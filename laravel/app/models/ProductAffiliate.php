<?php

class ProductAffiliate extends User{

    use ProfileTrait;

    protected $table = 'users';
    protected $roleId = 4;
    public static $relationsData = array(
        'sales' => array(self::HAS_MANY, 'Purchase'),
        'courseReferrals' => array(self::HAS_MANY, 'CourseReferral')
    );
    
     
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
              $transaction->transaction_type = 'affiliate_credit';
              $transaction->details = trans('transactions.affiliate_credit_transaction').' '.$order;
              $transaction->status = 'complete';
              $transaction->reference = $order;
              if( $transaction->save() ){
                  // increase balance
                  $this->affiliate_balance += $amount;
                  if( $this->updateUniques() ) return $transaction->id;
                  else return false;
              }
              return false;
         });
    }
    
    public function debit( $amount = 0, $reference = null, $gc_fee = 0 ){
        $amount = doubleval( $amount );
        if( $amount > $this->affiliate_balance ) return false;
        return DB::transaction(function() use ($amount, $reference, $gc_fee){
            // create the transaction
              $transaction = new Transaction();
              $transaction->user_id = $this->id;
              $transaction->amount = $amount - $gc_fee;
              $transaction->transaction_type = 'affiliate_debit';
              $transaction->details = trans('transactions.affiliate_debit_transaction');
              $transaction->reference = $reference;
              $transaction->status = 'complete';
              $transaction->gc_fee = $gc_fee;
              if( $transaction->save() ){
                  // increase balance
                  $this->affiliate_balance -= $amount;
                  if( $this->updateUniques() ) return $transaction->id;
                  else return false;
              }
              return false;
         });
     }


    public static function courses($affiliateId)
    {
        if ($affiliateId){
            $sql = "SELECT DISTINCT courses.id, courses.name, courses.short_description
                    FROM purchases
                    JOIN courses ON purchases.product_id = courses.id
                    WHERE purchases.product_affiliate_id = {$affiliateId}
                    AND purchases.product_type = 'Course'
                   ";

            return DB::select($sql);
        }

        return null;
    }


}