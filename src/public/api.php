<?php
require_once __DIR__ . '/../App/Bootstrap.php';

use App\Controller\NewsController;
use App\Auth;

header('Content-Type: application/json');
if (!Auth::check()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$controller = new NewsController($db);
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $controller->indexJson();
        break;
    case 'POST':
        $controller->create($_POST['title'] ?? '', $_POST['body'] ?? '');
        break;
    case 'PUT':
        parse_str(file_get_contents('php://input'), $putVars);
        $controller->update((int)($putVars['id'] ?? 0), $putVars['title'] ?? '', $putVars['body'] ?? '');
        break;
    case 'DELETE':
        parse_str(file_get_contents('php://input'), $deleteVars);
        $controller->delete((int)($deleteVars['id'] ?? 0));
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        http_response_code(405);
}
