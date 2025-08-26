<?php
require_once __DIR__ . '/../config/database.php';


class User {
    public $conn; // ✅ Keep only once
    private $table = 'users';

    public function __construct() {
        $database = new Database();

        $this->conn = $database->getConnection();
    }

    public function login($email, $password) {
        $query = "SELECT id, email, password, role, full_name 
                  FROM " . $this->table . " 
                  WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_name'] = $user['full_name'];
                return true;
            }
        }
        return false;
    }

    public function register($email, $password, $full_name, $role = 'user') {
        $query = "SELECT id FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return false; // Email already exists
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO " . $this->table . " (email, password, full_name, role, created_at) 
                  VALUES (:email, :password, :full_name, :role, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':role', $role);

        return $stmt->execute();
    }

    public function logout() {
        session_destroy();
    }

    public function getAllUsers() {
        $query = "SELECT id, email, full_name, role, created_at 
                  FROM " . $this->table . " 
                  ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
