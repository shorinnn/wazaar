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
        $I->assertGreaterThan( 0, $instructor->instructor_balance );
        $amount = $instructor->instructor_balance - Config::get('custom.cashout.fee');
        Artisan::call( 'cocorium:instructor-cashout' );
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->assertEquals( 0, $instructor->instructor_balance );

        $I->seeRecord('transactions', ['user_id' => $instructor->id, 'transaction_type' => 'instructor_debit', 'amount' => $amount, 'status' => 'pending'] );
        $I->seeRecord('transactions', ['user_id' => $instructor->id, 'transaction_type' => 'cashout_fee', 'amount' => Config::get('custom.cashout.fee'), 'status' => 'pending'] );
    }
    
    public function instructorAgencyCashout(UnitTester $I){
        $agency = InstructorAgency::where('username', 'InstructorAgency1')->first();
        $I->assertGreaterThan( 0, $agency->agency_balance );
        $amount = $agency->agency_balance - Config::get('custom.cashout.fee');
        Artisan::call( 'cocorium:instructor-agency-cashout' );
        $agency = InstructorAgency::where('username', 'InstructorAgency1')->first();
        $I->assertEquals( 0, $agency->agency_balance );

        $I->seeRecord('transactions', ['user_id' => $agency->id, 'transaction_type' => 'instructor_agency_debit', 'amount' => $amount, 'status' => 'pending'] );
        $I->seeRecord('transactions', ['user_id' => $agency->id, 'transaction_type' => 'cashout_fee', 'amount' => Config::get('custom.cashout.fee'), 'status' => 'pending'] );
    }
    
    public function affiliateCashout(UnitTester $I){
        $affiliate = LTCAffiliate::where('username', 'affiliate')->first();
        $I->assertGreaterThan( 0, $affiliate->affiliate_balance );
        $amount = $affiliate->affiliate_balance - Config::get('custom.cashout.fee');
        Artisan::call( 'cocorium:affiliate-cashout' );
        $affiliate = LTCAffiliate::where('username', 'affiliate')->first();
        $I->assertEquals( 0, $affiliate->affiliate_balance );

        $I->seeRecord('transactions', ['user_id' => $affiliate->id, 'transaction_type' => 'affiliate_debit', 'amount' => $amount, 'status' => 'pending'] );
        $I->seeRecord('transactions', ['user_id' => $affiliate->id, 'transaction_type' => 'cashout_fee', 'amount' => Config::get('custom.cashout.fee'), 'status' => 'pending'] );
    }
}