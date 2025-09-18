<?php
require_once __DIR__ . '/../App/Bootstrap.php';

use App\Controller\LoginController;
use App\Controller\NewsController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case '/':
        $controller = new LoginController($db);
        $controller->handle();
        break;
    case '/news':
        $controller = new NewsController($db);
        $controller->handle();
        break;
    default:
        http_response_code(404);
        echo "404 - Not Found";
}
