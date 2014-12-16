<?php

class SiteController extends \BaseController {

	public function index()
	{
//            $course = Course::find(1);
//            echo $course->previewImage->url;
            $categories = CourseCategory::all();
            Return View::make('site.homepage_authenticated')->with(compact('categories'));
	}



}
