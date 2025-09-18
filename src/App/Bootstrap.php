<?php

namespace App;

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Auth.php';
require_once __DIR__ . '/News.php';
require_once __DIR__ . '/Traits/JsonResponseTrait.php';
foreach (glob(__DIR__ . '/Controller/*.php') as $file) {
    require_once $file;
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use App\Database;

$db = (new Database())->getConnection();
