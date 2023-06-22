<?php

namespace App\Controllers;

use App\Helpers\Session;
use App\Models\Folder;
use App\Models\Note;
use App\Models\User;
use App\Services\NotesService;
use App\Validators\NotesValidator;
use Core\Controller;

class NotesController extends Controller
{
	public function show(int $id)
	{
		$note = Note::find($id);
		$folder = Folder::find($note->folder_id);
		view('pages/notes/show', ['note' => $note, 'folder' => $folder]);
	}

	public function create()
	{
		$users = User::select()->where('id', '!=', Session::id())->get();

		view('pages/notes/create', [
			'folders' => Folder::getUserFolders(),
			'users' => $users,
		]);
	}

	public function store()
	{
		$fields = filter_input_array(INPUT_POST, NotesValidator::REQUEST_RULES);

		$validator = new NotesValidator();
		if (NotesService::create($validator, $fields)) {
			Session::notify('Note was created!', 'success');
			redirect("folders/{$fields['folder_id']}");
		}

		view('notes/create', [
			'folders' => Folder::getUserFolders(),
			'errors' => $validator->getErrors(),
			'fields' => $fields,
		]);
	}

	public function edit(int $id)
	{
		view('pages/notes/edit', [
			'note' => Note::find($id),
			'folders' => Folder::getUserFolders(),
		]);
	}

	public function update(int $id)
	{
		$fields = filter_input_array(INPUT_POST, $_POST);
		$validator = new NotesValidator();

		if (NotesService::update($validator, $id, $fields)) {
			Session::notify('Note was updated!', 'success');
			redirect("notes/{$id}");
		}

		view('pages/notes/edit', [
			'note' => Note::find($id),
			'folders' => Folder::getUserFolders(),
			'errors' => $validator->getErrors(),
			'fields' => $fields,
		]);
	}

	public function destroy(int $id)
	{
		$note = Note::find($id);

		if ($note->destroy()) {
			Session::notify('Note was deleted!', 'success');
			redirect();
		}

		redirect();
	}

	public function before(string $action, array $params = []): bool
	{
		if (!Session::check()) {
			redirect('login');
		}

		return parent::before($action);
	}
}
