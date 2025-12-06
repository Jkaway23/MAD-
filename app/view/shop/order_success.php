<?php require_once '../app/view/template/header.php'; ?>

<style>
    .success-page {
        background: #f8f9fa;
        min-height: 100vh;
        padding: 30px 0;
    }
    
    .success-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .success-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 40px 20px;
        position: relative;
    }
    
    .success-icon {
        width: 100px;
        height: 100px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        animation: scaleIn 0.5s ease;
    }
    
    .success-icon i {
        color: #10b981;
        font-size: 50px;
    }
    
    @keyframes scaleIn {
        0% { transform: scale(0); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
    
    .order-number {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 20px;
        margin: 20px 0;
    }
    
    .detail-section {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .item-card {
        display: flex;
        align-items: center;
        padding: 15px;
        background: white;
        border-radius: 10px;
        margin-bottom: 10px;
        border: 1px solid #e9ecef;
    }
    
    .timeline {
        position: relative;
        padding-left: 30px;
        margin: 20px 0;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 15px;
    }
    
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -26px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #10b981;
        border: 3px solid white;
        box-shadow: 0 0 0 3px #e9ecef;
    }
</style>

<div class="success-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="success-card card">
                    <div class="success-header text-center">
                        <div class="success-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h2 class="mb-2">Pesanan Berhasil!</h2>
                        <p class="mb-0">Terima kasih telah berbelanja di AIMVC Store</p>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="order-number text-center">
                            <h5 class="mb-2">Nomor Pesanan Anda</h5>
                            <h2 class="fw-bold mb-2"><?= htmlspecialchars($data['order']['order_number']); ?></h2>
                            <p class="text-muted small mb-0">
                                <i class="fas fa-calendar me-2"></i><?= date('d M Y, H:i', strtotime($data['order']['created_at'])); ?>
                            </p>
                        </div>
                        
                        <!-- Order Timeline -->
                        <div class="detail-section">
                            <h6 class="mb-3"><i class="fas fa-shipping-fast me-2"></i>Status Pengiriman</h6>
                            <div class="timeline">
                                <div class="timeline-item">
                                    <strong>Pesanan Dibuat</strong>
                                    <p class="text-muted small mb-0">Pesanan Anda sedang diproses</p>
                                </div>
                                <div class="timeline-item" style="opacity: 0.5;">
                                    <strong>Sedang Dikemas</strong>
                                    <p class="text-muted small mb-0">Produk sedang disiapkan</p>
                                </div>
                                <div class="timeline-item" style="opacity: 0.5;">
                                    <strong>Dikirim</strong>
                                    <p class="text-muted small mb-0">Dalam perjalanan ke alamat Anda</p>
                                </div>
                                <div class="timeline-item" style="opacity: 0.5;">
                                    <strong>Selesai</strong>
                                    <p class="text-muted small mb-0">Pesanan diterima</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Order Details -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="detail-section">
                                    <h6 class="mb-3"><i class="fas fa-info-circle me-2 text-primary"></i>Detail Pesanan</h6>
                                    <table class="table table-sm table-borderless mb-0">
                                        <tr>
                                            <td class="text-muted">Status:</td>
                                            <td><span class="badge bg-warning">Pending</span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Pembayaran:</td>
                                            <td><strong><?= $data['order']['payment_method'] == 'cod' ? 'Cash on Delivery' : 'Transfer Bank'; ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Total:</td>
                                            <td><h5 class="text-success mb-0">Rp <?= number_format($data['order']['total_amount'], 0, ',', '.'); ?></h5></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="detail-section">
                                    <h6 class="mb-3"><i class="fas fa-map-marker-alt me-2 text-danger"></i>Alamat Pengiriman</h6>
                                    <p class="mb-2"><?= nl2br(htmlspecialchars($data['order']['shipping_address'])); ?></p>
                                    <p class="mb-0">
                                        <i class="fas fa-phone me-2"></i>
                                        <strong><?= htmlspecialchars($data['order']['phone']); ?></strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Products Ordered -->
                        <div class="detail-section">
                            <h6 class="mb-3"><i class="fas fa-box me-2"></i>Produk yang Dibeli (<?= count($data['order_items']); ?> item)</h6>
                            <?php foreach ($data['order_items'] as $item): ?>
                                <div class="item-card">
                                    <?php if (!empty($item['image'])): ?>
                                        <img src="<?= htmlspecialchars($item['image']); ?>" 
                                             alt="<?= htmlspecialchars($item['product_name']); ?>" 
                                             style="width: 60px; height: 60px; object-fit: contain; border-radius: 8px; background: #f8f9fa; padding: 5px;" 
                                             class="me-3">
                                    <?php endif; ?>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?= htmlspecialchars($item['product_name']); ?></h6>
                                        <small class="text-muted"><?= $item['quantity']; ?> x Rp <?= number_format($item['price'], 0, ',', '.'); ?></small>
                                    </div>
                                    <strong class="text-success">Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?></strong>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Next Steps -->
                        <div class="alert alert-info mb-4">
                            <h6 class="mb-2"><i class="fas fa-lightbulb me-2"></i>Langkah Selanjutnya:</h6>
                            <ul class="mb-0 ps-3">
                                <li>Kami akan mengirim notifikasi via email/SMS untuk update status pesanan</li>
                                <li>Pesanan akan diproses dalam 1-2 hari kerja</li>
                                <li>Estimasi pengiriman 3-5 hari kerja</li>
                                <li>Simpan nomor pesanan untuk tracking</li>
                            </ul>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="text-center">
                            <a href="<?= BASEURL; ?>/shop/orderDetail/<?= $data['order']['id']; ?>" class="btn btn-primary btn-lg me-2 mb-2">
                                <i class="fas fa-search me-2"></i>Lacak Pesanan
                            </a>
                            <a href="<?= BASEURL; ?>/shop/myOrders" class="btn btn-outline-primary btn-lg me-2 mb-2">
                                <i class="fas fa-list me-2"></i>Lihat Semua Pesanan
                            </a>
                            <a href="<?= BASEURL; ?>/shop" class="btn btn-outline-secondary btn-lg mb-2">
                                <i class="fas fa-shopping-bag me-2"></i>Belanja Lagi
                            </a>
                        </div>
                        
                        <!-- Share Section -->
                        <div class="text-center mt-4 pt-4 border-top">
                            <p class="text-muted mb-2">Puas dengan layanan kami? Bagikan pengalaman Anda!</p>
                            <button class="btn btn-sm btn-outline-primary me-2">
                                <i class="fab fa-facebook-f me-1"></i>Facebook
                            </button>
                            <button class="btn btn-sm btn-outline-info me-2">
                                <i class="fab fa-twitter me-1"></i>Twitter
                            </button>
                            <button class="btn btn-sm btn-outline-success">
                                <i class="fab fa-whatsapp me-1"></i>WhatsApp
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto scroll to top on page load
window.scrollTo(0, 0);

// Show success animation
setTimeout(function() {
    const icon = document.querySelector('.success-icon');
    if (icon) {
        icon.style.animation = 'scaleIn 0.5s ease';
    }
}, 100);
</script>

<?php require_once '../app/view/template/footer.php'; ?>
