<?php

class ProfileController extends Controller
{
    /** 
     * Sorin: see polymorphicTest method for an example
     */
    protected $uploadHelper;
    protected $userHelper;

    public function __construct(UserRepository $users, UserHelper $userHelper, UploadHelper $uploadHelper){
        $this->users = $users;
        $this->userHelper = $userHelper;
        $this->uploadHelper = $uploadHelper;
        $this->beforeFilter( 'auth' );
    }

    public function index($type = '')
    {
        $isProfileNew = $this->userHelper->isProfileNew();

        if ($isProfileNew OR Input::get('step') == 2) {
            $step = Input::has('step') ? Input::get('step') : 1;
            return View::make('profile.new', compact('isProfileNew', 'step'));
        }
        else{
            if (empty($type)) {
                $type = $this->userHelper->activeProfileType();
            }
            $profile = $this->userHelper->getProfileByType($type)->profile;
            if (empty($profile)){
                $profile =  $this->userHelper->createProfileFromType($type);
            }

            $trueType = $this->userHelper->activeProfileType();

            $availableProfiles = $this->userHelper->profilesByType($trueType);
            return View::make('profile.index', compact('profile', 'type','availableProfiles'));
        }
    }

    public function uploadProfilePicture()
    {
        $validationRule = ['profilePicture' => 'image|required'];
        $validator = Validator::make(Input::only('profilePicture'), $validationRule);

        if ($validator->fails()){
            return Redirect::back()->with('errors', $validator->messages()->all());
        }

        $imagePath = $this->uploadHelper->uploadImage('profilePicture');

        if ($imagePath){
            $awsResult = $this->uploadHelper->moveToAWS($imagePath, Config::get('wazaar.S3_PROFILES_BUCKET'));
            $pictureUrl = $awsResult->get('ObjectURL');
            $profileData = ['photo' => $pictureUrl];
            $this->userHelper->saveProfile(Auth::id(), $profileData);

            unset($imagePath);

            return Redirect::to('profile/?step=2');
        }
        else{
            return Redirect::back()->with('errors',['Something wrong happened']); //Should probably throw an exception
        }
    }

    public function storeNewProfile()
    {
        $validator = Validator::make(Input::only('first_name', 'last_name'),$this->userHelper->profileValidationRules());

        if ($validator->fails()){
            return Redirect::back()->withInput(Input::except('_token'))->with('errors', $validator->errors()->all());
        }

        $profileData = Input::only('first_name', 'last_name', 'address_1', 'address_2');
        $this->userHelper->saveProfile(Auth::id(), $profileData);
        return Redirect::to('profile');
    }

    public function update($id)
    {
        try{
            if ($id){
                $validator = Validator::make(Input::only('first_name', 'last_name'),$this->userHelper->profileValidationRules());

                if ($validator->fails()){
                    return Redirect::back()->withInput(Input::all())->with('errors', $validator->messages()->all());
                }
                $user = $this->userHelper->getProfileByType(Input::get('type'));
                $data = Input::except('_token','type', 'profilePicture');

                if (Input::hasFile('profilePicture')){
                    $imagePath = $this->uploadHelper->uploadImage('profilePicture');

                    if ($imagePath) {
                        $awsResult  = $this->uploadHelper->moveToAWS($imagePath, Config::get('wazaar.S3_PROFILES_BUCKET'));
                        $pictureUrl = $awsResult->get('ObjectURL');
                        $data['photo'] = $pictureUrl;
                    }
                }

                $this->userHelper->saveProfile(Auth::id(), $data , $user);
//            Session::put('success',trans('profile.updateSuccessful'));
                return Redirect::to('profile/' . Input::get('type'))->withSuccess( trans('profile.updateSuccessful') );
            }
        }
        catch(Exception $ex){
            return Redirect::back()->withInput(Input::all())->with('errors', [$ex->getMessage()]);
        }

    }
    
    public function finance(){
        $user = Student::find( Auth::user()->id );
        if(Input::get('show')=='instructor' && Auth::user()->hasRole('Instructor')){
            $user = Instructor::find( Auth::user()->id );
        }
        if(Input::get('show')=='affiliate' && Auth::user()->hasRole('Affiliate')){
            $user = LTCAffiliate::find( Auth::user()->id );
        }
        if(Input::get('show')=='agency' && Auth::user()->hasRole('InstructorAgency')){
            $user = InstructorAgency::find( Auth::user()->id );
        }
        $user->paginated_transactions = $user->transactions->orderBy('id','desc')->paginate( 2 );

        return View::make('profile.finances')->with( compact('user') );
    }


    
    public function settings(){
        return View::make('profile.settings');
    }
    
    public function updateSettings(){
        $repo = new UserRepository;
        if( $repo->updatePassword( Auth::user(), Input::all() ) ){
            if( Request::ajax() ) return json_encode ( [ 'status'=>'success'] );
            return Redirect::back()->withSuccess( trans('general.password-updated') );
        }
        else{
            if( Request::ajax() ) return json_encode ( [ 'status'=>'error', 'errors' => format_errors( $repo->errors ) ] );
            return Redirect::back()->withError( format_errors( $repo->errors ) );
        }
    }
}
