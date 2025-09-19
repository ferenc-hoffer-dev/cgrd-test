<?php
require_once __DIR__ . '/../App/init.php';

use App\Service\AuthService;
use App\Controller\NewsController;
use App\Repository\NewsRepository;
use App\Service\NewsService;
use App\Middleware\AuthMiddleware;

$authService = new AuthService($db);
$middleware = new AuthMiddleware($authService, 'api');

$middleware->handle(function () use ($db, $authService) {
    $newsRepository = new NewsRepository($db);
    $newsService = new NewsService($newsRepository);
    $newsController = new NewsController($newsService, $authService);

    $method = $_SERVER['REQUEST_METHOD'];
    parse_str(file_get_contents('php://input'), $input);

    switch ($method) {
        case 'GET':
            $newsController->indexJson();
            break;
        case 'POST':
            $newsController->create($input['title'] ?? '', $input['body'] ?? '');
            break;
        case 'PUT':
            $newsController->update(
                (int)($input['id'] ?? 0),
                $input['title'] ?? '',
                $input['body'] ?? ''
            );
            break;
        case 'DELETE':
            $newsController->delete((int)($input['id'] ?? 0));
            break;
        default:
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    }
});
