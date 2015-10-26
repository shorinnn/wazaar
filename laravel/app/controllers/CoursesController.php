<?php
use Jenssegers\Agent\Agent;
class CoursesController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'instructor', [ 'only' => ['create', 'store', 'myCourses', 'destroy', 'edit', 'update', 'curriculum', 'viewDiscussions',
                'customPercentage', 'updateExternalVideo', 'removePromo', 'setField'] ] );
            $this->beforeFilter( 'admin', ['only' => 'disapprove' ] );
            $this->beforeFilter( 'csrf', ['only' => [ 'store', 'update', 'destroyxxx', 'purchase', 'purchaseLesson', 'submitForApproval' ] ] );
            $this->beforeFilter( 'logCourseView', [ 'only' => ['show'] ] );
            
            $this->beforeFilter('restrictBrowsing');
            
            $this->analyticsHelper = new AnalyticsHelper(false, Auth::id(), 'instructor');
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
        
         public function setField($id){
            $course = Course::find($id);
            if(!admin() && $course->instructor->id != Auth::user()->id && $course->assigned_instructor_id != Auth::user()->id ){
                return Redirect::action('CoursesController@index');
            }
            DB::table('courses')->where('id', $id)->update( [ Input::get('name') => Input::get('val') ] );
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
            $lastVisit = Auth::user()->getCustom('last-instructor-dash-visit');
            
            if( time() - $lastVisit > 60*60*24){
                Auth::user()->setCustom( 'last-instructor-dash-visit', time() );
                Auth::user()->save();
            }
            if( $instructor->accepted_instructor_terms!='yes' ){
                return Redirect::action('InstructorsController@acceptTerms');
            }
            
            switch( Input::get('sort')){
               case 'date-old': $sortField = 'created_at'; $sortDir = 'ASC'; break;
               case 'public': $sortField = 'privacy_status'; $sortDir = 'DESC'; break;
               case 'private': $sortField = 'privacy_status'; $sortDir = 'ASC'; break;
               case 'unlisted': $sortField = 'publish_status'; $sortDir = 'DESC'; break;
               default: $sortField = 'created_at'; $sortDir = 'DESC'; break;
            }
            
            if( $sortField == 'publish_status' ){
                $courses = $instructor->courses()->orderBy( DB::raw( 'CAST( publish_status AS CHAR )' ), $sortDir )
                        ->with( [ 'dashboardComments' => function($query){
                            $query->where('instructor_read', 'no');
                        } ] )
                        ->paginate(10);
            }
            else{
                $courses = $instructor->courses()->orderBy( $sortField, $sortDir )
                        ->with( [ 'dashboardComments' => function($query){
                            $query->where('instructor_read', 'no');
                        } ] )
                        ->paginate(10);
            }
            
            $profile = $instructor->profile;
            
            $student = Student::find( Auth::user()->id );
            $purchasedCourses = $student->purchases()->where('product_type','Course')->get();
            $wishlist = $student->wishlistItems;
            if($wishlist !=null )$wishlist->load('course');
            
            return View::make('instructors.dashboard.v2.index')->with(compact('courses', 'instructor', 'profile', 'lastVisit', 
                    'student', 'purchasedCourses', 'wishlist'));
            Return View::make('courses.myCourses')->with(compact('courses'));
        }
        
        public function categories(){
            $categories = CourseCategory::paginate(3);
            Return View::make('courses.categories')->with(compact('categories'));
        }
        
        public function category($slug=''){
            $difficultyLevel = Input::get('difficulty') ?: null;
            $filter = Input::get('filter') ?: null;
            $subcategory = null;
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
                    $courses = $courseHelper->bestSellers($slug, $timeframe, 9, ['course_difficulty_id' => $difficultyLevel], $order, '', '', $filter);
                    $categories = CourseCategory::has('allCourses')->get();
                    $categories->load( 'courseSubcategories' );

                    if(Request::ajax() ) Return View::make('courses.categories.courses')->with( compact( 'category', 'courses', 'wishlisted', 'categories', 'subcategory' ) );
                    return View::make('courses.categories.category')->with( compact( 'category', 'difficultyLevel', 'courses', 'wishlisted', 'categories', 'subcategory') );
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

                if (!empty($filter)){
                    if($filter == 'free'){
                        $courses = $courses->where('free', 'yes');
                    } else if($filter == 'paid') {
                        $courses = $courses->where('free', 'no');
                    }
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
                $categories = CourseCategory::has('allCourses')->get();
                $categories->load( 'courseSubcategories' );

                if( Request::ajax() ) Return View::make('courses.categories.courses')->with(compact('category','courses', 'wishlisted', 'categories', 'subcategory'));                
                Return View::make('courses.categories.category')->with(compact('category','difficultyLevel', 'courses', 'wishlisted', 'categories', 'subcategory'));
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

            if (!empty($filter)){
                if($filter == 'free'){
                    $courses = $courses->where('free', 'yes');
                } else if($filter == 'paid') {
                    $courses = $courses->where('free', 'no');
                }
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
            $categories = CourseCategory::has('allCourses')->get();
            $categories->load( 'courseSubcategories' );
            
            if( Request::ajax() ) Return View::make('courses.categories.courses')->with(compact('category','courses', 'wishlisted', 'categories', 'subcategory'));
            Return View::make('courses.categories.category')->with(compact('category','difficultyLevel', 'wishlisted', 'courses', 'categories', 'subcategory'));
                            
        }
        
        public function subCategory($slug='', $subcat=''){
            $filter = Input::get('filter') ?: null;
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
                    $courses = $courseHelper->bestSellers($slug, $timeframe, 9, ['course_difficulty_id' => $difficultyLevel], $order, $subcat, '', $filter);
                    if(Request::ajax() ) Return View::make('courses.categories.courses')->with(compact('category','courses', 'wishlisted', 'categories', 'subcategory'  ) );
                    return View::make('courses.categories.category')->with(compact('category','difficultyLevel', 'wishlisted', 'courses', 'categories', 'subcategory') );
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

            if (!empty($filter)){
                if($filter == 'free'){
                    $courses = $courses->where('free', 'yes');
                } else if($filter == 'paid') {
                    $courses = $courses->where('free', 'no');
                }
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
            $category = $subcategory->courseCategory;
            $categories = CourseCategory::has('allCourses')->get();
            $categories->load( 'courseSubcategories' );
            if( Request::ajax() ) Return View::make('courses.categories.courses')->with(compact('category','courses', 'subcategory', 'wishlisted', 'categories'));
            Return View::make('courses.categories.category')->with(compact('category', 'subcategory', 'difficultyLevel', 'wishlisted', 'courses', 'categories') );
                            
        }
        
        public function oldSearch(){
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

            
            $categories = CourseCategory::has('allCourses')->get();
            $categories->load( 'courseSubcategories' );
            
            if( Request::ajax() ) Return View::make('courses.categories.courses')->with( compact('courses', 'category', 'difficultyLevel', 'wishlisted', 'categories' ) );
            Return View::make('courses.categories.category')->with( compact('difficultyLevel', 'courses','category', 'difficultyLevel', 'wishlisted', 'categories') );
                            
        }
        
        public function search(){
            $search = trim( Input::get('term') );
            
            $cloudSearch  = AWS::get('cloudsearchdomain', [ 'endpoint' => Config::get('custom.cloudsearch-search-endpoint') ] );
            $res = $cloudSearch->search( [ 'query' => $search ] );
            $ids = $res['hits']['hit'];
            $ids = array_column( $ids , 'id' );
            
            $difficultyLevel = Input::get('difficulty') ?: null;
            $wishlisted = [];
            if( Auth::check() ){
                $student = Student::find( Auth::user()->id );
                $wishlisted = $student->wishlistItems()->lists( 'course_id' );
            }
            $sort = null;
            $category = new stdClass;
            $category->color_scheme = $category->name = $category->description = $category->id =  '';
            
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
                    ->whereIn('id', $ids)
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

            
            $categories = CourseCategory::has('allCourses')->get();
            $categories->load( 'courseSubcategories' );
            $subcategory = '';
            if( Request::ajax() ) Return View::make('courses.categories.courses')->with( compact('courses', 'category', 'subcategory', 'search', 'difficultyLevel', 'wishlisted', 'categories' ) );
            Return View::make('courses.categories.category')->with( compact('difficultyLevel', 'courses','category', 'subcategory', 'search', 'difficultyLevel', 'wishlisted', 'categories') );
                            
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
                return View::make( 'site.error' );
                return View::make('site.error_encountered');
            }
            $course = courseApprovedVersion($course);
            if($course->publish_status != 'approved' && ($course->publish_status!='pending') && trim($course->approved_data)!=''){
               
                if( Auth::guest() || ( !admin() && $course->instructor_id != Auth::user()->id ) ){
                    return View::make('site.error_encountered');
                }
            }
            // store gift cookie if  any
            if( Input::has('gid') ){
                Cookie::queue('gid-'.$course->id, Input::get('gid'), 60*24*30);
            }
            
            $wishlisted = [];
            if( Auth::check() ){
                $student = Student::find( Auth::user()->id );
                $wishlisted = $student->wishlistItems()->lists( 'course_id' );
            }
            
            if( !Input::has('preview') ) $course = courseApprovedVersion( $course );
            
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
            $course->allTestimonials = $course->testimonials()->where('content','!=',"")->orderBy('id', 'desc')->limit(3)->get();
            if(Input::has('aid')){
//                Cookie::queue("aid-$course->id", Input::get('aid'), 60*24*30);
                Cookie::queue("aid", Input::get('aid'), 60*24*30);
                // store this in the DB as well, in case the cookies get deleted
                if(Auth::check()) {
                    $student->saveReferral(Input::get('aid'), $course->id);
                }

                //Store affiliate hit
                $agent = new Agent();
                AffiliateHit::create([
                    'affiliate_id' => Input::get('aid'),
                    'session_id' => Session::getId(),
                    'course_id' => $course->id,
                    'user_id' => Auth::id(),
                    'referrer' => Request::server('HTTP_REFERER'),
                    'ip_address' => Request::getClientIp(),
                    'user_agent' => Request::header('User-Agent'),
                    'device' => $agent->device(),
                    'operating_system' => $agent->platform(),
                    'browser' => $agent->browser(),
                    'created_at' => Carbon\Carbon::now()
                ]);
            }
            
            $video = $course->descriptionVideo;
            if( Input::has('gid') ) $gid = Input::get('gid');
            else $gid = Cookie::get('gid-'.$course->id);
            $gift = Gift::find( PseudoCrypt::unhash( $gid ) );



            if( serveMobile() ) 
                Return View::make('MOBILE_VERSION.courses.show')->with(compact('course', 'student', 'video', 'instructor', 'wishlisted', 'gid', 'gift' ) );
            else    
                Return View::make('courses.show')->with(compact('course', 'student', 'video', 'instructor', 'wishlisted', 'gid', 'gift' ) )->render();
        } 
        
        public function loginToPurchase($slug){
            if(Auth::guest()){
                Session::set('url.intended', action('CoursesController@show', $slug));
                return Redirect::to('register')->withError( trans('courses/general.login_to_purchase') );
            }
        }
        
        public function confirmToPurchase($slug){
            Session::set('url.intended', action('CoursesController@show', $slug));
            return Redirect::action( 'UsersController@confirmPassword' );
        }
        
        public function purchase($slug){
            if(Auth::guest()){
                Session::set('url.intended', action('CoursesController@show', $slug));
                return Redirect::to('register')->withError( trans('courses/general.login_to_purchase') );
            }
            
            $course = Course::where('slug', $slug)->first();
            $course = courseApprovedVersion( $course );
            
            $student = Student::current(Auth::user());
            $purchaseData = [];
            // gift
            if(Input::get('gid') !=''){
                $gift = Gift::find( PseudoCrypt::unhash(Input::get('gid')) );
                if($gift && $gift->affiliate_id == Cookie::get('aid')){
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
            $course = Course::where('slug', $slug)->first();
            Cookie::queue("aid", null, -1);
            Cookie::queue("gid-".$course->id, null, -1);
            
            Session::flash( 'message', trans('courses/general.enroll-success-message-paid') );
            return Redirect::action('ClassroomController@dashboard', $slug);
                
            return View::make('courses.purchased')->with( compact('course') );
        }
                
        public function crashLesson($slug, $lesson){
            if(Auth::guest()){
                Session::set('url.intended', action('CoursesController@show', $slug));
                return Redirect::to('register')->withError( trans('courses/general.login_to_purchase') );
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
                return Redirect::to('register')->withError( trans('courses/general.login_to_purchase') );
            }
            
            $course = Course::where('slug', $slug)->first();
            $student = Student::current(Auth::user());
//            $student->crash( $course,  Cookie::get( "aid-".$course->id ) );
            $g = null;
            if(Input::get('gid') !=''){
                $gift = Gift::find( PseudoCrypt::unhash(Input::get('gid')) );
                if($gift && $gift->affiliate_id == Cookie::get('aid')){
                    $g = $gift->id;
                }
            }
            $student->crash( $course,  Cookie::get( "aid" ), $g );
            // unset the affiliate cookie
            Cookie::queue("aid", null, -1);
            Cookie::queue("gid", null, -1);
            Cookie::queue("gid-".$course->id, null, -1);
            Session::flash( 'message', trans('courses/general.enroll-success-message-free') );
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
        
        public function viewDiscussions($slug){
            $course = Course::where('slug',$slug)->first();
            if( $course==null || $course->instructor->id != Auth::user()->id && $course->assigned_instructor_id != Auth::user()->id ){
                return Redirect::to('/');
            }
            $instructor = Instructor::find( Auth::user()->id );
            
//            if( Input::get('paginate')=='announcements' ) Paginator::setCurrentPage( Input::get('page') );
//            else Paginator::setCurrentPage(1);
//            $announcements = $instructor->sentMessages()->where('course_id', $course->id)
//                    ->where("type",'mass_message')->orderBy('id','desc')->paginate( 2 );
//            if( Input::get('paginate')=='discussions' ) Paginator::setCurrentPage( Input::get('page') );
//            else Paginator::setCurrentPage(1);
//            $course->comments = $course->dashboardComments()->where( 'instructor_read', 'no' )->orderBy( 'id','desc' )->paginate(2);
//            
//            if( Input::get('paginate')=='questions' ) Paginator::setCurrentPage( Input::get('page') );
//            else Paginator::setCurrentPage(1);
//            $course->questions = $course->questions()->paginate(2);
            
            $discussions = $course->discussions(20);
            
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
            return View::make('courses/instructor/dashboard')->with(compact('course', 'discussions') );
        }
        
        public function storeDiscussionReply(){
            $discussion = LessonDiscussion::find( Input::get('lesson_discussion_id') );
            $course = $discussion->lesson->module->course;
            if( $course==null || $course->instructor->id != Auth::user()->id && $course->assigned_instructor_id != Auth::user()->id ){
                return Redirect::to('/');
            }
            
           
            $lesson = Lesson::find( $discussion->lesson_id );          
            $reply = new LessonDiscussionReply( Input::all() );
            $reply->student_id = Auth::user()->id;
            if( $reply->save() ){
                // email the original poster
                $user = $discussion->student;
                Mail::send(
                        'emails.discussion-reply-from-instructor',
                        compact('user' ),
                        function ($message) use ($user) {
                            $message->getHeaders()->addTextHeader('X-MC-Important', 'True');
                            $message
                                ->to($user->email, $user->fullName())
                                ->subject( 'Reply from instructor' );
                        }
                    );
                
                
                  if( Request::ajax() ){
                    $response['status'] = 'success';
                    $timeDif = new stdClass();
                    $timeDif->timeDif = time();
                    $noTimeLine = true;
                    $response['html'] =  View::make('courses.instructor.dashboard.reply')
                            ->with( compact( 'course', 'discussion', 'timeDif', 'reply', 'noTimeLine' ) )->render();
                    return json_encode($response);
                }
		return Redirect::back();
            }
            else{
                return Redirect::back()->withErrors( format_errors( $reply->errors()->all() ) );
            }
        }
        
        public function viewDiscussion($id){
//            $comment = Conversation::find($id);
            $discussion = LessonDiscussion::find($id);
            $course = $discussion->lesson->module->course;
            if( $course==null || $course->instructor->id != Auth::user()->id && $course->assigned_instructor_id != Auth::user()->id ){
                return Redirect::to('/');
            }
            return View::make('courses/instructor/dashboard/discussion')->withDiscussion($discussion)->withCourse($course);
//            $page = $comment->page();
//            
//            $comment->markRead();
//            return Redirect::to( action('ClassroomController@dashboard', $course->slug)."?page=$page#conversations" );
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
        
        public function disapprove($id){
            $course = Course::find($id);
            $course->publish_status = 'unsubmitted';
            if( $course->updateUniques() )
                return Redirect::back()->withSuccess( 'Course Disapproved' );
            else
                return Redirect::back()->withError( 'Could not disapprove Course ' );
        }

    public function oldAdminIndex()
    {

        $courses = Course::oldGetAdminList();
        return View::make('administration.courses.oldindex', compact('courses'));
    }

    public function adminIndex()
    {

        $data = Request::all();

        $course_categories = [''=>trans('administration.courses.label.select_category') ];
        $course_categories_lists = CourseCategory::lists('name', 'id');
        foreach($course_categories_lists as $key => $val){
            $course_categories = array_add($course_categories, $key, $val);
        }
        $course_category = (isset($data['course_category']))?$data['course_category']:'';

        $course_sub_categories = [''=>trans('administration.courses.label.select_sub_category')];

        if(!empty($course_category)){
            $course_sub_categories_lists = CourseSubcategory::where('course_category_id', $course_category)->orderBy('name', 'asc')->lists('name', 'id');
            foreach($course_sub_categories_lists as $key => $val){
                $course_sub_categories = array_add($course_sub_categories, $key, $val);
            }    
        }


        $course_sub_category = (isset($data['course_sub_category']))?$data['course_sub_category']:'';
        
        $sale_amount_low = (isset($data['sale_amount_low']))?$data['sale_amount_low']:'';
        $sale_amount_high = (isset($data['sale_amount_high']))?$data['sale_amount_high']:'';

        $sort_data = (isset($data['sort_data']))?$data['sort_data']:'courses.created_at,desc';

        $page = (isset($data['page']))?$data['page']:'1';
        $search = (isset($data['search']))?$data['search']:'';

        $courses = Course::getAdminList($data);

        $totals = array();
        $totals['approved'] = Course::where('publish_status', '=', 'approved')->count();
        $totals['pending'] = Course::where('publish_status', '=', 'pending')->count();
        $totals['rejected'] = Course::where('publish_status', '=', 'rejected')->count();

        $sort_list = [
            // 'courses.name,asc' => 'Name (a-z)',
            // 'courses.name,desc' => 'Name (z-a)',
            'total_revenue,asc' => trans('administration.courses.label.revenue_low_high'),
            'total_revenue,desc' => trans('administration.courses.label.revenue_high_low'),
            'courses.created_at,asc' => trans('administration.courses.label.submitted_latest'),
            'courses.created_at,desc' => trans('administration.courses.label.submitted_oldest'),
            'courses.student_count,asc' => trans('administration.courses.label.student_count_low_high'),
            'courses.student_count,desc' => trans('administration.courses.label.student_count_high_low'),
        ];

        $total = (isset($data['total']))?$data['total']:'';

        if(Request::ajax()){
            if($total){
                return $courses.' '.trans('administration.courses.label.courses' );
            }
            return View::make('administration.courses.listing', compact('courses', 'page'));
        }

        return View::make('administration.courses.index', compact('course_categories', 'course_category', 'course_sub_categories', 'course_sub_category', 'sale_amount_low', 'sale_amount_high', 'totals', 'sort_list', 'sort_data', 'search', 'page'));
    }

    public function getSubcats()
    {
        $data = Request::all();

        $course_sub_categories = [''=>trans('administration.courses.label.select_sub_category')];

        $cat_id = (isset($data['cat_id']))?$data['cat_id']:'';

        if(!empty($cat_id)){
            $course_sub_categories_lists = CourseSubcategory::where('course_category_id', $cat_id)->orderBy('name', 'asc')->lists('name', 'id');
            foreach($course_sub_categories_lists as $key => $val){
                $course_sub_categories = array_add($course_sub_categories, $key, $val);
            }    
        }
        

        return Form::select('course_sub_category', $course_sub_categories, null, ['id'=>'course_sub_category', 'class'=>'form-control']);

    }

    public function adminShowCourse($slug)
    {
        $course = Course::where('slug', $slug)->first();

        // $course = Course::where('instructor_id', Auth::id())->where('slug', $courseSlug)->first();

        return View::make('administration.courses.show', compact('course'));
    }

    public function salesView($frequency = '', $courseId = '', $trackingCode = '')
    {
        $sales = null;
        switch ($frequency) {
            case 'alltime' :
                $sales = $this->analyticsHelper->salesLastFewYears(5, $courseId, $trackingCode);
                break;
            case 'week' :
                $sales = $this->analyticsHelper->salesLastFewWeeks(7, $courseId, $trackingCode);
                break;
            case 'month' :
                $sales = $this->analyticsHelper->salesLastFewMonths(7, $courseId, $trackingCode);
                break;
            default:
                $sales = $this->analyticsHelper->salesLastFewDays(7, $courseId, $trackingCode);
                break;
        }


        if (is_array($sales)) {
            $urlIdentifier = 'sales';
            $group = 'instructor';
            if ($frequency == 'week') {
                return View::make('analytics.partials.salesWeekly', compact('sales', 'frequency','group','urlIdentifier'))->render();
            } elseif ($frequency == 'month') {
                return View::make('analytics.partials.salesMonthly', compact('sales', 'frequency','group','urlIdentifier'))->render();
            } elseif ($frequency == 'alltime') {
                return View::make('analytics.partials.salesYearly', compact('sales', 'frequency','group','urlIdentifier'))->render();
            } else {
                $frequency = 'daily';
                return View::make('analytics.partials.sales', compact('sales', 'frequency','group','urlIdentifier'))->render();
            }
        }
    }

    public function salesCountView($frequency = '', $courseId = '', $trackingCode = '')
    {
        $frequencyOverride = $frequency;
        $sales = null;
        switch ($frequency) {
            case 'alltime' :
                $frequencyOverride = 'year';
                $sales             = $this->analyticsHelper->salesLastFewYears(7, $courseId);
                break;
            case 'week' :
                $sales = $this->analyticsHelper->salesLastFewWeeks(7, $courseId);
                break;
            case 'month' :
                $sales = $this->analyticsHelper->salesLastFewMonths(7, $courseId);
                break;
            default:
                $frequencyOverride = 'day';
                $sales             = $this->analyticsHelper->salesLastFewDays(7, $courseId);
                break;
        }

        return View::make('administration.dashboard.partials.sales.count',
            compact('frequencyOverride', 'sales'))->render();


    }

    public function courseStatsTableView($courseId, $startDate, $endDate)
    {
        $stats = $this->analyticsHelper->getCourseStats($courseId,$startDate,$endDate);

        return View::make('instructors.analytics.tableCourseStats',compact('stats'))->render();
    }

    public function topAffiliatesTableView($courseId, $startDate, $endDate)
    {
        $page = 1;
        if (Input::has('page')){
            $page = Input::get('page');
        }
        $addThisToRank = ($page - 1) * Config::get('wazaar.PAGINATION');
        $affiliates = $this->analyticsHelper->getTopAffiliatesByCourse($courseId, $startDate, $endDate);

        return View::make('instructors.analytics.tableTopAffiliates',compact('affiliates','addThisToRank'))->render();
    }

    public function getDisapproveForm()
    {
        if(Request::has('course_id')){
            $data = Request::all();
            $course_id = $data['course_id'];
            return View::make('administration.courses.partials.disapproveForm',compact('course_id'));
        }
    }
}