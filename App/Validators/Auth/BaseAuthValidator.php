<?php

namespace App\Validators\Auth;

use App\Models\User;
use App\Validators\BaseValidator;

class BaseAuthValidator extends BaseValidator
{
	protected function checkEmailOnExists(string $email): bool
	{
		$result = (bool)User::findBy('email', $email);

		if ($result) {
			$this->setError('email', 'Email already exists!');
		}

		return $result;
	}
}
