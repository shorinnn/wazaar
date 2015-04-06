<?php

class LTCAffiliate extends User{



    protected $table = 'users';


    public static $relationsData = array(
        'affiliated' => array(self::HAS_MANY, 'User', 'table' => 'users', 'foreignKey' => 'ltc_affiliate_id'),
        'sales' => array(self::HAS_MANY, 'Purchase', 'foreignKey' => 'ltc_affiliate_id'),
        'profile' => array(self::MORPH_ONE, 'Profile', 'name'=>'owner'),
        'allTransactions' => [ self::HAS_MANY, 'Transaction', 'foreignKey'=>'user_id' ],
    );
    
    public function getTransactionsAttribute(){
        $types = [
            'affiliate_credit',
            'affiliate_debit',
            'affiliate_debit_refund',
            'cashout_fee'
        ];
        return $this->allTransactions()->whereIn('transaction_type', $types);
    }
    
    
    public function credit( $amount = 0, $product = null, $order = null, $ltcOrWazaarOrST = '', $processor_fee = 0 ){
        $amount = doubleval($amount);
        if( $amount <= 0 ) return false;
        if( !is_a($product, 'Lesson') && !is_a($product, 'Course') ) return false;
        if( !$product->id ) return false;
        return DB::transaction(function() use ($amount, $product, $order, $ltcOrWazaarOrST, $processor_fee){
            // create the transaction
              $transaction = new Transaction();
              $transaction->user_id = $this->id;
              $transaction->amount = $amount;
              $transaction->product_id = $product->id;
              $transaction->product_type = get_class($product);
              $transaction->transaction_type = 'affiliate_credit';
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
    
    public function debit( $amount = 0, $reference = null, $transactions_to_mark = null ){
        $amount = doubleval( $amount );
        if( $amount > $this->affiliate_balance ) return false;
        if( $amount < Config::get('custom.cashout.threshold') ) return false;
        
        return DB::transaction(function() use ($amount, $reference, $transactions_to_mark){
              $fee = Config::get('custom.cashout.fee');
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
                            return false;
                        }
                        
                      // mark transactions as complete
                       $debits = [];
                       foreach($transactions_to_mark as $t){
                           $t->cashed_out_on = date('Y-m-d H:i:s');
                           if( !$t->updateUniques() ) return false;
                           $debits[] = $t->id;
                       }
                       $transaction->debits = json_encode($debits);
                       $transaction->updateUniques();
                      return $transaction->id;
                  }
                  else return false;
              }
              return false;
         });
     }
}