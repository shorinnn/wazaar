<?php
use LaravelBook\Ardent\Ardent;

class InstructorAgency extends Ardent {
    
	protected $fillable = ['name'];
        
        public static $rules = [
            'name' => 'required|unique:instructor_agencies'
        ];
        
        public static $relationsData = [
            'instructors' => [self::HAS_MANY, 'Instructor', 'table' => 'users' ]
        ];
}