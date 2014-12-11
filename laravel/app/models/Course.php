<?php
use LaravelBook\Ardent\Ardent;

class Course extends Ardent{
    public static $relationsData = array(
        'courseCategory' => array(self::BELONGS_TO, 'CourseCategory'),
        'courseDifficulty' => array(self::BELONGS_TO, 'CourseDifficulty'),
    );

}