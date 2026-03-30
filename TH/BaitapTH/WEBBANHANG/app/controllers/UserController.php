<?php
require_once 'app/models/UserModel.php';
require_once 'app/helpers/SessionHelper.php';

class UserController {
    public function __construct() {
        SessionHelper::init();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = UserModel::getUserByUsernameOrEmail($username);

            if (!$user) {
                $error = "Tài khoản không tồn tại! Vui lòng kiểm tra lại.";
                require_once 'app/views/user/login.php';
                return;
            }

            if (password_verify($password, $user['password'])) {
                SessionHelper::set('user_id', $user['id']);
                SessionHelper::set('username', $user['username']);
                SessionHelper::set('role', $user['role']);
                // Redirect based on role
                if ($user['role'] === 'admin') {
                    header('Location: ' . BASE_URL . '/Admin/dashboard');
                } else {
                    header('Location: ' . BASE_URL . '/Product/list');
                }
                exit;
            } else {
                $error = "Mật khẩu bạn nhập không chính xác!";
                require_once 'app/views/user/login.php';
            }
        } else {
            require_once 'app/views/user/login.php';
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $email = $_POST['email'] ?? '';

            if ($password !== $confirm_password) {
                $error = "Mật khẩu xác nhận không khớp!";
                require_once 'app/views/user/register.php';
                return;
            }

            $newUserId = UserModel::register($username, $password, $email);
            if ($newUserId) {
                // Auto login user after successful registration
                $user = UserModel::getUserById($newUserId);
                SessionHelper::set('user_id', $user['id']);
                SessionHelper::set('username', $user['username']);
                SessionHelper::set('role', $user['role']);
                
                header('Location: ' . BASE_URL . '/Product/list?registered=true');
                exit;
            } else {
                $error = "Tên đăng nhập hoặc email đã tồn tại!";
                require_once 'app/views/user/register.php';
            }
        } else {
            require_once 'app/views/user/register.php';
        }
    }

    public function apiLogin() {
        header('Content-Type: application/json; charset=utf-8');
        $data = json_decode(file_get_contents("php://input"), true);
        
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        $user = UserModel::getUserByUsernameOrEmail($username);
        
        if ($user && password_verify($password, $user['password'])) {
            // Thiết lập Session để Header (Server-side) nhận diện được người dùng
            require_once 'app/helpers/SessionHelper.php';
            SessionHelper::init();
            SessionHelper::set('user_id', $user['id']);
            SessionHelper::set('username', $user['username']);
            SessionHelper::set('role', $user['role']);

            require_once 'app/utils/JWTHandler.php';
            $jwtHandler = new JWTHandler();
            $token = $jwtHandler->encode([
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ]);
            
            echo json_encode([
                'token' => $token,
                'user' => [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role']
                ]
            ]);
        } else {
            http_response_code(401);
            echo json_encode(['message' => 'Tên đăng nhập hoặc mật khẩu không đúng']);
        }
        exit;
    }

    public function logout() {
        SessionHelper::destroy();
        header('Location: ' . BASE_URL . '/Product/list');
        exit;
    }
}
?>
