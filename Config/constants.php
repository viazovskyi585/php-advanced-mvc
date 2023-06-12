<?php

define('BASE_DIR', dirname(__DIR__));
const CONFIG_DIR = BASE_DIR . '/Config';
const VIEW_DIR = BASE_DIR . '/App/Views/';

define("SITE_URL", $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']);

const ASSETS_URI = SITE_URL . '/assets/';
