<?php

class TestimonialRating extends ArdentUniqueWith {
	protected $fillable = ['student_id', 'testimonial_id'];
        public static $rules = [
            'testimonial_id' => 'required|exists:testimonials,id|unique_with:testimonial_ratings,student_id',
            'student_id' => 'required|exists:users,id'
        ];
        public static $relationsData = [];
}