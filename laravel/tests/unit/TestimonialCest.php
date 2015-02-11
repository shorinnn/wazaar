<?php
use \UnitTester;

class TestimonialCest{
    public function _before() {
        $this->setupDatabase();
    }

    private function setupDatabase() {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        Testimonial::boot();
    }
    
    public function addTestimonial(UnitTester $I){
        Testimonial::destroy( Testimonial::lists('id') );
        $testimonial = new Testimonial;
        $testimonial->fill( [ 'student_id' => 4, 'course_id' => 5, 'content' => 'test' ] );
        $I->assertTrue( $testimonial->save() );
    }
    
    public function updateTestimonial(UnitTester $I){
        Testimonial::destroy( Testimonial::lists('id') );
        $testimonial = new Testimonial;
        $testimonial->fill( [ 'student_id' => 5, 'course_id' => 5, 'content' => 'test' ] );
        $I->assertTrue( $testimonial->save() );
        $testimonial = new Testimonial;
        $testimonial->fill( [ 'student_id' => 4, 'course_id' => 5, 'content' => 'test' ] );
        $I->assertTrue( $testimonial->save() );
        $testimonial->content = 'edited';
        $I->assertTrue( $testimonial->updateUniques() );
    }
    
    public function failAddingTwoTestimonialsToSameCourse(UnitTester $I){
        Testimonial::destroy( Testimonial::lists('id') );
        $testimonial = new Testimonial;
        $testimonial->fill( [ 'student_id' => 4, 'course_id' => 5, 'content' => 'test' ] );
        $I->assertTrue( $testimonial->save() );
        $testimonial = new Testimonial;
        $testimonial->fill( [ 'student_id' => 4, 'course_id' => 5, 'content' => 'test' ] );
        $I->assertFalse( $testimonial->save() );
    }
    
    public function failTestimonialBadCourse(UnitTester $I){
        Testimonial::destroy( Testimonial::lists('id') );
        $testimonial = new Testimonial;
        $testimonial->fill( [ 'student_id' => 4, 'course_id' => 55555, 'content' => 'test' ] );
        $I->assertFalse( $testimonial->save() );
    }
    
    public function failTestimonialBadStudent(UnitTester $I){
        Testimonial::destroy( Testimonial::lists('id') );
        $testimonial = new Testimonial;
        $testimonial->fill( [ 'student_id' => 44444444, 'course_id' => 5, 'content' => 'test' ] );
        $I->assertFalse( $testimonial->save() );
    }
    
    public function updateCoursePositiveCount(UnitTester $I){
        Testimonial::destroy( Testimonial::lists('id') );
        $testimonial = new Testimonial;
        $course = Course::find(5);
        $course->total_reviews = 0;
        $course->reviews_positive_score = 0;
        $I->assertTrue( $course->updateUniques() );
        $testimonial->fill( [ 'student_id' => 4, 'course_id' => 5, 'content' => 'positive', 'rating' => 'positive' ] );
        $I->assertTrue( $testimonial->save() );
        $course = Course::find(5);
        $I->assertEquals( 1, $course->total_reviews );
        $I->assertEquals( 100, $course->reviews_positive_score );
    }
    
    public function updateCourseNegativeCount(UnitTester $I){
        Testimonial::destroy( Testimonial::lists('id') );
        $course = Course::find(5);
        $course->total_reviews = 1;
        $course->reviews_positive_score = 100;
        $I->assertTrue( $course->updateUniques() );
        $testimonial = new Testimonial;
        $testimonial->fill( [ 'student_id' => 4, 'course_id' => 5, 'content' => 'negative', 'rating' => 'positive' ] );
        $I->assertTrue( $testimonial->save() );
        $testimonial = new Testimonial;
        $testimonial->fill( [ 'student_id' => 5, 'course_id' => 5, 'content' => 'negative', 'rating' => 'negative' ] );
        $I->assertTrue( $testimonial->save() );
        $course = Course::find(5);
        $I->assertEquals( 2, $course->total_reviews );
        $I->assertEquals( 50, $course->reviews_positive_score );
    }
    
    public function ignoreReportedTestimonials(UnitTester $I){
        Testimonial::destroy( Testimonial::lists('id') );
        $course = Course::find(5);
        $course->total_reviews = 1;
        $course->reviews_positive_score = 100;
        $I->assertTrue( $course->updateUniques() );
        $testimonial = new Testimonial;
        $testimonial->fill( [ 'student_id' => 4, 'course_id' => 5, 'content' => 'negative', 'rating' => 'negative', 'reported' => 'yes' ] );
        $I->assertTrue( $testimonial->save() );
        $testimonial = new Testimonial;
        $testimonial->fill( [ 'student_id' => 5, 'course_id' => 5, 'content' => 'negative', 'rating' => 'positive' ] );
        $I->assertTrue( $testimonial->save() );
        $course = Course::find(5);
        $I->assertEquals( 1, $course->total_reviews );
        $I->assertEquals( 100, $course->reviews_positive_score );
    }
    
    
    public function skipCourseUpdate(UnitTester $I){
        $course = Course::find(5);
        $course->total_reviews = 0;
        $course->reviews_positive_score = 0;
        $I->assertTrue( $course->updateUniques() );
        $I->assertEquals(0, Course::find(5)->reviews_positive_score);
        
        Testimonial::destroy( Testimonial::lists('id') );
        $testimonial = new Testimonial;
        $testimonial->rate_update = true;
        $testimonial->fill( [ 'student_id' => 4, 'course_id' => 5, 'content' => 'positive', 'rating' => 'positive' ] );
        $I->assertTrue( $testimonial->save() );
        $I->assertEquals(0, Course::find(5)->reviews_positive_score);
    }
    
    public function notUpdateRelatedCourse(UnitTester $I){
        sleep(2);
        $testimonial = Testimonial::find(5);
        $I->assertTrue( $testimonial->rate( false, 'positive', null ) );
        $I->assertNotEquals( $testimonial->course->updated_at->timestamp, time() );
    }
    
    public function updateRelatedCourse(UnitTester $I){
        sleep(2);
        $testimonial = Testimonial::find(5);
        $testimonial->rating = 'positive';
        $I->assertTrue( $testimonial->updateUniques() );
        $I->assertEquals( $testimonial->course->updated_at->timestamp, time() );
    }
     
        
}