<?php
use \UnitTester;

class CashoutCest{
    
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
    
    public function instructorCashout(UnitTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        Transaction::truncate();
        Transaction::unguard();
        $t = date('Y-m-01', strtotime('-40 day') );
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
       
    }
    public function instructorWithSecondTierCashout(UnitTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        Transaction::truncate();
        Transaction::unguard();
        $t = date('Y-m-01', strtotime('-40 day') );
        Transaction::create([ 'user_id' => $instructor->id, 'transaction_type' => 'second_tier_instructor_credit', 'amount' => 50, 'product_id' => 1, 
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
        
        $credits = $instructor->allTransactions()->whereIn('transaction_type',['instructor_credit', 'second_tier_instructor_credit'])->get();
        foreach($credits as $credit){
            $I->assertNotNull($credit->cashed_out_on);
        }
       
    }
    
    public function instructorCashout2OutOf3(UnitTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        Transaction::truncate();
        Transaction::unguard();
        $t = date('Y-m-01', strtotime('-40 day') );
        Transaction::create([ 'user_id' => $instructor->id, 'transaction_type' => 'instructor_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete', 'created_at' => $t ]);
        Transaction::create([ 'user_id' => $instructor->id, 'transaction_type' => 'instructor_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete' ]);
        Transaction::create([ 'user_id' => $instructor->id, 'transaction_type' => 'instructor_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete', 'created_at' => $t ]);
        $instructor->instructor_balance = 150;
        $instructor->updateUniques();
        $I->assertEquals( 150, $instructor->instructor_balance );
        
        $amount = $instructor->instructor_balance - 50 - Config::get('custom.cashout.fee');
        
        Artisan::call( 'cocorium:instructor-cashout' );
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->assertEquals( 50, $instructor->instructor_balance );

        
        $I->seeRecord('transactions', ['user_id' => $instructor->id, 'transaction_type' => 'instructor_debit', 'amount' => $amount, 
            'status' => 'pending' ] );
        $debits = '["1","3"]';
        $credit = Transaction::find(4);
        $I->assertEquals( $debits, $credit->debits );
        $I->seeRecord('transactions', ['user_id' => $instructor->id, 'transaction_type' => 'cashout_fee', 'amount' => Config::get('custom.cashout.fee'), 'status' => 'pending'] );
        
        $I->assertEquals(2 , $instructor->allTransactions()->where('transaction_type','instructor_credit')->whereNotNull('cashed_out_on')->count() );
        $I->assertEquals(1 , $instructor->allTransactions()->where('transaction_type','instructor_credit')->whereNull('cashed_out_on')->count() );
    }
    
    public function instructorWithSecondTierCashout2OutOf3(UnitTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        Transaction::truncate();
        Transaction::unguard();
        $t = date('Y-m-01', strtotime('-40 day') );
        Transaction::create([ 'user_id' => $instructor->id, 'transaction_type' => 'instructor_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete', 'created_at' => $t ]);
        Transaction::create([ 'user_id' => $instructor->id, 'transaction_type' => 'instructor_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete' ]);
        Transaction::create([ 'user_id' => $instructor->id, 'transaction_type' => 'second_tier_instructor_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete', 'created_at' => $t ]);
        $instructor->instructor_balance = 150;
        $instructor->updateUniques();
        $I->assertEquals( 150, $instructor->instructor_balance );
        
        $amount = $instructor->instructor_balance - 50 - Config::get('custom.cashout.fee');
        
        Artisan::call( 'cocorium:instructor-cashout' );
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->assertEquals( 50, $instructor->instructor_balance );

        
        $I->seeRecord('transactions', ['user_id' => $instructor->id, 'transaction_type' => 'instructor_debit', 'amount' => $amount, 
            'status' => 'pending' ] );
        $debits = '["1","3"]';
        $credit = Transaction::find(4);
        $I->assertEquals( $debits, $credit->debits );
        $I->seeRecord('transactions', ['user_id' => $instructor->id, 'transaction_type' => 'cashout_fee', 'amount' => Config::get('custom.cashout.fee'), 'status' => 'pending'] );
        
        $I->assertEquals(2 , $instructor->allTransactions()->whereIn('transaction_type',['instructor_credit','second_tier_instructor_credit'])
                ->whereNotNull('cashed_out_on')->count() );
        $I->assertEquals(1 , $instructor->allTransactions()->whereIn('transaction_type',['instructor_credit','second_tier_instructor_credit'])
                ->whereNull('cashed_out_on')->count() );
    }
    
    public function noInstructorCashout(UnitTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        Transaction::truncate();
        Transaction::unguard();
        
        $t = date('Y-m-d', strtotime('-10 day') );
        
        Transaction::create([ 'user_id' => $instructor->id, 'transaction_type' => 'instructor_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete', 'created_at' => $t ]);
        Transaction::create([ 'user_id' => $instructor->id, 'transaction_type' => 'instructor_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete' ]);
        Transaction::create([ 'user_id' => $instructor->id, 'transaction_type' => 'instructor_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete' ]);
        $instructor->instructor_balance = 150;
        $instructor->updateUniques();
        $I->assertEquals( 150, $instructor->instructor_balance );
        
        Artisan::call( 'cocorium:instructor-cashout' );
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->assertEquals( 150, $instructor->instructor_balance );

        $I->dontSeeRecord('transactions', ['user_id' => $instructor->id, 'transaction_type' => 'instructor_debit'] );
        
        $I->assertEquals(3 , $instructor->allTransactions()->where('transaction_type','instructor_credit')->whereNull('cashed_out_on')->count() );
    }
    
    public function noInstructorSecondTierCashout(UnitTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        Transaction::truncate();
        Transaction::unguard();
        
        $t = date('Y-m-d', strtotime('-10 day') );
        
        Transaction::create([ 'user_id' => $instructor->id, 'transaction_type' => 'second_tier_instructor_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete', 'created_at' => $t ]);
        Transaction::create([ 'user_id' => $instructor->id, 'transaction_type' => 'second_tier_instructor_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete' ]);
        Transaction::create([ 'user_id' => $instructor->id, 'transaction_type' => 'second_tier_instructor_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete' ]);
        $instructor->instructor_balance = 150;
        $instructor->updateUniques();
        $I->assertEquals( 150, $instructor->instructor_balance );
        
        Artisan::call( 'cocorium:instructor-cashout' );
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->assertEquals( 150, $instructor->instructor_balance );

        $I->dontSeeRecord('transactions', ['user_id' => $instructor->id, 'transaction_type' => 'instructor_debit'] );
        
        $I->assertEquals(3 , $instructor->allTransactions()->whereIn('transaction_type',['instructor_credit','second_tier_instructor_credit'])
                ->whereNull('cashed_out_on')->count() );
    }
    
    
    public function instructorAgencyCashout(UnitTester $I){
        $agency = InstructorAgency::where('username', 'InstructorAgency1')->first();
        Transaction::truncate();
        Transaction::unguard();
        $t = date('Y-m-01', strtotime('-40 day') );
        Transaction::create([ 'user_id' => $agency->id, 'transaction_type' => 'instructor_agency_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete', 'created_at' => $t ]);
        Transaction::create([ 'user_id' => $agency->id, 'transaction_type' => 'instructor_agency_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete', 'created_at' => $t ]);
        $agency->agency_balance = 100;
        $agency->updateUniques();
        $I->assertEquals( 100, $agency->agency_balance );
        $amount = $agency->agency_balance - Config::get('custom.cashout.fee');
        
        Artisan::call( 'cocorium:instructor-agency-cashout' );
        $agency = InstructorAgency::where('username', 'InstructorAgency1')->first();
        $I->assertEquals( 0, $agency->agency_balance );

        
        $I->seeRecord('transactions', ['user_id' => $agency->id, 'transaction_type' => 'instructor_agency_debit', 'amount' => $amount, 
            'status' => 'pending'] );
        $debits = '["1","2"]';
        $credit = Transaction::find(3);
        $I->assertEquals( $debits, $credit->debits );
        $I->seeRecord('transactions', ['user_id' => $agency->id, 'transaction_type' => 'cashout_fee', 'amount' => Config::get('custom.cashout.fee'), 'status' => 'pending'] );
        
        $credits = $agency->allTransactions()->where('transaction_type','instructor_agency_credit')->get();
        foreach($credits as $credit){
            $I->assertNotNull($credit->cashed_out_on);
        }
       
    }
    
        public function instructorAgencyCashout2OutOf3(UnitTester $I){
        $agency = InstructorAgency::where('username', 'InstructorAgency1')->first();
        Transaction::truncate();
        Transaction::unguard();
        $t = date('Y-m-01', strtotime('-40 day') );
        Transaction::create([ 'user_id' => $agency->id, 'transaction_type' => 'instructor_agency_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete', 'created_at' => $t ]);
        Transaction::create([ 'user_id' => $agency->id, 'transaction_type' => 'instructor_agency_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete' ]);
        Transaction::create([ 'user_id' => $agency->id, 'transaction_type' => 'instructor_agency_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete', 'created_at' => $t ]);
        $agency->agency_balance = 150;
        $agency->updateUniques();
        $I->assertEquals( 150, $agency->agency_balance );
        
        $amount = $agency->agency_balance - 50 - Config::get('custom.cashout.fee');
        
        Artisan::call( 'cocorium:instructor-agency-cashout' );
        $agency = InstructorAgency::where('username', 'InstructorAgency1')->first();
        $I->assertEquals( 50, $agency->agency_balance );
        
        $I->seeRecord('transactions', ['user_id' => $agency->id, 'transaction_type' => 'instructor_agency_debit', 'amount' => $amount, 
            'status' => 'pending' ] );
        $debits = '["1","3"]';
        $credit = Transaction::find(4);
        $I->assertEquals( $debits, $credit->debits );
        $I->seeRecord('transactions', ['user_id' => $agency->id, 'transaction_type' => 'cashout_fee', 'amount' => Config::get('custom.cashout.fee'), 'status' => 'pending'] );
        
        $I->assertEquals(2 , $agency->allTransactions()->where('transaction_type','instructor_agency_credit')->whereNotNull('cashed_out_on')->count() );
        $I->assertEquals(1 , $agency->allTransactions()->where('transaction_type','instructor_agency_credit')->whereNull('cashed_out_on')->count() );
    }
    
    public function noInstructorAgencyCashout(UnitTester $I){
        $agency = InstructorAgency::where('username', 'InstructorAgency1')->first();
        Transaction::truncate();
        Transaction::unguard();
        
        $t = date('Y-m-d', strtotime('-10 day') );
        
        Transaction::create([ 'user_id' => $agency->id, 'transaction_type' => 'instructor_agency_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete', 'created_at' => $t ]);
        Transaction::create([ 'user_id' => $agency->id, 'transaction_type' => 'instructor_agency_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete' ]);
        Transaction::create([ 'user_id' => $agency->id, 'transaction_type' => 'instructor_agency_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete' ]);
        $agency->agency_balance = 150;
        $agency->updateUniques();
        $I->assertEquals( 150, $agency->agency_balance );
        
        Artisan::call( 'cocorium:instructor-agency-cashout' );
        $agency = InstructorAgency::where('username', 'InstructorAgency1')->first();
        $I->assertEquals( 150, $agency->agency_balance );

        $I->dontSeeRecord('transactions', ['user_id' => $agency->id, 'transaction_type' => 'instructor_agency_debit'] );
        
        $I->assertEquals(3 , $agency->allTransactions()->where('transaction_type','instructor_agency_credit')->whereNull('cashed_out_on')->count() );
    }

    public function affiliateCashout(UnitTester $I){
        $affiliate = LTCAffiliate::where('username', 'affiliate')->first();
        Transaction::truncate();
        Transaction::unguard();
        $t = date('Y-m-01', strtotime('-40 day') );
        Transaction::create([ 'user_id' => $affiliate->id, 'transaction_type' => 'affiliate_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete', 'created_at' => $t ]);
        Transaction::create([ 'user_id' => $affiliate->id, 'transaction_type' => 'affiliate_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete', 'created_at' => $t ]);
        $affiliate->affiliate_balance = 100;
        $affiliate->updateUniques();
        $I->assertEquals( 100, $affiliate->affiliate_balance );
        $amount = $affiliate->affiliate_balance - Config::get('custom.cashout.fee');
        
        Artisan::call( 'cocorium:affiliate-cashout' );
        $affiliate = LTCAffiliate::where('username', 'affiliate')->first();
        $I->assertEquals( 0, $affiliate->affiliate_balance );
        
        $I->seeRecord('transactions', ['user_id' => $affiliate->id, 'transaction_type' => 'affiliate_debit', 'amount' => $amount, 
            'status' => 'pending' ] );
        $debits = '["1","2"]';
        $credit = Transaction::find(3);
        $I->assertEquals( $debits, $credit->debits );
        $I->seeRecord('transactions', ['user_id' => $affiliate->id, 'transaction_type' => 'cashout_fee', 'amount' => Config::get('custom.cashout.fee'), 'status' => 'pending'] );
        
        $credits = $affiliate->allTransactions()->where('transaction_type','affiliate_credit')->get();
        foreach($credits as $credit){
            $I->assertNotNull($credit->cashed_out_on);
        }
       
    }
    
    public function affiliateCashout2OutOf3(UnitTester $I){
        $affiliate = LTCAffiliate::where('username', 'affiliate')->first();
        Transaction::truncate();
        Transaction::unguard();
        $t = date('Y-m-01', strtotime('-40 day') );
        Transaction::create([ 'user_id' => $affiliate->id, 'transaction_type' => 'affiliate_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete', 'created_at' => $t ]);
        Transaction::create([ 'user_id' => $affiliate->id, 'transaction_type' => 'affiliate_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete' ]);
        Transaction::create([ 'user_id' => $affiliate->id, 'transaction_type' => 'affiliate_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete', 'created_at' => $t ]);
        $affiliate->affiliate_balance = 150;
        $affiliate->updateUniques();
        $I->assertEquals( 150, $affiliate->affiliate_balance );
        
        $amount = $affiliate->affiliate_balance - 50 - Config::get('custom.cashout.fee');
        
        Artisan::call( 'cocorium:affiliate-cashout' );
        $affiliate = LTCAffiliate::where('username', 'affiliate')->first();
        $I->assertEquals( 50, $affiliate->affiliate_balance );

        $debits = json_encode( [1, 3] );
        $I->seeRecord('transactions', ['user_id' => $affiliate->id, 'transaction_type' => 'affiliate_debit', 'amount' => $amount, 
            'status' => 'pending'] );
        $debits = '["1","3"]';
        $credit = Transaction::find(4);
        $I->assertEquals( $debits, $credit->debits );
        $I->seeRecord('transactions', ['user_id' => $affiliate->id, 'transaction_type' => 'cashout_fee', 'amount' => Config::get('custom.cashout.fee'), 'status' => 'pending'] );
        
        $I->assertEquals(2 , $affiliate->allTransactions()->where('transaction_type','affiliate_credit')->whereNotNull('cashed_out_on')->count() );
        $I->assertEquals(1 , $affiliate->allTransactions()->where('transaction_type','affiliate_credit')->whereNull('cashed_out_on')->count() );
    }
    
    public function noAffiliateCashout(UnitTester $I){
        $affiliate = LTCAffiliate::where('username', 'affiliate')->first();
        Transaction::truncate();
        Transaction::unguard();
        
        $t = date('Y-m-d', strtotime('-10 day') );
        
        Transaction::create([ 'user_id' => $affiliate->id, 'transaction_type' => 'affiliate_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete', 'created_at' => $t ]);
        Transaction::create([ 'user_id' => $affiliate->id, 'transaction_type' => 'affiliate_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete' ]);
        Transaction::create([ 'user_id' => $affiliate->id, 'transaction_type' => 'affiliate_credit', 'amount' => 50, 'product_id' => 1, 
            'product_type' => 'Course', 'status' => 'complete' ]);
        $affiliate->affiliate_balance = 150;
        $affiliate->updateUniques();
        $I->assertEquals( 150, $affiliate->affiliate_balance );
        
        Artisan::call( 'cocorium:affiliate-cashout' );
        $affiliate = LTCAffiliate::where('username', 'affiliate')->first();
        $I->assertEquals( 150, $affiliate->affiliate_balance );

        $I->dontSeeRecord('transactions', ['user_id' => $affiliate->id, 'transaction_type' => 'affiliate_debit'] );
        
        $I->assertEquals(3 , $affiliate->allTransactions()->where('transaction_type','affiliate_credit')->whereNull('cashed_out_on')->count() );
    }

}