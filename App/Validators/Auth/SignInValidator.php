<?php

namespace App\Validators\Auth;

class SignInValidator extends BaseAuthValidator
{
	protected array $rules = [
		'email' => [
			'required' => true,
		],
		'password' => [
			'required' => true,
		],
	];

	protected array $errorMessages = [
		'email' => [
			'required' => 'Email is required',
		],
		'password' => [
			'required' => 'Password is required',
		],
	];

	public function verifyPassword(string $formPass, string $userPass): string
	{
		return password_verify($formPass, $userPass);
	}
}
