<?php
require_once __DIR__ . '/../App/Bootstrap.php';

use App\Auth;

Auth::logout();
header('Location: /');
exit;
