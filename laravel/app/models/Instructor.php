<?php

class Instructor extends User{
    protected $table = 'users';
    
    public static $relationsData = array(
        'courses' => array(self::HAS_MANY, 'Course'),
        'coursePreviewImages' => array(self::HAS_MANY, 'CoursePreviewImage'),
      );
}