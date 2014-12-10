<?php

class CoursesController extends \BaseController {

	public function index()
	{
            Return View::make('courses.index');
	}
        
        public function category($category=''){
            Return View::make('courses.category')->with(compact('category'));
        }
        
        public function show($slug){
            if(Input::has('aid')){
                Cookie::queue('aid.product_id', Input::get('aid'), 60*60*30);
            }
            Return View::make('courses.show')->with(compact('slug'));
        }



}
