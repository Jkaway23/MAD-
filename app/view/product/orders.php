<?php require_once '../app/view/template/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-shopping-cart"></i> Manajemen Pesanan</h2>
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
    
    <?php if (empty($data['orders'])): ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Belum ada pesanan.
        </div>
    <?php else: ?>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Customer</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['orders'] as $order): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($order['order_number']); ?></strong></td>
                                    <td>
                                        <?= htmlspecialchars($order['user_name']); ?><br>
                                        <small class="text-muted"><?= htmlspecialchars($order['user_email']); ?></small>
                                    </td>
                                    <td><?= date('d M Y H:i', strtotime($order['created_at'])); ?></td>
                                    <td>Rp <?= number_format($order['total_amount'], 0, ',', '.'); ?></td>
                                    <td>
                                        <?php
                                        $badge_class = 'secondary';
                                        switch($order['status']) {
                                            case 'pending': $badge_class = 'warning'; break;
                                            case 'processing': $badge_class = 'info'; break;
                                            case 'shipped': $badge_class = 'primary'; break;
                                            case 'delivered': $badge_class = 'success'; break;
                                            case 'cancelled': $badge_class = 'danger'; break;
                                        }
                                        ?>
                                        <span class="badge bg-<?= $badge_class; ?>"><?= ucfirst($order['status']); ?></span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#orderModal<?= $order['id']; ?>">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        
                                        <!-- Modal for Order Details -->
                                        <div class="modal fade" id="orderModal<?= $order['id']; ?>" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Detail Pesanan: <?= htmlspecialchars($order['order_number']); ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <h6>Info Customer:</h6>
                                                                <p>
                                                                    <strong>Nama:</strong> <?= htmlspecialchars($order['user_name']); ?><br>
                                                                    <strong>Email:</strong> <?= htmlspecialchars($order['user_email']); ?><br>
                                                                    <strong>Telepon:</strong> <?= htmlspecialchars($order['phone']); ?>
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h6>Info Pengiriman:</h6>
                                                                <p><?= nl2br(htmlspecialchars($order['shipping_address'])); ?></p>
                                                            </div>
                                                        </div>
                                                        
                                                        <hr>
                                                        
                                                        <h6>Update Status:</h6>
                                                        <form action="<?= BASEURL; ?>/product/updateOrderStatus" method="POST" class="mb-3">
                                                            <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <select name="status" class="form-select" required>
                                                                        <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                                        <option value="processing" <?= $order['status'] == 'processing' ? 'selected' : ''; ?>>Processing</option>
                                                                        <option value="shipped" <?= $order['status'] == 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                                                                        <option value="delivered" <?= $order['status'] == 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                                                        <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <button type="submit" class="btn btn-success w-100">
                                                                        <i class="fas fa-check"></i> Update
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
