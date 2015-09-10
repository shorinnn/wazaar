<?php

class ProductAffiliate extends User{

    use ProfileTrait;

    protected $table = 'users';
    protected $roleId = 4;
    public static $relationsData = array(
        'sales' => array(self::HAS_MANY, 'Purchase'),
        'courseReferrals' => array(self::HAS_MANY, 'CourseReferral'),
        'ltcAffiliate' => [ self::BELONGS_TO, 'LTCAffiliate', 'table' => 'users', 'foreignKey' => 'ltc_affiliate_id' ],
        'secondTierAffiliate' => [ self::BELONGS_TO, 'LTCAffiliate', 'table' => 'users', 'foreignKey' => 'second_tier_affiliate_id' ],
        'customPercentages' => array(self::HAS_MANY, 'CourseAffiliateCustomPercentage', 'foreignKey' => 'affiliate_id'),
    );
    
    public static function all( $columns = []){
        return self::whereHas(
                'roles', function($q){
                $q->where('name', 'Affiliate');
            }
        )->get();
    }
    
    public static function arrayWithProfile(){
        $affiliates = self::all();
        foreach($affiliates as $aff){
            $affiliates_arr[$aff->id] = ( trim( $aff->fullName() ) != '') ? $aff->fullName() : $aff->email;
        }
        return $affiliates_arr;
    }
    
     
    public function credit( $amount = 0, $product = null, $order = null, $purchase_id ){
        $amount = doubleval($amount);
        if( $amount <= 0 ) return false;
        if( !is_a($product, 'Lesson') && !is_a($product, 'Course') ) return false;
        if( !$product->id ) return false;
        return DB::transaction(function() use ($amount, $product, $order, $purchase_id){
            // create the transaction
              $transaction = new Transaction();
              $transaction->user_id = $this->id;
              $transaction->purchase_id = $purchase_id;
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
    
    public function creditReverse( $transaction ){
        if( $transaction->transaction_type!='affiliate_credit' || $transaction->user_id != $this->id || $transaction->status!='complete' ){
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
              $transaction->transaction_type = 'affiliate_credit_reverse';
              $transaction->details = trans('transactions.affiliate_credit_reverse_transaction').' '.$old->reference;

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
    
    
    public function debit( $amount = 0, $reference = null, $gc_fee = 0 ){
        $amount = doubleval( $amount );
        if( $amount > $this->affiliate_balance ) return false;
        if( $amount < Config::get('custom.cashout.threshold') ) return false;
        
        return DB::transaction(function() use ($amount, $reference){
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
                  // increase balance
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
                      
                      return $transaction->id;
                  }
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
    
    public function getProfileAttribute(){
        return Profile::where('owner_id', $this->id)->where('owner_type', 'Affiliate')->first();
    }

    public static function profileLists()
    {
        $profiles = Profile::where('owner_type', 'Affiliate')->get();

        if ($profiles){
            return  [];//array_merge([''], $profiles->lists('full_name','owner_id'));
        }

        return [];
    }

}