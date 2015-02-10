<?php 
use \FunctionalTester;

class TestimonialsCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
    }

    public function redirectFromFormIfNotLoggedIn(FunctionalTester $I){
        $I->dontSeeAuthentication();
        $I->amOnPage( action('ClassroomController@testimonial', Course::first()->slug ));
        $I->seeCurrentUrlEquals('/login');
    }
    
    public function redirectFromFormIfNotPurchased(FunctionalTester $I){
        $user = Student::where('username', 'Jeremy')->first();
        $I->amLoggedAs($user);
        CoursePurchase::where('student_id', $user->id)->delete();
        $course = Course::first();
        $I->assertFalse( $user->purchased($course) );
        $I->amOnPage( action('ClassroomController@testimonial', $course->slug ));
        $I->seeCurrentUrlEquals('');
    }
    
    public function postTestimonial(FunctionalTester $I){
        $user = Student::where('username', 'Jeremy')->first();
        $I->amLoggedAs($user);
        $course = Course::first();
        $I->dontSeeRecord('testimonials', [ 'student_id' => $user->id, 'course_id' => $course->id ]);
        $I->assertTrue( $user->purchased($course) );
        $I->amOnPage( action('ClassroomController@testimonial', $course->slug ));
        $I->see('testimonial-submit-form');
        $I->submitForm('#testimonial-submit-form', [
            'content' => 'Posted Testimonial Codeception'
        ]);
        $I->seeRecord('testimonials', [ 'content' => 'Posted Testimonial Codeception', 'student_id' => $user->id, 
            'course_id' => $course->id, 'rating'=> 'positive' ]);
    }
    
    public function updateTestimonial(FunctionalTester $I){
        $user = Student::where('username', 'Jeremy')->first();
        $I->amLoggedAs($user);
        $course = Course::first();
        $I->dontSeeRecord('testimonials', [ 'student_id' => $user->id, 'course_id' => $course->id ]);
        $I->assertTrue( $user->purchased($course) );
        $I->amOnPage( action('ClassroomController@testimonial', $course->slug ));
        $I->see('testimonial-submit-form');
        $I->submitForm('#testimonial-submit-form', [
            'content' => 'Posted Testimonial Codeception'
        ]);
        $I->seeRecord('testimonials', [ 'content' => 'Posted Testimonial Codeception', 'student_id' => $user->id, 
            'course_id' => $course->id, 'rating'=> 'positive' ]);
        $I->amOnPage( action('ClassroomController@testimonial', $course->slug ));
        $I->see('testimonial-submit-form');
        $I->submitForm('#testimonial-submit-form', [
            'content' => 'Updated Posted Testimonial Codeception',
            'rating' => 'negative'
        ]);
        $I->seeRecord('testimonials', [ 'content' => 'Updated Posted Testimonial Codeception', 'student_id' => $user->id, 
            'course_id' => $course->id, 'rating'=> 'negative' ]);
    }
    
    public function failAjaxPostNoPurchase(FunctionalTester $I){
        $user = Student::where('username', 'Jeremy')->first();
        $I->amLoggedAs($user);
        CoursePurchase::where('student_id', $user->id)->delete();
        $course = Course::first();
        $I->assertFalse( $user->purchased($course) );
        $I->sendAjaxPostRequest( action('TestimonialsController@store'), [
            'content' => 'Ajax Testimonial',
            'rating' => 'negative',
            'id' => $course->id,
            '_token' => csrf_token()
        ]);
        $I->dontSeeRecord('testimonials', [ 'content' => 'Ajax Testimonial' ]);
    }

    public function failAjaxPosBadCourse(FunctionalTester $I){
        $user = Student::where('username', 'Jeremy')->first();
        $I->amLoggedAs($user);
        CoursePurchase::where('student_id', $user->id)->delete();
        $course = Course::first();
        $I->assertFalse( $user->purchased($course) );
        $I->sendAjaxPostRequest( action('TestimonialsController@store'), [
            'content' => 'Ajax Testimonial',
            'rating' => 'negative',
            'id' => 99999,
            '_token' => csrf_token()
        ]);
        $I->dontSeeRecord('testimonials', [ 'content' => 'Ajax Testimonial' ]);
    }
}