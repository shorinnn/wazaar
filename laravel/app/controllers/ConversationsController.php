<?php

class ConversationsController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'auth' );
            $this->beforeFilter( 'csrf', ['only' => [ 'store', 'update', 'destroy' ]] );
        }
        
        public function store(){
            $conv = new Conversation(['poster_id' => Auth::user()->id, 'lesson_id' => Input::get('lesson'), 'content' => Input::get('content') ]);
            if( Input::get('reply_to') > 0) $conv->reply_to = Input::get('reply_to');
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
        
        public function replies($id){
            $comment = Conversation::find($id);
            $html = '';
            foreach($comment->replies()->orderBy('id','asc')->get() as $reply){
                $html.=  View::make('courses.classroom.conversations.conversation')->withComment( $reply )->render();
            }
            return $html;
        }
        
        public function viewReplies($id){
            $comment = Conversation::with(['replies' => function($query){
                $query->orderBy('id','desc');
            }])->find($id);
            
            return  View::make('courses.classroom.conversations.view_replies')->with(compact('comment'));
        }
        
        public function loadMore(){
            $lesson = Lesson::with('comments.replies')
                    ->with('comments.poster')->with(['comments' => function($query){
                        $query->limit(2);
                        $query->skip( Input::get('skip') );
                        $query->orderBy('id','desc');
                        
                    }])->find( Input::get('lesson') );
                    
            $html = '';
            foreach($lesson->comments as $reply){
                $html.=  View::make('courses.classroom.conversations.conversation')->withComment( $reply )->render();
            }
            return $html;
        }
        
        public function lesson($course, $slug){
            $course = Course::where('slug', $course)->first();
            $student = Student::find( Auth::user()->id );
            if( $course==null || !$student->purchased( $course ) ){
                return Redirect::to('/');
            }
//            $lesson = Lesson::where('slug', $slug)->with('comments.replies')
//                    ->with('comments.poster')->with(['comments' => function($query){
//                        $query->orderBy('id','desc');                        
//                    }])->first();
            $lesson = Lesson::where('slug', $slug)->first();
            $comments = $lesson->comments()->orderBy('id','desc')->where('reply_to', null)->paginate( 5 );
            $lesson->comments = $comments;
            if( $lesson==null || $lesson->module->course->id != $course->id ){
                return Redirect::to('/');
            }            
            
            return View::make('courses.classroom.conversations.lesson_conversations')->with(compact('course'))->with( compact('lesson') );
        }
        
        public function replyTo($id){
            $comment = Conversation::with('replies')->find($id);
            return View::make('courses.classroom.conversations.lesson_conversations')
                    ->withCourse($comment->lesson->module->course)
                    ->withLesson( $comment->lesson )
                    ->with(compact('comment'))
                    ->withReplyto($id);
        }
}
