<?php

use App\Controllers\AuthController;
use Core\Router;

Router::add('login', [
	'controller' => AuthController::class,
	'action' => 'login',
	'method' => 'GET',
]);
