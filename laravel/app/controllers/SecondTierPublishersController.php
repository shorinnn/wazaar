<?php

class SecondTierPublishersController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter('admin');
            $this->beforeFilter('csrf', ['only' => [ 'update' ]]);
        }

	/**
	 * Display a listing of the resource.
	 * GET /secondtierpublishers
	 *
	 * @return Response
	 */
	public function index()
	{
            $members = User::where('is_second_tier_instructor','yes')->paginate(20);
            
            if( Request::ajax() ){
                return View::make('administration.second_tier_pub.partials.table')->with( compact('members') )->render();
            }
            Return View::make('administration.second_tier_pub.index')->with(compact('members'));
	}

	public function update($id)
	{
            $user = User::find($id);
            $user->sti_approved = trim( strtolower( Input::get('value') ) );
            if( $user->updateUniques() ){
                if( strtolower( Input::get('value') ) =='yes' ){
                    // send STP approval email
                    $name = '';
                    $instructor = Instructor::find($user->id);
                    if($instructor->profile != null) $name = $instructor->profile->last_name.' '.$instructor->profile->first_name;
                    else $name = "$user->last_name $user->first_name";
                    
                    Mail::send(
                        'emails.second_tier_approved',
                        compact('name'),
                        function ($message) use ($user, $name) {
                            $message
                                ->to($user->email, $name)
                                ->subject( '販売者２ティアのリンク発行承認のご連絡' );
                        }
                    );
                }
                if(Request::ajax()) return json_encode( ['status'=>'success','eh' => Input::get('value') ] );
                return Redirect::back()->withSuccess( trans('crud/errors.object_updated', ['object'=>'User'] ));
            }
            else{
                if(Request::ajax()) return json_encode( ['status'=>'error', 'errors' => format_errors($user->errors()->all()) ] );
                return Redirect::back()->withError( trans('crud/errors.cannot_update_object',['object'=>'User']).': '.format_errors($user->errors()->all()));
            }
	}
        
        public function stats(){
            $str = '';
            $stpi = User::where('is_second_tier_instructor','yes')->get();
            foreach($stpi as $s){
                $referred = User::where('second_tier_instructor_id', $s->id)->lists('email');
                $count = count($referred);
                $emails = implode(' | ', $referred);
                $str .= "<b>STPI $s->id - $s->last_name $s->first_name ( $s->email ) - Referred: $count</b><br />
                    <div style='display:block; max-height:100px; overflow-y:scroll; border:1px solid black; padding:10px'>$emails</div>
                        <hr />";
            }
            
            return View::make('administration.second_tier_pub.stats')->withStats( $str );
        }

}