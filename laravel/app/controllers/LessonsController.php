<?php

class LessonsController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'instructor' );
            $this->beforeFilter('csrf', ['only' => [ 'store', 'update', 'destroy']]);
        }

	public function index()
	{
            $categories = CourseCategory::all();
            Return View::make('courses.index')->with(compact('categories'));
	}
        
        



}
