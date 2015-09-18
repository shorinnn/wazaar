<?php
use \UnitTester;

class Order2Cest{
    
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
                
        $secondTierAffiliate = User::find(2);
        $secondTierAffiliate->has_ltc = 'yes';
        $secondTierAffiliate->affiliate_id = 2;
        $secondTierAffiliate->updateUniques();
        $aff = User::find(5);
        $aff->second_tier_affiliate_id = 2;
        $aff->updateUniques();
        
        $course = Course::first();
        $course->sale = 0;
        $course->sale_ends_on = $course->sale_starts_on = '';
        $course->updateUniques();
    }
    
    public function simpleCoursePurchase(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student->ltc_affiliate_id = 5;
        $student->created_at = date('Y-m-d H:i:s');
        $I->assertTrue( $student->updateUniques() );
        $student = Student::where('username','student')->first();
        
        Purchase::where('student_id', $student->id)->delete();
        $course = Course::first();
        $course->price = 105;
        $course->affiliate_percentage = 0;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
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
        $course = Course::first();
        
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
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 100 * (3 / 100) );
        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 100 * (3 / 100) )  );
        
        $I->assertEquals( 5, $purchase->ltc_affiliate_id );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 70,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $purchase->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
        
        
        $I->assertEquals( 70, $course->instructor->instructor_balance );
        $wazaar = User::find(2);
        $I->assertEquals( $purchase->site_earnings, $wazaar->affiliate_balance );
        $ltc = User::find(5);
        $I->assertEquals( $purchase->ltc_affiliate_earnings, $ltc->affiliate_balance );
    }
    
    public function simpleCoursePurchaseNoAffiliateNoLTC(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student->ltc_affiliate_id = 5;
        $student->created_at = date('Y-m-d H:i:s');
        $I->assertTrue( $student->updateUniques() );
        $student = Student::where('username','student')->first();
        
        Purchase::where('student_id', $student->id)->delete();
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 0;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course->instructor->instructor_agency_id = null;

        $course->instructor->instructor_balance = 0;
        $course->instructor->updateUniques();
        $course = Course::first();
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
        $ltc->has_ltc = 'no';
        $I->assertTrue( $ltc->updateUniques() );
        $ltc = User::find(5);
        
        $I->assertEquals( 0, $ltc->affiliate_balance );
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
        $I->assertEquals( 5, $student->ltc_affiliate_id );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 30 );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 70,
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
    
    public function simpleCourseNoLTCAffiliate(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student->ltc_affiliate_id = null;
        $student->created_at = date('Y-m-d H:i:s');
        $I->assertTrue( $student->updateUniques() );
        $student = Student::where('username','student')->first();
        
        Purchase::where('student_id', $student->id)->delete();
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 0;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course = Course::first();
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
        $I->assertEquals( null, $student->ltc_affiliate_id );
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
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 30  );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 70,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
        $I->assertNotEquals( 2, $purchase->ltc_affiliate_id );
        $I->assertEquals( 70, $course->instructor->instructor_balance );
        $wazaar = User::find(2);
        $I->assertEquals( $purchase->site_earnings, $wazaar->affiliate_balance );
    }
    
}