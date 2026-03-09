<?php
namespace App\Models;

class Product {
    private $connection;

    public function __construct() {
        $this->connection = new \mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->connection->connect_error) die("Kết nối thất bại: " . $this->connection->connect_error);
        $this->connection->set_charset("utf8mb4");
    }

    public function getCategories() {
        return $this->connection->query("SELECT * FROM categories")->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductById($id) { 
        return $this->connection->query("SELECT * FROM products WHERE id = " . intval($id))->fetch_assoc();
    }

    public function create($data) {
    
    $sql = "INSERT INTO products (name, image, price, quantity, status, id_category) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $this->connection->prepare($sql);
    
    $stmt->bind_param("ssdiis", 
        $data['name'], 
        $data['image'], 
        $data['price'], 
        $data['quantity'], 
        $data['status'], 
        $data['id_category']
    );
    return $stmt->execute();
    }

    public function update($id, $data) {
        $sql = "UPDATE products SET name=?, image=?, price=?, quantity=?, status=?, id_category=? WHERE id=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ssdiisi", $data['name'], $data['image'], $data['price'], $data['quantity'], $data['status'], $data['id_category'], $id);
        return $stmt->execute();
    }

    public function delete($id) {
        return $this->connection->query("DELETE FROM products WHERE id = " . intval($id));
    }

    public function getTotalProducts($keyword = '', $categoryId = 0) {
        $sql = "SELECT COUNT(*) as total FROM products WHERE 1=1";
        if (!empty($keyword)) { $k = $this->connection->real_escape_string($keyword); $sql .= " AND name LIKE '%$k%'"; }
        if ($categoryId > 0) $sql .= " AND id_category = " . intval($categoryId);
        return (int)$this->connection->query($sql)->fetch_assoc()['total'];
    }

    public function getProductsPaginated($keyword = '', $categoryId = 0, $limit = 10, $offset = 0) {
        $sql = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.id_category = c.id WHERE 1=1"; 
        if (!empty($keyword)) { $k = $this->connection->real_escape_string($keyword); $sql .= " AND p.name LIKE '%$k%'"; }
        if ($categoryId > 0) $sql .= " AND p.id_category = " . intval($categoryId);
        $sql .= " ORDER BY p.id DESC LIMIT $limit OFFSET $offset";
        return $this->connection->query($sql)->fetch_all(MYSQLI_ASSOC);
    }
}