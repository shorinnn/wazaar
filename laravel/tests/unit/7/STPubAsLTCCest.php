<?php
use \UnitTester;

class STPubAsLTCCest{
    
    public function _before() {
        $this->setupDatabase();
    }
    public function __destruct()
    {
        \DB::disconnect();
    }

    private function setupDatabase() {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        
        Student::boot();
        User::boot();
        ProductAffiliate::boot();
        LTCAffiliate::boot();
        Purchase::boot();
        DB::table('courses')->where('id', 1)->update(['instructor_id' => 11] );
        $course = Course::where('instructor_id', 11)->first();
        $course->sale = 0;
        $course->sale_ends_on = $course->sale_starts_on = '';
        $course->updateUniques();
    }
    
    /**
     * Instructor is Buyer and his ST Pub gets LTC commision
     */
    public function basicPurchase(UnitTester $I){
        $student = Student::where('username','instructor')->first();
        $student->second_tier_instructor_id = 2;
        $student->ltc_affiliate_id = null;
        $student->created_at = '2015-08-10 10:00:00';
        $student->updateUniques();
        
        $secondTierPub = User::find(2);
        $secondTierPub->is_second_tier_instructor = 'yes';
        $secondTierPub->updateUniques();
        DB::table('purchases')->delete();
        
        $course = Course::where('instructor_id', 11)->first();
        $course->price = 1050;
        $course->affiliate_percentage = 0;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course = Course::where('instructor_id', 11)->first();
        
        $I->assertEquals(105, $course->price);
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '0';
        $data['successData']['balance_transaction_id'] = '0';
        
        $I->assertLessThan( 1, $student->ltc_affiliate_id );
        $I->assertLessThan( 1, $course->instructor->second_tier_instructor_id );
        $I->assertEquals( 2, $student->second_tier_instructor_id );
        $I->assertNotEquals( false, $student->purchase($course, null, $data) );
        
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertLessThan( 1, $purchase->product_affiliate_id);
        $I->assertEquals( 2, $purchase->ltc_affiliate_id);
        $I->assertLessThan( 1, $purchase->second_tier_affiliate_id);
        $I->assertLessThan( 1, $purchase->second_tier_instructor_id);
        
                
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->instructor_earnings, 70 );     
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 30 * 0.08 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 0 );
        // no second tier aff, wazaar cut goes up to 30%
        $I->assertEquals( $purchase->site_earnings, 30 - 30 * 0.08);
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 70,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $student->LTCInstructor(), 'transaction_type' => 'second_tier_instructor_credit', 
            'amount' => $purchase->ltc_affiliate_earnings, 'product_id' => $course->id, 'status' => 'complete', 'is_ltc' => 'yes'] );
    }  
    
    /**TODO HERE
     * Instructor is Buyer and his ST Pub gets NO LTC commision because Instructor registered after 2015-08-12 23:59:59
     */
    public function noLTCBecausePastDate(UnitTester $I){
        $student = Student::where('username','instructor')->first();
        $student->second_tier_instructor_id = 2;
        $student->ltc_affiliate_id = null;
        $student->created_at = '2015-08-13 10:00:00';
        $student->updateUniques();
        
        $secondTierPub = User::find(2);
        $secondTierPub->is_second_tier_instructor = 'yes';
        $secondTierPub->sti_approved = 'yes';
        $secondTierPub->updateUniques();
        DB::table('purchases')->delete();
        
        $course = Course::where('instructor_id', 11)->first();
        $course->price = 1050;
        $course->affiliate_percentage = 0;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course = Course::where('instructor_id', 11)->first();
        
        $I->assertEquals(105, $course->price);
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '0';
        $data['successData']['balance_transaction_id'] = '0';
        
        $I->assertLessThan( 1, $student->ltc_affiliate_id );
        $I->assertLessThan( 1, $course->instructor->second_tier_instructor_id );
        $I->assertEquals( 2, $student->second_tier_instructor_id );
        $I->assertNotEquals( false, $student->purchase($course, null, $data) );
        
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertLessThan( 1, $purchase->product_affiliate_id);
        $I->assertLessThan( 1, $purchase->ltc_affiliate_id);
        $I->assertLessThan( 1, $purchase->second_tier_affiliate_id);
        $I->assertLessThan( 1, $purchase->second_tier_instructor_id);
        
                
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->instructor_earnings, 70 );     
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings,0 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 0 );
        // no second tier aff, wazaar cut goes up to 30%
        $I->assertEquals( $purchase->site_earnings, 30 );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 70,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->dontSeeRecord('transactions', ['user_id' => $student->LTCInstructor(), 'transaction_type' => 'second_tier_instructor_credit',
            'product_id' => $course->id, 'status' => 'complete', 'is_ltc' => 'yes'] );
    }   
    
    /**
     * Instructor is Buyer and his ST Pub gets LTC commision, but then refund!
     */
    public function basicPurchaseAndRefund(UnitTester $I){
        $student = Student::where('username','instructor')->first();
        $student->second_tier_instructor_id = 2;
        $student->ltc_affiliate_id = null;
        $student->created_at = '2015-08-10 10:00:00';
        $student->student_balance = 10;
        $student->updateUniques();
        
        $secondTierPub = User::find(2);
        $secondTierPub->is_second_tier_instructor = 'yes';
        $secondTierPub->instructor_balance = 0;
        $secondTierPub->updateUniques();
        DB::table('purchases')->delete();
        
        $course = Course::where('instructor_id', 11)->first();
        $course->price = 1050;
        $course->affiliate_percentage = 0;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course = Course::where('instructor_id', 11)->first();
        
        $I->assertEquals(105, $course->price);
        
        
        $balance = $student->balanceDebit( 10, $course );
        
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = $balance;
        
        $I->assertLessThan( 1, $student->ltc_affiliate_id );
        $I->assertLessThan( 1, $course->instructor->second_tier_instructor_id );
        $I->assertEquals( 2, $student->second_tier_instructor_id );
        $I->assertNotEquals( false, $student->purchase($course, null, $data) );
        
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertLessThan( 1, $purchase->product_affiliate_id);
        $I->assertEquals( 2, $purchase->ltc_affiliate_id);
        $I->assertLessThan( 1, $purchase->second_tier_affiliate_id);
        $I->assertLessThan( 1, $purchase->second_tier_instructor_id);
        
                
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->instructor_earnings, 70 );     
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 30 * 0.08 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 0 );
        // no second tier aff, wazaar cut goes up to 30%
        $I->assertEquals( $purchase->site_earnings, 30 - 30 * 0.08);
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 70,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $student->LTCInstructor(), 'transaction_type' => 'second_tier_instructor_credit', 
            'amount' => $purchase->ltc_affiliate_earnings, 'product_id' => $course->id, 'status' => 'complete', 'is_ltc' => 'yes'] );
        
        $student = Student::where('username','instructor')->first();
        $I->assertEquals(0, $student->student_balance);
        $secondTierPub = User::find(2);
        $I->assertEquals( 30 * 0.08, $secondTierPub->instructor_balance );
        $instructor = User::find(11);
        $I->assertEquals( 70, $instructor->instructor_balance );
        
        $I->assertNotEquals(false, $purchase->refund() );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 70,
            'product_id' => $course->id, 'status' => 'failed'] );
        $I->seeRecord('transactions', ['user_id' => $student->LTCInstructor(), 'transaction_type' => 'second_tier_instructor_credit', 
            'amount' => $purchase->ltc_affiliate_earnings, 'product_id' => $course->id, 'status' => 'failed', 'is_ltc' => 'yes'] );
        
        $I->dontSeeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 70,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->dontSeeRecord('transactions', ['user_id' => $student->LTCInstructor(), 'transaction_type' => 'second_tier_instructor_credit', 
            'amount' => $purchase->ltc_affiliate_earnings, 'product_id' => $course->id, 'status' => 'complete', 'is_ltc' => 'yes'] );
        
        $I->dontSeeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit_reversed', 'amount' => 70,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->dontSeeRecord('transactions', ['user_id' => $student->LTCInstructor(), 'transaction_type' => 'second_tier_instructor_credit_reversed', 
            'amount' => $purchase->ltc_affiliate_earnings, 'product_id' => $course->id, 'status' => 'complete', 'is_ltc' => 'yes'] );
        
        $student = Student::where('username','instructor')->first();
        $I->assertEquals(10, $student->student_balance);
        $secondTierPub = User::find(2);
        $I->assertEquals( 0, $secondTierPub->instructor_balance );
        $instructor = User::find(11);
        $I->assertEquals( 0, $instructor->instructor_balance );
    }  
    
    
}