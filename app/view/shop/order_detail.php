<?php require_once '../app/view/template/header.php'; ?>

<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASEURL; ?>/shop/myOrders">Pesanan Saya</a></li>
            <li class="breadcrumb-item active"><?= htmlspecialchars($data['order']['order_number']); ?></li>
        </ol>
    </nav>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Detail Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Nomor Pesanan:</strong><br><?= htmlspecialchars($data['order']['order_number']); ?></p>
                            <p><strong>Tanggal:</strong><br><?= date('d M Y H:i', strtotime($data['order']['created_at'])); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Status:</strong><br>
                                <?php
                                $badge_class = 'secondary';
                                switch($data['order']['status']) {
                                    case 'pending': $badge_class = 'warning'; break;
                                    case 'processing': $badge_class = 'info'; break;
                                    case 'shipped': $badge_class = 'primary'; break;
                                    case 'delivered': $badge_class = 'success'; break;
                                    case 'cancelled': $badge_class = 'danger'; break;
                                }
                                ?>
                                <span class="badge bg-<?= $badge_class; ?>"><?= ucfirst($data['order']['status']); ?></span>
                            </p>
                            <p><strong>Pembayaran:</strong><br><?= strtoupper($data['order']['payment_method']); ?></p>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h6>Alamat Pengiriman:</h6>
                    <p><?= nl2br(htmlspecialchars($data['order']['shipping_address'])); ?></p>
                    <p><strong>Telepon:</strong> <?= htmlspecialchars($data['order']['phone']); ?></p>
                    
                    <hr>
                    
                    <h6>Produk yang Dibeli:</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['order_items'] as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if (!empty($item['image'])): ?>
                                                    <img src="<?= htmlspecialchars($item['image']); ?>" 
                                                         alt="<?= htmlspecialchars($item['product_name']); ?>" 
                                                         class="img-thumbnail me-2" style="width: 50px; height: 50px; object-fit: contain;">
                                                <?php endif; ?>
                                                <span><?= htmlspecialchars($item['product_name']); ?></span>
                                            </div>
                                        </td>
                                        <td>Rp <?= number_format($item['price'], 0, ',', '.'); ?></td>
                                        <td><?= $item['quantity']; ?></td>
                                        <td>Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                    <td><strong class="text-success">Rp <?= number_format($data['order']['total_amount'], 0, ',', '.'); ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Aksi</h5>
                </div>
                <div class="card-body">
                    <a href="<?= BASEURL; ?>/shop/myOrders" class="btn btn-outline-primary w-100 mb-2">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                    <a href="<?= BASEURL; ?>/shop" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-shopping-bag"></i> Belanja Lagi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/view/template/footer.php'; ?>
