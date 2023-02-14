<?php namespace App\Controllers;

class Index extends BaseController
{
	public function index()
	{
		// return redirect()->to('https://nene-maru.com/home');
		return redirect()->to(base_url().'/home');
	}
}

