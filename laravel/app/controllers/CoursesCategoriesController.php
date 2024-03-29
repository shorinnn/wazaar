<?php

class CoursesCategoriesController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter('admin', ['except' => ['subcategories','subcategories_instructor' ] ] );
            $this->beforeFilter('csrf', ['only' => [ 'store', 'update','destroy', 'group' ]]);
        }
        
        public function index(){
            $cssClasses = [ 'business', 'investment', 'web-and-it', 'fitness-and-sports', 'beauty-and-health', 'cooking', 'language',
                            'personal-development', 'photo-and-video', 'music', 'handmade-craft', 'hobbies' ];
            Return View::make('administration.course_categories.index')->with( compact('cssClasses') );
        }
        
        public function store(){
            $category = new CourseCategory;
            $category->name = Input::get('name');
            if(Request::ajax()){
                if( $category->save() ) {
                    return json_encode ( [ 'status'=>'success', 
                                           'html' => View::make('administration.course_categories.category')->with(compact('category'))->render() ] );
                }
                else return json_encode( [ 'status'=>'error', 'errors' => format_errors($category->errors()->all()) ] );
            }
            else{
                if( $category->save() ) return Redirect::back();
                else return Redirect::back()->withErrors( format_errors( $category->errors()->all() ) );
            }
        }
        
        public function update($id){
            $category = CourseCategory::find($id);
            $name = Input::get('name');
            $category->$name = Input::get('value');
            $category->save();
            $response = ['status' => 'success'];
            if(Request::ajax()) return json_encode($response);
            else return Redirect::back();
        }

        public function destroy($id){
            $category = CourseCategory::find($id);
            if( $category->delete() ) $response = ['status' => 'success'];
            else $response = ['status' => 'error', 'errors' => format_errors( $category->errors()->all() ) ];
            
            if(Request::ajax()) return json_encode($response);
            else return Redirect::back();
        }
        
	public function subcategories()
	{
            if(Input::get('id') < 1) return array();
            $id = Input::get('id');
            $category = CourseCategory::find($id);
            return $category->courseSubcategories;
	}
        
	public function subcategories_instructor()
	{
            if(Input::get('id') < 1) return array();
            $id = Input::get('id');
            $category = CourseCategory::find($id);
            return $category->courseSubcategories;
	}
        
        public function graphics_url($category){
            $category = CourseCategory::find($category);
            $category->upload_graphics( Input::file('file')->getRealPath() );
            if($category->save()){
                return json_encode( [ 'status'=>'success', 'html' => 
                    View::make('administration.course_categories.graphics')->with(compact('category'))->render() ] );
            }
            else return json_encode( [ 'status'=>'error', 'errors' => format_errors($category->errors()->all()) ] );
        }
        
        public function group($id){
            if( Input::has('group') ){
                $groups = Input::get('group');
                // delete dropped groups
                 CategoryGroupItem::where( 'course_category_id', $id )->whereNotIn( 'category_group_id', $groups )->delete();
                // add the new groups
                foreach($groups as $group){
                    $g = new CategoryGroupItem( ['course_category_id' => $id, 'category_group_id' => $group ] );
                    $g->save();
                }
            }
            else{
                CategoryGroupItem::where('course_category_id', $id)->delete();
            }
            return json_encode( [ 'status'=>'success' ] );
        }
}
