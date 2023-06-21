<?php

namespace App\Controllers;

use App\Helpers\Session;
use App\Models\Folder;
use App\Models\Note;
use App\Models\User;
use App\Validators\FoldersValidator;
use Core\Controller;

class FoldersController extends Controller
{
	public function index()
	{
		$activeFolderId = Folder::$GENERAL_FOLDER_ID;
		$notes = Note::select()
			->where('author_id', '=', Session::id())
			->andWhere('folder_id', '=', 1)
			->get();

		$folders = Folder::select()
			->whereIn('author_id', [Session::id(), 0])
			->get();

		$activeFolder = findObjectById($folders, $activeFolderId);
		view('pages/dashboard', compact('notes', 'folders', 'activeFolder'));
	}

	public function show(int $id)
	{
		$notes = Note::select()
			->where('author_id', '=', Session::id())
			->andWhere('folder_id', '=', $id)
			->get();

		$folders = Folder::select()
			->whereIn('author_id', [Session::id(), 0])
			->get();

		$activeFolder = findObjectById($folders, $id);

		view('pages/dashboard', compact('notes', 'folders', 'activeFolder'));
	}

	public function create()
	{
		view('folders/create');
	}

	public function store()
	{
		$fields = filter_input_array(INPUT_POST, $_POST);
		$validator = new FoldersValidator();

		try {
			if ($validator->validate($fields) && $folderId = Folder::create(array_merge($fields, ['author_id' => Session::id()]))) {
				Session::notify('Folder created successfully', 'success');
				redirect("folders/{$folderId}");
			}
		} catch (\PDOException $e) {
			$validator->handleSqlError($e);
		}

		view('folders/create', [
			'fields' => $fields,
			'errors' => $validator->getErrors()
		]);
	}

	public function edit(int $id)
	{
		$folder = Folder::find($id);

		view('folders/edit', compact('folder'));
	}

	public function update(int $id)
	{
		$fields = filter_input_array(INPUT_POST, $_POST);
		$validator = new FoldersValidator();
		$folder = Folder::find($id);

		try {
			if ($validator->validate($fields) && $folder->update($fields)) {
				Session::notify('Folder updated successfully', 'success');
				redirect("folders/{$id}");
			}
		} catch (\PDOException $e) {
			$validator->handleSqlError($e);
		}

		view('folders/edit', [
			'folder' => $folder,
			'fields' => $fields,
			'errors' => $validator->getErrors()
		]);
	}

	public function destroy(int $id)
	{
		$folder = Folder::find($id);

		if ($folder->destroy()) {
			Session::notify('Folder deleted successfully', 'success');
			redirect();
		}

		redirectBack();
	}

	public function before(string $action, array $params = []): bool
	{
		if (!Session::check()) {
			redirect('login');
		}
		if (in_array($action, ['update', 'destroy', 'edit']) && !empty($params['id']) && Folder::isFrozen($params['id'])) {
			redirect();
		}

		return parent::before($action);
	}
}
