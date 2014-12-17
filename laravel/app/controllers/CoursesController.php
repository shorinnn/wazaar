<?php

class CoursesController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'instructor', [ 'only' => ['create', 'store', 'myCourses', 'destroy', 'edit', 'update'] ] );
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
            $instructor = Instructor::find(Auth::user()->id);
            $images = $instructor->coursePreviewImages;
            return View::make('courses.form')->with(compact('course'))->with(compact('images'))
                    ->with(compact('difficulties'))->with(compact('categories'));
        }
        
        public function store(){
            $data = input_except(['_method', '_token']);
            $course = new Course( $data );
            $course->instructor_id = Auth::user()->id;
            $course->course_preview_image_id = Input::get("course_preview_image_id");
            if($course->save()){
                // upload the preview image
                if (Input::hasFile('preview_image')){
                    if(!$course->upload_preview( Input::file('preview_image')->getRealPath() )){
                        return Redirect::action('CoursesController@show', $course->slug)
                        ->withError( trans('courses/general.course_created_image_error') );
                    }
                }
                return Redirect::action('CoursesController@show', $course->slug)
                        ->withSuccess( trans('crud/errors.object_created',['object' => 'Course']) );
            }
            else{
                return Redirect::back()
                        ->withError(trans('crud/errors.cannot_save_object',['object'=>'Course']).': '.format_errors($course->errors()->all()));
            }
        }
        
         public function edit($slug){
            $course = Course::where('slug',$slug)->first();
            if($course->instructor->id != Auth::user()->id){
                return Redirect::action('CoursesController@index');
            }
            $difficulties = CourseDifficulty::lists('name', 'id');
            $categories = CourseCategory::lists('name', 'id');
            $instructor = Instructor::find(Auth::user()->id);
            $images = $instructor->coursePreviewImages;
            return View::make('courses.form')->with(compact('course'))->with(compact('images'))
                    ->with(compact('difficulties'))->with(compact('categories'));
        }
        
        public function update($slug){
            $course = Course::where('slug',$slug)->first();
            if($course->instructor->id != Auth::user()->id){
                return Redirect::action('CoursesController@index');
            }
            $data = input_except(['_method', '_token']);
            if( Input::has("course_preview_image_id") ) $course->course_preview_image_id = Input::get("course_preview_image_id");
            $course->fill($data);
            if($course->updateUniques()){
                // upload the preview image
                if (Input::hasFile('preview_image')){
                    if(!$course->upload_preview( Input::file('preview_image')->getRealPath() )){
                        return Redirect::action('CoursesController@edit', $course->slug)
                        ->withError( trans('courses/general.course_created_image_error') );
                    }
                }
                return Redirect::action('CoursesController@edit', $course->slug)
                        ->withSuccess( trans('crud/errors.object_updated',['object' => 'Course']) );
            }
            else{
                return Redirect::back()
                        ->withError(trans('crud/errors.cannot_save_object',['object'=>'Course']).': '.format_errors($course->errors()->all()));
            }
        }
        
        
        
        public function myCourses(){
            $instructor = Instructor::find(Auth::user()->id);
            $courses = $instructor->courses()->paginate(10);
            Return View::make('courses.myCourses')->with(compact('courses'));
        }
        
        public function categories(){
            $categories = CourseCategory::paginate(3);
            Return View::make('courses.categories')->with(compact('categories'));
        }
        
        public function category($slug=''){
            $category = CourseCategory::where('slug',$slug)->first();
            $courses = $category->courses()->paginate(9);
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
        
        public function destroy($id){
            $course = Course::find($id);
            if( $course->instructor->id == Auth::user()->id ){
                $course->delete();
                return Redirect::back()->withSuccess( trans('crud/errors.object_deleted',['object'=>'Course']));
            }
            else{
                return Redirect::back()->withError( trans('crud/errors.cannot_delete_object',['object'=>'Course']) );
            }
        }



}
