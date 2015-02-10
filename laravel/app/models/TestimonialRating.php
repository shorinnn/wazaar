<?php
use LaravelBook\Ardent\Ardent;

class TestimonialRating extends Ardent {
	protected $fillable = ['student_id', 'testimonial_id'];
        public static $rules = [
            'testimonial_id' => 'required|exists:testimonials,id|unique_with:testimonial_ratings,student_id',
            'student_id' => 'required|exists:users,id'
        ];
        public static $relationsData = [];
}