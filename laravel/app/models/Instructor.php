<?php

class Instructor extends User{

    use ProfileTrait;

    protected $table = 'users';

    protected $roleId = 3;

    public static $relationsData = array(
        'courses' => array(self::HAS_MANY, 'Course'),
        'coursePreviewImages' => array(self::HAS_MANY, 'CoursePreviewImage'),
        'courseBannerImages' => array(self::HAS_MANY, 'CourseBannerImage')
      );


}