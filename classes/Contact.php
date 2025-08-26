<?php
require_once 'config/database.php';

class Contact {
    private $conn;
    private $table = 'contact_messages';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function saveMessage($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (name, email, phone, message, property_id, user_id, created_at) 
                  VALUES (:name, :email, :phone, :message, :property_id, :user_id, NOW())";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':message', $data['message']);
        $stmt->bindParam(':property_id', $data['property_id']);
        $stmt->bindParam(':user_id', $data['user_id']);

        return $stmt->execute();
    }

    public function getAllMessages() {
        $query = "SELECT cm.*, p.title as property_title, u.full_name as user_name 
                  FROM " . $this->table . " cm 
                  LEFT JOIN properties p ON cm.property_id = p.id 
                  LEFT JOIN users u ON cm.user_id = u.id 
                  ORDER BY cm.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMessageById($id) {
        $query = "SELECT cm.*, p.title as property_title, u.full_name as user_name 
                  FROM " . $this->table . " cm 
                  LEFT JOIN properties p ON cm.property_id = p.id 
                  LEFT JOIN users u ON cm.user_id = u.id 
                  WHERE cm.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function markAsRead($id) {
        $query = "UPDATE " . $this->table . " SET is_read = 1 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function deleteMessage($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>