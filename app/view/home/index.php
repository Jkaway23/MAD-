<?php require_once '../app/view/template/header.php'; ?>

<style>
    body {
        background: #f8f9fa;
    }
    
    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 100px 0 80px;
        position: relative;
        overflow: hidden;
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="40" fill="rgba(255,255,255,0.05)"/></svg>');
        animation: float 20s linear infinite;
    }
    
    @keyframes float {
        from { transform: translateY(0) rotate(0deg); }
        to { transform: translateY(-100%) rotate(360deg); }
    }
    
    .hero-content {
        position: relative;
        z-index: 1;
    }
    
    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        animation: fadeInUp 0.8s ease;
    }
    
    .hero-subtitle {
        font-size: 1.3rem;
        margin-bottom: 30px;
        opacity: 0.95;
        animation: fadeInUp 1s ease;
    }
    
    .hero-buttons {
        animation: fadeInUp 1.2s ease;
    }
    
    .hero-buttons .btn {
        padding: 15px 40px;
        font-size: 1.1rem;
        border-radius: 50px;
        margin: 10px;
        transition: all 0.3s;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .hero-buttons .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Features Section */
    .features-section {
        padding: 60px 0;
        background: white;
    }
    
    .feature-card {
        text-align: center;
        padding: 30px;
        transition: all 0.3s;
        border-radius: 15px;
    }
    
    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .feature-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 2rem;
        color: white;
    }
    
    /* Categories Section */
    .categories-section {
        padding: 60px 0;
        background: #f8f9fa;
    }
    
    .category-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        transition: all 0.3s;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border: 2px solid transparent;
        cursor: pointer;
    }
    
    .category-card:hover {
        border-color: #667eea;
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
    }
    
    .category-icon {
        font-size: 3rem;
        margin-bottom: 15px;
        color: #667eea;
    }
    
    /* Products Section */
    .products-section {
        padding: 60px 0;
        background: white;
    }
    
    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: #1f2937;
        position: relative;
        padding-bottom: 15px;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 2px;
    }
    
    .product-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        height: 100%;
        border: 1px solid #e5e7eb;
    }
    
    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }
    
    .product-image {
        height: 200px;
        background: #f9fafb;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    
    .product-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.3s;
    }
    
    .product-card:hover .product-image img {
        transform: scale(1.1);
    }
    
    .product-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #ef4444;
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .product-body {
        padding: 20px;
    }
    
    .product-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: #1f2937;
        height: 3em;
        overflow: hidden;
    }
    
    .product-category {
        font-size: 0.85rem;
        color: #6b7280;
        margin-bottom: 10px;
    }
    
    .product-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 15px;
    }
    
    .product-footer {
        padding: 0 20px 20px;
    }
    
    /* Stats Section */
    .stats-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 60px 0;
    }
    
    .stat-item {
        text-align: center;
        padding: 20px;
    }
    
    .stat-number {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 10px;
    }
    
    .stat-label {
        font-size: 1.1rem;
        opacity: 0.9;
    }
    
    /* CTA Section */
    .cta-section {
        background: #f8f9fa;
        padding: 80px 0;
        text-align: center;
    }
    
    .cta-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: #1f2937;
    }
    
    .cta-subtitle {
        font-size: 1.2rem;
        color: #6b7280;
        margin-bottom: 30px;
    }
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content">
                <h1 class="hero-title">Belanja Online<br>Mudah & Terpercaya</h1>
                <p class="hero-subtitle">Ribuan produk berkualitas dengan harga terbaik. Gratis ongkir & garansi 100% original!</p>
                <div class="hero-buttons">
                    <a href="<?= BASEURL; ?>shop" class="btn btn-light btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                    </a>
                    <a href="<?= BASEURL; ?>shop/myOrders" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-list me-2"></i>Lihat Pesanan
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-shopping-cart" style="font-size: 15rem; opacity: 0.2;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h5>Gratis Ongkir</h5>
                    <p class="text-muted mb-0">Pengiriman gratis untuk pembelian di atas Rp 100.000</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h5>100% Original</h5>
                    <p class="text-muted mb-0">Semua produk dijamin keasliannya</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-undo"></i>
                    </div>
                    <h5>Easy Return</h5>
                    <p class="text-muted mb-0">Pengembalian mudah dalam 7 hari</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h5>24/7 Support</h5>
                    <p class="text-muted mb-0">Customer service siap membantu kapan saja</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Kategori Populer</h2>
            <p class="text-muted">Jelajahi berbagai kategori produk pilihan kami</p>
        </div>
        <div class="row">
            <?php 
            $icons = [
                'Electronics' => 'laptop',
                'Fashion' => 'tshirt',
                'Food & Beverage' => 'coffee',
                'Books & Stationery' => 'book',
                'Sports & Outdoors' => 'basketball-ball',
                'Beauty & Health' => 'heart',
                'Home & Living' => 'home',
                'Toys & Hobbies' => 'gamepad',
                'Automotive' => 'car',
                'Services' => 'concierge-bell'
            ];
            
            $displayCategories = array_slice($data['categories'], 0, 6);
            foreach ($displayCategories as $category): 
                $icon = $icons[$category['name']] ?? 'tag';
            ?>
                <div class="col-md-4 col-lg-2 mb-4">
                    <a href="<?= BASEURL; ?>shop/index/<?= $category['id']; ?>" class="text-decoration-none">
                        <div class="category-card">
                            <div class="category-icon">
                                <i class="fas fa-<?= $icon; ?>"></i>
                            </div>
                            <h6 class="mb-0"><?= htmlspecialchars($category['name']); ?></h6>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?= BASEURL; ?>shop" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-th me-2"></i>Lihat Semua Kategori
            </a>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="products-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Produk Pilihan</h2>
            <p class="text-muted">Produk terbaik dan terlaris dari toko kami</p>
        </div>
        
        <?php if (empty($data['featured_products'])): ?>
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> Produk akan segera ditambahkan
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($data['featured_products'] as $product): ?>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="product-card">
                            <div class="product-image">
                                <?php if ($product['stock'] <= 5 && $product['stock'] > 0): ?>
                                    <span class="product-badge">Stok Terbatas</span>
                                <?php elseif ($product['stock'] == 0): ?>
                                    <span class="product-badge" style="background: #6b7280;">Habis</span>
                                <?php endif; ?>
                                
                                <?php if (!empty($product['image'])): ?>
                                    <img src="<?= htmlspecialchars($product['image']); ?>" 
                                         alt="<?= htmlspecialchars($product['name']); ?>">
                                <?php else: ?>
                                    <i class="fas fa-image fa-4x text-muted"></i>
                                <?php endif; ?>
                            </div>
                            <div class="product-body">
                                <div class="product-category">
                                    <i class="fas fa-tag"></i> <?= htmlspecialchars($product['category_name'] ?? 'Uncategorized'); ?>
                                </div>
                                <h5 class="product-title"><?= htmlspecialchars($product['name']); ?></h5>
                                <div class="product-price">Rp <?= number_format($product['price'], 0, ',', '.'); ?></div>
                            </div>
                            <div class="product-footer">
                                <a href="<?= BASEURL; ?>shop/detail/<?= $product['id']; ?>" class="btn btn-primary w-100">
                                    <i class="fas fa-eye me-2"></i>Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="text-center mt-5">
                <a href="<?= BASEURL; ?>shop" class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-bag me-2"></i>Lihat Semua Produk
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="stat-item">
                    <div class="stat-number">10K+</div>
                    <div class="stat-label">Produk Tersedia</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item">
                    <div class="stat-number">50K+</div>
                    <div class="stat-label">Customer Puas</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item">
                    <div class="stat-number">100K+</div>
                    <div class="stat-label">Transaksi Sukses</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item">
                    <div class="stat-number">4.9/5</div>
                    <div class="stat-label">Rating Toko</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2 class="cta-title">Siap Untuk Berbelanja?</h2>
        <p class="cta-subtitle">Dapatkan penawaran terbaik dan promo menarik setiap hari!</p>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="<?= BASEURL; ?>shop" class="btn btn-primary btn-lg me-2">
                <i class="fas fa-shopping-cart me-2"></i>Mulai Belanja Sekarang
            </a>
            <a href="<?= BASEURL; ?>shop/myOrders" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-list me-2"></i>Cek Pesanan Saya
            </a>
        <?php else: ?>
            <a href="<?= BASEURL; ?>auth/register" class="btn btn-primary btn-lg me-2">
                <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
            </a>
            <a href="<?= BASEURL; ?>shop" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-shopping-bag me-2"></i>Jelajahi Produk
            </a>
        <?php endif; ?>
    </div>
</section>

<?php require_once '../app/view/template/footer.php'; ?>
