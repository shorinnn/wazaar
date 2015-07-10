<?php
use LaravelBook\Ardent\Ardent;

class CategoryGroup extends CocoriumArdent {
	protected $fillable = ['name','order'];
        public static $rules = [];
        public static $relationsData = [];
        
    public function categories(){
        return $this->manyThroughMany('CourseCategory', 'CategoryGroupItem', 'category_group_id', 'id', 'course_category_id' );
    }
}