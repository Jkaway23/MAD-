<?php
/**
 * API Controller
 * Handle API requests for Postman testing
 */
class Api extends Controller {
    
    /**
     * API Login
     * POST /api/login
     * Body: { "email": "user@example.com", "password": "password123" }
     */
    public function login() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit;
        }
        
        // Get JSON input
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($input['email']) || !isset($input['password'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Email and password required']);
            exit;
        }
        
        $loginModel = $this->model('Login_model');
        $user = $loginModel->checkLogin($input['email'], $input['password']);
        
        if ($user) {
            // Generate session token (simplified)
            $token = bin2hex(random_bytes(32));
            
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Login successful',
                'data' => [
                    'user_id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'token' => $token
                ]
            ]);
        } else {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => 'Invalid email or password'
            ]);
        }
        exit;
    }
    
    /**
     * API Register
     * POST /api/register
     * Body: { "name": "John Doe", "email": "john@example.com", "password": "password123" }
     */
    public function register() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit;
        }
        
        // Get JSON input
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($input['name']) || !isset($input['email']) || !isset($input['password'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Name, email and password required']);
            exit;
        }
        
        // Validate email
        if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid email format']);
            exit;
        }
        
        // Validate password length
        if (strlen($input['password']) < 6) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters']);
            exit;
        }
        
        $loginModel = $this->model('Login_model');
        
        // Check if email already exists
        $existing = $loginModel->getUserByEmail($input['email']);
        if ($existing) {
            http_response_code(409);
            echo json_encode(['success' => false, 'message' => 'Email already registered']);
            exit;
        }
        
        // Register user
        $result = $loginModel->register($input['email'], $input['password'], $input['name']);
        
        if ($result) {
            http_response_code(201);
            echo json_encode([
                'success' => true,
                'message' => 'Registration successful',
                'data' => [
                    'name' => $input['name'],
                    'email' => $input['email']
                ]
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Registration failed']);
        }
        exit;
    }
    
    /**
     * API Get User Profile
     * GET /api/profile/{user_id}
     */
    public function profile($user_id = null) {
        header('Content-Type: application/json');
        
        if (!$user_id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'User ID required']);
            exit;
        }
        
        $loginModel = $this->model('Login_model');
        $user = $loginModel->getUserById($user_id);
        
        if ($user) {
            // Remove password from response
            unset($user['password']);
            
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'data' => $user
            ]);
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'User not found']);
        }
        exit;
    }
    
    /**
     * API Test endpoint
     * GET /api/test
     */
    public function test() {
        header('Content-Type: application/json');
        
        echo json_encode([
            'success' => true,
            'message' => 'API is working!',
            'timestamp' => date('Y-m-d H:i:s'),
            'server' => $_SERVER['SERVER_NAME']
        ]);
        exit;
    }
    
    /**
     * API Get All Products
     * GET /api/products
     */
    public function products() {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        
        $productModel = $this->model('Product_model');
        $products = $productModel->getAllProducts();
        
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'data' => $products
        ]);
        exit;
    }
    
    /**
     * API Get Product by ID
     * GET /api/product/{id}
     */
    public function product($id = null) {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        
        if (!$id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Product ID required']);
            exit;
        }
        
        $productModel = $this->model('Product_model');
        $product = $productModel->getProductById($id);
        
        if ($product) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'data' => $product
            ]);
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Product not found']);
        }
        exit;
    }
    
    /**
     * API Get All Categories
     * GET /api/categories
     */
    public function categories() {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        
        $categoryModel = $this->model('Category_model');
        $categories = $categoryModel->getAllCategories();
        
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'data' => $categories
        ]);
        exit;
    }
    
    /**
     * API Add to Cart
     * POST /api/cart/add
     * Body: { "user_id": 1, "product_id": 1, "quantity": 2 }
     */
    public function cart_add() {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit;
        }
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($input['user_id']) || !isset($input['product_id']) || !isset($input['quantity'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'User ID, Product ID and quantity required']);
            exit;
        }
        
        $cartModel = $this->model('Cart_model');
        $result = $cartModel->addToCart($input['user_id'], $input['product_id'], $input['quantity']);
        
        if ($result) {
            http_response_code(201);
            echo json_encode([
                'success' => true,
                'message' => 'Product added to cart'
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to add to cart']);
        }
        exit;
    }
    
    /**
     * API Get Cart Items
     * GET /api/cart/{user_id}
     */
    public function cart($user_id = null) {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        
        if (!$user_id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'User ID required']);
            exit;
        }
        
        $cartModel = $this->model('Cart_model');
        $items = $cartModel->getCartItems($user_id);
        
        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'data' => [
                'items' => $items,
                'total' => $total
            ]
        ]);
        exit;
    }
    
    /**
     * API Remove from Cart
     * POST /api/cart/remove
     * Body: { "cart_id": 1, "user_id": 1 }
     */
    public function cart_remove() {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit;
        }
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($input['cart_id']) || !isset($input['user_id'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Cart ID and User ID required']);
            exit;
        }
        
        $cartModel = $this->model('Cart_model');
        $result = $cartModel->removeFromCart($input['cart_id'], $input['user_id']);
        
        if ($result) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Item removed from cart'
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to remove item']);
        }
        exit;
    }
    
    /**
     * API Checkout
     * POST /api/checkout
     * Body: { "user_id": 1, "customer_name": "John", "customer_phone": "08123", "customer_address": "Jl...", "payment_method": "Transfer" }
     */
    public function checkout() {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit;
        }
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        $required = ['user_id', 'customer_name', 'customer_phone', 'customer_address', 'payment_method'];
        foreach ($required as $field) {
            if (!isset($input[$field]) || empty($input[$field])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => ucfirst(str_replace('_', ' ', $field)) . ' required']);
                exit;
            }
        }
        
        $cartModel = $this->model('Cart_model');
        $orderModel = $this->model('Order_model');
        
        // Get cart items
        $cartItems = $cartModel->getCartItems($input['user_id']);
        
        if (empty($cartItems)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Cart is empty']);
            exit;
        }
        
        // Calculate total
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }
        
        try {
            // Create order
            $orderId = $orderModel->createOrder(
                $input['user_id'],
                $input['customer_name'],
                $input['customer_phone'],
                $input['customer_address'],
                $input['payment_method'],
                $totalAmount,
                $cartItems
            );
            
            if ($orderId) {
                // Clear cart
                $cartModel->clearCart($input['user_id']);
                
                http_response_code(201);
                echo json_encode([
                    'success' => true,
                    'message' => 'Order created successfully',
                    'data' => [
                        'order_id' => $orderId,
                        'total_amount' => $totalAmount
                    ]
                ]);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Failed to create order']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
        exit;
    }
    
    /**
     * API Get User Orders
     * GET /api/orders/{user_id}
     */
    public function orders($user_id = null) {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        
        if (!$user_id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'User ID required']);
            exit;
        }
        
        $orderModel = $this->model('Order_model');
        $orders = $orderModel->getOrdersByUser($user_id);
        
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'data' => $orders
        ]);
        exit;
    }
    
    /**
     * API Get Order Detail
     * GET /api/order/{order_id}/{user_id}
     */
    public function order($order_id = null, $user_id = null) {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        
        if (!$order_id || !$user_id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Order ID and User ID required']);
            exit;
        }
        
        $orderModel = $this->model('Order_model');
        $order = $orderModel->getOrderById($order_id, $user_id);
        
        if ($order) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'data' => $order
            ]);
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Order not found']);
        }
        exit;
    }
}
?>
