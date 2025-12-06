<?php require_once '../app/view/template/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <!-- Sidebar Categories -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Kategori</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="<?= BASEURL; ?>/shop" class="list-group-item list-group-item-action <?= !isset($data['active_category']) ? 'active' : ''; ?>">
                        <i class="fas fa-th-large"></i> Semua Produk
                    </a>
                    <?php if (!empty($data['categories'])): ?>
                        <?php foreach ($data['categories'] as $cat): ?>
                            <a href="<?= BASEURL; ?>/shop/index/<?= $cat['id']; ?>" 
                               class="list-group-item list-group-item-action <?= isset($data['active_category']) && $data['active_category']['id'] == $cat['id'] ? 'active' : ''; ?>">
                                <?= htmlspecialchars($cat['name']); ?>
                                <span class="badge bg-secondary float-end"><?= $cat['product_count'] ?? 0; ?></span>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Search Box -->
            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <h6 class="card-title"><i class="fas fa-search"></i> Cari Produk</h6>
                    <form action="<?= BASEURL; ?>/shop/search" method="POST">
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control" placeholder="Cari..." 
                                   value="<?= isset($data['search_keyword']) ? htmlspecialchars($data['search_keyword']) : ''; ?>" required>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="col-md-9">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <?php if (isset($data['search_keyword'])): ?>
                        Hasil Pencarian: "<?= htmlspecialchars($data['search_keyword']); ?>"
                    <?php elseif (isset($data['active_category'])): ?>
                        <?= htmlspecialchars($data['active_category']['name']); ?>
                    <?php else: ?>
                        Semua Produk
                    <?php endif; ?>
                </h2>
                <a href="<?= BASEURL; ?>/shop/cart" class="btn btn-primary">
                    <i class="fas fa-shopping-cart"></i> Keranjang 
                    <?php if ($data['cart_count'] > 0): ?>
                        <span class="badge bg-danger"><?= $data['cart_count']; ?></span>
                    <?php endif; ?>
                </a>
            </div>
            
            <!-- Flash Message -->
            <?php if (isset($_SESSION['flash_message'])): ?>
                <div class="alert alert-<?= $_SESSION['flash_type']; ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['flash_message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
            <?php endif; ?>
            
            <!-- Products -->
            <?php if (empty($data['products'])): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Tidak ada produk ditemukan.
                </div>
            <?php else: ?>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php foreach ($data['products'] as $product): ?>
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <?php if (!empty($product['image'])): ?>
                                        <img src="<?= htmlspecialchars($product['image']); ?>" 
                                             alt="<?= htmlspecialchars($product['name']); ?>" 
                                             class="img-fluid" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                    <?php else: ?>
                                        <i class="fas fa-image fa-4x text-muted"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($product['name']); ?></h5>
                                    <p class="text-muted small mb-2">
                                        <i class="fas fa-tag"></i> <?= htmlspecialchars($product['category_name'] ?? 'Uncategorized'); ?>
                                    </p>
                                    <p class="card-text text-truncate" style="max-height: 3em;">
                                        <?= htmlspecialchars(substr($product['description'], 0, 100)); ?><?= strlen($product['description']) > 100 ? '...' : ''; ?>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="text-primary mb-0">Rp <?= number_format($product['price'], 0, ',', '.'); ?></h4>
                                        <small class="text-muted">
                                            <i class="fas fa-boxes"></i> Stok: <?= $product['stock']; ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="card-footer bg-white border-0">
                                    <a href="<?= BASEURL; ?>/shop/detail/<?= $product['id']; ?>" class="btn btn-outline-primary btn-sm w-100">
                                        <i class="fas fa-eye"></i> Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../app/view/template/footer.php'; ?>
