<?php

class Instructor extends User{

    protected $table = 'users';

    public static $relationsData = [
        'courses' => [self::HAS_MANY, 'Course'],
        'coursePreviewImages' => [self::HAS_MANY, 'CoursePreviewImage'],
        'courseBannerImages' => [self::HAS_MANY, 'CourseBannerImage'],
        'profile' => [self::MORPH_ONE, 'Profile', 'name'=>'owner'],
        'followers' => [self::BELONGS_TO_MANY, 'Student',  'table' => 'follow_relationships',  'foreignKey' => 'instructor_id', 'otherKey' => 'student_id']
      ];
    
    public function totalSales(){
        $amount = 0;
        foreach($this->courses as $course){
             $amount += $course->sales->sum('purchase_price') + $course->lessonSales();
        }
        return $amount;
    }
    
    public function followed($student_id){
        
        if( in_array( $student_id, $this->followers()->lists('student_id') ) ) return true;
        return false;
    }
    
    public function notifyFollowers( $course ){
        $data['course'] = $course;
        $data['instructor'] = $this;
        if( $this->followers->count() > 0 ){
            foreach($this->followers as $follower){
                $data['follower'] = $follower;
                Mail::send('emails.course_published', $data, function($message) use($follower){
                    $message->to( $follower->email )->subject('New Course Published');
                });
            }
        }
    }


}