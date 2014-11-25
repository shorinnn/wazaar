<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(
		/**
		 * Facebook
		 */
                'Facebook' => array(
                    'client_id'     => '542192635924313',
                    'client_secret' => 'f2c0081d8fcf59ff69e5bbcbe88a1f51',
                    'scope'         => array('email'),
                ),		
                /** 
                 * Google
                 */
                'Google' => array(
                    'client_id'     => '997779031455-p5n5bql2ej2bgagcbbdhbja7i93focmp.apps.googleusercontent.com',
                    'client_secret' => 'zJKQMwICU0p41SVYYfQ2-eS5',
                    'scope'         => array('userinfo_email', 'userinfo_profile'),
                ),  

	)

);