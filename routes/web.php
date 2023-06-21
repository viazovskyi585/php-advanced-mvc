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
	'controller' => \App\Controllers\HomeController::class,
	'action' => 'index',
	'method' => 'GET'
]);
