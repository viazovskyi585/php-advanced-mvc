<?php

namespace App\Models;

use App\Helpers\Session;
use Core\Model;

class Folder extends Model
{
	protected static string $tableName = 'folders';
	public static int $GENERAL_FOLDER_ID = 1;
	public static int $SHARED_FOLDER_ID = 2;

	public int $author_id;
	public string $title;
	public string $created_at;
	public string $updated_at;

	public static function isFrozen(int $id): bool
	{
		return in_array($id, [static::$GENERAL_FOLDER_ID, static::$SHARED_FOLDER_ID]);
	}

	public static function getUserFolders(): array
	{
		return static::select()
			->where('author_id', '=', Session::id())
			->orWhere('id', '=', static::$GENERAL_FOLDER_ID)
			->orderBy('id')
			->get();
	}
}
