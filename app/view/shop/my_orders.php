<?php require_once '../app/view/template/header.php'; ?>

<div class="container mt-4">
    <h2><i class="fas fa-list"></i> Pesanan Saya</h2>
    <hr>
    
    <?php if (empty($data['orders'])): ?>
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
            <h4>Belum Ada Pesanan</h4>
            <p>Anda belum memiliki riwayat pesanan.</p>
            <a href="<?= BASEURL; ?>/shop" class="btn btn-primary mt-3">
                <i class="fas fa-shopping-bag"></i> Belanja Sekarang
            </a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No. Pesanan</th>
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
                                <a href="<?= BASEURL; ?>/shop/orderDetail/<?= $order['id']; ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require_once '../app/view/template/footer.php'; ?>
