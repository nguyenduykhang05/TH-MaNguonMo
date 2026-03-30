<?php
require_once 'app/config/database.php';
require_once 'app/models/ProductModel.php';

class ProductApiController
{
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

    public function index()
    {
        if (!$this->authenticate()) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }
        header('Content-Type: application/json; charset=utf-8');
        $products = ProductModel::getAll();
        $productsArray = array_map(function($product) {
            return $product->toArray();
        }, $products);
        echo json_encode($productsArray);
    }

    public function show($id)
    {
        if (!$this->authenticate()) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }
        header('Content-Type: application/json; charset=utf-8');
        $product = ProductModel::findById($id);
        if ($product) {
            echo json_encode($product->toArray());
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Product not found']);
        }
    }

    public function store()
    {
        if (!$this->authenticate()) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }
        header('Content-Type: application/json; charset=utf-8');
        $data = json_decode(file_get_contents("php://input"), true);
        
        $name = $data['name'] ?? '';
        $description = $data['description'] ?? '';
        $price = $data['price'] ?? '';
        $categoryId = $data['category_id'] ?? null;
        $image = $data['image'] ?? '';

        $errors = [];
        if (empty($name)) $errors[] = 'Tên sản phẩm không được để trống.';
        if (!is_numeric($price) || $price <= 0) $errors[] = 'Giá sản phẩm không hợp lệ.';
        if (empty($categoryId)) $errors[] = 'Vui lòng chọn danh mục.';

        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode(['errors' => $errors]);
            return;
        }

        $result = ProductModel::create($name, $description, $price, $image, $categoryId);
        if ($result) {
            http_response_code(201);
            echo json_encode(['message' => 'Product created successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Product creation failed']);
        }
    }

    public function update($id)
    {
        if (!$this->authenticate()) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }
        header('Content-Type: application/json; charset=utf-8');
        $data = json_decode(file_get_contents("php://input"), true);
        
        $name = $data['name'] ?? '';
        $description = $data['description'] ?? '';
        $price = $data['price'] ?? '';
        $categoryId = $data['category_id'] ?? null;
        $image = $data['image'] ?? '';

        $result = ProductModel::update($id, $name, $description, $price, $image, $categoryId);
        if ($result) {
            echo json_encode(['message' => 'Product updated successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Product update failed']);
        }
    }

    public function destroy($id)
    {
        if (!$this->authenticate()) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }
        header('Content-Type: application/json; charset=utf-8');
        $result = ProductModel::delete($id);
        if ($result) {
            echo json_encode(['message' => 'Product deleted successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Product deletion failed']);
        }
    }
}
?>
