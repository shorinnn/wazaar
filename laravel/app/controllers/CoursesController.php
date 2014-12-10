<?php

class CoursesController extends \BaseController {

	public function index()
	{
            Return View::make('courses.index');
	}
        
        public function categories(){
            $categories = CourseCategory::paginate(3);
            Return View::make('courses.categories')->with(compact('categories'));
        }
        
        public function category($slug=''){
            $category = CourseCategory::where('slug',$slug)->first();
            $courses = $category->courses()->paginate(2);
            Return View::make('courses.category')->with(compact('category'))->with(compact('courses'));
        }
        
        public function show($slug){
            $course = Course::where('slug', $slug)->first();
            if(Input::has('aid')){
                Cookie::queue("aid-$course->id", Input::get('aid'), 60*60*30);
            }
            Return View::make('courses.show')->with(compact('course'));
        }
        
        public function purchase($slug){
            $course = Course::where('slug', $slug)->first();
            if(Cookie::has("aid-$course->id")){
                return "PURCHASED. AFFILIATOR ID  = ".Cookie::get("aid-$course->id");
            }
//            Auth::user()->purchase($course);
            return "PURCHASED! Kinda...";
        }



}
