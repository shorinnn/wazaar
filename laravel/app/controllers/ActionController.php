<?php

class ActionController extends \BaseController {

	public function track()
	{    
            if(Input::has('data')){
                $data = Input::get('data');
                foreach($data as $action){
                    $action = new Action($action);
                    $action->ip = $_SERVER['REMOTE_ADDR'];
                    $action->session_id = Session::getId();
                    if( !$action->save() ) dd($action->errors()->all());
                }
            }
            
	}
}
