<?php

// filepath: c:\xampp\htdocs\new4\backend\login.php

session_start();

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit();
}

$error_message = '';
if (isset($_SESSION['login_error'])) {
    $error_message = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}

$success_message = '';
if (isset($_SESSION['login_success'])) {
    $success_message = $_SESSION['login_success'];
    unset($_SESSION['login_success']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - SrijanAI Management System</title>
    <link rel="stylesheet" href="assets/css/login-modern.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="../assets/images/favicon.ico" type="image/x-icon">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-background">
            <div class="background-overlay"></div>
            <div class="background-pattern"></div>
        </div>
        
        <div class="login-card modern-card">
            <div class="login-header">
                <div class="login-logo">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h2>Admin Login</h2>
                <p>SrijanAI Management System</p>
            </div>
            
            <?php if (!empty($error_message)): ?>
            <div class="alert alert-error modern-alert">
                <div class="alert-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="alert-content">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
                <button class="alert-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($success_message)): ?>
            <div class="alert alert-success modern-alert">
                <div class="alert-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="alert-content">
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
                <button class="alert-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <?php endif; ?>
            
            <form action="login-process.php" method="POST" class="login-form modern-form" autocomplete="off">
                <div class="form-group">
                    <label for="username" class="form-label">
                        <i class="fas fa-user"></i>
                        Username
                    </label>
                    <div class="input-wrapper">
                        <input type="text" 
                               id="username"
                               name="username" 
                               placeholder="Enter your username" 
                               required 
                               autofocus 
                               autocomplete="username"
                               class="modern-input">
                        <div class="input-focus-border"></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock"></i>
                        Password
                    </label>
                    <div class="input-wrapper">
                        <input type="password" 
                               id="password"
                               name="password" 
                               placeholder="Enter your password" 
                               required 
                               autocomplete="current-password"
                               class="modern-input">
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="passwordToggleIcon"></i>
                        </button>
                        <div class="input-focus-border"></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="remember-me modern-checkbox">
                        <input type="checkbox" name="remember_me" value="1">
                        <span class="checkmark">
                            <i class="fas fa-check"></i>
                        </span>
                        <span class="checkbox-text">Remember me for 30 days</span>
                    </label>
                </div>
                
                <button type="submit" class="login-btn modern-btn">
                    <span class="btn-text">Login to Dashboard</span>
                    <span class="btn-icon">
                        <i class="fas fa-arrow-right"></i>
                    </span>
                    <div class="btn-loading" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </button>
            </form>
            
            <div class="login-footer">
                <div class="security-info">
                    <div class="security-badges">
                        <div class="security-badge">
                            <i class="fas fa-shield-alt"></i>
                            <span>SSL Encrypted</span>
                        </div>
                        <div class="security-badge">
                            <i class="fas fa-lock"></i>
                            <span>Secure Login</span>
                        </div>
                        <div class="security-badge">
                            <i class="fas fa-user-shield"></i>
                            <span>Protected Access</span>
                        </div>
                    </div>
                    
                    <div class="company-info">
                        <p>&copy; 2024 SrijanAI Innovations Pvt. Ltd. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/login-modern.js"></script>
</body>
</html>