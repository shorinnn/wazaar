<?php

class ProfileController extends Controller
{
    public function __construct(UserRepository $users){
        $this->users = $users;
        $this->beforeFilter('auth');
    }
    
    public function becomeTeacher(){
        if($this->users->become('Teacher', Auth::user())){
            return 'Became a teacher, congrats';
        }
        else{
            return 'Cannot become a teacher';
        }
    }
}
