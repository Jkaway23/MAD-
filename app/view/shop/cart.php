<?php require_once '../app/view/template/header.php'; ?>

<style>
    .cart-page {
        background: #f8f9fa;
        min-height: 100vh;
        padding: 30px 0;
    }
    
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }
    
    .cart-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        margin-bottom: 20px;
    }
    
    .cart-item {
        padding: 20px;
        border-bottom: 1px solid #e9ecef;
        transition: background 0.3s;
    }
    
    .cart-item:hover {
        background: #f8f9fa;
    }
    
    .cart-item:last-child {
        border-bottom: none;
    }
    
    .product-image-cart {
        width: 80px;
        height: 80px;
        object-fit: contain;
        border-radius: 10px;
        background: #f8f9fa;
        padding: 5px;
    }
    
    .quantity-input {
        width: 80px;
        border-radius: 8px;
        border: 2px solid #e9ecef;
        text-align: center;
        font-weight: 600;
    }
    
    .quantity-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .btn-update {
        border-radius: 8px;
        padding: 8px 15px;
    }
    
    .summary-card {
        position: sticky;
        top: 20px;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #e9ecef;
    }
    
    .summary-row:last-child {
        border-bottom: none;
        padding-top: 15px;
        margin-top: 10px;
        border-top: 2px solid #667eea;
    }
    
    .total-amount {
        font-size: 1.8rem;
        font-weight: 800;
        color: #667eea;
    }
    
    .btn-checkout {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 15px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s;
    }
    
    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    }
    
    .empty-cart {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }
    
    .empty-cart i {
        font-size: 5rem;
        color: #cbd5e0;
        margin-bottom: 20px;
    }
</style>

<div class="cart-page">
    <div class="container">
        <div class="page-header">
            <h1 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Keranjang Belanja</h1>
            <p class="mb-0 mt-2 opacity-75">Kelola produk yang akan Anda beli</p>
        </div>
    
    <!-- Flash Message -->
    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="alert alert-<?= $_SESSION['flash_type']; ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['flash_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
    <?php endif; ?>
    
        <!-- Flash Message -->
        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-<?= $_SESSION['flash_type']; ?> alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle me-2"></i><?= $_SESSION['flash_message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
        <?php endif; ?>
        
        <?php if (empty($data['cart_items'])): ?>
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <h3 class="mt-3 mb-2">Keranjang Anda Kosong</h3>
                <p class="text-muted mb-4">Belum ada produk di keranjang belanja Anda</p>
                <a href="<?= BASEURL; ?>shop" class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                </a>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="cart-card card">
                        <div class="card-header bg-white border-0 pt-4">
                            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Item di Keranjang (<?= count($data['cart_items']); ?>)</h5>
                        </div>
                        <div class="card-body p-0">
                            <?php foreach ($data['cart_items'] as $item): ?>
                                <div class="cart-item">
                                    <div class="row align-items-center">
                                        <div class="col-md-5">
                                            <div class="d-flex align-items-center">
                                                <?php if (!empty($item['image'])): ?>
                                                    <img src="<?= htmlspecialchars($item['image']); ?>" 
                                                         alt="<?= htmlspecialchars($item['name']); ?>" 
                                                         class="product-image-cart me-3">
                                                <?php else: ?>
                                                    <div class="product-image-cart bg-light d-flex align-items-center justify-content-center me-3">
                                                        <i class="fas fa-image fa-2x text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div>
                                                    <h6 class="mb-1"><?= htmlspecialchars($item['name']); ?></h6>
                                                    <small class="text-muted">
                                                        <i class="fas fa-boxes"></i> Stok: <?= $item['stock']; ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <strong class="text-primary">Rp <?= number_format($item['price'], 0, ',', '.'); ?></strong>
                                        </div>
                                        <div class="col-md-3">
                                            <form action="<?= BASEURL; ?>shop/updateCart" method="POST" class="d-flex align-items-center">
                                                <input type="hidden" name="cart_id" value="<?= $item['cart_id']; ?>">
                                                <input type="number" name="quantity" value="<?= $item['quantity']; ?>" 
                                                       min="1" max="<?= $item['stock']; ?>" 
                                                       class="form-control quantity-input me-2">
                                                <button type="submit" class="btn btn-primary btn-update" title="Update">
                                                    <i class="fas fa-sync-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <h6 class="mb-2 text-success">Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?></h6>
                                            <a href="<?= BASEURL; ?>shop/removeFromCart/<?= $item['cart_id']; ?>" 
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Hapus produk ini dari keranjang?')">
                                                <i class="fas fa-trash me-1"></i>Hapus
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Continue Shopping Button -->
                    <a href="<?= BASEURL; ?>shop" class="btn btn-outline-secondary mt-3">
                        <i class="fas fa-arrow-left me-2"></i>Lanjut Belanja
                    </a>
                </div>
            
                <div class="col-lg-4">
                    <div class="cart-card card summary-card">
                        <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>Ringkasan Belanja</h5>
                        </div>
                        <div class="card-body">
                            <div class="summary-row">
                                <span>Total Item</span>
                                <strong><?= $data['cart_count']; ?> item</strong>
                            </div>
                            <div class="summary-row">
                                <span>Subtotal</span>
                                <strong>Rp <?= number_format($data['cart_total'], 0, ',', '.'); ?></strong>
                            </div>
                            <div class="summary-row">
                                <span>Ongkos Kirim</span>
                                <strong class="text-success">GRATIS</strong>
                            </div>
                            <div class="summary-row">
                                <h5 class="mb-0">Total Pembayaran</h5>
                                <h5 class="mb-0 total-amount">Rp <?= number_format($data['cart_total'], 0, ',', '.'); ?></h5>
                            </div>
                            
                            <a href="<?= BASEURL; ?>shop/checkout" class="btn btn-checkout btn-success w-100 mt-4">
                                <i class="fas fa-credit-card me-2"></i>Lanjut ke Checkout
                            </a>
                            
                            <div class="mt-3 p-3 bg-light rounded">
                                <small class="text-muted">
                                    <i class="fas fa-shield-alt text-success me-2"></i>
                                    <strong>Belanja Aman</strong><br>
                                    Transaksi Anda dilindungi dengan enkripsi SSL
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Promo Info -->
                    <div class="card cart-card mt-3">
                        <div class="card-body">
                            <h6 class="mb-3"><i class="fas fa-gift me-2 text-danger"></i>Promo Spesial</h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Gratis ongkir semua pembelian</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Garansi 100% original</li>
                                <li><i class="fas fa-check text-success me-2"></i>Retur mudah dalam 7 hari</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../app/view/template/footer.php'; ?>
