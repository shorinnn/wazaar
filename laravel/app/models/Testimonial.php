<?php

class Testimonial extends ArdentUniqueWith{
    public $thumbs = null;
    public $rated_as = null;
    public $rate_update = false;
    public $fillable = ['course_id', 'student_id', 'content', 'rating'];
    public static $rules = [
        'course_id' => 'required|exists:courses,id|unique_with:testimonials,student_id',
        'student_id' => 'required|exists:users,id'
     ];
    
    
    public static $relationsData = [
        'student' => [ self::BELONGS_TO, 'Student', 'table' => 'users', 'foreignKey' => 'student_id' ],
        'course' => [ self::BELONGS_TO, 'Course', 'table' => 'courses', 'foreignKey' => 'course_id' ],
        'ratings' => [ self::HAS_MANY, 'TestimonialRating' ],
      ];
    
    public function thumbs(){
        if( $this->thumbs != null ) return $this->thumbs;
        $this->thumbs = $this->thumbs_up + $this->thumbs_down;
        return $this->thumbs;
    }
    
    public function afterSave(){
        if( $this->rate_update ){
            $this->rate_update = false;
            return true;
        }
        $course = Course::find( $this->course_id );
        $course->total_reviews = $course->testimonials()->where('reported','no')->count();
        if($course->total_reviews == 0 ) $course->reviews_positive_score = 100;
        else $course->reviews_positive_score = (100 * $course->testimonials()->where('reported','no')->where('rating', 'positive')->count() ) / $course->total_reviews;
        $course->updateUniques();
    }
    
    public function rate($first_time_rating, $rating, $old_rating){
        
        if( $first_time_rating ){ // first time rating
            if( $rating == 'positive' ) $this->thumbs_up++;
            else  $this->thumbs_down++;
        }
        else{ // update rating
            $this->rate_update = true;
            if($old_rating != $rating){//changed rating
                if( $rating == 'positive' ){
                    $this->thumbs_up++;
                    $this->thumbs_down--;
                }
                else{
                    $this->thumbs_up--;
                    $this->thumbs_down++;
                }
            }
        }
        $this->updateUniques();
    }
    
    public function ratedBy($user){
        if( $rating = $this->ratings()->where('student_id', $user->id)->first() ){
            $this->rated_as = $rating->rating;
            return true;
        }
        return false;
    }
        

}