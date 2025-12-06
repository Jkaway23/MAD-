<?php require_once '../app/view/template/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-tags"></i> Manajemen Kategori</h2>
        <a href="<?= BASEURL; ?>/product" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Produk
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
    
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tambah Kategori</h5>
                </div>
                <div class="card-body">
                    <form action="<?= BASEURL; ?>/product/addCategory" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-plus"></i> Tambah Kategori
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Daftar Kategori</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($data['categories'])): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Belum ada kategori.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Deskripsi</th>
                                        <th>Jumlah Produk</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['categories'] as $category): ?>
                                        <tr>
                                            <td><?= $category['id']; ?></td>
                                            <td><strong><?= htmlspecialchars($category['name']); ?></strong></td>
                                            <td><?= htmlspecialchars(substr($category['description'], 0, 50)); ?><?= strlen($category['description']) > 50 ? '...' : ''; ?></td>
                                            <td>
                                                <span class="badge bg-primary"><?= $category['product_count'] ?? 0; ?> produk</span>
                                            </td>
                                            <td>
                                                <a href="<?= BASEURL; ?>/product/deleteCategory/<?= $category['id']; ?>" 
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Yakin hapus kategori ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/view/template/footer.php'; ?>
