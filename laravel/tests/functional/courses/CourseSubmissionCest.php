<?php 
use \FunctionalTester;

class CourseSubmissionCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
    }

    public function seeUnapproved(FunctionalTester $I){
        $course = Course::where('name','Business App Development')->first();
        $course->publish_status = 'approved';
        $course->updateUniques();
        $I->amOnPage('/');
        $I->see('Business App Development');
    }
    
    public function notSeeUnsubmitted(FunctionalTester $I){
        $course = Course::where('name','Business App Development')->first();
        $course->publish_status = 'unsubmitted';
        $course->updateUniques();
        $I->amOnPage('/');
        $I->dontSee('Business App Development');
    }
    public function notSeePending(FunctionalTester $I){
        $course = Course::where('name','Business App Development')->first();
        $course->publish_status = 'pending';
        $course->updateUniques();
        $I->amOnPage('/');
        $I->dontSee('Business App Development');
    }
    public function notSeeRejected(FunctionalTester $I){
        $course = Course::where('name','Business App Development')->first();
        $course->publish_status = 'rejected';
        $course->updateUniques();
        $I->amOnPage('/');
        $I->dontSee('Business App Development');
    }
    
    public function adminApprove(FunctionalTester $I){
        $admin = User::find(1);
        $I->amLoggedAs( $admin );
        $course = Course::where('name','Business App Development')->first();
        $course->publish_status = 'pending';
        $course->updateUniques();
        $I->amOnPage( '/administration/submissions' );
        $I->see( 'Business App Development' );
        $I->submitForm('#approve-form-'.$course->id,[]);
        $I->seeRecord( 'courses',['name' => 'Business App Development', 'publish_status' => 'approved' ] );
        $I->dontSee( 'Business App Development' );
        $I->amOnPage('/');
        $I->see( 'Business App Development' );
    }
    
    public function adminReject(FunctionalTester $I){
        $admin = User::find(1);
        $I->amLoggedAs( $admin );
        $course = Course::where('name','Business App Development')->first();
        $course->publish_status = 'pending';
        $course->updateUniques();
        $I->amOnPage( '/administration/submissions' );
        $I->see( 'Business App Development' );
        $I->submitForm('#reject-form-'.$course->id,[]);
        $I->seeRecord( 'courses',['name' => 'Business App Development', 'publish_status' => 'rejected' ] );
        $I->dontSee( 'Business App Development' );
        $I->amOnPage('/');
        $I->dontSee( 'Business App Development' );
    }
    
    public function submitForApprovalAsInstructor(FunctionalTester $I){
        $I->haveDisabledFilters();
        $course  = Course::first();
        $course->publish_status = 'unsubmitted';
        $course->updateUniques();
        $I->amLoggedAs( $course->instructor );        
        $I->amOnPage("/courses/$course->slug/edit");
        $I->seeNumberOfElements('#submit-publish-btn', 1);
        $I->click('Submit for approval');
        $I->seeRecord( 'courses', [ 'name' => $course->name, 'publish_status' => 'pending' ] );
        
    }
    
}