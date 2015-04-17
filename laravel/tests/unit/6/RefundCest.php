<?php
use \UnitTester;

class RefundCest{
    
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
        Config::set('custom.earnings.instructor_percentage', 70);
        Config::set('custom.earnings.site_percentage', 30);
        Config::set('custom.earnings.ltc_percentage', 5);
        Config::set('custom.earnings.agency_percentage', 2);
        Config::set('custom.earnings.second_tier_percentage', 2);
        
        DB::table('purchases')->truncate();
        DB::table('purchase_refunds')->truncate();
        DB::table('transactions')->truncate();
    }
    
    public function purchaseThenRefundWithBalance(UnitTester $I){
        
        $student = Student::where('username','sorin')->first();
        $student->student_balance = 10;
        $student->updateUniques();
        $I->assertEquals(10, $student->student_balance);
                
        $course = Course::first();
        $course->price = 105;
        $course->affiliate_percentage = 10;
        $course->updateUniques();
        
        $course->instructor->instructor_agency_id = null;
        $course->instructor->updateUniques();
            
        $balance = $student->balanceDebit( 10, $course );
        $I->assertNotEquals( false, $balance );
        
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = $balance;
        
        $course->instructor->instructor_balance = 0;
        $course->instructor->updateUniques();
        $affiliate = ProductAffiliate::find(5);
        $affiliate->affiliate_balance = 0;
        $affiliate->updateUniques();
        $ltc = ProductAffiliate::find(2);
        $ltc->affiliate_balance = 0;
        $ltc->updateUniques();
        
        
        $I->assertEquals(0, $course->instructor->instructor_balance);
        $I->assertEquals(0, $affiliate->affiliate_balance);
        $I->assertEquals(0, $ltc->affiliate_balance);
        
        $I->assertNotEquals( false, $student->purchase($course, 5, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        
        $I->assertNotEquals(0, $affiliate->ltc_affiliate_id);
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, $balance );
        $I->assertEquals( $purchase->instructor_earnings, 58 );
        $I->assertEquals( $purchase->affiliate_earnings, 10 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 30 * (5 / 100) );
        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 30 * (5 / 100) ) - 5 );
        
        $st = ($purchase->purchase_price - $purchase->processor_fee) *  ( Config::get('custom.earnings.second_tier_percentage') / 100 );        
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, $st );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 58,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $affiliate->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => 2,
            'product_id' => $course->id, 'status' => 'complete', 'is_second_tier' => 'yes', 'is_ltc' => 'no'] );
        $I->seeRecord('transactions', ['user_id' => 5, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'is_ltc' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
        
        $student = Student::where('username','sorin')->first();
        $I->assertEquals( 0, $student->student_balance);
        
        $affiliate = ProductAffiliate::find(5);
        $ltc = ProductAffiliate::find(2);
        $I->assertEquals(0, $student->student_balance);
        $I->assertEquals($purchase->instructor_earnings, $course->instructor->instructor_balance);
        $I->assertEquals($purchase->affiliate_earnings, $affiliate->affiliate_balance);
        $I->assertEquals($purchase->ltc_affiliate_earnings + $purchase->second_tier_affiliate_earnings 
                + $purchase->site_earnings, $ltc->affiliate_balance);
        
        // refund the purchase
        $purchase = Purchase::first();
        $I->assertTrue( $purchase->refund() );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 58,
            'product_id' => $course->id, 'status' => 'failed'] );
        $I->seeRecord('transactions', ['user_id' => $affiliate->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => 2,
            'product_id' => $course->id, 'status' => 'failed', 'is_second_tier' => 'yes', 'is_ltc' => 'no'] );
        $I->seeRecord('transactions', ['user_id' => 5, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->affiliate_earnings,
            'product_id' => $course->id, 'status' => 'failed'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'failed', 'is_ltc' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'failed', 'gc_fee' => 5] );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit_reverse', 'amount' => 58,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $affiliate->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit_reverse', 'amount' => 2,
            'product_id' => $course->id, 'status' => 'complete', 'is_second_tier' => 'yes', 'is_ltc' => 'no'] );
        $I->seeRecord('transactions', ['user_id' => 5, 'transaction_type' => 'affiliate_credit_reverse', 'amount' => $purchase->affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'affiliate_credit_reverse', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'is_ltc' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit_reverse', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
        
        $I->dontSeeRecord( 'purchases',[ 'id' => 1 ] );
        $I->seeRecord( 'purchase_refunds',[ 'purchase_id' => 1 ] );
        
        $student = Student::where('username','sorin')->first();
        $affiliate = ProductAffiliate::find(5);
        $ltc = ProductAffiliate::find(2);
        $instructor = Instructor::find($course->instructor_id);
        $I->assertEquals( 10, $student->student_balance);
        $I->assertEquals( 0, $instructor->instructor_balance);
        $I->assertEquals( 0, $affiliate->affiliate_balance);
        $I->assertEquals( 0, $ltc->affiliate_balance);
    }
    
    public function purchaseThenRefundNoBalance(UnitTester $I){
        
        $student = Student::where('username','sorin')->first();
        $student->student_balance = 0;
        $student->updateUniques();
        $I->assertEquals(0, $student->student_balance);
                
        $course = Course::first();
        $course->price = 105;
        $course->affiliate_percentage = 10;
        $course->updateUniques();
        
        $course->instructor->instructor_agency_id = null;
        $course->instructor->updateUniques();
            
        
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '0';
        $data['successData']['balance_transaction_id'] = 0;
        
        $course->instructor->instructor_balance = 0;
        $course->instructor->updateUniques();
        $affiliate = ProductAffiliate::find(5);
        $affiliate->affiliate_balance = 0;
        $affiliate->updateUniques();
        $ltc = ProductAffiliate::find(2);
        $ltc->affiliate_balance = 0;
        $ltc->updateUniques();
        
        
        $I->assertEquals(0, $course->instructor->instructor_balance);
        $I->assertEquals(0, $affiliate->affiliate_balance);
        $I->assertEquals(0, $ltc->affiliate_balance);
        
        $I->assertNotEquals( false, $student->purchase($course, 5, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        
        $I->assertNotEquals(0, $affiliate->ltc_affiliate_id);
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->balance_used, 0 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 58 );
        $I->assertEquals( $purchase->affiliate_earnings, 10 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 30 * (5 / 100) );
        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 30 * (5 / 100) ) - 5 );
        
        $st = ($purchase->purchase_price - $purchase->processor_fee) *  ( Config::get('custom.earnings.second_tier_percentage') / 100 );        
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, $st );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 58,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $affiliate->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => 2,
            'product_id' => $course->id, 'status' => 'complete', 'is_second_tier' => 'yes', 'is_ltc' => 'no'] );
        $I->seeRecord('transactions', ['user_id' => 5, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'is_ltc' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
        
        $student = Student::where('username','sorin')->first();
        $I->assertEquals( 0, $student->student_balance);
        
        $affiliate = ProductAffiliate::find(5);
        $ltc = ProductAffiliate::find(2);
        $I->assertEquals(0, $student->student_balance);
        $I->assertEquals($purchase->instructor_earnings, $course->instructor->instructor_balance);
        $I->assertEquals($purchase->affiliate_earnings, $affiliate->affiliate_balance);
        $I->assertEquals($purchase->ltc_affiliate_earnings + $purchase->second_tier_affiliate_earnings 
                + $purchase->site_earnings, $ltc->affiliate_balance);
        
        // refund the purchase
        $purchase = Purchase::first();
        $I->assertTrue( $purchase->refund() );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 58,
            'product_id' => $course->id, 'status' => 'failed'] );
        $I->seeRecord('transactions', ['user_id' => $affiliate->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => 2,
            'product_id' => $course->id, 'status' => 'failed', 'is_second_tier' => 'yes', 'is_ltc' => 'no'] );
        $I->seeRecord('transactions', ['user_id' => 5, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->affiliate_earnings,
            'product_id' => $course->id, 'status' => 'failed'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'failed', 'is_ltc' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'failed', 'gc_fee' => 5] );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit_reverse', 'amount' => 58,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $affiliate->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit_reverse', 'amount' => 2,
            'product_id' => $course->id, 'status' => 'complete', 'is_second_tier' => 'yes', 'is_ltc' => 'no'] );
        $I->seeRecord('transactions', ['user_id' => 5, 'transaction_type' => 'affiliate_credit_reverse', 'amount' => $purchase->affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'affiliate_credit_reverse', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'is_ltc' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit_reverse', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
        
        $I->dontSeeRecord( 'purchases',[ 'id' => 1 ] );
        $I->seeRecord( 'purchase_refunds',[ 'purchase_id' => 1 ] );
        
        $student = Student::where('username','sorin')->first();
        $affiliate = ProductAffiliate::find(5);
        $ltc = ProductAffiliate::find(2);
        $instructor = Instructor::find($course->instructor_id);
        $I->assertEquals( 0, $student->student_balance);
        $I->assertEquals( 0, $instructor->instructor_balance);
        $I->assertEquals( 0, $affiliate->affiliate_balance);
        $I->assertEquals( 0, $ltc->affiliate_balance);
    }
    
    public function purchaseThenRefundNoAffiliate(UnitTester $I){
        
        $student = Student::where('username','sorin')->first();
        $student->student_balance = 0;
        $student->updateUniques();
        $I->assertEquals(0, $student->student_balance);
                
        $course = Course::first();
        $course->price = 105;
        $course->affiliate_percentage = 0;
        $course->updateUniques();
        
        $course->instructor->instructor_agency_id = null;
        $course->instructor->updateUniques();
            
        
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '0';
        $data['successData']['balance_transaction_id'] = 0;
        
        $course->instructor->instructor_balance = 0;
        $course->instructor->updateUniques();
        $affiliate = ProductAffiliate::find(5);
        $affiliate->affiliate_balance = 0;
        $affiliate->updateUniques();
        $ltc = ProductAffiliate::find(2);
        $ltc->affiliate_balance = 0;
        $ltc->updateUniques();
        
        
        $I->assertEquals(0, $course->instructor->instructor_balance);
        $I->assertEquals(0, $affiliate->affiliate_balance);
        $I->assertEquals(0, $ltc->affiliate_balance);
        
        $I->assertNotEquals( false, $student->purchase($course, 5, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        
        $I->assertNotEquals(0, $affiliate->ltc_affiliate_id);
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->balance_used, 0 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 70 );
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 30 * (5 / 100) );
        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 30 * (5 / 100) ) - 5 );
        
        $st = 0;     
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, $st );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 70,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'is_ltc' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
        
        $student = Student::where('username','sorin')->first();
        $I->assertEquals( 0, $student->student_balance);
        
        $affiliate = ProductAffiliate::find(5);
        $ltc = ProductAffiliate::find(2);
        $I->assertEquals(0, $student->student_balance);
        $I->assertEquals($purchase->instructor_earnings, $course->instructor->instructor_balance);
        $I->assertEquals($purchase->affiliate_earnings, $affiliate->affiliate_balance);
        $I->assertEquals($purchase->ltc_affiliate_earnings + $purchase->second_tier_affiliate_earnings 
                + $purchase->site_earnings, $ltc->affiliate_balance);
        
        // refund the purchase
        $purchase = Purchase::first();
        $I->assertTrue( $purchase->refund() );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 70,
            'product_id' => $course->id, 'status' => 'failed'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'failed', 'is_ltc' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'failed', 'gc_fee' => 5] );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit_reverse', 'amount' => 70,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'affiliate_credit_reverse', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'is_ltc' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit_reverse', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
        
        $I->dontSeeRecord( 'purchases',[ 'id' => 1 ] );
        $I->seeRecord( 'purchase_refunds',[ 'purchase_id' => 1 ] );
        
        $student = Student::where('username','sorin')->first();
        $affiliate = ProductAffiliate::find(5);
        $ltc = ProductAffiliate::find(2);
        $instructor = Instructor::find($course->instructor_id);
        $I->assertEquals( 0, $student->student_balance);
        $I->assertEquals( 0, $instructor->instructor_balance);
        $I->assertEquals( 0, $affiliate->affiliate_balance);
        $I->assertEquals( 0, $ltc->affiliate_balance);
    }
    
    public function purchaseThenRefundWithBalanceAndInstructorAgency(UnitTester $I){
        
        $student = Student::where('username','sorin')->first();
        $student->student_balance = 10;
        $student->updateUniques();
        $I->assertEquals(10, $student->student_balance);
                
        $course = Course::first();
        $course->price = 105;
        $course->affiliate_percentage = 10;
        $course->updateUniques();
        
        $course->instructor->agency->agency_balance = 0;
        $course->instructor->agency->updateUniques();
        
        $balance = $student->balanceDebit( 10, $course );
        $I->assertNotEquals( false, $balance );
        
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = $balance;
        
        $course->instructor->instructor_balance = 0;
        $course->instructor->updateUniques();
        $affiliate = ProductAffiliate::find(5);
        $affiliate->affiliate_balance = 0;
        $affiliate->updateUniques();
        $ltc = ProductAffiliate::find(2);
        $ltc->affiliate_balance = 0;
        $ltc->updateUniques();
        
        
        $I->assertEquals(0, $course->instructor->instructor_balance);
        $I->assertEquals(0, $course->instructor->agency->agency_balance);
        $I->assertEquals(0, $affiliate->affiliate_balance);
        $I->assertEquals(0, $ltc->affiliate_balance);
        
        $I->assertNotEquals( false, $student->purchase($course, 5, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        
        $I->assertNotEquals(0, $affiliate->ltc_affiliate_id);
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, $balance );
        $I->assertEquals( $purchase->instructor_earnings, 58 );
        $I->assertEquals( $purchase->affiliate_earnings, 10 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 30 * (5 / 100) );
        $I->assertEquals( $purchase->instructor_agency_earnings, 0.6 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 30 * (5 / 100) ) - 5 - 0.6 );
        
        $st = ($purchase->purchase_price - $purchase->processor_fee) *  ( Config::get('custom.earnings.second_tier_percentage') / 100 );        
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, $st );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 58,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $course->instructor->instructor_agency_id, 'transaction_type' => 'instructor_agency_credit', 
            'amount' => 0.6, 'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $affiliate->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => 2,
            'product_id' => $course->id, 'status' => 'complete', 'is_second_tier' => 'yes', 'is_ltc' => 'no'] );
        $I->seeRecord('transactions', ['user_id' => 5, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'is_ltc' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
        
        $student = Student::where('username','sorin')->first();
        $I->assertEquals( 0, $student->student_balance);
        
        $affiliate = ProductAffiliate::find(5);
        $ltc = ProductAffiliate::find(2);
        $I->assertEquals(0, $student->student_balance);
        $I->assertEquals(0.6, $course->instructor->agency->agency_balance);
        $I->assertEquals($purchase->instructor_earnings, $course->instructor->instructor_balance);
        $I->assertEquals($purchase->affiliate_earnings, $affiliate->affiliate_balance);
        $I->assertEquals($purchase->ltc_affiliate_earnings + $purchase->second_tier_affiliate_earnings 
                + $purchase->site_earnings, $ltc->affiliate_balance);
        
        // refund the purchase
        $purchase = Purchase::first();
        $I->assertTrue( $purchase->refund() );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 58,
            'product_id' => $course->id, 'status' => 'failed'] );
        $I->seeRecord('transactions', ['user_id' => $course->instructor->instructor_agency_id, 'transaction_type' => 'instructor_agency_credit', 'amount' => 0.6,
            'product_id' => $course->id, 'status' => 'failed'] );
        $I->seeRecord('transactions', ['user_id' => $affiliate->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => 2,
            'product_id' => $course->id, 'status' => 'failed', 'is_second_tier' => 'yes', 'is_ltc' => 'no'] );
        $I->seeRecord('transactions', ['user_id' => 5, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->affiliate_earnings,
            'product_id' => $course->id, 'status' => 'failed'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'failed', 'is_ltc' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'failed', 'gc_fee' => 5] );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit_reverse', 'amount' => 58,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $course->instructor->instructor_agency_id, 'transaction_type' => 'instructor_agency_credit_reverse', 'amount' => 0.6,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $affiliate->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit_reverse', 'amount' => 2,
            'product_id' => $course->id, 'status' => 'complete', 'is_second_tier' => 'yes', 'is_ltc' => 'no'] );
        $I->seeRecord('transactions', ['user_id' => 5, 'transaction_type' => 'affiliate_credit_reverse', 'amount' => $purchase->affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'affiliate_credit_reverse', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'is_ltc' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit_reverse', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
        
        $I->dontSeeRecord( 'purchases',[ 'id' => 1 ] );
        $I->seeRecord( 'purchase_refunds',[ 'purchase_id' => 1 ] );
        
        $student = Student::where('username','sorin')->first();
        $affiliate = ProductAffiliate::find(5);
        $ltc = ProductAffiliate::find(2);
        $instructor = Instructor::find($course->instructor_id);
        $I->assertEquals( 10, $student->student_balance);
        $I->assertEquals( 0, $instructor->instructor_balance);
        $I->assertEquals( 0, $affiliate->affiliate_balance);
        $I->assertEquals( 0, $ltc->affiliate_balance);
        $agency = InstructorAgency::find( $course->instructor->instructor_agency_id );
        $I->assertEquals( 0, $agency->agency_balance);
    }
    
    
}