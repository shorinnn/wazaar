<?php

class CoursesController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'instructor', [ 'only' => ['create', 'store', 'myCourses', 'destroy', 'edit', 'update'] ] );
            $this->beforeFilter('csrf', ['only' => [ 'store', 'update', 'destroy', 'purchase' ]]);
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
            $subcategories = CourseSubcategory::arrayWithParent();
            $instructor = Instructor::find(Auth::user()->id);
            $images = $instructor->coursePreviewImages;
            $bannerImages = $instructor->courseBannerImages;
            return View::make('courses.form')->with(compact('course'))->with(compact('images'))->with(compact('bannerImages'))
                    ->with(compact('difficulties'))->with(compact('categories'))->with(compact('subcategories'));
        }
        
        public function store(){
            $data = input_except(['_method', '_token']);
            $course = new Course( $data );
            $course->instructor_id = Auth::user()->id;
            $course->course_preview_image_id = Input::get("course_preview_image_id");
            $course->course_banner_image_id = Input::get("course_banner_image_id");
            $course->who_is_this_for = json_encode(array_filter(Input::get('who_is_this_for')));
            $course->what_will_you_achieve = json_encode(array_filter(Input::get('what_will_you_achieve')));
            $course->sale = Input::get('sale');
            $course->sale_kind = Input::get('sale_kind');
            $course->sale_ends_on = Input::get('sale_ends_on');
            if($course->save()){
                // upload the preview image
                if (Input::hasFile('preview_image')){
                    if(!$course->upload_preview( Input::file('preview_image')->getRealPath() )){
                        return Redirect::action('CoursesController@show', $course->slug)
                        ->withError( trans('courses/general.course_created_image_error') );
                    }
                }
                // upload banner image
                if (Input::hasFile('banner_image')){
                    if(!$course->upload_banner( Input::file('banner_image')->getRealPath() )){
                        return Redirect::action('CoursesController@edit', $course->slug)
                        ->withError( trans('courses/general.course_created_image_error') );
                    }
                }
                return Redirect::action('CoursesController@show', $course->slug)
                        ->withSuccess( trans('crud/errors.object_created',['object' => 'Course']) );
            }
            else{
                return Redirect::back()->withInput()
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
            $subcategories = CourseSubcategory::arrayWithParent();
            $instructor = Instructor::find(Auth::user()->id);
            $images = $instructor->coursePreviewImages;
            $bannerImages = $instructor->courseBannerImages;
            return View::make('courses.form')->with(compact('course'))->with(compact('images'))->with(compact('bannerImages'))
                    ->with(compact('difficulties'))->with(compact('categories'))->with(compact('subcategories'));
        }
        
        public function update($slug){
            $course = Course::where('slug',$slug)->first();
            if($course->instructor->id != Auth::user()->id){
                return Redirect::action('CoursesController@index');
            }
            $data = input_except(['_method', '_token']);
            if( Input::has("course_preview_image_id") ) $course->course_preview_image_id = Input::get("course_preview_image_id");
            if( Input::has("course_banner_image_id") ) $course->course_banner_image_id = Input::get("course_banner_image_id");
            
            $course->fill($data);
            $course->who_is_this_for = json_encode(array_filter(Input::get('who_is_this_for')));
            $course->what_will_you_achieve = json_encode(array_filter(Input::get('what_will_you_achieve')));
            $course->sale = Input::get('sale');
            $course->sale_kind = Input::get('sale_kind');
            $course->sale_ends_on = Input::get('sale_ends_on');
            if($course->updateUniques()){
                // upload the preview image
                if (Input::hasFile('preview_image')){
                    if(!$course->upload_preview( Input::file('preview_image')->getRealPath() )){
                        return Redirect::action('CoursesController@edit', $course->slug)
                        ->withError( trans('courses/general.course_created_image_error') );
                    }
                }
                // upload banner image
                if (Input::hasFile('banner_image')){
                    if(!$course->upload_banner( Input::file('banner_image')->getRealPath() )){
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
            if( !$category = CourseCategory::where('slug',$slug)->first() ){
                 return View::make('site.error_encountered');
            }
            
            $courses = $category->courses()->orderBy('id','Desc')->paginate(9);
            Return View::make('courses.category')->with(compact('category'))->with(compact('courses'));
        }
        
        public function subCategory($slug='', $subcat=''){
            $category =  CourseCategory::where('slug',$slug)->first();
            if( !$subcategory = CourseSubcategory::where('slug',$subcat)->first() ){
                 return View::make('site.error_encountered');
            }
            $courses = $subcategory->courses()->orderBy('id','Desc')->paginate(9);
            Return View::make('courses.category')->with(compact('category'))->with(compact('courses'))->with(compact('subcategory'));
        }
        
        public function show($slug){
            if( !$course = Course::where('slug', $slug)->with('instructor')->first()){
                return View::make('site.error_encountered');
            }
            
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
