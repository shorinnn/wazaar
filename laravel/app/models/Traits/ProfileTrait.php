<?php


trait ProfileTrait {

    public function profile()
    {
        $obj = (new static);
        return $this->hasOne('Profile', 'user_id')->where('role_id', $obj->roleId)->first();
    }
}