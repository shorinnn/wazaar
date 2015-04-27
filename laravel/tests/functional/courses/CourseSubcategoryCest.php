<?php 
use \FunctionalTester;

class CourseSubcategoryCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
    }

    public function seeFeaturedAndRegularCourses(FunctionalTester $I){
        $cat = CourseCategory::where('name', 'IT & Technology')->first()->slug;
        $subcat = CourseSubcategory::where('name', 'javascript')->first()->slug;
        $I->amOnPage('/courses/category/'.$cat.'/'.$subcat);
        $I->see('featured-contents-container');
        $I->see('small-box');
        $I->see('Javascript Primer');
    }
    
    public function getToCourseDetails(FunctionalTester $I){
        $cat = CourseCategory::where('name', 'IT & Technology')->first()->slug;
        $subcat = CourseSubcategory::where('name', 'javascript')->first()->slug;
        $I->amOnPage('/courses/category/'.$cat.'/'.$subcat);
        $course = Course::where('name', 'Javascript Primer')->first()->slug;
//        $I->click('Learn more');
        $I->click('.big-box > a');
        $I->seeCurrentUrlEquals('/courses/'.$course);
    }
    
    public function seeOnlyPublicCourse(FunctionalTester $I){
        $cat = CourseCategory::where('name', 'Beauty')->first()->slug;
        $subcat = CourseSubcategory::where('name', 'Beauty Subcat')->first()->slug;
        $I->amOnPage('/courses/category/'.$cat.'/'.$subcat);
        $I->see('Beauty PHP Primer Revisited');
        $course = Course::where('name', 'Beauty PHP Primer Revisited')->first();
        $course->privacy_status = 'private';
        $course->save();
        $I->amOnPage('/courses/category/'.$cat.'/'.$subcat);
        $I->dontSee('Beauty Beauty PHP Primer Revisited');
    }
    
  
    
    
}