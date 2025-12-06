<?php require_once '../app/view/template/header.php'; ?>

<style>
    .checkout-page {
        background: #f8f9fa;
        min-height: 100vh;
        padding: 30px 0;
    }
    
    .checkout-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
    }
    
    .checkout-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        margin-bottom: 20px;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.25);
    }
    
    .checkout-btn {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        padding: 15px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s;
    }
    
    .checkout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
    }
    
    .order-item {
        padding: 15px;
        border-bottom: 1px solid #e9ecef;
        transition: background 0.2s;
    }
    
    .order-item:hover {
        background: #f8f9fa;
    }
    
    .order-item:last-child {
        border-bottom: none;
    }
    
    .payment-option {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .payment-option:hover {
        border-color: #10b981;
        background: #f0fdf4;
    }
    
    .payment-option input[type="radio"]:checked + label {
        color: #10b981;
        font-weight: 600;
    }
    
    .step-indicator {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
        position: relative;
    }
    
    .step {
        flex: 1;
        text-align: center;
        position: relative;
    }
    
    .step-number {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e9ecef;
        color: #6b7280;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .step.active .step-number {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    
    .step.completed .step-number {
        background: #10b981;
        color: white;
    }
</style>

<div class="checkout-page">
    <div class="container">
        <div class="checkout-header">
            <h1 class="mb-0"><i class="fas fa-credit-card me-2"></i>Checkout</h1>
            <p class="mb-0 mt-2 opacity-75">Selesaikan pembayaran Anda dengan aman</p>
        </div>
        
        <!-- Step Indicator -->
        <div class="step-indicator">
            <div class="step completed">
                <div class="step-number"><i class="fas fa-check"></i></div>
                <small>Keranjang</small>
            </div>
            <div class="step active">
                <div class="step-number">2</div>
                <small>Checkout</small>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <small>Selesai</small>
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
    
        <div class="row">
            <div class="col-lg-7 mb-4">
                <div class="checkout-card card">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Informasi Pengiriman</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= BASEURL; ?>shop/processCheckout" method="POST" id="checkoutForm">
                            <div class="mb-4">
                                <label for="shipping_address" class="form-label fw-bold">
                                    <i class="fas fa-home me-2 text-success"></i>Alamat Lengkap <span class="text-danger">*</span>
                                </label>
                                <textarea name="shipping_address" id="shipping_address" class="form-control" rows="4" 
                                          placeholder="Masukkan alamat lengkap dengan detail (nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan, kota, kode pos)" required></textarea>
                                <small class="text-muted">Pastikan alamat lengkap dan benar untuk pengiriman</small>
                            </div>
                            
                            <div class="mb-4">
                                <label for="phone" class="form-label fw-bold">
                                    <i class="fas fa-phone me-2 text-success"></i>Nomor Telepon <span class="text-danger">*</span>
                                </label>
                                <input type="tel" name="phone" id="phone" class="form-control" 
                                       placeholder="08xxxxxxxxxx" pattern="[0-9]{10,13}" required>
                                <small class="text-muted">Nomor telepon aktif untuk koordinasi pengiriman</small>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-credit-card me-2 text-success"></i>Metode Pembayaran <span class="text-danger">*</span>
                                </label>
                                <div class="payment-option">
                                    <input type="radio" name="payment_method" value="cod" id="cod" checked class="form-check-input me-2">
                                    <label for="cod" class="form-check-label w-100 cursor-pointer">
                                        <strong>Cash on Delivery (COD)</strong>
                                        <p class="text-muted mb-0 small">Bayar saat barang diterima</p>
                                    </label>
                                </div>
                                <div class="payment-option">
                                    <input type="radio" name="payment_method" value="transfer" id="transfer" class="form-check-input me-2">
                                    <label for="transfer" class="form-check-label w-100 cursor-pointer">
                                        <strong>Transfer Bank</strong>
                                        <p class="text-muted mb-0 small">Transfer ke rekening toko</p>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="alert alert-success">
                                <i class="fas fa-shield-alt me-2"></i>
                                <strong>Transaksi Aman</strong><br>
                                <small>Data Anda dilindungi dengan enkripsi SSL 256-bit</small>
                            </div>
                            
                            <button type="submit" class="btn btn-success checkout-btn w-100">
                                <i class="fas fa-check-circle me-2"></i>Proses Pesanan Sekarang
                            </button>
                            
                            <a href="<?= BASEURL; ?>shop/cart" class="btn btn-outline-secondary w-100 mt-2">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Keranjang
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        
            <div class="col-lg-5">
                <div class="checkout-card card" style="position: sticky; top: 20px;">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-3"><i class="fas fa-box me-2"></i>Produk yang Dibeli (<?= count($data['cart_items']); ?>):</h6>
                        <div class="mb-3" style="max-height: 350px; overflow-y: auto;">
                            <?php foreach ($data['cart_items'] as $item): ?>
                                <div class="order-item">
                                    <div class="d-flex align-items-start">
                                        <?php if (!empty($item['image'])): ?>
                                            <img src="<?= htmlspecialchars($item['image']); ?>" 
                                                 alt="<?= htmlspecialchars($item['name']); ?>" 
                                                 style="width: 50px; height: 50px; object-fit: contain; border-radius: 8px; background: #f8f9fa; padding: 5px;" 
                                                 class="me-3">
                                        <?php endif; ?>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1"><?= htmlspecialchars($item['name']); ?></h6>
                                            <small class="text-muted"><?= $item['quantity']; ?> x Rp <?= number_format($item['price'], 0, ',', '.'); ?></small>
                                        </div>
                                        <strong class="text-success">Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?></strong>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal (<?= $data['cart_count']; ?> item)</span>
                            <strong>Rp <?= number_format($data['cart_total'], 0, ',', '.'); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Ongkos Kirim</span>
                            <strong class="text-success">GRATIS</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Biaya Admin</span>
                            <strong>Rp 0</strong>
                        </div>
                        <hr class="my-3">
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0">Total Pembayaran</h5>
                            <h4 class="mb-0 text-success fw-bold">Rp <?= number_format($data['cart_total'], 0, ',', '.'); ?></h4>
                        </div>
                        
                        <div class="mt-4 p-3 bg-light rounded">
                            <small class="text-muted">
                                <i class="fas fa-info-circle text-primary me-2"></i>
                                <strong>Catatan:</strong><br>
                                Dengan melanjutkan, Anda menyetujui <a href="#">Syarat & Ketentuan</a> kami
                            </small>
                        </div>
                    </div>
            </div>
            
                </div>
                
                <!-- Trust Badges -->
                <div class="card checkout-card mt-3">
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col-4">
                                <i class="fas fa-truck fa-2x text-success mb-2"></i>
                                <small class="d-block">Gratis Ongkir</small>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-shield-alt fa-2x text-success mb-2"></i>
                                <small class="d-block">100% Aman</small>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-undo fa-2x text-success mb-2"></i>
                                <small class="d-block">Easy Return</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Form validation
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    const phone = document.getElementById('phone').value;
    const address = document.getElementById('shipping_address').value;
    
    if (phone.length < 10) {
        e.preventDefault();
        alert('Nomor telepon minimal 10 digit');
        return false;
    }
    
    if (address.length < 20) {
        e.preventDefault();
        alert('Mohon masukkan alamat lengkap minimal 20 karakter');
        return false;
    }
    
    // Confirmation
    if (!confirm('Apakah data pengiriman sudah benar? Pesanan akan segera diproses.')) {
        e.preventDefault();
        return false;
    }
});

// Payment method styling
document.querySelectorAll('.payment-option').forEach(option => {
    option.addEventListener('click', function() {
        const radio = this.querySelector('input[type="radio"]');
        radio.checked = true;
        
        document.querySelectorAll('.payment-option').forEach(opt => {
            opt.style.borderColor = '#e9ecef';
            opt.style.background = 'white';
        });
        
        this.style.borderColor = '#10b981';
        this.style.background = '#f0fdf4';
    });
});
</script>

<?php require_once '../app/view/template/footer.php'; ?>
