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
    
//    public function getInstructorInfo(UnitTester $I){
//        $course = Course::find(1);
//        $I->assertEquals('instructor', $course->instructor->username);
//    }
//    
//    public function getCategoryInfo(UnitTester $I){
//        $course = Course::find(1);
//        $I->assertEquals('IT & Technology', $course->courseCategory->name);
//    }
//    
//    public function failDuplicateSlug(UnitTester $I){
//        $course = Course::find(1);
//        $newCourse = new Course(['name' => 'New name', 'slug' => $course->slug,  'instructor_id' => 4, 'course_category_id' => 1, 'price' => 300000, 
//                        'course_difficulty_id' => 1, 'description' => 'Test.', 'student_count' => 0 ]);
//        $I->assertFalse( $newCourse->save() );
//    }
//    
//    public function updateCourseDetails(UnitTester $I){
//        $course = Course::find(1);
//        $course->name = 'Updated!';
//        $I->assertTrue( $course->updateUniques() );
//    }
//    
//    public function failUpdateUsingTakenSlug(UnitTester $I){
//        $course = Course::find(1);
//        $course2 = Course::find(2);
//        $course->slug = $course2->slug;
//        $I->assertFalse( $course->updateUniques() );
//    }
//    
//    public function updateSlug(UnitTester $I){
//        $course = Course::find(1);
//        $course->slug = 'updated-ok';
//        $I->assertTrue( $course->updateUniques() );
//    }
//    
//    public function failUsingBadFormatSlug(UnitTester $I){
//        $course = Course::find(1);
//        $course->slug = 'bad format slug/';
//        $I->assertFalse( $course->updateUniques() );
//    }
//    
//    public function failUpdatingSlugWithReservedWord(UnitTester $I){
//        $course = Course::find(1);
//        $course->slug = 'create';
//        $I->assertFalse( $course->updateUniques() );
//    }
//    
//    public function deleteCourse(UnitTester $I){
//        $course = Course::find(1);
//        $I->assertTrue( $course->delete() );
//    }
//    
//    public function failDeletingCourseWithStudents(UnitTester $I){
//        $course = Course::find(1);
//        $course->student_count = 10;
//        $I->assertFalse( $course->delete() );
//        $I->assertEquals('Cannot delete this course because students have already purchased it', $course->errors()->first());
//    }
//    
//    public function createCourse(UnitTester $I){
//        $course = new Course();
//        $course->name = 'New App Development';
//        $course->slug = 'new-app-development';
//        $course->instructor_id = 4;
//        $course->course_category_id = 1;
//        $course->course_subcategory_id = 1;
//        $course->price = 300000;
//        $course->course_difficulty_id = 1;
//        $course->description = 'Create your very first application in 2 weeks! You get a beginner award after completing the course.';
//        $course->student_count =  0;
//        $I->assertTrue( $course->save() );
//    }
//    
//    public function failWrongSubcategory(UnitTester $I){
//        $course = new Course();
//        $course->name = 'New App Development';
//        $course->slug = 'new-app-development';
//        $course->instructor_id = 4;
//        $course->course_category_id = 1;
//        $course->course_subcategory_id = 2;
//        $course->price = 300000;
//        $course->course_difficulty_id = 1;
//        $course->description = 'Create your very first application in 2 weeks! You get a beginner award after completing the course.';
//        $course->student_count =  0;
//        $I->assertFalse( $course->save() );
//    }
//    
//    public function getNewCourseLessThan20Students(UnitTester $I){
//        $course = Course::find(1);
//        $I->assertLessThan(20, $course->student_count);
//        $I->assertTrue($course->isNew());
//    }
//    
//    public function getNewCourseLessThan6Months(UnitTester $I){
//        $course = Course::find(1);
//        $course->student_count = 33;
//        $I->assertTrue( $course->updateUniques() );
//        $creation_date = date_create($course->created_at);
//        $now = date_create();
//        $interval = (int)date_diff($creation_date, $now)->format('%m');
//        $I->assertLessThan(6, $interval);
//        $I->assertTrue($course->isNew());
//    }
//    
//    public function notGetNewCourseOlderThan6MonthsAndMoreThan20Students(UnitTester $I){
//        $course = Course::find(1);
//        $course->student_count = 33;
//        $d = date('Y-m-d H:i:s', strtotime('6 month ago') );
//        $course->created_at = $d;
//        $I->assertTrue( $course->updateUniques() );
//        $creation_date = date_create($course->created_at);
//        $now = date_create();
//        $interval = (int)date_diff($creation_date, $now)->format('%m');
//        $I->assertGreaterThanOrEqual(6, $interval);
//        $I->assertFalse( $course->isNew() );
//    }
    public function setZeroAffiliatePercentage(UnitTester $I){
        $course = Course::find(1);
        $course->affiliate_percentage = 0;
        $I->assertTrue( $course->updateUniques() );
    }
    
    public function set70AffiliatePercentage(UnitTester $I){
        $course = Course::find(1);
        $course->affiliate_percentage = 70;
        $I->assertTrue( $course->updateUniques() );
    }
    
    public function notSet71AffiliatePercentage(UnitTester $I){
        $course = Course::find(1);
        $course->affiliate_percentage = 71;
        $I->assertFalse( $course->updateUniques() );
    }
    
    public function notSetInvalidAffiliatePercentage(UnitTester $I){
        $course = Course::find(1);
        $course->affiliate_percentage = 'invalid';
        $I->assertFalse( $course->updateUniques() );
    }
    
}
