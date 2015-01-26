<?php

class WishlistController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'auth' );
            $this->beforeFilter( 'csrf', ['only' => [ 'store', 'update', 'destroy' ]] );
        }
        
        public function store(){
            WishlistItem::create( [ 'student_id' => Auth::user()->id, 'course_id' => Input::get('id') ] );
            return Redirect::action('StudentController@wishlist');
        }
}
