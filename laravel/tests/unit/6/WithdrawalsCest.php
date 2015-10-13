<?php
use \UnitTester;

class WithdrawalsCest{
    
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
    
    public function rejectInstructorCashout(UnitTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        Transaction::truncate();
        Transaction::unguard();
//        $t = date('Y-m-01', strtotime('-40 day') );
        $t = date('Y-m-01', strtotime('-1 day') );
        Transaction::create([ 'user_id' => $instructor->id, 'transaction_type' => 'instructor_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete', 'created_at' => $t ]);
        Transaction::create([ 'user_id' => $instructor->id, 'transaction_type' => 'instructor_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete', 'created_at' => $t ]);
        $instructor->instructor_balance = 100;
        $instructor->updateUniques();
        $I->assertEquals( 100, $instructor->instructor_balance );
        $amount = $instructor->instructor_balance - Config::get('custom.cashout.fee');
        
        Artisan::call( 'cocorium:instructor-cashout' );
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->assertEquals( 0, $instructor->instructor_balance );

        
        $I->seeRecord('transactions', ['user_id' => $instructor->id, 'transaction_type' => 'instructor_debit', 
            'amount' => $amount, 'status' => 'pending'] );
        $debits = '["1","2"]';
        $credit = Transaction::find(3);
        $I->assertEquals( $debits, $credit->debits );
        $I->seeRecord('transactions', ['user_id' => $instructor->id, 'transaction_type' => 'cashout_fee', 'amount' => Config::get('custom.cashout.fee'), 'status' => 'pending'] );
        
        $credits = $instructor->allTransactions()->where('transaction_type','instructor_credit')->get();
        foreach($credits as $credit){
            $I->assertNotNull($credit->cashed_out_on);
        }
        $credit = Transaction::find(3);
        $credit->reverseDebit();
        $credits = $instructor->allTransactions()->where('transaction_type','instructor_credit')->get();
        foreach($credits as $credit){
            $I->assertNull($credit->cashed_out_on);
        }
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->assertEquals( 100, $instructor->instructor_balance );
       
    }
    
    public function rejectInstructorCashoutWithSecondTier(UnitTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        Transaction::truncate();
        Transaction::unguard();
//        $t = date('Y-m-01', strtotime('-40 day') );
        $t = date('Y-m-01', strtotime('-1 day') );
        Transaction::create([ 'user_id' => $instructor->id, 'transaction_type' => 'instructor_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete', 'created_at' => $t ]);
        Transaction::create([ 'user_id' => $instructor->id, 'transaction_type' => 'second_tier_instructor_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete', 'created_at' => $t ]);
        $instructor->instructor_balance = 100;
        $instructor->updateUniques();
        $I->assertEquals( 100, $instructor->instructor_balance );
        $amount = $instructor->instructor_balance - Config::get('custom.cashout.fee');
        
        Artisan::call( 'cocorium:instructor-cashout' );
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->assertEquals( 0, $instructor->instructor_balance );

        
        $I->seeRecord('transactions', ['user_id' => $instructor->id, 'transaction_type' => 'instructor_debit', 
            'amount' => $amount, 'status' => 'pending'] );
        $debits = '["1","2"]';
        $credit = Transaction::find(3);
        $I->assertEquals( $debits, $credit->debits );
        $I->seeRecord('transactions', ['user_id' => $instructor->id, 'transaction_type' => 'cashout_fee', 'amount' => Config::get('custom.cashout.fee'), 'status' => 'pending'] );
        
        $credits = $instructor->allTransactions()->whereIn('transaction_type',['instructor_credit','second_tier_instructor_credit'])->get();
        foreach($credits as $credit){
            $I->assertNotNull($credit->cashed_out_on);
        }
        $credit = Transaction::find(3);
        $credit->reverseDebit();
        $credits = $instructor->allTransactions()->whereIn('transaction_type',['instructor_credit','second_tier_instructor_credit'])->get();
        foreach($credits as $credit){
            $I->assertNull($credit->cashed_out_on);
        }
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->assertEquals( 100, $instructor->instructor_balance );
       
    }
    

}