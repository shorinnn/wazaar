<?php
use \UnitTester;

class TestimonialRatingCest{
    public function _before() {
        $this->setupDatabase();
    }
    public function __destruct()
    {
        \DB::disconnect();
    }

    private function setupDatabase() {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        TestimonialRating::boot();
    }
    
    public function addRating(UnitTester $I){
        $testimonial = Testimonial::find(5);
        TestimonialRating::where('testimonial_id', $testimonial->id)->delete();
        $rating = new TestimonialRating(['student_id' => 5, 'testimonial_id' => 5, 'rating' => 'positive']);
        $I->assertTrue( $rating->save() );
    }
    
    public function failAddBadStudent(UnitTester $I){
        $testimonial = Testimonial::find(5);
        TestimonialRating::where('testimonial_id', $testimonial->id)->delete();
        $rating = new TestimonialRating(['student_id' => 555555, 'testimonial_id' => 5, 'rating' => 'positive']);
        $I->assertFalse( $rating->save() );
    }
    
    public function failAddBadTestimonial(UnitTester $I){
        $testimonial = Testimonial::find(5);
        TestimonialRating::where('testimonial_id', $testimonial->id)->delete();
        $rating = new TestimonialRating(['student_id' => 5, 'testimonial_id' => 5555555, 'rating' => 'positive']);
        $I->assertFalse( $rating->save() );
    }
    
    public function failAddingRatingTwice(UnitTester $I){
        $testimonial = Testimonial::find(5);
        TestimonialRating::where('testimonial_id', $testimonial->id)->delete();
        $rating = new TestimonialRating(['student_id' =>5, 'testimonial_id' => 5, 'rating' => 'positive']);
        $I->assertTrue( $rating->save() );
        $rating = new TestimonialRating(['student_id' =>5, 'testimonial_id' => 5, 'rating' => 'positive']);
        $I->assertFalse( $rating->save() );
    }
    
    public function updateRating(UnitTester $I){
        $testimonial = Testimonial::find(5);
        TestimonialRating::where('testimonial_id', $testimonial->id)->delete();
        $rating = new TestimonialRating(['student_id' =>5, 'testimonial_id' => 5, 'rating' => 'positive']);
        $I->assertTrue( $rating->save() );
        $rating->rating = 'negative';
        $I->assertTrue( $rating->updateUniques() );
    }
    
    
     
        
}