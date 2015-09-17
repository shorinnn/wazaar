<?php

class TestimonialsController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'auth', [ 'except' => 'more' ] );
            $this->beforeFilter( 'csrf', ['only' => [ 'store', 'update', 'destroy', 'rate' ]] );
        }
        
        public function store(){
            $course = Course::find( Input::get('id') );
            $student = Student::find( Auth::user()->id );
            if( $course==null || !$student->purchased( $course ) ){
                return Redirect::to('/');
            }
            Testimonial::create( [ 'student_id' => Auth::user()->id, 'course_id' => Input::get('id'), 
                'rating' => Input::get('rating'), 'content' => Input::get('content') ] );
            if( Request::ajax() ) return json_encode( ['status' => 'success'] );
            return Redirect::action('ClassroomController@dashboard', $course->slug);
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
        
        public function more(){
            $html = '';
            foreach( Testimonial::where('course_id', Input::get('course') )->orderBy('id', 'desc')
                    ->skip( Input::get('skip') )->limit(2)->get() as $testimonial ){
                $html.=  View::make('courses.testimonials.testimonial')->with( compact('testimonial') )->render();
            }
            return $html;
        }
        
        public function rate(){
            $rating = TestimonialRating::firstOrNew( ['student_id' => Auth::user()->id, 'testimonial_id' => Input::get('testimonial_id')] );
            $first_time_rating = ( !$rating->id ) ? true : false;
            $testimonial = Testimonial::find( Input::get('testimonial_id') );
            $old_rating = $rating->rating;
            $rating->rating = Input::get('rating');
            $rating->updateUniques();
            $testimonial->rate( $first_time_rating, $rating->rating, $old_rating );
            if( Request::ajax() ){
                return json_encode( ['status' => 'success'] );
            }
            else{
                return Redirect::back();
            }
        }
    
}
