<?php
require_once 'app/models/ProductModel.php';
require_once 'app/models/CategoryModel.php';
require_once 'app/helpers/SessionHelper.php';

class ProductController
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
        include 'app/views/product/list.php';
    }

    public function detail($id)
    {
        $product = ProductModel::findById($id);
        if (!$product) {
            die('Sản phẩm không tồn tại hoặc đã bị xóa.');
        }

        // Generate related products (same category)
        $relatedProducts = ProductModel::getByCategory($product->getCategoryId());
        // Simple trick to exclude current product from related list but keep max 4 items
        $relatedProducts = array_filter($relatedProducts, function($p) use ($id) {
            return $p->getID() != $id;
        });
        $relatedProducts = array_slice($relatedProducts, 0, 4);

        include 'app/views/product/detail.php';
    }

    public function add()
    {
        SessionHelper::requireAdmin();
        $categories = CategoryModel::getAll();
        include 'app/views/product/add.php';
    }

    public function edit($id)
    {
        SessionHelper::requireAdmin();
        $product = ProductModel::findById($id);
        if (!$product) {
            die('Product not found');
        }
        $categories = CategoryModel::getAll();
        include 'app/views/product/edit.php';
    }

    public function delete($id)
    {
        SessionHelper::requireAdmin();
        $deleted = ProductModel::delete($id);
        if ($deleted) {
             header('Location: ' . BASE_URL . '/Product/list');
        } else {
             die('Error deleting product');
        }
        exit();
    }
}
?>
