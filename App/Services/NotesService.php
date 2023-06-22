<?php

namespace App\Services;

use App\Helpers\Session;
use App\Models\Note;
use App\Models\SharedNote;
use App\Validators\NotesValidator;

class NotesService
{
	public static function create(NotesValidator $validator, array $fields): bool
	{
		if (!$validator->validate($fields)) {
			return false;
		}

		$sharedUsers = $fields['users'] ?? [];
		unset($fields['users']);

		$fields = static::prepareFields($fields);
		$noteId = Note::create($fields);

		if (!empty($sharedUsers)) {
			foreach ($sharedUsers as $userId) {
				SharedNote::create(['note_id' => $noteId, 'user_id' => $userId]);
			}
		}

		$fields['author_id'] = Session::id();

		return $noteId;
	}

	public static function update(NotesValidator $validator, int $id, array $fields): bool
	{
		if (!$validator->validate($fields)) {
			return false;
		}

		$note = Note::find($id);

		if (!$note) {
			Session::notify('Note not found!', 'error');
			redirect();
		}

		return $note->update($fields);
	}

	static protected function prepareFields(array $fields): array
	{
		$fields['author_id'] = Session::id();
		$fields['pinned'] = $fields['pinned'] ?? 0;
		$fields['completed'] = $fields['completed'] ?? 0;

		return $fields;
	}
}
