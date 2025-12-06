<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-5">
            <div class="card shadow-lg">
                <div class="card-body p-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="bg-white rounded p-4">
                        <h2 class="text-center mb-4">Login Form</h2>
                        
                        <!-- Tab Navigation -->
                        <ul class="nav nav-pills nav-fill mb-4">
                            <li class="nav-item">
                                <a class="nav-link active" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASEURL ?>auth/register" style="color: #667eea;">Signup</a>
                            </li>
                        </ul>
                        
                        <!-- Error Message -->
                        <?php if (!empty($data['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($data['error']) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Login Form -->
                        <form method="POST" action="<?= BASEURL ?>auth/login">
                            <div class="mb-3">
                                <label for="email" class="form-label text-muted">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label text-muted">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                            </div>
                            
                            <div class="mb-3 text-end">
                                <a href="#" class="text-decoration-none" style="color: #667eea; font-size: 0.9rem;">Forgot password?</a>
                            </div>
                            
                            <button type="submit" class="btn w-100 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">Login</button>
                        </form>
                        
                        <div class="text-center mt-3">
                            <small>Not a member? <a href="<?= BASEURL ?>auth/register" class="text-decoration-none" style="color: #667eea;">Signup now</a></small>
                        </div>
                        
                        <!-- Demo Info -->
                        <div class="alert alert-info mt-4 mb-0" role="alert">
                            <strong>💡 Demo Login:</strong><br>
                            Email: admin@example.com<br>
                            Password: password123
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
