<?php

class CoursesController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'instructor', [ 'only' => ['create', 'store', 'myCourses', 'destroy', 'edit', 'update', 'curriculum', 'dashboard'] ] );
            $this->beforeFilter('csrf', ['only' => [ 'store', 'update', 'destroy', 'purchase', 'purchaseLesson' ]]);
        }

	public function index()
	{
            $categories = CourseCategory::all();
            Return View::make('courses.index')->with(compact('categories'));
	}
        
        public function create(){
            $course = new Course;
            $difficulties = CourseDifficulty::lists('name', 'id');
            $categories = ['' => trans('general.select')] + CourseCategory::lists('name', 'id');
            $subcategories = CourseSubcategory::arrayWithParent();
            $instructor = Instructor::find(Auth::user()->id);
            $images = $instructor->coursePreviewImages;
            $bannerImages = $instructor->courseBannerImages;
         
            return View::make('courses.create')->with(compact('difficulties'))->with(compact('categories'));
//            return View::make('courses.form')->with(compact('course'))->with(compact('images'))->with(compact('bannerImages'))
//                    ->with(compact('difficulties'))->with(compact('categories'))->with(compact('subcategories'));
        }
        
        public function store(){
            
            $data = input_except(['_method', '_token']);
            $course = new Course();
            $course->instructor_id = Auth::user()->id;
            $course->name = Input::get('name');
            $course->slug = Str::slug(Input::get('name'));
            if($course->save()){
                // notify followers
                Instructor::find( Auth::user()->id )->notifyFollowers( $course );
                
                if(Request::ajax()){
                    return $this->update( $course->slug );
                    $response = ['status' => 'success', 'url' => 'http://google.ro' ];
                    return json_encode($response);
                    
                    $response = ['status' => 'success', 'updateAction' => action('CoursesController@update', $course->slug) ];
                    return json_encode($response);
                }
                return Redirect::action('CoursesController@show', $course->slug)
                        ->withSuccess( trans('crud/errors.object_created',['object' => 'Course']) );
            }
            else{
                if(Request::ajax()){
                    $response = ['status' => 'error', 'errors' => format_errors($course->errors()->all())];
                    return json_encode($response);
                }
                return Redirect::back()->withInput()
                        ->withError(trans('crud/errors.cannot_save_object',['object'=>'Course']).': '.format_errors($course->errors()->all()));
            }
        }
        
         public function edit($slug){
            $course = Course::where('slug',$slug)->first();
            if($course->instructor->id != Auth::user()->id && $course->assigned_instructor_id != Auth::user()->id ){
                return Redirect::action('CoursesController@index');
            }
            $difficulties = CourseDifficulty::lists('name', 'id');
            $categories = CourseCategory::lists('name', 'id');
            $subcategories = CourseSubcategory::where('course_category_id',$course->course_category_id)->lists('name','id');
//            $instructor = Instructor::find(Auth::user()->id);
            $instructor = $course->instructor;
            $images = $instructor->coursePreviewImages;
            $bannerImages = $instructor->courseBannerImages;
            
            $assignedInstructor = $course->assignedInstructor;
            if($assignedInstructor!=null){
                $images = $images->merge( $assignedInstructor->coursePreviewImages );
                $bannerImages = $bannerImages->merge( $assignedInstructor->courseBannerImages );
            }
            $instructors =  Instructor::whereHas(
                'roles', function($q){
                    $q->where('name', 'instructor');
                }
            )->get();
            $assignableInstructors = ['null' => 'Not Assigned'];
            foreach($instructors as $i){
                $assignableInstructors[$i->id] = $i->commentName();
            }
            return View::make('courses.form')->with(compact('course'))->with(compact('images'))->with(compact('bannerImages'))
                    ->with(compact('difficulties'))->with(compact('categories'))->with(compact('subcategories'))->with(compact('assignableInstructors'));
        }
        
        public function update($slug){
            $course = Course::where('slug',$slug)->first();
            if($course->instructor->id != Auth::user()->id && $course->assigned_instructor_id != Auth::user()->id ){
                return Redirect::action('CoursesController@index');
            }
            $data = input_except(['_method', '_token']);
            if( Input::has("course_preview_image_id") ) $course->course_preview_image_id = Input::get("course_preview_image_id");
            if( Input::has("course_banner_image_id") ) $course->course_banner_image_id = Input::get("course_banner_image_id");
            
            $course->fill($data);
            if(!is_array(Input::get('who_is_this_for')) || count(Input::get('who_is_this_for') ==0 )){
                $course->who_is_this_for = json_encode([]);
            }
            else{
                $course->who_is_this_for = json_encode(array_filter(Input::get('who_is_this_for')));
            }
            
            if(!is_array(Input::get('what_will_you_achieve')) || count(Input::get('what_will_you_achieve') ==0 )){
                $course->what_will_you_achieve = json_encode([]);
            }
            else{
                $course->what_will_you_achieve = json_encode(array_filter(Input::get('what_will_you_achieve')));
            }
            $course->sale = Input::get('sale');
            $course->sale_kind = Input::get('sale_kind');
            $course->sale_ends_on = (Input::get('sale_ends_on')) ?  Input::get('sale_ends_on') : null;
            $course->ask_teacher = Input::get('ask_teacher');
            $course->details_displays = Input::get('details_displays');
            $course->assigned_instructor_id = Input::get('assigned_instructor_id');
            $course->show_bio = Input::get('show_bio');
            $course->custom_bio = Input::get('custom_bio');
            if($course->updateUniques()){
                if ( Input::hasFile('preview_image') ){
                    $img = $course->upload_preview( Input::file('preview_image')->getRealPath()); 
                    if( !$img ){
                        return json_encode(['status'=>'error', 'errors' => trans('courses/general.course_created_image_error')]);
                    }
                    else{
                        return json_encode(['status'=>'success', 'html'=> View::make('courses.preview_image')->with(compact('img'))->render() ]);
                    }
                }
                // upload banner image
                if (Input::hasFile('banner_image')){
                    $img = $course->upload_banner( Input::file('banner_image')->getRealPath());
                    if( !$img ){
                        return json_encode(['status'=>'error', 'errors' => trans('courses/general.course_created_image_error')]);
                    }
                    else{
                        return json_encode(['status'=>'success', 'html'=> View::make('courses.preview_image')->with(compact('img'))->render() ]);
                    }
                }
                if(Request::ajax()){
                    $response = ['status' => 'success', 'url' => action('CoursesController@curriculum', $course->slug) ];
                    return json_encode($response);
                }
                return Redirect::action('CoursesController@edit', $course->slug)
                        ->withSuccess( trans('crud/errors.object_updated',['object' => 'Course']) );
            }
            else{
                if(Request::ajax()){
                    $response = ['status' => 'error', 'errors' => format_errors($course->errors()->all())];
                    return json_encode($response);
                }
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
 
            
            $courses = $category->courses()->with('courseDifficulty')->with('courseCategory')->with('courseSubcategory')->with('previewImage')
                    ->where('featured',0)->where('privacy_status','public')->orderBy('id','Desc')->paginate(9);
            Return View::make('courses.category')->with(compact('category'))->with(compact('courses'));
        }
        
        public function subCategory($slug='', $subcat=''){
            $category =  CourseCategory::where('slug',$slug)->first();
            if( !$subcategory = CourseSubcategory::where('slug',$subcat)->first() ){
                 return View::make('site.error_encountered');
            }
            $courses = $subcategory->courses()->with('courseDifficulty')->with('courseCategory')->with('courseSubcategory')->with('previewImage')
                    ->where('featured',0)->where('privacy_status','public')->orderBy('id','Desc')->paginate(9);
            Return View::make('courses.category')->with(compact('category'))->with(compact('courses'))->with(compact('subcategory'));
        }
        
        public function show($slug){
            $course = Course::where('slug', $slug)->with('instructor')
                    ->with(['modules.lessons' => function($query){
                        $query->where('published', 'yes');
                        $query->orderBy('order','asc');
                    }])
                    ->with(['modules' => function($query){
                        $query->orderBy('order','asc');
                    }])
                    ->with(['testimonials' => function($query){
                        $query->limit(2);
                        $query->where('rating', 'positive');
                        $query->where('reported', 'no');
                        $query->orderBy( DB::raw('RAND()') );
                    }])
                    ->first();
            if( $course==null)   {
                return View::make('site.error_encountered');
            }
            $instructor = $course->instructor;
            if( $course->assigned_instructor_id != null && $course->details_displays == 'assigned_instructor'){
                $instructor = $course->assignedInstructor;
            }
            
            $course->allTestimonials = $course->testimonials()->orderBy('id', 'desc')->limit(2)->get();
            if(Input::has('aid')){
                Cookie::queue("aid-$course->id", Input::get('aid'), 60*24*30);
                // store this in the DB as well, in case the cookies get deleted
                if(Auth::check()) {
                    $student = Student::find(Auth::user()->id);
                    $student->saveReferral(Input::get('aid'), $course->id);
                }
            }
            $video = $course->videoBlocks();
            if($video!=null) $video = $video->first();
            Return View::make('courses.show')->with(compact('course'))->with(compact('student'))->with( compact('video') )->with( compact('instructor') );
        } 
        
        public function purchase($slug){
            if(Auth::guest()){
                Session::set('url.intended', action('CoursesController@show', $slug));
                return Redirect::to('login')->withError( trans('courses/general.login_to_purchase') );
            }
            
            $course = Course::where('slug', $slug)->first();
            $student = Student::current(Auth::user());
            
            if( $student->purchase( $course, Cookie::get( "aid-$course->id" ) ) ){
                // unset the affiliate cookie
                Cookie::queue("aid-$course->id", null, -1);
                return Redirect::action('ClassroomController@dashboard', $slug);
            }
            else{
                return Redirect::action('CoursesController@show', $slug)->withError( trans('courses/general.purchase_failed') );
            }
            
        }
        
        public function purchaseLesson($slug, $lesson){
            if(Auth::guest()){
                Session::set('url.intended', action('CoursesController@show', $slug));
                return Redirect::to('login')->withError( trans('courses/general.login_to_purchase') );
            }
            
            $course = Course::where('slug', $slug)->first();
            $student = Student::current(Auth::user());
            $lesson = Lesson::find( $lesson );
            if( $student->purchase( $lesson, Cookie::get( "aid-$course->id" ) ) ){
                return Redirect::action('ClassroomController@dashboard', $slug);
            }
            else{
                return Redirect::action('CoursesController@show', $slug)->withError( trans('courses/general.purchase_failed') );
            }
            
        }
        
        public function destroy($id){
            $course = Course::find($id);
            if( $course->instructor->id == Auth::user()->id && $course->assigned_instructor_id != Auth::user()->id ){
                $course->delete();
                if(Request::ajax()){
                    $response = ['status' => 'success' ];
                    return json_encode($response);
                }
                return Redirect::back()->withSuccess( trans('crud/errors.object_deleted',['object'=>'Course']));
            }
            else{
                if(Request::ajax()){
                    $response = ['status' => 'error', 'errors' => trans('crud/errors.cannot_delete_object',['object'=>'Course']) ];
                    return json_encode($response);
                }
                return Redirect::back()->withError( trans('crud/errors.cannot_delete_object',['object'=>'Course']) );
            }
        }
        
        public function curriculum($slug){
            $course = Course::where('slug',$slug)->first();
            if( $course==null || $course->instructor->id != Auth::user()->id && $course->assigned_instructor_id != Auth::user()->id ){
                return Redirect::to('/');
            }
            return View::make('courses/instructor/curriculum')->with(compact('course'));
        }
        
        public function dashboard($slug){
            $course = Course::where('slug',$slug)->first();
            if( $course==null || $course->instructor->id != Auth::user()->id && $course->assigned_instructor_id != Auth::user()->id ){
                return Redirect::to('/');
            }
            $instructor = Instructor::find( Auth::user()->id );
            $announcements = $instructor->sentMessages()->where('course_id', $course->id)
                    ->where("type",'mass_message')->orderBy('id','desc')->paginate( 2 );
            if(Request::ajax()){
                 return View::make('courses/instructor/dashboard/announcements')->with(compact('course'))->with( compact('announcements') );
            }
            return View::make('courses/instructor/dashboard')->with(compact('course'))->with( compact('announcements') );
        }
        
        
}
