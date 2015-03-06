<?php

class ConversationsController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'auth' );
            $this->beforeFilter( 'csrf', ['only' => [ 'store', 'update', 'destroy' ]] );
        }
        
        public function store(){
            $student = Student::find( Auth::user()->id );
            if( Input::has('lesson') ){
                $lesson = Lesson::find( Input::get('lesson') );
                if( !$student->purchased($lesson->module->course) && !$student->purchased( $lesson ) ){
                     return Redirect::to('/');
                }
                $conv = new Conversation(['poster_id' => Auth::user()->id, 'lesson_id' => Input::get('lesson'), 'content' => Input::get('content') ]);
            }
            else{
                $course = Course::find( Input::get('course') );
                if( !$student->purchased($course) ){
                     return Redirect::to('/');
                }
                $conv = new Conversation(['poster_id' => Auth::user()->id, 'course_id' => Input::get('course'), 'content' => Input::get('content') ]);
            }
            if( Input::get('reply_to') > 0) {
                $original = Conversation::find( Input::get('reply_to') );
                if($original->reply_to > 0){
                    $conv->reply_to = $original->reply_to;
                    $conv->original_reply_to = Input::get('reply_to');
                }
                else{
                    $conv->reply_to = Input::get('reply_to');
                }
            }
            if( $conv->save() ){
                if( Request::ajax() ){
                    return json_encode( ['status'=>'success', 
                        'html' => View::make('courses.classroom.conversations.conversation')->withComment( $conv )->render()  ]);
                }
                else{
                    return Redirect::back();
                }
            }
            else{
                if( Request::ajax() ){
                    return json_encode( ['status'=>'error', 'errors' => format_errors($conv->errors()->all()) ]);
                }
                else{
                    return Redirect::back()->withErrors( format_errors($conv->errors()->all()) );
                }
            }
            
        }
        
        public function replies($id, $skip=0){
            $comment = Conversation::find($id);
            $student = Student::find(Auth::user()->id);
            if($comment->lesson_id > 0 && !$student->purchased($comment->lesson->module->course) ){
                 return Redirect::to('/');
            }
            if($comment->course_id > 0 && !$student->purchased($comment->course) ){
                 return Redirect::to('/');
            }
            $html = '';
            foreach($comment->replies()->orderBy('id','asc')->take( $comment->replies()->count() - $skip )->get() as $reply){
                $html.=  View::make('courses.classroom.conversations.conversation')->withComment( $reply )->render();
            }
            return $html;
        }
        
        public function viewReplies($id){
            $comment = Conversation::with(['replies' => function($query){
                $query->orderBy('id','desc');
            }])->find($id);
            
            $student = Student::find(Auth::user()->id);
            if( !$student->purchased($comment->lesson->module->course) ){
                 return Redirect::to('/');
            }
            return  View::make('courses.classroom.conversations.view_replies')->with(compact('comment'));
        }
        
        public function loadMore(){
            $lesson = Lesson::with('comments.replies')
                    ->with('comments.poster')->with(['comments' => function($query){
                        $query->limit(2);
                        $query->skip( Input::get('skip') );
                        $query->orderBy('id','desc');
                        $query->where('reply_to',null);
                        
                    }])->find( Input::get('lesson') );
                    
            $student = Student::find(Auth::user()->id);
            if( !$student->purchased($lesson->module->course) ){
                 return Redirect::to('/');
            }
                    
            $html = '';
            foreach($lesson->comments as $reply){
                $html.=  View::make('courses.classroom.conversations.conversation')->withComment( $reply )->render();
            }
            return $html;
        }
        
        public function lesson($course, $module, $slug){
            $course = Course::where('slug', $course)->first();
            $student = Student::find( Auth::user()->id );
            if( $course==null || !$student->purchased( $course ) ){
                return Redirect::to('/');
            }
            $module = $course->modules()->where('slug', $module)->first();
            $lesson = $module->lessons()->where('slug', $slug)->first();
//            $lesson = Lesson::where('module_id', $module)->where('slug', $slug)->first();
            $comments = $lesson->comments()->orderBy('id','desc')->where('reply_to', null)->paginate( 5 );
            $lesson->comments = $comments;
            if( $lesson==null || $lesson->module->course->id != $course->id ){
                return Redirect::to('/');
            }            
            
            return View::make('courses.classroom.conversations.lesson_conversations')->with( compact('course') )->with( compact('lesson') );
        }
        
        public function replyTo($id){
            $comment = Conversation::with('replies')->find($id);
            $student = Student::find(Auth::user()->id);
            if( !$student->purchased($comment->lesson->module->course) ){
                 return Redirect::to('/');
            }
            $comment->lesson->comments = $comment->lesson->comments()->paginate();
            return View::make('courses.classroom.conversations.lesson_conversations')
                    ->withCourse($comment->lesson->module->course)
                    ->withLesson( $comment->lesson )
                    ->with(compact('comment'))
                    ->withReplyto($id);
        }
}
