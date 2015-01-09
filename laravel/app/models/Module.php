<?php
use LaravelBook\Ardent\Ardent;

class Module extends Ardent{

    public $fillable = ['name', 'order'];
    
    public static $relationsData = array(
        'course' => array(self::BELONGS_TO, 'Course'),
        'lessons' => array(self::HAS_MANY, 'Lesson'),
    );
    
     public static $rules = [
        'course_id' => 'required|exists:courses,id'
    ];
    
   

}