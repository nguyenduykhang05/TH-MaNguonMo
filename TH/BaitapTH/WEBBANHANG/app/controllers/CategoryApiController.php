<?php
require_once 'app/config/database.php';
require_once 'app/models/CategoryModel.php';

class CategoryApiController
{
    public function index()
    {
        if (!$this->authenticate()) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }
        header('Content-Type: application/json; charset=utf-8');
        $categories = CategoryModel::getAll();
        $categoriesArray = array_map(function($category) {
            return $category->toArray();
        }, $categories);
        echo json_encode($categoriesArray);
    }

    private function authenticate()
    {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
            $arr = explode(" ", $authHeader);
            $jwt = $arr[1] ?? null;
            if ($jwt) {
                require_once 'app/utils/JWTHandler.php';
                $jwtHandler = new JWTHandler();
                $decoded = $jwtHandler->decode($jwt);
                return $decoded ? true : false;
            }
        }
        return false;
    }
}
?>
