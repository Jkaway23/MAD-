<?php
/**
 * Product Controller
 * Admin product management
 */
class Product extends Controller {
    
    public function __construct() {
        // Check authentication
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash_message'] = 'Silakan login terlebih dahulu';
            $_SESSION['flash_type'] = 'warning';
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
    }
    
    /**
     * Product list (admin)
     */
    public function index() {
        $productModel = $this->model('Product_model');
        
        $data['products'] = $productModel->getAllProducts();
        $data['title'] = 'Manajemen Produk - Admin';
        
        $this->view('product/index', $data);
    }
    
    /**
     * Add product form
     */
    public function add() {
        $categoryModel = $this->model('Category_model');
        
        $data['categories'] = $categoryModel->getAllCategories();
        $data['title'] = 'Tambah Produk - Admin';
        $data['action'] = 'add';
        
        $this->view('product/form', $data);
    }
    
    /**
     * Edit product form
     */
    public function edit($id) {
        $productModel = $this->model('Product_model');
        $categoryModel = $this->model('Category_model');
        
        $product = $productModel->getProductById($id);
        
        if (!$product) {
            $_SESSION['flash_message'] = 'Produk tidak ditemukan';
            $_SESSION['flash_type'] = 'danger';
            header('Location: ' . BASEURL . '/product');
            exit;
        }
        
        $data['product'] = $product;
        $data['categories'] = $categoryModel->getAllCategories();
        $data['title'] = 'Edit Produk - Admin';
        $data['action'] = 'edit';
        
        $this->view('product/form', $data);
    }
    
    /**
     * Insert product
     */
    public function insert() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Location: ' . BASEURL . '/product');
            exit;
        }
        
        $name = trim($_POST['name'] ?? '');
        $category_id = intval($_POST['category_id'] ?? 0);
        $price = floatval($_POST['price'] ?? 0);
        $stock = intval($_POST['stock'] ?? 0);
        $description = trim($_POST['description'] ?? '');
        $image = trim($_POST['image'] ?? '');
        $status = $_POST['status'] ?? 'active';
        
        // Validation
        if (empty($name)) {
            $_SESSION['flash_message'] = 'Nama produk tidak boleh kosong';
            $_SESSION['flash_type'] = 'danger';
            header('Location: ' . BASEURL . '/product/add');
            exit;
        }
        
        if ($category_id <= 0) {
            $_SESSION['flash_message'] = 'Kategori harus dipilih';
            $_SESSION['flash_type'] = 'danger';
            header('Location: ' . BASEURL . '/product/add');
            exit;
        }
        
        if ($price <= 0) {
            $_SESSION['flash_message'] = 'Harga harus lebih dari 0';
            $_SESSION['flash_type'] = 'danger';
            header('Location: ' . BASEURL . '/product/add');
            exit;
        }
        
        $data = [
            'name' => $name,
            'category_id' => $category_id,
            'price' => $price,
            'stock' => $stock,
            'description' => $description,
            'image' => $image,
            'status' => $status
        ];
        
        $productModel = $this->model('Product_model');
        $result = $productModel->insertProduct($data);
        
        if ($result > 0) {
            $_SESSION['flash_message'] = 'Produk berhasil ditambahkan';
            $_SESSION['flash_type'] = 'success';
        } else {
            $_SESSION['flash_message'] = 'Gagal menambahkan produk';
            $_SESSION['flash_type'] = 'danger';
        }
        
        header('Location: ' . BASEURL . '/product');
        exit;
    }
    
    /**
     * Update product
     */
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Location: ' . BASEURL . '/product');
            exit;
        }
        
        $id = intval($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $category_id = intval($_POST['category_id'] ?? 0);
        $price = floatval($_POST['price'] ?? 0);
        $stock = intval($_POST['stock'] ?? 0);
        $description = trim($_POST['description'] ?? '');
        $image = trim($_POST['image'] ?? '');
        $status = $_POST['status'] ?? 'active';
        
        // Validation
        if ($id <= 0) {
            $_SESSION['flash_message'] = 'ID produk tidak valid';
            $_SESSION['flash_type'] = 'danger';
            header('Location: ' . BASEURL . '/product');
            exit;
        }
        
        if (empty($name)) {
            $_SESSION['flash_message'] = 'Nama produk tidak boleh kosong';
            $_SESSION['flash_type'] = 'danger';
            header('Location: ' . BASEURL . '/product/edit/' . $id);
            exit;
        }
        
        if ($category_id <= 0) {
            $_SESSION['flash_message'] = 'Kategori harus dipilih';
            $_SESSION['flash_type'] = 'danger';
            header('Location: ' . BASEURL . '/product/edit/' . $id);
            exit;
        }
        
        if ($price <= 0) {
            $_SESSION['flash_message'] = 'Harga harus lebih dari 0';
            $_SESSION['flash_type'] = 'danger';
            header('Location: ' . BASEURL . '/product/edit/' . $id);
            exit;
        }
        
        $data = [
            'id' => $id,
            'name' => $name,
            'category_id' => $category_id,
            'price' => $price,
            'stock' => $stock,
            'description' => $description,
            'image' => $image,
            'status' => $status
        ];
        
        $productModel = $this->model('Product_model');
        $result = $productModel->updateProduct($data);
        
        if ($result > 0) {
            $_SESSION['flash_message'] = 'Produk berhasil diupdate';
            $_SESSION['flash_type'] = 'success';
        } else {
            $_SESSION['flash_message'] = 'Tidak ada perubahan data';
            $_SESSION['flash_type'] = 'info';
        }
        
        header('Location: ' . BASEURL . '/product');
        exit;
    }
    
    /**
     * Delete product
     */
    public function delete($id) {
        $productModel = $this->model('Product_model');
        $result = $productModel->deleteProduct($id);
        
        if ($result > 0) {
            $_SESSION['flash_message'] = 'Produk berhasil dihapus';
            $_SESSION['flash_type'] = 'success';
        } else {
            $_SESSION['flash_message'] = 'Gagal menghapus produk';
            $_SESSION['flash_type'] = 'danger';
        }
        
        header('Location: ' . BASEURL . '/product');
        exit;
    }
    
    /**
     * Category management
     */
    public function categories() {
        $categoryModel = $this->model('Category_model');
        
        $data['categories'] = $categoryModel->getCategoriesWithCount();
        $data['title'] = 'Manajemen Kategori - Admin';
        
        $this->view('product/categories', $data);
    }
    
    /**
     * Add category
     */
    public function addCategory() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Location: ' . BASEURL . '/product/categories');
            exit;
        }
        
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        
        if (empty($name)) {
            $_SESSION['flash_message'] = 'Nama kategori tidak boleh kosong';
            $_SESSION['flash_type'] = 'danger';
            header('Location: ' . BASEURL . '/product/categories');
            exit;
        }
        
        $categoryModel = $this->model('Category_model');
        $result = $categoryModel->insertCategory(['name' => $name, 'description' => $description]);
        
        if ($result > 0) {
            $_SESSION['flash_message'] = 'Kategori berhasil ditambahkan';
            $_SESSION['flash_type'] = 'success';
        } else {
            $_SESSION['flash_message'] = 'Gagal menambahkan kategori';
            $_SESSION['flash_type'] = 'danger';
        }
        
        header('Location: ' . BASEURL . '/product/categories');
        exit;
    }
    
    /**
     * Delete category
     */
    public function deleteCategory($id) {
        $categoryModel = $this->model('Category_model');
        $result = $categoryModel->deleteCategory($id);
        
        if ($result == -1) {
            $_SESSION['flash_message'] = 'Kategori tidak dapat dihapus karena masih memiliki produk';
            $_SESSION['flash_type'] = 'warning';
        } elseif ($result > 0) {
            $_SESSION['flash_message'] = 'Kategori berhasil dihapus';
            $_SESSION['flash_type'] = 'success';
        } else {
            $_SESSION['flash_message'] = 'Gagal menghapus kategori';
            $_SESSION['flash_type'] = 'danger';
        }
        
        header('Location: ' . BASEURL . '/product/categories');
        exit;
    }
    
    /**
     * Order management (admin)
     */
    public function orders() {
        $orderModel = $this->model('Order_model');
        
        $data['orders'] = $orderModel->getAllOrders();
        $data['title'] = 'Manajemen Pesanan - Admin';
        
        $this->view('product/orders', $data);
    }
    
    /**
     * Update order status (admin)
     */
    public function updateOrderStatus() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Location: ' . BASEURL . '/product/orders');
            exit;
        }
        
        $order_id = intval($_POST['order_id'] ?? 0);
        $status = $_POST['status'] ?? '';
        
        $orderModel = $this->model('Order_model');
        $success = $orderModel->updateOrderStatus($order_id, $status);
        
        if ($success) {
            $_SESSION['flash_message'] = 'Status pesanan berhasil diupdate';
            $_SESSION['flash_type'] = 'success';
        } else {
            $_SESSION['flash_message'] = 'Gagal mengupdate status pesanan';
            $_SESSION['flash_type'] = 'danger';
        }
        
        header('Location: ' . BASEURL . '/product/orders');
        exit;
    }
}
?>
