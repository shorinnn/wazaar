<?php
use \UnitTester;

class OrderCest{
    
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
        Config::set('custom.earnings.second_tier_instructor_percentage', 2);
        
                
        $secondTierAffiliate = User::find(2);
        $secondTierAffiliate->has_ltc = 'yes';
        $secondTierAffiliate->affiliate_id = 2;
        $secondTierAffiliate->updateUniques();
        $aff = User::find(5);
        $aff->ltc_affiliate_id = 2;
        $aff->updateUniques();
    }
    
    public function simpleCoursePurchase(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student->ltc_affiliate_id = 5;
        $I->assertTrue( $student->updateUniques() );
        $student = Student::where('username','student')->first();
        
        Purchase::where('student_id', $student->id)->delete();
        $course = Course::first();
        $course->price = 105;
        $course->affiliate_percentage = 0;
        $course->updateUniques();
        $course->instructor->instructor_agency_id = null;

        $course->instructor->instructor_balance = 0;
        $course->instructor->updateUniques();
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        
        
        $I->assertEquals( 0, $course->instructor->instructor_balance );
        $wazaar = User::find(2);
        $I->assertEquals( 0, $wazaar->affiliate_balance );
        $ltc = User::find(5);
        $ltc->affiliate_balance = 0;
        $ltc->updateUniques();
        $I->assertEquals( 0, $ltc->affiliate_balance );
        $I->assertEquals( 5, $student->ltc_affiliate_id );
        $I->assertNotEquals( false, $student->purchase($course, null, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();

        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 70 ); 
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 30 * (5 / 100) );
        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 30 * (5 / 100) ) - 5 );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 70,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $purchase->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
        $I->assertNotEquals( 2, $purchase->ltc_affiliate_id );
        $I->assertEquals( 70, $course->instructor->instructor_balance );
        $wazaar = User::find(2);
        $I->assertEquals( $purchase->site_earnings, $wazaar->affiliate_balance );
        $ltc = User::find(5);
        $I->assertEquals( $purchase->ltc_affiliate_earnings, $ltc->affiliate_balance );
    }
    
    public function coursePurchaseSecondTierInstructor(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        
        $st = User::find( 14 );
        $I->assertEquals(0, $st->instructor_balance);
        
        $course = Course::first();
        $course->price = 105;
        $course->affiliate_percentage = 0;
        $course->updateUniques();
        $course->instructor->instructor_agency_id = null;
        $course->instructor->second_tier_instructor_id = $st->id;
        $course->instructor->updateUniques();
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $I->assertNotEquals( false, $student->purchase($course, null, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 70 ); 
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 30 * (5 / 100) );
        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 30 * (2 / 100) );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 30 * (5 / 100) ) - ( 30 * (2 / 100) ) - 5 );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 70,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $st->id, 'transaction_type' => 'second_tier_instructor_credit', 
            'amount' => $purchase->second_tier_instructor_earnings, 'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $purchase->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
        
        $st = User::find( 14 );
        $I->assertEquals($purchase->second_tier_instructor_earnings, $st->instructor_balance);
    }
    
    public function coursePurchaseDiscountedPercent(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        $course = Course::first();
        $course->price = 105;
        $course->affiliate_percentage = 0;
        $course->sale = 1;
        $course->sale_kind = 'percentage';
        $course->sale_ends_on = date('Y-m-d H:i:s', time() + 3600);
        $course->updateUniques();
        $course->instructor->instructor_agency_id = null;
        $course->instructor->updateUniques();
        
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $I->assertNotEquals( false, $student->purchase($course, null, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( $purchase->purchase_price, 103.95 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 1.05 );
        $I->assertEquals( $purchase->discount, '1%' );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 98.95 * 0.7 );
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $nonInstructorMoney = 98.95 * .3;
        $I->assertEquals( $purchase->ltc_affiliate_earnings, $nonInstructorMoney * .05 );
        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, $nonInstructorMoney - ( $nonInstructorMoney * .05 ) - 5 );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => $purchase->instructor_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $purchase->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
    }
    
    public function coursePurchaseDiscountedAmount(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        $course = Course::first();
        $course->price = 106;
        $course->affiliate_percentage = 0;
        $course->sale = 1;
        $course->sale_kind = 'amount';
        $course->sale_ends_on = date('Y-m-d H:i:s', time() + 3600);
        $course->updateUniques();
        
        $course->instructor->instructor_agency_id = null;
        $course->instructor->updateUniques();
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $I->assertNotEquals( false, $student->purchase($course, null, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 106 );
        $I->assertEquals( $purchase->discount_value, 1 );
        $I->assertEquals( $purchase->discount, 'Yen 1' );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 100 * 0.7 );
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $nonInstructorMoney = 100 * .3;
        $I->assertEquals( $purchase->ltc_affiliate_earnings, $nonInstructorMoney * .05 );
        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, $nonInstructorMoney - ( $nonInstructorMoney * .05 ) - 5 );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => $purchase->instructor_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $purchase->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
    }
    
    public function coursePurchaseDiscountedAmountSecondTierInstructor(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        $st = User::find( 14 );
        $I->assertEquals(0, $st->instructor_balance);
        $course = Course::first();
        $course->price = 106;
        $course->affiliate_percentage = 0;
        $course->sale = 1;
        $course->sale_kind = 'amount';
        $course->sale_ends_on = date('Y-m-d H:i:s', time() + 3600);
        $course->updateUniques();
        
        $course->instructor->instructor_agency_id = null;
        $course->instructor->second_tier_instructor_id = $st->id;
        $course->instructor->updateUniques();
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $I->assertNotEquals( false, $student->purchase($course, null, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 106 );
        $I->assertEquals( $purchase->discount_value, 1 );
        $I->assertEquals( $purchase->discount, 'Yen 1' );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 100 * 0.7 );
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $nonInstructorMoney = 100 * .3;
        $I->assertEquals( $purchase->ltc_affiliate_earnings, $nonInstructorMoney * .05 );
        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, $nonInstructorMoney * .02 );
        $I->assertEquals( $purchase->site_earnings, $nonInstructorMoney - ( $nonInstructorMoney * .05 ) - ( $nonInstructorMoney * .02 ) - 5 );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => $purchase->instructor_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $st->id, 'transaction_type' => 'second_tier_instructor_credit', 'amount' => $purchase->second_tier_instructor_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $purchase->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
        
        $st = User::find( 14 );
        $I->assertEquals($purchase->second_tier_instructor_earnings, $st->instructor_balance);
    }
    
    public function coursePurchaseAffiliateShare(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
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
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $I->assertNotEquals( false, $student->purchase($course, 5, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        $affiliate = ProductAffiliate::find(5);
        
        $I->assertNotEquals(0, $affiliate->ltc_affiliate_id);
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->balance_used, 10 );
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
        $I->seeRecord('transactions', ['user_id' => $purchase->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'is_ltc' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
    }
    
    public function coursePurchaseAffiliateShareNoSecondTier(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
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
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $affiliate = ProductAffiliate::find(5);
        $affiliate->ltc_affiliate_id = 0;
        $I->assertTrue( $affiliate->updateUniques() );
        
        $I->assertNotEquals( false, $student->purchase($course, 5, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals(0, $affiliate->ltc_affiliate_id);
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 60 );
        $I->assertEquals( $purchase->affiliate_earnings, 10 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 30 * (5 / 100) );
        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 30 * (5 / 100) ) - 5 );
             
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 0 );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 60,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 5, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $purchase->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
    }
    
    public function coursePurchaseInstructorAgency(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        $course = Course::first();
        $course->price = 105;
        $course->affiliate_percentage = 0;
        $course->updateUniques();
        $agency = InstructorAgency::where( 'username','InstructorAgency1' )->first();
        $course->instructor->instructor_agency_id = $agency->id;
        $course->instructor->updateUniques();
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $I->assertNotEquals( false, $student->purchase($course, null, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 70 );
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 30 * 0.05 );
        $I->assertEquals( $purchase->instructor_agency_earnings, 30 * .02 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 30 * 0.05 ) - ( 30 * .02 ) - 5 );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 70,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $purchase->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $course->instructor->agency->id, 'transaction_type' => 'instructor_agency_credit', 
            'amount' => $purchase->instructor_agency_earnings, 'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
    }
    
    public function lessonPurchase(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        $lesson = Lesson::first();
        $lesson->price = 105;
        $lesson->updateUniques();
        
        $lesson->module->course->instructor->instructor_agency_id = null;
        $lesson->module->course->instructor->updateUniques();
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $I->assertNotEquals( false, $student->purchase($lesson, null, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 70 );
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 30 * (5 / 100) );
        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 30 * (5 / 100) ) - 5 );
        
        $I->seeRecord('transactions', ['user_id' => $lesson->module->course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 70,
            'product_id' => $lesson->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $purchase->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $lesson->id, 'status' => 'complete', 'is_ltc' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $lesson->id, 'status' => 'complete', 'gc_fee' => 5] );
    }
    
    public function lessonPurchaseSecondTierInstructor(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        $lesson = Lesson::first();
        $lesson->price = 105;
        $lesson->updateUniques();
        
        $st = User::find(14);
        $st->instructor_balance = 0;
        $st->updateUniques();
        $I->assertEquals( 0, $st->instructor_balance );
        
        $lesson->module->course->instructor->instructor_agency_id = null;
        $lesson->module->course->instructor->second_tier_instructor_id = 14;
        $lesson->module->course->instructor->updateUniques();
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $I->assertNotEquals( false, $student->purchase($lesson, null, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 70 );
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 30 * (5 / 100) );
        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 30 * (2 / 100) );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 30 * (5 / 100) )  - ( 30 * (2 / 100) ) - 5 );
        
        $I->seeRecord('transactions', ['user_id' => $lesson->module->course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 70,
            'product_id' => $lesson->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $purchase->second_tier_instructor_id, 'transaction_type' => 'second_tier_instructor_credit',
            'amount' => $purchase->second_tier_instructor_earnings,
            'product_id' => $lesson->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $purchase->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $lesson->id, 'status' => 'complete', 'is_ltc' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $lesson->id, 'status' => 'complete', 'gc_fee' => 5] );
        
        $st = User::find(14);
        $I->assertEquals( $purchase->second_tier_instructor_earnings, $st->instructor_balance );
    }
    
    public function lessonPurchaseAffiliateShareNoSecondTier(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        $lesson = Lesson::first();
        $lesson->price = 105;
        $lesson->updateUniques();
        $lesson->module->course->affiliate_percentage = 10;
        $lesson->module->course->updateUniques();
        
        $lesson->module->course->instructor->instructor_agency_id = null;
        $lesson->module->course->instructor->updateUniques();
        $affiliate = ProductAffiliate::find(5);
        $affiliate->ltc_affiliate_id = 0;
        $I->assertTrue( $affiliate->updateUniques() );
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $I->assertNotEquals( false, $student->purchase($lesson, 5, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 60 );
        $I->assertEquals( $purchase->affiliate_earnings, 10 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 30 * (5 / 100) );
        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 30 * (5 / 100) ) - 5 );
        
        $I->seeRecord('transactions', ['user_id' => $lesson->module->course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 60,
            'product_id' => $lesson->id, 'status' => 'complete', 'reference' => '123'] );
        $I->seeRecord('transactions', ['user_id' => 5, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->affiliate_earnings,
            'product_id' => $lesson->id, 'status' => 'complete', 'reference' => '123'] );
        $I->seeRecord('transactions', ['user_id' => $purchase->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $lesson->id, 'status' => 'complete', 'reference' => '123', 'is_ltc' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $lesson->id, 'status' => 'complete', 'gc_fee' => 5, 'reference' => '123'] );
    }
    
    public function lessonPurchaseAffiliateShareSecondTier(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        $lesson = Lesson::first();
        $lesson->price = 105;
        $lesson->updateUniques();
        $lesson->module->course->affiliate_percentage = 10;
        $lesson->module->course->updateUniques();
        
        $lesson->module->course->instructor->instructor_agency_id = null;
        $lesson->module->course->instructor->updateUniques();
        
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';

        
        $I->assertNotEquals( false, $student->purchase($lesson, 5, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 58 );
        $I->assertEquals( $purchase->affiliate_earnings, 10 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 2 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 30 * (5 / 100) );
        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 30 * (5 / 100) ) - 5 );
        $st = ProductAffiliate::find(5)->ltc_affiliate_id;
        $I->seeRecord('transactions', ['user_id' => $lesson->module->course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 58,
            'product_id' => $lesson->id, 'status' => 'complete', 'reference' => '123'] );
        $I->seeRecord('transactions', ['user_id' => $st, 'transaction_type' => 'affiliate_credit', 'amount' => 2,
            'product_id' => $lesson->id, 'status' => 'complete', 'reference' => '123', 'is_second_tier' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 5, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->affiliate_earnings,
            'product_id' => $lesson->id, 'status' => 'complete', 'reference' => '123'] );
        $I->seeRecord('transactions', ['user_id' => $purchase->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $lesson->id, 'status' => 'complete', 'reference' => '123', 'is_ltc' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $lesson->id, 'status' => 'complete', 'gc_fee' => 5, 'reference' => '123'] );
    }
    
    public function lessonPurchaseInstructorAgency(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        $lesson = Lesson::first();
        $lesson->price = 105;
        $lesson->updateUniques();
        $agency = InstructorAgency::where( 'username','InstructorAgency1' )->first();
        $lesson->module->course->instructor->instructor_agency_id = $agency->id;
        $lesson->module->course->instructor->updateUniques();
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $I->assertNotEquals( false, $student->purchase($lesson, null, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 70);
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 30 * (5 / 100) );
        $I->assertEquals( $purchase->instructor_agency_earnings, 30 * .02 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 30 * 0.05 ) - ( 30 * .02) - 5 );
        
        $I->seeRecord('transactions', ['user_id' => $lesson->module->course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 70,
            'product_id' => $lesson->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $purchase->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $lesson->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $lesson->module->course->instructor->agency->id, 'transaction_type' => 'instructor_agency_credit', 
            'amount' => $purchase->instructor_agency_earnings, 'product_id' => $lesson->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $lesson->id, 'status' => 'complete', 'gc_fee' => 5] );
    }
}