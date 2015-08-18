<?php

class WishlistController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'auth' );
            $this->beforeFilter( 'csrf', ['only' => [ 'store', 'update', 'destroy' ]] );
        }
        
        public function store(){
            WishlistItem::create( [ 'student_id' => Auth::user()->id, 'course_id' => Input::get('id') ] );
            $url = action('StudentController@mycourses');
            $url.='#wishlist';
            return Redirect::to($url);
        }
        
        public function destroy($id){
            // make sure user own this item
            $item = WishlistItem::find( $id );
            if($item->student_id == Auth::user()->id){
                $item->delete();
                if( Request::ajax() ){
                    $response = ['status' => 'success'];
                    return json_encode($response);
                }
                else{
                    return Redirect::back();
                }
            }
            
            if( Request::ajax() ){
                $response = ['status' => 'error', 'errors' =>  trans('crud/errors.cannot_delete_object', 'Wishlist Item')  ];
                return json_encode($response);
            }
            else{
                return Redirect::back()->withErrors( trans('crud/errors.cannot_delete_object', 'Wishlist Item') );
            }
        }
}
