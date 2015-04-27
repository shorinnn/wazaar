<?php 
use \FunctionalTester;

class FollowerCest{
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
    }

    public function notFollowIfNotLoggedIn(FunctionalTester $I){
        $course = Course::where('name', 'App Development')->first();
        $I->dontSeeAuthentication();
        $I->amOnPage('/courses/'.$course->slug);
        $I->dontSee('FOLLOW');
    }
    
    public function followInstructor(FunctionalTester $I){
        FollowRelationship::boot();
        $I->assertEquals(0, FollowRelationship::count() );
        $user = Student::where('username', 'student')->first();
        $course = Course::first();
        $I->amLoggedAs($user);
        $I->amOnPage('/courses/'.$course->slug);  
        $I->click('FOLLOW');
        $I->assertEquals(1, FollowRelationship::count() );
        $I->see('UNFOLLOW');
    }
    
    
    public function unfollowInstructor(FunctionalTester $I){
        FollowRelationship::boot();
        $I->assertEquals(0, FollowRelationship::count() );
        $user = Student::where('username', 'student')->first();
        $course = Course::first();
        $I->amLoggedAs($user);
        $I->amOnPage('/courses/'.$course->slug);
        $I->click('FOLLOW');
        $I->assertEquals(1, FollowRelationship::count() );
        $I->see('UNFOLLOW');
        $I->click('UNFOLLOW');
        $I->assertEquals(0, FollowRelationship::count() );
    }
    
    public function failUnfollowingOthersInstructor(FunctionalTester $I){
        FollowRelationship::boot();
        $I->assertEquals(0, FollowRelationship::count() );
        $user = Student::where('username', 'student')->first();
        $course = Course::first();
        $I->amLoggedAs($user);
        $I->amOnPage('/courses/'.$course->slug);  
        $I->click('FOLLOW');
        $I->assertEquals(1, FollowRelationship::count() );
        $user = Student::where('username', 'sorin')->first();
        $I->amLoggedAs($user);
        $rel = FollowRelationship::first();
        $I->assertEquals(1, FollowRelationship::count() );
//        $I->sendAjaxPostRequest('/followers/', ['_method' => 'DELETE', 'instructor_id' => $rel->instructor_id, '_token' => csrf_token() ]);
        $I->sendAjaxRequest('DELETE', '/followers/'.$rel->instructor_id, ['_method' => 'DELETE', 'instructor_id' => $rel->instructor_id, '_token' => csrf_token() ]);
        $I->assertEquals(1, FollowRelationship::count() );
        
    }
    
}