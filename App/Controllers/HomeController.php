<?php

namespace App\Controllers;

use App\Helpers\Session;
use App\Models\User;
use Core\Controller;

class HomeController extends Controller
{
	public function index(): void
	{
		if (Session::check()) {
			$user = User::find(Session::id());
		}

		view('home/index', [
			'user' => $user ?? null
		]);
	}
}
