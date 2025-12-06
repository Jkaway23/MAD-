<?php
/**
 * Product Model
 * Handles all database operations for products
 */
class Product_model {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Get all products with category info
     */
    public function getAllProducts($limit = null) {
        $conn = $this->db->getConnection();
        $sql = "SELECT p.*, c.name as category_name 
                FROM tbl_products p 
                LEFT JOIN tbl_categories c ON p.category_id = c.id 
                WHERE p.status = 'active'
                ORDER BY p.created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT " . (int)$limit;
        }
        
        $result = $conn->query($sql);
        $products = [];
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        return $products;
    }

    /**
     * Get product by ID
     */
    public function getProductById($id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT p.*, c.name as category_name 
                                FROM tbl_products p 
                                LEFT JOIN tbl_categories c ON p.category_id = c.id 
                                WHERE p.id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = null;
        
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
        }
        $stmt->close();
        return $product;
    }

    /**
     * Get products by category
     */
    public function getProductsByCategory($category_id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT p.*, c.name as category_name 
                                FROM tbl_products p 
                                LEFT JOIN tbl_categories c ON p.category_id = c.id 
                                WHERE p.category_id = ? AND p.status = 'active'
                                ORDER BY p.created_at DESC");
        $stmt->bind_param('i', $category_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        $stmt->close();
        return $products;
    }

    /**
     * Search products
     */
    public function searchProducts($keyword) {
        $conn = $this->db->getConnection();
        $searchTerm = '%' . $keyword . '%';
        $stmt = $conn->prepare("SELECT p.*, c.name as category_name 
                                FROM tbl_products p 
                                LEFT JOIN tbl_categories c ON p.category_id = c.id 
                                WHERE (p.name LIKE ? OR p.description LIKE ?) 
                                AND p.status = 'active'
                                ORDER BY p.created_at DESC");
        $stmt->bind_param('ss', $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        $stmt->close();
        return $products;
    }

    /**
     * Insert new product
     */
    public function insertProduct($data) {
        $conn = $this->db->getConnection();
        try {
            $stmt = $conn->prepare("INSERT INTO tbl_products (category_id, name, description, price, stock, image, status) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?)");
            
            $category_id = $data['category_id'];
            $name = $data['name'];
            $description = $data['description'] ?? '';
            $price = $data['price'];
            $stock = $data['stock'] ?? 0;
            $image = $data['image'] ?? '';
            $status = $data['status'] ?? 'active';
            
            $stmt->bind_param('issdiis', $category_id, $name, $description, $price, $stock, $image, $status);
            $success = $stmt->execute();
            $stmt->close();
            
            return $success ? $conn->insert_id : 0;
        } catch (mysqli_sql_exception $e) {
            error_log("Insert Product Error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Update product
     */
    public function updateProduct($data) {
        $conn = $this->db->getConnection();
        try {
            $stmt = $conn->prepare("UPDATE tbl_products 
                                   SET category_id = ?, name = ?, description = ?, price = ?, stock = ?, image = ?, status = ? 
                                   WHERE id = ?");
            
            $category_id = $data['category_id'];
            $name = $data['name'];
            $description = $data['description'] ?? '';
            $price = $data['price'];
            $stock = $data['stock'] ?? 0;
            $image = $data['image'] ?? '';
            $status = $data['status'] ?? 'active';
            $id = $data['id'];
            
            $stmt->bind_param('issdissi', $category_id, $name, $description, $price, $stock, $image, $status, $id);
            $success = $stmt->execute();
            $affected = $stmt->affected_rows;
            $stmt->close();
            
            return $success ? $affected : 0;
        } catch (mysqli_sql_exception $e) {
            error_log("Update Product Error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Delete product
     */
    public function deleteProduct($id) {
        $conn = $this->db->getConnection();
        try {
            $stmt = $conn->prepare("DELETE FROM tbl_products WHERE id = ?");
            $stmt->bind_param('i', $id);
            $success = $stmt->execute();
            $affected = $stmt->affected_rows;
            $stmt->close();
            
            return $success ? $affected : 0;
        } catch (mysqli_sql_exception $e) {
            error_log("Delete Product Error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Update stock
     */
    public function updateStock($product_id, $quantity) {
        $conn = $this->db->getConnection();
        try {
            $stmt = $conn->prepare("UPDATE tbl_products SET stock = stock - ? WHERE id = ? AND stock >= ?");
            $stmt->bind_param('iii', $quantity, $product_id, $quantity);
            $success = $stmt->execute();
            $affected = $stmt->affected_rows;
            $stmt->close();
            
            return $success && $affected > 0;
        } catch (mysqli_sql_exception $e) {
            error_log("Update Stock Error: " . $e->getMessage());
            return false;
        }
    }
}
?>
