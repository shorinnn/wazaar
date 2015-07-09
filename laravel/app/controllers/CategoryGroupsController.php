<?php

class CategoryGroupsController extends \BaseController {
    public function __construct(){
            $this->beforeFilter('admin');
            $this->beforeFilter('csrf', ['only' => [ 'store', 'update','destroy' ]]);
        }
        
        public function index(){
            Return View::make('administration.category_groups.index');
        }
        
        public function store(){
            $group = new CategoryGroup;
            $group->name = Input::get('name');
            if(Request::ajax()){
                if( $group->save() ) {
                    return json_encode ( [ 'status'=>'success', 
                                           'html' => View::make('administration.category_groups.group')->with(compact('group'))->render() ] );
                }
                else return json_encode( [ 'status'=>'error', 'errors' => format_errors($group->errors()->all()) ] );
            }
            else{
                if( $group->save() ) return Redirect::back();
                else return Redirect::back()->withErrors( format_errors( $group->errors()->all() ) );
            }
        }
        
        public function update($id){
            $group = CategoryGroup::find($id);
            $name = Input::get('name');
            $group->$name = Input::get('value');
            $group->save();
            $response = ['status' => 'success'];
            if(Request::ajax()) return json_encode($response);
            else return Redirect::back();
        }

        public function destroy($id){
            $group = CategoryGroup::find($id);
            if( $group->delete() ) $response = ['status' => 'success'];
            else $response = ['status' => 'error', 'errors' => format_errors( $group->errors()->all() ) ];
            
            if(Request::ajax()) return json_encode($response);
            else return Redirect::back();
        }
        
        public function group($id){
            if( Input::has('group') ){
                $groups = Input::get('group');
                // delete dropped groups
                 CategoryGroupItem::where( 'category_group_id', $id )->whereNotIn( 'course_category_id', $groups )->delete();
                // add the new groups
                foreach($groups as $group){
                    $g = new CategoryGroupItem( ['category_group_id' => $id, 'course_category_id' => $group ] );
                    $g->save();
                }
            }
            else{
                CategoryGroupItem::where('category_group_id', $id)->delete();
            }
            return json_encode( [ 'status'=>'success' ] );
        }

    
}