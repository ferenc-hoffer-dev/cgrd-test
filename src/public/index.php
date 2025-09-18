<?php
require_once __DIR__ . '/../App/Bootstrap.php';

use App\AuthService;
use App\Controller\AuthController;
use App\Controller\NewsController;
use App\Repository\NewsRepository;
use App\Service\NewsService;

$newsRepository = new NewsRepository($db);
$newsService = new NewsService($newsRepository);
$authService = new AuthService($db);
$newsController = new NewsController($newsService, $authService);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case '/':
        $authService = new AuthService($db);
        $authController = new AuthController($authService);
        $authController->handle();
        break;
    case '/news':
        $newsController->handle();
        break;
    default:
        http_response_code(404);
        echo "404 - Not Found";
}
