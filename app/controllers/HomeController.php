<?php

class HomeController extends BaseController {

	public function home()
	{
		$title = 'Home Page';
		return View::make('home', compact('title', 'user'));
	}
}