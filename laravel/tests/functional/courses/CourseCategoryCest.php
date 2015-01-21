<?php 
use \FunctionalTester;

class CourseCategoryCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
        CourseCategory::boot();
    }

    public function seeFeaturedAndRegularCourses(FunctionalTester $I){
        $I->amLoggedAs( User::first() );
        $I->amOnPage('/courses/category/it-technology');
        $I->see('featured-contents-container');
        $I->see('small-box');
        $I->see('App Development');
    }
    
    public function getToCourseDetails(FunctionalTester $I){
        $I->amLoggedAs( User::first() );
        $I->amOnPage('/courses/category/it-technology');
        $I->click('Learn more');
        $I->seeCurrentUrlEquals('/courses/javascript-primer');
    }
    
    public function getToJSSubcategory(FunctionalTester $I){
        $I->amLoggedAs( User::first() );
        $I->amOnPage('/courses/category/it-technology');
        $I->click('javascript');
        $I->seeCurrentUrlEquals('/courses/category/it-technology/javascript');
    }
    
    public function seeOnlyPublicCourse(FunctionalTester $I){
        $I->amLoggedAs( User::first() );
        $I->amOnPage('/courses/category/beauty');
        $I->see('Beauty PHP Primer Revisited');
        $course = Course::where('name', 'Beauty PHP Primer Revisited')->first();
        $course->privacy_status = 'private';
        $course->save();
        $I->amOnPage('/courses/category/beauty');
        $I->dontSee('Beauty Beauty PHP Primer Revisited');
    }
    
  
    
    
}