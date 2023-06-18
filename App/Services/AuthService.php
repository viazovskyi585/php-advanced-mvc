<?php

namespace App\Services;

use App\Helpers\Session;
use App\Models\User;
use App\Validators\Auth\SignInValidator;

class AuthService
{
	public static function call(array $fields, SignInValidator $validator): bool
	{
		if ($validator->validate($fields)) {
			$user = User::findBy('email', $fields['email']);
			if ($user && $validator->verifyPassword($fields['password'], $user->password)) {
				Session::setUserData($user->id, ['email' => $user->email]);
				return true;
			} else {
				$validator->setNonFieldError('Invalid email or password');
			}
		}

		return false;
	}
}
