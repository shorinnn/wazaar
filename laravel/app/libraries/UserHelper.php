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

    /**
     * @param $userId  - Most probably the Auth::id()
     * @param array $profileData - Key value of the profile data
     * @param null $profileObject - the User collection if you want to update a particular profile 1 by 1(e.g. Student), leave null if all profiles are to be updated
     */
    public function saveProfile($userId, $profileData = [], $profileObject = null)
    {

        if (is_null($profileObject)){
            $profileObjects = [Student::find($userId), Instructor::find($userId), LTCAffiliate::find($userId)];
        }
        else{
            $profileObjects = [$profileObject];
        }
        $profileObjects = [Student::find($userId), Instructor::find($userId), LTCAffiliate::find($userId)];

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
                    $user->profile->updateUniques();
                }
            }

        }


    }

    public function profileValidationRules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required'
        ];
    }
}