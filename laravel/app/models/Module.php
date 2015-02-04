<?php
use LaravelBook\Ardent\Ardent;

class Module extends Ardent{

    public $fillable = ['name', 'order'];
    
    public static $relationsData = array(
        'course' => array(self::BELONGS_TO, 'Course'),
        'lessons' => array(self::HAS_MANY, 'Lesson'),
    );
    
     public static $rules = [
        'course_id' => 'required|exists:courses,id'
    ];
     
     public function beforeSave(){
         $this->slug = Str::slug( $this->name );
         // module slug must be unique within course
         $id = isset($this->id) ? $this->id : 0;
         if( Module::where('slug', $this->slug)->where('course_id', $this->course_id)->where('id','!=', $id)->count() > 0 ){
             $this->errors()->add(0, trans('crud/errors.module-slug-in-use') );
             return false;
         }
     }
     public function beforeDelete(){
         // delete lessons
         foreach($this->lessons as $lesson){
             $lesson->delete();
         }
     }
    
   

}