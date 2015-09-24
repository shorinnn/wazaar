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
//            if(1==2 && Cache::has('delivered-stpub-stats') ){
            if( Cache::has('delivered-stpub-stats') ){
                $str = Cache::get('delivered-stpub-stats');
            }
            else{
                $delivered = new DeliveredHelper();
                $str = '<h1>Data updated every 10 minutes. Generated at '.date('Y-m-d H:i:s').'</h1>';
                $stpi = User::where('is_second_tier_instructor','yes')->get();
                foreach($stpi as $s){
                    $referred = User::where('second_tier_instructor_id', $s->id)->lists('email');
                    $count = count($referred);
                    $st = User::where('email','yozawa@exraise-venture.asia')->first();
                    $ltc = User::where('email','#waa#-yozawa@exraise-venture.asia')->first();
                    if($st->id == $s->id){
                        $emails_arr = User::where('second_tier_instructor_id', $s->id)->where('ltc_affiliate_id','!=', $ltc->id)->lists('email');
                        $emails_arr = $emails_arr;
                    }
                    else{
                       $emails_arr = $referred;
                    }
                    $emails = implode(' | ', $referred);

                    $data = $delivered->getUsersByTags(['second-tier-publisher-id' => $s->id]);
                    if($data==null || $data['success']==false){
                        $lp_count = 0;
                        $lp_emails = '';
                        $lp_emails_arr = [];
                    }
                    else{
                        $data = $data['data'];
                        $lp_count = count($data);
                        $lp_emails = array_column($data, 'email');
                        $lp_emails_arr = $lp_emails;
                        $lp_emails = implode(' | ', $lp_emails);
                    }
                    
                    if( count($emails) > count($lp_emails_arr) ){
                        $common = array_intersect($emails_arr, $lp_emails_arr);
                    }
                    else{
                        $common = array_intersect($lp_emails_arr, $emails_arr );
                    }
                    $commonCount = count($common);
                    $str .= "<b>STPI $s->id - $s->last_name $s->first_name ( $s->email ) - 
                        Referred Registered on Wazaar: $count. Registerd on LP: $lp_count. Registered on LP and Wazaar: $commonCount</b><br />
                        <div style='display:block; max-height:100px; overflow-y:scroll; border:1px solid black; padding:10px'>
                            <span style='font-weight:bold'>Registered On Wazaar</span><br />
                            $emails
                        </div>";


                    $str .= " <div style='display:block; max-height:100px; overflow-y:scroll; border:1px solid black; padding:10px'>
                            <span style='font-weight:bold'>Registered On LP</span><br />
                            $lp_emails
                        </div>";
                    $common = implode(' | ', $common);
                    $str .= " <div style='display:block; max-height:100px; overflow-y:scroll; border:1px solid black; padding:10px'>
                            <span style='font-weight:bold'>Registered On LP AND Wazaar</span><br />
                            $common
                        </div> <hr />";
                }
                Cache::put('delivered-stpub-stats', $str, 10);
            }
            
            return View::make('administration.second_tier_pub.stats')->withStats( $str );
        }

}