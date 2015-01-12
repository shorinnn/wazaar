<?php
use LaravelBook\Ardent\Ardent;

class Lesson extends Ardent{

    public $fillable = ['name', 'order'];
    
    public static $relationsData = array(
        'module' => array(self::BELONGS_TO, 'Module'),
    );
    
     public static $rules = [
        'module_id' => 'required|exists:modules,id'
    ];
    
   

}