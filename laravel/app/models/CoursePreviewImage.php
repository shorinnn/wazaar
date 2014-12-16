<?php
use LaravelBook\Ardent\Ardent;

class CoursePreviewImage extends Ardent{
    
    public static $relationsData = array(
        'courses' => array(self::HAS_MANY, 'Course', 'table' => 'courses', 'foreignKey' => 'course_preview_image_id'),
        'instructor' => array(self::BELONGS_TO, 'Instructor'),
    );

}