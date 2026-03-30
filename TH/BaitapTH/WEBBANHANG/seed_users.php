<?php
require_once 'app/config/database.php';

try {
    // Xóa dữ liệu cũ (tùy chọn, để tránh trùng lặp nếu chạy lại)
    $conn->exec("DELETE FROM users WHERE username IN ('admin', 'user')");

    $users = [
        [
            'username' => 'admin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'email' => 'admin@khangstore.com',
            'role' => 'admin'
        ],
        [
            'username' => 'user',
            'password' => password_hash('user123', PASSWORD_DEFAULT),
            'email' => 'user@gmail.com',
            'role' => 'user'
        ]
    ];

    $stmt = $conn->prepare("INSERT INTO users (username, password, email, role) VALUES (:username, :password, :email, :role)");

    foreach ($users as $user) {
        $stmt->execute($user);
        echo "Đã tạo tài khoản: " . $user['username'] . "\n";
    }

    echo "Sinh dữ liệu thành công!\n";

} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage() . "\n";
}
?>
