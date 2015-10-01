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
        $aff->ltc_affiliate_id = 2;
        $aff->has_ltc = 'yes';
        $aff->updateUniques();
        
        $student = Student::where('username','student')->first();
        $student->created_at = date('Y-m-d H:i:s');
        $student->updateUniques();
        
        $course = Course::first();
        $course->sale = 0;
        $course->sale_ends_on = $course->sale_starts_on = '';
        $course->updateUniques();
    }
    
    
    public function coursePurchaseSecondTierInstructor(UnitTester $I){
        
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        
        $st = User::find( 14 );
        $st->is_second_tier_instructor = 'yes';
        $st->sti_approved = 'yes';
        $st->updateUniques();
        $I->assertEquals(0, $st->instructor_balance);
        
        $course = Course::first();
        $course->price = 105;
        $course->affiliate_percentage = 0;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course = Course::first();
        
        $I->assertEquals(105, $course->price);
//        $course->instructor->instructor_agency_id = null;
        $course->instructor->second_tier_instructor_id = $st->id;
        $course->instructor->updateUniques();
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '8.4';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $I->assertNotEquals( false, $student->purchase($course, null, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( $purchase->purchase_price, 113.4 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 8.4 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 70 );     
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 0 );
        
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 100 * (3 / 100) );
        
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 100 * (2 / 100) );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 100 * (3 / 100) ) - ( 100 * (2 / 100) ) );
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
    
    public function coursePurchaseSecondTierInstructorNotApproved(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        
        $st = User::find( 14 );
        $st->is_second_tier_instructor = 'yes';
        $st->sti_approved = 'no';
        $st->updateUniques();
        $I->assertEquals(0, $st->instructor_balance);
        
        $course = Course::first();
        $course->price = 105;
        $course->affiliate_percentage = 0;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course = Course::first();
//        $course->instructor->instructor_agency_id = null;
        $course->instructor->second_tier_instructor_id = $st->id;
        $course->instructor->updateUniques();
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '8.4';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $I->assertNotEquals( false, $student->purchase($course, null, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( $purchase->purchase_price, 113.4 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 8.4 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 70 ); 
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 0 );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 70,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->dontSeeRecord('transactions', ['user_id' => $st->id, 'transaction_type' => 'second_tier_instructor_credit'] );

        
        $st = User::find( 14 );
        $I->assertEquals( 0, $st->instructor_balance );
    }
    
    public function coursePurchaseDiscountedPercent(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 0;
        $course->sale = 50;
        $course->sale_kind = 'percentage';
        $course->sale_starts_on = date('Y-m-d H:i:s', time() - 3600);
        $course->sale_ends_on = date('Y-m-d H:i:s', time() + 3600);
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update( ['price' => '105', 'sale'=>1 ] );
        $course = Course::first();
//        $course->instructor->instructor_agency_id = null;
        $course->instructor->updateUniques();
        
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '8.31';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $I->assertNotEquals( false, $student->purchase($course, null, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( $purchase->purchase_price , 112.266 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 1.05 );
        $I->assertEquals( $purchase->discount, '1.00%' );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 8.31 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 98.95 * 0.70 );
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $nonInstructorMoney = 98.95 * .30;
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 98.95 * .03 );
//        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, $nonInstructorMoney - ( 98.95 * .03 ) );
        
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
        $course->price = 1006;
        $course->affiliate_percentage = 0;
        $course->sale = 1;
        $course->sale_kind = 'amount';
        $course->sale_starts_on = date('Y-m-d H:i:s', time() - 100 );
        $course->sale_ends_on = date('Y-m-d H:i:s', time() + 3600);
        $course->updateUniques();
        
        DB::table('courses')->where('id', $course->id)->update( ['price' => '106', 'sale' => 1] );
        $course = Course::first();
        
//        $course->instructor->instructor_agency_id = null;
        $course->instructor->updateUniques();
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '8.4';
        
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        
        $I->assertNotEquals( false, $student->purchase($course, null, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( $purchase->purchase_price, 113.4 );
        $I->assertEquals( $purchase->original_price, 106 );
        $I->assertEquals( $purchase->discount_value, 1 );
        $I->assertEquals( $purchase->discount, 'Yen 1.00' );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 8.4 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        
        $I->assertEquals( $purchase->instructor_earnings, 100 * 0.70 );
        
        $nonInstructorMoney = 100 * .30;
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 100 * .03 );
        
        $I->assertEquals( $purchase->site_earnings, $nonInstructorMoney - ( 100 * .03 ) );
        
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
        $st->is_second_tier_instructor = 'yes';
        $st->sti_approved = 'yes';
        $st->updateUniques();
        $I->assertEquals(0, $st->instructor_balance);
        $course = Course::first();
        $course->price = 1006;
        $course->affiliate_percentage = 0;
        $course->sale = 100;
        $course->sale_kind = 'amount';
        $course->sale_starts_on = date('Y-m-d H:i:s', time() - 3600);
        $course->sale_ends_on = date('Y-m-d H:i:s', time() + 3600);
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update( [ 'price' => '106', 'sale' => 1 ] );
        $course = Course::first();
        
//        $course->instructor->instructor_agency_id = null;
        $course->instructor->second_tier_instructor_id = $st->id;
        $course->instructor->updateUniques();
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '8.4';
        
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $I->assertNotEquals( false, $student->purchase($course, null, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( $purchase->purchase_price, 113.4 );
        $I->assertEquals( $purchase->original_price, 106 );
        $I->assertEquals( $purchase->discount_value, 1 );
        $I->assertEquals( $purchase->discount, 'Yen 1.00' );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 8.4 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 100 * 0.70 );
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $nonInstructorMoney = 100 * .30;
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 100 * .03 );
//        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 100 * .02 );
        $I->assertEquals( $purchase->site_earnings, $nonInstructorMoney - ( 100 * .03 ) - ( 100 * .02 ) );
        
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
        $course->price = 1050;
        $course->affiliate_percentage = 10;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course = Course::first();
        
//        $course->instructor->instructor_agency_id = null;
//        $course->instructor->updateUniques();
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '8.4';
        
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $I->assertNotEquals( false, $student->purchase($course, 5, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        $affiliate = ProductAffiliate::find(5);
     
        $st = ($purchase->purchase_price - 8.4 - $purchase->processor_fee) *  ( Config::get('custom.earnings.second_tier_percentage') / 100 );        
        
        $I->assertNotEquals(0, $affiliate->second_tier_affiliate_id);
        $I->assertEquals( $purchase->purchase_price, 113.4 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 8.4 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 58);
        $I->assertEquals( $purchase->affiliate_earnings, 10 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 100 * (3 / 100) );
//        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 100 * (3 / 100) )  );
        
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, $st );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' =>  $purchase->instructor_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $affiliate->second_tier_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => 2,
            'product_id' => $course->id, 'status' => 'complete', 'is_second_tier' => 'yes', 'is_ltc' => 'no'] );
        $I->seeRecord('transactions', ['user_id' => 5, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $purchase->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'is_ltc' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
        
        $sale = $purchase;
        $total = $sale->processor_fee + $sale->tax + $sale->instructor_earnings + $sale->second_tier_instructor_earnings + $sale->affiliate_earnings + $sale->second_tier_affiliate_earnings
                        + $sale->ltc_affiliate_earnings + $sale->instructor_agency_earnings + $sale->site_earnings; 
        $I->assertEquals($purchase->purchase_price, $total);
    }
    
    public function coursePurchaseCustomAffiliateShareForOnlyOne(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 10;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course = Course::first();
        
        $custom = new CourseAffiliateCustomPercentage();
        $custom->course_id = $course->id;
        $custom->affiliate_id = 5;
        $custom->percentage = 20;
        $custom->save();
        
//        $course->instructor->instructor_agency_id = null;
//        $course->instructor->updateUniques();
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '8.4';
        
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $I->assertNotEquals( false, $student->purchase($course, 5, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        $affiliate = ProductAffiliate::find(5);
        
        $I->assertNotEquals( 0, $affiliate->second_tier_affiliate_id );
        
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 2 );
        $I->assertEquals( $purchase->affiliate_earnings, 20 );
        $I->assertEquals( $purchase->instructor_earnings, 48 );
        
        $sorin = Student::where('username','sorin')->first();
        Purchase::where('student_id', $sorin->id)->delete();
        
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course = Course::first();
        
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '8.4';
        
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 2;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $I->assertNotEquals( false, $sorin->purchase($course, 2, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        $affiliate = ProductAffiliate::find(2);
        
        $I->assertEquals(0, $affiliate->second_tier_affiliate_id);
        $I->assertEquals( $purchase->affiliate_earnings, 10 );        
        $I->assertEquals( $purchase->instructor_earnings, 60 );
        
        $sale = $purchase;
        $total = $sale->processor_fee + $sale->tax + $sale->instructor_earnings + $sale->second_tier_instructor_earnings + $sale->affiliate_earnings + $sale->second_tier_affiliate_earnings
                        + $sale->ltc_affiliate_earnings + $sale->instructor_agency_earnings + $sale->site_earnings; 
        $I->assertEquals($purchase->purchase_price, $total);
    }
    
    public function coursePurchaseCustomAffiliateShare(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 10;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course = Course::first();
        
        $custom = new CourseAffiliateCustomPercentage();
        $custom->course_id = $course->id;
        $custom->affiliate_id = 5;
        $custom->percentage = 20;
        $custom->save();
        
//        $course->instructor->instructor_agency_id = null;
//        $course->instructor->updateUniques();
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '8.4';
        
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $I->assertNotEquals( false, $student->purchase($course, 5, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        $affiliate = ProductAffiliate::find(5);
        $st = ($purchase->purchase_price - 8.4 - $purchase->processor_fee) *  ( Config::get('custom.earnings.second_tier_percentage') / 100 );        
        
        $I->assertNotEquals(0, $affiliate->second_tier_affiliate_id);
        $I->assertEquals( $purchase->purchase_price, 113.4 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 8.4 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->affiliate_earnings, 20 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, $st );
        $I->assertEquals( $purchase->instructor_earnings, 48  );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 100 * (3 / 100) );
//        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 100 * (3 / 100) )  );
        
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 48,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $affiliate->second_tier_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => 2,
            'product_id' => $course->id, 'status' => 'complete', 'is_second_tier' => 'yes', 'is_ltc' => 'no'] );
        $I->seeRecord('transactions', ['user_id' => 5, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $purchase->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'is_ltc' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
        
        $sale = $purchase;
        $total = $sale->processor_fee + $sale->tax + $sale->instructor_earnings + $sale->second_tier_instructor_earnings + $sale->affiliate_earnings + $sale->second_tier_affiliate_earnings
                        + $sale->ltc_affiliate_earnings + $sale->instructor_agency_earnings + $sale->site_earnings; 
        $I->assertEquals($purchase->purchase_price, $total);
    }
    
    public function coursePurchaseAffiliateShareNoSecondTier(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 10;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course = Course::first();
        
//        $course->instructor->instructor_agency_id = null;
//        $course->instructor->updateUniques();
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '8.4';
        
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $affiliate = ProductAffiliate::find(5);
        $affiliate->second_tier_affiliate_id = 0;
        $I->assertTrue( $affiliate->updateUniques() );
        
        $I->assertNotEquals( false, $student->purchase($course, 5, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals(0, $affiliate->second_tier_affiliate_id);
        $I->assertEquals( $purchase->purchase_price, 113.4 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 8.4 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 60 );
        $I->assertEquals( $purchase->affiliate_earnings, 10 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 100 * (3 / 100) );
//        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 100 * (3 / 100) )  );
             
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
    
    public function coursePurchaseAffiliateCustomShareNoSecondTier(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 10;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course = Course::first();
        
//        $course->instructor->instructor_agency_id = null;
//        $course->instructor->updateUniques();
        
        $custom = new CourseAffiliateCustomPercentage();
        $custom->course_id = $course->id;
        $custom->affiliate_id = 5;
        $custom->percentage = 20;
        $custom->save();
        
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '8.4';
        
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $affiliate = ProductAffiliate::find(5);
        $affiliate->second_tier_affiliate_id = 0;
        $I->assertTrue( $affiliate->updateUniques() );
        
        $I->assertNotEquals( false, $student->purchase($course, 5, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals(0, $affiliate->second_tier_affiliate_id);
        $I->assertEquals( $purchase->purchase_price, 113.4 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 8.4 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 50 );
        $I->assertEquals( $purchase->affiliate_earnings, 20 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 100 * (3 / 100) );
//        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 100 * (3 / 100) )  );
             
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 0 );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 50,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 5, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $purchase->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
    }
   
    
    public function lessonPurchase(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        $lesson = Lesson::first();
        $lesson->price = 1050;
        $lesson->updateUniques();
        DB::table('lessons')->where('id', $lesson->id)->update(['price' => '105']);
        $lesson = Lesson::first();
        
//        $lesson->module->course->instructor->instructor_agency_id = null;
//        $lesson->module->course->instructor->updateUniques();
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '8.4';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $I->assertNotEquals( false, $student->purchase($lesson, null, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( $purchase->purchase_price, 113.4 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 8.4 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 70 );
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 100 * (3 / 100) );
//        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 100 * (3 / 100) )  );
        
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
        $lesson->price = 1050;
        $lesson->updateUniques();
        DB::table('lessons')->where('id', $lesson->id)->update(['price' => '105']);
        $lesson = Lesson::first();
        
        $st = User::find(14);
        $st->is_second_tier_instructor = 'yes';
        $st->sti_approved = 'yes';
        $st->updateUniques();
        $st->instructor_balance = 0;
        $st->updateUniques();
        $I->assertEquals( 0, $st->instructor_balance );
        
//        $lesson->module->course->instructor->instructor_agency_id = null;
        $lesson->module->course->instructor->second_tier_instructor_id = 14;
        $lesson->module->course->instructor->updateUniques();
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '8.4';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $I->assertNotEquals( false, $student->purchase($lesson, null, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( $purchase->purchase_price, 113.4 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 8.4 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 70 );
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 100 * (3 / 100) );
//        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 100 * (2 / 100) );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 100 * (3 / 100) )  - ( 100 * (2 / 100) )  );
        
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
        DB::table('lessons')->where('id', $lesson->id)->update(['price' => '105']);
        $lesson = Lesson::first();
        
//        $lesson->module->course->instructor->instructor_agency_id = null;
//        $lesson->module->course->instructor->updateUniques();
        $affiliate = ProductAffiliate::find(5);
        $affiliate->ltc_affiliate_id = $affiliate->second_tier_affiliate_id = 0;
        $I->assertTrue( $affiliate->updateUniques() );
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '8.4';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $I->assertNotEquals( false, $student->purchase($lesson, 5, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( $purchase->purchase_price, 113.4 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 8.4 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 60 );
        $I->assertEquals( $purchase->affiliate_earnings, 10 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 100 * (3 / 100) );
//        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 100 * (3 / 100) ) );
        
        $I->seeRecord('transactions', ['user_id' => $lesson->module->course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 60,
            'product_id' => $lesson->id, 'status' => 'complete', 'reference' => '123'] );
        $I->seeRecord('transactions', ['user_id' => 5, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->affiliate_earnings,
            'product_id' => $lesson->id, 'status' => 'complete', 'reference' => '123'] );
        $I->seeRecord('transactions', ['user_id' => $purchase->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $lesson->id, 'status' => 'complete', 'reference' => '123', 'is_ltc' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $lesson->id, 'status' => 'complete', 'gc_fee' => 5, 'reference' => '123'] );
    }
    
    public function lessonPurchaseAffiliateCustomShareNoSecondTier(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        $lesson = Lesson::first();
        $lesson->price = 1050;
        $lesson->updateUniques();
        $lesson->module->course->affiliate_percentage = 10;
        $lesson->module->course->updateUniques();
        DB::table('lessons')->where('id', $lesson->id)->update(['price' => '105']);
        $lesson = Lesson::first();
        
//        $lesson->module->course->instructor->instructor_agency_id = null;
//        $lesson->module->course->instructor->updateUniques();
        $affiliate = ProductAffiliate::find(5);
        $affiliate->ltc_affiliate_id = $affiliate->second_tier_affiliate_id = 0;
        $I->assertTrue( $affiliate->updateUniques() );
        
        $custom = new CourseAffiliateCustomPercentage();
        $custom->course_id = $lesson->module->course->id;
        $custom->affiliate_id = 5;
        $custom->percentage = 20;
        $custom->save();
        
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '8.4';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $I->assertNotEquals( false, $student->purchase($lesson, 5, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( $purchase->purchase_price, 113.4 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 8.4 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 50 );
        $I->assertEquals( $purchase->affiliate_earnings, 20 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 100 * (3 / 100) );
//        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 100 * (3 / 100) )  );
        
        $I->seeRecord('transactions', ['user_id' => $lesson->module->course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 50,
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
        $lesson->price = 1050;
        $lesson->updateUniques();
        $lesson->module->course->affiliate_percentage = 10;
        $lesson->module->course->updateUniques();
        DB::table('lessons')->where('id', $lesson->id)->update(['price' => '105']);
        $lesson = Lesson::first();
        
//        $lesson->module->course->instructor->instructor_agency_id = null;
//        $lesson->module->course->instructor->updateUniques();
        
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '8.4';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';

        
        $I->assertNotEquals( false, $student->purchase($lesson, 5, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( $purchase->purchase_price, 113.4 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 8.4 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 2 );
        $I->assertEquals( $purchase->instructor_earnings, 58 );
        $I->assertEquals( $purchase->affiliate_earnings, 10 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 100 * (3 / 100) );
//        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 100 * (3 / 100) )  );
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
        
        $sale = $purchase;
        $total = $sale->processor_fee + $sale->tax + $sale->instructor_earnings + $sale->second_tier_instructor_earnings + $sale->affiliate_earnings + $sale->second_tier_affiliate_earnings
                        + $sale->ltc_affiliate_earnings + $sale->instructor_agency_earnings + $sale->site_earnings; 
        $I->assertEquals($purchase->purchase_price, $total);
    }
    
    public function lessonPurchaseAffiliateCustomShareSecondTier(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        $lesson = Lesson::first();
        $lesson->price = 1050;
        $lesson->updateUniques();
        DB::table('lessons')->where('id', $lesson->id)->update(['price' => '105']);
        $lesson = Lesson::first();
        $lesson->module->course->affiliate_percentage = 10;
        $lesson->module->course->updateUniques();
        
//        $lesson->module->course->instructor->instructor_agency_id = null;
//        $lesson->module->course->instructor->updateUniques();
        
        $custom = new CourseAffiliateCustomPercentage();
        $custom->course_id = $lesson->module->course->id;
        $custom->affiliate_id = 5;
        $custom->percentage = 20;
        $custom->save();
        
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '8.4';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';

        
        $I->assertNotEquals( false, $student->purchase($lesson, 5, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( $purchase->purchase_price, 113.4 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 8.4 );
        $I->assertEquals( $purchase->balance_used, 10 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 2 );
        $I->assertEquals( $purchase->instructor_earnings, 48 );
        $I->assertEquals( $purchase->affiliate_earnings, 20 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 100 * (3 / 100) );
//        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 100 * (3 / 100) )  );
        $st = ProductAffiliate::find(5)->second_tier_affiliate_id;
        $I->seeRecord('transactions', ['user_id' => $lesson->module->course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 48,
            'product_id' => $lesson->id, 'status' => 'complete', 'reference' => '123'] );
        $I->seeRecord('transactions', ['user_id' => $st, 'transaction_type' => 'affiliate_credit', 'amount' => 2,
            'product_id' => $lesson->id, 'status' => 'complete', 'reference' => '123', 'is_second_tier' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 5, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->affiliate_earnings,
            'product_id' => $lesson->id, 'status' => 'complete', 'reference' => '123'] );
        $I->seeRecord('transactions', ['user_id' => $purchase->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $lesson->id, 'status' => 'complete', 'reference' => '123', 'is_ltc' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $lesson->id, 'status' => 'complete', 'gc_fee' => 5, 'reference' => '123'] );
        
        $sale = $purchase;
        $total = $sale->processor_fee + $sale->tax + $sale->instructor_earnings + $sale->second_tier_instructor_earnings + $sale->affiliate_earnings + $sale->second_tier_affiliate_earnings
                        + $sale->ltc_affiliate_earnings + $sale->instructor_agency_earnings + $sale->site_earnings; 
        $I->assertEquals($purchase->purchase_price, $total);
        
    }
    
}