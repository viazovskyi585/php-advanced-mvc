<?php

namespace App\Models;

use Core\Model;

class Note extends Model
{
	protected static string $tableName = 'notes';

	public int $author_id;
	public int $folder_id;
	public string $content;
	public bool $pinned;
	public bool $completed;
	public string $created_at;
	public string $updated_at;
}