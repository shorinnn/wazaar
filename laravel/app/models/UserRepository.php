<?php
/**
 * Class UserRepository
 *
 * This service abstracts some interactions that occurs between Confide and
 * the Database.
 */
class UserRepository
{   
    public function find($id){
        return User::find($id);
    }
    
    public function where($prop, $val){
        return User::where($prop, $val);
    }
    /**
     * Signup a new account with the given parameters
     *
     * @param array $input Array containing 'username', 'email' and 'password'.
     * @param string|null $ltc_cookie The Life Time Commission Affiliate ID or null if none
     * @param array $roles Additional roles to attach besides Student
     * @return  User User object that may or may not be saved successfully. Check the id to make sure.
     */
    public function signup($input, $ltc_cookie=null, $roles=false, $secondTierInstructorCookie = null, $instructorAgencyCookie = null, $registersAsST = null)
    {
        $user = new Student;

//      $user->username = array_get($input, 'username');
        $user->email    = array_get($input, 'email');
        if( isset( $roles['affiliate'] ) && $roles['affiliate'] == 1 ){
            $user->email = '#waa#-'.$user->email;
        }
        $user->username = 'U'.uniqid();
//        $user->first_name = Input::get('first_name');
        $user->first_name = array_get($input, 'first_name');
//        $user->last_name = Input::get('last_name');
        $user->last_name = array_get($input, 'last_name');
        $user->password = array_get($input, 'password');
        $user->instructor_agency_id = $instructorAgencyCookie;
        $user->confirmed = 0;
//        if( User::where('id', $secondTierInstructorCookie )->where( 'is_second_tier_instructor','yes' )->where( 'sti_approved','yes' )->count() == 1 ){
//            $user->second_tier_instructor_id = $secondTierInstructorCookie;
//        }
        $user->second_tier_instructor_id = $secondTierInstructorCookie;
        if( $registersAsST !=null ){
            $user->is_second_tier_instructor = 'yes';
        }

        // The password confirmation will be removed from model
        // before saving. This field will be used in Ardent'ssql
        // auto validation.
        $user->password_confirmation = $user->password;// array_get($input, 'password_confirmation');

        // Generate a random confirmation code
        $user->confirmation_code     = md5(uniqid(mt_rand(), true));
        
        $url = action('SiteController@index');
        if($registersAsST!=null) $url = action('UsersController@registrationConfirmation' );
        $url = action('UsersController@registrationConfirmation' );
        

        $deliveredTags = [];
        // Save if valid. Password field will be hashed before save
        if($this->save($user)){
            // no student role for Affiliate
            if( isset( $roles['affiliate'] ) && $roles['affiliate'] == 1 ){
                $user = $this->attachRoles($user, 2);
                $profileType = 'Affiliate';
                $deliveredTags[] = 'affiliate';
            }
            else{
                $profileType = 'Student';
                $deliveredTags[] = 'student';
                $user = $this->attachRoles($user);
            }
            if( $registersAsST!=null || ( isset( $roles['instructor'] ) && $roles['instructor'] == 1 ) ){
                $user = $this->attachRoles($user, 1);
                $profileType = 'Instructor';
                $deliveredTags[] = 'instructor';
            }
            
            $this->save_ltc($user, $ltc_cookie);
            
            if($registersAsST!=null){// create profile
                $profileType = 'Instructor';
                $deliveredTags[] = 'instructor';
                $deliveredTags[] = 'stinstructor';
            }
//                $name = explode( ' ', Input::get('name') );
//                $first_name = ( !isset($name[1]) || empty($name[1]) ) ? 'First Name' : $name[1];
//                $last_name = ( !isset($name[0]) || empty($name[0]) ) ? 'Last Name' : $name[0];
//  ---              $first_name = Input::get('first_name');
//     ----           $last_name = Input::get('last_name');
                $first_name = array_get($input, 'first_name');
                $last_name = array_get($input, 'last_name');
                $profile = new Profile;
                $profile->owner_id = $user->id; 
                $profile->owner_type = $profileType;
                $profile->first_name = $first_name;// 'First  Name';//!isset($name[1]) && empty($name[1]) ? 'First Name' : $name[1];
                $profile->last_name = $last_name;//  'Last Name';//!isset($name[0]) && empty($name[0]) ? 'Last Name' : $name[0];
                $profile->email = $user->email;
                $profile->save();
//            }
            

            // add user to DELIVERED
            $this->_addToDelivered($user, $deliveredTags);
            $user = User::find($user->id); 
            $user->url = $url;
            if($user->roles()->count() == 1){
                Session::flash('verification-notice', 1);
            }
            return $user;
        }
        else return $user;
        
    }
    
    private function _addToDelivered($user, $deliveredTags){
        if( App::environment() != 'production' ) return;
        $this->delivered = new DeliveredHelper();
        // add the user to DELIVERED
        $response = $this->delivered->addUser( $user->first_name, $user->last_name, $user->email );
        if( is_array($response) && $response['success'] == true ){
            $userData = $response['data'];
            if( is_array($userData) ) $userData = json_decode(json_encode($userData), FALSE);
            $user->delivered_user_id = $userData->id;
            $user->updateUniques();
            // associate tags with the user
            foreach($deliveredTags as $tag){
                $this->delivered->addTag('user-type-'.$tag, 'integer', 1, $userData->id);
            }
            // add confirmed tag
            $res = $this->delivered->addTag('email-confirmed', 'integer', $user->confirmed, $userData->id);
        }
    }
    
    /**
     * Save the life time commission affiliate
     * @param User $user the user registered
     * @param string|null $ltc The affiliate id or NULL
     */
    public function save_ltc($user, $ltc=null){
        $user = Student::find( $user->id );
        if( $ltc != null ){
            $ltc_affiliate = LTCAffiliate::where('affiliate_id', $ltc)->first();
            if($ltc_affiliate !=null ){
                if( $user->hasRole('Affiliate') ) $user->second_tier_affiliate_id = $ltc_affiliate->id;
                else $user->ltc_affiliate_id = $ltc_affiliate->id;
                $user->save();
            }            
        }
        else{
            $user->ltc_affiliate_id = null;
            $user->save();
        }
    }
    
    /**
     * Attaches roles after user registration
     * 
     * @param User $user The user object
     * @param int $instructor Flag, 0 for no additional role, 1 for instructor, 2 for affiliate
     */
    public function attachRoles($user, $instructor=0){
        // assign the default student role
        if( !$user->hasRole('Student') && $instructor === 0){
            $studentRole = Role::where('name','=','Student')->first();
            $user->attachRole( $studentRole );

        }
        // user signs up for a instructor account
        if($instructor==1){
            $instructorRole = Role::where('name','=','Instructor')->first();
            $user->attachRole( $instructorRole );
        }
        if($instructor==2){
            $affiliateRole = Role::where('name','=','Affiliate')->first();
            $user->attachRole( $affiliateRole );
            $user->affiliate_id = $user->id;
            $user->save();
        }
        return $user;
    }
    
    /**
     * Signup a new account with FB Credentials
     * @param array $input User fields
     * @param string|null $ltc_cookie The Life Time Commission Affiliate ID or null if none
     * @param array $roles Additional roles to attach besides Student
     * @return  User User object that may or may not be saved successfully. Check the id to make sure.
     */
    public function signupWithFacebook($input, $ltc_cookie=null, $roles = false, $secondTierInstructorCookie = null, $instructorAgencyCookie = null, $registersAsST = null)
    {
       
        $user = new Student;

        $user->username = "FB$input[id]";
        $user->email    = $input['email'];
        $user->password = Str::random(12);//md5(uniqid(mt_rand(), true));
        $user->password_confirmation = $user->password;
        $user->confirmed = 1;
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->facebook_login_id = $input['id'];
        $user->facebook_profile_id = $input['link'];
        $user->instructor_agency_id = $instructorAgencyCookie;
        if( User::where('id', $secondTierInstructorCookie )->where( 'is_second_tier_instructor','yes' )->where( 'sti_approved','yes' )->count() == 1 ){
            $user->second_tier_instructor_id = $secondTierInstructorCookie;
        }
        if( $registersAsST !=null ){
            $user->is_second_tier_instructor = 'yes';
        }
        
        // Generate a random confirmation code
        $user->confirmation_code     = md5(uniqid(mt_rand(), true));
        
        $deliveredTags = [];
        $profileType = 'Student';
        $deliveredTags[] = 'student';

        // Save if valid. Password field will be hashed before save
        $this->save($user);
        $user = $this->attachRoles($user);
        if( $registersAsST!=null || ( isset( $roles['instructor'] ) && $roles['instructor'] == 1 ) ){
            $user = $this->attachRoles($user, 1);
            $profileType = 'Instructor';
            $deliveredTags[] = 'instructor';
            $deliveredTags[] = 'stinstructor';
        }
        if( isset( $roles['affiliate'] ) && $roles['affiliate'] == 1 ){
            $user = $this->attachRoles($user, 2);
             $profileType = 'Affiliate';
             $deliveredTags[] = 'affiliate';
        }
        $this->save_ltc($user, $ltc_cookie);
        
        if($registersAsST!=null){// create profile
            $profileType = 'Instructor';
            $deliveredTags[] = 'instructor';
        }
            $first_name = $input['first_name'];
            $last_name = $input['last_name'];
            $profile = new Profile;
            $profile->owner_id = $user->id; 
            $profile->owner_type = $profileType;
            $profile->first_name = $first_name;// 'First  Name';//!isset($name[1]) && empty($name[1]) ? 'First Name' : $name[1];
            $profile->last_name = $last_name;//  'Last Name';//!isset($name[0]) && empty($name[0]) ? 'Last Name' : $name[0];
            $profile->email = $user->email;
            $profile->save();

        $this->_addToDelivered($user, $deliveredTags);
        return $user;
    }
    
    /**
     * Link an existing Email account with a Facebook Profile
     * @param string $password The password for the existing account
     * @param int $user_id The existing user ID
     * @param int $facebook_id The Facebook profile ID
     * @param string $facebook_profile The Facebook profile public link
     */
    public function linkFacebook($input, $user_id, $facebook_id, $facebook_profile){
        $user = User::find($user_id);
        $input['email'] = $user->email;
        $login = $this->login($input);
        if( $login ){
            // link the account
            Auth::user()->confirmed = 1;
            Auth::user()->facebook_login_id = $facebook_id;
            Auth::user()->facebook_profile_id = $facebook_profile;
            Auth::user()->save();
            return true;
        }
        else{
            // see if password failed, but visitor used social confirmation code
            if($user->social_confirmation == $input['password']){
                Auth::login($user);
                $user->confirmed = 1;
                $user->facebook_login_id = $facebook_id;
                $user->facebook_profile_id = $facebook_profile;
                $user->save();
                return true;                
            }
            else{
                // verification failed
                return false;
            }
        }
    }
    
    /**
     * Signup a new account with Google Credentials
     * @param array $input User fields
     * @param string|null $ltc_cookie The Life Time Commission Affiliate ID or null if none
     * @param array $roles Additional roles to attach besides Student
     * @return  User User object that may or may not be saved successfully. Check the id to make sure.
     */
    public function signupWithGoogle($input, $ltc_cookie=null, $roles = false, $secondTierInstructorCookie = null, $instructorAgencyCookie = null, $registersAsST = null)
    {
        $user = new Student;

        $user->username = "G$input[id]";
        $user->email    = $input['email'];
        $user->password = md5(uniqid(mt_rand(), true));
        $user->password_confirmation = $user->password;
        $user->confirmed = 1;
        $user->first_name = $input['given_name'];
        $user->last_name = $input['family_name'];
        $user->google_plus_login_id = $input['id'];
        $user->google_plus_profile_id = $input['link'];
        $user->instructor_agency_id = $instructorAgencyCookie;
        if( User::where('id', $secondTierInstructorCookie )->where( 'is_second_tier_instructor','yes' )->where( 'sti_approved','yes' )->count() == 1 ){
            $user->second_tier_instructor_id = $secondTierInstructorCookie;
        }
        if( $registersAsST !=null ){
            $user->is_second_tier_instructor = 'yes';
        }
        
        // Generate a random confirmation code
        $user->confirmation_code     = md5(uniqid(mt_rand(), true));

        // Save if valid. Password field will be hashed before save
        $this->save($user);
        $user = $this->attachRoles($user);
        if( isset( $roles['instructor'] ) && $roles['instructor'] == 1 ) $user = $this->attachRoles($user, 1);
        if( isset( $roles['affiliate'] ) && $roles['affiliate'] == 1 ) $user = $this->attachRoles($user, 2);
        $this->save_ltc($user, $ltc_cookie);
        return $user;
    }
    
    /**
     * Link an existing Email account with a Google Profile
     * @param string $password The password for the existing account
     * @param int $user_id The existing user ID
     * @param int $google_id The Google profile ID
     * @param string $google_profile The Google profile public link
     */
    public function linkGooglePlus($input, $user_id, $google_id, $google_profile){
        $user = User::find($user_id);
        $input['email'] = $user->email;
        if($this->login($input)){
            // link the account
            Auth::user()->confirmed = 1;
            Auth::user()->google_plus_login_id = $google_id;
            Auth::user()->google_plus_profile_id = $google_profile;
            Auth::user()->save();
            return true;
        }
        else{
            // see if password failed, but visitor used social confirmation code
            if($user->social_confirmation == $input['password']){
                Auth::login($user);
                $user->confirmed = 1;
                $user->google_plus_login_id = $google_id;
                $user->google_plus_profile_id = $google_profile;
                $user->save();
                return true;                
            }
            else{
                // verification failed
                return false;
            }
        }
    }
    
    public function saveSocialPicture($user, $key, $picture){
        $file = file_get_contents($picture);
        $mime = mimetype($file);
        $extension = mime_to_extension($mime);
        $s3 = AWS::get('s3');
        $result = $s3->putObject(array(
            'ACL'    => 'public-read',
            'Bucket' => $_ENV['AWS_BUCKET'],
            'ContentType' => $mime,
            'Key'    => 'profile_pictures/'.$key.$extension,
            'Body'   => $file
        ));
        
        $user->photo =  $result->get('ObjectURL');
        $user->save();
        DB::table('user_profiles')->where('owner_id', $user->id)->update( ['photo' => $user->photo] );
    }

    /**
     * Attempts to login with the given credentials.
     *
     * @param  array $input Array containing the credentials (email/username and password)
     *
     * @return  boolean Success?
     */
    public function login($input)
    {
        if (! isset($input['password'])) {
            $input['password'] = null;
        }
        return Confide::logAttempt($input, Config::get('confide::signup_confirm'));
    }

    /**
     * Checks if the credentials has been throttled by too
     * much failed login attempts
     *
     * @param  array $credentials Array containing the credentials (email/username and password)
     *
     * @return  boolean Is throttled
     */
    public function isThrottled($input)
    {
        return Confide::isThrottled($input);
    }

    /**
     * Checks if the given credentials correponds to a user that exists but
     * is not confirmed
     *
     * @param  array $credentials Array containing the credentials (email/username and password)
     *
     * @return  boolean Exists and is not confirmed?
     */
    public function existsButNotConfirmed($input)
    {
        $user = Confide::getUserByEmailOrUsername($input);

        if ($user) {
            $correctPassword = Hash::check(
                isset($input['password']) ? $input['password'] : false,
                $user->password
            );

            return (! $user->confirmed && $correctPassword);
        }
    }

    /**
     * Resets a password of a user. The $input['token'] will tell which user.
     *
     * @param  array $input Array containing 'token', 'password' and 'password_confirmation' keys.
     *
     * @return  boolean Success
     */
    public function resetPassword($input)
    {
        $this->affiliateReset = false;
        $result = false;
        $user   = Confide::userByResetPasswordToken($input['token']);
        if ($user) {
            $user->password              = $input['password'];
            $user->password_confirmation = $input['password_confirmation'];
            $result = $this->save($user);
            if($user->isAffiliate()) $this->affiliateReset = true;
        }

        // If result is positive, destroy token
        if ($result) {
            Confide::destroyForgotPasswordToken($input['token']);
        }

        return $result;
    }

    /**
     * Simply saves the given instance
     *
     * @param  User $instance
     *
     * @return  boolean Success
     */
    public function save(User $instance)
    {
        return $instance->save();
    }
    
    /**
     * Attach a role to the user
     * @param string $role The role name
     * @param User $user The user object
     * @return boolean True on success, false on failure
     */
    public function become($role, User $user, $secondTierInstructorCookie = null, $secondTierAffiliate = null){
        // usable roles
        if(!in_array($role, ['Student', 'Instructor' ])) return false;
        
        try{
            $role = Role::where('name', $role)->first();
        }
        catch(Exception $e){ 
            throw $e;
        }
        if( $user->hasRole($role->name) ) return false;

        $user->attachRole($role);
        // default the affiliate ID to the user ID
        $user->affiliate_id = $user->id;
        // record the second tier instructor if any
        if( $secondTierInstructorCookie!=null && 
                User::where('id', $secondTierInstructorCookie )->where( 'is_second_tier_instructor','yes' )->where( 'sti_approved','yes' )->count() == 1 ){
            $user->second_tier_instructor_id = $secondTierInstructorCookie;
        }
        if( $secondTierAffiliate != null  ){
            $secondTierAffiliate = LTCAffiliate::where('affiliate_id', $secondTierAffiliate)->first();
            if($secondTierAffiliate!=null) $user->second_tier_affiliate_id = $secondTierAffiliate->id;
        }
        $user->save();
        return true;
    }
    
    public function updatePassword($user, $data){
        if( !isset($data['old_password'], $data['new_password'], $data['password_confirmation'] ) ){
            $this->errors = [ trans('general.please-fill-in-all-fields') ];
            return false;
        }
        if( !Hash::check( $data['old_password'], $user->password ) ){
            $this->errors = [ trans('general.old-password-not-valid') ];
            return false;
        }
        $user->password = $data['new_password'];
        $user->password_confirmation = $data['password_confirmation'];
        if( $user->updateUniques() ) return true;
        $this->errors = $user->errors()->all();
        return false;
    }
    
    public function confirm($code){
        $identity = ['confirmation_code' => $code];
        $Eloquent = new \Zizaco\Confide\EloquentRepository();
        $user = $Eloquent->getUserByIdentity($identity);
        if ($user) {
            $user->confirmed = 1;
            if( ! $user->updateUniques() ){
                dd( $user->errors()->all() );
            }
            Auth::login($user);
            // todo: confirm on delivered too!
            $delivered = new DeliveredHelper();
            $deliveredUser = $delivered->findUser( $user->email );
            $deliveredUser = $deliveredUser['data'];
            if( count($deliveredUser) > 0){
                $dUser = $deliveredUser[0];
                foreach( $dUser['tags'] as $tag ){
                    if( $tag['tagName'] == 'email-confirmed' ){
                        $res = $delivered->updateTag( $tag['id'], $dUser['id'], 'email-confirmed', 'integer', 1);
                        $added = true;
                    }
                }
                if( !$added ){
                    $res = $delivered->addTag('email-confirmed', 'integer', 1, $dUser['id']);
                }
            }
            return $user;
        } else {
            return false;
        }
    }
    
}
