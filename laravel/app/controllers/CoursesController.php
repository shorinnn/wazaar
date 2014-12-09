<?php

class CoursesController extends \BaseController {

	public function index()
	{
            Return View::make('courses.index');
	}
        
        public function category($category=''){
            Return View::make('courses.category')->with(compact('category'));
        }
        
        public function show($slug, $affiliate = ''){
            Return View::make('courses.show')->with(compact('slug'));
        }



}
