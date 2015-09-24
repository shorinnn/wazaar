<?php
use LaravelBook\Ardent\Ardent;
use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\ConfideUserInterface;
use Zizaco\Entrust\HasRole;


class RecommendedCourses extends Ardent
{  
    public $table = 'recommended_courses';
    public $fillable = ['course_id', 'recommended_courses'];

}