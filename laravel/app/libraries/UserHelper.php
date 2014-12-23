<?php

class UserHelper
{
    public function isProfileNew($userId = 0)
    {
        if ($userId == 0){
           $user = Auth::user();
        }
        else{
            $user = User::find($userId);
        }

        if ($user){
            if ( (!empty($user->first_name) AND !empty($user->last_name)) ){
                return false;
            }
        }

        return true;
    }
}