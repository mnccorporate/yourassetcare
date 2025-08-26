<?php
require_once __DIR__ . '/../config/database.php';


class Property {
    private $conn;
    private $table = 'properties';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllProperties($limit = null) {
        $query = "SELECT * FROM " . $this->table . " WHERE status = 'active' ORDER BY created_at DESC";
        if ($limit) {
            $query .= " LIMIT " . $limit;
        }
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllPropertiesForAdmin() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPropertiesByStatus($status) {
        $query = "SELECT * FROM " . $this->table . " WHERE status = :status ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPropertyStats() {
        $stats = [];
        
        // Total properties
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $stats['total'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Active properties
        $query = "SELECT COUNT(*) as active FROM " . $this->table . " WHERE status = 'active'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $stats['active'] = $stmt->fetch(PDO::FETCH_ASSOC)['active'];
        
        // Sold properties
        $query = "SELECT COUNT(*) as sold FROM " . $this->table . " WHERE status = 'sold'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $stats['sold'] = $stmt->fetch(PDO::FETCH_ASSOC)['sold'];
        
        // Average price
        $query = "SELECT AVG(price) as avg_price FROM " . $this->table . " WHERE status = 'active'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $stats['avg_price'] = $stmt->fetch(PDO::FETCH_ASSOC)['avg_price'];
        
        return $stats;
    }

    public function getPropertyById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addProperty($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (title, description, price, address, bedrooms, bathrooms, area, property_type, status, image, created_at) 
                  VALUES (:title, :description, :price, :address, :bedrooms, :bathrooms, :area, :property_type, :status, :image, NOW())";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':bedrooms', $data['bedrooms']);
        $stmt->bindParam(':bathrooms', $data['bathrooms']);
        $stmt->bindParam(':area', $data['area']);
        $stmt->bindParam(':property_type', $data['property_type']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':image', $data['image']);

        return $stmt->execute();
    }

    public function updateProperty($id, $data) {
        $query = "UPDATE " . $this->table . " 
                  SET title = :title, description = :description, price = :price, 
                      address = :address, bedrooms = :bedrooms, bathrooms = :bathrooms, 
                      area = :area, property_type = :property_type, status = :status";
        
        if (!empty($data['image'])) {
            $query .= ", image = :image";
        }
        
        $query .= " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':bedrooms', $data['bedrooms']);
        $stmt->bindParam(':bathrooms', $data['bathrooms']);
        $stmt->bindParam(':area', $data['area']);
        $stmt->bindParam(':property_type', $data['property_type']);
        $stmt->bindParam(':status', $data['status']);
        
        if (!empty($data['image'])) {
            $stmt->bindParam(':image', $data['image']);
        }

        return $stmt->execute();
    }

    public function deleteProperty($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function searchProperties($search_term) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE (title LIKE :search OR address LIKE :search OR description LIKE :search) 
                  AND status = 'active' 
                  ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $search_param = '%' . $search_term . '%';
        $stmt->bindParam(':search', $search_param);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function togglePropertyStatus($id) {
        $query = "UPDATE " . $this->table . " 
                  SET status = CASE 
                      WHEN status = 'active' THEN 'inactive' 
                      WHEN status = 'inactive' THEN 'active' 
                      ELSE status 
                  END 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getRecentProperties($limit = 5) {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>