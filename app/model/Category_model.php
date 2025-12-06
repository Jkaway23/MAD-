<?php
/**
 * Category Model
 * Handles all database operations for categories
 */
class Category_model {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Get all categories
     */
    public function getAllCategories() {
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM tbl_categories ORDER BY name ASC";
        $result = $conn->query($sql);
        $categories = [];
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
        }
        return $categories;
    }

    /**
     * Get category by ID
     */
    public function getCategoryById($id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM tbl_categories WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $category = null;
        
        if ($result->num_rows > 0) {
            $category = $result->fetch_assoc();
        }
        $stmt->close();
        return $category;
    }

    /**
     * Get category with product count
     */
    public function getCategoriesWithCount() {
        $conn = $this->db->getConnection();
        $sql = "SELECT c.*, COUNT(p.id) as product_count 
                FROM tbl_categories c 
                LEFT JOIN tbl_products p ON c.id = p.category_id AND p.status = 'active'
                GROUP BY c.id 
                ORDER BY c.name ASC";
        $result = $conn->query($sql);
        $categories = [];
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
        }
        return $categories;
    }

    /**
     * Insert category
     */
    public function insertCategory($data) {
        $conn = $this->db->getConnection();
        try {
            $stmt = $conn->prepare("INSERT INTO tbl_categories (name, description) VALUES (?, ?)");
            
            $name = $data['name'];
            $description = $data['description'] ?? '';
            
            $stmt->bind_param('ss', $name, $description);
            $success = $stmt->execute();
            $stmt->close();
            
            return $success ? $conn->insert_id : 0;
        } catch (mysqli_sql_exception $e) {
            error_log("Insert Category Error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Update category
     */
    public function updateCategory($data) {
        $conn = $this->db->getConnection();
        try {
            $stmt = $conn->prepare("UPDATE tbl_categories SET name = ?, description = ? WHERE id = ?");
            
            $name = $data['name'];
            $description = $data['description'] ?? '';
            $id = $data['id'];
            
            $stmt->bind_param('ssi', $name, $description, $id);
            $success = $stmt->execute();
            $affected = $stmt->affected_rows;
            $stmt->close();
            
            return $success ? $affected : 0;
        } catch (mysqli_sql_exception $e) {
            error_log("Update Category Error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Delete category
     */
    public function deleteCategory($id) {
        $conn = $this->db->getConnection();
        try {
            // Check if category has products
            $stmt = $conn->prepare("SELECT COUNT(*) as count FROM tbl_products WHERE category_id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();
            
            if ($row['count'] > 0) {
                return -1; // Category has products
            }
            
            $stmt = $conn->prepare("DELETE FROM tbl_categories WHERE id = ?");
            $stmt->bind_param('i', $id);
            $success = $stmt->execute();
            $affected = $stmt->affected_rows;
            $stmt->close();
            
            return $success ? $affected : 0;
        } catch (mysqli_sql_exception $e) {
            error_log("Delete Category Error: " . $e->getMessage());
            return 0;
        }
    }
}
?>
