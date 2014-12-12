<?php
use \UnitTester;

class StudentCest{
    
    public function _before() {
        $this->setupDatabase();
    }

    private function setupDatabase() {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        Student::boot();
    }
    
    public function getLTCAffiliate(UnitTester $I){
        $student = Student::where('username','student')->first();
        $I->assertEquals(2, $student->ltcAffiliate->id);
    }
    
    public function get2productAffiliates(UnitTester $I){
        $student = Student::where('username','student')->first();
        $I->assertEquals(2, $student->productAffiliates->count());
    }
    
    public function get2Purchases(UnitTester $I){
        $student = Student::where('username','student')->first();
        $I->assertEquals(2, $student->purchases->count());
    }
    
    public function purchaseNewCourse(UnitTester $I){
        $student = Student::where('username','student')->first();
        $course = Course::find(1);
        $student->purchase($course);
        $student = Student::where('username','student')->first();
        $I->assertTrue( $student->purchased($course) );
        
    }
    
    public function denyDuplicatePurchases(UnitTester $I){
        $student = Student::where('username','student')->first();
        $course = Course::find(1);
        $student->purchase($course);
        $student = Student::where('username','student')->first();
        $I->assertTrue( $student->purchased($course) );
        $student = Student::where('username','student')->first();
        $I->assertFalse( $student->purchase($course) );
    }
    
    public function keepLTCAffiliate(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student->ltc_affiliate_id = 5;
        $student->save();
        $I->assertEquals(5, $student->ltc_affiliate_id);
        $course = Course::find(1);
        $student->purchase($course);
        $student = Student::where('username','student')->first();
        $I->assertTrue( $student->purchased($course) );
        $I->assertEquals(5, $student->ltc_affiliate_id);
    }
    
    public function defaultAffiliateToWazaar(UnitTester $I){
        $student = Student::where('username','mac')->first();
        $student->ltc_affiliate_id = 5;
        $student->created_at = '2012-12-12 18:57:26';
        $student->save();
        $I->assertEquals(5, $student->ltc_affiliate_id);
        $I->assertEquals(0, $student->purchases->count());
        $course = Course::find(1);
        $student->purchase($course);
        $student = Student::where('username','mac')->first();
        $I->assertTrue( $student->purchased($course) );
        $I->assertEquals(2, $student->ltc_affiliate_id);
    }
    
    public function storeProductAffiliate(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student->save();
        $course = Course::find(1);
        $student->purchase($course, 5);
        $student = Student::where('username','student')->first();
        $I->assertTrue( $student->purchased($course) );
        $I->assertEquals(2, $student->ltc_affiliate_id);
        $I->assertEquals(5, $student->purchases->last()->product_affiliate_id);
    }
    
}
