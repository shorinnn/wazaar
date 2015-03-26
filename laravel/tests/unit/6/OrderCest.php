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
    }
    
    public function coursePurchase(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        $course = Course::first();
        $course->price = 105;
        $course->affiliate_percentage = 0;
        $course->updateUniques();
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
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
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 30 * (5 / 100) );
        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 30 * (5 / 100) ) - 5 );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 70,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
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
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
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
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->ltc_affiliate_earnings,
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
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
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
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
    }
    
    public function coursePurchaseAffiliateShare(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        $course = Course::first();
        $course->price = 105;
        $course->affiliate_percentage = 10;
        $course->updateUniques();
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $I->assertNotEquals( false, $student->purchase($course, 5, $data) );
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
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 60,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 5, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->ltc_affiliate_earnings,
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
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->ltc_affiliate_earnings,
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
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
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
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $lesson->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $lesson->id, 'status' => 'complete', 'gc_fee' => 5] );
    }
    
    public function lessonPurchaseAffiliateShare(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        $lesson = Lesson::first();
        $lesson->price = 105;
        $lesson->updateUniques();
        $lesson->module->course->affiliate_percentage = 10;
        $lesson->module->course->updateUniques();
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
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
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $lesson->id, 'status' => 'complete', 'reference' => '123'] );
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
        $I->assertEquals( $purchase->instructor_agency_earnings, 30 * .02 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 30 * 0.05 ) - ( 30 * .02) - 5 );
        
        $I->seeRecord('transactions', ['user_id' => $lesson->module->course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 70,
            'product_id' => $lesson->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $lesson->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $lesson->module->course->instructor->agency->id, 'transaction_type' => 'instructor_agency_credit', 
            'amount' => $purchase->instructor_agency_earnings, 'product_id' => $lesson->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $lesson->id, 'status' => 'complete', 'gc_fee' => 5] );
    }
}