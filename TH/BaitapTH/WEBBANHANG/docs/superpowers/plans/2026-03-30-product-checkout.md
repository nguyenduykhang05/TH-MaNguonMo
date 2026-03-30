# Product Details and Checkout Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Implement the Product Details page layout and the Shopping Cart Checkout process with DB storage.

**Architecture:** Create an `OrderModel` for DB operations. Update `ProductController.php` for details view, and `CartController.php` to handle checkout submissions. We use vanilla PHP data structures.

**Tech Stack:** PHP (Vanilla MVC), MySQL (PDO), HTML/CSS.

---

### Task 1: Component OrderModel and Setup

**Files:**
- Create: `app/models/OrderModel.php`
- Create: `setup_orders.php`
- Create: `tests/test_ordermodel.php`

- [ ] **Step 1: Write the failing test**

```php
<?php
// tests/test_ordermodel.php
require_once 'app/models/OrderModel.php';
$model = new OrderModel();
echo "OrderModel exists.\n";
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php tests/test_ordermodel.php`
Expected: FAIL (Cannot open file)

- [ ] **Step 3: Write minimal implementation**

Create `app/models/OrderModel.php`:
```php
<?php
class OrderModel {
    private $pdo;
    public function __construct() {
        // connect to DB
        $host = 'localhost';
        $dbname = 'my_store';
        $username = 'root'; // default xampp
        $password = '';
        $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    }
}
```

Create `setup_orders.php` to execute raw SQL that creates `orders` and `order_details` tables.

- [ ] **Step 4: Run test to verify it passes**

Run: `php tests/test_ordermodel.php`
Expected: "OrderModel exists."

- [ ] **Step 5: Commit**

```bash
git add app/models/OrderModel.php setup_orders.php tests/test_ordermodel.php
git commit -m "feat: Order model and tables setup"
```

### Task 2: Product Detail Integration

**Files:**
- Modify: `app/controllers/ProductController.php`
- Create: `app/views/product/detail.php`

- [ ] **Step 1: Write the failing test**

```php
<?php
// tests/test_product_detail.php
require_once 'app/controllers/ProductController.php';
$c = new ProductController();
if (method_exists($c, 'detail')) { echo "Detail exists\n"; } else { echo "No detail\n"; exit(1); }
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php tests/test_product_detail.php`
Expected: FAIL (No detail)

- [ ] **Step 3: Write minimal implementation**

In `app/controllers/ProductController.php`: Add `public function detail($id)` to fetch product by `$id` and render `app/views/product/detail.php`.

- [ ] **Step 4: Run test to verify it passes**

Run: `php tests/test_product_detail.php`
Expected: "Detail exists\n"

- [ ] **Step 5: Commit**

```bash
git add app/controllers/ProductController.php app/views/product/detail.php tests/test_product_detail.php
git commit -m "feat: add product detail view"
```

### Task 3: Cart Checkout Submission

**Files:**
- Modify: `app/controllers/CartController.php`
- Modify: `app/views/cart/index.php`

- [ ] **Step 1: Write the failing test**

```php
<?php
// tests/test_checkout.php
require_once 'app/controllers/CartController.php';
$c = new CartController();
if (method_exists($c, 'checkout')) { echo "Checkout exists\n"; } else { echo "No checkout\n"; exit(1); }
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php tests/test_checkout.php`
Expected: FAIL (No checkout)

- [ ] **Step 3: Write minimal implementation**

In `app/views/cart/index.php`, wrap items in `<form action="/?route=cart/checkout" method="POST">`.
In `app/controllers/CartController.php`, add `public function checkout()` to process POST output using `OrderModel`.

- [ ] **Step 4: Run test to verify it passes**

Run: `php tests/test_checkout.php`
Expected: "Checkout exists\n"

- [ ] **Step 5: Commit**

```bash
git add app/controllers/CartController.php app/views/cart/index.php tests/test_checkout.php
git commit -m "feat: implement cart checkout submission"
```
