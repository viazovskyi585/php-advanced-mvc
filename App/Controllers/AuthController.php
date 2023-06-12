<?php

namespace App\Controllers;

use Core\Controller;

class AuthController extends Controller
{
	public function login()
	{
		return view('auth/login');
	}
}
