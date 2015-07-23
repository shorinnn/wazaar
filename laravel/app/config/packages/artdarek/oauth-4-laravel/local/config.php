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
                    'client_id'     => '1452067801764623',
                    'client_secret' => '3cba8db5faef7ca42f81391af4178d8d',
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