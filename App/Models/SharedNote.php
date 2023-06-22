<?php

namespace App\Models;

use Core\Model;

class SharedNote extends Model
{
	protected static string $tableName = 'shared_notes';

	public int $note_id;
	public int $user_id;
	public string $created_at;
}
