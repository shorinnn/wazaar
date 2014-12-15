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
    
    public function dontSeeBuyButtonAsOwner(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->seeAuthentication();
        $I->amOnPage('/courses/app-development');
        $I->seeNumberOfElements('#purchase-form', 0);
    }
    
    public function dontSeeBuyButtonIfAlreadyPurchased(FunctionalTester $I){
        $instructor = Instructor::where('username', 'student')->first();
        $I->amLoggedAs($instructor);
        $I->seeAuthentication();
        $I->amOnPage('/courses/investments-app-development');
        $I->seeNumberOfElements('#purchase-form', 0);
    }
    
    
    
}