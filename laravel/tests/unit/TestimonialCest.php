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
        $testimonial = new Testimonial;
        $testimonial->fill( [ 'student_id' => 4, 'course_id' => 5, 'content' => 'test' ] );
        $I->assertTrue( $testimonial->save() );
    }
    
    public function updateTestimonial(UnitTester $I){
        $testimonial = new Testimonial;
        $testimonial->fill( [ 'student_id' => 4, 'course_id' => 5, 'content' => 'test' ] );
        $I->assertTrue( $testimonial->save() );
        $testimonial->content = 'edited';
        $I->assertTrue( $testimonial->updateUniques() );
    }
    
    public function failAddingTwoTestimonialsToSameCourse(UnitTester $I){
        $testimonial = new Testimonial;
        $testimonial->fill( [ 'student_id' => 4, 'course_id' => 5, 'content' => 'test' ] );
        $I->assertTrue( $testimonial->save() );
        $testimonial = new Testimonial;
        $testimonial->fill( [ 'student_id' => 4, 'course_id' => 5, 'content' => 'test' ] );
        $I->assertFalse( $testimonial->save() );
    }
    
    public function failTestimonialBadCourse(UnitTester $I){
        $testimonial = new Testimonial;
        $testimonial->fill( [ 'student_id' => 4, 'course_id' => 55555, 'content' => 'test' ] );
        $I->assertFalse( $testimonial->save() );
    }
    
    public function failTestimonialBadStudent(UnitTester $I){
        $testimonial = new Testimonial;
        $testimonial->fill( [ 'student_id' => 44444444, 'course_id' => 5, 'content' => 'test' ] );
        $I->assertFalse( $testimonial->save() );
    }
    
     
        
}