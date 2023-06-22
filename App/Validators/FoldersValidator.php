<?php

namespace App\Validators;

use App\Validators\BaseValidator;

class FoldersValidator extends BaseValidator
{
	protected array $rules = [
		'title' => [
			'required' => true,
			'min' => 3,
			'max' => 255,
		],
	];

	protected array $errorMessages = [
		'title' => [
			'required' => 'Title is required',
			'min' => 'Title must be at least 3 characters',
			'max' => 'Title must be less than 255 characters',
		]
	];

	protected array $sqlErrorCodeMessages = [
		'1062' => 'Folder with this title already exists',
	];
}
