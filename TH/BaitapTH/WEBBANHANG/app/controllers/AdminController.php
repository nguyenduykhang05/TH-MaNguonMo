<?php
require_once 'app/models/ProductModel.php';
require_once 'app/models/CategoryModel.php';
require_once 'app/models/UserModel.php';
require_once 'app/helpers/SessionHelper.php';
require_once 'app/config/database.php';

class AdminController
{
    public function __construct()
    {
        SessionHelper::requireAdmin();
    }

    public function dashboard()
    {
        global $conn;

        // Stats counters
        $totalProducts   = $conn->query("SELECT COUNT(*) FROM product")->fetchColumn();
        $totalCategories = $conn->query("SELECT COUNT(*) FROM category")->fetchColumn();
        $totalUsers      = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'user'")->fetchColumn();

        // Data for Chart: Products per Category
        $stmtChart = $conn->query("SELECT c.name as label, COUNT(p.id) as value FROM category c LEFT JOIN product p ON c.id = p.category_id GROUP BY c.id");
        $chartData = $stmtChart->fetchAll(PDO::FETCH_ASSOC);

        // Recent products (5 latest)
        $stmt = $conn->query("SELECT p.*, c.name as category_name FROM product p LEFT JOIN category c ON p.category_id = c.id ORDER BY p.id DESC LIMIT 5");
        $recentProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include 'app/views/admin/dashboard.php';
    }

    public function products()
    {
        $products = ProductModel::getAll();
        include 'app/views/admin/products.php';
    }

    public function categories()
    {
        $categories = CategoryModel::getAll();
        include 'app/views/admin/categories.php';
    }

    public function users()
    {
        global $conn;
        $stmt = $conn->query("SELECT id, username, email, role FROM users ORDER BY id DESC");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include 'app/views/admin/users.php';
    }
}
?>
