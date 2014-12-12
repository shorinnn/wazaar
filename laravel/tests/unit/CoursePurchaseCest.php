<?php
use \UnitTester;

class CoursePurchaseCest{
    public function _before() {
        $this->setupDatabase();
    }

    private function setupDatabase() {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        CoursePurchase::boot();
    }
    
    public function getStudentID(UnitTester $I){
        $purchase = CoursePurchase::find(1);
        $I->assertEquals(3, $purchase->student->id);
    }
    
    public function getCourseID(UnitTester $I){
        $purchase = CoursePurchase::find(1);
        $I->assertEquals(6, $purchase->course->id);
    }
    
    public function getLTCAffiliateID(UnitTester $I){
        $purchase = CoursePurchase::find(1);
        $I->assertEquals(2, $purchase->ltcAffiliate->id);
    }
    
    public function getProductAffiliateID(UnitTester $I){
        $purchase = CoursePurchase::find(1);
        $I->assertEquals(5, $purchase->productAffiliate->id);
    }
    
}
