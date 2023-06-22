<?php

namespace App\Validators;

use App\Helpers\Session;
use App\Models\Folder;

class NotesValidator extends BaseValidator
{
	const REQUEST_RULES = [
		'folder_id' => FILTER_VALIDATE_INT,
		'title' => [
			'filter' => 'is_string',
			'flags' => FILTER_CALLBACK
		],
		'content' => [
			'filter' => 'is_string',
			'flags' => FILTER_CALLBACK
		],
		'users' => [
			'filter' => FILTER_VALIDATE_INT,
			'flags' => FILTER_REQUIRE_ARRAY,
		],
		'pinned' => FILTER_VALIDATE_BOOL,
		'completed' => FILTER_VALIDATE_BOOL,
	];

	protected array $rules = [
		'title' => [
			'required' => true,
			'min' => 3,
			'max' => 255,
		],
		'folder_id' => [
			'required' => true,
		],
		'content' => [
			'required' => true,
			'min' => 3,
			'max' => 10000,
		]
	];

	protected array $errorMessages = [
		'title' => [
			'required' => 'Title is required',
			'min' => 'Title must be at least 3 characters',
			'max' => 'Title must be less than 255 characters',
		],
		'folder_id' => [
			'required' => 'Folder is required',
		],
		'content' => [
			'required' => 'Content is required',
			'min' => 'Content must be at least 3 characters',
			'max' => 'Content must be less than 10000 characters',
		]
	];

	public function validateFolderId(int $folderId): bool
	{
		$result = (bool) Folder::select()
			->where('id', '=', $folderId)
			->whereIn('author_id', [Session::id(), 0])
			->get();

		if (!$result) {
			$this->setNonFieldError('Folder does not exists or does not related to the current user');
		}

		return $result;
	}

	public function validate(array $fields = []): bool
	{
		$result = [
			parent::validate($fields),
			$this->validateFolderId($fields['folder_id'])
		];

		return !in_array(false, $result);
	}
}
