<?php

class AffiliateController extends \BaseController {
    
    public function __construct()
    {
        $this->beforeFilter( 'affiliate', ['except' => ['becomeAffiliate','doBecomeAffiliate'] ] );
        $this->beforeFilter('csrf', ['only' => [ 'store', 'update', 'destroy' ]]);
    }

	public function promote($course, $tcode='')
	{
            $course = Course::where('slug', $course)->first();
            $course->gifts = $course->gifts()->where('affiliate_id', Auth::user()->id)->get();
            return View::make('affiliate.promote.promote')->with( compact('course', 'tcode') );
	}
        
        public function acceptTerms(){
            $a = ProductAffiliate::find( Auth::user()->id );
            if( !Session::has('redirect-after-accept') ) Session::put('redirect-after-accept', $_SERVER['HTTP_REFERER']);
            return View::make('affiliate.at');
        }
        
        public function doAcceptTerms(){
            if( Input::get('accept') != 1 ) return View::make('affiliate.at');
            Auth::user()->accepted_affiliate_terms = 'yes';
            Auth::user()->updateUniques();
            if( Session::has('redirect-after-accept') ){
                $url = Session::get('redirect-after-accept');
                Session::forget('redirect-after-accept');
                return Redirect::to( $url );
            }
            return Redirect::action('SiteController@index');
        }
        
        public function becomeAffiliate(){
            $users = new UserRepository();
            $users->become( 'Affiliate', Auth::user(), Cookie::get('stpi') );
                
            
            $a = ProductAffiliate::find( Auth::user()->id );
            if( !Session::has('redirect-after-accept') ) Session::put('redirect-after-accept', $_SERVER['HTTP_REFERER']);
            return View::make('affiliate.at');
        }
}