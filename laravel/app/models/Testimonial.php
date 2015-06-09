<?php

class Testimonial extends CocoriumArdent{
    public $autoPurgeRedundantAttributes = true;
    public $thumbs = null;
    public $current_user_rating = null;
    public $rate_update = false;
    public $skipped_after_save = false;
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
    
    public function beforeSave(){
        $this->clearTransient();
    }
    
    public function afterSave(){
        if( $this->rate_update ){
            $this->setTransient('rate_update',  false );
            $this->setTransient('skipped_after_save', true);    
            return;
        }
        $this->setTransient('skipped_after_save', false);
        $course = Course::find( $this->course_id );
        $course->total_reviews = $course->testimonials()->where('reported','no')->count();
        if($course->total_reviews == 0 ) $course->reviews_positive_score = 100;
        else $course->reviews_positive_score = (100 * $course->testimonials()->where('reported','no')->where('rating', 'positive')->count() ) / $course->total_reviews;
        $course->updateUniques();
    }
    
    public function rate($first_time_rating, $rating, $old_rating){
        $this->setTransient('rate_update',  true );
        
        if( $first_time_rating ){ // first time rating
            if( $rating == 'positive' ) $this->thumbs_up++;
            else  $this->thumbs_down++;
        }
        else{ // update rating
            
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
        if( $this->updateUniques() ) return true;
        return false;
    }
    
    public function ratedBy($user){
        if( $rating = $this->ratings()->where('student_id', $user->id)->first() ){
            $this->current_user_rating = $rating;
            return true;
        }
        return false;
    }
        

}