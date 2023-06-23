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
	public bool $shared = false;
	public string $author = '';

	public static function byFolderId(int $folderId)
	{
		return static::selectWithSharedField()
			->where('author_id', '=', Session::id())
			->andWhere('folder_id', '=', $folderId)
			->groupBy(['notes.id'])
			->orderBy([
				'notes.pinned' => 'DESC',
				'notes.completed' => 'ASC',
				'notes.id' => 'DESC',
			])
			->get();
	}

	static public function sharedNotes()
	{
		return Note::select(['notes.*', 'us.email as author'])
			->join('shared_notes sn', 'sn.note_id', 'notes.id')
			->join('users us', 'notes.author_id', 'us.id')
			->where('sn.user_id', '=', Session::id())
			->orderBy(['notes.id' => 'DESC'])
			->get();
	}

	static protected function selectWithSharedField(): Model
	{
		return self::select(['notes.*', 'MAX(sn.user_id IS NOT NULL) AS shared'])
			->join('shared_notes sn', 'notes.id', 'sn.note_id');
	}
}
