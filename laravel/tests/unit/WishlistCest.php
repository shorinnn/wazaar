<?php
use \UnitTester;

class WishlistItemCest{
    public function _before() {
        $this->setupDatabase();
    }

    private function setupDatabase() {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        WishlistItem::boot();
    }
    
    public function getWishlistItemCount(UnitTester $I){
        $student = Student::where('username','student')->first();
        $I->assertEquals(0, $student->wishlistItems->count());
    }
    
    public function addToWishlistItemOnce(UnitTester $I){
        $student = Student::where('username','student')->first();
        $course = Course::first();
        $item = new WishlistItem(); 
        $item->student_id = $student->id;
        $item->course_id = $course->id;
        $I->assertTrue( $item->save() );
        $student = Student::where('username','student')->first();
        $I->assertEquals(1, $student->wishlistItems->count());
    }
    
    
    
     public function failAddingToWishlistItemSameItemTwice(UnitTester $I){
        $student = Student::where('username','student')->first();
        $course = Course::first();
        $item = new WishlistItem(); 
        $item->student_id = $student->id;
        $item->course_id = $course->id;
        $I->assertTrue( $item->save() );
        $item = new WishlistItem(); 
        $item->student_id = $student->id;
        $item->course_id = $course->id;
        $I->assertFalse($item->save() );
        $student = Student::where('username','student')->first();
    }

     
        
}