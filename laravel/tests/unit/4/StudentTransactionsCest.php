<?php
use \UnitTester;

class StudentTransactionsCest{
    
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
    }
    
    public function credit(UnitTester $I){
        $student = Student::find(3);
        $I->assertEquals( 0, $student->student_balance );
        $student->credit( 100 );
        $I->assertEquals( 100, $student->student_balance );
        $I->seeRecord('transactions', ['user_id' => $student->id, 'transaction_type' => 'student_credit', 'amount' => 100, 'gc_fee' => 0, 
            'details' => 'Student Credit Transaction', 'status' => 'complete' ] );
    }
    
    public function failCreditBadAmount(UnitTester $I){
        $student = Student::find(3);
        $I->assertEquals( 0, $student->student_balance );
        $I->assertFalse( $student->credit( 'asd' ) );
        $I->assertEquals( 0, $student->student_balance );
        $I->dontSeeRecord('transactions', ['user_id' => $student->id, 'transaction_type' => 'student_credit', 'gc_fee' => 0, 
            'details' => 'Student Credit Transaction', 'status' => 'complete' ] );
    }
    
    public function balanceDebit(UnitTester $I){
        $student = Student::find(3);
        $student->student_balance = 100;

        $student->updateUniques();
        $I->assertEquals( 100, $student->student_balance );
        $I->assertGreaterThan(0, $student->balanceDebit( 90, Course::first() ) );
        $I->assertEquals( 10, $student->student_balance );
        $I->seeRecord('transactions', ['user_id' => $student->id, 'transaction_type' => 'student_balance_debit', 'amount' => 90, 'gc_fee' => 0, 
             'status' => 'pending' ] );
    }
    
    public function failBalanceDebitLowBalance(UnitTester $I){
        $student = Student::find(3);
        $student->student_balance = 100;
        $student->updateUniques();
        $I->assertEquals( 100, $student->student_balance );
        $I->assertFalse( $student->balanceDebit( 500, Course::first() ) );
        $I->assertEquals( 100, $student->student_balance );
        $I->dontSeeRecord('transactions', ['user_id' => $student->id, 'transaction_type' => 'student_balance_debit', 'amount' => 500, 'gc_fee' => 0, 
            'status' => 'pending' ] );
    }
    
    public function failBalanceBadItem(UnitTester $I){
        $student = Student::find(3);
        $student->student_balance = 100;
        $student->updateUniques();
        $I->assertEquals( 100, $student->student_balance );
        $I->assertFalse( $student->balanceDebit( 100, 'NotACourse' ) );
        $I->assertEquals( 100, $student->student_balance );
        $I->dontSeeRecord('transactions', ['user_id' => $student->id, 'transaction_type' => 'student_balance_debit', 'amount' => 500, 'gc_fee' => 0, 
             'status' => 'pending' ] );
    }
    
    public function debit(UnitTester $I){
        $student = Student::find(3);
        $student->debit( 100, Course::first(), '123', 'gc123', 5 );
        $I->seeRecord('transactions', ['user_id' => $student->id, 'transaction_type' => 'student_debit', 'amount' => 95, 'gc_fee' => 5,
            'details' => 'Student Debit Transaction For Order #123', 'reference' => 'gc123', 'status' => 'complete' ] );
    }
    
    public function failDebitBadItem(UnitTester $I){
        $student = Student::find(3);
        $student->debit( 100, 'notACourse', '123', 'gc123' );
        $I->dontSeeRecord('transactions', ['user_id' => $student->id, 'transaction_type' => 'student_debit', 'amount' => 100, 
            'details' => 'Student Debit Transaction For Order #123', 'reference' => 'gc123', 'status' => 'complete' ] );
    }
    
    public function refundBalanceDebit(UnitTester $I){
        $student = Student::find(3);
        $student->student_balance = 100;
        $student->updateUniques();
        $I->assertEquals( 100, $student->student_balance );
        $transaction = $student->balanceDebit( 90, Course::first() );
        $I->assertEquals( 10, $student->student_balance );
        $I->seeRecord('transactions', ['user_id' => $student->id, 'transaction_type' => 'student_balance_debit', 'amount' => 90, 'gc_fee' => 0, 
             'status' => 'pending' ] );
        
        $transaction = Transaction::find($transaction);
        $refund = $transaction->id + 1;
        
        $I ->assertGreaterThan( 0 , $student->refundBalanceDebit( $transaction ) );
        
        $I->seeRecord('transactions', ['user_id' => $student->id, 'transaction_type' => 'student_balance_debit', 'amount' => 90, 'gc_fee' => 0, 
             'status' => 'failed', 'details' => 'Refunded #'.$refund ] );
        
        $I->seeRecord('transactions', ['user_id' => $student->id, 'transaction_type' => 'student_balance_debit_refund', 'amount' => 90, 'gc_fee' => 0, 
             'status' => 'complete', 'details' => 'Student Balance Debit Transaction Failed #'.$transaction->id ] );
        $I->assertEquals( 100, $student->student_balance );
        
    }
    
    public function failRefundBalanceDebitBadObject(UnitTester $I){
        $student = Student::find(3);
        $student->student_balance = 100;
        $student->updateUniques();
        $I->assertFalse( $student->refundBalanceDebit('badTransaction') );
    }
    
    public function failRefundBalanceDebitWrongTransaction(UnitTester $I){
        $student = Student::find(3);
        $student->student_balance = 100;
        $student->updateUniques();
        $transaction = $student->balanceDebit( 90, Course::first() );
        $newUser = Student::find(4);
        $I->assertFalse( $newUser->refundBalanceDebit( $transaction ) );
    }
    
    public function failRefundBalanceDebitWrongTransactionType(UnitTester $I){
        $student = Student::find(3);
        $student->student_balance = 100;
        $student->updateUniques();
        $transaction = $student->debit( 100, Course::first(), '123', 'gc123' );
        $transaction = Transaction::find( $transaction );
        $I->assertFalse( $student->refundBalanceDebit( $transaction ) );
    }
    
    public function failRefundBalanceDebitBadTransactionObject(UnitTester $I){
        $student = Student::find(3);
        $student->student_balance = 100;
        $student->updateUniques();
        $I->assertFalse( $student->refundBalanceDebit('badTransaction') );
    }
    
    public function failRefundBalanceDebitAlreadyRefunded(UnitTester $I){
        $student = Student::find(3);
        $student->student_balance = 100;
        $student->updateUniques();
        $transaction = $student->balanceDebit( 90, Course::first() );
        $I->assertGreaterThan(0, $transaction);
        $transaction = Transaction::find( $transaction );
        $refund = $student->refundBalanceDebit( $transaction );
        $I->assertGreaterThan(0, $refund);
        $refund = Transaction::find( $refund );
        $I->assertFalse( $student->refundBalanceDebit($refund) );
    }
}
