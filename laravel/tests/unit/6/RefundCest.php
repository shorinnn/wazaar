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
        
        $user = User::where('username','sorin')->first();
        DB::table('purchases')->where('student_id', $user->id)->delete();
        DB::table('purchase_refunds')->where('student_id', $user->id)->delete();
        DB::table('transactions')->where('user_id', $user->id)->delete();
        
        $course = Course::first();
        $course->sale = 0;
        $course->sale_starts_on = $course->sale_ends_on = '';
        $course->updateUniques();
        
    }
    
    
    public function purchaseThenRefundWithBalance(UnitTester $I){
        
        $student = Student::where('username','sorin')->first();
        $student->student_balance = 10;
        $student->ltc_affiliate_id = 2;
        $student->created_at = date('Y-m-d');
        $student->updateUniques();
        $I->assertEquals(10, $student->student_balance);
                
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 10;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course = Course::first();
        
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
        $affiliate->ltc_affiliate_id = 2;
        $affiliate->second_tier_affiliate_id = 2;
        $affiliate->updateUniques();
        $ltc = ProductAffiliate::find(2);
        $ltc->affiliate_balance = 0;
        $ltc->has_ltc = 'yes';
        $ltc->updateUniques();
        
        
        $I->assertEquals(0, $course->instructor->instructor_balance);
        $I->assertEquals(0, $affiliate->affiliate_balance);
        $I->assertEquals(0, $ltc->affiliate_balance);
        
        $I->assertNotEquals( false, $student->purchase($course, 5, $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        
        
        $I->assertEquals( $purchase->instructor_id, $course->instructor_id );
        $I->assertNotEquals(0, $affiliate->second_tier_affiliate_id);
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
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 30 * (3 / 100) );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 30 * (3 / 100) )  );
        
        $st = ($purchase->purchase_price - $purchase->processor_fee) *  ( Config::get('custom.earnings.second_tier_percentage') / 100 );   
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, $st );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 58,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $affiliate->second_tier_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => 2,
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
        $purchase = Purchase::orderBy('id','desc')->first();
        $I->assertNotEquals(false, $purchase->refund() );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 58,
            'product_id' => $course->id, 'status' => 'failed'] );
        $I->seeRecord('transactions', ['user_id' => $affiliate->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => 2,
            'product_id' => $course->id, 'status' => 'failed', 'is_second_tier' => 'yes', 'is_ltc' => 'no'] );
        $I->seeRecord('transactions', ['user_id' => 5, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->affiliate_earnings,
            'product_id' => $course->id, 'status' => 'failed'] );
        $I->seeRecord('transactions', ['user_id' => $purchase->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
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
        
        $I->dontSeeRecord( 'purchases',[ 'id' => $purchase->id ] );
        $I->seeRecord( 'purchase_refunds',[ 'purchase_id' => $purchase->id, 'instructor_id' => $purchase->instructor_id ] );
        
        $student = Student::where('username','sorin')->first();
        $affiliate = ProductAffiliate::find(5);
        $ltc = ProductAffiliate::find(2);
        $instructor = Instructor::find($course->instructor_id);
        $I->assertEquals( 10, $student->student_balance);
        $I->assertEquals( 0, $instructor->instructor_balance);
        $I->assertEquals( 0, $affiliate->affiliate_balance);
        $I->assertEquals( 0, $ltc->affiliate_balance);
    }
    
    public function purchaseThenRefundWithBalanceSecondTierInstructor(UnitTester $I){
        
        $student = Student::where('username','sorin')->first();
        $student->student_balance = 10;
        $student->ltc_affiliate_id = 2;
        $student->created_at = date('Y-m-d H:i:s');
        $student->updateUniques();
        $I->assertEquals(10, $student->student_balance);
                
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 10;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course = Course::first();
        
        $course->instructor->instructor_agency_id = null;
        $course->instructor->second_tier_instructor_id = 14;
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
        $affiliate->ltc_affiliate_id = 2;
        $affiliate->updateUniques();
        $ltc = ProductAffiliate::find(2);
        $ltc->affiliate_balance = 0;
        $ltc->has_ltc = 'yes';
        $ltc->updateUniques();
        
        $stInstructor = User::find(14);
        $stInstructor->is_second_tier_instructor = 'yes';
        $stInstructor->sti_approved = 'yes';
        $stInstructor->updateUniques();
        
        
        $I->assertEquals(0, $course->instructor->instructor_balance);
        $I->assertEquals(0, $affiliate->affiliate_balance);
        $I->assertEquals(0, $ltc->affiliate_balance);
        $I->assertEquals(0, $stInstructor->instructor_balance);
        
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
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 30 * (3 / 100) );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 30 * .02 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 30 * (3 / 100) ) - (30 * .02)  );
        
        $st = ($purchase->purchase_price - $purchase->processor_fee) *  ( Config::get('custom.earnings.second_tier_percentage') / 100 );        
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, $st );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 58,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 14, 'transaction_type' => 'second_tier_instructor_credit',
            'amount' => $purchase->second_tier_instructor_earnings, 'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $affiliate->second_tier_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => 2,
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
        $purchase = Purchase::orderBy('id','desc')->first();
        $I->assertNotEquals(false, $purchase->refund() );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 58,
            'product_id' => $course->id, 'status' => 'failed'] );
        $I->seeRecord('transactions', ['user_id' => 14, 'transaction_type' => 'second_tier_instructor_credit', 
            'amount' => $purchase->second_tier_instructor_earnings, 'product_id' => $course->id, 'status' => 'failed'] );
        $I->seeRecord('transactions', ['user_id' => $affiliate->second_tier_affiliate_id, 'transaction_type' => 'affiliate_credit', 'amount' => 2,
            'product_id' => $course->id, 'status' => 'failed', 'is_second_tier' => 'yes', 'is_ltc' => 'no'] );
        $I->seeRecord('transactions', ['user_id' => 5, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->affiliate_earnings,
            'product_id' => $course->id, 'status' => 'failed'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'affiliate_credit', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'failed', 'is_ltc' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'failed', 'gc_fee' => 5] );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit_reverse', 'amount' => 58,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 14, 'transaction_type' => 'second_tier_instructor_credit_reverse',
            'amount' => $purchase->second_tier_instructor_earnings, 'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $affiliate->second_tier_affiliate_id, 'transaction_type' => 'affiliate_credit_reverse', 'amount' => 2,
            'product_id' => $course->id, 'status' => 'complete', 'is_second_tier' => 'yes', 'is_ltc' => 'no'] );
        $I->seeRecord('transactions', ['user_id' => 5, 'transaction_type' => 'affiliate_credit_reverse', 'amount' => $purchase->affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'affiliate_credit_reverse', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'is_ltc' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit_reverse', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
        
        $I->dontSeeRecord( 'purchases',[ 'id' => $purchase->id ] );
        $I->seeRecord( 'purchase_refunds',[ 'purchase_id' => $purchase->id ] );
        
        $student = Student::where('username','sorin')->first();
        $affiliate = ProductAffiliate::find(5);
        $ltc = ProductAffiliate::find(2);
        $instructor = Instructor::find($course->instructor_id);
        $stInstructor = User::find(14);
        $I->assertEquals( 10, $student->student_balance);
        $I->assertEquals( 0, $instructor->instructor_balance);
        $I->assertEquals( 0, $affiliate->affiliate_balance);
        $I->assertEquals( 0, $ltc->affiliate_balance);
        $I->assertEquals( 0, $stInstructor->instructor_balance);
        
        $sale = $purchase;
        $total = $sale->processor_fee + $sale->instructor_earnings + $sale->second_tier_instructor_earnings + $sale->affiliate_earnings + $sale->second_tier_affiliate_earnings
                        + $sale->ltc_affiliate_earnings + $sale->instructor_agency_earnings + $sale->site_earnings; 
        $I->assertEquals($purchase->purchase_price, $total);
    }
    
    
    public function purchaseThenRefundNoAffiliate(UnitTester $I){
        
        $student = Student::where('username','sorin')->first();
        $student->student_balance = 0;
        $student->ltc_affiliate_id = 2;
        $student->created_at = date('Y-m-d H:i:s');
        $student->updateUniques();
        $I->assertEquals(0, $student->student_balance);
                
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 0;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course = Course::first();
        
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
        $affiliate->ltc_affiliate_id = 2;
        $affiliate->second_tier_affiliate_id = 2;
        $affiliate->updateUniques();
        $ltc = ProductAffiliate::find(2);
        $ltc->affiliate_balance = 0;
        $ltc->has_ltc = 'yes';
        $ltc->updateUniques();
        
        
        $I->assertEquals(0, $course->instructor->instructor_balance);
        $I->assertEquals(0, $affiliate->affiliate_balance);
        $I->assertEquals(0, $ltc->affiliate_balance);
        
        $I->assertNotEquals( false, $student->purchase($course, null, $data) );
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
        $I->assertEquals( $purchase->instructor_earnings, 70);
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 30 * (3 / 100) );
        $I->assertEquals( $purchase->instructor_agency_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 30 * (3 / 100) )  );
        
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
        $purchase = Purchase::orderBy('id','desc')->first();
        $I->assertNotEquals(false, $purchase->refund() );
        
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
        
        $I->dontSeeRecord( 'purchases',[ 'id' => $purchase->id ] );
        $I->seeRecord( 'purchase_refunds',[ 'purchase_id' => $purchase->id ] );
        
        $student = Student::where('username','sorin')->first();
        $affiliate = ProductAffiliate::find(5);
        $ltc = ProductAffiliate::find(2);
        $instructor = Instructor::find($course->instructor_id);
        $I->assertEquals( 0, $student->student_balance);
        $I->assertEquals( 0, $instructor->instructor_balance);
        $I->assertEquals( 0, $affiliate->affiliate_balance);
        $I->assertEquals( 0, $ltc->affiliate_balance);
    }
 
    public function purchaseThenRefundWithBalanceAndInstructorAgencySecondTierInstructor(UnitTester $I){
        
        $student = Student::where('username','sorin')->first();
        $student->student_balance = 10;
        $student->ltc_affiliate_id = 2;
        $student->created_at = date('Y-m-d H:i:s');
        $student->updateUniques();
        $I->assertEquals(10, $student->student_balance);
                
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 10;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course = Course::first();
        
        $course->instructor->agency->agency_balance = 0;
        $course->instructor->agency->updateUniques();
        $course->instructor->second_tier_instructor_id = 14;
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
        $affiliate->second_tier_affiliate_id = 2;
        $affiliate->updateUniques();
        $ltc = ProductAffiliate::find(2);
        $ltc->affiliate_balance = 0;
        $ltc->has_ltc = 'yes';
        $ltc->updateUniques();
        
        $stInstructor = User::find(14);
        $stInstructor->is_second_tier_instructor = 'yes';
        $stInstructor->sti_approved = 'yes';
        $stInstructor->updateUniques();
        
        $I->assertEquals(0, $course->instructor->instructor_balance);
        $I->assertEquals(0, $affiliate->affiliate_balance);
        $I->assertEquals(0, $ltc->affiliate_balance);
        $I->assertEquals(0, $stInstructor->instructor_balance);
        
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
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 30 * (3 / 100) );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 30 * .02 );
        $I->assertEquals( $purchase->site_earnings, 30 - ( 30 * (3 / 100) ) - (30 * .02)  );
        
        $st = ($purchase->purchase_price - $purchase->processor_fee) *  ( Config::get('custom.earnings.second_tier_percentage') / 100 );        
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, $st );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 58,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 14, 'transaction_type' => 'second_tier_instructor_credit', 
            'amount' => $purchase->second_tier_instructor_earnings, 'product_id' => $course->id, 'status' => 'complete'] );
        
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
        $stInstructor = User::find(14);
        $I->assertEquals(0, $student->student_balance);
        
        $I->assertEquals($purchase->instructor_earnings, $course->instructor->instructor_balance);
        $I->assertEquals($purchase->second_tier_instructor_earnings, $stInstructor->instructor_balance);
        $I->assertEquals($purchase->affiliate_earnings, $affiliate->affiliate_balance);
        $I->assertEquals($purchase->ltc_affiliate_earnings + $purchase->second_tier_affiliate_earnings 
                + $purchase->site_earnings, $ltc->affiliate_balance);
        
        // refund the purchase
        $purchase = Purchase::orderBy('id','desc')->first();
        $I->assertNotEquals(false, $purchase->refund() );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 58,
            'product_id' => $course->id, 'status' => 'failed'] );
        $I->seeRecord('transactions', ['user_id' => $stInstructor->id, 'transaction_type' => 'second_tier_instructor_credit', 
            'amount' => $purchase->second_tier_instructor_earnings, 'product_id' => $course->id, 'status' => 'failed'] );
        
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
        $I->seeRecord('transactions', ['user_id' => $stInstructor->id, 'transaction_type' => 'second_tier_instructor_credit_reverse', 
            'amount' => $purchase->second_tier_instructor_earnings, 'product_id' => $course->id, 'status' => 'complete'] );
        
        $I->seeRecord('transactions', ['user_id' => $affiliate->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit_reverse', 'amount' => 2,
            'product_id' => $course->id, 'status' => 'complete', 'is_second_tier' => 'yes', 'is_ltc' => 'no'] );
        $I->seeRecord('transactions', ['user_id' => 5, 'transaction_type' => 'affiliate_credit_reverse', 'amount' => $purchase->affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'affiliate_credit_reverse', 'amount' => $purchase->ltc_affiliate_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'is_ltc' => 'yes'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit_reverse', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
        
        $I->dontSeeRecord( 'purchases',[ 'id' => $purchase->id ] );
        $I->seeRecord( 'purchase_refunds',[ 'purchase_id' => $purchase->id ] );
        
        $student = Student::where('username','sorin')->first();
        $affiliate = ProductAffiliate::find(5);
        $ltc = ProductAffiliate::find(2);
        $stInstructor = User::find(14);
        $instructor = Instructor::find($course->instructor_id);
        $I->assertEquals( 10, $student->student_balance);
        $I->assertEquals( 0, $instructor->instructor_balance);
        $I->assertEquals( 0, $affiliate->affiliate_balance);
        $I->assertEquals( 0, $ltc->affiliate_balance);
        $I->assertEquals( 0, $stInstructor->instructor_balance);
        
        $sale = $purchase;
        $total = $sale->processor_fee + $sale->instructor_earnings + $sale->second_tier_instructor_earnings + $sale->affiliate_earnings + $sale->second_tier_affiliate_earnings
                        + $sale->ltc_affiliate_earnings + $sale->instructor_agency_earnings + $sale->site_earnings; 
        $I->assertEquals($purchase->purchase_price, $total);
        
    }
    
    public function purchaseThenRefundNoBalanceSelfPromotion(UnitTester $I){
        
        $student = Student::where('username','sorin')->first();
        $student->student_balance = 0;
        $student->ltc_affiliate_id = null;
        $I->assertTrue( $student->updateUniques() );
        $I->assertEquals(0, $student->student_balance);
        $student = Student::where('username','sorin')->first();
                
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 0;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course = Course::first();
        
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
        
        $I->assertEquals(0, $course->instructor->instructor_balance);
        
        $I->assertNotEquals( false, $student->purchase($course, 'sp', $data) );
        $purchase = Purchase::orderBy('id','desc')->first();
        
        
        $I->assertLessThan( 1, $student->ltc_affiliate_id);
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->balance_used, 0 );
        $I->assertEquals( $purchase->balance_transaction_id, 0 );
        $I->assertEquals( $purchase->instructor_earnings, 80 );
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 20 );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 80,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
        
        $student = Student::where('username','sorin')->first();
        $I->assertEquals( 0, $student->student_balance);
       
        $I->assertEquals(0, $student->student_balance);
        $I->assertEquals($purchase->instructor_earnings, $course->instructor->instructor_balance);
        
        // refund the purchase
        $purchase = Purchase::orderBy('id','desc')->first();
        $I->assertNotEquals(false, $purchase->refund() );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit', 'amount' => 80,
            'product_id' => $course->id, 'status' => 'failed'] );
       
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'failed', 'gc_fee' => 5] );
        
        $I->seeRecord('transactions', ['user_id' => $course->instructor_id, 'transaction_type' => 'instructor_credit_reverse', 'amount' => 80,
            'product_id' => $course->id, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => 2, 'transaction_type' => 'site_credit_reverse', 'amount' => $purchase->site_earnings,
            'product_id' => $course->id, 'status' => 'complete', 'gc_fee' => 5] );
        
        $I->dontSeeRecord('transactions', [ 'transaction_type' => 'affiliate_credit_reverse', 'product_id' => $course->id, 'status' => 'complete'] );
        
        $I->dontSeeRecord( 'purchases',[ 'id' => $purchase->id ] );
        $I->seeRecord( 'purchase_refunds',[ 'purchase_id' => $purchase->id ] );
        
        $student = Student::where('username','sorin')->first();
        $instructor = Instructor::find($course->instructor_id);
        $I->assertEquals( 0, $student->student_balance);
        $I->assertEquals( 0, $instructor->instructor_balance);
    }
    
    
}