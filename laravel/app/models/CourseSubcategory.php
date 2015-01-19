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
    
        
    public function courses($privacy_status = 'public'){
        if($privacy_status=='public') return Course::where('course_subcategory_id', $this->id)->where('privacy_status', 'public');
        return Course::where('course_subcategory_id', $this->id); 
   }
   
   public function beforeSave(){
       $this->slug = Str::slug( $this->name );
   }

}