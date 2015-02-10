<?php

class Profile extends ArdentUniqueWith
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
}