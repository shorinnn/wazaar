<?php
use LaravelBook\Ardent\Ardent;

class Conversation extends Ardent{
    public $fillable = ['lesson_id', 'poster_id', 'reply_to', 'content'];
    
    public static $rules = [
        'lesson_id' => 'required|exists:lessons,id',
        'poster_id' => 'required|exists:users,id',
        'content' => 'required'
     ];
    
    public static $relationsData = array(
        'poster' => array(self::BELONGS_TO, 'Student', 'foreignKey' => 'poster_id', 'otherKey' => 'id'),
        'replies' => array(self::HAS_MANY, 'Conversation', 'foreignKey' => 'reply_to', 'otherKey' => 'id')
    );
    
        

}