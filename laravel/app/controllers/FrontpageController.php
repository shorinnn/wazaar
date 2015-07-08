<?php

class FrontpageController extends \BaseController {
        
        public function __construct(){
            $this->beforeFilter('admin');
            $this->beforeFilter('csrf', ['only' => [ 'doFeaturedCourses' ] ] );
        }

        public function featuredCourses(){
            $featured = Course::where('featured','1')->get();
            $allCourses = Course::where('publish_status','approved')->orderBy('name','asc')->get();
            return View::make('administration.frontpage.courses.index')->with( compact( 'featured' ,'allCourses' ) );
        }
        
        public function doFeaturedCourses(){
            DB::table('courses')->update( [ 'featured' => 0 ] );
            if( Input::has('featured') ){
                foreach(Input::get('featured') as $course){
                    Course::where('id', $course)->update( [ 'featured' => 1 ] );
                }
                return json_encode( [ 'status' => 'success' ] );
            }
        }

}