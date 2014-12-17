<?php 
use \FunctionalTester;

class CourseSubcategoryCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
    }

    public function seeFeaturedAndRegularCourses(FunctionalTester $I){
        $I->amOnPage('/courses/category/it-and-technology/javascript');
        $I->see('featured-contents-container');
        $I->see('small-box');
        $I->see('Javascript Primer');
    }
    
    public function getToCourseDetails(FunctionalTester $I){
        $I->amOnPage('/courses/category/it-and-technology/javascript');
        $I->click('Learn more');
        $I->seeCurrentUrlEquals('/courses/javascript-primer');
    }
    
    public function seeOnlyPublicCourse(FunctionalTester $I){
        $I->amOnPage('/courses/category/beauty/beauty-subcat');
        $I->see('Beauty PHP Primer Revisited');
        $course = Course::where('name', 'Beauty PHP Primer Revisited')->first();
        $course->privacy_status = 'private';
        $course->save();
        $I->amOnPage('/courses/category/beauty/beauty-subcat');
        $I->dontSee('Beauty Beauty PHP Primer Revisited');
    }
    
  
    
    
}