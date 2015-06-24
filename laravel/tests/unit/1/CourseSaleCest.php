<?php
use \UnitTester;

class CourseSaleCest{
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
        Course::boot();
    }
    public function discount100Yen(UnitTester $I){
        $course = Course::find(1);
        $course->price = 1000;
        $course->updateUniques();
        $I->assertEquals($course->price, $course->cost());
        $course->sale = 100;
        $course->sale_kind = 'amount';
        $course->sale_starts_on = date('Y-m-d H:i:s', time() );
        $course->sale_ends_on = date('Y-m-d H:i:s', time() + 3600);
        $I->assertTrue( $course->updateUniques() );
        $I->assertNotEquals($course->price, $course->cost());
        $I->assertEquals($course->price - 100, $course->cost());
        $I->assertEquals($course->price, $course->discount_original);
        $I->assertEquals(100, $course->discount_saved);
    }
    
    public function discount50Percent(UnitTester $I){
        $course = Course::find(1);
        $course->price = 1000;
        $course->updateUniques();
        $I->assertEquals($course->price, $course->cost());
        $course->sale = 50;
        $course->sale_kind = 'percentage';
        $course->sale_starts_on = date('Y-m-d H:i:s', time() );
        $course->sale_ends_on = date('Y-m-d H:i:s', time() + 3600);
        $I->assertTrue( $course->updateUniques() );
        
        $I->assertNotEquals($course->price, $course->cost());
        $I->assertEquals($course->price/2, $course->cost());
        $I->assertEquals($course->price, $course->discount_original);
        $I->assertEquals($course->price/2, $course->discount_saved);
    }
    
    public function failMoreThan100PercentSale(UnitTester $I){
        $course = Course::find(1);
        $I->assertEquals($course->price, $course->cost());
        $course->price = 100;
        $course->sale = 150;
        $course->sale_kind = 'percentage';
        $course->sale_ends_on = date('Y-m-d H:i:s', time() + 3600);
        $I->assertFalse( $course->updateUniques() );
        $course = Course::find(1);
        $I->assertNotEquals(150, $course->sale);
    }
    
    public function failMoreThanOriginalPriceSale(UnitTester $I){
        $course = Course::find(1);
        $I->assertEquals($course->price, $course->cost());
        $course->price = 100;
        $course->sale = 150;
        $course->sale_kind = 'amount';
        $course->sale_ends_on = date('Y-m-d H:i:s', time() + 3600);
        $I->assertFalse( $course->updateUniques() );
        $course = Course::find(1);
        $I->assertNotEquals(150, $course->sale);
    }
    
    public function failNegativeSale(UnitTester $I){
        $course = Course::find(1);
        $I->assertEquals($course->price, $course->cost());
        $course->price = 100;
        $course->sale = -5;
        $course->sale_kind = 'amount';
        $course->sale_ends_on = date('Y-m-d H:i:s', time() + 3600);
        $I->assertFalse( $course->updateUniques() );
    }
    
    public function failSaleNoStartDate(UnitTester $I){
        $course = Course::find(1);
        $I->assertEquals($course->price, $course->cost());
        $course->price = 100;
        $course->sale = 5;
        $course->sale_kind = 'amount';
        $course->sale_starts_on = date('Y-m-d H:i:s', time() + 3600);
        $I->assertFalse( $course->updateUniques() );
    }
    
    public function failSaleNoEndDate(UnitTester $I){
        $course = Course::find(1);
        $I->assertEquals($course->price, $course->cost());
        $course->price = 100;
        $course->sale = 5;
        $course->sale_kind = 'amount';
        $course->sale_ends_on = date('Y-m-d H:i:s', time() + 3600);
        $I->assertFalse( $course->updateUniques() );
    }
    
    public function failSaleEndBeforeStart(UnitTester $I){
        $course = Course::find(1);
        $I->assertEquals($course->price, $course->cost());
        $course->price = 100;
        $course->sale = 5;
        $course->sale_kind = 'amount';
        $course->sale_starts_on = date('Y-m-d H:i:s', time() + 3600);
        $course->sale_ends_on = date('Y-m-d H:i:s', time());
        $I->assertFalse( $course->updateUniques() );
    }
    
    public function passIsDiscounted(UnitTester $I){
        $course = Course::find(1);
        $course->price = 1000;
        $course->updateUniques();
        $I->assertEquals($course->price, $course->cost());
        $course->sale = 200;
        $course->sale_kind = 'amount';
        $course->sale_starts_on = date('Y-m-d H:i:s', time() );
        $course->sale_ends_on = date('Y-m-d H:i:s', time() + 3600);
        $I->assertTrue( $course->updateUniques() );
        $I->assertNotEquals($course->price, $course->cost());
        $I->assertEquals($course->price - 200, $course->cost());
        $I->assertEquals($course->price, $course->discount_original);
        $I->assertEquals(200, $course->discount_saved);
        
        $I->assertTrue( $course->isDiscounted() );
    }
    
    public function failIsDiscounted(UnitTester $I){
        $course = Course::find(1);
        $I->assertFalse( $course->isDiscounted() );
    }
    
    public function failIsDiscountedBadDate(UnitTester $I){
        $course = Course::find(1);
        $course->price = 1000;
        $course->updateUniques();
        $I->assertEquals($course->price, $course->cost());
        $course->sale = 500;
        $course->sale_kind = 'amount';
        $course->sale_starts_on = date('Y-m-d H:i:s', time() );
        $I->assertFalse( $course->updateUniques() );
        
        $I->assertFalse( $course->isDiscounted() );
    }
    
    public function failDiscountPriceTooLowPercentage(UnitTester $I){
        $course = Course::find(1);
        $I->assertFalse( $course->isDiscounted() );
        
        $course->price = 1000;
        $course->updateUniques();
        $I->assertEquals($course->price, $course->cost());
        $course->sale = 90;
        $course->sale_kind = 'percentage';
        $course->sale_starts_on = date('Y-m-d H:i:s', time() );
        $course->sale_ends_on = date('Y-m-d H:i:s', time() + 3600);
        $I->assertFalse( $course->updateUniques() );
        
        $course = Course::find(1);
        $I->assertFalse( $course->isDiscounted() );
    }
    
    public function failDiscountPriceTooLowAmount(UnitTester $I){
        $course = Course::find(1);
        $I->assertFalse( $course->isDiscounted() );
        
        $course->price = 1000;
        $course->updateUniques();
        $I->assertEquals($course->price, $course->cost());
        $course->sale = 600;
        $course->sale_kind = 'amount';
        $course->sale_starts_on = date('Y-m-d H:i:s', time() );
        $course->sale_ends_on = date('Y-m-d H:i:s', time() + 3600);
        $I->assertFalse( $course->updateUniques() );
        
        $course = Course::find(1);
        $I->assertFalse( $course->isDiscounted() );
    }
    
    public function roundSaleUp(UnitTester $I){
        $course = Course::find(1);
        $I->assertFalse( $course->isDiscounted() );
        
        $course->price = 1000;
        $course->updateUniques();
        $I->assertEquals($course->price, $course->cost());
        $course->sale = 281;
        $course->sale_kind = 'amount';
        $course->sale_starts_on = date('Y-m-d H:i:s', time() );
        $course->sale_ends_on = date('Y-m-d H:i:s', time() + 3600);
        $I->assertTrue( $course->updateUniques() );
        
        $course = Course::find(1);
        $I->assertEquals(300, $course->sale);
        $I->assertTrue( $course->isDiscounted() );
    }
    public function roundSaleDown(UnitTester $I){
        $course = Course::find(1);
        $I->assertFalse( $course->isDiscounted() );
        
        $course->price = 1000;
        $course->updateUniques();
        $I->assertEquals($course->price, $course->cost());
        $course->sale = 321;
        $course->sale_kind = 'amount';
        $course->sale_starts_on = date('Y-m-d H:i:s', time() );
        $course->sale_ends_on = date('Y-m-d H:i:s', time() + 3600);
        $I->assertTrue( $course->updateUniques() );
        
        $course = Course::find(1);
        $I->assertEquals(300, $course->sale);
        $I->assertTrue( $course->isDiscounted() );
        
    }
    public function notRoundSaleBecausePercentage(UnitTester $I){
        $course = Course::find(1);
        $I->assertFalse( $course->isDiscounted() );
        
        $course->price = 1000;
        $course->updateUniques();
        $I->assertEquals($course->price, $course->cost());
        $course->sale = 20;
        $course->sale_kind = 'percentage';
        $course->sale_starts_on = date('Y-m-d H:i:s', time() );
        $course->sale_ends_on = date('Y-m-d H:i:s', time() + 3600);
        $I->assertTrue( $course->updateUniques() );
        
        $course = Course::find(1);
        $I->assertEquals(20, $course->sale);
        $I->assertTrue( $course->isDiscounted() );
    }
    
    public function failTotalDiscountPercentageForPaidCourse(UnitTester $I){
        $course = Course::find(1);
        $I->assertFalse( $course->isDiscounted() );
        
        $course->price = 1000;
        $course->updateUniques();
        $I->assertEquals($course->price, $course->cost());
        $course->sale = 100;
        $course->sale_kind = 'percentage';
        $course->sale_starts_on = date('Y-m-d H:i:s', time() );
        $course->sale_ends_on = date('Y-m-d H:i:s', time() + 3600);
        $I->assertFalse( $course->updateUniques() );
        
        $course = Course::find(1);
        $I->assertFalse( $course->isDiscounted() );
    }
    
    public function failTotalDiscountAmountForPaidCourse(UnitTester $I){
        $course = Course::find(1);
        $I->assertFalse( $course->isDiscounted() );
        
        $course->price = 1000;
        $course->updateUniques();
        $I->assertEquals($course->price, $course->cost());
        $course->sale = 1000;
        $course->sale_kind = 'amount';
        $course->sale_starts_on = date('Y-m-d H:i:s', time() );
        $course->sale_ends_on = date('Y-m-d H:i:s', time() + 3600);
        $I->assertFalse( $course->updateUniques() );
        
        $course = Course::find(1);
        $I->assertFalse( $course->isDiscounted() );
    }
        
}