<?php
use \UnitTester;

class CourseCest{
    public function _before() {
        $this->setupDatabase();
    }

    private function setupDatabase() {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        Course::boot();
    }
    
    public function getInstructorInfo(UnitTester $I){
        $course = Course::find(1);
        $I->assertEquals('instructor', $course->instructor->username);
    }
    
    public function getCategoryInfo(UnitTester $I){
        $course = Course::find(1);
        $I->assertEquals('IT & Technology', $course->courseCategory->name);
    }
    
    public function failDuplicateSlug(UnitTester $I){
        $course = Course::find(1);
        $newCourse = new Course(['name' => 'New name', 'slug' => $course->slug,  'instructor_id' => 4, 'course_category_id' => 1, 'price' => 300000, 
                        'course_difficulty_id' => 1, 'description' => 'Test.', 'student_count' => 0 ]);
        $I->assertFalse( $newCourse->save() );
    }
    
    public function updateCourseDetails(UnitTester $I){
        $course = Course::find(1);
        $course->name = 'Updated!';
        $I->assertTrue( $course->updateUniques() );
    }
    
    public function failUpdateUsingTakenSlug(UnitTester $I){
        $course = Course::find(1);
        $course2 = Course::find(2);
        $course->slug = $course2->slug;
        $I->assertFalse( $course->updateUniques() );
    }
    
    public function updateSlug(UnitTester $I){
        $course = Course::find(1);
        $course->slug = 'updated-ok';
        $I->assertTrue( $course->updateUniques() );
    }
    
    public function failUsingBadFormatSlug(UnitTester $I){
        $course = Course::find(1);
        $course->slug = 'bad format slug/';
        $I->assertFalse( $course->updateUniques() );
    }
    
    public function failUpdatingSlugWithReservedWord(UnitTester $I){
        $course = Course::find(1);
        $course->slug = 'create';
        $I->assertFalse( $course->updateUniques() );
    }
    
    public function deleteCourse(UnitTester $I){
        $course = Course::find(1);
        $I->assertTrue( $course->delete() );
    }
    
    public function failDeletingCourseWithStudents(UnitTester $I){
        $course = Course::find(1);
        $course->student_count = 10;
        $I->assertFalse( $course->delete() );
        $I->assertEquals('Cannot delete this course because students have already purchased it', $course->errors()->first());
    }
    
}
