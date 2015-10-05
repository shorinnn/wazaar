<?php



/**
 * UsersController Class
 *
 * Implements actions regarding user management
 */
class UsersController extends Controller
{
    public function __construct(UserRepository $users){
        $this->users = $users;
        $this->beforeFilter('guest', array('only' => array('create', 'secondTierPublisherCreate', 'login' )));
//        $this->beforeFilter('auth', array('only' => array('verificationConfirmation', 'registrationConfirmation' ,'links')));
    }

    /**
     * Displays the form for account creation
     * @param mixed $instructor_account If not 0, sign up for a instructor account
     * @return  Illuminate\Http\Response
     */
    public function create($instructor_account = 0)
    {
        
        Cookie::queue("register_affiliate",  null, -1);
        
        if( Auth::guest() ){
            Cookie::queue('st', null, -1);
            Cookie::forget('st');
        }
        $extraText = '';
        if( $instructor_account === 'instructor' ){
            Cookie::queue("register_instructor", 1, 30);
            $extraText = trans('general.register-instructor');
        }
        if( $instructor_account === 'affiliate' ){
            $extraText = trans('general.register-affiliate');
        }
        
        return View::make(Config::get('confide::signup_form'))->with( compact('instructor_account', 'extraText') );
    }
    
    /**
     * Displays the form for account creation
     * @param mixed $instructor_account If not 0, sign up for a instructor account
     * @return  Illuminate\Http\Response
     */
    public function secondTierPublisherCreate()
    {
//        if( Auth::guest() ){
//            Cookie::queue('st', 1, 24*30);
//        }
        Cookie::queue('st', 1, 24*30);
        $extraText = trans('general.register-2-tier');
        $secondTierRegister = $st = 1;
        return View::make(Config::get('confide::signup_form'))->with( compact('extraText','secondTierRegister', 'st' ) );
//        return View::make('confide.second_tier_publisher_signup');
    }
    
    /**
     * Stores new account
     *
     * @return  Illuminate\Http\Response
     */
    public function store()
    {
        $roles['instructor'] = Input::get('register_instructor');//Cookie::get('register_instructor');
        //$roles['affiliate'] = Input::get('register_affiliate');//Cookie::get('register_affiliate');
        $st = Input::get('st'); // Cookie::get('st')
        $stpi = Cookie::get('stpi2');// disable this at one point
        $user = $this->users->signup( Input::all(), Cookie::get('ltc'), $roles, $stpi, Cookie::get('iai'), $st );
        
        if ( $user!=null && $user->id) {
            try{
//                $subject = '販売者アカウント確認のご連絡';
                $subject = 'アカウント確認のご連絡';
                $view = 'confide.emails.regular_confirm';
                $lastName = $user->last_name;
                if($user->is_second_tier_instructor=='yes'){
                    $subject = Lang::get('confide::confide.email.account_confirmation.subject');
                    $view = Config::get('confide::email_account_confirmation');
                }
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
            Cookie::queue('stpi', null, -1);
            unset($user->url);
            Auth::login($user, true);
            $user->setCustom('intended-redirect', Session::get('url.intended') );
            $user->updateUniques();
            Session::set('verifiedLogin', 1);
            
            return Redirect::action('UsersController@registrationConfirmation' );
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

    /**
     * Displays the login form
     *
     * @return  Illuminate\Http\Response
     */
    public function login()
    {        
            return View::make(Config::get('confide::login_form'));
    }

    /**
     * Attempt to do login
     *
     * @return  Illuminate\Http\Response
     */
    public function doLogin()
    {
        
        $input = Input::all();

        if ($this->users->login($input)) {
            Session::set('verifiedLogin', 1);
            if(Request::ajax()){
                return json_encode( ['status' => 'success'] );
            }
            
            //if(Auth::user()->is_second_tier_instructor=='yes') return Redirect::action('UsersController@links');
            if( Auth::user()->hasRole('Instructor') ) return Redirect::intended( nonHttps( action('CoursesController@myCourses') ) );
            return Redirect::intended( nonHttps( action('SiteController@index') ) );
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
            return Redirect::action('UsersController@login')
                ->withInput($input)
                ->with('error', $err_msg);
        }
    }
    
    public function loginWithGoogle() {
        // get data from input
        $code = Input::get( 'code' );
        // get google service
        $googleService = OAuth::consumer( 'Google' );
        // check if code is valid
        // if code is provided get user data and sign in
        if ( !empty( $code ) ) {
            // This was a callback request from google, get the token
            $token = $googleService->requestAccessToken( $code );
            // Send a request with it
            $result = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );
            // See if we need to register this user
            
            $user = $this->users->where('google_plus_login_id',$result['id'])->first();
            if($user == null){
                 // see if email is aready in the system
                if($user = $this->users->where('email', $result['email'])->first()){
                    Session::set('uid', $user->id);
                    Session::set('gid', $result['id']);
                    Session::set('glink', $result['link']);
                    return Redirect::action('UsersController@linkGooglePlus');
                }
                else{
                    // create user
                    $roles['instructor'] = Cookie::get('register_instructor');
                    $roles['affiliate'] = Cookie::get('register_affiliate');
                    $user = $this->users->signupWithGoogle($result, Cookie::get('ltc'), $roles, Cookie::get('stpi'), Cookie::get('iai'), Cookie::get('st') );

                    if(!$user->id){ 
                        // cannot create user
                        $error = $user->errors()->all(':message');
                        return Redirect::action('UsersController@create')
                            ->withInput(Input::except('password'))
                            ->with('error', $error);
                    }
                    else{
                        Cookie::queue('ltc', null, -1);
                        Cookie::queue('register_instructor', null, -1);
                        Cookie::queue('register_affiliate', null, -1);
                        $this->users->saveSocialPicture($user, "G$result[id]", "$result[picture]?sz=150");
                        //user created
                        unset($user->url);
                        Auth::login($user, true);
                        return Redirect::intended('/');
                    }
                }
            }
            else{
                // login
                unset($user->url);
                Auth::login($user, true);
                return Redirect::intended('/');
            }

        }
        // if not ask for permission first
        else {
            // get googleService authorization
            $url = $googleService->getAuthorizationUri();

            // return to google login url
            return Redirect::intended( (string)$url );
        }
    }
    
    public function fbLogin($encryptedUserId = ''){
        if (!Session::has('f')){
            $id = Crypt::decrypt($encryptedUserId);
        }
        else{
            $id = Session::get('f');
        }

        //dd($id);
        $user = User::find($id);
//        Auth::loginzzz($user);
        Auth::loginUsingId( $id , true);
        Session::forget('f');
        Session::set('verifiedLogin', 1);
        //if($user->is_second_tier_instructor=='yes') return Redirect::action('UsersController@links');
        if( $user->hasRole('Instructor') ) return Redirect::action('CoursesController@myCourses');
        else return Redirect::intended('/');
    }
    
    /**
     * Show Link existing email account with Google account page
     */
    public function linkGooglePlus(){
        return View::make('confide.link_google');
    }
    
    /**
     * Perform FB link action
     */
    public function doLinkGooglePlus(){
        
        if( $this->users->linkGooglePlus(Input::all(), Session::get('uid'), Session::get('gid'), Session::get('glink')) ){
            Session::flash('success', trans('acl.google_linked'));
            return Redirect::intended('/');
        }
        else{
            return Redirect::action('UsersController@linkGooglePlus')->with('error', trans('acl.password_not_valid'));
        }
    }
    
    public function confirmationCode(){
        
        $user = $this->users->find(Session::get('uid'));
        $code = $string = str_random(4);
        $user->social_confirmation = $code;
        $user->save();
        Mail::queue('confide.emails.social_confirmation_code', array('code' => $code), function($message) use ($user){
            $message->getHeaders()->addTextHeader('X-MC-Important', 'True');
            $message->to($user->email, "$user->first_name $user->last_name")->subject( trans('acl.social_confirmation_subject') );
        });
        if(Input::get('social_network')=='google') return Redirect::action('UsersController@linkGooglePlus')->with('notice', trans('acl.code_sent'));
        else return Redirect::action('UsersController@linkFacebook')->with('notice', trans('acl.code_sent'));
    }
    
    /**
     * Login user with facebook
     *
     * @return void
     */

    public function loginWithFacebook() {
        // get data from input
        $code = Input::get( 'code' );
        // get fb service
        $fb = OAuth::consumer( 'Facebook' );
        // if code is provided get user data and sign in
        if ( !empty( $code ) ) {
            // This was a callback request from facebook, get the token
            $token = $fb->requestAccessToken( $code );
            // Send a request with it
            $result = json_decode( $fb->request( '/me?fields=email,link,first_name,last_name' ), true );
            // See if we need to register this user
            $user = $this->users->where('facebook_login_id',$result['id'])->first();
            if($user == null){
                // see if email is aready in the system
                if($user = $this->users->where('email', $result['email'])->first()){
                    Session::set('uid', $user->id);
                    Session::set('fbid', $result['id']);
                    Session::set('fblink', $result['link']);
                    return Redirect::action('UsersController@linkFacebook');
                }
                else{
                    // create user
                    $roles['instructor'] = Cookie::get('register_instructor');
                    $roles['affiliate'] = Cookie::get('register_affiliate');
                    $user = $this->users->signupWithFacebook($result, Cookie::get('ltc'), $roles, Cookie::get('stpi'), Cookie::get('iai'), Cookie::get('st') );
                    if(!$user->id){ 
                        // cannot create user
                        $error = $user->errors()->all(':message');
                        return Redirect::action('UsersController@create')
                            ->withInput(Input::except('password'))
                            ->with('error', $error);
                    }
                    else{
                        Cookie::queue('register_instructor', null, -1);
                        Cookie::queue('register_affiliate', null, -1);
                        Cookie::queue('ltc', null, -1);
                        Cookie::queue('st', null, -1);
                        Cookie::queue('iai', null, -1);
                        Cookie::queue('stpi', null, -1);
                        $this->users->saveSocialPicture($user, "FB$result[id]", "https://graph.facebook.com/$result[id]/picture?type=large");
                        //user created
                        Session::put('f', $user->id);
                        Cookie::make('f',$user->id,5);
                        Session::set('verifiedLogin', 1);
                        return Redirect::action('UsersController@fbLogin',[Crypt::encrypt($user->id)]);
//                        return Redirect::action('UsersController@fbLogin');
                        
//                        $user = User::find( $user->id );
//                        Auth::loginzzz($user);
//                        if($user->is_second_tier_instructor=='yes') return Redirect::action('UsersController@links');
//                        else return Redirect::intended('/');
                    }
                }
                
            }
            else{
                // login
                Session::put('f', $user->id);
                Cookie::make('f',$user->id,5);
                return Redirect::action('UsersController@fbLogin',[Crypt::encrypt($user->id)]);
                
//                $user = User::find( $user->id );
//                Auth::loginzzz($user);
//                if($user->is_second_tier_instructor=='yes') return Redirect::action('UsersController@links');
//                else return Redirect::intended('/');
            }
        }
        // if not ask for permission first
        else {
            // get fb authorization
            $url = $fb->getAuthorizationUri();
            // return to facebook login url
            return Redirect::to( (string)$url );
//            return Redirect::intended( (string)$url );
        }
    }
    
    /**
     * Show Link existing email account with FB account page
     */
    public function linkFacebook(){
        return View::make('confide.link_facebook');
    }
    
    
    
    /**
     * Perform FB link action
     */
    public function doLinkFacebook(){
        
        if( $this->users->linkFacebook(Input::all(), Session::get('uid'), Session::get('fbid'), Session::get('fblink')) ){
            Session::flash('success', trans('acl.facebook_linked'));
            return Redirect::intended('/');
        }
        else{
            return Redirect::action('UsersController@linkFacebook')->with('error', trans('acl.password_not_valid'));
        }
    }

    /**
     * Attempt to confirm account with code
     *
     * @param  string $code
     *
     * @return  Illuminate\Http\Response
     */
    public function confirm($code)
    {
//        if (Confide::confirm($code)) {
        try{
            Session::flush();
        }
        catch(Exception $e){}
        if (  $this->users->confirm($code) ) {    
            $notice_msg = Lang::get('confide::confide.alerts.confirmation');
//            return View::make('confide.to_verification');
            return Redirect::action('UsersController@verificationConfirmation');
//            return Redirect::action('UsersController@login')
//                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_confirmation');
            return Redirect::action('UsersController@login')
                ->with('error', $error_msg);
        }
    }

    /**
     * Displays the forgot password form
     *
     * @return  Illuminate\Http\Response
     */
    public function forgotPassword()
    {
        return View::make(Config::get('confide::forgot_password_form'));
    }

    /**
     * Attempt to send change password link to the given email
     *
     * @return  Illuminate\Http\Response
     */
    public function doForgotPassword()
    {
        $old = Config::get('queue.default');
        Config::set('queue.default', 'sync');
        
        if ( Confide::forgotPassword( Input::get('email') ) ) {
            Config::set('queue.default', $old);
            $notice_msg = Lang::get('confide::confide.alerts.password_forgot');
            return Redirect::action('UsersController@login')
                ->with('notice', $notice_msg);
        } else {
            Config::set('queue.default', $old);
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_forgot');
            return Redirect::action('UsersController@forgotPassword')
                ->withInput()
                ->with('error', $error_msg);
        }
    }

    /**
     * Shows the change password form with the given token
     *
     * @param  string $token
     *
     * @return  Illuminate\Http\Response
     */
    public function resetPassword($token)
    {
        return View::make(Config::get('confide::reset_password_form'))
                ->with('token', $token);
    }

    /**
     * Attempt change password of the user
     *
     * @return  Illuminate\Http\Response
     */
    public function doResetPassword()
    {
        
        $input = array(
            'token'                 =>Input::get('token'),
            'password'              =>Input::get('password'),
            'password_confirmation' =>Input::get('password_confirmation'),
        );

        // By passing an array with the token, password and confirmation
        if ($this->users->resetPassword($input)) {
            $notice_msg = Lang::get('confide::confide.alerts.password_reset');
            if( $this->users->affiliateReset == true ){
                return Redirect::action('AffiliateController@login')
                ->with('notice', $notice_msg);
            }
            return Redirect::action('UsersController@login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_reset');
            return Redirect::action('UsersController@resetPassword', array('token'=>$input['token']))
                ->withInput()
                ->with('error', $error_msg);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @return  Illuminate\Http\Response
     */
    public function logout()
    {
        Confide::logout();

        return Redirect::to('/');
    }
    
    public function emailCheck(){
        return User::where('email', Input::get('email'))->count();
    }
    
            
    public function registrationConfirmation(){
        if( Auth::guest() ){
            $dot = getenv('AWS_MACHINE_IDENTIFIER') == 'Wazaar.' ? 1 : 0;
            return Redirect::to("login?dot=$dot");
        }
        return View::make('confide.signup_success');
    }
    
    public function registrationConfirmationResend(){
        if(Auth::user()->confirmed==1) return Redirect::action('SiteController@index');
        return View::make('confide.signup_success_resend');
    }
    
    public function doRegistrationConfirmationResend(){
        if(Auth::user()->confirmed==1) return Redirect::action('SiteController@index');
        $u = User::find(Auth::user()->id);
        $user = [
            'email' => $u->email,
            'confirmation_code' => $u->confirmation_code
        ];
        $subject = 'アカウント確認のご連絡';
        Mail::send(
                    'confide.emails.confirm',
                    compact('user' , 'lastName' ),
                    function ($message) use ($user, $subject) {
                        $message->getHeaders()->addTextHeader('X-MC-Important', 'True');
                        $message
                            ->to($user['email'], $user['email'])
                            ->subject( $subject );
                    }
                );
        Session::flash('success', trans('general.confirmation-link-emailed') );
        return View::make('confide.signup_success_resend');
    }

    public function verificationConfirmation(){
        if( Auth::guest() ){
            $dot = getenv('AWS_MACHINE_IDENTIFIER') == 'Wazaar.' ? 1 : 0;
            return Redirect::to("login?dot=$dot");
        }
        if( !Auth::user()->hasRole('Affiliate') && !Auth::user()->hasRole('Instructor')){
            $intention =  Auth::user()->getCustom('intended-redirect') ;
            if( $intention != null && trim($intention) !=''){
                Auth::user()->setCustom('intended-redirect',null);
                Auth::user()->updateUniques();
                return Redirect::to($intention);
            }
        }
        if( Auth::user()->hasRole('Affiliate') ) return Redirect::action('AffiliateController@acceptTerms');
        return View::make('confide.mail_verified');
    }
    
    public function links(){
        return Redirect::action('SiteController@index');
        if(Auth::guest() || Auth::user()->is_second_tier_instructor=='no'){
            return Redirect::action('SiteController@index');
        }
        
        if ( !Cache::has( 'sti-for-'.Auth::user()->id ) ){
        
            $this->delivered = new DeliveredHelper();
            $total = $this->delivered->getUsers();
            if($total == null) $ref = 0;
            else{
                $users = $total['data'];

                $total = 0;
                $stpi = User::where('is_second_tier_instructor','yes')->get();
                foreach($stpi as $s){
                    if($s->id != Auth::user()->id) continue;
                    $emails = [];
                    $count = 0;
                    foreach($users as $user){
                        foreach($user['tags']  as $tag){
                            if( $tag['tagName'] == 'second-tier-publisher-id' && ($tag['tagIntegerValue']==$s->id ||  $tag['tagStringValue']==$s->id ) ){
                               $count ++;
                            }
                        }
                    }
                }
                $ref = $count;
                Cache::add( 'sti-for-'.Auth::user()->id , $ref, 30);
            }
        }
        else $ref = Cache::get( 'sti-for-'.Auth::user()->id );
        
        return View::make('links')->with( compact('ref') );
    }
    
    
    public function confirmPassword(){
        if( Auth::user()->facebook_login_id > 0 ){
            Session::set('verifiedLogin', 1);
            $url = Session::get('url.intended');
            Session::forget('url.intended');
            return Redirect::to($url);
        }
        return View::make('confide.confirm_password');
    }
    
    public function doConfirmPassword(){
        $email = Input::get('email');
        if( Auth::user()->hasRole('Affiliate') ) $email = '#waa#-'.$email;
        
        if( Auth::attempt(['email' => $email, 'password' => Input::get('password') ] ) ){
            Session::set('verifiedLogin', 1);
            $url = Session::get('url.intended');
            Session::forget('url.intended');
            return Redirect::to($url);
        }
        Session::flash('error', trans('general.incorrect-password' ) );
        return View::make('confide.confirm_password');
    }

    public function adminManageUsers()
    {
        $data = Request::all();

        $sort_by = (isset($data['sort_by']))?$data['sort_by']:'users.created_at';
        $sort = (isset($data['sort']))?$data['sort']:'desc';
        $name = (isset($data['name']))?$data['name']:'';
        $email = (isset($data['email']))?$data['email']:'';
        $join_date_low = (isset($data['join_date_low']))?$data['join_date_low']:'';
        $join_date_high = (isset($data['join_date_high']))?$data['join_date_high']:'';
        $total_purchased_low = (isset($data['total_purchased_low']))?$data['total_purchased_low']:'';
        $total_purchased_high = (isset($data['total_purchased_high']))?$data['total_purchased_high']:'';
        $email_verified = (isset($data['email_verified']))?$data['email_verified']:'';
        $role = (isset($data['role']))?$data['role']:'2';
        $user_filter = (isset($data['user_filter']))?$data['user_filter']:'';
        $page = (isset($data['page']))?$data['page']:'';
        $start = (isset($data['start']))?$data['start']:0;
        $limit = (isset($data['limit']))?$data['limit']:15;
        if(Request::ajax()){
                $query = User::select(DB::raw('users.*'), DB::raw("CONCAT(users.last_name, ', ', users.first_name) as name"), DB::raw('roles.name as role_name'))
                                ->leftJoin('assigned_roles', 'assigned_roles.user_id', '=', 'users.id')
                                ->leftJoin('roles', 'roles.id', '=', 'assigned_roles.role_id')
                                ->where('roles.id', '!=', '1')
                                ->where(function ($query) use ($name, $email, $join_date_low, $join_date_high, $email_verified){

                                    if($name){
                                        $query->where(DB::raw("CONCAT(users.last_name, ', ', users.first_name)"), 'like', "%$name%");
                                    }

                                    if($email){
                                        $query->where('users.email', 'like', "%$email%");
                                    }

                                    if($join_date_low && $join_date_high){
                                        $query->orWhere(function ($query2) use ($join_date_low, $join_date_high) {
                                            $join_date_low = \Carbon\Carbon::parse($join_date_low);
                                            $join_date_low = $join_date_low->startOfDay();
                                            $join_date_high = \Carbon\Carbon::parse($join_date_high);
                                            $join_date_high = $join_date_high->endOfDay();
                                            $query2->whereBetween('users.created_at', array($sale_amount_low, $sale_amount_high));
                                        });
                                    } else if($join_date_low && empty($join_date_high)){
                                        $join_date_low = \Carbon\Carbon::parse($join_date_low);
                                        $join_date_low = $join_date_low->startOfDay();
                                        $query->where('users.created_at', '>=', $join_date_low);
                                    } else if($join_date_high && empty($join_date_low)){
                                        $join_date_high = \Carbon\Carbon::parse($join_date_high);
                                        $join_date_high = $join_date_high->startOfDay();
                                        $query->where('users.created_at', '<=', $join_date_high);
                                    }
                                });

                $users = $query->orderBy($sort_by, $sort)->paginate($limit);
                // dd(DB::getQueryLog());
                $start = $start + $limit;

                return View::make('administration.users.listing', compact('start', 'limit', 'page', 'users', 'name', 'email', 'join_date_low', 'join_date_high', 'total_purchased_low', 'total_purchased_high', 'email_verified', 'user_filter', 'sort', 'sort_by'));
        }

        return View::make('administration.users.index', compact('name', 'email', 'join_date_low', 'join_date_high', 'total_purchased_low', 'total_purchased_high', 'email_verified', 'user_filter', 'sort', 'sort_by'));
    }
}
