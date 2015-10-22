<?php

class LTCAffiliate extends User{



    protected $table = 'users';


    public static $relationsData = array(
        'affiliated' => array(self::HAS_MANY, 'User', 'table' => 'users', 'foreignKey' => 'ltc_affiliate_id'),
        'sales' => array(self::HAS_MANY, 'Purchase', 'foreignKey' => 'ltc_affiliate_id'),
        'profile' => array(self::MORPH_ONE, 'Profile', 'name'=>'owner'),
        'allTransactions' => [ self::HAS_MANY, 'Transaction', 'foreignKey'=>'user_id' ],
    );
    
    public function getProfileAttribute(){
        return Profile::where('owner_id', $this->id)->where('owner_type', 'Affiliate')->first();
    }
    
    public function getTransactionsAttribute(){
        $types = [
            'affiliate_credit',
            'affiliate_credit_reverse',
            'affiliate_debit',
            'affiliate_debit_refund',
            'cashout_fee'
        ];
        return $this->allTransactions()->whereIn('transaction_type', $types);
    }
    
    
    public function credit( $amount = 0, $product = null, $order = null, $ltcOrWazaarOrST = '', $processor_fee = 0, $purchase_id = 0 ){
        $amount = doubleval($amount);
        if( $amount <= 0 ) return false;
        if( !is_a($product, 'Lesson') && !is_a($product, 'Course') ) return false;
        if( !$product->id ) return false;
        return DB::transaction(function() use ($amount, $product, $order, $ltcOrWazaarOrST, $processor_fee, $purchase_id){
            // create the transaction
              $transaction = new Transaction();
              $transaction->user_id = $this->id;
              $transaction->amount = $amount;
              $transaction->product_id = $product->id;
              $transaction->product_type = get_class($product);
              $transaction->transaction_type = 'affiliate_credit';
              $transaction->purchase_id = $purchase_id;
              $transaction->reference = $order;
//              if($this->id == 2) $transaction->transaction_type = 'site_credit';
              $transaction->details = trans('transactions.affiliate_credit_transaction').' '.$order;
              if( $ltcOrWazaarOrST == 'ltc'){
                  $transaction->is_ltc = 'yes';
                  $transaction->details = trans('transactions.ltc_affiliate_credit_transaction').' '.$order;
              }
              if( $ltcOrWazaarOrST == 'st'){
                  $transaction->is_second_tier = 'yes';
                  $transaction->details = trans('transactions.second_tier_affiliate_credit_transaction').' '.$order;
              }
              if( $ltcOrWazaarOrST == 'wazaar'){
                  $transaction->transaction_type = 'site_credit';
                  $transaction->details = trans('transactions.site_earnings').' '.$order;
                  $transaction->gc_fee = $processor_fee;
              }
              $transaction->status = 'complete';
              if( $transaction->save() ){
                  // increase balance
                  $this->affiliate_balance += $amount;
                  if( $this->updateUniques() ) return $transaction->id;
                  else return false;
              }
              return false;
         });
    }
    
    public function creditReverse( $transaction,  $ltcOrWazaarOrST=''){
        if( 
                ( $ltcOrWazaarOrST=='ltc' && $transaction->is_ltc != 'yes' )
                || ( $ltcOrWazaarOrST=='st' && $transaction->is_second_tier != 'yes' )
                || ( $ltcOrWazaarOrST=='wazaar' && ( $transaction->is_ltc=='yes' || $transaction->is_second_tier == 'yes' ) )
                || $transaction->user_id != $this->id 
                || $transaction->status!='complete' ){
            return false;
        }
        $old = $transaction;
        return DB::transaction(function() use ($old, $ltcOrWazaarOrST){
            // create the transaction
              $transaction = new Transaction();
              $transaction->user_id = $this->id;
              $transaction->amount = $old->amount;
              $transaction->gc_fee = $old->gc_fee;
              $transaction->is_ltc = $old->is_ltc;
              $transaction->is_second_tier = $old->is_second_tier;
              $transaction->purchase_id = $old->purchase_id;
              $transaction->product_id = $old->product_id;
              $transaction->product_type = $old->product_type;
              $transaction->transaction_type = 'affiliate_credit_reverse';
              $transaction->details = trans('transactions.instructor_credit_reverse_transaction').' '.$old->reference;
              if($ltcOrWazaarOrST=='wazaar'){
                  $transaction->transaction_type = 'site_credit_reverse';
                  $transaction->details = trans('transactions.site_credit_reverse_transaction').' '.$old->reference;
              }

//              $transaction->reference = $order;
              $transaction->status = 'complete';
              if( $transaction->save() ){
                  // increase balance
                  $this->affiliate_balance -= $old->amount;
                  if( $this->updateUniques() ){
                      $old->status = 'failed';
                      $old->details .= ' | '.trans('transactions.refunded').' #'.$transaction->id;
                      if( $old->updateUniques() ){
                          return $transaction->id;
                      }
                  }
                  else return false;
              }
              return false;
         });
    }
    
    
    public function debit( $amount = 0, $reference = null, $transactions_to_mark = null ){
        $amount = doubleval( $amount );
        if( $amount > $this->affiliate_balance ){
            $this->debit_error = "Amount ($amount) greater than balance ($this->affiliate_balance)";
            $this->balance_error = true;
            return false;
        }
        
        $threshold = Config::get('custom.cashout.threshold');
        if( $this->profile !=null && $this->profile->payment_threshold > $threshold ){
            $threshold = $this->profile->payment_threshold;
        }
        
        if( $amount < $threshold ){
            $this->debit_error = "Amount ($amount) less than threshold (". $threshold .")";
            return false;
        }
        
        return DB::transaction(function() use ($amount, $reference, $transactions_to_mark){
              $cashoutFee = Setting::where( [ 'name' => 'cashout-bank-fee' ] )->first();
              if($cashoutFee==null || $cashoutFee->value==='')
                $fee = Config::get('custom.cashout.fee');
              else
                $fee = $cashoutFee->value;
              
              $cashout = $amount - $fee;
              
            // create the transaction
              $transaction = new Transaction();
              $transaction->user_id = $this->id;
              $transaction->amount = $cashout;
              $transaction->transaction_type = 'affiliate_debit';
              $transaction->details = trans('transactions.affiliate_debit_transaction');
              $transaction->reference = $reference;
              $transaction->status = 'pending';
              $transaction->gc_fee = 0;
              if( $transaction->save() ){
                  // decrease balance
                  $this->affiliate_balance -= $amount;
                  if( $this->updateUniques() ){
                      // store the fee
                        $fee_transaction = new Transaction();
                        $fee_transaction->user_id = $this->id;
                        $fee_transaction->amount = $fee;
                        $fee_transaction->transaction_type = 'cashout_fee';
                        $fee_transaction->details = trans('transactions.cashout_fee'). ' #'.$transaction->id;
                        $fee_transaction->reference = 'withdraw-'.$transaction->id;
                        $fee_transaction->status = 'pending';
                        $fee_transaction->gc_fee = 0;
                        if( !$fee_transaction->save() ){
                            $this->debit_error = 'Cannot save fee transaction - '.implode(',', $fee_transaction->errors()->all() );
                            return false;
                        }
                        
                      // mark transactions as complete
                       $debits = [];
                       foreach($transactions_to_mark as $t){
                           $t->cashed_out_on = date('Y-m-d H:i:s');
                           if( !$t->updateUniques() ){
                               $this->debit_error = 'Cannot mark transactions as cashed out - '.implode(',', $t->errors()->all() );
                               return false;
                           }
                           $debits[] = $t->id;
                       }
                       $transaction->debits = json_encode($debits);
                       $transaction->updateUniques();
                      return $transaction->id;
                  }
                  else{
                      $this->debit_error = 'Cannot update balance - '.implode(',', $this->errors()->all() );
                      return false;
                  }
              }
              $this->debit_error = 'Cannot save debit transaction - '.implode(',', $transaction->errors()->all() );
              return false;
         });
     }
}