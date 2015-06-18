<?php
use \UnitTester;

class CourseCest{
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
    
    public function setFreeCourse(UnitTester $I){
        $course = Course::find(1);
        $course->price = 0;
        $I->assertTrue( $course->updateUniques() );
    }
    
    public function failSetting200Price(UnitTester $I){
        $course = Course::find(1);
        $course->price = 200;
        $I->assertFalse( $course->updateUniques() );
    }
    
    public function roundPriceDown(UnitTester $I){
        $course = Course::find(1);
        $course->price = 620;
        $I->assertTrue( $course->updateUniques() );
        $course = Course::find(1);
        $I->assertEquals(600, $course->price);
    }
    
    public function roundPriceUp(UnitTester $I){
        $course = Course::find(1);
        $course->price = 660;
        $I->assertTrue( $course->updateUniques() );
        $course = Course::find(1);
        $I->assertEquals(700, $course->price);
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
    
    public function createCourse(UnitTester $I){
        $course = new Course();
        $course->name = 'New App Development';
        $course->slug = 'new-app-development';
        $course->instructor_id = 4;
        $course->course_category_id = 1;
        $course->course_subcategory_id = 1;
        $course->price = 300000;
        $course->course_difficulty_id = 1;
        $course->description = 'Create your very first application in 2 weeks! You get a beginner award after completing the course.';
        $course->student_count =  0;
        $course->affiliate_percentage =  0;
        $I->assertTrue( $course->save() );
    }
    
    public function getNewCourseLessThanXStudents(UnitTester $I){
        $course = Course::find(1);
        $I->assertLessThan( Config::get('custom.course_is_new.maximum_students'), $course->student_count);
        $I->assertTrue($course->isNew());
    }
    
     public function notGetNewCourseMoreThanXStudents(UnitTester $I){
        $course = Course::find(1);
        $course->student_count =  Config::get('custom.course_is_new.maximum_students') + 5;
        $I->assertTrue( $course->updateUniques() );
        $I->assertFalse( $course->isNew() );
    }
    
    public function getNewCourseLessThanXMonths(UnitTester $I){
        $course = Course::find(1);
        $course->student_count =  Config::get('custom.course_is_new.maximum_students') - 5;
        $I->assertTrue( $course->updateUniques() );
        $creation_date = date_create($course->created_at);
        $now = date_create();
        $interval = (int)date_diff($creation_date, $now)->format('%m');
        $I->assertLessThan( Config::get('custom.course_is_new.maximum_students'), $interval);
        $I->assertTrue($course->isNew());
    }
    
    public function notGetNewCourseOlderThanXMonths(UnitTester $I){
        $course = Course::find(1);
        $course->student_count =  Config::get('custom.course_is_new.maximum_students') - 5;
        $months =  Config::get('custom.course_is_new.maximum_months') + 1;
        $d = date('Y-m-d H:i:s', strtotime("$months month ago") );
        $course->created_at = $d;
        $I->assertTrue( $course->updateUniques() );
        $creation_date = date_create($course->created_at);
        $now = date_create();
        $interval = (int)date_diff($creation_date, $now)->format('%m');
        $I->assertGreaterThanOrEqual($months, $interval);
        $I->assertFalse( $course->isNew() );
    }
    
   
    
    public function setZeroAffiliatePercentage(UnitTester $I){
        $course = Course::find(1);
        $course->affiliate_percentage = 0;
        $I->assertTrue( $course->updateUniques() );
    }
    
    public function set68AffiliatePercentage(UnitTester $I){
        $course = Course::find(1);
        $course->affiliate_percentage = 68;
        $I->assertTrue( $course->updateUniques() );
    }
    
    public function notSet69AffiliatePercentage(UnitTester $I){
        $course = Course::find(1);
        $course->affiliate_percentage = 69;
        $I->assertFalse( $course->updateUniques() );
    }
    
    public function notSetInvalidAffiliatePercentage(UnitTester $I){
        $course = Course::find(1);
        $course->affiliate_percentage = 'invalid';
        $I->assertFalse( $course->updateUniques() );
    }
    
    public function forceNewEvenIfOldOrHasLotsOfStudents(UnitTester $I){
        $course = Course::find(1);
        $course->student_count = Config::get('custom.course_is_new.maximum_students') + 5;
        $months =  Config::get('custom.course_is_new.maximum_months') + 1;
        $d = date('Y-m-d H:i:s', strtotime("$months month ago") );
        $course->created_at = $d;
        $course->force_new = 1;
        $I->assertTrue( $course->updateUniques() );
        $creation_date = date_create($course->created_at);
        $now = date_create();
        $interval = (int)date_diff($creation_date, $now)->format('%m');
        $I->assertGreaterThanOrEqual( Config::get('custom.course_is_new.maximum_months'), $interval);
        $I->assertTrue( $course->isNew() );
    }
    
    public function getLessonSales(UnitTester $I){
        $lesson = Lesson::find(10);
        $lessonSales = Purchase::where( 'product_id', $lesson->id )->where( 'product_type','Lesson' )->sum( 'purchase_price' );
        $I->assertEquals( $lessonSales, $lesson->module->course->lessonSales() );
    }
        
}