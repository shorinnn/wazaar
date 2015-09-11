<?php

class GiftsFileController extends \BaseController {
        public function __construct(){
            $this->beforeFilter( 'affiliate' );
            $this->beforeFilter('csrf', ['only' => [ 'store', 'update', 'destroy' ]]);
        }

        public function store(){
            $gift = Input::get('gift');
            if(!Input::hasFile('file')) return json_encode(['status'=>'error', 'errors' => '1'.trans('crud/errors.error_occurred') ]); 
            $gift = Gift::find($gift);
            if($gift->affiliate_id != Auth::user()->id){
                if(Request::ajax()) return json_encode(['status'=>'error', 'errors' => trans('crud/errors.error_occurred') ]); 
                return Redirect::back();
            }
            $file = new GiftFile();
            $file->gift_id = $gift->id;
            $file->size = formatSizeUnits( filesize( Input::file('file')->getRealPath() ) );
            // scan for viruses!
//            if ( App::environment( 'production' ) ){
                $scan_result = shell_exec('clamscan '.Input::file('file')->getRealPath() );
                if( strpos($scan_result, 'FOUND') ){
                    @unlink( Input::file('file')->getRealPath() );
                    return json_encode(['status'=>'error', 'errors' => trans('general.virus-found-in-uploaded-file') ]); 
                }
//            }
            
            if( $file->upload( Input::file('file')->getRealPath() ) ){
                if($file->save()){
                    return json_encode(['status'=>'success', 'html' => View::make('affiliate/promote.partials.file')->with(compact('file'))->render() ]);
                }
                else{
                    return json_encode(['status'=>'error', 'errors' => trans('crud/errors.error_occurred') ]); 
                }
            }
            else{
                return json_encode(['status'=>'error', 'errors' => trans('crud/errors.error_occurred') ]); 
            }
        }
        
        public function update($id){
            $file = GiftFile::find($id);
            if($file==null || $file->gift->affiliate_id != Auth::user()->id ){
                $response = ['status' => 'error', 'errors' =>  trans('crud/errors.cannot_save_object', ['object'  => 'File' ]) ];
                return json_encode($response);
            }
            
            $name = Input::get('name');
            $file->$name = Input::get('value');
            $file->save();
            $response = ['status' => 'success'];
            return json_encode($response);
        }
        
        public function destroy($id){
            $file = GiftFile::find($id);
            if($file==null || $file->gift->affiliate_id != Auth::user()->id ){
                $response = ['status' => 'error', 'errors' =>  trans('crud/errors.cannot_delete_object', ['object'  => 'File' ]) ];
                if(Request::ajax()){
                    return json_encode($response);
                }
                return Redirect::back();
            }
            
            $file->delete();
            $response = ['status' => 'success'];
            if(Request::ajax()){
                return json_encode($response);
            }
            return Redirect::back();
        }

}