<?php
use LaravelBook\Ardent\Ardent;

class InstructorAgency extends Ardent {
    
        protected $table = 'users';
        
        public static $relationsData = [
            'instructors' => [self::HAS_MANY, 'Instructor', 'table' => 'users' ]
        ];
        
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
              $transaction->details = trans('transactions.agency_credit_transaction').' '.$order;

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
    
    public function debit( $amount = 0, $reference = null, $gc_fee = 0 ){
        $amount = doubleval( $amount );
        if( $amount > $this->instructor_balance ) return false;
        return DB::transaction(function() use ($amount, $reference, $gc_fee){
            // create the transaction
              $transaction = new Transaction();
              $transaction->user_id = $this->id;
              $transaction->amount = $amount - $gc_fee;
              $transaction->transaction_type = 'instructor_debit';
              $transaction->details = trans('transactions.instructor_debit_transaction');
              $transaction->reference = $reference;
              $transaction->status = 'complete';
              $transaction->gc_fee = $gc_fee;
              if( $transaction->save() ){
                  // increase balance
                  $this->agency_balance -= $amount;
                  if( $this->updateUniques() ) return $transaction->id;
                  else return false;
              }
              return false;
         });
     }
}