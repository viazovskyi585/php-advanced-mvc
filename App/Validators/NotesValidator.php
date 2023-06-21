<?php

namespace App\Validators;


class NotesValidator extends BaseValidator
{
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
}
