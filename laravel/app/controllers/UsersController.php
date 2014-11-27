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
    }

    /**
     * Displays the form for account creation
     *
     * @return  Illuminate\Http\Response
     */
    public function create()
    {
        return View::make(Config::get('confide::signup_form'));
    }

    /**
     * Stores new account
     *
     * @return  Illuminate\Http\Response
     */
    public function store()
    {
        
        $user = $this->users->signup(Input::all());

        if ($user->id) {
            $studentRole = Role::where('name','=','Student')->first();
            $user->attachRole( $studentRole );
            if (Config::get('confide::signup_email')) {
                Mail::queueOn(
                    Config::get('confide::email_queue'),
                    Config::get('confide::email_account_confirmation'),
                    compact('user'),
                    function ($message) use ($user) {
                        $message
                            ->to($user->email, $user->usersname)
                            ->subject(Lang::get('confide::confide.email.account_confirmation.subject'));
                    }
                );
            }
            Auth::login($user);
            return Redirect::to('/');
        } else {
            $error = $user->errors()->all(':message');

            return Redirect::action('UsersController@create')
                ->withInput(Input::except('password'))
                ->with('error', $error);
        }
    }

    /**
     * Displays the login form
     *
     * @return  Illuminate\Http\Response
     */
    public function login()
    {        
        if (Confide::user()) {
            return Redirect::to('/');
        } else {
            return View::make(Config::get('confide::login_form'));
        }
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
            return Redirect::intended('/');
        } else {
            if ($this->users->isThrottled($input)) {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
            } elseif ($this->users->existsButNotConfirmed($input)) {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            } else {
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
            }

            return Redirect::action('UsersController@login')
                ->withInput(Input::except('password'))
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
                    
                    $user = $this->users->signupWithGoogle($result);

                    if(!$user->id){ 
                        // cannot create user
                        $error = $user->errors()->all(':message');
                        return Redirect::action('UsersController@create')
                            ->withInput(Input::except('password'))
                            ->with('error', $error);
                    }
                    else{
                        $studentRole = Role::where('name','=','Student')->first();
                        $user->attachRole( $studentRole );
                        $this->users->save_social_picture($user, "G$result[id]", "$result[picture]?sz=150");
                        //user created
                        Auth::login($user);
                        return Redirect::to('/');
                    }
                }
            }
            else{
                // login
                Auth::login($user);
                return Redirect::to('/');
            }

        }
        // if not ask for permission first
        else {
            // get googleService authorization
            $url = $googleService->getAuthorizationUri();

            // return to google login url
            return Redirect::to( (string)$url );
        }
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
            return Redirect::to('/');
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
            $result = json_decode( $fb->request( '/me' ), true );
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
                    $user = $this->users->signupWithFacebook($result);
                    if(!$user->id){ 
                        // cannot create user
                        $error = $user->errors()->all(':message');
                        return Redirect::action('UsersController@create')
                            ->withInput(Input::except('password'))
                            ->with('error', $error);
                    }
                    else{
                        $studentRole = Role::where('name','=','Student')->first();
                        $user->attachRole( $studentRole );
                        $this->users->save_social_picture($user, "FB$result[id]", "https://graph.facebook.com/$result[id]/picture?type=large");
                        //user created
                        Auth::login($user);
                        return Redirect::to('/');
                    }
                }
                
            }
            else{
                // login
                Auth::login($user);
                return Redirect::to('/');
            }
        }
        // if not ask for permission first
        else {
            // get fb authorization
            $url = $fb->getAuthorizationUri();
            // return to facebook login url
            return Redirect::to( (string)$url );
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
            return Redirect::to('/');
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
        if (Confide::confirm($code)) {
            $notice_msg = Lang::get('confide::confide.alerts.confirmation');
            return Redirect::action('UsersController@login')
                ->with('notice', $notice_msg);
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
        if (Confide::forgotPassword(Input::get('email'))) {
            $notice_msg = Lang::get('confide::confide.alerts.password_forgot');
            return Redirect::action('UsersController@login')
                ->with('notice', $notice_msg);
        } else {
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
}
