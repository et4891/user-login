<?php

class AccountController extends \BaseController {

	/*
	***Register Account (GET)
	 */
	public function getAccountRegister()
	{
		$title = 'Register';
		return View::make('account.register', compact('title'));
	}

	/*
	***Register Account (POST)
	 */
	public function postAccountRegister()
	{
		$v = Validator::make(Input::all(), array(
				'email'						=> 'required|max:50|email|unique:user-login',
				'username'					=> 'required|min:6|max:20|unique:user-login',
				'password'				=> 'required|min:6|max:60|different:username',
				'confirm_password'=> 'required|same:password'
			));

		if ($v->fails())
		{
			return Redirect::route('account-register')
				->withErrors($v)
				->withInput();
		}
		else
		{
			$email		= Input::get('email');
			$username	= Input::get('username');
			$password	= Input::get('password');

			$code = str_random(60);

			$user = User::create(array(
					'email'			=> $email,
					'username'	=> $username,
					'password'	=> Hash::make($password),
					'code'			=> $code,
					'active'		=> 0
				));

			if ($user->save())
			{

				Mail::send('emails.auth.activate', array('link' => URL::route('account-activate', $code), 'username' => $username), function($m) use($user){
					$m->to($user->email, $user->username)->subject('Activation Email');
				});

				return Redirect::route('home')
					->with('global', 'Account has been created.  Check your email for activation email.');
			}

		}
	}

	/*
	***Account Log In (GET)
	 */
	public function getLogIn()
	{
		$title = 'Log In';
		return View::make('account.login', compact('title'));
	}

	/*
	***Account Log In (POST)
	 */
	public function postLogIn()
	{
		$v = Validator::make(Input::all(), array(
				'email'			=> 'required|email',
				'password'	=> 'required'
			));

		if ($v->fails())
		{
			return Redirect::route('account-log-in')
				->withErrors($v)
				->withInput();
		}
		else
		{
			$remember = Input::has('remember');

			$auth = Auth::attempt(array(
					'email'			=> Input::get('email'),
					'password'	=> Input::get('password'),
					'active'		=> 1
				),$remember);

			if ($auth)
			{
				return Redirect::intended('/');
			}
			else
			{
				return Redirect::route('account-log-in')
					->with('global', 'Email / Password wrong or account not actived');
			}
		}
	}

	/*
	***Account Log Out
	 */
	public function logOut()
	{
		Auth::logout();
		return Redirect::route('home');
	}

	/*
	***Change Password (GET)
	 */
	public function getChangePassword()
	{
		$title = 'Change Password';
		return View::make('account.changepassword', compact('title'));
	}

	/*
	***Change Password (POST)
	 */
	public function postChangePassword()
	{
		$v = Validator::make(Input::all(),array(
				'old_password'		=> 'required',
				'new_password'		=> 'required|min:6|max:60',
				'confirm_password'=>	'required|same:confirm_password'
			));

		if ($v->fails())
		{
			return Redirect::route('account-change-password')
				->withErrors($v);	
		}
		else
		{
			$user = User::find(Auth::user()->id);

			$old_password = Input::get('old_password');
			$new_password = Input::get('new_password');

			if (Hash::check($old_password, $user->getAuthPassword()))
			{
				$user->password = Hash::make($new_password);

				if ($user->save())
				{
					return Redirect::route('home')
						->with('global', 'Your password has been changed.');
				}

			}
			else
			{
				return Redirect::route('account-change-password')
					->with('global', 'Your old password is incorrect');
			}
			
		}
		
	}

	/*
	***Forgot Password (GET)
	 */
	public function getForgotPassword()
	{
		$title = 'Forgot Password';
		return View::make('account.forgotpassword', compact('title'));
	}

	public function postForgotPassword()
	{
		$v = Validator::make(Input::all(), array(
				'email'	=> 'required|email'
			));

		if ($v->fails())
		{
			return Redirect::route('account-forgot-password')
				->withErrors($v)
				->withInput();
		}
		else
		{
			$user = User::where('email', '=', Input::get('email'));

			if ($user->count())
			{
				$user = $user->first();

				$code = str_random(60);
				$password_temp = str_random(10);

				$user->password_temp = Hash::make($password_temp);
				$user->code = $code;

				if ($user->save())
				{
					Mail::send('emails.auth.recovery', array('link' => URL::route('account-recovery', $code), 'username' => $user->username, 'password' => $password_temp), function($m) use($user){
						$m->to($user->email, $user->username)->subject('Account Recovery');
					});
				}

				return Redirect::route('home')
					->with('global', 'Recovery Email Sent.  Please check your inbox');
			}
			return Redirect::route('account-forgot-password')
				->with('global', 'Email does not exist');
		}
		
	}

	/*
	***Account Recovery
	 */
	public function recovery($code)
	{
		$user = User::where('code', '=', $code)->where('password_temp', '!=', '');

		if ($user->count())
		{
			$user = $user->first();

			$user->password				= $user->password_temp;
			$user->password_temp 	= '';
			$user->code 					= '';

			if ($user->save())
			{
				return Redirect::route('home')
					->with('global', 'Account Recovered. Please use your temporary password to log in.');
			}
		}
		return Redirect::route('home')
			->with('global', 'Could not recover your account');
	}

	/*
	***Account Activate
	 */
	public function activate($code)
	{
		$user = User::where('code', '=', $code)->where('active', '=', 0);

		if ($user->count())
		{
			$user = $user->first();

			$user->code 	= '';
			$user->active = 1;

			if ($user->save())
			{
				return Redirect::route('home')
					->with('global', 'Account has been activated.  Please Log In.');
			}
		}
			return Redirect::route('home')
				->with('global', 'Account can not be activated.  Please try again later');
	}
}