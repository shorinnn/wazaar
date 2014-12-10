<?php
use LaravelBook\Ardent\Ardent;

class CourseCategory extends Ardent{
    
    public static $relationsData = array(
        'courses' => array(self::HAS_MANY, 'Course', 'table' => 'courses', 'foreignKey' => 'course_category_id'),
    );

}