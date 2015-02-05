<?php 
use \FunctionalTester;

class CourseCategoryCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
        CourseCategory::boot();
    }

    public function seeFeaturedAndRegularCourses(FunctionalTester $I){
        $I->amLoggedAs( User::first() );
        $cat = CourseCategory::where('name', 'IT & Technology')->first()->slug;
        $I->amOnPage('/courses/category/'.$cat);
        $I->see('featured-contents-container');
        $I->see('small-box');
        $I->see('App Development');
    }
    
    public function getToCourseDetails(FunctionalTester $I){
        $I->amLoggedAs( User::first() );
        $cat = CourseCategory::where('name', 'IT & Technology')->first();
        $I->amOnPage('/courses/category/'.$cat->slug);
        $I->click('Learn more');
        $course = Course::where('name','javascript primer')->first()->slug;
        $I->seeCurrentUrlEquals('/courses/'.$course);
    }
    
    public function getToJSSubcategory(FunctionalTester $I){
        $I->amLoggedAs( User::first() );
        $cat = CourseCategory::where('name', 'IT & Technology')->first();
        $I->amOnPage('/courses/category/'.$cat->slug);
        $I->click('javascript');
        $subcat = CourseSubcategory::where('name', 'javascript')->first()->slug;
        $I->seeCurrentUrlEquals("/courses/category/$cat->slug/$subcat");
    }
    
    public function seeOnlyPublicCourse(FunctionalTester $I){
        $I->amLoggedAs( User::first() );
        $cat = CourseCategory::where('name', 'Beauty')->first()->slug;
        $I->amOnPage('/courses/category/'.$cat);
        $I->see('Beauty PHP Primer Revisited');
        $course = Course::where('name', 'Beauty PHP Primer Revisited')->first();
        $course->privacy_status = 'private';
        $course->save();
        $I->amOnPage('/courses/category/'.$cat);
        $I->dontSee('Beauty Beauty PHP Primer Revisited');
    }
    
  
    
    
}