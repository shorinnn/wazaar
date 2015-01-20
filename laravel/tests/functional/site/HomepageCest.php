<?php 
use \FunctionalTester;

class HomepageCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
    }

    public function seeFeaturedCourse(FunctionalTester $I){
        $user = User::first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/');
        $I->see('featured-img-container');
    }
    
    public function getToCategories(FunctionalTester $I){
        $user = User::first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/');
        $I->click('View all');
        $I->seeCurrentUrlEquals('/courses/category/it-technology');
    }
    
    public function getToCourseDetails(FunctionalTester $I){
        $user = User::first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/');
        $I->click('Learn more');
        $I->seeCurrentUrlEquals('/courses/javascript-primer');
    }
    
    public function seeBecomeInstructor(FunctionalTester $I){
        $user = User::first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/');
        $I->see('BECOME');
        $I->see('AN INSTRUCTOR');
    }
    
    public function notSeeBecomeInstructorIfAlreadyAm(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('/');
        $I->dontSee('BECOME');
        $I->dontSee('AN INSTRUCTOR');
    }
    
    public function seeOnlyPublicCourse(FunctionalTester $I){
        $I->amOnPage('/');
        $I->see('Beauty PHP Primer Revisited');
        $course = Course::where('name', 'Beauty PHP Primer Revisited')->first();
        $course->privacy_status = 'private';
        $course->save();
        $I->amOnPage('/');
        $I->dontSee('Beauty Beauty PHP Primer Revisited');
    }
    
    
    
    
}