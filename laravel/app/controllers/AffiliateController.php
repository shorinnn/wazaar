f<?php

class AffiliateController extends \BaseController {
    
    public function __construct(UserRepository $users){
        $this->users = $users;
        $this->beforeFilter( 'affiliate', ['except' => [ 'becomeAffiliate', 'doBecomeAffiliate', 'create', 'store', 'login', 
            'doLogin', 'forgotPassword', 'doForgotPassword' ] ] );
        $this->beforeFilter('guest', ['only' => [ 'login', 'doLogin', 'forgotPassword', 'doForgotPassword' ]]);
        $this->beforeFilter('csrf', ['only' => [ 'store', 'update', 'destroy' ]]);
    }
    
        public function index(){
            if( Auth::guest() ) return Redirect::action('AffiliateController@login');
            else return Redirect::action('AffiliateDashboardController@index');
        }

	public function promote($course, $tcode='')
	{
            $course = Course::where('slug', $course)->first();
            $course->gifts = $course->gifts()->where('affiliate_id', Auth::user()->id)->get();
            if( $course->gifts->count() == 0 ){
                $gift = new Gift();
                $gift->course_id = $course->id;
                $gift->affiliate_id = Auth::user()->id;
                $gift->save();
                $course->gifts->add( $gift );
            }
            return View::make('affiliate.promote.promote')->with( compact('course', 'tcode') );
	}
        
        public function acceptTerms(){
            $a = ProductAffiliate::find( Auth::user()->id );
//            if( !Session::has('redirect-after-accept') ) Session::put('redirect-after-accept', $_SERVER['HTTP_REFERER']);
            return View::make('affiliate.at');
        }
        
        public function doAcceptTerms(){
            if( Input::get('accept') != 1 ) return View::make('affiliate.at');
            Auth::user()->accepted_affiliate_terms = 'yes';
            Auth::user()->updateUniques();
//            if( Session::has('redirect-after-accept') ){
//                $url = Session::get('redirect-after-accept');
//                Session::forget('redirect-after-accept');
//                return Redirect::to( $url );
//            }
            return Redirect::action('AffiliateDashboardController@index');
        }
        
        /**
     * Displays the form for account creation
     * @param mixed $instructor_account If not 0, sign up for a instructor account
     * @return  Illuminate\Http\Response
     */
    public function create($instructor_account = 'affiliate')
    {
        $extraText = trans('general.register-affiliate');
        
        if( Input::has('stai')){
//            Cookie::queue('stai', Input::get('stai'), 60*24*30);
        }
        return View::make( 'confide.affiliates.signup' )->with( compact('instructor_account', 'extraText') );
    }
    
    public function store()
    {
        if( Auth::check() ) Session::flush();
        
        $roles['affiliate'] = Input::get('register_affiliate');//Cookie::get('register_affiliate');
        $st = Input::get('st');
        $stai = Cookie::get('stai');
        $stai = null;
        $user = $this->users->signup( Input::all(), $stai, $roles, Cookie::get('stpi'), Cookie::get('iai'), $st );
        
        if ( $user!=null && $user->id) {
            try{
//                $subject = '販売者アカウント確認のご連絡';
                $subject = 'アフィリエイターアカウントのご連絡';
                $view = 'confide.emails.regular_confirm';
                $lastName = $user->last_name;
                if (Config::get('confide::signup_email')) {
                    Mail::send(
                        $view,
                        compact('user' , 'lastName' ),
                        function ($message) use ($user, $subject) {
                            $message->getHeaders()->addTextHeader('X-MC-Important', 'True');
                            $message
                                ->to($user->email, $user->email)
                                ->subject( $subject );
                        }
                    );
                }
            }
            catch(Exception $e){
                
            }

            Cookie::queue('register_instructor', null, -1);
            Cookie::queue('register_affiliate', null, -1);
            Cookie::queue('ltc', null, -1);
            Cookie::queue('st', null, -1);
            Cookie::queue('iai', null, -1);
            Cookie::queue('stai', null, -1);
            Cookie::queue('stpi', null, -1);
            Auth::login($user);
            if(Request::ajax()) return json_encode( [ 'status' => 'success', 'url' => $user->url ] );
            return Redirect::intended( $user->url );
        } else {
            $error = implode('<br />',$user->errors()->all());
            $input = Input::all();
            unset($input['password']);
          
            if(Request::ajax()) return json_encode( [ 'status' => 'error', 'errors' => $user->errors()->getMessages() ] );
            return Redirect::back()->with('error', $error)->withInput( $input );//Redirect::action('UsersController@create')

        }
    }
    
    public function login()
    {        
            return View::make( 'confide.affiliates.login' );
    }

    /**
     * Attempt to do login
     *
     * @return  Illuminate\Http\Response
     */
    public function doLogin()
    {
        
        $input = Input::all();
        $input['email'] = '#waa#-'.$input['email'];

        if ($this->users->login($input)) {
            if(Request::ajax()){
                return json_encode( ['status' => 'success'] );
            }
            
            if(Auth::user()->is_second_tier_instructor=='yes') return Redirect::action('UsersController@links');
            elseif( Auth::user()->hasRole('Instructor') ) return Redirect::action('CoursesController@myCourses');
            return Redirect::action('AffiliateDashboardController@index');
        } else {
            if ($this->users->isThrottled($input)) {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
            } elseif ($this->users->existsButNotConfirmed($input)) {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            } else {
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
                
            }
            $input = Input::all();
            unset($input['password']);
            if(Request::ajax()){
                return json_encode( ['status' => 'error', 'errors' => ['password' => [$err_msg] ] ] );
            }
            return Redirect::action('AffiliateController@login')
                ->withInput($input)
                ->with('error', $err_msg);
        }
    }
    
     public function forgotPassword()
    {
        return View::make( 'confide.affiliates.forgot_password');
    }
    
    public function doForgotPassword()
    {
        $old = Config::get('queue.default');
        Config::set('queue.default', 'sync');
        $email = Input::get('email');
        $email = '#waa#-'.Input::get('email');
        
        if (Confide::forgotPassword($email)) {
            Config::set('queue.default', $old);
            $notice_msg = Lang::get('confide::confide.alerts.password_forgot');
            return Redirect::action('AffiliateController@login')
                ->with('notice', $notice_msg);
        } else {
            Config::set('queue.default', $old);
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_forgot');
            return Redirect::action('AffiliateController@forgotPassword')
                ->withInput()
                ->with('error', $error_msg);
        }
    }
        
//        public function becomeAffiliate(){
//            $a = ProductAffiliate::find( Auth::user()->id );
//            return View::make('affiliate.become');
//        }
//        
//        public function doBecomeAffiliate(){
//            if( Input::get('accept') != 1 ) return View::make('affiliate.become');
//            
//            $users = new UserRepository();
//            $users->become( 'Affiliate', Auth::user(), null, Cookie::get('aid') );
//                
//            Auth::user()->accepted_affiliate_terms = 'yes';
//            Auth::user()->updateUniques();
//            return Redirect::action('ProfileController@index');
//        }
}