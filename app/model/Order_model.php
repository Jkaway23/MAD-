<?php
/**
 * Order Model
 * Handles order and order items operations
 */
class Order_model {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Create order from cart
     */
    public function createOrder($user_id, $shipping_address, $phone, $payment_method = 'cod') {
        $conn = $this->db->getConnection();
        
        try {
            // Start transaction
            $conn->begin_transaction();
            
            // Get cart items
            $stmt = $conn->prepare("SELECT c.product_id, c.quantity, p.name, p.price, p.stock
                                   FROM tbl_cart c
                                   INNER JOIN tbl_products p ON c.product_id = p.id
                                   WHERE c.user_id = ? AND p.status = 'active'");
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows == 0) {
                $stmt->close();
                $conn->rollback();
                return ['success' => false, 'message' => 'Keranjang kosong'];
            }
            
            $items = [];
            $total = 0;
            
            while ($row = $result->fetch_assoc()) {
                // Check stock
                if ($row['stock'] < $row['quantity']) {
                    $stmt->close();
                    $conn->rollback();
                    return ['success' => false, 'message' => 'Stok tidak mencukupi'];
                }
                
                $items[] = $row;
                $total += $row['price'] * $row['quantity'];
            }
            $stmt->close();
            
            // Create order
            $order_number = 'ORD-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $status = 'pending';
            
            $stmt = $conn->prepare("INSERT INTO tbl_orders (user_id, order_number, total_amount, status, shipping_address, phone, payment_method) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('isdssss', $user_id, $order_number, $total, $status, $shipping_address, $phone, $payment_method);
            
            if (!$stmt->execute()) {
                $stmt->close();
                $conn->rollback();
                return ['success' => false, 'message' => 'Gagal membuat order'];
            }
            
            $order_id = $conn->insert_id;
            $stmt->close();
            
            // Create order items and update stock
            $stmt = $conn->prepare("INSERT INTO tbl_order_items (order_id, product_id, product_name, quantity, price, subtotal) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt2 = $conn->prepare("UPDATE tbl_products SET stock = stock - ? WHERE id = ?");
            
            foreach ($items as $item) {
                $subtotal = $item['price'] * $item['quantity'];
                $stmt->bind_param('iisidd', $order_id, $item['product_id'], $item['name'], $item['quantity'], $item['price'], $subtotal);
                if (!$stmt->execute()) {
                    $stmt->close();
                    $stmt2->close();
                    $conn->rollback();
                    return ['success' => false, 'message' => 'Gagal menyimpan item order'];
                }
                
                $stmt2->bind_param('ii', $item['quantity'], $item['product_id']);
                $stmt2->execute();
            }
            
            $stmt->close();
            $stmt2->close();
            
            // Clear cart
            $stmt = $conn->prepare("DELETE FROM tbl_cart WHERE user_id = ?");
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $stmt->close();
            
            // Commit transaction
            $conn->commit();
            
            return ['success' => true, 'order_id' => $order_id, 'order_number' => $order_number];
            
        } catch (mysqli_sql_exception $e) {
            $conn->rollback();
            error_log("Create Order Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Terjadi kesalahan'];
        }
    }

    /**
     * Get order by ID
     */
    public function getOrderById($order_id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT o.*, u.name as user_name, u.email as user_email
                                FROM tbl_orders o
                                INNER JOIN tbl_login u ON o.user_id = u.id
                                WHERE o.id = ?");
        $stmt->bind_param('i', $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = null;
        
        if ($result->num_rows > 0) {
            $order = $result->fetch_assoc();
        }
        $stmt->close();
        return $order;
    }

    /**
     * Get user orders
     */
    public function getUserOrders($user_id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM tbl_orders 
                                WHERE user_id = ? 
                                ORDER BY created_at DESC");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $orders = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
        }
        $stmt->close();
        return $orders;
    }

    /**
     * Get all orders (admin)
     */
    public function getAllOrders() {
        $conn = $this->db->getConnection();
        $sql = "SELECT o.*, u.name as user_name, u.email as user_email
                FROM tbl_orders o
                INNER JOIN tbl_login u ON o.user_id = u.id
                ORDER BY o.created_at DESC";
        $result = $conn->query($sql);
        $orders = [];
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
        }
        return $orders;
    }

    /**
     * Get order items
     */
    public function getOrderItems($order_id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT oi.*, p.name as product_name, p.image
                                FROM tbl_order_items oi
                                INNER JOIN tbl_products p ON oi.product_id = p.id
                                WHERE oi.order_id = ?");
        $stmt->bind_param('i', $order_id);
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
     * Update order status
     */
    public function updateOrderStatus($order_id, $status) {
        $conn = $this->db->getConnection();
        try {
            $valid_statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
            if (!in_array($status, $valid_statuses)) {
                return false;
            }
            
            $stmt = $conn->prepare("UPDATE tbl_orders SET status = ? WHERE id = ?");
            $stmt->bind_param('si', $status, $order_id);
            $success = $stmt->execute();
            $stmt->close();
            
            return $success;
        } catch (mysqli_sql_exception $e) {
            error_log("Update Order Status Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Cancel order
     */
    public function cancelOrder($order_id) {
        $conn = $this->db->getConnection();
        
        try {
            $conn->begin_transaction();
            
            // Check if order can be cancelled
            $stmt = $conn->prepare("SELECT status FROM tbl_orders WHERE id = ?");
            $stmt->bind_param('i', $order_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows == 0) {
                $stmt->close();
                $conn->rollback();
                return false;
            }
            
            $order = $result->fetch_assoc();
            $stmt->close();
            
            if (in_array($order['status'], ['delivered', 'cancelled'])) {
                $conn->rollback();
                return false;
            }
            
            // Restore stock
            $stmt = $conn->prepare("SELECT product_id, quantity FROM tbl_order_items WHERE order_id = ?");
            $stmt->bind_param('i', $order_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $stmt2 = $conn->prepare("UPDATE tbl_products SET stock = stock + ? WHERE id = ?");
            while ($row = $result->fetch_assoc()) {
                $stmt2->bind_param('ii', $row['quantity'], $row['product_id']);
                $stmt2->execute();
            }
            
            $stmt->close();
            $stmt2->close();
            
            // Update order status
            $stmt = $conn->prepare("UPDATE tbl_orders SET status = 'cancelled' WHERE id = ?");
            $stmt->bind_param('i', $order_id);
            $stmt->execute();
            $stmt->close();
            
            $conn->commit();
            return true;
            
        } catch (mysqli_sql_exception $e) {
            $conn->rollback();
            error_log("Cancel Order Error: " . $e->getMessage());
            return false;
        }
    }
}
?>
