<?php

class GiftsController extends \BaseController {
    public function __construct(){
            $this->beforeFilter( 'affiliate' );
            $this->beforeFilter('csrf', ['only' => [ 'store', 'update', 'destroy' ]]);
        }

	/**
	 * Store a newly created resource in storage.
	 * POST /gifts
	 *
	 * @return Response
	 */
	public function store()
	{
		$gift = new Gift();
                $gift->course_id = Input::get('course_id');
                $gift->affiliate_id = Auth::user()->id;
                $gift->save();
                if(Request::ajax()){
                    $course = $gift->course;
                    $response['html'] = View::make('affiliate.promote.partials.gift')->with( compact('gift', 'course') )->render();
                    $response['status'] = 'success';
                    $response['id'] = '#gift-textarea-'.$gift->id;
                    return json_encode($response);
                }
                return Redirect::back();
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /gifts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
            $gift = Gift::find($id);
            if( $gift->affiliate_id != Auth::user()->id ){
                return Redirect::back();
            }
            $gift->text = Input::get('text');
            $gift->save();
            if(Request::ajax()){
                return json_encode(['status'=>'success']);
            }
            return Redirect::back();
	}
        
        public function destroy($id){
            $gift = Gift::find($id);
            if($gift==null || $gift->affiliate_id != Auth::user()->id ){
                $response = ['status' => 'error', 'errors' =>  trans('crud/errors.cannot_delete_object', ['object'  => 'Gift' ]) ];
                
                if(Request::ajax()){
                    return json_encode($response);
                }
                return Redirect::back();
            }
            $gift->delete();
            $response = ['status' => 'success'];
            if(Request::ajax()){
                return json_encode($response);
            }
            return Redirect::back();
        }

}