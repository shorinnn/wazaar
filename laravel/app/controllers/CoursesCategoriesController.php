<?php

class CoursesCategoriesController extends \BaseController {
    
        public function __construct(){
        }

	public function subcategories()
	{
            $id = Input::get('id');
            $category = CourseCategory::find($id);
            return $category->courseSubcategories;
	}
        
}
