<?php

class CoursesCategoriesController extends \BaseController {
    
        public function __construct(){
        }

	public function subcategories()
	{
            if(Input::get('id') < 1) return array();
            $id = Input::get('id');
            $category = CourseCategory::find($id);
            return $category->courseSubcategories;
	}
        
}
