<?php

class SiteController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'auth', [ 'only' => ['dashboard'] ] );
//            View::share( 'headerShowTopLinks', 1 );
        }

	public function index()
	{
            
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
                $discoverCourses = Course::orderBy('free','desc')->orderBy('student_count','desc')
                        ->where(function($query){
                            $query->where('publish_status', 'approved')
                            ->orWhere(function($query2){
                                $query2->where('privacy_status','public')
                                        ->where('publish_status', 'pending')
                                        ->where('approved_data', '!=', "");
                            });
                        })
                        ->paginate(12);
                
                if(Auth::user()){
                    Return View::make('site.homepage_authenticated')
                            ->with(compact('categories', 'topCourses', 'groups', 'discoverCourses', 'wishlisted'));
                }
                else{

                    if( Request::ajax() ) Return View::make('site.discover_courses')->with( compact('discoverCourses', 'wishlisted'));

                    if(Input::has('old-page'))
                        Return View::make('site.homepage_unauthenticated_DEPR')
                        ->with( compact('categories', 'frontpageVideos', 'topCourses', 'discoverCourses', 'wishlisted') );
                    else
                        Return View::make('site.homepage_unauthenticated')
                            ->with( compact('categories', 'frontpageVideos', 'topCourses', 'groups', 'discoverCourses', 'wishlisted') );
                }
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
        if( Auth::check() ){
            $student = Student::find( Auth::user()->id );
            $wishlisted = $student->wishlistItems()->lists( 'course_id' );
        }
        if( $group == 0 ){
            $discoverCourses = Course::where('publish_status','approved')->orderBy( DB::raw('RAND()') )->limit(6)->get();
        }
        else{
            $cats = CategoryGroup::find($group)->categories()->lists('id');
            $discoverCourses = Course::where('publish_status','approved')->whereIn( 'course_category_id', $cats )->orderBy( DB::raw('RAND()') )->limit(6)->get();
        }
        if( Request::ajax() )        return View::make('site.discover_courses')->with( compact('discoverCourses', 'wishlisted') );
        else{
                $categories = CourseCategory::limit(12);
                $groups = CategoryGroup::orderBy('order','asc')->get();
                $topCourses = Cache::get('topCourses');
                $topCourses = $topCourses[ rand(0, count($topCourses)-1 ) ];                
                
                if(Auth::user()) Return View::make('site.homepage_authenticated')
                    ->with(compact('categories', 'topCourses', 'groups', 'discoverCourses', 'wishlisted'));
                else{
                    $selectedGroup = $group;
                    if(Input::has('old-page'))
                        Return View::make('site.homepage_unauthenticated_DEPR')
                        ->with( compact('categories', 'frontpageVideos', 'topCourses', 'discoverCourses', 'selectedGroup', 'wishlisted') );
                    else
                        Return View::make('site.homepage_unauthenticated')
                            ->with( compact('categories', 'frontpageVideos', 'topCourses', 'groups', 'discoverCourses', 'selectedGroup', 'wishlisted') );
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
    

}
