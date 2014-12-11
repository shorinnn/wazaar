<?php
use LaravelBook\Ardent\Ardent;

class Course extends Ardent{
    public static $relationsData = array(
        'courseCategory' => array(self::BELONGS_TO, 'CourseCategory'),
        'courseDifficulty' => array(self::BELONGS_TO, 'CourseDifficulty'),
        'courseDifficulty' => array(self::BELONGS_TO, 'CourseDifficulty'),
        'sales' => array(self::HAS_MANY, 'CoursePurchase'),
    );

}