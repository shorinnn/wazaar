<?php 
use \FunctionalTester;

class CourseCategoryCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
    }

    public function seeFeaturedAndRegularCourses(FunctionalTester $I){
        $I->amOnPage('/courses/category/it-and-technology');
        $I->see('featured-contents-container');
        $I->see('small-box');
        $I->see('App Development');
    }
    
    public function getToCourseDetails(FunctionalTester $I){
        $I->amOnPage('/courses/category/it-and-technology');
        $I->click('Learn more');
        $I->seeCurrentUrlEquals('/courses/javascript-primer');
    }
    
    public function getToJSSubcategory(FunctionalTester $I){
        $I->amOnPage('/courses/category/it-and-technology');
        $I->click('javascript');
        $I->seeCurrentUrlEquals('/courses/category/it-and-technology/javascript');
    }
    
  
    
    
}