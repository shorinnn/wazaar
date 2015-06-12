<?php

class LpController extends \BaseController {
    
        public function index(){
            return View::make('lp.index');
        }

	public function store()
	{
            $error_flag = '?error=1';
            if( Input::has('stpi') ){
                Cookie::queue('stpi', Input::get('stpi'), 60*24*30);
                $error_flag = '&error=1';
            }
            
            //add user to DELIVERED
            $delivered = new DeliveredHelper();
            $name = explode(' ', Input::get('name'), 2);
            $response = $delivered->addUser( $name[1], $name[0], Input::get('email') );
            if( is_object($response) && $response->success ){
                return Redirect::to('lp1/success.php');
            }
            return Redirect::to( $_SERVER['HTTP_REFERER'].$error_flag );
	}

}