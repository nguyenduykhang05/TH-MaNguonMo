<?php
$base_dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
if ($base_dir == '/') $base_dir = '';
define('BASE_URL', $base_dir);

$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);
// Kiểm tra phần đầu tiên của URL để xác định controller
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' : 'ProductController';
// Kiểm tra phần thứ hai của URL để xác định action
$action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';
// Định tuyến các yêu cầu API
if ($controllerName === 'ApiController' && isset($url[1])) {
    // Trường hợp đặc biệt: api/user/login
    if ($url[1] === 'user' && isset($url[2]) && $url[2] === 'login') {
        require_once 'app/controllers/UserController.php';
        $controller = new UserController();
        $controller->apiLogin();
        exit;
    }

    $apiControllerName = ucfirst($url[1]) . 'ApiController';
    if (file_exists('app/controllers/' . $apiControllerName . '.php')) {
        require_once 'app/controllers/' . $apiControllerName . '.php';
        $controller = new $apiControllerName();
        
        $method = $_SERVER['REQUEST_METHOD'];
        $id = $url[2] ?? null;
        
        switch ($method) {
            case 'GET':
                $action = $id ? 'show' : 'index';
                break;
            case 'POST':
                $action = 'store';
                break;
            case 'PUT':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(['message' => 'ID is required']);
                    exit;
                }
                $action = 'update';
                break;
            case 'DELETE':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(['message' => 'ID is required']);
                    exit;
                }
                $action = 'destroy';
                break;
            default:
                http_response_code(405);
                echo json_encode(['message' => 'Method Not Allowed']);
                exit;
        }
        
        if (method_exists($controller, $action)) {
            if ($id) {
                call_user_func_array([$controller, $action], [$id]);
            } else {
                call_user_func_array([$controller, $action], []);
            }
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Action not found']);
        }
        exit;
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'Controller not found']);
        exit;
    }
}

// Kiểm tra xem controller và action có tồn tại không
if (!file_exists('app/controllers/' . $controllerName . '.php')) {
// Xử lý không tìm thấy controller
die('Controller not found');
}
require_once 'app/controllers/' . $controllerName . '.php';
$controller = new $controllerName();
if (!method_exists($controller, $action)) {
// Xử lý không tìm thấy action
die('Action not found');
}
// Gọi action với các tham số còn lại (nếu có)
call_user_func_array([$controller, $action], array_slice($url, 2));
