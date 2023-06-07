<?php

namespace App\Models;

use Core\Model;

class Folder extends Model
{
	protected static string $tableName = 'folders';

	public string $author_id;
	public string $title;
	public string $created_at;
	public string $updated_at;
}
