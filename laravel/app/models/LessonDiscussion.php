<?php
use LaravelBook\Ardent\Ardent;

class LessonDiscussion extends Ardent {
	protected $fillable = ['student_id', 'lesson_id', 'title'];
        public static $rules = [
            'lesson_id' => 'required|numeric',
            'student_id' => 'required|numeric',
            'title' => 'required'
        ];
        public static $relationsData = [
            'lesson' => array(self::BELONGS_TO, 'Lesson'),
            'student' => array(self::BELONGS_TO, 'Student'),
            'replies' =>[self::HAS_MANY, 'LessonDiscussionReply']
            
        ];
        
        public function vote($userId, $vote){
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