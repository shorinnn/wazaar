<?php

class AffiliateAgenciesController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter('admin', ['except' => 'subcategories']);
            $this->beforeFilter('csrf', ['only' => [ 'store', 'update','destroy' ]]);
        }

	public function index()
	{
		Return View::make('administration.affiliate_agencies.index');
	}

	public function store()
	{
            $agency = new AffiliateAgency;
            $agency->name = Input::get('name');
            if(Request::ajax()){
                if( $agency->save() ) {
                    return json_encode ( [ 'status'=>'success', 
                                           'html' => View::make('administration.affiliate_agencies.agency')->with(compact('agency'))->render() ] );
                }
                else return json_encode( [ 'status'=>'error', 'errors' => format_errors($agency->errors()->all()) ] );
            }
            else{
                if( $agency->save() ) return Redirect::back();
                else return Redirect::back()->withErrors( format_errors( $agency->errors()->all() ) );
            }
	}
        
	
	public function update($id)
	{
            $agency = AffiliateAgency::find($id);
            $name = Input::get('name');
            $agency->$name = Input::get('value');
            $agency->save();
            $response = ['status' => 'success'];
            if(Request::ajax()) return json_encode($response);
            else return Redirect::back();
	}

	public function destroy($id)
	{
            $agency = AffiliateAgency::find($id);
            if( $agency->delete() ) $response = ['status' => 'success'];
            else $response = ['status' => 'error', 'errors' => format_errors( $agency->errors()->all() ) ];
            
            if(Request::ajax()) return json_encode($response);
            else return Redirect::back();
	}
        
        public function affiliates($id){
            $affiliates = AffiliateAgency::find($id)->ltcAffiliates;
            return View::make('administration.affiliate_agencies.affiliates')->with( compact('affiliates') )->render();
        }

}