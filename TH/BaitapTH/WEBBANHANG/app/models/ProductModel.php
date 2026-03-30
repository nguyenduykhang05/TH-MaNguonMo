<?php
require_once 'app/config/database.php';

class ProductModel
{
    private $ID;
    private $Name;
    private $Description;
    private $Price;
    private $Image;
    private $categoryId;
    private $categoryName;

    public function __construct($ID = null, $Name = '', $Description = '', $Price = 0, $Image = '', $categoryId = null, $categoryName = '')
    {
        $this->ID = $ID;
        $this->Name = $Name;
        $this->Description = $Description;
        $this->Price = $Price;
        $this->Image = $Image;
        $this->categoryId = $categoryId;
        $this->categoryName = $categoryName;
    }

    public function getID() { return $this->ID; }
    public function setID($ID) { $this->ID = $ID; }
    public function getName() { return $this->Name; }
    public function setName($Name) { $this->Name = $Name; }
    public function getDescription() { return $this->Description; }
    public function setDescription($Description) { $this->Description = $Description; }
    public function getPrice() { return $this->Price; }
    public function setPrice($Price) { $this->Price = $Price; }
    public function getImage() { return $this->Image; }
    public function setImage($Image) { $this->Image = $Image; }
    public function getCategoryId() { return $this->categoryId; }
    public function setCategoryId($categoryId) { $this->categoryId = $categoryId; }
    public function getCategoryName() { return $this->categoryName; }

    public function toArray()
    {
        return [
            'id' => $this->ID,
            'name' => $this->Name,
            'description' => $this->Description,
            'price' => $this->Price,
            'image' => $this->Image,
            'category_id' => $this->categoryId,
            'category_name' => $this->categoryName
        ];
    }

    public static function getAll()
    {
        global $conn;
        $stmt = $conn->prepare("SELECT p.*, c.name as category_name FROM product p LEFT JOIN category c ON p.category_id = c.id");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $products = [];
        foreach ($results as $row) {
            $products[] = new ProductModel($row['id'], $row['name'], $row['description'], $row['price'], $row['image'], $row['category_id'], $row['category_name']);
        }
        return $products;
    }

    public static function getByCategory($categoryId)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT p.*, c.name as category_name FROM product p LEFT JOIN category c ON p.category_id = c.id WHERE p.category_id = :category_id");
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $products = [];
        foreach ($results as $row) {
            $products[] = new ProductModel($row['id'], $row['name'], $row['description'], $row['price'], $row['image'], $row['category_id'], $row['category_name']);
        }
        return $products;
    }

    public static function searchByName($keyword)
    {
        global $conn;
        $searchQuery = "%" . $keyword . "%";
        $stmt = $conn->prepare("SELECT p.*, c.name as category_name FROM product p LEFT JOIN category c ON p.category_id = c.id WHERE p.name LIKE :keyword");
        $stmt->bindParam(':keyword', $searchQuery);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $products = [];
        foreach ($results as $row) {
            $products[] = new ProductModel($row['id'], $row['name'], $row['description'], $row['price'], $row['image'], $row['category_id'], $row['category_name']);
        }
        return $products;
    }

    public static function findById($id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT p.*, c.name as category_name FROM product p LEFT JOIN category c ON p.category_id = c.id WHERE p.id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new ProductModel($row['id'], $row['name'], $row['description'], $row['price'], $row['image'], $row['category_id'], $row['category_name']);
        }
        return null;
    }

    public static function create($name, $description, $price, $image, $categoryId)
    {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO product (name, description, price, image, category_id) VALUES (:name, :description, :price, :image, :category_id)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':category_id', $categoryId);
        return $stmt->execute();
    }

    public static function update($id, $name, $description, $price, $image, $categoryId)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE product SET name = :name, description = :description, price = :price, image = :image, category_id = :category_id WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':category_id', $categoryId);
        return $stmt->execute();
    }

    public static function delete($id)
    {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM product WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
