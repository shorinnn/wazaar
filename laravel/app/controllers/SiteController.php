<?php

class SiteController extends \BaseController {

	public function index()
	{            
            $categories = CourseCategory::all();
            Return View::make('site.homepage_authenticated')->with(compact('categories'));
	}



}
