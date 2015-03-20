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
                $original = PrivateMessage::find( $this->reply_to );
                if( $original->recipient_id != $this->sender_id ) return false;
            }
            if( $this->type == 'mass_message' ){
                if( ( $this->course==null ) || 
                        ( $this->course->instructor->id != $this->sender_id && $this->course->assigned_instructor_id != $this->sender_id )) return false;
            }
            if( $this->type == 'ask_teacher' &&  $this->course->instructor->id != $this->sender_id
                    &&  $this->course->assigned_instructor_id != $this->sender_id ){
                $student = Student::find( $this->sender_id );
                if( ( $this->recipient_id != $this->course->assigned_instructor_id ) && 
                    ( $this->recipient_id != $this->course->instructor_id ) ) return false;
                if( !$student->purchased($this->course) ) return false;
                // make sure course allows this 
                if( $this->course->ask_teacher == 'disabled' ) return false;
            }
        }
        
        public function scopeUnread($query, $user_id=0){
            return $query->where('status','unread')->where(function($query) use ( $user_id ){
                $read = DB::table('private_messages_mass_statuses')->where( 'recipient_id',$user_id )->lists('private_message_id');
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
        
        public function isUnread($user_id){
            if( ($this->type!='mass_message' && $this->status=='unread') || $this->massUnread($user_id) ) return true;
            return false;
        }
        
        public function markRead($user_id){
            if( $this->type=='mass_message' ){
                $read = new PrivateMessagesMassStatus( ['private_message_id' => $this->id, 'recipient_id' => $user_id, 'status' => 'read'] );
                $read->save();
            }
            else{
                if( $this->recipient_id == $user_id ){
                    $this->status='read';
                    $this->save();
                }
            }
        }
        private $_questions = null;
        public function inboxPage(){
            if( $this->_questions == null){
                $this->_questions = self::where('recipient_id', $this->recipient_id )->select('id')->orderBy('id','desc')->lists('id');
            }
            $startIndex = array_search($this->id, $this->_questions);
            return floor($startIndex / 2 ) + 1;
        }
}