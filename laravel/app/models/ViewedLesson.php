<?php
use LaravelBook\Ardent\Ardent;

class ViewedLesson extends Ardent{
    public $fillable = ['lesson_id', 'student_id'];
    
    public static $relationsData = [
        'lesson' => [ self::BELONGS_TO, 'Lesson' ],
        'student' => [ self::BELONGS_TO, 'Student', 'table' => 'users', 'foreignKey' => 'student_id' ],
    ];

}