<?php
//use \UnitTester;

class BasicOrderCest{
    
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
    
    public function basicPurchase(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student->ltc_affiliate_id = null;
        $student->updateUniques();
        DB::table('purchases')->delete();
        
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 0;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course = Course::first();
        
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
        $I->assertNotEquals( false, $student->purchase($course, null, $data) );
        
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( $course->instructor_id, $purchase->instructor_id);
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
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 0 );
        // no second tier aff, wazaar cut goes up to 30%
        $I->assertEquals( $purchase->site_earnings, 30 );
    }   
    
    public function basicPurchaseNoLTC(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student->ltc_affiliate_id = 0;
        $student->updateUniques();
        DB::table('purchases')->delete();
        
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 0;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course = Course::first();
        
        $I->assertEquals(105, $course->price);
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '0';
        $data['successData']['balance_transaction_id'] = '0';
        
        $I->assertEquals( 0, $student->ltc_affiliate_id );
        $I->assertLessThan( 1, $course->instructor->second_tier_instructor_id );
        $I->assertNotEquals( false, $student->purchase($course, null, $data) );
        
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( $course->instructor_id, $purchase->instructor_id);
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
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 0 );
        // no second tier aff, wazaar cut goes up to 30%
        $I->assertEquals( $purchase->site_earnings, 30 );
    }   
    
    public function basicPurchaseLTC(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student->updateUniques();
        DB::table('purchases')->delete();
        User::find(5)->update( ['is_vip' => 'no', 'has_ltc' => 'yes' ] );
        
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 0;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course = Course::first();
        
        $I->assertEquals(105, $course->price);
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '0';
        $data['successData']['balance_transaction_id'] = '0';
        
        $I->assertEquals( 5, $student->ltc_affiliate_id );
        $I->assertLessThan( 1, $course->instructor->second_tier_instructor_id );
        $I->assertNotEquals( false, $student->purchase($course, null, $data) );
        
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertLessThan( 1, $purchase->product_affiliate_id);
        $I->assertEquals( 5, $purchase->ltc_affiliate_id);
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
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 3 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 0 );
        // no second tier aff, wazaar cut goes up to 30%
        $I->assertEquals( $purchase->site_earnings, 30 - 3);
    }   
    
    public function basicPurchaseLTCVIP(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student->updateUniques();
        DB::table('purchases')->delete();
        User::find(5)->update( ['is_vip' => 'yes', 'has_ltc' => 'yes' ] );
        
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 0;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course = Course::first();
        User::find(5)->update( ['is_vip' => 'yes'] );
        $I->assertEquals(105, $course->price);
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '0';
        $data['successData']['balance_transaction_id'] = '0';
        
        $I->assertEquals( 5, $student->ltc_affiliate_id );
        $I->assertLessThan( 1, $course->instructor->second_tier_instructor_id );
        $I->assertNotEquals( false, $student->purchase($course, null, $data) );
        
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertLessThan( 1, $purchase->product_affiliate_id);
        $I->assertEquals( 5, $purchase->ltc_affiliate_id);
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
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 8 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 0 );
        // no second tier aff, wazaar cut goes up to 30%
        $I->assertEquals( $purchase->site_earnings, 30 - 8);
    }   
    
    public function basicPurchaseLTCSUPERVIP(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student->updateUniques();
        DB::table('purchases')->delete();
        
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 0;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course = Course::first();
        User::find(5)->update( ['is_super_vip' => 'yes', 'has_ltc' => 'yes'] );
        $I->assertEquals(105, $course->price);
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '0';
        $data['successData']['balance_transaction_id'] = '0';
        
        $I->assertEquals( 5, $student->ltc_affiliate_id );
        $I->assertLessThan( 1, $course->instructor->second_tier_instructor_id );
        $I->assertNotEquals( false, $student->purchase($course, null, $data) );
        
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertLessThan( 1, $purchase->product_affiliate_id);
        $I->assertEquals( 5, $purchase->ltc_affiliate_id);
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
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 8 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 0 );
        // no second tier aff, wazaar cut goes up to 30%
        $I->assertEquals( $purchase->site_earnings, 30 - 8);
    }   
    
    public function basicPurchaseProductAffiliate(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student->ltc_affiliate_id = null;
        $student->updateUniques();
        DB::table('purchases')->delete();
        
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 10;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course = Course::first();
        
        $I->assertEquals(105, $course->price);
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '0';
        $data['successData']['balance_transaction_id'] = '0';
        $affiliate = User::find(5);
        $affiliate->second_tier_affiliate_id = null;
        $affiliate->updateUniques();
        
        $I->assertLessThan( 1, $student->ltc_affiliate_id );
        $I->assertLessThan( 1, $course->instructor->second_tier_instructor_id );
        $I->assertNotEquals( false, $student->purchase($course, 5, $data) );
        
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( 5, $purchase->product_affiliate_id);
        $I->assertLessThan( 1, $purchase->ltc_affiliate_id);
        $I->assertLessThan( 1, $purchase->second_tier_affiliate_id);
        $I->assertLessThan( 1, $purchase->second_tier_instructor_id);
                
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->affiliate_earnings, 10 );
        $I->assertEquals( $purchase->instructor_earnings, 60 );     
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 0 );
        // no second tier aff, wazaar cut goes up to 30%
        $I->assertEquals( $purchase->site_earnings, 30 );
    }   
    
    public function basicPurchaseProductAffiliateAndSecondTier(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student->ltc_affiliate_id = null;
        $student->updateUniques();
        DB::table('purchases')->delete();
        
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 10;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course = Course::first();
        
        $I->assertEquals(105, $course->price);
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '0';
        $data['successData']['balance_transaction_id'] = '0';
        $affiliate = User::find(5);
        $affiliate->second_tier_affiliate_id = 2;
        $affiliate->updateUniques();
        
        $I->assertLessThan( 1, $student->ltc_affiliate_id );
        $I->assertLessThan( 1, $course->instructor->second_tier_instructor_id );
        $I->assertNotEquals( false, $student->purchase($course, 5, $data) );
        
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( 5, $purchase->product_affiliate_id);
        $I->assertLessThan( 1, $purchase->ltc_affiliate_id);
        $I->assertEquals( 2, $purchase->second_tier_affiliate_id);
        $I->assertLessThan( 1, $purchase->second_tier_instructor_id);
                
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->affiliate_earnings, 10 );
        $I->assertEquals( $purchase->instructor_earnings, 58);     
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 100 * 0.02  );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 30);
        
    }   
    
    public function basicPurchaseSecondTierInstructor(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student->ltc_affiliate_id = null;
        $student->updateUniques();
        DB::table('purchases')->delete();
        
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 0;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        
        $sti = User::find(2);
        $sti->sti_approved = 'yes';
        $sti->updateUniques();
        
        $course->instructor->second_tier_instructor_id = 2;
        $course->instructor->updateUniques();
        $course = Course::first();
        
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
        $I->assertEquals( 2, $course->instructor->second_tier_instructor_id );
        $I->assertNotEquals( false, $student->purchase($course, null, $data) );
        
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertLessThan( 1, $purchase->product_affiliate_id);
        $I->assertLessThan( 1, $purchase->ltc_affiliate_id);
        $I->assertLessThan( 1, $purchase->second_tier_affiliate_id);
        $I->assertEquals( 2, $purchase->second_tier_instructor_id);
                
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->instructor_earnings, 70 );     
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 2 );
        // no second tier aff, wazaar cut goes up to 30%
        $I->assertEquals( $purchase->site_earnings, 30 - 2 );
    }  
    
    public function purchaseWithEverything(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student->ltc_affiliate_id = 2;
        $student->updateUniques();
        DB::table('purchases')->delete();
        
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 10;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $aff = User::find(5);
        $aff->second_tier_affiliate_id = 2;
        $aff->updateUniques();
        
        $sti = User::find(2);
        $sti->sti_approved = 'yes';
        $sti->updateUniques();
        
        $course->instructor->second_tier_instructor_id = 2;
        $course->instructor->updateUniques();
        $course = Course::first();
        
        $I->assertEquals(105, $course->price);
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '0';
        $data['successData']['balance_transaction_id'] = '0';
        
        $I->assertEquals( 2, $student->ltc_affiliate_id );
        $I->assertEquals( 2, $course->instructor->second_tier_instructor_id );
        $I->assertNotEquals( false, $student->purchase($course, 5, $data) );
        
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( 5, $purchase->product_affiliate_id);
        $I->assertEquals( 2, $purchase->ltc_affiliate_id);
        $I->assertEquals( 2, $purchase->second_tier_affiliate_id);
        $I->assertEquals( 2, $purchase->second_tier_instructor_id);
                
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->instructor_earnings, 58 );     
        $I->assertEquals( $purchase->affiliate_earnings, 10 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 3 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 2 );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 2 );
        $I->assertEquals( $purchase->site_earnings, 30 - 2 - 3 );
        $sale = $purchase;
        $total = $sale->processor_fee + $sale->instructor_earnings + $sale->second_tier_instructor_earnings + $sale->affiliate_earnings + $sale->second_tier_affiliate_earnings
                        + $sale->ltc_affiliate_earnings + $sale->instructor_agency_earnings + $sale->site_earnings; 
        $I->assertEquals($purchase->purchase_price, $total);
    }   
    
    public function purchaseWithEverythingInstructorZeroPercent(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student->ltc_affiliate_id = 2;
        $student->updateUniques();
        DB::table('purchases')->delete();
        
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 68;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $aff = User::find(5);
        $aff->second_tier_affiliate_id = 2;
        $aff->updateUniques();
        
        $sti = User::find(2);
        $sti->sti_approved = 'yes';
        $sti->updateUniques();
        
        $course->instructor->second_tier_instructor_id = 2;
        $course->instructor->updateUniques();
        $course = Course::first();
        
        $I->assertEquals(105, $course->price);
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '0';
        $data['successData']['balance_transaction_id'] = '0';
        
        $I->assertEquals( 2, $student->ltc_affiliate_id );
        $I->assertEquals( 2, $course->instructor->second_tier_instructor_id );
        $I->assertNotEquals( false, $student->purchase($course, 5, $data) );
        
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertEquals( 5, $purchase->product_affiliate_id);
        $I->assertEquals( 2, $purchase->ltc_affiliate_id);
        $I->assertEquals( 2, $purchase->second_tier_affiliate_id);
        $I->assertEquals( 2, $purchase->second_tier_instructor_id);
                
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->affiliate_earnings, 68 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 2 );
        $I->assertEquals( $purchase->instructor_earnings, 0 );     
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 3 );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 2 );
        $I->assertEquals( $purchase->site_earnings, 30 - 2 - 3 );
    }   
    
    public function selfPromoting(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student->ltc_affiliate_id = null;
        $student->updateUniques();
        DB::table('purchases')->delete();
        
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 0;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        
        $course->instructor->second_tier_instructor_id = null;
        $course->instructor->updateUniques();
        
        $course = Course::first();
        
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
        $I->assertEquals( null, $course->instructor->second_tier_instructor_id );
        $I->assertNotEquals( false, $student->purchase($course, 'sp', $data) );
        
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
        $I->assertEquals( $purchase->instructor_earnings, 80 );     
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 20 );
    }
    
    public function selfPromotingWithLTC(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student->ltc_affiliate_id = 2;
        $student->updateUniques();
        DB::table('purchases')->delete();
        
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 0;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        
        $course->instructor->second_tier_instructor_id = null;
        $course->instructor->updateUniques();
        
        $course = Course::first();
        
        $I->assertEquals(105, $course->price);
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '0';
        $data['successData']['balance_transaction_id'] = '0';
        
        $I->assertEquals( 2, $student->ltc_affiliate_id );
        $I->assertEquals( null, $course->instructor->second_tier_instructor_id );
        $I->assertNotEquals( false, $student->purchase($course, 'sp', $data) );
        
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
        $I->assertEquals( $purchase->instructor_earnings, 80 );     
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 3);
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 0 );
        $I->assertEquals( $purchase->site_earnings, 20 - 3 );
    }
    
    public function selfPromotingWithLTCAndSTInstructor(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student->ltc_affiliate_id = 2;
        $student->updateUniques();
        DB::table('purchases')->delete();
        
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 0;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        
        $course->instructor->second_tier_instructor_id = 14;
        $course->instructor->updateUniques();
        
        $course->instructor->secondTierInstructor->sti_approved = 'yes';
        $course->instructor->secondTierInstructor->updateUniques();
        
        $course = Course::first();
        
        $I->assertEquals(105, $course->price);
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '0';
        $data['successData']['balance_transaction_id'] = '0';
        
        $I->assertEquals( 2, $student->ltc_affiliate_id );
        $I->assertEquals( 14, $course->instructor->second_tier_instructor_id );
        $I->assertNotEquals( false, $student->purchase($course, 'sp', $data) );
        
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertLessThan( 1, $purchase->product_affiliate_id);
        $I->assertEquals( 2, $purchase->ltc_affiliate_id);
        $I->assertLessThan( 1, $purchase->second_tier_affiliate_id);
        $I->assertEquals( 14, $purchase->second_tier_instructor_id);
                
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 105 );
        $I->assertEquals( $purchase->discount_value, 0 );
        $I->assertEquals( $purchase->discount, null );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->instructor_earnings, 80 );     
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 3 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 2 );
        $I->assertEquals( $purchase->site_earnings, 20 - 3 - 2 );
    }
    
    public function selfPromotingWithLTCAndSTInstructorAndDiscount(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student->ltc_affiliate_id = 2;
        $student->updateUniques();
        DB::table('purchases')->delete();
        
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 0;
        $course->sale = 500;
        $course->sale_kind = 'amount';
        $course->sale_starts_on = date('Y-m-d H:i:s', time() - 3600);
        $course->sale_ends_on = date('Y-m-d H:i:s', time() + 3600);
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '110', 'sale' => 5]);
        
        $course->instructor->second_tier_instructor_id = 14;
        $course->instructor->updateUniques();
        
        $course->instructor->secondTierInstructor->sti_approved = 'yes';
        $course->instructor->secondTierInstructor->updateUniques();
        
        $course = Course::first();
        
        $I->assertEquals(110, $course->price);
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '0';
        $data['successData']['balance_transaction_id'] = '0';
        
        $I->assertEquals( 2, $student->ltc_affiliate_id );
        $I->assertEquals( 14, $course->instructor->second_tier_instructor_id );
        $I->assertNotEquals( false, $student->purchase($course, 'sp', $data) );
        
        $purchase = Purchase::orderBy('id','desc')->first();
        
        $I->assertLessThan( 1, $purchase->product_affiliate_id);
        $I->assertEquals( 2, $purchase->ltc_affiliate_id);
        $I->assertLessThan( 1, $purchase->second_tier_affiliate_id);
        $I->assertEquals( 14, $purchase->second_tier_instructor_id);
                
        $I->assertEquals( $purchase->purchase_price, 105 );
        $I->assertEquals( $purchase->original_price, 110 );
        $I->assertEquals( $purchase->discount_value, 5 );
        $I->assertEquals( $purchase->processor_fee, 5 );
        $I->assertEquals( $purchase->tax, 10 );
        $I->assertEquals( $purchase->instructor_earnings, 80 );     
        $I->assertEquals( $purchase->affiliate_earnings, 0 );
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 3 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 2 );
        $I->assertEquals( $purchase->site_earnings, 20 - 3 - 2 );
    }
    
    public function LTCStaysTheSameEvenIfMoreThan30Days(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student->ltc_affiliate_id = 2;
        $student->created_at = '2010-01-01 10:10:10';
        $I->assertTrue( $student->updateUniques() );
        DB::table('purchases')->delete();
        
        $course = Course::first();
        $course->price = 1050;
        $course->affiliate_percentage = 0;
        $course->updateUniques();
        DB::table('courses')->where('id', $course->id)->update(['price' => '105']);
        $course = Course::first();
        
        $I->assertEquals(105, $course->price);
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['giftID'] = null;
        $data['successData']['ORDERID'] = 1;
        $data['successData']['balance_used'] = '0';
        $data['successData']['balance_transaction_id'] = '0';
        
        $I->assertEquals( 2, $student->ltc_affiliate_id );
        $I->assertLessThan( 1, $course->instructor->second_tier_instructor_id );
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
        $I->assertEquals( $purchase->ltc_affiliate_earnings, 3 );
        $I->assertEquals( $purchase->second_tier_affiliate_earnings, 0 );
        $I->assertEquals( $purchase->second_tier_instructor_earnings, 0 );
        // no second tier aff, wazaar cut goes up to 30%
        $I->assertEquals( $purchase->site_earnings, 30 - 3 );
        
        $student = Student::where('username','student')->first();
        $I->assertEquals( 2, $student->ltc_affiliate_id);
    }

    
}