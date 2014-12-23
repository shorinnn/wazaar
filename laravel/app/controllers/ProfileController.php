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
            $this->uploadHelper->prepareUploadDirectories();
            $this->uploadHelper->uploadProfilePicture(Auth::id(), 'profilePicture');
            return Redirect::to('profile/?step=2');
        }
        else{
            return Redirect::back()->with('errors', $validator->messages()->all());
        }
    }

    public function storeNewProfile()
    {

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
