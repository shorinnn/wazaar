<?php
use LaravelBook\Ardent\Ardent;

class Module extends Ardent{

    public $fillable = ['name', 'order'];
    
    public static $relationsData = array(
        'course' => array(self::BELONGS_TO, 'Course'),
    );
    
   

}