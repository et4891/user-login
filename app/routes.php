<?php

Route::get('/', array(
		'as' => 'home',
		'uses' => 'HomeController@home'
	));


/*
***Authenticated Group
 */
Route::group(array('before' => 'auth'), function(){
	/*
	***CSRF Protection
	 */
	Route::group(array('before' => 'csrf'), function(){
		/*
		***Change Password (POST)
		 */
		Route::post('account/change-password', array(
				'as'		=> 'account-change-password-post',
				'uses'	=> 'AccountController@postChangePassword'
			));
	});

	/*
	***User Profile
	 */
	Route::get('user/{username}', array(
		'as'		=> 'user-profile',
		'uses'	=> 'ProfileController@user'
		));

	/*
	***Change Password (GET)
	 */
	Route::get('account/change-password', array(
			'as'		=> 'account-change-password',
			'uses'	=> 'AccountController@getChangePassword'
		));

	/*
	***Account Log Out
	 */
	Route::get('account/log-out', array(
			'as'		=> 'account-log-out',
			'uses'	=> 'AccountController@logOut'
		));
});




/* 
***Unauthenticated Group
 */											 

Route::group(array('before' => 'guest'), function(){
	/*
	***CSRF Protection
	 */
	Route::group(array('before' => 'csrf'), function(){
		/*
		***Forgot Password (POST)
		 */
		Route::post('account/forgot-password', array(
				'as'		=> 'account-forgot-password-post',
				'uses'	=> 'AccountController@postForgotPassword'
			));
		/*
		***Account Log In (POST)
		 */
		Route::post('account/log-in', array(
				'as'		=> 'account-log-in-post',
				'uses'	=> 'AccountController@postLogIn'
			));

		/*
		***Register Account (POST)
		 */
		Route::post('account/register', array(
				'as'		=> 'account-register-post',
				'uses'	=> 'AccountController@postAccountRegister'
			));
	});

	/*
	***Forgot Password (GET)
	 */
	Route::get('account/forgot-password', array(
			'as'		=> 'account-forgot-password',
			'uses'	=> 'AccountController@getForgotPassword'
		));

	/*
	***Account Log In (GET)
	 */
	Route::get('account/log-in', array(
			'as'		=> 'account-log-in',
			'uses'	=> 'AccountController@getLogIn'
		));

	/*
	***Register Account (GET)
	 */
	Route::get('account/register', array(
			'as'		=> 'account-register',
			'uses'	=> 'AccountController@getAccountRegister'
		));

	/*
	***Code Activate
	 */
	Route::get('account/activate/{code}', array(
			'as'		=> 'account-activate',
			'uses'	=>	'AccountController@activate'
		));

	/*
	***Account Recovery
	 */
	Route::get('account/recovery/{code}', array(
			'as'		=> 'account-recovery',
			'uses'	=> 'AccountController@recovery'
		));
});