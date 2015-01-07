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
        $I->seeCurrentUrlEquals('');
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
    
    public function seeCoursesViewEditDeletePagination(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('/courses/mycourses');
        $I->see('App Development');
        $I->see('View');
        $I->see('Edit');
        $I->see('Delete');
        $I->seeNumberOfElements('.pagination', 1);
    }
    public function deleteCourse(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('/courses/mycourses');
        $I->click('#course-form-1 button');
        $I->see('Course Deleted');
        $I->seeNumberOfElements('#course-form-1', 0);
    }
    
    public function notSeeDeleteButton(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('/courses/mycourses');
        $I->seeNumberOfElements('#course-form-5', 0);
    }
    
    public function viewCourse(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('/courses/mycourses');
        $I->click('View');
        $I->seeCurrentUrlEquals('/courses/app-development');
    }
    
    public function seeEditForm(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('/courses/mycourses');
        $I->click('Edit');
        $I->seeCurrentUrlEquals('/courses/app-development/edit');
        $I->see('Category');
        $I->see('Price');
        $I->see('Update');
    }
    
    public function editCourseName(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('/courses/app-development/edit');
        $I->fillField(['name' => 'name'], 'My Updated Title');
        $I->click('Update');
        $I->see('Course Updated');
        $I->seeInField(['name' => 'name'], 'My Updated Title');
    }
    
      public function failUpdateBadSlug(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('/courses/app-development/edit');
        $I->fillField(['name' => 'slug'], 'My Updated Title');
        $I->click('Update');
        $I->see('Could not save Course: The slug may only contain letters, numbers, and dashes.');
     }
    
      public function failReusingSlug(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('/courses/app-development/edit');
        $I->fillField(['name' => 'slug'], 'javascript-primer');
        $I->click('Update');
        $I->see('Could not save Course: The slug has already been taken.');
     }

     
     public function setDiscount(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('/courses/app-development/edit');
        $I->fillField(['name' => 'sale'], '5');
        $I->click('Update');
        $I->see('Course Updated');
        $I->seeInField(['name' => 'sale'], '5');
    }
    
     public function failNegativeDiscount(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('/courses/app-development/edit');
        $I->fillField(['name' => 'sale'], '-5');
        $I->selectOption(['name' => 'sale_kind'], 'amount');
        $I->click('Update');
        $I->see('Could not save Course');
    }
    
     public function failDiscountGreaterThanPrice(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('/courses/app-development/edit');
        $I->fillField(['name' => 'sale'], '999999999');
        $I->selectOption(['name' => 'sale_kind'], 'amount');
        $I->click('Update');
        $I->see('Could not save');
        $I->dontSeeInField(['name' => 'sale'], '999999999.00');
    }
    
     public function failDiscountGreaterThan100Percent(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('/courses/app-development/edit');
        $I->fillField(['name' => 'sale'], '200');
        $I->selectOption(['name' => 'sale_kind'], 'percentage');
        $I->click('Update');
        $I->see('Could not save');
        $I->dontSeeInField(['name' => 'sale'], '200.00');
    }
      
    
}