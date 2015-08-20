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
            if( Request::ajax() ) return 1;
            return Redirect::to($url);
        }
        
        public function change($slug='', $action=1){
            $course = Course::where('slug', $slug)->first();
            if($course==null) return 0;
            if( $action==1 ){
                WishlistItem::create( [ 'student_id' => Auth::user()->id, 'course_id' => $course->id ] );
                $url = action('StudentController@mycourses');
                $url.='#wishlist';
                if( Request::ajax() ) return 1;
                return Redirect::to($url);
            }
            else{
                WishlistItem::where('student_id', Auth::user()->id)->where('course_id', $course->id)->delete();
                return 1;
            }
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
