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
    
    public function getSales(UnitTester $I){
        $pa = ProductAffiliate::find(5);
        $sales = CoursePurchase::where('product_affiliate_id', 5)->count();
        $I->assertEquals($sales, $pa->sales->count());
    }
    
}
