<?php

class CoursesController extends \BaseController {
    
        public function __constructor(){
            $this->beforeFilter( 'instructor', [ 'only' => ['create', 'store'] ] );
        }

	public function index()
	{
            $categories = CourseCategory::all();
            Return View::make('courses.index')->with(compact('categories'));
	}
        
        public function create(){
            $course = new Course;
            $difficulties = CourseDifficulty::lists('name', 'id');
            $categories = CourseCategory::lists('name', 'id');
            return View::make('courses.create')->with(compact('course'))->with(compact('difficulties'))->with(compact('categories'));
        }
        
        public function store(){
            $course = new Course( input_except(['_method', '_token']) );
            $course->instructor_id = Auth::user()->id;
            
            if($course->save()){
                // upload the preview image
                if (Input::hasFile('photo')){
                    $course->upload_preview();
                }
                return Redirect::action('CoursesController@show', $course->slug)
                        ->withSuccess( trans('crud/errors.object_created',['object' => 'Course']) );
            }
            else{
                return Redirect::back()
                        ->withError(trans('crud/errors.cannot_save_object',['object'=>'Course']).': '.format_errors($course->errors()->all()));
            }
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
                Session::set('url.intended', action('CoursesController@show', $slug));
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
