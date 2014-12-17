<?php 
use \FunctionalTester;

class HomepageCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
    }

    public function seeFeaturedCourse(FunctionalTester $I){
        $I->amOnPage('/');
        $I->see('featured-img-container');
    }
    
    public function getToCategories(FunctionalTester $I){
        $I->amOnPage('/');
        $I->click('View all');
        $I->seeCurrentUrlEquals('/courses/category/it-and-technology');
    }
    
    public function getToCourseDetails(FunctionalTester $I){
        $I->amOnPage('/');
        $I->click('Learn more');
        $I->seeCurrentUrlEquals('/courses/javascript-primer');
    }
    
    public function seeBecomeInstructor(FunctionalTester $I){
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
    
    
    
    
}