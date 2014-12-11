<?php
use LaravelBook\Ardent\Ardent;

class CourseDifficulty extends Ardent{
    public static $relationsData = array(
        'courses' => array(self::HAS_MANY, 'Courses'),
    );

}