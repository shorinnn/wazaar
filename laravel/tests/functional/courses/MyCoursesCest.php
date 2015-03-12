<?php 
use \FunctionalTester;

class MyCourseCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
         Course::boot();
    }

    public function redirectIfNotLoggedIn(FunctionalTester $I){
        $I->dontSeeAuthentication();
        $I->amOnPage('/courses/mycourses');
        $I->seeCurrentUrlEquals('/login');
    }
    
    public function redirectIfNotInstructor(FunctionalTester $I){
        $I->dontSeeAuthentication();
        $student = Student::where('username', 'student')->first();
        $I->amLoggedAs($student);
        $I->assertFalse( $student->hasRole('Instructor') );
        $I->seeAuthentication();
        $I->amOnPage('/courses/mycourses');
        $I->seeCurrentUrlEquals('');
    }
    
    public function loginAsInstructor(FunctionalTester $I){
        $I->dontSeeAuthentication();
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->assertTrue( $instructor->hasRole('Instructor') );
        $I->seeAuthentication();
        $I->amOnPage('/courses/mycourses');
        $I->seeCurrentUrlEquals('/courses/mycourses');
    }
    
    public function notSeeCourseAsSecondInstructor(FunctionalTester $I){
        $I->dontSeeAuthentication();
        $instructor = Instructor::where('username', 'instructor')->first();
        $second_instructor = Instructor::where('username', 'second_instructor')->first();
        $I->amLoggedAs($second_instructor);
        
        $I->assertTrue( $second_instructor->hasRole('Instructor') );
        $I->seeAuthentication();
        $I->amOnPage('/courses/mycourses');
        $I->seeCurrentUrlEquals('/courses/mycourses');
        
        $I->dontSee( $instructor->courses->first()->name );
    }
    
    public function seeCourseAsSecondInstructor(FunctionalTester $I){
        $I->dontSeeAuthentication();
        $instructor = Instructor::where('username', 'instructor')->first();
        $second_instructor = Instructor::where('username', 'second_instructor')->first();
        $I->amLoggedAs($second_instructor);
        
        $course = $instructor->courses->first();
        $course->assigned_instructor_id = $second_instructor->id;
        $I->assertTrue( $course->updateUniques() );
        $I->assertTrue( $second_instructor->hasRole('Instructor') );
        $I->seeAuthentication();
        $I->amOnPage('/courses/mycourses');
        $I->seeCurrentUrlEquals('/courses/mycourses');
        $I->see( $course->name );
    }
    
//    public function seeCoursesViewEditDeletePagination(FunctionalTester $I){
//        $instructor = Instructor::where('username', 'instructor')->first();
//        $I->amLoggedAs($instructor);
//        $I->amOnPage('/courses/mycourses');
//        $I->see('App Development');
//        $I->see('Edit');
//        $I->see('Delete');
//        $I->seeNumberOfElements('.pagination', 1);
//    }
//    public function deleteCourse(FunctionalTester $I){
//        $instructor = Instructor::where('username', 'instructor')->first();
//        $I->amLoggedAs($instructor);
//        $I->amOnPage('/courses/mycourses');
//        $I->click('#course-form-1 button');
//        $I->see('Course Deleted');
//        $I->seeNumberOfElements('#course-form-1', 0);
//    }
//    
//    public function notSeeDeleteButton(FunctionalTester $I){
//        $instructor = Instructor::where('username', 'instructor')->first();
//        $I->amLoggedAs($instructor);
//        $I->amOnPage('/courses/mycourses');
//        $I->seeNumberOfElements('#course-form-5', 0);
//    }
    
//    public function viewCourse(FunctionalTester $I){
//        $instructor = Instructor::where('username', 'instructor')->first();
//        $I->amLoggedAs($instructor);
//        $I->amOnPage('/courses/mycourses');
//        $I->click('View');
//        $course = Course::where('name','App Development')->first();
//        $I->seeCurrentUrlEquals('/courses/'.$course->slug);
//    }
    
    public function seeEditForm(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $course = Course::where('name','App Development')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('/courses/mycourses');
        $I->click('Edit');
        $I->seeCurrentUrlEquals('/courses/'.$course->slug.'/edit');
        $I->see('Category');
        $I->see('Price');
        $I->see('Update');
    }
    
    public function editCourseName(FunctionalTester $I){
        $course = Course::where('name','App Development')->first();
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('/courses/'.$course->slug.'/edit');
        $I->fillField(['name' => 'name'], 'My Updated Title');
        $I->click('Update');
        $I->see('Course Updated');
        $I->seeInField(['name' => 'name'], 'My Updated Title');
    }
    
      public function failUpdateBadSlug(FunctionalTester $I){
          if( !Config::get('custom.use_id_for_slug') ){
            $course = Course::where('name','App Development')->first();
            $instructor = Instructor::where('username', 'instructor')->first();
            $I->amLoggedAs($instructor);
            $I->amOnPage('/courses/'.$course.'/edit');
            $I->fillField(['name' => 'slug'], 'My Updated Title');
            $I->click('Update');
            $I->see('Could not save Course: The slug may only contain letters, numbers, and dashes.');
          }
     }
    
      public function failReusingSlug(FunctionalTester $I){
          if( !Config::get('custom.use_id_for_slug') ){
            $course = Course::where('name','App Development')->first();
            $instructor = Instructor::where('username', 'instructor')->first();
            $I->amLoggedAs($instructor);
            $I->amOnPage('/courses/'.$course.'/edit');
            $I->fillField(['name' => 'slug'], 'javascript-primer');
            $I->click('Update');
            $I->see('Could not save Course: The slug has already been taken.');
          }
     }

     
     public function setDiscount(FunctionalTester $I){
        $course = Course::where('name','App Development')->first();

        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('/courses/'.$course->slug.'/edit');
        $I->seeInField(['name' => 'sale'], '0');
//        $I->fillField(['name' => 'sale'], '5');
        $I->submitForm('form', ['sale' => '5', 'sale_kind' => 'amount', 'name' => 'sorin']);
        $I->see('Course Updated');
        $course = Course::find( $course->id );
        $I->assertEquals('sorin', $course->name);
        $I->assertEquals(5, $course->sale);
        $I->seeInField(['name' => 'sale'], '5');
    }
    
     public function failNegativeDiscount(FunctionalTester $I){
        $course = Course::where('name','App Development')->first();
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('/courses/'.$course->slug.'/edit');
//        $I->fillField(['name' => 'sale'], '-5');
        $I->submitForm('form', ['sale' => '-5', 'sale_kind' => 'amount']);
//        $I->selectOption(['name' => 'sale_kind'], 'amount');
        $I->click('Update');
        $I->see('Could not save Course');
    }
    
     public function failDiscountGreaterThanPrice(FunctionalTester $I){
        $course = Course::where('name','App Development')->first();
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('/courses/'.$course->slug.'/edit');
//        $I->fillField(['name' => 'sale'], '999999999');
        $I->submitForm('form', ['sale' => '999999999', 'sale_kind' => 'amount']);
//        $I->selectOption(['name' => 'sale_kind'], 'amount');
        $I->click('Update');
        $I->see('Could not save');
        $I->dontSeeInField(['name' => 'sale'], '999999999.00');
    }
    
     public function failDiscountGreaterThan100Percent(FunctionalTester $I){
        $course = Course::where('name','App Development')->first();
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('/courses/'.$course->slug.'/edit');
//        $I->fillField(['name' => 'sale'], '200');
//        $I->selectOption(['name' => 'sale_kind'], 'percentage');
        $I->submitForm('form', ['sale' => '200', 'sale_kind' => 'percentage']);
        $I->click('Update');
        $I->see('Could not save');
        $I->dontSeeInField(['name' => 'sale'], '200.00');
    }
      
    
}