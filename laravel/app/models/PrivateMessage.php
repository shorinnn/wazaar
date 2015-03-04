<?php
use LaravelBook\Ardent\Ardent;

class PrivateMessage extends Ardent {
	protected $fillable = ['sender_id', 'recipient_id', 'thread_id', 'reply_to', 'content'];
        public static $rules = [
            'sender_id' => 'required|numeric|exists:users,id',
            'thread_id' => 'numeric',
            'content' => 'required'
        ];
        
        public static $relationsData = [
            'sender' => [ self::BELONGS_TO, 'User', 'foreignKey' => 'sender_id', 'otherKey' => 'id' ],
            'recipient' => [ self::BELONGS_TO, 'User', 'User', 'foreignKey' => 'recipient_id', 'otherKey' => 'id' ],
            'course' => [ self::BELONGS_TO, 'Course', 'foreignKey' => 'course_id', 'otherKey' => 'id' ],
            'lesson' => [ self::BELONGS_TO, 'Lesson', 'foreignKey' => 'lesson_id', 'otherKey' => 'id' ],
            'replies' => [ self::HAS_MANY, 'PrivateMessage', 'foreignKey' => 'thread_id', 'otherKey' => 'id' ],
        ];
        
        public function beforeSave(){
            if( $this->reply_to > 0 ){
                $original = self::find($this->reply_to);
                if( $original->recipient_id != $this->sender_id ) return false;
            }
            if( $this->type == 'mass_message' ){
                if( ( $this->course==null ) || $this->course->instructor->id != $this->sender_id ) return false;
            }
        }
        
        public function scopeUnread($query){
            return $query->where('status','unread')->where(function($query){
                $read = DB::table('private_messages_mass_statuses')->lists('private_message_id');
                if( count($read) > 0) return $query->whereNotIn('id', $read );
            });
        }
        
        public function _sender(){
            if($this->type=='ask_teacher'){
                if( $this->sender->id == $this->course->instructor->id ) return $this->sender->commentName('instructor');
                else return $this->sender->commentName('student');
            }
            return $this->sender->commentName('student');
        }
        
        public function massUnread($user_id){
            if($this->type!='mass_message') return false;
            if( PrivateMessagesMassStatus::where('private_message_id',$this->id)->where('recipient_id', $user_id)->where('status','read')->count()==0) return true;
            return false;
        }
        
        public function thread(){
            if($this->thread_id==0) return $this->id;
            else return $this->thread_id;
        }
}