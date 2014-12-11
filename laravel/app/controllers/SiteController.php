<?php

class SiteController extends \BaseController {

	public function index()
	{
//            $purchase = CoursePurchase::first();
//            echo $purchase->course->name;
//            echo $purchase->student->username;
//            echo $purchase->ltcAffiliator->username;
//            echo $purchase->productAffiliator->username;
//            $user = User::find(3);
//            dd( $user->productAffiliators()->count() );
            $categories = CourseCategory::all();
            Return View::make('site.homepage_authenticated')->with(compact('categories'));
	}



}
