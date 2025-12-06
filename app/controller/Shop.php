<?php
/**
 * Shop Controller
 * Public-facing shop interface
 */
class Shop extends Controller {
    
    public function __construct() {
        // No auth required for viewing products
    }
    
    /**
     * Shop homepage - product listing
     */
    public function index($category_id = null) {
        $productModel = $this->model('Product_model');
        $categoryModel = $this->model('Category_model');
        
        // Get categories for sidebar
        $data['categories'] = $categoryModel->getCategoriesWithCount();
        
        // Get products
        if ($category_id) {
            $data['products'] = $productModel->getProductsByCategory($category_id);
            $data['active_category'] = $categoryModel->getCategoryById($category_id);
        } else {
            $data['products'] = $productModel->getAllProducts();
            $data['active_category'] = null;
        }
        
        // Cart count for navbar
        $data['cart_count'] = 0;
        if (isset($_SESSION['user_id'])) {
            $cartModel = $this->model('Cart_model');
            $data['cart_count'] = $cartModel->getCartCount($_SESSION['user_id']);
        }
        
        $data['title'] = 'Shop - AIMVC Store';
        $this->view('shop/index', $data);
    }
    
    /**
     * Product detail page
     */
    public function detail($id) {
        $productModel = $this->model('Product_model');
        $product = $productModel->getProductById($id);
        
        if (!$product) {
            header('Location: ' . BASEURL . '/errors/error_404');
            exit;
        }
        
        $data['product'] = $product;
        $data['title'] = $product['name'] . ' - AIMVC Store';
        
        // Related products
        $data['related_products'] = $productModel->getProductsByCategory($product['category_id']);
        
        // Cart count
        $data['cart_count'] = 0;
        if (isset($_SESSION['user_id'])) {
            $cartModel = $this->model('Cart_model');
            $data['cart_count'] = $cartModel->getCartCount($_SESSION['user_id']);
        }
        
        $this->view('shop/detail', $data);
    }
    
    /**
     * Search products
     */
    public function search() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $keyword = $_POST['keyword'] ?? '';
            
            $productModel = $this->model('Product_model');
            $categoryModel = $this->model('Category_model');
            
            $data['products'] = $productModel->searchProducts($keyword);
            $data['categories'] = $categoryModel->getCategoriesWithCount();
            $data['search_keyword'] = $keyword;
            $data['active_category'] = null;
            
            // Cart count
            $data['cart_count'] = 0;
            if (isset($_SESSION['user_id'])) {
                $cartModel = $this->model('Cart_model');
                $data['cart_count'] = $cartModel->getCartCount($_SESSION['user_id']);
            }
            
            $data['title'] = 'Search: ' . $keyword . ' - AIMVC Store';
            $this->view('shop/index', $data);
        } else {
            header('Location: ' . BASEURL . '/shop');
            exit;
        }
    }
    
    /**
     * Add to cart
     */
    public function addToCart($product_id) {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash_message'] = 'Silakan login terlebih dahulu';
            $_SESSION['flash_type'] = 'warning';
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $quantity = $_POST['quantity'] ?? 1;
            $quantity = max(1, intval($quantity));
            
            $cartModel = $this->model('Cart_model');
            $success = $cartModel->addToCart($_SESSION['user_id'], $product_id, $quantity);
            
            if ($success) {
                $_SESSION['flash_message'] = 'Produk berhasil ditambahkan ke keranjang';
                $_SESSION['flash_type'] = 'success';
            } else {
                $_SESSION['flash_message'] = 'Gagal menambahkan produk ke keranjang';
                $_SESSION['flash_type'] = 'danger';
            }
            
            header('Location: ' . BASEURL . '/shop/cart');
            exit;
        }
        
        header('Location: ' . BASEURL . '/shop');
        exit;
    }
    
    /**
     * View cart
     */
    public function cart() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash_message'] = 'Silakan login terlebih dahulu';
            $_SESSION['flash_type'] = 'warning';
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
        
        $cartModel = $this->model('Cart_model');
        
        $data['cart_items'] = $cartModel->getCartItems($_SESSION['user_id']);
        $data['cart_total'] = $cartModel->getCartTotal($_SESSION['user_id']);
        $data['cart_count'] = $cartModel->getCartCount($_SESSION['user_id']);
        $data['title'] = 'Keranjang Belanja - AIMVC Store';
        
        $this->view('shop/cart', $data);
    }
    
    /**
     * Update cart quantity
     */
    public function updateCart() {
        if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Location: ' . BASEURL . '/shop');
            exit;
        }
        
        $cart_id = $_POST['cart_id'] ?? 0;
        $quantity = $_POST['quantity'] ?? 1;
        $quantity = max(1, intval($quantity));
        
        $cartModel = $this->model('Cart_model');
        $success = $cartModel->updateQuantity($cart_id, $quantity);
        
        if ($success) {
            $_SESSION['flash_message'] = 'Keranjang berhasil diupdate';
            $_SESSION['flash_type'] = 'success';
        } else {
            $_SESSION['flash_message'] = 'Gagal mengupdate keranjang';
            $_SESSION['flash_type'] = 'danger';
        }
        
        header('Location: ' . BASEURL . '/shop/cart');
        exit;
    }
    
    /**
     * Remove from cart
     */
    public function removeFromCart($cart_id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/shop');
            exit;
        }
        
        $cartModel = $this->model('Cart_model');
        $success = $cartModel->removeFromCart($cart_id);
        
        if ($success) {
            $_SESSION['flash_message'] = 'Produk berhasil dihapus dari keranjang';
            $_SESSION['flash_type'] = 'success';
        } else {
            $_SESSION['flash_message'] = 'Gagal menghapus produk';
            $_SESSION['flash_type'] = 'danger';
        }
        
        header('Location: ' . BASEURL . '/shop/cart');
        exit;
    }
    
    /**
     * Checkout page
     */
    public function checkout() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash_message'] = 'Silakan login terlebih dahulu';
            $_SESSION['flash_type'] = 'warning';
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
        
        $cartModel = $this->model('Cart_model');
        $cart_items = $cartModel->getCartItems($_SESSION['user_id']);
        
        if (empty($cart_items)) {
            $_SESSION['flash_message'] = 'Keranjang belanja kosong';
            $_SESSION['flash_type'] = 'warning';
            header('Location: ' . BASEURL . '/shop');
            exit;
        }
        
        $data['cart_items'] = $cart_items;
        $data['cart_total'] = $cartModel->getCartTotal($_SESSION['user_id']);
        $data['cart_count'] = $cartModel->getCartCount($_SESSION['user_id']);
        $data['title'] = 'Checkout - AIMVC Store';
        
        $this->view('shop/checkout', $data);
    }
    
    /**
     * Process checkout
     */
    public function processCheckout() {
        if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Location: ' . BASEURL . '/shop');
            exit;
        }
        
        $shipping_address = $_POST['shipping_address'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $payment_method = $_POST['payment_method'] ?? 'cod';
        
        if (empty($shipping_address) || empty($phone)) {
            $_SESSION['flash_message'] = 'Alamat pengiriman dan nomor telepon wajib diisi';
            $_SESSION['flash_type'] = 'danger';
            header('Location: ' . BASEURL . '/shop/checkout');
            exit;
        }
        
        $orderModel = $this->model('Order_model');
        $result = $orderModel->createOrder($_SESSION['user_id'], $shipping_address, $phone, $payment_method);
        
        if ($result['success']) {
            $_SESSION['flash_message'] = 'Pesanan berhasil dibuat! Nomor order: ' . $result['order_number'];
            $_SESSION['flash_type'] = 'success';
            header('Location: ' . BASEURL . '/shop/orderSuccess/' . $result['order_id']);
        } else {
            $_SESSION['flash_message'] = $result['message'];
            $_SESSION['flash_type'] = 'danger';
            header('Location: ' . BASEURL . '/shop/checkout');
        }
        exit;
    }
    
    /**
     * Order success page
     */
    public function orderSuccess($order_id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/shop');
            exit;
        }
        
        $orderModel = $this->model('Order_model');
        $order = $orderModel->getOrderById($order_id);
        
        if (!$order || $order['user_id'] != $_SESSION['user_id']) {
            header('Location: ' . BASEURL . '/shop');
            exit;
        }
        
        $data['order'] = $order;
        $data['order_items'] = $orderModel->getOrderItems($order_id);
        $data['cart_count'] = 0;
        $data['title'] = 'Pesanan Berhasil - AIMVC Store';
        
        $this->view('shop/order_success', $data);
    }
    
    /**
     * My orders
     */
    public function myOrders() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash_message'] = 'Silakan login terlebih dahulu';
            $_SESSION['flash_type'] = 'warning';
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
        
        $orderModel = $this->model('Order_model');
        
        $data['orders'] = $orderModel->getUserOrders($_SESSION['user_id']);
        $data['cart_count'] = 0;
        
        $cartModel = $this->model('Cart_model');
        $data['cart_count'] = $cartModel->getCartCount($_SESSION['user_id']);
        
        $data['title'] = 'Pesanan Saya - AIMVC Store';
        
        $this->view('shop/my_orders', $data);
    }
    
    /**
     * Order detail
     */
    public function orderDetail($order_id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/shop');
            exit;
        }
        
        $orderModel = $this->model('Order_model');
        $order = $orderModel->getOrderById($order_id);
        
        if (!$order || $order['user_id'] != $_SESSION['user_id']) {
            header('Location: ' . BASEURL . '/shop');
            exit;
        }
        
        $data['order'] = $order;
        $data['order_items'] = $orderModel->getOrderItems($order_id);
        
        $cartModel = $this->model('Cart_model');
        $data['cart_count'] = $cartModel->getCartCount($_SESSION['user_id']);
        
        $data['title'] = 'Detail Pesanan - AIMVC Store';
        
        $this->view('shop/order_detail', $data);
    }
}
?>
