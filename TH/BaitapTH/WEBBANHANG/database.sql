-- Tạo cơ sở dữ liệu và sử dụng nó
CREATE DATABASE IF NOT EXISTS my_store;
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
-- Chèn dữ liệu vào bảng category
INSERT INTO category (name, description) VALUES
('Điện thoại', 'Danh mục các loại điện thoại'),
('Laptop', 'Danh mục các loại laptop'),
('Máy tính bảng', 'Danh mục các loại máy tính bảng'),
('Phụ kiện', 'Danh mục phụ kiện điện tử'),
('Thiết bị âm thanh', 'Danh mục loa, tai nghe, micro');

-- Tạo bảng người dùng
CREATE TABLE IF NOT EXISTS users (
id INT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(50) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL,
email VARCHAR(100) NOT NULL UNIQUE,
role ENUM('user', 'admin') DEFAULT 'user',
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);