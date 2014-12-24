<?php

class SiteController extends \BaseController {

	public function index()
	{            
            $categories = CourseCategory::all();
            Return View::make('site.homepage_authenticated')->with(compact('categories'));
	}
        
	public function classroom()
	{            
            Return View::make('site.classroom');
	}
        
        public function admindash(){
             Return View::make('TEMPORARYVIEWS.admin_dashboard');
        }
        
        public function affiliatedash(){
             Return View::make('TEMPORARYVIEWS.affiliate_dashboard');
        }
        
        public function classroomdash(){
             Return View::make('TEMPORARYVIEWS.classroom_dashboard');
        }



}
