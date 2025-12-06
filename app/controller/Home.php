<?php
/**
 * Home Controller
 * Handles home page display for online shop
 */
class Home extends Controller {
    
    /**
     * Display home page - Landing page for online shop
     */
    public function index() {
        $productModel = $this->model('Product_model');
        $categoryModel = $this->model('Category_model');
        
        $data['title'] = 'AIMVC Store - Belanja Online Terpercaya';
        $data['featured_products'] = $productModel->getAllProducts(8); // 8 featured products
        $data['categories'] = $categoryModel->getAllCategories();
        
        // Cart count for navbar
        $data['cart_count'] = 0;
        if (isset($_SESSION['user_id'])) {
            $cartModel = $this->model('Cart_model');
            $data['cart_count'] = $cartModel->getCartCount($_SESSION['user_id']);
        }
        
        $this->view('home/index', $data);
    }
}
?>
