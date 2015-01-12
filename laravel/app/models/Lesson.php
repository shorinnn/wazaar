<?php
use LaravelBook\Ardent\Ardent;

class Lesson extends Ardent{

    public $fillable = ['name', 'order'];
    
    public static $relationsData = array(
        'module' => array(self::BELONGS_TO, 'Module'),
        'blocks' => array(self::HAS_MANY, 'Block'),
    );
    
     public static $rules = [
        'module_id' => 'required|exists:modules,id'
    ];
    
   

}