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

		$sharedUsers = $fields['users'] ?? [];
		unset($fields['users']);
		$fields = static::prepareFields($fields);

		static::updateSharedNotesUsers($sharedUsers, $id);

		return $note->update($fields);
	}

	static protected function updateSharedNotesUsers(array $newSharedUsers, int $noteId): bool
	{
		$oldSharedUsers = SharedNote::select(['user_id'])->where('note_id', '=', $noteId)->pluck('user_id');

		$usersToDelete = array_diff($oldSharedUsers, $newSharedUsers);
		$usersToAdd = array_diff($newSharedUsers, $oldSharedUsers);

		if (!empty($usersToDelete)) {
			$sharedNotesToDelete = SharedNote::select()
				->where('note_id', '=', $noteId)
				->whereIn('user_id', $usersToDelete)
				->get();

			foreach ($sharedNotesToDelete as $sharedNote) {
				$sharedNote->destroy();
			}
		}

		if (!empty($usersToAdd)) {
			foreach ($usersToAdd as $userId) {
				SharedNote::create(['note_id' => $noteId, 'user_id' => $userId]);
			}
		}

		return true;
	}

	static protected function prepareFields(array $fields): array
	{
		$fields['author_id'] = Session::id();
		$fields['pinned'] = $fields['pinned'] ?? 0;
		$fields['completed'] = $fields['completed'] ?? 0;

		return $fields;
	}
}
