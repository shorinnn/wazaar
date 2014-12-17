<?php
use LaravelBook\Ardent\Ardent;

class CourseSubcategory extends Ardent{
    
    public static $relationsData = array(
        'courses' => array(self::HAS_MANY, 'Course', 'table' => 'courses', 'foreignKey' => 'course_subcategory_id'),
        'courseCategory' => array(self::BELONGS_TO, 'CourseCategory'),
    );
    
    public static function arrayWithParent(){
        $subcats = self::with('courseCategory')->get();
        $subcategories = array();
        foreach($subcats as $sub){
            $subcategories[$sub->id] = $sub->courseCategory->name." - $sub->name";
        }
        return $subcategories;
    }

}