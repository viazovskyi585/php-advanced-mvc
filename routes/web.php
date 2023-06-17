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
