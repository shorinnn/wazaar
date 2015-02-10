<?php
use LaravelBook\Ardent\Ardent;

class Testimonial extends Ardent{
    public $thumbs = null;
    public $fillable = ['course_id', 'student_id', 'content', 'rating'];
    public static $rules = [
        'course_id' => 'required|exists:courses,id|unique_with:testimonials,student_id',
        'student_id' => 'required|exists:users,id'
     ];
    
    public static $relationsData = [
        'student' => [ self::BELONGS_TO, 'Student', 'table' => 'users', 'foreignKey' => 'student_id' ],
        'course' => [ self::BELONGS_TO, 'Course', 'table' => 'course', 'foreignKey' => 'course_id' ],
      ];
    
    public function thumbs(){
        if( $this->thumbs != null ) return $this->thumbs;
        $this->thumbs = $this->thumbs_up + $this->thumbs_down;
        return $this->thumbs;
    }
    
    public function afterSave(){
        $course = Course::find( $this->course_id );
        $course->total_reviews = $course->testimonials()->where('reported','no')->count();
        if($course->total_reviews == 0 ) $course->reviews_positive_score = 100;
        else $course->reviews_positive_score = (100 * $course->testimonials()->where('reported','no')->where('rating', 'positive')->count() ) / $course->total_reviews;
        $course->updateUniques();
    }
        

}