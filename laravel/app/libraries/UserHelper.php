<?php

class UserHelper
{
    public function isProfileNew($userId = 0)
    {
        if ($userId == 0){
           $userId = Auth::id();
        }

        $profiles = Profile::where('owner_id', $userId);
        return ($profiles->count() == 0);
    }

    public function saveProfile($userId, $profileData = [], $profileObject = null)
    {

        if (is_null($profileObject)){
            $profileObjects = [Student::find($userId), Instructor::find($userId), LTCAffiliate::find($userId)];
        }
        else{
            $profileObjects = [$profileObject];
        }


        foreach($profileObjects as $user){

            if ($user){

                $newProfile = true;

                if ($user->profile()->count() == 0){
                    $profile = new Profile;
                }
                else{
                    $profile = $user->profile;
                    $newProfile = false;
                }

                foreach($profileData as $key => $val){
                    $profile->{$key} = $val;
                }

                if ($newProfile) {
                    $user->profile()->save($profile);
                }
                else{

                    if (!$user->profile->updateUniques()){

                    }
                }
            }
        }


    }
}