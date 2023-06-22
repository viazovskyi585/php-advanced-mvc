<?php

namespace App\Models;

use App\Helpers\Session;
use Core\Model;

class Note extends Model
{
	protected static string $tableName = 'notes';

	public int $author_id;
	public int $folder_id;
	public string $title;
	public string $content;
	public bool $pinned;
	public bool $completed;
	public string $created_at;
	public string $updated_at;

	public static function byFolderId(int $folderId)
	{
		return self::select()
			->where('author_id', '=', Session::id())
			->andWhere('folder_id', '=', $folderId)
			->get();
	}
}
