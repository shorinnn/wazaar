<?php
use \UnitTester;

class PurchaseCest{
    public function _before() {
        $this->setupDatabase();
    }

    private function setupDatabase() {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        Purchase::boot();
    }
    
    public function getStudentID(UnitTester $I){
        $purchase = Purchase::find(1);
        $I->assertEquals(3, $purchase->student->id);
    }
    
    public function getCourseID(UnitTester $I){
        $purchase = Purchase::find(1);
        $I->assertEquals(6, $purchase->product->id);
    }
    
    public function getLessonID(UnitTester $I){
        $purchase = Purchase::find(5);
        $I->assertEquals(10, $purchase->product->id);
    }
    
    
    public function getLTCAffiliateID(UnitTester $I){
        $purchase = Purchase::find(1);
        $I->assertEquals(2, $purchase->ltcAffiliate->id);
    }
    
    public function getProductAffiliateID(UnitTester $I){
        $purchase = Purchase::find(1);
        $I->assertEquals(5, $purchase->productAffiliate->id);
    }
    
    public function purchaseCourse(UnitTester $I){
        $purchase = new Purchase(['product_type' => 'Course', 'product_id' => 1, 'student_id' => 1]);
        $I->assertTrue( $purchase->save() );
    }
    
    public function purchaseLesson(UnitTester $I){
        $purchase = new Purchase(['product_type' => 'Lesson', 'product_id' => 10, 'student_id' => 1]);
        $I->assertTrue( $purchase->save() );
    }
    
    public function failPurchaseBadCourse(UnitTester $I){
        $purchase = new Purchase(['product_type' => 'Course', 'product_id' => 9999999999, 'student_id' => 1]);
        $I->assertFalse( $purchase->save() );
        
    }
    
    public function failPurchaseBadLesson(UnitTester $I){
        $purchase = new Purchase(['product_type' => 'Lesson', 'product_id' => 9999999999, 'student_id' => 1]);
        $I->assertFalse( $purchase->save() );
        
    }
    public function failPurchaseBadStudent(UnitTester $I){
        $purchase = new Purchase(['product_type' => 'Course', 'product_id' => 1, 'student_id' => 99999999]);
        $I->assertFalse( $purchase->save() );
        
    }
    
    public function failPurchaseCourseAlreadyPurchased(UnitTester $I){
        $purchase = new Purchase(['product_type' => 'Course', 'product_id' => 1, 'student_id' => 1]);
        $I->assertTrue( $purchase->save() );
        $purchase = new Purchase(['product_type' => 'Course', 'product_id' => 1, 'student_id' => 1]);
        $I->assertFalse( $purchase->save() );
    }
    
    public function failPurchaseLessonAlreadyPurchased(UnitTester $I){
        $purchase = new Purchase(['product_type' => 'Lesson', 'product_id' => 10, 'student_id' => 1]);
        $I->assertTrue( $purchase->save() );
        $purchase = new Purchase(['product_type' => 'Lesson', 'product_id' => 10, 'student_id' => 1]);
        $I->assertFalse( $purchase->save() );
    }
    
    public function failPurchaseLessonAlreadyPurchasedCourse(UnitTester $I){
        $course = Course::find(5);
        $student = Student::find(9);
        $I->assertTrue( $student->purchased( $course ) );
        $lesson = Lesson::find(10);
        $I->assertFalse( $student->purchase($lesson) );
    }

}
