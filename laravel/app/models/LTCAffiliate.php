<?php

class LTCAffiliate extends User{



    protected $table = 'users';


    public static $relationsData = array(
        'affiliated' => array(self::HAS_MANY, 'User', 'table' => 'users', 'foreignKey' => 'ltc_affiliate_id'),
        'sales' => array(self::HAS_MANY, 'Purchase', 'foreignKey' => 'ltc_affiliate_id'),
        'profile' => array(self::MORPH_ONE, 'Profile', 'name'=>'owner')
    );
    
    public function credit( $amount = 0, $product = null, $order = null, $ltcOrWazaar = '', $processor_fee = 0 ){
        $amount = doubleval($amount);
        if( $amount < 1 ) return false;
        if( !is_a($product, 'Lesson') && !is_a($product, 'Course') ) return false;
        if( !$product->id ) return false;
        return DB::transaction(function() use ($amount, $product, $order, $ltcOrWazaar, $processor_fee){
            // create the transaction
              $transaction = new Transaction();
              $transaction->user_id = $this->id;
              $transaction->amount = $amount;
              $transaction->product_id = $product->id;
              $transaction->product_type = get_class($product);
              $transaction->transaction_type = 'affiliate_credit';
              $transaction->reference = $order;
              if($this->id == 2) $transaction->transaction_type = 'site_credit';
              $transaction->details = trans('transactions.affiliate_credit_transaction').' '.$order;
              if( $ltcOrWazaar == 'ltc'){
                  $transaction->details = trans('transactions.ltc_affiliate_credit_transaction').' '.$order;
              }
              if( $ltcOrWazaar == 'wazaar'){
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
}