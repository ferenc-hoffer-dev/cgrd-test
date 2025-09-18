<?php
require_once __DIR__ . '/../App/Bootstrap.php';

session_destroy();
header('Location: /');
exit;
