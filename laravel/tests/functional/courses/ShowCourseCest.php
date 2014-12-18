<?php 
use \FunctionalTester;

class ShowCourseCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
    }

    public function seeBuyButtonUnauthenticated(FunctionalTester $I){
        $I->dontSeeAuthentication();
        $I->amOnPage('/courses/app-development');
        $I->seeNumberOfElements('#purchase-form', 1);
    }
    
    public function seeBuyButtonAsUser(FunctionalTester $I){
        $student = User::where('username', 'student')->first();
        $I->amLoggedAs($student);
        $I->seeAuthentication();
        $I->amOnPage('/courses/app-development');
        $I->seeNumberOfElements('#purchase-form', 1);
    }
    
    public function seeDisabledAsOwner(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->seeAuthentication();
        $I->amOnPage('/courses/app-development');
        $I->seeNumberOfElements('#purchase-form', 1);
        $I->see('<button class="join-class" disabled="disabled">');
    }
    
    public function dontSeeBuyButtonIfAlreadyPurchased(FunctionalTester $I){
        $instructor = Instructor::where('username', 'student')->first();
        $I->amLoggedAs($instructor);
        $I->seeAuthentication();
        $I->amOnPage('/courses/investments-app-development');
        $I->seeNumberOfElements('#purchase-form', 1);
        $I->see('<button class="join-class" disabled="disabled">');
    }
    
    public function seeStudentCounterIncrement(FunctionalTester $I){
        $student = Student::where('username', 'student')->first();
        $I->amLoggedAs($student);
        $I->seeAuthentication();
        $I->amOnPage('/courses/app-development');
        $I->see('0 Students');
        $I->dontSee('<button class="join-class" disabled="disabled">');
        $I->submitForm('#purchase-form',[]);
        $I->see('1 Student');
    }
    
    
    
}