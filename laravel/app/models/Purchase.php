<?php

class Purchase extends CocoriumArdent{
    public static $rules = [
        'product_id' => 'required|unique_with:purchases,student_id,product_type,subscription_start',
        'product_type' => 'required|in:Lesson,Course',
        'student_id' => 'required|exists:users,id'
    ];
    
    public static $relationsData = array(
        'product' => array(self::MORPH_TO),
        'student' => array(self::BELONGS_TO, 'Student', 'table' => 'users', 'foreignKey' => 'student_id'),
        'ltcAffiliate' => array(self::BELONGS_TO, 'LTCAffiliate', 'table' => 'users', 'foreignKey' => 'ltc_affiliate_id'),
        'productAffiliate' => array(self::BELONGS_TO, 'ProductAffiliate', 'table' => 'course_purchases', 'foreignKey' => 'product_affiliate_id'),
        'gift' => array(self::BELONGS_TO, 'Gift'),
    );
    
    public function beforeSave(){
        if($this->product_type=='Course'){
            if( Course::find($this->product_id)==null ) return false;
        }
        else {
            if( Lesson::find($this->product_id)==null ) return false;
        }
    }
    public function refundable(){
        if( $this->purchase_price==0 ) return false;
        
        $now = new DateTime();
        $purchased  = new DateTime( $this->created_at );
        $dDiff = $now->diff($purchased);
        if( $dDiff->days > 30) return false;
        return true;
    }
    public function refund(){
        if( !$this->refundable() ) return false;
        
        $data =  $this->toArray();
        $data['purchase_id'] = $data['id'];
        unset( $data['id'] );
        unset( $data['created_at'] );
        unset( $data['updated_at'] );
        // create a new refund object
        $refund = new PurchaseRefund( $data );
        if($refund->save()){
            
            if(get_class($refund->product)=='Course') $course = $refund->product;
            else $course = $refund->product->module->course;
            
            // uncredit the instructor
            if( $refund->instructor_earnings > 0 ){
                $instructorTransaction = $refund->product->instructor->allTransactions()
                        ->where('transaction_type','instructor_credit')
                        ->where('purchase_id', $refund->purchase_id)->first();
                $course->instructor->creditReverse($instructorTransaction);
            }
            
            // uncredit the second tier instructor
            if( $refund->second_tier_instructor_earnings > 0 ){
                $secondTierInstructorTransaction = $refund->product->instructor->secondTierInstructor->allTransactions()
                        ->where('transaction_type','second_tier_instructor_credit')
                        ->where('purchase_id', $refund->purchase_id)->first();
                $course->instructor->secondTierInstructor->creditReverse($secondTierInstructorTransaction);
            }
            
            // uncredit the instructor agency
            if( $refund->instructor_agency_earnings > 0 ){
                $agency = $course->instructor->agency;
                $agencyTransaction = Transaction::where('purchase_id', $refund->purchase_id)->where('transaction_type', 'instructor_agency_credit')->first();
                $agency->creditReverse( $agencyTransaction );
            }
            
            
            // uncredit the affiliate
            if( $refund->affiliate_earnings > 0 ){
                $productAffiliate = ProductAffiliate::find( $refund->product_affiliate_id );
                $affiliateTransaction = Transaction::where('purchase_id', $refund->purchase_id)->where('user_id', $refund->product_affiliate_id)
                        ->where('transaction_type', 'affiliate_credit')
                        ->where('is_ltc','no')->where('is_second_tier','no')->first();
                $productAffiliate->creditReverse( $affiliateTransaction );
            }
           
            // uncredit the second tier affiliate
            if( $refund->second_tier_affiliate_earnings > 0 ){
                $secondTierAffiliate = LTCAffiliate::find( $refund->second_tier_affiliate_id );
                $affiliateTransaction = Transaction::where('purchase_id', $refund->purchase_id)->where('user_id', $refund->second_tier_affiliate_id)
                        ->where('transaction_type', 'affiliate_credit')
                        ->where('is_ltc','no')->where('is_second_tier','yes')->first();
                $secondTierAffiliate->creditReverse( $affiliateTransaction, 'st' );
            }
            
            // uncredit the ltc affiliate
            if( $refund->ltc_affiliate_earnings > 0 ){
                $ltcAffiliate = LTCAffiliate::find( $refund->ltc_affiliate_id );
                // is the LTC a Second Tier Publisher?
                $buyer = Student::find( $this->student_id );
                $ltcInstructor = $buyer->LTCInstructor();
                // second tier Publisher LTC
                if( $buyer->LTCInstructor() == $refund->ltc_affiliate_id){
                    $ltcSecondTierTransaction = Transaction::where('purchase_id', $refund->purchase_id)->where('user_id', $refund->ltc_affiliate_id)
                            ->where('transaction_type', 'second_tier_instructor_credit')
                            ->where('is_ltc','yes')->first();
                    $secondTierInstructor = SecondTierInstructor::find( $refund->ltc_affiliate_id );
                    $secondTierInstructor->creditReverse( $ltcSecondTierTransaction );
                }
                // regular LTC
                else{
                    $affiliateTransaction = Transaction::where('purchase_id', $refund->purchase_id)->where('user_id', $refund->ltc_affiliate_id)
                            ->where('transaction_type', 'affiliate_credit')
                            ->where('is_ltc','yes')->where('is_second_tier','no')->first();
                    $ltcAffiliate->creditReverse( $affiliateTransaction, 'ltc' );
                }
            }
            
            
            // uncredit the site
            if( $refund->site_earnings > 0 ){
                $wazaar = LTCAffiliate::find(2);
                $wazaarTransaction = Transaction::where('purchase_id', $refund->purchase_id)->where('transaction_type', 'site_credit')->first();
                $wazaar->creditReverse( $wazaarTransaction, 'wazaar' );
            }
            
            // restore the student balance used
            
            if($refund->balance_used > 0){
                $balanceTransaction = Transaction::find( $refund->balance_transaction_id );
                $refund->student->refundBalanceDebit( $balanceTransaction );
            }
            
            // delete the original purchase
            $this->delete();
            return $refund;
        }
        return false;
    }

}