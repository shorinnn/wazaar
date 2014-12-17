<?php
use LaravelBook\Ardent\Ardent;

class CourseCategory extends Ardent{
    
    public static $relationsData = array(
        'courses' => array(self::HAS_MANY, 'Course', 'table' => 'courses', 'foreignKey' => 'course_category_id'),
        'courseSubcategories' => array(self::HAS_MANY, 'CourseSubcategory'),
    );
    
    public function courses($privacy_status = 'public'){
        if($privacy_status=='public') return Course::where('course_category_id', $this->id)->where('privacy_status', 'public');
        return Course::where('course_category_id', $this->id); 
   }

}