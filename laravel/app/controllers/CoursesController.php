<?php

class CoursesController extends \BaseController {

	public function index()
	{
            Return View::make('courses.index');
	}
        
        public function categories(){
            $categories = CourseCategory::paginate(3);
            Return View::make('courses.categories')->with(compact('categories'));
        }
        
        public function category($slug=''){
            $category = CourseCategory::where('slug',$slug)->first();
            $courses = $category->courses()->paginate(2);
            Return View::make('courses.category')->with(compact('category'))->with(compact('courses'));
        }
        
        public function show($slug){
            $course = Course::where('slug', $slug)->with('instructor')->first();

            if(Input::has('aid')){
                Cookie::queue("aid-$course->id", Input::get('aid'), 60*60*30);
            }
            Return View::make('courses.show')->with(compact('course'))->with(compact('student'));
        }
        
        public function purchase($slug){
            if(Auth::guest()){
                return Redirect::to('login')->withError( trans('courses/general.login_to_purchase') );
            }
            
            $course = Course::where('slug', $slug)->first();
            $student = Student::current(Auth::user());
            
            if($student->purchase($course, Cookie::get("aid-$course->id"))){
                // unset the affiliate cookie
                Cookie::queue("aid-$course->id", null, -1);
                return Redirect::action('CoursesController@show', $slug)->withSuccess( trans('courses/general.purchase_successful') );
            }
            else{
                return Redirect::action('CoursesController@show', $slug)->withError( trans('courses/general.purchase_failed') );
            }
            
        }



}
