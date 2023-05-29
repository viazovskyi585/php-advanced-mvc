<?php
use Config\Config;
use Dotenv\Dotenv;
require_once dirname(__DIR__) . '/Config/constants.php';
require_once BASE_DIR . '/vendor/autoload.php';

try {
    if (!session_id()) {
        session_start();
    }

    $dotenv = Dotenv::createUnsafeImmutable(BASE_DIR);
    $dotenv->load();


	$host = Config::get('db.user');

	echo $host;

} catch (Exception $exception) {
    echo "Exception: " . $exception->getMessage();
}
