<?php

namespace App\Models;

use Core\Model;

class User extends Model
{
	protected static string $tableName = 'users';

	public string $name;
	public string $email;
	public string $password;
	public string $created_at;
	public string $updated_at;
}
