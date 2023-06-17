<?php
use Dotenv\Dotenv;

if (!session_id()) {
    session_start();
}

require_once dirname(__DIR__) . '/Config/constants.php';
require_once BASE_DIR . '/vendor/autoload.php';

try {
    $dotenv = Dotenv::createUnsafeImmutable(BASE_DIR);
    $dotenv->load();


    if (!preg_match('/assets/i', $_SERVER['REQUEST_URI'])) {
        \Core\Router::dispatch($_SERVER['REQUEST_URI']);
    }

} catch (Exception $exception) {
    echo "Exception: " . $exception->getMessage();
}
