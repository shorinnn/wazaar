<?php

class SiteController extends \BaseController {

	public function index()
	{
            Return View::make('site.homepage_authenticated');
	}



}
