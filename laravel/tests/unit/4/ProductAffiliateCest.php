<?php
use \UnitTester;

class ProductAffiliateCest{
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
        ProductAffiliate::boot();
    }
    
    public function getSales(UnitTester $I){
        $pa = ProductAffiliate::find(5);
        $sales = Purchase::where('product_affiliate_id', 5)->count();
        $I->assertEquals($sales, $pa->sales->count());
    }
    
}
