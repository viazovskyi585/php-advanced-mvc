<?php

use App\Controllers\NoteController;
use Core\Router;

Router::add('users/{user_id:\d+}/note/{note_id:\d}', [
	'controller' => NoteController::class,
	'action' => 'index',
	'method' => 'GET',
]);

Router::add('users/{user_id:\d+}/note/{slug:\D+}/edit', [
	'controller' => NoteController::class,
	'action' => 'edit',
	'method' => 'GET',
]);
