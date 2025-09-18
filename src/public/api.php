<?php
require_once __DIR__ . '/../App/Bootstrap.php';

require_once __DIR__ . '/../App/Controller/NewsController.php';

use App\Auth;
use App\Controller\NewsController;

header('Content-Type: application/json');

if (!Auth::check()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$newsController = new NewsController($db);

$action = $_POST['action'] ?? '';
$id     = $_POST['id'] ?? null;
$title  = $_POST['title'] ?? '';
$body   = $_POST['body'] ?? '';

switch ($action) {
    case 'create':
        $success = $newsController->create($title, $body);
        echo json_encode(['success' => $success]);
        break;

    case 'update':
        $success = $newsController->update($id, $title, $body);
        echo json_encode(['success' => $success]);
        break;

    case 'delete':
        $success = $newsController->delete($id);
        echo json_encode(['success' => $success]);
        break;

    case 'all':
        $newsController->allJson();
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Unknown action']);
}
