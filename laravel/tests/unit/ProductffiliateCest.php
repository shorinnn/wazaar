<?php
use \UnitTester;

class ProductAffiliateCest{
    public function _before() {
        $this->setupDatabase();
    }

    private function setupDatabase() {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        ProductAffiliate::boot();
    }
    
    public function get2Sales(UnitTester $I){
        $pa = ProductAffiliate::find(5);
        $I->assertEquals(2, $pa->sales->count());
    }
    
}
