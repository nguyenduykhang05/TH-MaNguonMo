<?php
// setup_my_store.php
$host = 'localhost';
$username = 'root';
$password = '';

try {
    // Connect to MySQL server without specifying a database first
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to MySQL server successfully.<br>";

    $sql = "
    -- Tạo cơ sở dữ liệu và sử dụng nó
    CREATE DATABASE IF NOT EXISTS my_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
    USE my_store;

    -- Tạo bảng danh mục sản phẩm
    CREATE TABLE IF NOT EXISTS category (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        description TEXT
    );

    -- Tạo bảng sản phẩm
    CREATE TABLE IF NOT EXISTS product (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        description TEXT,
        price DECIMAL(10,2) NOT NULL,
        image VARCHAR(255) DEFAULT NULL,
        category_id INT,
        FOREIGN KEY (category_id) REFERENCES category(id) ON DELETE CASCADE
    );

    -- Xóa dữ liệu cũ nếu có để tránh trùng lặp khi chạy lại script
    TRUNCATE TABLE product;
    SET FOREIGN_KEY_CHECKS = 0;
    TRUNCATE TABLE category;
    SET FOREIGN_KEY_CHECKS = 1;

    -- Chèn dữ liệu vào bảng category
    INSERT INTO category (name, description) VALUES
    ('Điện thoại', 'Danh mục các loại điện thoại'),
    ('Laptop', 'Danh mục các loại laptop'),
    ('Máy tính bảng', 'Danh mục các loại máy tính bảng'),
    ('Phụ kiện', 'Danh mục phụ kiện điện tử'),
    ('Thiết bị âm thanh', 'Danh mục loa, tai nghe, micro');
    ";

    $pdo->exec($sql);
    echo "Database 'my_store', tables 'category', 'product' created successfully, and sample categories inserted.<br>";
    
    // Insert some sample products
   $sampleProducts = "
INSERT INTO product (name, description, price, image, category_id) VALUES

-- Điện thoại (10)
('iPhone 15 Pro Max','Điện thoại Apple cao cấp',29990000,'https://images.unsplash.com/photo-1695048133142-1a20484d2569',1),
('iPhone 15','Điện thoại Apple mới',22990000,'https://images.unsplash.com/photo-1510557880182-3d4d3cba35a5',1),
('Samsung Galaxy S24 Ultra','Flagship Samsung',32490000,'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c',1),
('Samsung Galaxy S23','Điện thoại Samsung mạnh mẽ',19990000,'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9',1),
('Xiaomi 14 Pro','Điện thoại cấu hình cao',19990000,'https://images.unsplash.com/photo-1601784551446-20c9e07cdbdb',1),
('Xiaomi Redmi Note 13','Điện thoại giá tốt',5990000,'https://images.unsplash.com/photo-1598327105666-5b89351aff97',1),
('Oppo Find X7','Camera đẹp',17990000,'https://images.unsplash.com/photo-1580910051074-3eb694886505',1),
('Oppo Reno 11','Thiết kế đẹp',10990000,'https://images.unsplash.com/photo-1585060544812-6b45742d762f',1),
('Vivo X100 Pro','Camera ZEISS',20990000,'https://images.unsplash.com/photo-1605236453806-6ff36851218e',1),
('Realme GT 6','Hiệu năng cao',12990000,'https://images.unsplash.com/photo-1592750475338-74b7b21085ab',1),

-- Laptop (10)
('MacBook Pro M3 Max','Laptop Apple mạnh',87490000,'https://images.unsplash.com/photo-1517336714731-489689fd1ca8',2),
('MacBook Air M2','Laptop mỏng nhẹ',28990000,'https://images.unsplash.com/photo-1496181133206-80ce9b88a853',2),
('Dell XPS 15','Laptop cao cấp',45990000,'https://images.unsplash.com/photo-1587614382346-4ec70e388b28',2),
('HP Spectre x360','Laptop xoay gập',36990000,'https://images.unsplash.com/photo-1515879218367-8466d910aaa4',2),
('Lenovo ThinkPad X1 Carbon','Laptop doanh nhân',41990000,'https://images.unsplash.com/photo-1587202372775-e229f172b9d7',2),
('Asus ROG Strix G16','Laptop gaming',38990000,'https://images.unsplash.com/photo-1603302576837-37561b2e2302',2),
('Asus Zenbook 14','Laptop mỏng nhẹ',24990000,'https://images.unsplash.com/photo-1519389950473-47ba0277781c',2),
('Acer Predator Helios','Laptop gaming mạnh',35990000,'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed',2),
('MSI Katana GF66','Laptop gaming giá tốt',26990000,'https://images.unsplash.com/photo-1593642634443-44adaa06623a',2),
('HP Pavilion 15','Laptop học tập',15990000,'https://images.unsplash.com/photo-1588702547919-26089e690ecc',2),

-- Máy tính bảng (10)
('iPad Pro M2','Tablet cao cấp Apple',27990000,'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0',3),
('iPad Air 5','Tablet mạnh mẽ',18990000,'https://images.unsplash.com/photo-1585790050230-5dd28404ccb9',3),
('iPad Gen 10','Tablet phổ thông',12990000,'https://images.unsplash.com/photo-1609081219090-a6d81d3085bf',3),
('Samsung Galaxy Tab S9','Tablet Android mạnh',21990000,'https://images.unsplash.com/photo-1587614203976-365c74645e83',3),
('Samsung Galaxy Tab A9','Tablet giá rẻ',6990000,'https://images.unsplash.com/photo-1580913428735-bd3c269d6a82',3),
('Xiaomi Pad 6','Tablet hiệu năng cao',9990000,'https://images.unsplash.com/photo-1623126908029-58cb08a2b272',3),
('Huawei MatePad 11','Tablet Huawei',11990000,'https://images.unsplash.com/photo-1561154464-82e9adf32764',3),
('Lenovo Tab P11','Tablet giải trí',8990000,'https://images.unsplash.com/photo-1557821552-17105176677c',3),
('Realme Pad 2','Tablet giá tốt',6990000,'https://images.unsplash.com/photo-1551650975-87deedd944c3',3),
('Nokia T20','Tablet học tập',5990000,'https://images.unsplash.com/photo-1587614295999-6c1c13675110',3),

-- Phụ kiện (10)
('Chuột Logitech MX Master 3','Chuột không dây',2490000,'https://images.unsplash.com/photo-1527814050087-3793815479db',4),
('Chuột Logitech G502','Chuột gaming',1790000,'https://images.unsplash.com/photo-1613145993486-81e5c6d9b61c',4),
('Bàn phím Keychron K6','Bàn phím cơ',2890000,'https://images.unsplash.com/photo-1587829741301-dc798b83add3',4),
('Bàn phím Logitech K380','Bàn phím bluetooth',990000,'https://images.unsplash.com/photo-1517433456452-f9633a875f6f',4),
('Sạc nhanh Anker 65W','Củ sạc nhanh',990000,'https://images.unsplash.com/photo-1583863788434-e58a36330cf0',4),
('Sạc Apple 20W','Củ sạc iPhone',490000,'https://images.unsplash.com/photo-1580894908361-967195033215',4),
('Cáp sạc Baseus USB-C','Cáp sạc bền',190000,'https://images.unsplash.com/photo-1598327105666-5b89351aff97',4),
('Pin dự phòng Xiaomi 20000mAh','Pin dự phòng',590000,'https://images.unsplash.com/photo-1609592806596-b43bada2f50b',4),
('Đế tản nhiệt laptop','Phụ kiện laptop',350000,'https://images.unsplash.com/photo-1587202372775-e229f172b9d7',4),
('USB Sandisk 128GB','USB lưu trữ',290000,'https://images.unsplash.com/photo-1580913428735-bd3c269d6a82',4),

-- Thiết bị âm thanh (10)
('AirPods Pro 2','Tai nghe Apple chống ồn',6290000,'https://images.unsplash.com/photo-1600294037681-c80b4cb5b434',5),
('AirPods 3','Tai nghe Apple',4290000,'https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb',5),
('Sony WH-1000XM5','Tai nghe chống ồn',8990000,'https://images.unsplash.com/photo-1518441902112-fb48c0d1d9f1',5),
('Sony WF-1000XM4','Tai nghe true wireless',5990000,'https://images.unsplash.com/photo-1585386959984-a41552231658',5),
('JBL Charge 5','Loa bluetooth',3990000,'https://images.unsplash.com/photo-1585386959984-a41552231658',5),
('JBL Flip 6','Loa di động',2990000,'https://images.unsplash.com/photo-1545454675-3531b543be5d',5),
('Marshall Emberton','Loa bluetooth cao cấp',4490000,'https://images.unsplash.com/photo-1524678606370-a47ad25cb82a',5),
('Rode NT-USB','Micro thu âm',4590000,'https://images.unsplash.com/photo-1581091870627-3c7fcd998f66',5),
('HyperX QuadCast','Micro gaming',3290000,'https://images.unsplash.com/photo-1590608897129-79da98d15969',5),
('Bose SoundLink Mini','Loa Bose',4990000,'https://images.unsplash.com/photo-1496950866446-3253e1470e8e',5)

";
    
    $pdo->exec($sampleProducts);
    echo "Sample products inserted successfully.<br>";

    echo "<strong>Setup Completed! Please delete this file.</strong>";

} catch (PDOException $e) {
    die("Setup failed: " . $e->getMessage());
}
?>
