<?php

namespace App\Controllers;

use Core\Controller;

class AuthController extends Controller
{
	public function login(): void
	{
		view('auth/login');
	}

	public function register(): void
	{
		view('auth/register');
	}
}
