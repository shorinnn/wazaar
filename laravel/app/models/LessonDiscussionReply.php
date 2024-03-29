<?php
use LaravelBook\Ardent\Ardent;

class LessonDiscussionReply extends Ardent {
	protected $fillable = ['student_id', 'lesson_discussion_id', 'content'];
        public static $rules = [
            'lesson_discussion_id' => 'required|numeric|exists:lesson_discussions,id',
            'student_id' => 'required|numeric|exists:users,id',
            'content' => 'required'
        ];
        public static $relationsData = [
            'discussion' => array(self::BELONGS_TO, 'LessonDiscussion', 'foreignKey' => 'lesson_discussion_id'),
            'student' => array(self::BELONGS_TO, 'User'),
        ];
        
        public function beforeSave(){
            $student = Student::find($this->student_id);
            $lesson = Lesson::find($this->discussion->lesson_id);
            if( !$student->purchased($lesson->module->course) && !$student->purchased( $lesson ) 
                     && $student->id != $lesson->module->course->instructor_id && $student->id != $lesson->module->course->assigned_instructor_id ){
                $this->errors()->add(0, 'Lesson Not Purchased' );
                return false;
            }
        }
        
        public function vote($userId, $vote){
            $student = Student::find($userId);
            $lesson = $this->discussion->lesson;
            
            if( !$student->purchased($lesson->module->course) && !$student->purchased( $lesson ) ){
                $this->errors()->add(0, 'Lesson Not Purchased' );
                return false;
            }
            
            $rating = LessonDiscussionReplyRating::firstOrNew( ['student_id' => $userId, 'lesson_discussion_reply_id' => $this->id ] );
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