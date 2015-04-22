<?php 
use \FunctionalTester;

class WithdrawalsCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
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
    
    
    public function completeFirst(FunctionalTester $I){
        $transaction = new Transaction();
        $transaction->user_id = 4;
        $transaction->amount = 60;
        $transaction->purchase_id = 1;
        $transaction->product_id = 1;
        $transaction->product_type = 'Course';
        $transaction->transaction_type = 'instructor_credit';
        $transaction->details = trans('transactions.instructor_credit_reverse_transaction');
        $transaction->status = 'complete';
        $transaction->created_at = date('Y-m-d H:i:s', strtotime('-2 month'));
        $transaction->save();
        
        Artisan::call( 'cocorium:instructor-cashout' );
        $admin = User::first();
        $I->amLoggedAs( $admin );
        $I->seeRecord('transactions', ['transaction_type' => 'instructor_debit', 'status' => 'pending']);
        $I->dontSeeRecord('transactions', ['transaction_type' => 'instructor_debit', 'status' => 'complete']);
        
        $transaction = Transaction::where(['transaction_type' => 'instructor_debit', 'status' => 'pending'])->first();
        $I->amOnPage('administration/withdrawals');
        $I->checkOption( "[name='request[$transaction->id]']" );
        $I->fillField("[name='reference[$transaction->id]']", 1);
        $I->fillField("[name='action']", 'complete');
        $I->click('Complete Selected');
        
        $I->dontSeeRecord('transactions', ['id' => $transaction->id, 'transaction_type' => 'instructor_debit', 'status' => 'pending']);
        $I->seeRecord('transactions', ['id' => $transaction->id, 'transaction_type' => 'instructor_debit', 'status' => 'complete']);
    }
    
    public function rejectFirst(FunctionalTester $I){
        $transaction = new Transaction();
        $transaction->user_id = 4;
        $transaction->amount = 60;
        $transaction->purchase_id = 1;
        $transaction->product_id = 1;
        $transaction->product_type = 'Course';
        $transaction->transaction_type = 'instructor_credit';
        $transaction->details = trans('transactions.instructor_credit_reverse_transaction');
        $transaction->status = 'complete';
        $transaction->created_at = date('Y-m-d H:i:s', strtotime('-2 month'));
        $transaction->save();
        
        Artisan::call( 'cocorium:instructor-cashout' );
        $admin = User::first();
        $I->amLoggedAs( $admin );
        $I->seeRecord('transactions', ['transaction_type' => 'instructor_debit', 'status' => 'pending']);
        $I->dontSeeRecord('transactions', ['transaction_type' => 'instructor_debit', 'status' => 'failed']);
        
        $transaction = Transaction::where(['transaction_type' => 'instructor_debit', 'status' => 'pending'])->first();
        $I->amOnPage('administration/withdrawals');
        $I->checkOption( "[name='request[$transaction->id]']" );
        $I->fillField("[name='reference[$transaction->id]']", 1);
        $I->fillField("[name='action']", 'reject');
        $I->click('Complete Selected');
        
        $I->dontSeeRecord('transactions', ['id' => $transaction->id, 'transaction_type' => 'instructor_debit', 'status' => 'pending']);
        $I->seeRecord('transactions', ['id' => $transaction->id, 'transaction_type' => 'instructor_debit', 'status' => 'failed']);
    }
    
    public function completeTwo(FunctionalTester $I){
        $admin = User::first();
        $I->amLoggedAs( $admin );
        
        DB::table('transactions')->truncate();
        Transaction::unguard();
        $instructor = Instructor::where('username','instructor')->first();
        $t1 = new Transaction([ 'user_id'=>$instructor->id, 'transaction_type' => 'instructor_debit', 
            'status' => 'pending', 'amount' => 10, 'details' => 'test1']);
        $t1->save();
        $I->assertEquals(1, $t1->id);
        $t2 = new Transaction(['user_id' => $instructor->id, 'transaction_type' => 'instructor_debit', 
            'status' => 'pending', 'amount' => 10, 'details' => 'test2']);
        $t2->save();
        $I->assertEquals(2, $t2->id);
        
        $fee1 =  new Transaction([ 'user_id' => $instructor->id, 'transaction_type' => 'cashout_fee', 
            'status' => 'pending', 'amount' => 10, 'reference' => 'withdraw-1']);
        $I->assertTrue( $fee1->save() );
        
        $fee2 =  new Transaction([ 'user_id' => $instructor->id, 'transaction_type' => 'cashout_fee', 
            'status' => 'pending', 'amount' => 10, 'reference' => 'withdraw-2']);
        $I->assertTrue( $fee2->save() );
        
        $I->seeRecord('transactions', ['transaction_type' => 'instructor_debit', 'status' => 'pending', 'details' => 'test1']);
        $I->seeRecord('transactions', ['transaction_type' => 'instructor_debit', 'status' => 'pending', 'details' => 'test2']);
        $I->dontSeeRecord('transactions', ['transaction_type' => 'instructor_debit', 'status' => 'complete', 'details' => 'test1']);
        $I->dontSeeRecord('transactions', ['transaction_type' => 'instructor_debit', 'status' => 'complete', 'details' => 'test2']);
        
        $I->amOnPage('administration/withdrawals');
        
        $I->checkOption( "[name='request[1]']" );
        $I->checkOption( "[name='request[2]']" );
        $I->fillField("[name='reference[1]']", 1);
        $I->fillField("[name='reference[2]']", 2);
        $I->fillField("[name='action']", 'complete');
        
        $I->click('Complete Selected');
        
        $I->dontSeeRecord('transactions', ['transaction_type' => 'instructor_debit', 'status' => 'pending', 'details' => 'test1']);
        $I->seeRecord('transactions', ['transaction_type' => 'instructor_debit', 'status' => 'complete', 'details' => 'test1']);
        
        $I->dontSeeRecord('transactions', ['transaction_type' => 'instructor_debit', 'status' => 'pending', 'details' => 'test2']);
        $I->seeRecord('transactions', ['transaction_type' => 'instructor_debit', 'status' => 'complete', 'details' => 'test2']);

    }
    
    public function rejectTwo(FunctionalTester $I){
        $admin = User::first();
        $I->amLoggedAs( $admin );
        
        DB::table('transactions')->truncate();
        Transaction::unguard();
        $instructor = Instructor::where('username','instructor')->first();
        $t1 = new Transaction([ 'user_id'=>$instructor->id, 'transaction_type' => 'instructor_debit', 
            'status' => 'pending', 'amount' => 1, 'details' => 'test1']);
        $t1->save();
        $I->assertEquals(1, $t1->id);
        $t2 = new Transaction(['user_id' => $instructor->id, 'transaction_type' => 'instructor_debit', 
            'status' => 'pending', 'amount' => 2, 'details' => 'test2']);
        $t2->save();
        $I->assertEquals(2, $t2->id);
        
        $fee1 =  new Transaction([ 'user_id' => $instructor->id, 'transaction_type' => 'cashout_fee', 
            'status' => 'pending', 'amount' => 10, 'reference' => 'withdraw-1']);
        $I->assertTrue( $fee1->save() );
        
        $fee2 =  new Transaction([ 'user_id' => $instructor->id, 'transaction_type' => 'cashout_fee', 
            'status' => 'pending', 'amount' => 10, 'reference' => 'withdraw-2']);
        $I->assertTrue( $fee2->save() );
        
        $I->seeRecord('transactions', ['transaction_type' => 'instructor_debit', 'status' => 'pending', 'amount' => '1']);
        $I->seeRecord('transactions', ['transaction_type' => 'instructor_debit', 'status' => 'pending', 'amount' => '2']);
        $I->dontSeeRecord('transactions', ['transaction_type' => 'instructor_debit', 'status' => 'complete', 'amount' => '1']);
        $I->dontSeeRecord('transactions', ['transaction_type' => 'instructor_debit', 'status' => 'complete', 'amount' => '2']);
        
        $I->amOnPage('administration/withdrawals');
        
        $I->checkOption( "[name='request[1]']" );
        $I->checkOption( "[name='request[2]']" );
        $I->fillField("[name='reference[1]']", 1);
        $I->fillField("[name='reference[2]']", 2);
        $I->fillField("[name='action']", 'reject');
        
        $I->click('Complete Selected');
        
        $I->dontSeeRecord('transactions', ['transaction_type' => 'instructor_debit', 'status' => 'pending', 'amount' => '1']);
        $I->seeRecord('transactions', ['transaction_type' => 'instructor_debit', 'status' => 'failed', 'amount' => '1']);
        
        $I->dontSeeRecord('transactions', ['transaction_type' => 'instructor_debit', 'status' => 'pending', 'amount' => '2']);
        $I->seeRecord('transactions', ['transaction_type' => 'instructor_debit', 'status' => 'failed', 'amount' => '2']);
    }

    
    
}