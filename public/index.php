<?php
use Dotenv\Dotenv;
use Core\Db;

require_once dirname(__DIR__) . '/Config/constants.php';
require_once BASE_DIR . '/vendor/autoload.php';

try {
    if (!session_id()) {
        session_start();
    }

    $dotenv = Dotenv::createUnsafeImmutable(BASE_DIR);
    $dotenv->load();


	$pdo = Db::connect();
    var_dump($pdo);

} catch (Exception $exception) {
    echo "Exception: " . $exception->getMessage();
}
