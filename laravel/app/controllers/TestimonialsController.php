<?php

class TestimonialsController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'auth' );
            $this->beforeFilter( 'csrf', ['only' => [ 'store', 'update', 'destroy' ]] );
        }
        
        public function store(){
            $course = Course::find( Input::get('id') );
            $student = Student::find( Auth::user()->id );
            if( $course==null || !$student->purchased( $course ) ){
                return Redirect::to('/');
            }
            Testimonial::create( [ 'student_id' => Auth::user()->id, 'course_id' => Input::get('id'), 'content' => Input::get('content') ] );
            return Redirect::action('ClassroomController@testimonial', $course->slug);
        }
        
        public function update($id){
            $testimonial = Testimonial::find($id);
            
            $course = Course::find( Input::get('id') );
            $student = Student::find( Auth::user()->id );
            if( $testimonial->student_id != Auth::user()->id || $course==null || !$student->purchased( $course ) ){
                return Redirect::to('/');
            }
            $testimonial->content = Input::get('content');
            $testimonial->rating = Input::get('rating');
            $testimonial->updateUniques();
            return Redirect::action('ClassroomController@testimonial', $course->slug);
        }
    
}
