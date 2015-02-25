<?php
use \UnitTester;

class LTCTransactionsCest{
    
    public function _before() {
        $this->setupDatabase();
    }

    private function setupDatabase() {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        LTCAffiliate::boot();
    }
    
    public function credit(UnitTester $I){
        $affiliate = LTCAffiliate::find(4);
        $I->assertEquals( 0, $affiliate->affiliate_balance );
        $course = Course::first();
        $I->assertGreaterThan(0, $affiliate->credit( 100, $course, 1 ) );
        $I->assertEquals( 100, $affiliate->affiliate_balance );
        
        $I->seeRecord('transactions', ['user_id' => $affiliate->id, 'transaction_type' => 'affiliate_credit', 'amount' => 100, 'gc_fee' => 0, 
            'product_id' => $course->id, 'product_type' => 'Course',
            'details' => 'Affiliate Credit Transaction For Order #1', 'status' => 'complete' ] );
    }
    
    public function failCreditBadAmount(UnitTester $I){
        $affiliate = LTCAffiliate::find(4);
        $I->assertEquals( 0, $affiliate->affiliate_balance );
        $I->assertFalse( $affiliate->credit( 'ad', Course::first(), 1 ) );
        $I->dontSeeRecord('transactions', ['user_id' => $affiliate->id, 'transaction_type' => 'affiliate_credit', 'gc_fee' => 0, 
            'details' => 'Affiliate Credit Transaction', 'status' => 'complete' ] );
    }
    
        
    public function debit(UnitTester $I){
        $affiliate = LTCAffiliate::find(4);
        $affiliate->affiliate_balance = 100;
        $affiliate->updateUniques();
        $I->assertEquals( 100, $affiliate->affiliate_balance );
        $affiliate->debit( 100, 'ref', 5 );
        $I->assertEquals( 0, $affiliate->affiliate_balance );
        $I->seeRecord('transactions', ['user_id' => $affiliate->id, 'transaction_type' => 'affiliate_debit', 
            'reference' => 'ref', 'status' => 'complete', 'gc_fee' => 5, 'amount' => 95 ] );
    }
    
    public function failDebitLowBalance(UnitTester $I){
        $affiliate = LTCAffiliate::find(4);
        $I->assertFalse( $affiliate->debit( 100, 'ref', 5) );
        $I->assertEquals( 0, $affiliate->student_balance );
        $I->dontSeeRecord('transactions', ['user_id' => $affiliate->id, 'transaction_type' => 'affiliate_debit', 
            'reference' => 'ref', 'status' => 'complete', 'gc_fee' => 5 ] );
    }
    
    
  
    
    
    
    
   
    
}
