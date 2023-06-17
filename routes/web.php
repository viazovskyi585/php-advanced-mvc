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
