<?php

class Instructor extends User{
/**
 * To implement polymorphism I've commented out the trait and introduced a profile relationship
 * Also commented out the roleID property
 */

//    use ProfileTrait;

    protected $table = 'users';

//    protected $roleId = 3;

    public static $relationsData = array(
        'courses' => array(self::HAS_MANY, 'Course'),
        'coursePreviewImages' => array(self::HAS_MANY, 'CoursePreviewImage'),
        'courseBannerImages' => array(self::HAS_MANY, 'CourseBannerImage'),
        'profile' => array(self::MORPH_ONE, 'Profile', 'name'=>'owner')
      );


}