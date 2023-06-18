<?php

namespace App\Controllers;

use App\Helpers\Session;
use App\Models\User;
use App\Services\AuthService;
use App\Services\User\UserCreateService;
use App\Validators\Auth\SignInValidator;
use App\Validators\Auth\SignUpValidator;
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

	public function signUp(): void
	{
		$fields = filter_input_array(INPUT_POST, $_POST);
		$validator = new SignUpValidator();

		if ($validator->validate($fields)) {
			try {
				UserCreateService::call($fields);
				redirect('login');
			} catch (\Exception $e) {
				$validator->setNonFieldError($e->getMessage());
			}
		}

		view('auth/register', [
			'errors' => $validator->getErrors(),
			'fields' => $fields
		]);
	}

	public function signIn(): void
	{
		$fields = filter_input_array(INPUT_POST, $_POST);
		$validator = new SignInValidator();

		if (AuthService::call($fields, $validator)) {
			redirect();
		} else {
			view('auth/login', [
				'errors' => $validator->getErrors(),
				'fields' => $fields
			]);
		}
	}

	public function signOut(): void
	{
		Session::destroy();
		redirect('login');
	}

	public function before(string $action): bool
	{
		if (in_array($action, ['login', 'register']) && Session::check()) {
			if (!empty($_SERVER['HTTP_REFERER'])) {
				redirectBack();
			} else {
				redirect();
			}
		}

		return parent::before($action);
	}
}
