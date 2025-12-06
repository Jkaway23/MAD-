<?php require_once '../app/view/template/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= BASEURL; ?>/shop">Shop</a></li>
                    <li class="breadcrumb-item"><a href="<?= BASEURL; ?>/shop/index/<?= $data['product']['category_id']; ?>"><?= htmlspecialchars($data['product']['category_name']); ?></a></li>
                    <li class="breadcrumb-item active"><?= htmlspecialchars($data['product']['name']); ?></li>
                </ol>
            </nav>
            
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                                <?php if (!empty($data['product']['image'])): ?>
                                    <img src="<?= htmlspecialchars($data['product']['image']); ?>" 
                                         alt="<?= htmlspecialchars($data['product']['name']); ?>" 
                                         class="img-fluid" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                <?php else: ?>
                                    <i class="fas fa-image fa-5x text-muted"></i>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h2><?= htmlspecialchars($data['product']['name']); ?></h2>
                            <p class="text-muted">
                                <i class="fas fa-tag"></i> <?= htmlspecialchars($data['product']['category_name']); ?>
                            </p>
                            <hr>
                            <h3 class="text-primary">Rp <?= number_format($data['product']['price'], 0, ',', '.'); ?></h3>
                            <p class="mb-3">
                                <i class="fas fa-boxes"></i> 
                                Stok: <strong><?= $data['product']['stock']; ?></strong>
                                <?php if ($data['product']['stock'] > 0): ?>
                                    <span class="badge bg-success ms-2">Tersedia</span>
                                <?php else: ?>
                                    <span class="badge bg-danger ms-2">Habis</span>
                                <?php endif; ?>
                            </p>
                            
                            <h5>Deskripsi:</h5>
                            <p><?= nl2br(htmlspecialchars($data['product']['description'])); ?></p>
                            
                            <?php if ($data['product']['stock'] > 0): ?>
                                <form action="<?= BASEURL; ?>/shop/addToCart/<?= $data['product']['id']; ?>" method="POST" class="mt-4">
                                    <div class="row g-3">
                                        <div class="col-auto">
                                            <label for="quantity" class="col-form-label">Jumlah:</label>
                                        </div>
                                        <div class="col-auto">
                                            <input type="number" name="quantity" id="quantity" class="form-control" 
                                                   value="1" min="1" max="<?= $data['product']['stock']; ?>" style="width: 100px;">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            <?php else: ?>
                                <div class="alert alert-warning mt-4">
                                    <i class="fas fa-exclamation-triangle"></i> Produk sedang habis
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Related Products -->
            <?php if (!empty($data['related_products'])): ?>
                <h4 class="mt-5 mb-3">Produk Terkait</h4>
                <div class="row row-cols-1 row-cols-md-4 g-3">
                    <?php 
                    $count = 0;
                    foreach ($data['related_products'] as $product): 
                        if ($product['id'] == $data['product']['id']) continue;
                        if ($count >= 4) break;
                        $count++;
                    ?>
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                    <?php if (!empty($product['image'])): ?>
                                        <img src="<?= htmlspecialchars($product['image']); ?>" 
                                             alt="<?= htmlspecialchars($product['name']); ?>" 
                                             class="img-fluid" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                    <?php else: ?>
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title"><?= htmlspecialchars(substr($product['name'], 0, 30)); ?><?= strlen($product['name']) > 30 ? '...' : ''; ?></h6>
                                    <p class="text-primary mb-2">Rp <?= number_format($product['price'], 0, ',', '.'); ?></p>
                                    <a href="<?= BASEURL; ?>/shop/detail/<?= $product['id']; ?>" class="btn btn-sm btn-outline-primary w-100">Lihat</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-shopping-cart"></i> Keranjang</h5>
                </div>
                <div class="card-body text-center">
                    <p class="mb-0">Items: <strong><?= $data['cart_count']; ?></strong></p>
                    <a href="<?= BASEURL; ?>/shop/cart" class="btn btn-primary btn-sm mt-2 w-100">
                        <i class="fas fa-eye"></i> Lihat Keranjang
                    </a>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Kategori Lain</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="<?= BASEURL; ?>/shop" class="list-group-item list-group-item-action">
                        <i class="fas fa-th-large"></i> Semua Produk
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/view/template/footer.php'; ?>
