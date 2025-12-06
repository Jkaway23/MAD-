<?php include_once __DIR__ . '/../template/header.php'; ?>

<style>
    .dashboard-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: calc(100vh - 100px);
        padding: 40px 0;
    }
    
    .hero-section {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 25px;
        padding: 50px 40px;
        color: white;
        text-align: center;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        margin-bottom: 40px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .hero-section h1 {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 15px;
        text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
        animation: fadeInDown 0.8s ease-out;
    }
    
    .hero-section .subtitle {
        font-size: 1.4rem;
        opacity: 0.95;
        margin-bottom: 10px;
        font-weight: 300;
    }
    
    .stats-row {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-top: 30px;
        flex-wrap: wrap;
    }
    
    .stat-item {
        background: rgba(255, 255, 255, 0.2);
        padding: 15px 30px;
        border-radius: 15px;
        backdrop-filter: blur(5px);
    }
    
    .stat-item i {
        font-size: 1.5rem;
        margin-right: 10px;
    }
    
    .action-card {
        background: white;
        border: none;
        border-radius: 20px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        overflow: hidden;
        position: relative;
    }
    
    .action-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    }
    
    .action-card:hover {
        transform: translateY(-15px) scale(1.02);
        box-shadow: 0 20px 50px rgba(0,0,0,0.25);
    }
    
    .action-card .card-icon {
        font-size: 5rem;
        margin-bottom: 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: pulse 2s infinite;
    }
    
    .action-card .card-title {
        color: #2d3748;
        font-weight: 700;
        font-size: 1.8rem;
        margin-bottom: 15px;
    }
    
    .action-card .card-text {
        color: #718096;
        font-size: 1rem;
        line-height: 1.6;
    }
    
    .action-card .btn-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 12px 35px;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }
    
    .action-card .btn-custom:hover {
        transform: scale(1.08);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
    }
    
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }
    
    .card-body {
        padding: 2.5rem !important;
    }
</style>

<div class="dashboard-container">
    <div class="container">
        <!-- Hero Welcome Section -->
        <div class="hero-section">
            <h1>✨ Welcome Back, <?php echo htmlspecialchars($data['user']); ?>!</h1>
            <p class="subtitle">Ready to create something amazing today?</p>
            
            <div class="stats-row">
                <div class="stat-item">
                    <i class="fas fa-envelope"></i>
                    <span><?php echo htmlspecialchars($data['email']); ?></span>
                </div>
                <div class="stat-item">
                    <i class="fas fa-clock"></i>
                    <span>Login: <?php echo date('M d, H:i', strtotime($data['login_time'])); ?></span>
                </div>
            </div>
        </div>
        
        <!-- Action Cards -->
        <div class="row g-4 justify-content-center">
            <div class="col-md-5">
                <div class="action-card card shadow">
                    <div class="card-body text-center">
                        <div class="card-icon">🏠</div>
                        <h4 class="card-title">Home</h4>
                        <p class="card-text mb-4">Explore the main page and discover featured products</p>
                        <a href="<?php echo BASEURL; ?>home" class="btn btn-custom">
                            <i class="fas fa-arrow-right me-2"></i>Visit Home
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-5">
                <div class="action-card card shadow">
                    <div class="card-body text-center">
                        <div class="card-icon">👤</div>
                        <h4 class="card-title">Profile</h4>
                        <p class="card-text mb-4">Manage your account settings and personal information</p>
                        <a href="<?php echo BASEURL; ?>dashboard/profile" class="btn btn-custom">
                            <i class="fas fa-user-circle me-2"></i>My Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../template/footer.php'; ?>