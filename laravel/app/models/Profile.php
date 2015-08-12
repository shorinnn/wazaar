<?php

class Profile extends CocoriumArdent
{
/**
 * To implement polymorphism I've introduced a owner relationship
 * Added validation to make sure ownerID&ownerType combos are unique (ie, no duplicate profiles for the same student)
 */
    protected $table = 'user_profiles';
    protected $guarded = ['id'];
    
     public static $rules = [
         'owner_id' => 'numeric|unique_with:user_profiles,owner_type'
     ];
     
    public static $relationsData = array(
        'owner' => array(self::MORPH_TO),
     );

    public function getFullNameAttribute()
    {
        return $this->attributes['last_name'] . ' ' . $this->attributes['first_name'];
    }
    
    public function getEmailAttribute(){
        $email = $this['attributes']['email'];
        if( $this->owner_type == 'Affiliate' ) return str_replace ('#waa#-', '', $email);
        return $email;
    }
}