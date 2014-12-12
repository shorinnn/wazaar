<?php

class ProfileController extends Controller
{
    public function __construct(UserRepository $users){
        $this->users = $users;
        $this->beforeFilter('auth');
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
