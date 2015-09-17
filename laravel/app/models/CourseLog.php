<?php
use LaravelBook\Ardent\Ardent;
use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\ConfideUserInterface;
use Zizaco\Entrust\HasRole;


class CourseLog extends Ardent
{  
    public $table = 'course_log';
    public $fillable = ['user_id', 'courses_viewed'];

}