<?php
namespace App;

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Auth.php';
require_once __DIR__ . '/News.php';

session_start();

use App\Database;

$db = (new Database())->getConnection();
