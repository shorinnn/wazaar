<?php
use LaravelBook\Ardent\Ardent;

class CourseReferral extends Ardent{
    public $fillable = ['course_id', 'student_id', 'affiliate_id'];
    
    public static $relationsData = array(
        'course' => array(self::BELONGS_TO, 'Course'),
        'affiliate' => array(self::BELONGS_TO, 'ProductAffiliate'),
        'student' => array(self::BELONGS_TO, 'Student'),
    );
    
     public static $rules = [
        'course_id' => 'required|exists:courses,id|unique_with:course_referrals,student_id',
        'student_id' => 'required|exists:users,id',
        'affiliate_id' => 'required|exists:users,id',
        'expires' => 'required|date'
     ];
    


}

