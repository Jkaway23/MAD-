<?php require_once '../app/view/template/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-box"></i> Manajemen Produk</h2>
        <div>
            <a href="<?= BASEURL; ?>/product/categories" class="btn btn-info me-2">
                <i class="fas fa-tags"></i> Kelola Kategori
            </a>
            <a href="<?= BASEURL; ?>/product/orders" class="btn btn-warning me-2">
                <i class="fas fa-shopping-cart"></i> Pesanan
            </a>
            <a href="<?= BASEURL; ?>/product/add" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Produk
            </a>
        </div>
    </div>
    
    <!-- Flash Message -->
    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="alert alert-<?= $_SESSION['flash_type']; ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['flash_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
    <?php endif; ?>
    
    <?php if (empty($data['products'])): ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Belum ada produk. Silakan tambah produk baru.
        </div>
    <?php else: ?>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['products'] as $product): ?>
                                <tr>
                                    <td><?= $product['id']; ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($product['name']); ?></strong><br>
                                        <small class="text-muted"><?= htmlspecialchars(substr($product['description'], 0, 50)); ?>...</small>
                                    </td>
                                    <td><?= htmlspecialchars($product['category_name'] ?? 'N/A'); ?></td>
                                    <td>Rp <?= number_format($product['price'], 0, ',', '.'); ?></td>
                                    <td>
                                        <?php if ($product['stock'] <= 5): ?>
                                            <span class="badge bg-danger"><?= $product['stock']; ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-success"><?= $product['stock']; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($product['status'] == 'active'): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= BASEURL; ?>/product/edit/<?= $product['id']; ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= BASEURL; ?>/product/delete/<?= $product['id']; ?>" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Yakin hapus produk ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once '../app/view/template/footer.php'; ?>
