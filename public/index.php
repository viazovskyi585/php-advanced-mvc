<?php
use Dotenv\Dotenv;

require_once dirname(__DIR__) . '/Config/constants.php';
require_once BASE_DIR . '/vendor/autoload.php';

use App\Models\Folder;
use App\Models\Note;

try {
    if (!session_id()) {
        session_start();
    }

    $dotenv = Dotenv::createUnsafeImmutable(BASE_DIR);
    $dotenv->load();


    $users = Note::select()->get();

    d($users);

} catch (Exception $exception) {
    echo "Exception: " . $exception->getMessage();
}
