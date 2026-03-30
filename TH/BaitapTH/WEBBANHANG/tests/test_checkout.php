<?php
// tests/test_checkout.php
require_once 'app/controllers/CartController.php';
$c = new CartController();
if (method_exists($c, 'checkout')) { 
    echo "Checkout exists\n"; 
} else { 
    echo "No checkout\n"; 
    exit(1); 
}
