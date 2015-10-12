<?php

class SiteController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'auth', [ 'only' => ['dashboard'] ] );
//            View::share( 'headerShowTopLinks', 1 );
        }

	public function index()
	{
        $data = Request::all();

        $filter = (isset($data['filter']) && $data['filter'] != '')? $data['filter']: '';

        $wishlisted = [];
        if( Auth::check() ){
            $student = Student::find( Auth::user()->id );
            $wishlisted = $student->wishlistItems()->lists( 'course_id' );
        }
        // TEMPORARILY DISABLE THESE VARS BECAUSE THEY'RE NOT USED IN THE VIEW
        $categories = $groups = $topCourses = null;
    //                $categories = CourseCategory::limit(12);
    //                $groups = CategoryGroup::orderBy('order','asc')->get();
    //                
    //                if ( !Cache::has('topCourses') ){
    //                    $top = HomepageHelper::generateVariations(8);
    //                    Cache::add('topCourses', $top, 30);
    //                }
    //                
    //                $topCourses = Cache::get('topCourses');
    ////                $topCourses = $topCourses[ rand(0, count($topCourses)-1 ) ];
    //                $topCourses = $topCourses[ 0 ];
            
        // $discoverCourses = Course::where('publish_status','approved')->orderBy( DB::raw('RAND()') )->limit(6)->get();
        $paginate = 12;

        switch($filter){
            case 'free':
                $discoverCourses = Course::where(function($query){
                                                $query->where('publish_status', 'approved')
                                                        ->orWhere(function($query2){
                                                            $query2->where('privacy_status','public')
                                                                    ->where('publish_status', 'pending')
                                                                    ->where('approved_data', '!=', "");
                                                                });
                                                })
                                            ->orderBy('free','desc')
                                            ->orderBy('student_count','desc')
                                            ->where('free', 'yes')
                                            ->paginate($paginate);
            break;

            case 'paid':
                $discoverCourses = Course::where(function($query){
                                                $query->where('publish_status', 'approved')
                                                        ->orWhere(function($query2){
                                                            $query2->where('privacy_status','public')
                                                                    ->where('publish_status', 'pending')
                                                                    ->where('approved_data', '!=', "");
                                                                });
                                                })
                                            ->orderBy('free','desc')
                                            ->orderBy('student_count','desc')
                                            ->where('free', 'no')
                                            ->paginate($paginate);
            break;

            default:
                $discoverCourses = Course::where(function($query){
                                                $query->where('publish_status', 'approved')
                                                        ->orWhere(function($query2){
                                                            $query2->where('privacy_status','public')
                                                                    ->where('publish_status', 'pending')
                                                                    ->where('approved_data', '!=', "");
                                                                });
                                                })
                                            ->orderBy('free','desc')
                                            ->orderBy('student_count','desc')
                                            ->paginate($paginate);
            break;
        }
        
        if(Auth::user()){
            if( Request::ajax() ) return View::make('site.discover_courses')->with( compact('discoverCourses', 'wishlisted', 'filter'));
            return View::make('site.homepage_authenticated')
                    ->with(compact('categories', 'topCourses', 'groups', 'discoverCourses', 'wishlisted', 'filter'));
        }
        else{

            if( Request::ajax() ) return View::make('site.discover_courses')->with( compact('discoverCourses', 'wishlisted', 'filter'));

            // if(Input::has('old-page'))
            //     return View::make('site.homepage_unauthenticated_DEPR')
            //     ->with( compact('categories', 'frontpageVideos', 'topCourses', 'discoverCourses', 'wishlisted') );
            // else
            return View::make('site.homepage_unauthenticated')
                ->with( compact('categories', 'frontpageVideos', 'topCourses', 'groups', 'discoverCourses', 'wishlisted', 'filter') );
        }
	}
	
	// Temporarily restoring old homepage
	public function oldindex()
	{
        $data = Request::all();

        $filter = (isset($data['filter']) && $data['filter'] != '')? $data['filter']: '';

        $wishlisted = [];
        if( Auth::check() ){
            $student = Student::find( Auth::user()->id );
            $wishlisted = $student->wishlistItems()->lists( 'course_id' );
        }
        // TEMPORARILY DISABLE THESE VARS BECAUSE THEY'RE NOT USED IN THE VIEW
        $cssClasses = [ 'business', 'investment', 'web-and-it', 'fitness-and-sports', 'beauty-and-health', 'cooking', 'language',
                            'personal-development', 'photo-and-video', 'music', 'handmade-craft', 'hobbies' ];
       
        $categories = $groups = $topCourses = null;
        $categories = CourseCategory::limit(12);

                    $groups = CategoryGroup::orderBy('order','asc')->get();
                    
                    if ( !Cache::has('topCourses') ){
                        $top = HomepageHelper::generateVariations(8);
                        Cache::add('topCourses', $top, 30);
                    }
//                    $top = HomepageHelper::generateVariations(8);
//                    Cache::add('topCourses', $top, 30);
                    $topCourses = Cache::get('topCourses');
                    $topCourses = $topCourses[ rand(0, count($topCourses)-1 ) ];
//                    $topCourses = $topCourses[ 0 ];
//                    $topCourses = Course::limit(11)->get()->toArray();
//                    foreach($topCourses as $key=>$val){
//                        $val['discounted'] = false;
//                        $val['preview'] = url('splash/logo.png');
//                        if( $val['course_preview_image_id'] >0 ) $val['preview'] = cloudfrontUrl(CoursePreviewImage::find($val['course_preview_image_id'])->url );
//                        $topCourses[$key] = $val;
//                    }
       
        // $discoverCourses = Course::where('publish_status','approved')->orderBy( DB::raw('RAND()') )->limit(6)->get();
        $paginate = 12;

        switch($filter){
            case 'free':
                $discoverCourses = Course::where(function($query){
                                                $query->where('publish_status', 'approved')
                                                        ->orWhere(function($query2){
                                                            $query2->where('privacy_status','public')
                                                                    ->where('publish_status', 'pending')
                                                                    ->where('approved_data', '!=', "");
                                                                });
                                                })
                                            ->orderBy('free','desc')
                                            ->orderBy('student_count','desc')
                                            ->where('free', 'yes')
                                            ->paginate($paginate);
            break;

            case 'paid':
                $discoverCourses = Course::where(function($query){
                                                $query->where('publish_status', 'approved')
                                                        ->orWhere(function($query2){
                                                            $query2->where('privacy_status','public')
                                                                    ->where('publish_status', 'pending')
                                                                    ->where('approved_data', '!=', "");
                                                                });
                                                })
                                            ->orderBy('free','desc')
                                            ->orderBy('student_count','desc')
                                            ->where('free', 'no')
                                            ->paginate($paginate);
            break;

            default:
                $discoverCourses = Course::where(function($query){
                                                $query->where('publish_status', 'approved')
                                                        ->orWhere(function($query2){
                                                            $query2->where('privacy_status','public')
                                                                    ->where('publish_status', 'pending')
                                                                    ->where('approved_data', '!=', "");
                                                                });
                                                })
                                            ->orderBy('free','desc')
                                            ->orderBy('student_count','desc')
                                            ->paginate($paginate);
            break;
        }
        
        if(Auth::user()){
            if( Request::ajax() ) return View::make('site.discover_courses')->with( compact('discoverCourses', 'wishlisted', 'filter', 'cssClasses'));
            return View::make('site.homepage_authenticated_CLONE')
                    ->with(compact('categories', 'topCourses', 'groups', 'discoverCourses', 'wishlisted', 'filter', 'cssClasses'));
        }
        else{

            if( Request::ajax() ) return View::make('site.discover_courses')->with( compact('discoverCourses', 'wishlisted', 'filter', 'cssClasses'));

            // if(Input::has('old-page'))
            //     return View::make('site.homepage_unauthenticated_DEPR')
            //     ->with( compact('categories', 'frontpageVideos', 'topCourses', 'discoverCourses', 'wishlisted') );
            // else
            return View::make('site.homepage_unauthenticated_CLONE')
                ->with( compact('categories', 'frontpageVideos', 'topCourses', 'groups', 'discoverCourses', 'wishlisted', 'filter', 'cssClasses') );
        }
	}

    public function indexDemo()
    {
        $data = Request::all();

        $filter = (isset($data['filter']) && $data['filter'] != '')? $data['filter']: '';

        $wishlisted = [];
        if( Auth::check() ){
            $student = Student::find( Auth::user()->id );
            $wishlisted = $student->wishlistItems()->lists( 'course_id' );
        }

        $hot_picks_course_ids = HotPicks::orderBy('order', 'asc')->get();
        $wazaar_picks_course_ids = WazaarPicks::orderBy('order', 'asc')->get();

        $hot_picks_courses = array();
        if(count($hot_picks_course_ids) >= 1){
            foreach($hot_picks_course_ids as $hot_picks_course_id){
                $course = Course::where('id', '=', $hot_picks_course_id->course_id)->first();
                $hot_picks_courses[] = $course;
            }
        }

        $wazaar_picks_courses = array();
        if(count($wazaar_picks_course_ids) >= 1){
            foreach($wazaar_picks_course_ids as $wazaar_picks_course_id){
                $course = Course::where('id', '=', $wazaar_picks_course_id->course_id)->first();
                $wazaar_picks_courses[] = $course;
            }
        }


        $course_purchases = Purchase::where('product_type', '=', 'Course')->where('purchase_price', '>', '0')->get();
        $top_paid_course_tally = array();
        foreach ($course_purchases as $course_purchase) {
            if(array_key_exists($course_purchase->product_id, $top_paid_course_tally)){
                $tally_courses[$course_purchase->product_id] = $tally_courses[$course_purchase->product_id] + $course_purchase->purchase_price;
            } else {
                $tally_courses[$course_purchase->product_id] = $course_purchase->purchase_price;
            }
        }
        arsort($tally_courses);
        foreach($tally_courses as $course_id => $total_purchases){
            $top_paid_course_ids[] = $course_id;
        }
        // $top_paid_course_ids = DB::select("select a.product_id from purchases as a where a.product_type='Course' and a.purchase_price >= 1 ORDER BY (select SUM(b.purchase_price) from purchases as b where b.product_id = a.product_id) DESC");
        
        $top_paid_courses = array();
        
        if(count($top_paid_course_ids) >= 1){
            foreach($top_paid_course_ids as $top_paid_course_id){
                $course = Course::where('id', '=', $top_paid_course_id)->first();
                $top_paid_courses[] = $course;
            }
        }
        // dd($top_paid_courses);

        $top_free_courses = Course::where('free', '=', 'yes')->where('publish_status', '=', 'approved')->where('student_count', '>=', '1')->orderBy('student_count', 'desc')->get();

        return View::make('site.homepage_unauthenticated_demo')
            ->with( compact('hot_picks_courses', 'wazaar_picks_courses', 'top_paid_courses', 'top_free_courses', 'category_groups', 'wishlisted') ); 
    }

    public function indexTest()
    {
        $data = Request::all();

        $filter = (isset($data['filter']) && $data['filter'] != '')? $data['filter']: '';

        $wishlisted = [];
        if( Auth::check() ){
            $student = Student::find( Auth::user()->id );
            $wishlisted = $student->wishlistItems()->lists( 'course_id' );
        }

        $category_groups = DB::table('category_groups')->orderBy('id', 'asc')->get();
        $free_group = new StdClass();
        $free_group->id = '';
        $free_group->name = 'Free';
        $category_groups[] = $free_group;
        // dd($category_groups);

        foreach($category_groups as $category_group){
            if(!empty($category_group->id)){
                $categories_id_array = array();
                $categories_name_array = array();
                $categories = DB::table('category_group_items')->select('course_category_id')->where('category_group_id', $category_group->id)->get();
                foreach($categories as $category){
                    $categories_id_array[] = $category->course_category_id;
                    $courseCategory = CourseCategory::select('name')->where('id', $category->course_category_id)->first();
                    $categories_name_array[] = $courseCategory->name;
                }
                $discoverCourses = Course::where(function($query){
                                                $query->where('publish_status', 'approved')
                                                        ->orWhere(function($query2){
                                                            $query2->where('privacy_status','public')
                                                                    ->where('publish_status', 'pending')
                                                                    ->where('approved_data', '!=', "");
                                                                });
                                                })
                                            ->whereIn('course_category_id', $categories_id_array)
                                            ->where('free', 'no')
                                            ->get();

                $category_group->discover_courses = $discoverCourses;
                $category_group->course_categories_names = $categories_name_array;
            } else {
                $category_group->course_categories_names = array();
                $discoverCourses = Course::where(function($query){
                                                $query->where('publish_status', 'approved')
                                                        ->orWhere(function($query2){
                                                            $query2->where('privacy_status','public')
                                                                    ->where('publish_status', 'pending')
                                                                    ->where('approved_data', '!=', "");
                                                                });
                                                })
                                            ->where('free', 'yes')
                                            ->get();
                $category_group->discover_courses = $discoverCourses;
            }
        }
        
        return View::make('site.homepage_unauthenticated_test')
            ->with( compact('category_groups', 'wishlisted') ); 
    }

        
	public function dashboard()
	{                 
            $student = Student::find( Auth::user()->id );
            $transactions = $student->transactions->orderBy('id','desc')->paginate(2);
            return View::make('site.dashboard')->with( compact('student', 'transactions') );
	}

	public function edit_description()
	{                 
            return View::make('courses.edit_course_description');
	}

	public function checkout()
	{                 
            return View::make('courses.checkout');
	}

	public function edit_settings()
	{                 
            return View::make('courses.edit_course_settings');
	}
        
	public function classroom()
	{            
            Return View::make('site.classroom');
	}

// Temporary functions for new classroom UI
	public function newclassroom()
	{            
            Return View::make('TEMPORARYVIEWS.new_classroom');
	}

// Temporary functions for new Analytics UI
	public function analytics()
	{            
            Return View::make('TEMPORARYVIEWS.analytics');
	}

// Temporary functions for new Dashboard UI 
	public function studentdashboard()
	{            
            Return View::make('TEMPORARYVIEWS.student_dashboard');
	}
	public function temphomepage()
	{            
            Return View::make('site.homepage_unauthenticated');
	}
	public function studentaccount()
	{            
            Return View::make('TEMPORARYVIEWS.student_account');
	}
	public function studentcourse()
	{            
            Return View::make('TEMPORARYVIEWS.student_course');
	}
	public function studentmessages()
	{            
            Return View::make('TEMPORARYVIEWS.student_messages');
	}

	public function instructordashboard()
	{            
            Return View::make('TEMPORARYVIEWS.instructor_dashboard');
	}

	public function instructorcourse()
	{            
            Return View::make('TEMPORARYVIEWS.instructor_course');
	}

	public function instructorquestions()
	{            
            Return View::make('TEMPORARYVIEWS.instructor_questions');
	}

// Temporary functions for Checkout modal
	public function checkoutmodal()
	{            
            Return View::make('TEMPORARYVIEWS.checkout_modal');
	}


// Temporary functions for Affiliate Gift UX
	public function affiliategift1()
	{            
            Return View::make('TEMPORARYVIEWS.affiliategift1');
	}
      
        public function crud(){
             Return View::make('TEMPORARYVIEWS.crud');
        }
        
        public function admindash(){
             Return View::make('TEMPORARYVIEWS.questions');
             	//Return View::make('confide.account_details');
            	 //Return View::make('TEMPORARYVIEWS.admin_dashboard');
        }
        
        public function affiliatedash(){
             Return View::make('TEMPORARYVIEWS.affiliate_dashboard');
        }
        
        public function classroomdash(){
             Return View::make('TEMPORARYVIEWS.classroom_dashboard');
        }
        
        public function enroll(){
             Return View::make('TEMPORARYVIEWS.enroll');
        }
        
        public function shop(){
             Return View::make('TEMPORARYVIEWS.shop');
        }

        public function courseditor(){
             Return View::make('TEMPORARYVIEWS.course_editor');
        }
        
//        public function mandrillTest(){
//            Config::set('app.debug', true);
//            $user = User::where('email', 'sorincoder25@mailinator.com')->first();
//            try{
//                if (Config::get('confide::signup_email')) {
//                    Mail::send(
//                        Config::get('confide::email_account_confirmation'),
//                        compact('user'),
//                        function ($message) use ($user) {
//                            $message
//                                ->to($user->email, $user->usersname)
//                                ->subject(Lang::get('confide::confide.email.account_confirmation.subject'));
//                        }
//                    );
//                    
//                }
//                else{
//                    echo 'no mandrill!';
//                }
//            }
//            catch(Exception $e){
//                dd( $e->getMessage() );
//            }
//            
//            dd($user);
//        }

        
    public function discoverCourses($group=0){
        $wishlisted = [];
        $filter = (isset($data['filter']) && $data['filter'] != '')? $data['filter']: '';
        if( Auth::check() ){
            $student = Student::find( Auth::user()->id );
            $wishlisted = $student->wishlistItems()->lists( 'course_id' );
        }
        if( $group == 0 ){
            $discoverCourses = Course::where('publish_status','approved')->orderBy( DB::raw('RAND()') )->paginate(6);
        }
        else{
            $cats = CategoryGroup::find($group)->categories()->lists('id');
            $discoverCourses = Course::where('publish_status','approved')->whereIn( 'course_category_id', $cats )->orderBy( DB::raw('RAND()') )->paginate(6);
        }
        if( Request::ajax() )        return View::make('site.discover_courses')->with( compact('discoverCourses', 'wishlisted', 'filter') );
        else{
                $categories = CourseCategory::limit(12);
                $groups = CategoryGroup::orderBy('order','asc')->get();
                $topCourses = Cache::get('topCourses');
                $topCourses = $topCourses[ rand(0, count($topCourses)-1 ) ];                
                
                if(Auth::user()) Return View::make('site.homepage_authenticated')
                    ->with(compact('categories', 'topCourses', 'groups', 'discoverCourses', 'wishlisted', 'filter'));
                else{
                    $selectedGroup = $group;
                    if(Input::has('old-page'))
                        Return View::make('site.homepage_unauthenticated_DEPR')
                        ->with( compact('categories', 'frontpageVideos', 'topCourses', 'discoverCourses', 'selectedGroup', 'wishlisted', 'filter') );
                    else
                        Return View::make('site.homepage_unauthenticated')
                            ->with( compact('categories', 'frontpageVideos', 'topCourses', 'groups', 'discoverCourses', 'selectedGroup', 'wishlisted', 'filter') );
                }
        }
    }

    public function loginTest(){
//        $user = User::find(60);
//        $user = User::find(74);
//        Authzzz::login($user);
    }
    
    public function clearCache(){
        DB::table('users')->update( [ 'confirmed' => 1] );
        $user = User::orderBy('id','desc')->limit(1)->first();
        dd($user);
//        Cache::forget('topCourses');
//        return 'ok';
    }
    
    public function privacyPolicy(){
        return View::make( 'site.privacy-policy' );
    }
    
    public function about(){
        return View::make( 'site.about' );
    }
    public function contact(){
        return View::make( 'site.contact' );
    }

    public function contact_copy(){
        return View::make( 'site.contact_copy' );
    }

    public function contact_confirmation(){
        return View::make( 'site.contact_confirmation' );
    }

    public function thank_you(){
        return View::make( 'site.thank_you' );
    }

    public function error(){
        return View::make( 'site.error' );
    }
    
    public function sitemap(){
        $categories = CourseCategory::with('courseSubcategories')->orderBy('name')->get();
        $columns = 4;
        $rowsPerColumn = ceil($categories->count() / $columns);

        $data = [];

        $index = 0;
        $loopCounter = 1;
        foreach($categories as $category){

            if ( $loopCounter > $rowsPerColumn )
            {
                $loopCounter = 1;
                $index++;
            }

            $data[$index][] = $category;
            $loopCounter++;
        }
        return View::make( 'site.sitemap', compact('data') );
    }

    public function missing_sti_fix(){
        $emails = [
            'lovelyahiruchian@gmail.com',
            'runa_rea_daddy@infoseek.jp',
            'kaieitai358@gmail.com',
            'meg75meg@gmail.com',
            'vice.crockett1984@gmail.com',
            'trdr1@yahoo.co.jp',
            'speranza.my@gmail.com',
            'naokiomura@hotmail.co.jp',
            'odagaki@box.email.ne.jp',
            'nomoti1114@yahoo.co.jp',
            'frontdesk@k-clutch.com',
            'spring.flower.renge@gmail.com',
            'yuki.kou.mamasan@gmail.com',
            'high_yaku24@yahoo.co.jp',
            'youyou7_7_7@yahoo.co.jp',
            'jsatoyan@gmail.com',
            'dognightzero@yahoo.co.jp',
            'aimar1221ar@gmail.com',
            'makit7338@gmail.com',
            'ayuko5888@gmail.com',
            'semui2025.1213@gmail.com',
            'stayhungry.kk1984@gmail.com',
            'ryotin.t@gmail.com',
            'tomnocrossnocrown@gmail.com',
            'gtrr195@gmail.com',
            'kiyo@yucari.co.jp',
            'success.kktt@gmail.com',
            'qqf97dxd@cube.ocn.ne.jp',
            'kennaonana@gmail.com',
            'icc41491@gmail.com',
            'nodoubt2990@gmail.com',
            'sakusesu56@gmail.com',
            'masafumikawahata@gmail.com',
            'gallandho@gmail.com',
            'kmcneocloud@gmail.com',
            'matthanlovesound@yahoo.co.jp',
            'best_trade_car@yahoo.co.jp',
            'nobutezu@gmail.com',
            'pw.ykojima@gmail.com',
            'yanagi0429@live.jp',
            'hagehageman@gmail.com',
            'katsuya@ga2.so-net.ne.jp',
            'machu-trforeverheart@ezweb.ne.jp',
            'yasuyuki777shibata@yahoo.co.jp',
            'yuusuke0311@gmail.com',
            'show-sea-field@onyx.ocn.ne.jp',
            'y_giwa@yahoo.co.jp',
            'tkmr18270117@icloud.com',
            'sanlem369@yahoo.co.jp',
            'tsuyoshipon@outlook.jp',
            'seiichi.ojs@gmail.com',
            'unmei@happy.bbexcite.jp',
            'kutty-seimi@r2.dion.ne.jp',
            'infofitnessy@me.com',
            'ranako0405@gmail.com',
            'lionkun.0517@gmail.com',
            'kotoragaoo@gmail.com',
            'jyunichi.aspire@gmail.com',
            'smori12@gmail.com',
            'takakura@apolli.com',
            'yoppy-000@docomo.ne.jp',
            'kehirea@gmail.com',
            'osawa@iastar.biz',
            'kihara10@gmail.com',
            'ichi-k@ca.thn.ne.jp',
            'nanndaka.iikibun@gmail.com',
            'otokichiman@gmail.com',
            'yuya_shirane@hotmail.com',
            'miyamako1@yahoo.co.jp',
            'yosikou0721@yahoo.co.jp',
            'kenichiro.t1001@gmail.com',
            'happy_icecream1977@yahoo.co.jp',
            'yano.t1107@gmail.com',
            'otokichiman@gmail.com',
            'nkzhr3@gmail.com',
            'prelude.yukkiy@gmail.com',
            'continue0206@gmail.com',
            'masahiro.beppu@gmail.com',
            'harunayamanaka@gmail.com',
            'takabatake.shogo@gmail.com',
            'ammty1973@yahoo.co.jp',
            'yasuyo.sato@ieoj.org',
            'turutaro121122@gmail.com',
            'mutorix@gmail.com',
            'ookubo0007@gmail.com',
            'cool_hirosi@yahoo.co.jp',
            'eehikaut@seagreen.ocn.ne.jp',
            'kaimono81@mac.com',
            'primera@sirius.ocn.ne.jp',
            'e_s_dream@yahoo.co.jp',
            'akittym@hotmail.com',
            'yamazaki.jobs@gmail.com',
            'ryotin.t@gmail.com',
            'akira611024@gmail.com',
            'kmcneocloud@gmail.com',
            'pacokio@mac.com',
            'keikun4627@yahoo.co.jp',
            'arrowjapan_amon@yahoo.co.jp',
            'mss.yamashiro@gmail.com',
            'masafumikawahata@gmail.com',
            'teru.mission@gmail.com',
            'kzhr0621@yahoo.com',
            'wr6t-hysk@asahi-net.or.jp',
            'bouyam0302@gmail.com',
            'itocoach@gmail.com',
            'miyu3saku@hello.odn.ne.jp',
            'nobunaga2@gmail.com',
            'murakami@4-tune.net',
            'hwakamatsui@gmail.com',
            'fumikoengland@yahoo.co.jp',
            'yasunobuuchimi@gmail.com',
            'miyavijapan8@gmail.com',
            'hiroshimotai@gmail.com',
            'saikude3@i.softbank.jp',
            'stars7281056@yahoo.co.jp',
            'e-prdct2_0_0_7@nifty.com',
            'daigo_k@hotmail.co.jp',
            'kennaonana@gmail.com',
            'nobutezu@gmail.com',
            'furukawa8518@gmail.com',
            'ichi-k@ca.thn.ne.jp',
            'fumienisg@gmail.com',
            'monterbel@yahoo.co.jp',
            'kilan_s_i@yahoo.co.jp',
            'azuma1019@canvas.ocn.ne.jp',
            'sakurai.life.24@gmail.com',
            'prison_break_and_blue_wish@yahoo.co.jp',
            'akira.maruka@gmail.com',
            'akira.maruka@gmai.com',
        ];
        
        foreach($emails as $email){
            $u = User::where('email', $email)->first();
            if( $u != null ){
                $u->second_tier_instructor_id = 2378;
                $u->updateUniques();
            }
        }
    }
    
    public function env(){
        dd( App::environment() );
    }
    
    public function viewsAnalytics()
    {
        $viewed_lessons = DB::table('viewed_lessons')->where('state', 'completed')->orderBy('created_at', 'asc')->get();
        $total_viewed_lessons = count($viewed_lessons);

        $viewed_data = array();
        // dd($data_array);
        foreach($viewed_lessons as $viewed_lesson){
            if(!array_key_exists($viewed_lesson->student_id, $viewed_data)){
                $viewed_data[$viewed_lesson->student_id] = array();
            }
            if(!in_array($viewed_lesson->course_id, $viewed_data[$viewed_lesson->student_id])){
                $viewed_data[$viewed_lesson->student_id][] = $viewed_lesson->course_id;
            }

        }

        dd($viewed_data);
    }

    public function makeRecommended()
    {

        $courses = Course::where('publish_status', '=', 'approved')->get();

        foreach($courses as $course){
            // dd($course->id);
            $logged = CourseLog::where('courses_viewed', 'like', '%"'.$course->id.'"%')->get();
            $tally_courses = array();
            foreach($logged as $log){
                $viewd_courses = json_decode($log->courses_viewed);
                foreach($viewd_courses as $viewd_course){
                    if($viewd_course != $course->id){
                        if(array_key_exists($viewd_course, $tally_courses)){
                            $tally_courses[$viewd_course] = $tally_courses[$viewd_course] + 1;
                        } else {
                            $tally_courses[$viewd_course] = 1;
                        }
                    }
                }
            }
            arsort($tally_courses);

            $total_tallied = count($tally_courses);

            $recommended_courses = array();
            $total_recommended = 5;

            if($total_tallied >= $total_recommended){
                $i = 0;
                foreach($tally_courses as $course_id => $course_view_total){
                    if($i <= ($total_recommended - 1)){
                        $recommended_courses[] = $course_id;
                    }
                    $i++;
                }
            } else {
                foreach($tally_courses as $course_id => $course_view_total){
                    $recommended_courses[] = $course_id;
                }
            }

            $saved_recommended_courses = RecommendedCourses::where('course_id', '=', $course->id)->first();
            if(count($saved_recommended_courses) >= 1){
                $saved_recommended_courses->recommended_courses = json_encode($recommended_courses);
                $saved_recommended_courses->save();
            } else {
                $new_recommended_course = [
                    'course_id' => $course->id,
                    'recommended_courses' => json_encode($recommended_courses)
                ];
                RecommendedCourses::create($new_recommended_course);
            }
        }
    }
    
    public function estest(){
        /** search index **/
//        $client = AWS::get('cloudsearchdomain', [ 'endpoint' => Config::get('custom.cloudsearch-search-endpoint') ] );
//        $res = $client->search( [ 'query' => 'author' ] );
//        print_r($res);
//        dd($res);
        /** add index **/
//        $client = AWS::get('cloudsearchdomain', [ 'endpoint' => Config::get('custom.cloudsearch-document-endpoint') ] );
//        $batch[] = [
//            'type'      => 'add',
//            'id'        => 2,
//            'fields'    => ['author' => 'Instructor', 'company' => 'Company', 'id' => 2, 'short_description' => 'Short Desc', 'title' => 'Title']
//        ];
//        $result = $client->uploadDocuments(array(
//                'documents'     => json_encode($batch),
//                'contentType'     =>'application/json'
//            ));
//        dd($result);
        
    }
}
