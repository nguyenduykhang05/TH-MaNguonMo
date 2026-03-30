<?php
class OrderModel {
    private $pdo;

    public function __construct() {
        $host = 'localhost';
        $dbname = 'my_store';
        $username = 'root';
        $password = '';
        $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function createOrder($name, $phone, $address, $totalAmount) {
        $stmt = $this->pdo->prepare("INSERT INTO orders (customer_name, customer_phone, customer_address, total_amount) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $phone, $address, $totalAmount]);
        return $this->pdo->lastInsertId();
    }

    public function createOrderDetail($orderId, $productId, $quantity, $price) {
        $stmt = $this->pdo->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$orderId, $productId, $quantity, $price]);
    }
}
