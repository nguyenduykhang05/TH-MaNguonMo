<?php
require_once 'app/config/database.php';

class UserModel {
    public static function register($username, $password, $email) {
        global $conn;
        // Check if username or email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return false;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (:username, :password, :email)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':email', $email);
        if ($stmt->execute()) {
            return $conn->lastInsertId();
        }
        return false;
    }

    public static function getUserByUsernameOrEmail($username) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username OR email = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getUserById($id) {
        global $conn;
        $stmt = $conn->prepare("SELECT id, username, email, role FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
