<?php
use \UnitTester;

class LTCAffiliateCest{
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
        LTCAffiliate::boot();
    }
    
    public function getAffiliated(UnitTester $I){
        $ltc = LTCAffiliate::find(2);
        $count =  User::where('ltc_affiliate_id', 2)->get()->count();
        $I->assertEquals($count, $ltc->affiliated->count());
    }
    
    public function getSales(UnitTester $I){
        $ltc = LTCAffiliate::find(2);
        $count = Purchase::where('ltc_affiliate_id', 2)->count();
        $I->assertEquals($count, $ltc->sales->count());
    }
    
}
