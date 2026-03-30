<?php
$base_dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
if ($base_dir == '/') $base_dir = '';
define('BASE_URL', $base_dir);

require_once 'app/config/database.php';

try {
    $sql = file_get_contents('database.sql');
    $conn->exec($sql);
    echo "<h1>Tạo/Cập nhật CSDL thành công!</h1>";
    echo "<p>Bảng Users đã được tạo.</p>";
    echo "<a href='" . BASE_URL . "/User/login'>Đến trang Đăng nhập</a>";
} catch (PDOException $e) {
    echo "<h1>Lỗi khi cập nhật CSDL:</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?>
