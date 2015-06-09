<?php
use LaravelBook\Ardent\Ardent;

class Conversation extends Ardent{
    public $fillable = ['lesson_id', 'course_id','poster_id', 'reply_to', 'content'];
    
    public static $rules = [
        'poster_id' => 'required|exists:users,id',
        'content' => 'required'
     ];
    
    public static $relationsData = array(
        'poster' => array(self::BELONGS_TO, 'Student', 'foreignKey' => 'poster_id', 'otherKey' => 'id'),
        'lesson' => array(self::BELONGS_TO, 'Lesson', 'foreignKey' => 'lesson_id', 'otherKey' => 'id'),
        'course' => array(self::BELONGS_TO, 'Course', 'foreignKey' => 'course_id', 'otherKey' => 'id'),
        'replies' => array(self::HAS_MANY, 'Conversation', 'foreignKey' => 'reply_to', 'otherKey' => 'id'),
        'original' => array(self::BELONGS_TO, 'Conversation', 'foreignKey' => 'original_reply_to', 'otherKey' => 'id')
    );       

    private $_comments = null;
    public function page(){
        if( $this->_comments == null){
            $this->_comments = $this->course->comments()->where( 'lesson_id', null )->select('id')->orderBy('id','desc')->lists('id');
        }
        $startIndex = array_search($this->id, $this->_comments);
        return floor($startIndex / 2 ) + 1;
    }
    
    public function markRead(){
        $this->instructor_read = 'yes';
        $this->updateUniques();
    }
}