<?php 
class ProfileController extends BaseController
{
	public function user($username)
	{
		$user = User::where('username', '=', $username);

		if ($user->count())
		{
			$user = $user->first();
			$title = 'User Profile';
			return View::make('profile.user', compact('user', 'title'));
		}

		return 'User Not Found. Please Create an Account';
	}
}