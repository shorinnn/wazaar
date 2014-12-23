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
        // sorin:  temporarily allow the polymorhicTest action for guests
        $this->beforeFilter('auth', ['except' => 'polymorphicTest']);
    }

    public function index()
    {
        $isProfileNew = $this->userHelper->isProfileNew();
        $step = Input::has('step') ? Input::get('step') : 1;
        return View::make('profile.index', compact('isProfileNew', 'step'));
    }

    public function uploadProfilePicture()
    {
        $validationRule = ['profilePicture' => 'image|required'];
        $validator = Validator::make(Input::only('profilePicture'), $validationRule);

        if ($validator->passes()){
            $imagePath = $this->uploadHelper->uploadImage('profilePicture');

            if ($imagePath){
                $pictureUrl = $this->uploadHelper->moveToAWS($imagePath, 'avatars');
                $user = Auth::user();

                $user->photo = $pictureUrl;
                $user->save();

                unset($file);
                return Redirect::to('profile/?step=2');
            }
            else{
                return Redirect::back()->with('errors',['Something wrong happened']); //Should probably throw an exception
            }
        }
        else{
            return Redirect::back()->with('errors', $validator->messages()->all());
        }
    }

    public function storeNewProfile()
    {
        $user = User::find(Auth::id());

        $user->first_name = Input::get('first_name');
        $user->last_name = Input::get('last_name');
        $user->address_1 = Input::get('address_1');
        $user->addrsss_2 = Input::get('address_2');

        if ($user->save()){

        }
        else{
            dd($user->errors()->all());
            return Redirect::back()->with('errors', $user->errors()->all());
        }
    }
    
    /**
     * @owner: Sorin
     * Testing some polymorphic relationships
     * http://wazaar.dev/profile/polymorphic-test
     */
    public function polymorphicTest(){
        // get a student
        $student = Student::find(4);
        // create a profile for him
        if($student->profile()->count()==0){
            $profile = new Profile;
            $profile->first_name = "Student";
            $profile->last_name = "McProfile";
            $student->profile()->save( $profile );
        }
        // echo some profile data
        echo 'Profile ID <b>'.$student->profile->id  . '</b> Profile First name <b>'. $student->profile->first_name.'</b>';
        
        // get the same user who's also an instructor
        $instructor = Instructor::find(4);
        if($instructor->profile()->count()==0){
            $profile = new Profile;
            $profile->first_name = "Instructor";
            $profile->last_name = "ProfileInstr";
            $instructor->profile()->save( $profile );
        }
        // echo some profile data
        echo '<br />Profile ID <b>'.$instructor->profile->id  . '</b> Profile First name <b>'. $instructor->profile->first_name.'</b>';
        
        // get a profile and fetch user info from it (reverse relationship)
        $profile = Profile::first();
        // echo the username
        echo '<br />Username: <b>'.$profile->owner->username.'</b>';
    }
}
