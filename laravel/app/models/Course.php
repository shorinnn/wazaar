<?php
use LaravelBook\Ardent\Ardent;

class Course extends Ardent{
    public static $relationsData = array(
        'course_category' => array(self::BELONGS_TO, 'CourseCategory'),
    );

}