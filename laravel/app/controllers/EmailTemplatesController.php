<?php

class EmailTemplatesController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter('admin');
            $this->beforeFilter('csrf', ['only' => [ 'update','destroy' ]]);
        }


	public function edit($tag)
	{
            $template = EmailTemplate::firstOrCreate( ['tag' => $tag] );
            return View::make('administration.email-templates.edit')->withTemplate( $template );
	}
        
	public function update($tag)
	{
            $template = EmailTemplate::where('tag', $tag)->first();
            $template->content = Input::get('content');
            $template->save();
            return Redirect::back()->withSuccess( 'Template updated' );
	}

	
}