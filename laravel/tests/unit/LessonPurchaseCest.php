<?php
use \UnitTester;

class LessonPurchaseCest{
    public function _before() {
        $this->setupDatabase();
    }

    private function setupDatabase() {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        LessonPurchase::boot();
    }
  
     public function purchase(UnitTester $I){
        $purchase = new LessonPurchase(['course_id' => 1, 'lesson_id' => 1, 'student_id' => 1]);
        $I->assertTrue( $purchase->save() );
    }
    
    public function failPurchaseBadCourse(UnitTester $I){
        $purchase = new LessonPurchase(['course_id' => 9999999999, 'lesson_id' => 1, 'student_id' => 1]);
        $I->assertFalse( $purchase->save() );
        
    }
    
    public function failPurchaseBadStudent(UnitTester $I){
        $purchase = new LessonPurchase(['course_id' => 1, 'lesson_id' => 1, 'student_id' => 99999999]);
        $I->assertFalse( $purchase->save() );
        
    }
    
    public function failPurchaseBadLesson(UnitTester $I){
        $purchase = new LessonPurchase(['course_id' => 1, 'lesson_id' => 999999999, 'student_id' => 1]);
        $I->assertFalse( $purchase->save() );
        
    }
    
    public function failPurchaseAlreadyPurchased(UnitTester $I){
        $purchase = new LessonPurchase(['course_id' => 1, 'lesson_id' => 1, 'student_id' => 1]);
        $I->assertTrue( $purchase->save() );
        $purchase = new LessonPurchase(['course_id' => 1, 'lesson_id' => 1, 'student_id' => 1]);
        $I->assertFalse( $purchase->save() );
    }
    
}
