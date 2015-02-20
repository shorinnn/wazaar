<?php 
use \FunctionalTester;

class ShowCourseCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
    }

    public function seeBuyButtonUnauthenticated(FunctionalTester $I){
        $course = Course::where('name', 'App Development')->first();
        $I->dontSeeAuthentication();
        $I->amOnPage('/courses/'.$course->slug);
        $I->seeNumberOfElements('#purchase-form', 1);
    }
    
    public function seeBuyButtonAsUser(FunctionalTester $I){
        $course = Course::where('name', 'App Development')->first();
        $student = User::where('username', 'student')->first();
        $I->amLoggedAs($student);
        $I->seeAuthentication();
        $I->amOnPage('/courses/'.$course->slug);
        $I->seeNumberOfElements('#purchase-form', 1);
    }
    
    public function seeDisabledAsOwner(FunctionalTester $I){
        $course = Course::where('name', 'App Development')->first();
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->seeAuthentication();
        $I->amOnPage('/courses/'.$course->slug);
        $I->seeNumberOfElements('#purchase-form', 1);
        $I->see('<button class="join-class" disabled="disabled">');
    }
    
    public function dontSeeBuyButtonIfAlreadyPurchased(FunctionalTester $I){
        $course = Course::where('name', 'Investments App Development')->first();
        $instructor = Instructor::where('username', 'student')->first();
        $I->amLoggedAs($instructor);
        $I->seeAuthentication();
        $I->amOnPage('/courses/'.$course->slug);
        $I->seeNumberOfElements('#purchase-form', 1);
        $I->see('<button class="join-class" disabled="disabled">');
    }
    
    public function redirectToDashboardAndIncrementStudentCount(FunctionalTester $I){
        $course = Course::where('name', 'App Development')->first();
        $student = Student::where('username', 'student')->first();
        Purchase::where('student_id', $student->id)->delete();
        $I->amLoggedAs($student);
        $I->seeAuthentication();
        $I->amOnPage('/courses/'.$course->slug);
        $I->see('0 Students');
        $I->dontSee('<button class="join-class" disabled="disabled">');
        $I->submitForm('#purchase-form',[]);
        $I->seeCurrentUrlEquals('/classroom/'.$course->slug.'/dashboard');
        $I->amOnPage('/courses/'.$course->slug);
        $I->see('1 Student');
    }    
    
}