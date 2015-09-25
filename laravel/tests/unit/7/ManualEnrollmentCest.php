<?php

class ManualEnrollmentCest{
    
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
    }
    
    public function manualStudentCourseEnrollment(UnitTester $I)
    {
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();// delete purchases for this buyer
        $course = Course::first();
        $priceInput = 100;

        //Calculate sale
        $sale = $course->price - $priceInput;

        //Set sale amount
        $course->sale = $sale;
        $course->sale_starts_on = date('Y-m-d H:i:s', time()- 24 * 60 *60);
        $course->sale_ends_on = date('Y-m-d H:i:s', time()+ 24 * 60 *60);
        $course->approved_data = null;

        $I->assertGreaterThan(0, $course->price);
        $I->assertGreaterThan(0, $course->sale);
        //Dummy payment data
        $paymentData = [
            'successData' => [
                'balance_transaction_id' => 0,
                'processor_fee'          => 0,
                'tax'                    => 0,
                'giftID'                 => 0,
                'balance_used'           => 0,
                'REF'                    => Str::random(),
                'ORDERID'                => Str::random()
            ]
        ];

        //Do Purchase
        $purchase = $student->purchase( $course,null,$paymentData );

        $I->assertNotEquals( false, $purchase );
        $I->assertEquals( $sale, $purchase->discount_value );
        $I->assertEquals( $purchase->purchase_price, $priceInput );
        $I->assertEquals( $purchase->original_price, $course->price );
        
        $I->seeRecord('transactions',['purchase_id' => $purchase->id, 'user_id' => $course->instructor->id, 'transaction_type' => 'instructor_credit', 
            'amount' => $purchase->instructor_earnings]);
        $I->seeRecord('transactions',['purchase_id' => $purchase->id, 'user_id' => $purchase->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 
            'is_ltc' => 'yes', 'amount' => $purchase->ltc_affiliate_earnings]);
        
        $I->seeRecord('transactions',['purchase_id' => $purchase->id, 'user_id' => 2, 'transaction_type' => 'site_credit', 
            'amount' => $purchase->site_earnings]);

    }
    
    public function manualStudentCourseEnrollmentFailsSecondTime(UnitTester $I)
    {
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();// delete purchases for this buyer
        $course = Course::first();
        $priceInput = 100;

        //Calculate sale
        $sale = $course->price - $priceInput;

        //Set sale amount
        $course->sale = $sale;
        $course->sale_starts_on = date('Y-m-d H:i:s', time()- 24 * 60 *60);
        $course->sale_ends_on = date('Y-m-d H:i:s', time()+ 24 * 60 *60);
        $course->approved_data = null;

        $I->assertGreaterThan(0, $course->price);
        $I->assertGreaterThan(0, $course->sale);
        //Dummy payment data
        $paymentData = [
            'successData' => [
                'balance_transaction_id' => 0,
                'processor_fee'          => 0,
                'tax'                    => 0,
                'giftID'                 => 0,
                'balance_used'           => 0,
                'REF'                    => Str::random(),
                'ORDERID'                => Str::random()
            ]
        ];

        //Do Purchase
        $purchase = $student->purchase( $course,null,$paymentData );

        $I->assertNotEquals( false, $purchase );
        $I->assertEquals( $sale, $purchase->discount_value );
        $I->assertEquals( $purchase->purchase_price, $priceInput );
        $I->assertEquals( $purchase->original_price, $course->price );
        
        $I->seeRecord('transactions',['purchase_id' => $purchase->id, 'user_id' => $course->instructor->id, 'transaction_type' => 'instructor_credit', 
            'amount' => $purchase->instructor_earnings]);
        $I->seeRecord('transactions',['purchase_id' => $purchase->id, 'user_id' => $purchase->ltc_affiliate_id, 'transaction_type' => 'affiliate_credit', 
            'is_ltc' => 'yes', 'amount' => $purchase->ltc_affiliate_earnings]);
        
        $I->seeRecord('transactions',['purchase_id' => $purchase->id, 'user_id' => 2, 'transaction_type' => 'site_credit', 
            'amount' => $purchase->site_earnings]);
        
        $purchase = $student->purchase( $course,null,$paymentData );
        $I->assertFalse( $purchase );
        $I->assertEquals(1, Purchase::where('student_id', $student->id)->count() );

    }
 
}