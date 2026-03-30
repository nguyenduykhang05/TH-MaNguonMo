<?php
require 'app/models/OrderModel.php';

try {
    $host = 'localhost';
    $dbname = 'my_store';
    $username = 'root';
    $password = '';
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "
    CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        customer_name VARCHAR(255),
        customer_phone VARCHAR(50),
        customer_address TEXT,
        notes TEXT,
        total_amount DECIMAL(12,2),
        status ENUM('pending', 'completed') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    CREATE TABLE IF NOT EXISTS order_details (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT,
        product_id INT,
        quantity INT,
        price DECIMAL(12,2),
        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
        FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE
    );
    ";

    $pdo->exec($sql);
    echo "Bảng orders và order_details đã được tạo thành công.";

} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
