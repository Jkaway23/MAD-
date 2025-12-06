<?php require_once '../app/view/template/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-box"></i> 
                        <?= $data['action'] == 'add' ? 'Tambah Produk Baru' : 'Edit Produk'; ?>
                    </h5>
                </div>
                <div class="card-body">
                    <form action="<?= BASEURL; ?>/product/<?= $data['action'] == 'add' ? 'insert' : 'update'; ?>" method="POST">
                        <?php if (isset($data['product'])): ?>
                            <input type="hidden" name="id" value="<?= $data['product']['id']; ?>">
                        <?php endif; ?>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" 
                                   value="<?= isset($data['product']) ? htmlspecialchars($data['product']['name']) : ''; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach ($data['categories'] as $category): ?>
                                    <option value="<?= $category['id']; ?>" 
                                            <?= isset($data['product']) && $data['product']['category_id'] == $category['id'] ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($category['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Harga <span class="text-danger">*</span></label>
                                    <input type="number" name="price" id="price" class="form-control" 
                                           value="<?= isset($data['product']) ? $data['product']['price'] : ''; ?>" 
                                           min="0" step="1000" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Stok</label>
                                    <input type="number" name="stock" id="stock" class="form-control" 
                                           value="<?= isset($data['product']) ? $data['product']['stock'] : '0'; ?>" 
                                           min="0">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea name="description" id="description" class="form-control" rows="4"><?= isset($data['product']) ? htmlspecialchars($data['product']['description']) : ''; ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">URL Gambar</label>
                            <input type="text" name="image" id="image" class="form-control" 
                                   value="<?= isset($data['product']) ? htmlspecialchars($data['product']['image']) : ''; ?>" 
                                   placeholder="https://example.com/image.jpg">
                            <small class="text-muted">Masukkan URL gambar produk</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="active" <?= isset($data['product']) && $data['product']['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                                <option value="inactive" <?= isset($data['product']) && $data['product']['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="<?= BASEURL; ?>/product" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/view/template/footer.php'; ?>
