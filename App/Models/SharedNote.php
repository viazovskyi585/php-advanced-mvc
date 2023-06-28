<?php

namespace App\Models;

use Core\Db;
use Core\Model;

class SharedNote extends Model
{
	protected static string $tableName = 'shared_notes';

	public int $note_id;
	public int $user_id;
	public string $created_at;

	public function destroy(): bool
	{
		$dbh = Db::connect()->prepare('DELETE FROM ' . static::$tableName . ' WHERE note_id = :note_id AND user_id = :user_id');
		$dbh->bindParam(':note_id', $this->note_id);
		$dbh->bindParam(':user_id', $this->user_id);
		return $dbh->execute();
	}
}
