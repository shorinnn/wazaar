<?php
use \UnitTester;

class InstructorTransactionsCest{
    
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
        DB::table('users')->update( ['instructor_balance' => 0] );
        Instructor::boot();
    }
    
    public function credit(UnitTester $I){
        $instructor = Instructor::find(4);
        $I->assertEquals( 0, $instructor->instructor_balance );
        $course = Course::first();
        $I->assertGreaterThan(0, $instructor->credit( 100, $course, 1 ) );
        $I->assertEquals( 100, $instructor->instructor_balance );
        
        $I->seeRecord('transactions', ['user_id' => $instructor->id, 'transaction_type' => 'instructor_credit', 'amount' => 100, 'gc_fee' => 0, 
            'product_id' => $course->id, 'product_type' => 'Course', 'status' => 'complete' ] );
    }
    
    public function failCreditBadAmount(UnitTester $I){
        $instructor = Instructor::find(4);
        $I->assertEquals( 0, $instructor->instructor_balance );
        $I->assertFalse( $instructor->credit( 'ad', Course::first(), 1 ) );
        $I->dontSeeRecord('transactions', ['user_id' => $instructor->id, 'transaction_type' => 'instructor_credit', 'gc_fee' => 0, 
            'details' => 'Instructor Credit Transaction', 'status' => 'complete' ] );
    }
    
        
    public function debit(UnitTester $I){
        $instructor = Instructor::find(4);
        $instructor->instructor_balance = 100;
        $instructor->updateUniques();
        $I->assertEquals( 100, $instructor->instructor_balance );
        $instructor->debit( 100, 'ref');
        $I->assertEquals( 0, $instructor->instructor_balance );
        $I->seeRecord('transactions', ['user_id' => $instructor->id, 'transaction_type' => 'instructor_debit', 
            'reference' => 'ref', 'status' => 'pending',  'amount' => 100  - Config::get('custom.cashout.fee') ] );
    }
    
    public function failDebitLowBalance(UnitTester $I){
        $instructor = Instructor::find(4);
        $I->assertFalse( $instructor->debit( 100, 'ref') );
        $I->assertEquals( 0, $instructor->student_balance );
        $I->dontSeeRecord('transactions', ['user_id' => $instructor->id, 'transaction_type' => 'instructor_debit', 
            'reference' => 'ref', 'status' => 'pending' ] );
    }
    
    
  
    
    
    
    
   
    
}
