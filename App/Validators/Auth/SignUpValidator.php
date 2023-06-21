<?php

namespace App\Validators\Auth;

class SignUpValidator extends BaseAuthValidator
{
	protected array $rules = [
		'name' => [
			'required' => true,
			'min' => 2,
			'max' => 255,
		],
		'email' => [
			'required' => true,
			'type' => 'email',
			'max' => 255,
		],
		'password' => [
			'required' => true,
			'type' => 'password',
			'min' => 8,
			'max' => 255,
		],
		'password_confirmation' => [
			'required' => true,
			'sameAs' => 'password',
			'min' => 8,
			'max' => 255,
		],
	];

	protected array $errorMessages = [
		'name' => [
			'required' => 'Name is required',
			'min' => 'Name must be at least 2 characters',
			'max' => 'Name must be less than 255 characters',
		],
		'email' => [
			'required' => 'Email is required',
			'type' => 'Email is not valid',
			'max' => 'Email must be less than 255 characters',
		],
		'password' => [
			'required' => 'Password is required',
			'type' => 'Password must contain at least one letter and one number',
			'min' => 'Password must be at least 8 characters',
			'max' => 'Password must be less than 255 characters',
		],
		'password_confirmation' => [
			'required' => 'Password confirmation is required',
			'sameAs' => 'Password confirmation field must be the same as password',
			'min' => 'Password confirmation must be at least 8 characters',
			'max' => 'Password confirmation must be less than 255 characters',
		],
	];

	public function validate(array $fields): bool
	{
		$result = parent::validate($fields);
		if (!$result) {
			return false;
		}

		return !$this->checkEmailOnExists($fields['email']);
	}
}
