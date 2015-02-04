<?php
use \UnitTester;

class InstructorCest{
    public function _before() {
        $this->setupDatabase();
    }

    private function setupDatabase() {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        Instructor::boot();
    }
    
    public function get13Courses(UnitTester $I){
        $instructor = Instructor::where('username','instructor')->first();
        $I->assertEquals(13, $instructor->courses->count());
    }
    
    public function getFirstCourseTitle(UnitTester $I){
        $instructor = Instructor::where('username','instructor')->first();
        $I->assertEquals('App Development', $instructor->courses->first()->name);
    }
    
    public function getFirstCourseSaleCount(UnitTester $I){
        $instructor = Instructor::where('username','instructor')->first();
        $sales = CoursePurchase::where('course_id', 6)->count();
        $I->assertEquals($sales, $instructor->courses->find(6)->sales->count());
    }
    
    public function buyCourse(UnitTester $I){
        $instructor = Student::where('username','second_instructor')->first();
        $I->assertTrue($instructor->hasRole('Instructor'));
        $course = Course::find(1);
        $I->assertNotEquals($course->instructor->id, $instructor->id);
        $instructor->purchase($course);
        $instructor = Student::where('username','second_instructor')->first();
        $I->assertTrue( $instructor->purchased($course) );
    }
    
    public function failbuyingOwnCourse(UnitTester $I){
        $instructor = Student::where('username','instructor')->first();
        $I->assertTrue($instructor->hasRole('Instructor'));
        $course = Course::find(1);
        $I->assertEquals($course->instructor->id, $instructor->id);
        $instructor->purchase($course);
        $instructor = Student::where('username','instructor')->first();
        $I->assertFalse( $instructor->purchased($course) );
    }
    
    
}
