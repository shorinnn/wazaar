<?php

class TestimonialRating extends CocoriumArdent {
	protected $fillable = ['student_id', 'testimonial_id'];
        public static $rules = [
            'testimonial_id' => 'required|exists:testimonials,id|unique_with:testimonial_ratings,student_id',
            'student_id' => 'required|exists:users,id'
        ];
        public static $relationsData = [];
}