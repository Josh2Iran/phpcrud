<?php
// SERVER ENTRY POINT (API layer) - receives HTTP, returns JSON
header('Content-Type: application/json');
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../data/UserRepository.php';
require_once __DIR__ . '/../app/UserService.php';

$trace = 'Browser -> api/users.php -> UserService -> UserRepository -> MySQL (phpcrud.tblusers)';
$method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$in = json_decode(file_get_contents('php://input'), true) ?? [];

try {
    $service = new UserService(new UserRepository(Database::connect()));
    switch ($method) {
        case 'GET':    $data = $id ? $service->get($id) : $service->list(); $code = 200; break;
        case 'POST':   $data = $service->create($in);         $code = 201; break;
        case 'PUT':    $data = $service->update((int)$id, $in);    $code = 200; break;
        case 'DELETE': $service->delete((int)$id); $data = ['deleted' => $id]; $code = 200; break;
        default: http_response_code(405); echo json_encode(['ok' => false, 'error' => 'Method not allowed']); exit;
    }
    http_response_code($code);
    echo json_encode(['ok' => true, 'method' => $method, 'trace' => $trace, 'data' => $data]);
} catch (InvalidArgumentException $e) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Server error: ' . $e->getMessage()]);
}
