<?php
use LaravelBook\Ardent\Ardent;

class LessonDiscussion extends Ardent {
	protected $fillable = ['student_id', 'lesson_id', 'course_id', 'title', 'content'];
        public static $rules = [
            'lesson_id' => 'required|numeric|exists:lessons,id',
            'course_id' => 'required|numeric|exists:courses,id',
            'student_id' => 'required|numeric|exists:users,id',
            'title' => 'required'
        ];
        public static $relationsData = [
            'lesson' => array(self::BELONGS_TO, 'Lesson'),
            'student' => array(self::BELONGS_TO, 'User'),
            'replies' =>[self::HAS_MANY, 'LessonDiscussionReply']
            
        ];
        
        public function beforeSave(){
            $student = Student::find($this->student_id);
            $lesson = Lesson::find($this->lesson_id);
            if( !$student->purchased($lesson->module->course) && !$student->purchased( $lesson ) 
                    && $student->id != $lesson->module->course->instructor_id && $student->id != $lesson->module->course->assigned_instructor_id ){
                $this->errors()->add(0, 'Lesson Not Purchased' );
                return false;
            }
        }
        
        public function vote($userId, $vote){
            $student = Student::find( $userId );
            $lesson = Lesson::find( $this->lesson_id );
            if( !$student->purchased($lesson->module->course) && !$student->purchased( $lesson ) ){
                $this->errors()->add(0, 'Lesson Not Purchased' );
                return false;
            }
            
            $rating = LessonDiscussionRating::firstOrNew( ['student_id' => $userId, 'lesson_discussion_id' => $this->id ] );
            $first_time_rating = ( !$rating->id ) ? true : false;
            $old_rating = $rating->vote;
            $rating->vote = $vote;
            $rating->updateUniques();
            
        
            if( $first_time_rating ){ // first time rating
                if( $vote == 'up' ) $this->upvotes++;
                else  $this->upvotes--;
            }
            else{ // update rating

                if($old_rating != $vote){//changed rating
                    if( $vote == 'up' ){
                        $this->upvotes++;
                        if($this->upvotes==0) $this->upvotes++;
                    }
                    else{
                        $this->upvotes--;
                        if($this->upvotes==0) $this->upvotes--;
                    }
                }
            }
            if( $this->updateUniques() ) return $this->upvotes;
            return false;
        }
}