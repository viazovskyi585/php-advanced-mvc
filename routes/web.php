<?php

use App\Controllers\AuthController;
use Core\Router;

Router::add('login', [
	'controller' => AuthController::class,
	'action' => 'login',
	'method' => 'GET',
]);

Router::add('register', [
	'controller' => AuthController::class,
	'action' => 'register',
	'method' => 'GET',
]);

Router::add('auth/sign-up', [
	'controller' => \App\Controllers\AuthController::class,
	'action' => 'signUp',
	'method' => 'POST'
]);

Router::add('auth/sign-in', [
	'controller' => \App\Controllers\AuthController::class,
	'action' => 'signIn',
	'method' => 'POST'
]);

Router::add('auth/sign-out', [
	'controller' => \App\Controllers\AuthController::class,
	'action' => 'signOut',
	'method' => 'POST'
]);

Router::add('', [
	'controller' => \App\Controllers\FoldersController::class,
	'action' => 'index',
	'method' => 'GET'
]);

Router::add('folders/{id:\d+}', [
	'controller' => \App\Controllers\FoldersController::class,
	'action' => 'show',
	'method' => 'GET'
]);

Router::add('folders/create', [
	'controller' => \App\Controllers\FoldersController::class,
	'action' => 'create',
	'method' => 'GET'
]);

Router::add('folders/store', [
	'controller' => \App\Controllers\FoldersController::class,
	'action' => 'store',
	'method' => 'POST'
]);

Router::add('folders/{id:\d+}/edit', [
	'controller' => \App\Controllers\FoldersController::class,
	'action' => 'edit',
	'method' => 'GET'
]);

Router::add('folders/{id:\d+}/update', [
	'controller' => \App\Controllers\FoldersController::class,
	'action' => 'update',
	'method' => 'POST'
]);

Router::add('folders/{id:\d+}/destroy', [
	'controller' => \App\Controllers\FoldersController::class,
	'action' => 'destroy',
	'method' => 'POST'
]);
