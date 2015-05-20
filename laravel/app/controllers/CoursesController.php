<?php

class CoursesController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'instructor', [ 'only' => ['create', 'store', 'myCourses', 'destroy', 'edit', 'update', 'curriculum', 'dashboard'] ] );
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
            $categories = ['' => trans('general.select')] + CourseCategory::lists('name', 'id');
            $subcategories = CourseSubcategory::arrayWithParent();
            $instructor = Instructor::find(Auth::user()->id);
            $images = $instructor->coursePreviewImages;
            $bannerImages = $instructor->courseBannerImages;
         
            return View::make('courses.create')->with(compact('difficulties'))->with(compact('categories'));
        }
        
        public function store(){
            
            $data = input_except(['_method', '_token']);
            $course = new Course();
            $course->instructor_id = Auth::user()->id;
            $course->name = Input::get('name');
            $course->slug = Str::slug(Input::get('name'));
            if($course->save()){
                // notify followers
//                Instructor::find( Auth::user()->id )->notifyFollowers( $course );
                
                if(Request::ajax()){
//                    dd($course);
                    return $this->update( $course->slug );
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

             $awsPolicySig = UploadHelper::AWSPolicyAndSignature();
            return View::make('courses.form',compact('awsPolicySig'))->with(compact('course'))->with(compact('images'))->with(compact('bannerImages'))->with(compact('assignedInstructor'))
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
            $course->who_is_this_for = json_encode(array_filter(Input::get('who_is_this_for')));
            $course->what_will_you_achieve = json_encode(array_filter(Input::get('what_will_you_achieve')));
            $course->requirements = json_encode(array_filter(Input::get('requirements')));
            $course->sale = Input::get('sale');
            $course->sale_kind = Input::get('sale_kind');
            $course->sale_ends_on = (Input::get('sale_ends_on')) ?  Input::get('sale_ends_on') : null;
            $course->ask_teacher = Input::get('ask_teacher');
            $course->details_displays = Input::get('details_displays');
            $course->assigned_instructor_id = Input::get('assigned_instructor_id') == 0 ? null : Input::get('assigned_instructor_id');
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
        
        public function searchInstructor($email){
            $instructor = Instructor::where('email', $email)->first();
            if( $instructor==null ) return 0;
            if( !$instructor->hasRole('Instructor') ) return 0;
            return $instructor->id;
        }
        
        public function myCourses(){
            $instructor = Instructor::find(Auth::user()->id);
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
            // temporary video TODO: remove this
            Course::whereNull('description_video_id')->update(['description_video_id' => 1]);
            $video = $course->descriptionVideo;

            if( serveMobile() ) 
                Return View::make('MOBILE_VERSION.courses.show')->with(compact('course'))->with(compact('student'))->with( compact('video') )->with( compact('instructor') );
            else    
                Return View::make('courses.show')->with(compact('course'))->with(compact('student'))->with( compact('video') )->with( compact('instructor') );
        } 
        
        public function purchase($slug){
            if(Auth::guest()){
                Session::set('url.intended', action('CoursesController@show', $slug));
                return Redirect::to('login')->withError( trans('courses/general.login_to_purchase') );
            }
            
            $course = Course::where('slug', $slug)->first();
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
            $student->crash( $lesson,  Cookie::get( "aid-".$lesson->module->course->id ) );
            
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
            $student->crash( $course,  Cookie::get( "aid-".$course->id ) );
            
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
}
