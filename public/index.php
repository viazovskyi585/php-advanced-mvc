<?php
use Dotenv\Dotenv;

require_once dirname(__DIR__) . '/Config/constants.php';
require_once BASE_DIR . '/vendor/autoload.php';

use App\Models\User;
use App\Models\Folder;
use App\Models\Note;
use App\Models\SharedNote;

try {
    if (!session_id()) {
        session_start();
    }

    $dotenv = Dotenv::createUnsafeImmutable(BASE_DIR);
    $dotenv->load();


    $sNote = SharedNote::select()->get()[0];
    d($sNote);

} catch (Exception $exception) {
    echo "Exception: " . $exception->getMessage();
}
