<?php

class MembersController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter('admin');
            $this->beforeFilter('csrf', ['only' => [ 'update','destroy', 'loginAs' ]]);
        }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
            $pagination = Input::get('view') > 0 ? Input::get('view') :  20;
            
            $url_filters = [];
            $params = array_merge( $_GET, array("type" => "student", 'page' => 1));
            $url_filters['student'] = http_build_query($params);
            $params = array_merge( $_GET, array("type" => "instructor", 'page' => 1));
            $url_filters['instructor'] = http_build_query($params);
            $params = array_merge( $_GET, array("type" => "affiliate", 'page' => 1));
            $url_filters['affiliate'] = http_build_query($params);
            
//            if( !Input::get('type') ) $members = User::with('profiles')->paginate( $pagination );
//            else $members = Role::where('name', Input::get('type'))->first()->users()->with('profiles')->paginate( $pagination );
            if( !Input::get('type') ) $members = User::with('profiles');
            else $members = Role::where('name', Input::get('type'))->first()->users()->with('profiles');
            
            if( Input::get('search') )$members = $members->where('email', 'like', '%'.Input::get('search').'%' );
            
            $members = $members->paginate( $pagination );
            
            if( Request::ajax() ){
                return View::make('administration.members.partials.table')->with( compact('members') )->with( compact('url_filters') )->render();
            }
            Return View::make('administration.members.index')->with(compact('members'))->with( compact('url_filters') );
	}
        
     

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
            $user = User::find($id);
            $student = Student::find($id);
            $adminHelper = new AdminHelper();
            
            if($student==null){
                return Redirect::action('MembersController@index')->withError( trans('crud/errors.object_doesnt_exist', ['object' => 'User' ]) );
            }
            return View::make('administration.members.show')->with(compact('student', 'adminHelper'));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
            $user = User::find($id);
            $instructor_agencies = InstructorAgency::all()->lists('username', 'id');
            $instructor_agencies = ['NULL' => ''] + $instructor_agencies;
            if($user==null){
                return Redirect::action('MembersController@index')->withError( trans('crud/errors.object_doesnt_exist', ['object' => 'User' ]) );
            }
            return View::make('administration.members.edit')->with( compact('user') )->with( compact('instructor_agencies') );
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
            User::unguard();
            $user = User::find($id);
            if($user==null){
                return Redirect::action('MembersController@index')->withError( trans('crud/errors.object_doesnt_exist', ['object' => 'User' ]) );
            }
            $user->status = Input::get('status');
            $user->instructor_agency_id = Input::get('instructor_agency_id') == 0 ? null : Input::get('instructor_agency_id');         
            $user->fill( input_except(['_method', '_token'] ) );
            if($user->hasRole('Affiliate')) $user->email = '#waa#-'.$user->email;
//           if( $user->update( input_except(['_method', '_token'] ) ) ){
           if( $user->updateUniques() ){
                if(Request::ajax()) return json_encode( ['status'=>'success'] );
                return Redirect::back()->withSuccess( trans('crud/errors.object_updated', ['object'=>'User'] ));
            }
            else{
                if(Request::ajax()) return json_encode( ['status'=>'error', 'errors' => format_errors($user->errors()->all()) ] );
                return Redirect::back()->withError( trans('crud/errors.cannot_update_object',['object'=>'User']).': '.format_errors($user->errors()->all()));
            }
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
            $user = User::find($id);
            if($user==null){
                return Redirect::action('MembersController@index')->withError( trans('crud/errors.object_doesnt_exist', ['object' => 'User' ]) );
            }
            if($user->delete($id)){
                return Redirect::back()->withSuccess( trans('crud/errors.object_deleted',['object'=>'User']));
            }
            else{
                return Redirect::back()->withError( trans('crud/errors.cannot_delete_object',['object'=>'User']).': '.format_errors($user->errors()->all()));
            }
	}
        
        public function refund(){
            $purchase = Purchase::find( Input::get('purchase') );
            $refund = $purchase->refund();
            if(!$refund){
                if( !Request::ajax() ){
                    return Redirect::back();
                }
                else{
                    return json_encode( [ 'status' => 'error', 'errors' => trans('administration.not-refundable') ] );
                }
            }
            if( !Request::ajax() ){
                return Redirect::back();
            }
            else {
                $i = $refund->student->refunds()->count();
                $html = View::make('administration.members.partials.refund')->with( compact('refund', 'i') )->render();
                return json_encode( [ 'status' => 'success', 'html' => $html ] );
            }
        }
        
        public function updateProfile($id){
            $update = DB::table('user_profiles')->where('owner_id', $id)->where( 'owner_type', Input::get('profile_type') )->update([
                'first_name' => Input::get('first_name'),
                'last_name' => Input::get('last_name'),
            ]);
            
            if( $update ){
                if( !Request::ajax() ) return Redirect::back();
                else return json_encode( [ 'status' => 'success' ] );
            }
            else{
                if( !Request::ajax() ) return Redirect::back();
                else return json_encode( [ 'status' => 'error', 'errors' => trans('administration.error-updating-profile') ] );
            }
        }
        
        public function createVip(){
            return View::make('administration.members.vip.create');
        }
        
        public function storeVip(){
            $this->users = new UserRepository();
            $roles['affiliate'] = 1;
            $st = null;
            $user = $this->users->signup( Input::all(), null, $roles, null, null, null);
            if ( $user!=null && $user->id) {
                unset($user->url);
                $user->has_ltc = 'yes';
                if(Input::get('vip-type')=='super') $user->is_super_vip = 'yes';
                if(Input::get('vip-type')=='regular') $user->is_vip = 'yes';
                $user->confirmed = 1;
                if($user->save()){
                    if(Input::get('vip-type')=='super') $success = 'Super VIP account created';
                    else $success = 'VIP account created';
                    return View::make('administration.members.vip.create')->withSuccess($success);
                }
                else{
                    $error = implode('<br />',$user->errors()->all());
                    return View::make('administration.members.vip.create')->withErr($error);
                }
            }
            else{
                $error = implode('<br />',$user->errors()->all());
                return View::make('administration.members.vip.create')->withErr($error);
            }
        }
        
        public function superVip(){
            $result = DB::select("SELECT `id` as `theID`, `first_name`, `last_name`, `email`,
                (SELECT COUNT(id) FROM `users` WHERE `second_tier_affiliate_id` = theID) AS `ref_count` FROM `users` WHERE `is_super_vip` = 'yes' 
                ORDER BY `ref_count` DESC");
            return View::make('administration.members.vip.super-vip')->withVips($result);
            
        }
        
        public function vip(){
            $result = DB::select("SELECT `id` as `theID`, `first_name`, `last_name`, `email`,
                (SELECT COUNT(id) FROM `users` WHERE `second_tier_affiliate_id` = theID) AS `ref_count` FROM `users` WHERE `is_vip` = 'yes' 
                ORDER BY `ref_count` DESC");
            return View::make('administration.members.vip.super-vip')->withVips($result);
            
        }
        
        public function ltc(){
            $result = User::where('has_ltc','yes')->orderBy('ltc_count','desc')->paginate(50); 
                    
            return View::make('administration.members.ltc')->withVips($result);
            
        }
        
        public function loginAs(){
            $user = User::find( Input::get('id') );
            Auth::login( $user );
            return Redirect::action('SiteController@index');
        }
        
        public function updatePassword($id){
            $user = User::find($id);
            $user->password = Input::get('password');
            $user->password_confirmation = Input::get('password_confirm');
            if( $user->updateUniques() ){
                if( !Request::ajax() ) return Redirect::back()->withSuccess('success');
                else return json_encode( [ 'status' => 'success' ] );
            }
            else{
                if( !Request::ajax() ) return Redirect::back()->withError('Cannot change password');
                return Response::json(['success' => 0, 'errors'=> $user->errors()->all()]);
            }
        }
        
        public function ltcMover(){
            set_time_limit(0);
            $stPubs = ['yiu72315@gmail.com', 'kame.affili@gmail.com', 'kfkd0123@gmail.com', 'kameoffice123@gmail.com',
                'yozawa@exraise-venture.asia', 'info@otakeninc.com', 'rabbitkiss2000@yahoo.co.jp', 'harada@ulj.co.jp',
                'okazeri@agari.guru', 'okazeri@wannabies.jp', 'kotanigawa@leadconsulting.jp', 'mm7732002@gmail.com',
                'support@e-motty.com', 'sub@mellidion.jp', 'numakura@mellidion.jp', 'tetsuoship@gmail.com', 'info@jmedia.asia',
                'mori@it-partners.biz', 'info@dodo.co.jp', 'yu_ni123@yahoo.co.jp'
            ];
            
            $stPubs = SecondTierInstructor::whereIn('email', $stPubs)->with('instructors')->get();
            return View::make('administration.members.ltc-mover')->with( compact('stPubs') );
        }
        
        public function doLtcMove(){
            set_time_limit(0);
            $stPubs = ['yiu72315@gmail.com', 'kame.affili@gmail.com', 'kfkd0123@gmail.com', 'kameoffice123@gmail.com',
                'yozawa@exraise-venture.asia', 'info@otakeninc.com', 'rabbitkiss2000@yahoo.co.jp', 'harada@ulj.co.jp',
                'okazeri@agari.guru', 'okazeri@wannabies.jp', 'kotanigawa@leadconsulting.jp', 'mm7732002@gmail.com',
                'support@e-motty.com', 'sub@mellidion.jp', 'numakura@mellidion.jp', 'tetsuoship@gmail.com', 'info@jmedia.asia',
                'mori@it-partners.biz', 'info@dodo.co.jp', 'yu_ni123@yahoo.co.jp'
            ];
            
            $stPubs = SecondTierInstructor::whereIn('email', $stPubs)->with('instructors')->get();
            foreach($stPubs as $pub){
                $ltc = LTCAffiliate::where('email', '#waa#-'.$pub->email)->first();
                $instructors = $pub->instructors->lists('id');
                if( count( $instructors ) == 0 ) $instructors = [0];
                
                if($ltc!=null){
                    User::whereIn('id', $instructors)->update( [ 'ltc_affiliate_id' => $ltc->id ] );
                }
            }
            return Redirect::action('MembersController@ltcMover');
        }


}
