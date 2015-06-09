<?php
use \FunctionalTester;

class ProductFeferralsCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
    }
    
    public function saveReferral(FunctionalTester $I){
        $course = Course::where('name', 'App Development')->first()->slug;
        $user =  User::where('username','student')->first();
        Auth::login($user);
        $I->dontSeeRecord('course_referrals', ['student_id' => $user->id, 'affiliate_id' => '2']);
        $I->amOnPage('/courses/'.$course.'/?aid=2');
        $I->seeRecord('course_referrals', ['student_id' => $user->id, 'affiliate_id' => '2']);
    }
    
    public function expireReferral(FunctionalTester $I){
        $course = Course::where('name', 'App Development')->first()->slug;
        $user =  Student::where('username','student')->first();
        Auth::login($user);
        $I->dontSeeRecord('course_referrals', ['student_id' => $user->id, 'affiliate_id' => '2']);
        $I->amOnPage('/courses/'.$course.'/?aid=2');
        $I->seeRecord('course_referrals', ['student_id' => $user->id, 'affiliate_id' => '2']);
        $I->assertEquals(1, $user->courseReferrals()->count());
        $referral = CourseReferral::first();
        $referral->expires = '2012-12-12 00:00:00';
        $referral->updateUniques();
        Auth::login($user);
        $I->assertEquals(0, $user->courseReferrals()->count());
    }
    
    /**
     * Can't get $I->seeCookie to work
     */
}