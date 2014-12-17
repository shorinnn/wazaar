<?php
use LaravelBook\Ardent\Ardent;

class Course extends Ardent{

    
    public $fillable = ['name', 'slug', 'description', 'price', 'course_difficulty_id', 'course_category_id', 'course_subcategory_id', 'course_image_preview_id'];
    public static $rules = [
        'name' => 'required',
        'slug' => 'required|alpha_dash|unique:courses|not_in:index,show,create,store,categories,category,purchase,mycourses,destroy,edit,update',
        'description' => 'required',
        'price' => 'required|numeric',
        'course_difficulty_id' => 'required|numeric',
        'course_category_id' => 'required|numeric',
        'course_subcategory_id' => 'required|numeric',
        'course_preview_image_id' => 'numeric',
    ];
    
    public static $relationsData = array(
        'instructor' => array(self::BELONGS_TO, 'Instructor'),
        'previewImage' => array(self::BELONGS_TO, 'CoursePreviewImage', 'foreignKey' => 'course_preview_image_id'),
        'courseCategory' => array(self::BELONGS_TO, 'CourseCategory'),
        'courseSubcategory' => array(self::BELONGS_TO, 'CourseSubcategory'),
        'courseDifficulty' => array(self::BELONGS_TO, 'CourseDifficulty'),
        'sales' => array(self::HAS_MANY, 'CoursePurchase'),
    );
    
    public function upload_preview($path){
        $preview = new CoursePreviewImage();
        $preview->file_path = $path;
        $preview->instructor_id = $this->instructor->id;
        if($preview->save()){
            $this->previewImage()->associate($preview);
            if(!$this->updateUniques()) return false;
        }
        else{
           return false;
        }
        return true;
    }
    
    
    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }
    
    public function beforeDelete(){
        if($this->student_count > 0){
            $this->errors()->add(0, trans('courses/general.cannot_delete_has_students') );
            return false;
        }
    }
    
    public function beforeSave(){
        if($this->courseCategory->id != $this->courseSubcategory->courseCategory->id){
            $this->errors()->add(0, trans('courses/general.selected_subcategory_not_child_of_category') );
            return false;
        }
    }

}