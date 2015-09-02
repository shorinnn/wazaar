<?php

class CoursesController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'instructor', [ 'only' => ['create', 'store', 'myCourses', 'destroy', 'edit', 'update', 'curriculum', 'dashboard',
                'customPercentage', 'updateExternalVideo', 'removePromo'] ] );
            $this->beforeFilter('csrf', ['only' => [ 'store', 'update', 'destroy', 'purchase', 'purchaseLesson', 'submitForApproval' ]]);

            
        }

	public function index()
	{
            $categories = CourseCategory::all();
            Return View::make('courses.index')->with(compact('categories'));
	}
        
        public function create(){
            $course = new Course;
            $difficulties = CourseDifficulty::lists('name', 'id');
            $categories = ['' => trans('courses/general.category')  ] + CourseCategory::lists('name', 'id');
            $subcategories = CourseSubcategory::arrayWithParent();
            $instructor = Instructor::find(Auth::user()->id);
            $images = $instructor->coursePreviewImages;
            $bannerImages = $instructor->courseBannerImages;
            
            return View::make('courses.create')->with( compact('difficulties', 'categories') );
        }
        
        public function store(){
            
            $data = input_except(['_method', '_token']);
            $course = new Course();
            $course->instructor_id = Auth::user()->id;
            $course->name = Input::get('name');
            $course->slug = Str::slug(Input::get('name'));
            $course->course_category_id = Input::get('course_category_id');
            $course->course_subcategory_id = Input::get('course_subcategory_id');
            $course->free = Input::get('free');
            if($course->save()){
                // notify followers
//                Instructor::find( Auth::user()->id )->notifyFollowers( $course );
                
                if(Request::ajax()){
//                    dd($course);
                    $response = ['status' => 'success', 'url' => action('CoursesController@edit', $course->slug) ];
                    return json_encode($response);
//                    return $this->update( $course->slug );
//                    $response = ['status' => 'success', 'url' => 'http://google.ro' ];
//                    return json_encode($response);
//                    
//                    $response = ['status' => 'success', 'updateAction' => action('CoursesController@update', $course->slug) ];
//                    return json_encode($response);
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
        
         public function edit($slug, $step=0){
            // delete dashboard modules
            foreach( Module::where('order','99999')->get() as $m ){
                $m->delete();
            }
            // delete dashboard modules
            
            $course = Course::where('slug',$slug)->first();
            if($course->instructor->id != Auth::user()->id && $course->assigned_instructor_id != Auth::user()->id ){
                if( !admin() ){
                    return Redirect::action('CoursesController@indexz');
                }
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
//            $instructors =  Instructor::whereHas(
//                'roles', function($q){
//                    $q->where('name', 'instructor');
//                }
//            )->get();
            $assignableInstructors = ['null' => 'Not Assigned'];
//            foreach($instructors as $i){
//                $assignableInstructors[$i->id] = $i->commentName();
//            }

            $awsPolicySig = UploadHelper::AWSPolicyAndSignature();
            $uniqueKey = Str::random();
            
            $filePolicy = UploadHelper::AWSAttachmentsPolicyAndSignature();
            
//            $affiliates = ProductAffiliate::arrayWithProfile();
            $affiliates = [];


            switch($step){
                case 0: $view = 'courses.editor.form'; break;
                case 1: $view = 'courses.editor.step1'; break;
                case 2: $view = 'courses.editor.step2'; break;
                case 3: $view = 'courses.editor.step3'; break;
            }
            
            if(Input::has('old-ui')){
                return View::make('courses.form_DEPRECATED',compact('awsPolicySig','uniqueKey' ,'course', 'images', 'bannerImages', 'assignedInstructor', 'difficulties'))
                        ->with(compact('categories', 'subcategories', 'assignableInstructors', 'affiliates', 'filePolicy' ));
            }


            return View::make($view,compact('awsPolicySig','uniqueKey' ,'course', 'images', 'bannerImages', 'assignedInstructor', 'difficulties'))
                    ->with(compact('categories', 'subcategories', 'assignableInstructors', 'affiliates', 'filePolicy' ));
        }
        
        
        public function customPercentage($slug){
            $course = Course::where('slug',$slug)->first();
            
            if($course->instructor->id != Auth::user()->id && $course->assigned_instructor_id != Auth::user()->id ){
                return Redirect::action('CoursesController@index');
            }
            
            $affiliates = [0 => 'Select...'] + ProductAffiliate::arrayWithProfile();
            
            return View::make( 'courses.custom_percentages',compact('course', 'affiliates') );
        }
        
        public function update($slug){
            $course = Course::where('slug',$slug)->first();
            
            if(!admin() && $course->instructor->id != Auth::user()->id && $course->assigned_instructor_id != Auth::user()->id ){
//                if( admin() ){
//                    if( Request::ajax() ){
//                        $response = ['status' => 'success', 'url' => action('CoursesController@edit', $course->slug) ];
//                        return json_encode($response);
//                    }
//                    return Redirect::action('CoursesController@edit', $course->slug)
//                            ->withSuccess( trans('crud/errors.object_updated',['object' => 'Course']) );
//                }
                
                return Redirect::action('CoursesController@index');
            }
            if( Input::has('publish_status') && Input::get('publish_status')==1 ){
                $course->publish_status = 'pending';
            }
            
            $data = input_except([ '_method', '_token', 'publish_status', 'slug' ]);
            if( Input::has("course_preview_image_id") ) $course->course_preview_image_id = Input::get("course_preview_image_id");
            if( Input::has("course_banner_image_id") ) $course->course_banner_image_id = Input::get("course_banner_image_id");
            
            $course->fill($data);
            if( Config::get('custom.use_id_for_slug')==false && Input::has('slug') ) $course->slug = Input::get('slug'); 
            if(Input::has('who_is_this_for') ) $course->who_is_this_for = json_encode(array_filter(Input::get('who_is_this_for')));
            if(Input::has('what_will_you_achieve') ) $course->what_will_you_achieve = json_encode(array_filter(Input::get('what_will_you_achieve')));
            if(Input::has('requirements') ) $course->requirements = json_encode(array_filter(Input::get('requirements')));
            if(Input::has('sale') ){
                $course->sale = Input::get('sale');
                $course->sale_kind = 'amount';
            }
//            if(Input::has('sale_kind') ) $course->sale_kind = Input::get('sale_kind');
            if(Input::has('sale_starts_on') ) $course->sale_starts_on = (Input::get('sale_starts_on')) ?  date('Y-m-d H:i:s', strtotime(Input::get('sale_starts_on')) ) : null;
            if(Input::has('sale_ends_on') ) $course->sale_ends_on = (Input::get('sale_ends_on')) ?  date('Y-m-d H:i:s', strtotime(Input::get('sale_ends_on')) ) : null;
            if(Input::has('ask_teacher') ) $course->ask_teacher = Input::get('ask_teacher');
            if(Input::has('details_displays') ) $course->details_displays = Input::get('details_displays');
            $notify_assigned = false;
            if(Input::has('assigned_instructor_id') ){
                if( Input::get('assigned_instructor_id') != 0 && Input::get('assigned_instructor_id') !=  $course->assigned_instructor_id ){
                    $notify_assigned = true;
                }
                $course->assigned_instructor_id = Input::get('assigned_instructor_id') == 0 ? null : Input::get('assigned_instructor_id');
            }
            if(Input::has('show_bio') ) $course->show_bio = Input::get('show_bio');
            if(Input::has('custom_bio') ) $course->custom_bio = Input::get('custom_bio');
            if($course->updateUniques()){
                if ( $notify_assigned ){
                    $instructor = $course->instructor;
                    $assigned = $course->assignedInstructor;
                    Mail::send(
                        'emails.assigned_instructor',
                        compact('instructor' , 'assigned' , 'course' ),
                        function ($message) use ($instructor, $assigned) {
                            $message->getHeaders()->addTextHeader('X-MC-Important', 'True');
                            $message
                                ->to($assigned->email, $assigned->email)
                                ->subject( 'Wazaar Assignment' );
                        }
                    );
                }
                if ( Input::hasFile('preview_image') ){
                    $img = $course->upload_preview( Input::file('preview_image')->getRealPath()); 
                    if( !$img ){
                        return json_encode(['status'=>'error', 'errors' => trans('courses/general.course_created_image_error')]);
                    }
                    else{
//                        return json_encode(['status'=>'success', 'html'=> View::make('courses.preview_image')->with(compact('img'))->render() ]);
                        return json_encode(['status'=>'success', 'html'=> "<img src='$img->url' height=100 />", 
                            'option' => View::make('courses.preview_image')->with(compact('img', 'course'))->render() ]);
                    }
                }
                // upload banner image
                if (Input::hasFile('banner_image')){
                    $img = $course->upload_banner( Input::file('banner_image')->getRealPath());
                    if( !$img ){
                        return json_encode(['status'=>'error', 'errors' => trans('courses/general.course_created_image_error')]);
                    }
                    else{
                        return json_encode(['status'=>'success', 'html'=> "<img src='$img->url' height=100 />" ]);
//                        return json_encode(['status'=>'success', 'html'=> View::make('courses.preview_image')->with(compact('img'))->render() ]);
                    }
                }
                if( Request::ajax() ){
                    $response = ['status' => 'success', 'url' => action('CoursesController@edit', $course->slug) ];
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
        
        public function submitForApproval($slug){
            $course = Course::where('slug',$slug)->first();
            if($course->instructor->id != Auth::user()->id && $course->assigned_instructor_id != Auth::user()->id ){
                return Redirect::action('CoursesController@index');
            }
            $course->publish_status = 'pending';
            $course->updateUniques();
            if( Request::ajax() ){
                $response = ['status' => 'success' ];
                return json_encode($response);
            }
            return Redirect::back();
        }
        
        public function searchInstructor($email=''){
            $instructor = Instructor::where('email', $email)->first();
            if( $instructor==null ) return 0;
            if( !$instructor->hasRole('Instructor') ) return 0;
            return $instructor->id;
        }
        
        public function myCourses(){
            
            $instructor = Instructor::find(Auth::user()->id);
            if( $instructor->accepted_instructor_terms!='yes' ){
                return Redirect::action('InstructorsController@acceptTerms');
            }
            $courses = $instructor->courses()
                    ->with( [ 'dashboardComments' => function($query){
                        $query->where('instructor_read', 'no');
                    } ] )
                    ->paginate(10);
            Return View::make('courses.myCourses')->with(compact('courses'));
        }
        
        public function categories(){
            $categories = CourseCategory::paginate(3);
            Return View::make('courses.categories')->with(compact('categories'));
        }
        
        public function category($slug=''){
            $difficultyLevel = Input::get('difficulty') ?: null;
            $sort = null;
            $wishlisted = [];
            if( Auth::check() ){
                $student = Student::find( Auth::user()->id );
                $wishlisted = $student->wishlistItems()->lists( 'course_id' );
            }
            if (Input::has('sort')){
                if ( Input::get('sort') == 'best-at' || Input::get("sort") == 'best-m' || Input::get("sort") == 'best-w' ){
                    
                    switch(Input::get('sort')){
                        case 'best-at': $timeframe = 'AT'; break;
                        case 'best-m': $timeframe = 'LM'; break;
                        case 'best-w': $timeframe = 'LW'; break;
                        default: $timeframe = 'AT';
                    }
                    
                    $courseHelper = new CourseHelper();
                    $category = new stdClass;
                    $category->color_scheme = $category->name = $category->description = $category->id =  '';
                    $order = ( Input::get('sort') == 'best-selling-low' ) ? 'ASC' : 'DESC';
                    $courses = $courseHelper->bestSellers($slug, $timeframe, 9, ['course_difficulty_id' => $difficultyLevel], $order);
                    if(Request::ajax() ) Return View::make('courses.categories.courses')->with( compact( 'category', 'courses', 'wishlisted' ) );
                    return View::make('courses.categories.category')->with( compact( 'category', 'difficultyLevel', 'courses', 'wishlisted') );
                }

                $sort = Input::get('sort');
            }

            if($slug==''){
                $courses = Course::with('courseDifficulty')->with('courseCategory')->with('courseSubcategory')->with('previewImage')
                    ->where(function($query){
//                        $query->where('featured',0)
                        $query->where('publish_status', 'approved')
                        ->where('privacy_status','public')
                        ->orWhere(function($query2){
                            $query2->where('privacy_status','public')
//                                    ->where('featured',0)
                                    ->where('publish_status', 'pending')
                                    ->where('pre_submit_data', '!=', "");
                        });
                    });

                if (!empty($difficultyLevel)){
                    $courses = $courses->where('course_difficulty_id', $difficultyLevel);
                }

                if ($sort == 'date'){
                    $courses = $courses->orderBy('created_at','desc');
                }
                else if ($sort == 'date-oldest'){
                    $courses = $courses->orderBy('created_at','asc');
                }
                else{
                    $courses = $courses->orderBy('id','desc');
                }
                
                $courses = $courses->paginate(9);

                $category = new stdClass;
                $category->color_scheme = $category->name = $category->description = $category->id =  '';
                if( Request::ajax() ) Return View::make('courses.categories.courses')->with(compact('category','courses', 'wishlisted' ));
                
                Return View::make('courses.categories.category')->with(compact('category','difficultyLevel', 'courses', 'wishlisted'));
            }
            if( !$category = CourseCategory::where('slug',$slug)->first() ){
                 return View::make('site.error_encountered');
            }
            
            $courses = $category->courses()->with('courseDifficulty')->with('courseCategory')->with('courseSubcategory')->with('previewImage')
                    ->where(function($query){
//                        ->where('featured',0)
                        $query->where('publish_status', 'approved')
                        ->where('privacy_status','public')
                        ->orWhere(function($query2){
                            $query2->where('privacy_status','public')
//                                    ->where('featured',0)
                                    ->where('publish_status', 'pending')
                                    ->where('pre_submit_data', '!=', "");
                        });
                    });


            if (!empty($difficultyLevel)){
                $courses = $courses->where('course_difficulty_id', $difficultyLevel);
            }

            if ($sort == 'date'){
                $courses = $courses->orderBy('created_at','desc');
            }
            else if ($sort == 'date-oldest'){
                $courses = $courses->orderBy('created_at','asc');
            }
            else{
                $courses = $courses->orderBy('id','desc');
            }

            $courses = $courses->paginate(9);

            if( Request::ajax() ) Return View::make('courses.categories.courses')->with(compact('category','courses', 'wishlisted'));
            Return View::make('courses.categories.category')->with(compact('category','difficultyLevel', 'wishlisted', 'courses'));
                            
        }
        
        public function subCategory($slug='', $subcat=''){
            if( !$category = CourseCategory::where('slug',$slug)->first() ){
                 return View::make('site.error_encountered');
            }
            if( !$subcategory = CourseSubcategory::where('slug',$subcat)->first() ){
                 return View::make('site.error_encountered');
            }
            
            $difficultyLevel = Input::get('difficulty') ?: null;
            $sort = null;
            $wishlisted = [];
            if( Auth::check() ){
                $student = Student::find( Auth::user()->id );
                $wishlisted = $student->wishlistItems()->lists( 'course_id' );
            }
            if (Input::has('sort')){
                if ( Input::get('sort') == 'best-at' || Input::get("sort") == 'best-m' || Input::get("sort") == 'best-w' ){
                    
                    switch(Input::get('sort')){
                        case 'best-at': $timeframe = 'AT'; break;
                        case 'best-m': $timeframe = 'LM'; break;
                        case 'best-w': $timeframe = 'LW'; break;
                        default: $timeframe = 'AT';
                    }
                    
                    $courseHelper = new CourseHelper();
                    $category = new stdClass;
                    $category->color_scheme = $category->name = $category->description = $category->id =  '';
                    $order = ( Input::get('sort') == 'best-selling-low' ) ? 'ASC' : 'DESC';
                    $courses = $courseHelper->bestSellers($slug, $timeframe, 9, ['course_difficulty_id' => $difficultyLevel], $order, $subcat);
                    if(Request::ajax() ) Return View::make('courses.categories.courses')->with(compact('category','courses', 'wishlisted' ) );
                    return View::make('courses.categories.category')->with(compact('category','difficultyLevel', 'wishlisted', 'courses') );
                }

                $sort = Input::get('sort');
            }

            
            
            $courses = $subcategory->courses()->with('courseDifficulty')->with('courseCategory')->with('courseSubcategory')->with('previewImage')
                    ->where(function($query){
//                        ->where('featured',0)
                        $query->where('publish_status', 'approved')
                        ->where('privacy_status','public')
                        ->orWhere(function($query2){
                            $query2->where('privacy_status','public')
//                                    ->where('featured',0)
                                    ->where('publish_status', 'pending')
                                    ->where('pre_submit_data', '!=', "");
                        });
                    });


            if (!empty($difficultyLevel) && $difficultyLevel > 0){
                $courses = $courses->where('course_difficulty_id', $difficultyLevel);
            }

            if ($sort == 'date'){
                $courses = $courses->orderBy('created_at','desc');
            }
            else if ($sort == 'date-oldest'){
                $courses = $courses->orderBy('created_at','asc');
            }
            else{
                $courses = $courses->orderBy('id','desc');
            }

            $courses = $courses->paginate(9);

            if( Request::ajax() ) Return View::make('courses.categories.courses')->with(compact('category','courses', 'wishlisted'));
            Return View::make('courses.categories.category')->with(compact('category','difficultyLevel', 'wishlisted') );
                            
        }
        
        public function search(){
            $difficultyLevel = Input::get('difficulty') ?: null;
            $wishlisted = [];
            if( Auth::check() ){
                $student = Student::find( Auth::user()->id );
                $wishlisted = $student->wishlistItems()->lists( 'course_id' );
            }
            $sort = null;
            $category = new stdClass;
            $category->color_scheme = $category->name = $category->description = $category->id =  '';
            $search = trim( Input::get('term') );
            
            if (Input::has('sort')){
                if ( Input::get('sort') == 'best-selling' || Input::get("sort") == 'best-selling-low' ){
                    
                    $courseHelper = new CourseHelper();
                    $order = ( Input::get('sort') == 'best-selling-low' ) ? 'ASC' : 'DESC';
                    $courses = $courseHelper->bestSellers(null,'AT',9,['course_difficulty_id' => $difficultyLevel], $order, null, $search );
                    if(Request::ajax() ) Return View::make('courses.categories.courses')->with(compact('category','courses', 'wishlisted'));
                    return View::make('courses.categories.category')->with(compact('category','difficultyLevel', 'wishlisted', 'courses'));
                }

                $sort = Input::get('sort');
            }

            
            $courses = Course::with('courseDifficulty')->with('courseCategory')->with('courseSubcategory')->with('previewImage')
                    ->where(function($query) use ($search){
                        $query->where( 'name', 'like', "%$search%" )
                        ->orWhere( 'description', 'like', "%$search%" );
                    })
                    ->where(function($query){
                        $query->where('publish_status', 'approved')
                        ->where('privacy_status','public')
                        ->orWhere(function($query2){
                            $query2->where('privacy_status','public')
//                                    ->where('featured',0)
                                    ->where('publish_status', 'pending')
                                    ->where('approved_data', '!=', "");
                        });
                    });


            if ( $difficultyLevel != null ){
                $courses = $courses->where('course_difficulty_id', $difficultyLevel);
            }

            if ($sort == 'date'){
                $courses = $courses->orderBy('created_at','desc');
            }
            else if ($sort == 'date-oldest'){
                $courses = $courses->orderBy('created_at','asc');
            }
            else{
                $courses = $courses->orderBy('id','desc');
            }

            $courses = $courses->paginate(9);

            if( Request::ajax() ) Return View::make('courses.categories.courses')->with( compact('courses', 'category', 'difficultyLevel', 'wishlisted' ) );
            Return View::make('courses.categories.category')->with( compact('difficultyLevel', 'courses','category', 'difficultyLevel', 'wishlisted') );
                            
        }
        
        public function zzsubCategory($slug='', $subcat=''){
            $difficultyLevel = Input::get('difficulty') ?: null;

            $category =  CourseCategory::where('slug',$slug)->first();
            if( !$subcategory = CourseSubcategory::where('slug',$subcat)->first() ){
                 return View::make('site.error_encountered');
            }
            $courses = $subcategory->courses()->with('courseDifficulty')->with('courseCategory')->with('courseSubcategory')->with('previewImage')
                    ->where(function($query){
                        $query->where('featured',0)
                        ->where('publish_status', 'approved')
                        ->where('privacy_status','public')
                        ->orWhere(function($query2){
                            $query2->where('privacy_status','public')
                                    ->where('featured',0)
                                    ->where('publish_status', 'pending')
                                    ->where('pre_submit_data', '!=', "");
                        });
                    })
                    
                    ->orderBy('id','Desc')->paginate(9);
            Return View::make('courses.categories.category')->with(compact('category','difficultyLevel'))->with(compact('courses'))->with(compact('subcategory'));
                    //->where('featured',0)->where('privacy_status','public')
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
            
            $wishlisted = [];
            if( Auth::check() ){
                $student = Student::find( Auth::user()->id );
                $wishlisted = $student->wishlistItems()->lists( 'course_id' );
            }
            
            if( !Input::has('is-preview') ) $course = courseApprovedVersion( $course );
            
            if( $course->publish_status != 'approved' && $course->approved_data == '' ){
                if( Auth::guest() ) return Redirect::action('SiteController@index');
                if( !admin() && $course->instructor_id != Auth::user()->id  && $course->assigned_instructor_id != Auth::user()->id ) return Redirect::action('SiteController@index');
            }
            
//            if(Auth::check() && Auth::user()->hasRole('Admin') && Input::has('view-old-version')){
//                if( $course->pre_submit_data !='' ) {
//                    $old = json_decode( $course->pre_submit_data );
//                    foreach($old as $k => $v) $course->$k = $v;
//                    $course->name = "[OLD VERSION] ".$course->name;
//                }
//            }
            $instructor = $course->instructor;
            if( $course->assigned_instructor_id != null && $course->details_displays == 'assigned_instructor'){
                $instructor = $course->assignedInstructor;
            }
            $student = null;
            if(Auth::check()) $student = Student::find(Auth::user()->id);
            $course->allTestimonials = $course->testimonials()->orderBy('id', 'desc')->limit(2)->get();
            if(Input::has('aid')){
//                Cookie::queue("aid-$course->id", Input::get('aid'), 60*24*30);
                Cookie::queue("aid", Input::get('aid'), 60*24*30);
                // store this in the DB as well, in case the cookies get deleted
                if(Auth::check()) {
                    $student->saveReferral(Input::get('aid'), $course->id);
                }
            }
            
            $video = $course->descriptionVideo;

            if( serveMobile() ) 
                Return View::make('MOBILE_VERSION.courses.show')->with(compact('course', 'student', 'video', 'instructor', 'wishlisted') );
            else    
                Return View::make('courses.show')->with(compact('course', 'student', 'video', 'instructor', 'wishlisted') )->render();
        } 
        
        public function purchase($slug){
            if(Auth::guest()){
                Session::set('url.intended', action('CoursesController@show', $slug));
                return Redirect::to('login')->withError( trans('courses/general.login_to_purchase') );
            }
            
            $course = Course::where('slug', $slug)->first();
            $course = courseApprovedVersion( $course );
            
            $student = Student::current(Auth::user());
            $purchaseData = [];
            // gift
            if(Input::get('gid') !=''){
                $gift = Gift::find( PseudoCrypt::unhash(Input::get('gid')) );
                if($gift && $gift->affiliate_id == Input::get('aid')){
                    $purchaseData['giftID'] = $gift->id;
                }
            }
            $purchaseData['productID'] = $course->id;
            $purchaseData['productType'] = 'Course';
            $purchaseData['originalCost'] = $course->price;
            $purchaseData['discount'] = 0;
            if( $course->isDiscounted() ){
                $purchaseData['discount'] = $course->discount_saved;
            }
            $purchaseData['balanceUsed'] = 0;
            $purchaseData['balanceTransactionID'] = '';
            if( $student->student_balance > 0 ){
                $transaction = $student->balanceDebit( $student->student_balance, $course);
                if ( !$transaction ){
                    return "Balance debit failed";
                }
                $purchaseData['balanceUsed'] = $student->student_balance;
                $purchaseData['balanceTransactionID'] = $transaction;
            }
            $purchaseData['finalCost'] = $course->cost() - $purchaseData['balanceUsed'];
            $purchaseData['paymentType'] = $course->payment_type;
            
            Session::put('data',  json_encode($purchaseData) ) ;
            
            return Redirect::action('PaymentController@index');            
        }
        
        public function purchaseLesson($slug, $lesson){
            if(Auth::guest()){
                Session::set('url.intended', action('CoursesController@show', $slug));
                return Redirect::to('login')->withError( trans('courses/general.login_to_purchase') );
            }
            
            $lesson = Lesson::where('slug', $lesson)->first();
            $student = Student::current(Auth::user());
            $purchaseData = [];
            $purchaseData['productID'] = $lesson->id;
            $purchaseData['productType'] = 'Lesson';
            $purchaseData['originalCost'] = $lesson->price;
            $purchaseData['discount'] = 0;
            $purchaseData['balanceUsed'] = 0;
            $purchaseData['balanceTransactionID'] = '';
            if( $student->student_balance > 0 ){
                $transaction = $student->balanceDebit( $student->student_balance, $lesson);
                if ( !$transaction ){
                    return "Balance debit failed";
                }
                $purchaseData['balanceUsed'] = $student->student_balance;
                $purchaseData['balanceTransactionID'] = $transaction;
            }
            $purchaseData['finalCost'] = $lesson->cost() - $purchaseData['balanceUsed'];
            $purchaseData['paymentType'] = "one_time";
            
            Session::put('data',  json_encode($purchaseData) ) ;
            
            return Redirect::action('PaymentController@index');
            
        }
        
        public function purchased($slug){
            // unset the affiliate cookie
            Cookie::queue("aid", null, -1);
            $course = Course::where('slug', $slug)->first();
            return View::make('courses.purchased')->with( compact('course') );
        }
                
        public function crashLesson($slug, $lesson){
            if(Auth::guest()){
                Session::set('url.intended', action('CoursesController@show', $slug));
                return Redirect::to('login')->withError( trans('courses/general.login_to_purchase') );
            }
            
            $lesson = Lesson::where('slug', $lesson)->first();
            $student = Student::current(Auth::user());
//            $student->crash( $lesson,  Cookie::get( "aid-".$lesson->module->course->id ) );
            $student->crash( $lesson,  Cookie::get( "aid" ) );
            // unset the affiliate cookie
            Cookie::queue("aid", null, -1);
            return Redirect::action( 'ClassroomController@lesson', 
                                                [ 'course' => $lesson->module->course->slug, 'module' => $lesson->module->slug, 
                                                    'lesson' => $lesson->slug ]);
        }
        
        public function crashCourse($slug){
            if(Auth::guest()){
                Session::set('url.intended', action('CoursesController@show', $slug));
                return Redirect::to('login')->withError( trans('courses/general.login_to_purchase') );
            }
            
            $course = Course::where('slug', $slug)->first();
            $student = Student::current(Auth::user());
//            $student->crash( $course,  Cookie::get( "aid-".$course->id ) );
            $student->crash( $course,  Cookie::get( "aid" ) );
            // unset the affiliate cookie
            Cookie::queue("aid", null, -1);
            
            return Redirect::action( 'ClassroomController@dashboard', [ 'course' => $course->slug ]);
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
            
            if( Input::get('paginate')=='announcements' ) Paginator::setCurrentPage( Input::get('page') );
            else Paginator::setCurrentPage(1);
            $announcements = $instructor->sentMessages()->where('course_id', $course->id)
                    ->where("type",'mass_message')->orderBy('id','desc')->paginate( 2 );
            if( Input::get('paginate')=='discussions' ) Paginator::setCurrentPage( Input::get('page') );
            else Paginator::setCurrentPage(1);
            $course->comments = $course->dashboardComments()->where( 'instructor_read', 'no' )->orderBy( 'id','desc' )->paginate(2);
            
            if( Input::get('paginate')=='questions' ) Paginator::setCurrentPage( Input::get('page') );
            else Paginator::setCurrentPage(1);
            $course->questions = $course->questions()->paginate(2);
            
            if(Request::ajax()){
                if(Input::get('paginate') == 'announcements'){
                    return View::make('courses/instructor/dashboard/announcements')->with(compact('course'))->with( compact('announcements') );
                }
                if(Input::get('paginate') == 'discussions'){
                    return View::make('courses/instructor/dashboard/discussions')->with(compact('course'));
                }
                if(Input::get('paginate') == 'questions'){
                    return View::make('courses/instructor/dashboard/questions')->with(compact('course'));
                }
            }
            return View::make('courses/instructor/dashboard')->with(compact('course'))->with( compact('announcements') );
        }
        
        public function viewDiscussion($id){
            $comment = Conversation::find($id);
            $course = $comment->course;
            if( $course==null || $course->instructor->id != Auth::user()->id && $course->assigned_instructor_id != Auth::user()->id ){
                return Redirect::to('/');
            }
            $page = $comment->page();
            
            $comment->markRead();
            return Redirect::to( action('ClassroomController@dashboard', $course->slug)."?page=$page#conversations" );
        }
        
        public function markResolved(){
            if(Input::get('type')=='question'){
                $object = PrivateMessage::find(Input::get('id'));                
                if( $object->course->instructor_id != Auth::user()->id && $object->course->assigned_instructor_id != Auth::user()->id ){
                    return json_encode( [ 'status' => 'error' ] );
                }
                if( $object->recipient_id != $object->course->instructor_id && $object->recipient_id != $object->course->assigned_instructor_id ){
                    return json_encode( [ 'status' => 'error' ] );
                }
                $object->status = 'read';
            }
            else{
                $object = Conversation::find(Input::get('id'));
                if( $object->course->instructor_id != Auth::user()->id && $object->course->assigned_instructor_id != Auth::user()->id ){
                    return json_encode( [ 'status' => 'error' ] );
                }
                $object->instructor_read = 'yes';
            }
                 
            if($object->updateUniques())            return json_encode( [ 'status' => 'success' ] );
            else return json_encode( [ 'status' => 'error' ] );
        }
        
        public function reply(){
            if(Input::get('type')=='question'){
                $object = PrivateMessage::find(Input::get('id'));                
                if( $object->course->instructor_id != Auth::user()->id && $object->course->assigned_instructor_id != Auth::user()->id ){
                    return json_encode( [ 'status' => 'error' ] );
                }
                if( $object->recipient_id != $object->course->instructor_id && $object->recipient_id != $object->course->assigned_instructor_id ){
                    return json_encode( [ 'status' => 'error' ] );
                }
                $object->status = 'read';
                if( !$object->updateUniques() ){
                    return json_encode( [ 'status' => 'error' ] );
                }
                $reply = new PrivateMessage([ 'sender_id' => Auth::user()->id, 'type' => 'ask_teacher' ]);
                $reply->content = Input::get('reply');
                $reply->recipient_id = $object->sender_id;  
                $reply->course_id = $object->course_id;  
                $reply->lesson_id = $object->lesson_id;  
                $reply->thread_id = ($object->thread_id > 0) ? $object->thread_id : $object->id;  
            }
            else{
                $object = Conversation::find(Input::get('id'));
                if( $object->course->instructor_id != Auth::user()->id && $object->course->assigned_instructor_id != Auth::user()->id ){
                    return json_encode( [ 'status' => 'error' ] );
                }
                $object->instructor_read = 'yes';
                if( !$object->updateUniques() ){
                    return json_encode( [ 'status' => 'error' ] );
                }
                
                $reply = new Conversation(['poster_id' => Auth::user()->id, 'course_id' => $object->course_id ]);
                $reply->content = Input::get('reply');
                $reply->instructor_read = 'yes';
                if($object->reply_to > 0){
                    $reply->reply_to = $object->reply_to;
                    $reply->original_reply_to = $object->id;
                }
                else{
                    $reply->reply_to = $object->id;
                }
            }
            
            if($reply->save())            return json_encode( [ 'status' => 'success' ] );
            else return json_encode( [ 'status' => 'error', 'errors' => format_errors( $reply->errors()->all() ) ] );
        }


        public function setVideoDescription($courseId = 0)
        {
            if (Input::has('videoId')){
                $course = Course::find($courseId);

                if ($course){
                    $course->description_video_id = Input::get('videoId');
                    $course->updateUniques();
                    return Response::json($course->toArray());
                }
            }

            return Response::json(['error' => 'Insufficient Parameters']);
        }

        public function minutes($courseId = 0){
            $course = Course::find( $courseId );
            return $course->videoHours('i');
        }

        public function reorder($id){
            $course = Course::find($id);
            if($course->instructor->id != Auth::user()->id && $course->assigned_instructor_id != Auth::user()->id ){
                return Redirect::action('CoursesController@index');
            }
            if( Input::has('modules') ){
                $i = 1;
                foreach( Input::get('modules') as $module){
                    $module = Module::where('course_id', $course->id)->where('id', $module)->update( ['order' => $i] );
                    ++$i;
                }

            }
            if( Input::has('lessons') ){
                foreach( Input::get('lessons') as $data ){
                    $module = $data['module'];
                    $lessons = isset( $data['lessons'] ) ? $data['lessons'] : [];
                    $i = 1;
                    $module = Module::find($module);
                    foreach($lessons as $lesson){       
                        $lesson = Lesson::where('id', $lesson)->first();
                        if( $module==null || $module->course_id != $course->id ) continue;
                        if( $lesson->module->course_id != $course->id ) continue;
                        $lesson->order = $i;
                        $lesson->module_id = $module->id;
                        $lesson->updateUniques();
                        ++$i;
                    }
                }
            }
            return Response::json(['status' => 'success']);

        }
        
        public function updateExternalVideo($id){
            $course = Course::find($id);
            
            if(!admin() && $course->instructor->id != Auth::user()->id && $course->assigned_instructor_id != Auth::user()->id ){
                return Redirect::action('CoursesController@index');
            }
            
            $course->external_video_url = Input::get('value');
            if( $course->updateUniques() ){
                $response = ['status' => 'success'];
                $response['embed_code'] = externalVideoPreview( Input::get('value') );
            }
            else{
                $response = ['status' => 'error', 'errors' => format_errors( $course->errors()->all() ) ];
            }
            return json_encode($response);
        }
        
        public function removePromo($id){
            $course = Course::find($id);
            
            if(!admin() && $course->instructor->id != Auth::user()->id && $course->assigned_instructor_id != Auth::user()->id ){
                return Redirect::action('CoursesController@index');
            }
            
            $course->description_video_id = null;
            if( $course->updateUniques() ){
                $response = ['status' => 'success'];
            }
            else{
                $response = ['status' => 'error', 'errors' => format_errors( $course->errors()->all() ) ];
            }
            return json_encode($response);
        }
}
