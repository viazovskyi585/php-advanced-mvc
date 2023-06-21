<?php

namespace App\Services;

use App\Helpers\Session;
use App\Models\Note;
use App\Validators\NotesValidator;

class NotesService
{
	public static function create(NotesValidator $validator, array $fields): bool
	{
		if (!$validator->validate($fields)) {
			return false;
		}

		$fields['author_id'] = Session::id();

		return Note::create($fields);
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
}
