<?php 
use \FunctionalTester;

class TestimonialsCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
        Testimonial::boot();
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
    
    public function notSeeRateFormUnauthenticated(FunctionalTester $I){
        $course = Course::where('name', 'Business App Development')->first();
        $I->amOnPage('/courses/'.$course->slug);
        $I->dontSee('was this review helpful');
        $I->dontSee('testimonials/rate');
    }
    
    public function thumbUpTestimonial(FunctionalTester $I){
        $course = Course::where('name', 'Business App Development')->first();
        $testimonial = $course->testimonials()->orderBy('id','desc')->first();
        $user = User::first();
        $I->amLoggedAs($user);
        $I->amOnPage('/courses/'.$course->slug);
        if($testimonial->thumbs() > 0){
            if($testimonial->thumbs_up > $testimonial->thumbs_down){
                $I->see( $testimonial->thumbs_up );
                $I->see( $testimonial->thumbs() );
                $I->see( "found this review very helpful" );
            }
            else{
                $I->see( $testimonial->thumbs_down);
                $I->see( $testimonial->thumbs() );
                $I->see ( "found this review not helpful" );
            }
        }
        $I->click('Yes');
        $I->see( 'data-rated' );
        $testimonial->thumbs_up++;
        $total = $testimonial->thumbs() + 1;
        if($testimonial->thumbs() > 0){
            if($testimonial->thumbs_up > $testimonial->thumbs_down){
                $I->see( $testimonial->thumbs_up );
                $I->see( $total );
                $I->see( "found this review very helpful" );
            }
            else{
                $I->see( $testimonial->thumbs_down);
                $I->see( $total );
                $I->see ( "found this review not helpful" );
            }
        }
        
    }
    
    public function thumbDownTestimonial(FunctionalTester $I){
        $course = Course::where('name', 'Business App Development')->first();
        $testimonial = $course->testimonials()->orderBy('id','desc')->first();
        $user = User::first();
        $I->amLoggedAs($user);
        $I->amOnPage('/courses/'.$course->slug);
        if($testimonial->thumbs() > 0){
            if($testimonial->thumbs_up > $testimonial->thumbs_down){
                $I->see( $testimonial->thumbs_up );
                $I->see( $testimonial->thumbs() );
                $I->see( "found this review very helpful" );
            }
            else{
                $I->see( $testimonial->thumbs_down);
                $I->see( $testimonial->thumbs() );
                $I->see ( "found this review not helpful" );
            }
        }
        
        $I->click('rate-no');
        $I->see( 'data-rated' );
        $testimonial->thumbs_down++;
        $total = $testimonial->thumbs() + 1;
        
        if($testimonial->thumbs() > 0){
            if($testimonial->thumbs_up > $testimonial->thumbs_down){
                $I->see( $testimonial->thumbs_up );
                $I->see( $total );
                $I->see( "found this review very helpful" );
            }
            else{
                $I->see( $testimonial->thumbs_down);
                $I->see( $total );
                $I->see ( "found this review not helpful" );
            }
        }
    }
    
    public function changeTestimonialRating(FunctionalTester $I){
        $course = Course::where('name', 'Business App Development')->first();
        $testimonial = $course->testimonials()->orderBy('id','desc')->first();
        $user = User::first();
        $I->amLoggedAs($user);
        $I->amOnPage('/courses/'.$course->slug);
        if($testimonial->thumbs() > 0){
            if($testimonial->thumbs_up > $testimonial->thumbs_down){
                $I->see( $testimonial->thumbs_up );
                $I->see( $testimonial->thumbs() );
                $I->see( "found this review very helpful" );
            }
            else{
                $I->see( $testimonial->thumbs_down);
                $I->see( $testimonial->thumbs() );
                $I->see ( "found this review not helpful" );
            }
        }
        
        $I->click('rate-no');
        $I->seeCurrentUrlEquals('/courses/'.$course->slug);
        $I->see( 'data-rated' );
        
        $testimonial->thumbs_down++;
        $total = $testimonial->thumbs() + 1;
        
        if($testimonial->thumbs() > 0){
            if($testimonial->thumbs_up > $testimonial->thumbs_down){
                $I->see( $testimonial->thumbs_up );
                $I->see( $total );
                $I->see( "found this review very helpful" );
            }
            else{
                $I->see( $testimonial->thumbs_down);
                $I->see( $total );
                $I->see ( "found this review not helpful" );
            }
        }
        Testimonial::boot();
        $I->click('Yes');
        $I->seeCurrentUrlEquals('/courses/'.$course->slug);
        $testimonial->thumbs_up++;
        if( $testimonial->thumbs() > 0 ){
            if( $testimonial->thumbs_up > $testimonial->thumbs_down ){
                $I->see( $testimonial->thumbs_up );
                $I->see( $total );
                $I->see( "found this review very helpful" );
            }
            else{
                $I->see( $testimonial->thumbs_down);
                $I->see( $total );
                $I->see ( "found this review not helpful" );
            }
        }
    }
    
    public function sameValueTestimonialRating(FunctionalTester $I){
        $course = Course::where('name', 'Business App Development')->first();
        $testimonial = $course->testimonials()->orderBy('id','desc')->first();
        $user = User::first();
        $I->amLoggedAs($user);
        $I->amOnPage('/courses/'.$course->slug);
        if($testimonial->thumbs() > 0){
            if($testimonial->thumbs_up > $testimonial->thumbs_down){
                $I->see( $testimonial->thumbs_up );
                $I->see( $testimonial->thumbs() );
                $I->see( "found this review very helpful" );
            }
            else{
                $I->see( $testimonial->thumbs_down);
                $I->see( $testimonial->thumbs() );
                $I->see ( "found this review not helpful" );
            }
        }
        
        $I->click('rate-no');
        $I->see( 'data-rated' );
        
        $testimonial->thumbs_down++;
        $total = $testimonial->thumbs() + 1;
        
        if($testimonial->thumbs() > 0){
            if($testimonial->thumbs_up > $testimonial->thumbs_down){
                $I->see( $testimonial->thumbs_up );
                $I->see( $total );
                $I->see( "found this review very helpful" );
            }
            else{
                $I->see( $testimonial->thumbs_down);
                $I->see( $total );
                $I->see ( "found this review not helpful" );
            }
        }
        
        $I->click('rate-no');
        $I->seeCurrentUrlEquals('/courses/'.$course->slug);
        
        if( $testimonial->thumbs() > 0 ){
            if( $testimonial->thumbs_up > $testimonial->thumbs_down ){
                $I->see( $testimonial->thumbs_up );
                $I->see( $total );
                $I->see( "found this review very helpful" );
            }
            else{
                $I->see( $testimonial->thumbs_down);
                $I->see( $total );
                $I->see ( "found this review not helpful" );
            }
        }
    }
    
    public function failDoubleRatingViaAjax(FunctionalTester $I){
        $course = Course::where('name', 'Business App Development')->first();
        $testimonial = $course->testimonials()->orderBy('id','desc')->first();
        $user = User::first();
        $I->amLoggedAs($user);
        $I->dontSeeRecord('testimonial_ratings', ['student_id' => $user->id, 'testimonial_id' => $testimonial->id, 'rating' =>'positive' ]);
        
        $I->sendAjaxPostRequest( action( 'TestimonialsController@rate', 
                ['_token' => csrf_token(), 'testimonial_id' => $testimonial->id, 'rating' => 'positive'] ) );
        $I->seeRecord('testimonial_ratings', ['student_id' => $user->id, 'testimonial_id' => $testimonial->id, 'rating' =>'positive']);
        
        $I->sendAjaxPostRequest( action( 'TestimonialsController@rate', 
                ['_token' => csrf_token(), 'testimonial_id' => $testimonial->id, 'rating' => 'negative'] ) );
        $I->seeRecord('testimonial_ratings', ['student_id' => $user->id, 'testimonial_id' => $testimonial->id, 'rating' =>'negative']);
        $I->dontSeeRecord('testimonial_ratings', ['student_id' => $user->id, 'testimonial_id' => $testimonial->id, 'rating' =>'positive']);
    }
    
}