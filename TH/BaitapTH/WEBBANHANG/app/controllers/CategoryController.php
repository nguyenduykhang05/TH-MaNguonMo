<?php
require_once 'app/models/CategoryModel.php';
require_once 'app/helpers/SessionHelper.php';

class CategoryController
{
    public function __construct()
    {
        SessionHelper::init();
    }

    public function index()
    {
        $this->list();
    }

    public function list()
    {
        $categories = CategoryModel::getAll();
        include 'app/views/category/list.php';
    }

    public function add()
    {
        SessionHelper::requireAdmin();
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            if (empty(trim($name))) {
                $errors[] = 'Tên danh mục là bắt buộc.';
            }

            if (empty($errors)) {
                $inserted = CategoryModel::create($name, $description);
                if ($inserted) {
                    header('Location: ' . BASE_URL . '/Category/list');
                    exit();
                } else {
                    $errors[] = 'Có lỗi xảy ra khi thêm danh mục.';
                }
            }
        }
        
        include 'app/views/category/add.php';
    }

    public function edit($id)
    {
        SessionHelper::requireAdmin();
        $category = CategoryModel::findById($id);
        if (!$category) {
            die('Category not found');
        }

        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            if (empty(trim($name))) {
                $errors[] = 'Tên danh mục là bắt buộc.';
            }

            if (empty($errors)) {
                $updated = CategoryModel::update($id, $name, $description);
                if ($updated) {
                     header('Location: ' . BASE_URL . '/Category/list');
                     exit();
                } else {
                     $errors[] = 'Có lỗi xảy ra khi cập nhật danh mục.';
                }
            }
        }
        
        include 'app/views/category/edit.php';
    }

    public function delete($id)
    {
        SessionHelper::requireAdmin();
        $deleted = CategoryModel::delete($id);
        if ($deleted) {
             header('Location: ' . BASE_URL . '/Category/list');
        } else {
             die('Error deleting category');
        }
        exit();
    }
}
?>
