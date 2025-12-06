<?php
/**
 * Cart Model
 * Handles shopping cart operations
 */
class Cart_model {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Add item to cart
     */
    public function addToCart($user_id, $product_id, $quantity = 1) {
        $conn = $this->db->getConnection();
        try {
            // Check if item already in cart
            $stmt = $conn->prepare("SELECT id, quantity FROM tbl_cart WHERE user_id = ? AND product_id = ?");
            $stmt->bind_param('ii', $user_id, $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // Update quantity
                $row = $result->fetch_assoc();
                $stmt->close();
                
                $new_quantity = $row['quantity'] + $quantity;
                $cart_id = $row['id'];
                
                $stmt = $conn->prepare("UPDATE tbl_cart SET quantity = ? WHERE id = ?");
                $stmt->bind_param('ii', $new_quantity, $cart_id);
                $success = $stmt->execute();
                $stmt->close();
                
                return $success;
            } else {
                // Insert new item
                $stmt->close();
                
                $stmt = $conn->prepare("INSERT INTO tbl_cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
                $stmt->bind_param('iii', $user_id, $product_id, $quantity);
                $success = $stmt->execute();
                $stmt->close();
                
                return $success;
            }
        } catch (mysqli_sql_exception $e) {
            error_log("Add to Cart Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get cart items for user
     */
    public function getCartItems($user_id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT c.id as cart_id, c.quantity, c.created_at,
                                p.id as product_id, p.name, p.price, p.stock, p.image,
                                (c.quantity * p.price) as subtotal
                                FROM tbl_cart c
                                INNER JOIN tbl_products p ON c.product_id = p.id
                                WHERE c.user_id = ? AND p.status = 'active'
                                ORDER BY c.created_at DESC");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
        }
        $stmt->close();
        return $items;
    }

    /**
     * Update cart item quantity
     */
    public function updateQuantity($cart_id, $quantity) {
        $conn = $this->db->getConnection();
        try {
            if ($quantity <= 0) {
                return $this->removeFromCart($cart_id);
            }
            
            $stmt = $conn->prepare("UPDATE tbl_cart SET quantity = ? WHERE id = ?");
            $stmt->bind_param('ii', $quantity, $cart_id);
            $success = $stmt->execute();
            $stmt->close();
            
            return $success;
        } catch (mysqli_sql_exception $e) {
            error_log("Update Cart Quantity Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove item from cart
     */
    public function removeFromCart($cart_id) {
        $conn = $this->db->getConnection();
        try {
            $stmt = $conn->prepare("DELETE FROM tbl_cart WHERE id = ?");
            $stmt->bind_param('i', $cart_id);
            $success = $stmt->execute();
            $stmt->close();
            
            return $success;
        } catch (mysqli_sql_exception $e) {
            error_log("Remove from Cart Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Clear cart for user
     */
    public function clearCart($user_id) {
        $conn = $this->db->getConnection();
        try {
            $stmt = $conn->prepare("DELETE FROM tbl_cart WHERE user_id = ?");
            $stmt->bind_param('i', $user_id);
            $success = $stmt->execute();
            $stmt->close();
            
            return $success;
        } catch (mysqli_sql_exception $e) {
            error_log("Clear Cart Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get cart total
     */
    public function getCartTotal($user_id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT SUM(c.quantity * p.price) as total
                                FROM tbl_cart c
                                INNER JOIN tbl_products p ON c.product_id = p.id
                                WHERE c.user_id = ? AND p.status = 'active'");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $total = 0;
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $total = $row['total'] ?? 0;
        }
        $stmt->close();
        return $total;
    }

    /**
     * Get cart item count
     */
    public function getCartCount($user_id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT SUM(quantity) as count FROM tbl_cart WHERE user_id = ?");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = 0;
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $count = $row['count'] ?? 0;
        }
        $stmt->close();
        return $count;
    }
}
?>
