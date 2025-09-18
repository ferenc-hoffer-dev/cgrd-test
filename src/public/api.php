<?php
require_once __DIR__ . '/../App/Bootstrap.php';

use App\AuthService;
use App\Controller\NewsController;
use App\Helpers\BaseHelper;
use App\Repository\NewsRepository;
use App\Service\NewsService;

header('Content-Type: application/json');
if (!BaseHelper::isUserSet()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$newsRepository = new NewsRepository($db);
$newsService = new NewsService($newsRepository);
$authService = new AuthService($db);
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
        $newsController->update((int)($input['id'] ?? 0), $input['title'] ?? '', $input['body'] ?? '');
        break;
    case 'DELETE':
        $newsController->delete((int)($input['id'] ?? 0));
        break;
    default:
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}