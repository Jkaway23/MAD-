<?php include_once __DIR__ . '/../template/header.php'; ?>

<style>
    .profile-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: calc(100vh - 100px);
        padding: 40px 0;
    }
    
    .profile-card {
        background: white;
        border-radius: 25px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 40px;
        text-align: center;
        color: white;
        position: relative;
    }
    
    .profile-header::after {
        content: '';
        position: absolute;
        bottom: -30px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 0;
        border-left: 30px solid transparent;
        border-right: 30px solid transparent;
        border-top: 30px solid #764ba2;
    }
    
    .profile-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 4rem;
        border: 5px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }
    
    .profile-name {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }
    
    .profile-email {
        font-size: 1.2rem;
        opacity: 0.9;
    }
    
    .profile-body {
        padding: 60px 40px 40px;
    }
    
    .info-row {
        display: flex;
        align-items: center;
        padding: 20px;
        border-bottom: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    
    .info-row:hover {
        background: #f7fafc;
        border-left: 4px solid #667eea;
        padding-left: 16px;
    }
    
    .info-row:last-child {
        border-bottom: none;
    }
    
    .info-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin-right: 20px;
    }
    
    .info-content {
        flex: 1;
    }
    
    .info-label {
        font-size: 0.85rem;
        color: #718096;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }
    
    .info-value {
        font-size: 1.1rem;
        color: #2d3748;
        font-weight: 500;
    }
    
    .action-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        padding: 30px 40px;
        background: #f7fafc;
    }
    
    .btn-action {
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-primary-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }
    
    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    }
    
    .btn-secondary-custom {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
    }
    
    .btn-secondary-custom:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
    }
    
    .stats-cards {
        margin-top: 30px;
    }
    
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border-top: 4px solid #667eea;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }
    
    .stat-icon {
        font-size: 3rem;
        margin-bottom: 15px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 5px;
    }
    
    .stat-label {
        font-size: 1rem;
        color: #718096;
        font-weight: 500;
    }
</style>

<div class="profile-container">
    <div class="container">
        <!-- Profile Card -->
        <div class="profile-card">
            <!-- Profile Header -->
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <h1 class="profile-name"><?php echo htmlspecialchars($data['user']); ?></h1>
                <p class="profile-email">
                    <i class="fas fa-envelope me-2"></i><?php echo htmlspecialchars($data['email']); ?>
                </p>
            </div>
            
            <!-- Profile Body -->
            <div class="profile-body">
                <div class="info-row">
                    <div class="info-icon">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">User ID</div>
                        <div class="info-value">#<?php echo htmlspecialchars($data['user_id']); ?></div>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Full Name</div>
                        <div class="info-value"><?php echo htmlspecialchars($data['user']); ?></div>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Email Address</div>
                        <div class="info-value"><?php echo htmlspecialchars($data['email']); ?></div>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Last Login</div>
                        <div class="info-value"><?php echo date('F d, Y - H:i:s', strtotime($data['login_time'])); ?></div>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Account Status</div>
                        <div class="info-value">
                            <span class="badge bg-success" style="font-size: 1rem; padding: 8px 15px;">
                                <i class="fas fa-check-circle me-1"></i>Active
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="<?php echo BASEURL; ?>dashboard" class="btn btn-secondary-custom btn-action">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
                <button class="btn btn-primary-custom btn-action" onclick="alert('Edit profile feature coming soon!')">
                    <i class="fas fa-edit me-2"></i>Edit Profile
                </button>
            </div>
        </div>
        
        <!-- Statistics Cards -->
        <div class="stats-cards">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-value"><?php echo date('d', strtotime($data['login_time'])); ?></div>
                        <div class="stat-label">Days Active</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <div class="stat-value">0</div>
                        <div class="stat-label">Tasks Completed</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="stat-value">0</div>
                        <div class="stat-label">Achievements</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../template/footer.php'; ?>
