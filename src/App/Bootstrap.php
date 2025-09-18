<?php

namespace App;

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/News.php';
require_once __DIR__ . '/Traits/JsonResponseTrait.php';
require_once __DIR__ . '/Helpers/BaseHelper.php';
foreach (glob(__DIR__ . '/Controller/*.php') as $file) {
    require_once $file;
}
foreach (glob(__DIR__ . '/Service/*.php') as $file) {
    require_once $file;
}
foreach (glob(__DIR__ . '/Repository/*.php') as $file) {
    require_once $file;
}

//use RecursiveDirectoryIterator;
//use RecursiveIteratorIterator;

//$directory = __DIR__;
//
//$iterator = new RecursiveIteratorIterator(
//    new RecursiveDirectoryIterator($directory)
//);
//
//foreach ($iterator as $file) {
//    if ($file->isFile() && $file->getExtension() === 'php') {
//        require_once $file->getPathname();
//    }
//}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use App\Database;

$db = (new Database())->getConnection();
