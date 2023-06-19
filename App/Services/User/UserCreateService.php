<?php

namespace App\Services\User;

use App\Models\User;

class UserCreateService
{
	static public function call($fields = []): bool
	{
		unset($fields['password_confirmation']);

		$fields['password'] = password_hash($fields['password'], PASSWORD_BCRYPT);

		return User::create($fields);
	}
}
