<?php

class SecondTierInstructor extends User{



    protected $table = 'users';


    public static $relationsData = array(
        'instructors' => array(self::HAS_MANY, 'User', 'table' => 'users', 'foreignKey' => 'second_tier_instructor_id'),
        'allTransactions' => [ self::HAS_MANY, 'Transaction', 'foreignKey'=>'user_id' ],
    );
    
    public function getTransactionsAttribute(){
        $types = [
            'second_tier_instructor_credit',
            'second_tier_instructor_credit_reverse',
            'second_tier_instructor_debit',
            'second_tier_instructor_debit_refund',
            'cashout_fee'
        ];
        return $this->allTransactions()->whereIn('transaction_type', $types);
    }
    
    
    public function credit( $amount = 0, $product = null, $order = null, $purchase_id = 0 ){
        $amount = doubleval($amount);
        if( $amount <= 0 ) return false;
        if( !is_a($product, 'Lesson') && !is_a($product, 'Course') ) return false;
        if( !$product->id ) return false;
        return DB::transaction(function() use ($amount, $product, $order, $purchase_id){
            // create the transaction
              $transaction = new Transaction();
              $transaction->user_id = $this->id;
              $transaction->amount = $amount;
              $transaction->product_id = $product->id;
              $transaction->product_type = get_class($product);
              $transaction->transaction_type = 'second_tier_instructor_credit';
              $transaction->details = trans('transactions.second_tier_instructor_credit_transaction').' '.$order;

              $transaction->purchase_id = $purchase_id;
              $transaction->reference = $order;
              $transaction->status = 'complete';
              if( $transaction->save() ){
                  // increase balance
                  $this->instructor_balance += $amount;
                  if( $this->updateUniques() ) return $transaction->id;
                  else return false;
              }
              return false;
         });
    }
    
    public function creditReverse( $transaction ){
        if( $transaction->transaction_type!='second_tier_instructor_credit' || $transaction->user_id != $this->id || $transaction->status!='complete' ){
            return false;
        }
        $old = $transaction;
        return DB::transaction(function() use ($old){
            // create the transaction
              $transaction = new Transaction();
              $transaction->user_id = $this->id;
              $transaction->amount = $old->amount;
              $transaction->purchase_id = $old->purchase_id;
              $transaction->product_id = $old->product_id;
              $transaction->product_type = $old->product_type;
              $transaction->transaction_type = 'second_tier_instructor_credit_reverse';
              $transaction->details = trans('second_tier_transactions.instructor_credit_reverse_transaction').' '.$old->reference;

//              $transaction->reference = $order;
              $transaction->status = 'complete';
              if( $transaction->save() ){
                  // increase balance
                  $this->instructor_balance -= $old->amount;
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
        
        if( $amount > $this->instructor_balance ) return false;
        if( $amount < Config::get('custom.cashout.threshold') ) return false;
        
        return DB::transaction(function() use ($amount, $reference, $transactions_to_mark ){
              $fee = Config::get('custom.cashout.fee');
              $cashout = $amount - $fee;
              
              // create the transaction
              $transaction = new Transaction();
              $transaction->user_id = $this->id;
              $transaction->amount = $cashout;
              $transaction->transaction_type = 'second_tier_instructor_debit';
              $transaction->details = trans('transactions.second_tier_instructor_debit_transaction');
              $transaction->reference = $reference;
              $transaction->status = 'pending';
              $transaction->gc_fee = 0;
              if( $transaction->save() ){
                  // increase balance
                  $this->instructor_balance -= $amount;
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