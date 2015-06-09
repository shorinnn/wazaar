<?php

class AffiliateController extends \BaseController {
    
    public function __construct()
    {
        $this->beforeFilter( 'affiliate' );
        $this->beforeFilter('csrf', ['only' => [ 'store', 'update', 'destroy' ]]);
    }

	public function promote($course)
	{
            $course = Course::where('slug', $course)->first();
            $course->gifts = $course->gifts()->where('affiliate_id', Auth::user()->id)->get();
            return View::make('affiliate.promote.promote')->with( compact('course') );
	}
}