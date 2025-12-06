<?php include_once __DIR__ . '/../template/header.php'; ?>

<style>
    .error-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: calc(100vh - 100px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }
    
    .error-card {
        background: white;
        border-radius: 30px;
        padding: 60px 40px;
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.3);
        text-align: center;
        max-width: 600px;
        width: 100%;
        position: relative;
        overflow: hidden;
    }
    
    .error-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #e74c3c 0%, #c0392b 100%);
    }
    
    .error-icon {
        width: 150px;
        height: 150px;
        margin: 0 auto 30px;
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 5rem;
        color: white;
        box-shadow: 0 15px 40px rgba(231, 76, 60, 0.4);
        animation: shake 0.5s ease-in-out;
    }
    
    .error-number {
        font-size: 6rem;
        font-weight: 900;
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 20px;
        line-height: 1;
        animation: pulse 2s infinite;
    }
    
    .error-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 15px;
    }
    
    .error-message {
        font-size: 1.2rem;
        color: #718096;
        margin-bottom: 10px;
        line-height: 1.6;
    }
    
    .error-description {
        font-size: 1rem;
        color: #a0aec0;
        margin-bottom: 35px;
        padding: 20px;
        background: #f7fafc;
        border-radius: 15px;
        border-left: 4px solid #e74c3c;
    }
    
    .error-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .btn-error {
        padding: 15px 35px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }
    
    .btn-primary-error {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
    }
    
    .btn-primary-error:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(102, 126, 234, 0.6);
        color: white;
    }
    
    .btn-secondary-error {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
    }
    
    .btn-secondary-error:hover {
        background: #667eea;
        color: white;
        transform: translateY(-3px);
    }
    
    .suggestions {
        margin-top: 30px;
        padding-top: 30px;
        border-top: 2px dashed #e2e8f0;
    }
    
    .suggestion-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 15px;
    }
    
    .suggestion-list {
        list-style: none;
        padding: 0;
        text-align: left;
    }
    
    .suggestion-list li {
        padding: 10px 15px;
        margin-bottom: 8px;
        background: #f7fafc;
        border-radius: 10px;
        color: #4a5568;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .suggestion-list li i {
        color: #667eea;
        font-size: 1.2rem;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
</style>

<div class="error-container">
    <div class="error-card">
        <div class="error-icon">
            <i class="fas fa-lock"></i>
        </div>
        
        <div class="error-number">403</div>
        <h1 class="error-title">Access Forbidden</h1>
        <p class="error-message">Oops! You don't have permission to access this resource.</p>
        
        <div class="error-description">
            <i class="fas fa-info-circle me-2"></i>
            This page or action is restricted. You may need special permissions or authentication to view this content.
        </div>
        
        <div class="error-actions">
            <a href="<?php echo BASEURL; ?>" class="btn-error btn-primary-error">
                <i class="fas fa-home"></i>
                <span>Go Home</span>
            </a>
            <a href="javascript:history.back()" class="btn-error btn-secondary-error">
                <i class="fas fa-arrow-left"></i>
                <span>Go Back</span>
            </a>
        </div>
        
        <div class="suggestions">
            <div class="suggestion-title">💡 What you can try:</div>
            <ul class="suggestion-list">
                <li>
                    <i class="fas fa-check-circle"></i>
                    <span>Check if you're logged in with the correct account</span>
                </li>
                <li>
                    <i class="fas fa-check-circle"></i>
                    <span>Contact administrator for access permissions</span>
                </li>
                <li>
                    <i class="fas fa-check-circle"></i>
                    <span>Return to homepage and try again</span>
                </li>
            </ul>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../template/footer.php'; ?>
