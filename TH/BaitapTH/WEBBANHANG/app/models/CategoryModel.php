<?php
require_once 'app/config/database.php';

class CategoryModel
{
    private $id;
    private $name;
    private $description;

    public function __construct($id = null, $name = '', $description = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getDescription() { return $this->description; }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description
        ];
    }

    public static function getAll()
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM category");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $categories = [];
        foreach ($results as $row) {
            $categories[] = new CategoryModel($row['id'], $row['name'], $row['description']);
        }
        return $categories;
    }

    public static function findById($id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM category WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new CategoryModel($row['id'], $row['name'], $row['description']);
        }
        return null;
    }

    public static function create($name, $description)
    {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO category (name, description) VALUES (:name, :description)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        return $stmt->execute();
    }

    public static function update($id, $name, $description)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE category SET name = :name, description = :description WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        return $stmt->execute();
    }

    public static function delete($id)
    {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM category WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
