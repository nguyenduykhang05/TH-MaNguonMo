<?php
require_once 'app/models/ProductModel.php';
require_once 'app/helpers/SessionHelper.php';

class CartController
{
    public function __construct()
    {
        SessionHelper::init();
        // Require login for ALL cart actions
        SessionHelper::requireLogin();

        // Initialize cart if not exists
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function index()
    {
        $cartItems = [];
        $totalParam = 0;

        foreach ($_SESSION['cart'] as $id => $quantity) {
            $product = $this->findProductById($id);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'total' => $product->getPrice() * $quantity
                ];
                $totalParam += $product->getPrice() * $quantity;
            }
        }

        include 'app/views/cart/index.php';
    }

    public function add($id)
    {
        if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = 1;
        } else {
            $_SESSION['cart'][$id]++;
        }
        
        header('Location: ' . BASE_URL . '/Cart/index');
        exit();
    }

    public function remove($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        
        header('Location: ' . BASE_URL . '/Cart/index');
        exit();
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantities'])) {
            foreach ($_POST['quantities'] as $id => $quantity) {
                $qty = (int)$quantity;
                if ($qty > 0) {
                    $_SESSION['cart'][$id] = $qty;
                } else {
                    unset($_SESSION['cart'][$id]);
                }
            }
        }
        header('Location: ' . BASE_URL . '/Cart/index');
        exit();
    }

    public function checkout()
    {
        if (empty($_SESSION['cart'])) {
            header('Location: ' . BASE_URL . '/Cart/index');
            exit();
        }
        include 'app/views/cart/checkout.php';
    }

    public function processOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once 'app/models/OrderModel.php';
            $orderModel = new OrderModel();
            
            $name = $_POST['fullname'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $totalAmount = 0;
            
            foreach ($_SESSION['cart'] as $id => $quantity) {
                $product = $this->findProductById($id);
                if ($product) {
                    $totalAmount += $product->getPrice() * $quantity;
                }
            }

            // Create order
            $orderId = $orderModel->createOrder($name, $phone, $address, $totalAmount);
            
            // Create details
            foreach ($_SESSION['cart'] as $id => $quantity) {
                $product = $this->findProductById($id);
                if ($product) {
                    $orderModel->createOrderDetail($orderId, $id, $quantity, $product->getPrice());
                }
            }
            
            // Clear cart
            unset($_SESSION['cart']);
            
            // Redirect
            include 'app/views/cart/order_success.php';
            exit();
        }
    }

    private function findProductById($id)
    {
        return ProductModel::findById($id);
    }
}
?>

