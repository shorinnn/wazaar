<?php
use LaravelBook\Ardent\Ardent;

class InstructorAgency extends User {
    
        protected $table = 'users';
        
        public static $relationsData = [
            'instructors' => [self::HAS_MANY, 'Instructor', 'table' => 'users' ],
            'allTransactions' => [ self::HAS_MANY, 'Transaction', 'foreignKey'=>'user_id' ],
        ];
        
    public function getTransactionsAttribute(){
        $types = [
            'instructor_agency_credit',
            'instructor_agency_debit',
            'instructor_agency_debit_refund',
            'cashout_fee'
        ];
        return $this->allTransactions()->whereIn('transaction_type', $types);
    }
        
        public function credit( $amount = 0, $product = null, $order = null ){
        $amount = doubleval($amount);
        if( $amount <= 0 ) return false;
        if( !is_a($product, 'Lesson') && !is_a($product, 'Course') ) return false;
        if( !$product->id ) return false;
        return DB::transaction(function() use ($amount, $product, $order){
            // create the transaction
              $transaction = new Transaction();
              $transaction->user_id = $this->id;
              $transaction->amount = $amount;
              $transaction->product_id = $product->id;
              $transaction->product_type = get_class($product);
              $transaction->transaction_type = 'instructor_agency_credit';
              $transaction->details = trans('transactions.instructor_agency_credit_transaction').' '.$order;

              $transaction->reference = $order;
              $transaction->status = 'complete';
              if( $transaction->save() ){
                  // increase balance
                  $this->agency_balance += $amount;
                  if( $this->updateUniques() ) return $transaction->id;
                  else return false;
              }
              return false;
         });
    }
    
    public function debit( $amount = 0, $reference = null ){
        $amount = doubleval( $amount );
        if( $amount > $this->agency_balance ) return false;
        if( $amount < Config::get('custom.cashout.threshold') ) return false;
        
        return DB::transaction(function() use ($amount, $reference){
              $fee = Config::get('custom.cashout.fee');
              $cashout = $amount - $fee;
              
            // create the transaction
              $transaction = new Transaction();
              $transaction->user_id = $this->id;
              $transaction->amount = $cashout;
              $transaction->transaction_type = 'instructor_agency_debit';
              $transaction->details = trans('transactions.instructor_agency_debit_transaction');
              $transaction->reference = $reference;
              $transaction->status = 'pending';
              $transaction->gc_fee = 0;
              if( $transaction->save() ){
                  // increase balance
                  $this->agency_balance -= $amount;
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
                        
                      return $transaction->id;
                  }
                  else return false;
              }
              return false;
         });
     }
}