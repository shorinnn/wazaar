<?php

class SiteController extends \BaseController {

	public function index()
	{                 
            $categories = CourseCategory::with('featuredCourse')->get();
            if(Auth::user()) Return View::make('site.homepage_authenticated')->with(compact('categories'));
            else Return View::make('site.homepage_unauthenticated')->with(compact('categories'));
	}
        
	public function classroom()
	{            
            Return View::make('site.classroom');
	}
        
        public function crud(){
             Return View::make('TEMPORARYVIEWS.crud');
        }
        
        public function admindash(){
             Return View::make('TEMPORARYVIEWS.questions');
             	//Return View::make('confide.account_details');
            	 //Return View::make('TEMPORARYVIEWS.admin_dashboard');
        }
        
        public function affiliatedash(){
             Return View::make('TEMPORARYVIEWS.affiliate_dashboard');
        }
        
        public function classroomdash(){
             Return View::make('TEMPORARYVIEWS.classroom_dashboard');
        }
        
        public function enroll(){
             Return View::make('TEMPORARYVIEWS.enroll');
        }
        
        public function shop(){
             Return View::make('TEMPORARYVIEWS.shop');
        }

        public function courseditor(){
             Return View::make('TEMPORARYVIEWS.course_editor');
        }



}
