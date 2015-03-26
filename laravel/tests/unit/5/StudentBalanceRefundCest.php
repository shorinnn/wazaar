<?php
use \UnitTester;

class StudentBalanceRefundCest{
    
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
    
    public function refund(UnitTester $I){
        $student = Student::where('username', 'student')->first();
        $transaction = new Transaction;
        $transaction->user_id = $student->id;
        $transaction->amount = 50;
        $transaction->transaction_type = 'student_balance_debit';
        $transaction->status = 'pending';
        $transaction->created_at = date( 'Y-m-d H:i:s', time() - 48 * 60 * 60 );
        $I->assertTrue( $transaction->save() );
        $I->dontSeeRecord('transactions', ['user_id' => $student->id, 'transaction_type' => 'student_balance_debit_refund', 
            'amount' => 50, 'status' => 'complete'] );
        Artisan::call( 'cocorium:student-balance-debit-refund' );
        
        $I->seeRecord('transactions', ['user_id' => $student->id, 'transaction_type' => 'student_balance_debit_refund', 
            'amount' => 50, 'status' => 'complete'] );
        $I->seeRecord('transactions', ['user_id' => $student->id, 'transaction_type' => 'student_balance_debit', 
            'amount' => 50, 'status' => 'failed'] );
    }
    
}