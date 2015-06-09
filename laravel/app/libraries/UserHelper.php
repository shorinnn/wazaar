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
    public function saveProfile($userId, $profileData = [], $userObject = null)
    {

        if (is_null($userObject)){
            $userObjects = [Student::find($userId), Instructor::find($userId), LTCAffiliate::find($userId)];
        }
        else{
            $userObjects = [$userObject];
        }
        //$userObjects = [Student::find($userId), Instructor::find($userId), LTCAffiliate::find($userId)];

        foreach($userObjects as $user){

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

    public function getProfileByType($type, $id = null)
    {
        if (is_null($id)){
            $id = Auth::id();
        }
        switch($type){
            case 'student' :
                $profile = Student::find($id);
                break;
            case 'affiliate' :
                $profile = LTCAffiliate::find($id);
                break;
            case 'instructor' :
                $profile = Instructor::find($id);
                break;
            default:
                $profile = Student::find($id);
        }

        return $profile;
    }

    public function profileValidationRules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required'
        ];
    }

    public function activeProfileType()
    {
        $return = '';
        if (Auth::user()->hasRole('Student')){
            $return = 'student';
        }

        if (Auth::user()->hasRole('Affiliate')){
            $return = 'affiliate';
        }

        if (Auth::user()->hasRole('Instructor')){
            $return = 'instructor';
        }

        return $return;
    }

    public function createProfileFromType($type)
    {
        $profile = new Profile;

        $profile->email = 'email@email.com';
        $profile->owner_type = ucfirst($type);
        $profile->owner_id = Auth::id();

        if ($type == 'student'){
            return Student::find(Auth::id())->profile()->save($profile);
        }

        if ($type == 'instructor'){
            return Instructor::find(Auth::id())->profile()->save($profile);
        }

        if ($type == 'affiliate'){
            return LTCAffiliate::find(Auth::id())->profile()->save($profile);
        }
    }

    public function profilesByType($type)
    {
        $profiles = [
            'student' => [
                'student'
            ],
            'instructor' => [
                'instructor', 'student'
            ],
            'affiliate' => [
                'affiliate', 'student'
            ],
            '' => []
        ];

        return @$profiles[$type];
    }
}