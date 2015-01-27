<?php
use \UnitTester;

class FollowerCest{
    public function _before() {
        $this->setupDatabase();
    }

    private function setupDatabase() {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        FollowRelationship::boot();
    }
    
    public function getFollowerCount(UnitTester $I){
        $instructor = Instructor::first();
        $I->assertEquals(0, $instructor->followers->count());
    }
    
    public function followInstructor(UnitTester $I){
        $instructor = Instructor::first();
        $student = Student::where('username','student')->first();
        $rel = new FollowRelationship;
        $rel->student_id = $student->id;
        $rel->instructor_id = $instructor->id;
        $I->assertTrue( $rel->save() );
        $instructor = Instructor::first();
        $I->assertEquals(1, $instructor->followers->count());
    }
    
    public function failFollowingTwice(UnitTester $I){
        $instructor = Instructor::first();
        $student = Student::where('username','student')->first();
        $rel = new FollowRelationStudent();
        $rel->student_id = $student->id;
        $rel->instructor_id = $instructor->id;
        $I->assertTrue( $rel->save() );
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->assertEquals(1, $instructor->followers->count());
        $rel = new FollowRelationship;
        $rel->student_id = $student->id;
        $rel->instructor_id = $instructor->id;
        $I->assertFalse( $rel->save() );
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->assertEquals(1, $instructor->followers->count());
    }
    
}