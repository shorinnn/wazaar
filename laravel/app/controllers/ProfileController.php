<?php

class ProfileController extends Controller
{
    protected $uploadHelper;
    protected $userHelper;

    public function __construct(UserRepository $users, UserHelper $userHelper, UploadHelper $uploadHelper){
        $this->users = $users;
        $this->userHelper = $userHelper;
        $this->uploadHelper = $uploadHelper;
        $this->beforeFilter('auth');
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
    
    public function becomeInstructor(){
        if($this->users->become('Instructor', Auth::user())){
            return 'Became a instructor, congrats';
        }
        else{
            return 'Cannot become a instructor';
        }
    }
}
