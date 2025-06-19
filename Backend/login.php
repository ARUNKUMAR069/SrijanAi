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
    <title>Admin Login - AI Enquiry System</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="robots" content="noindex, nofollow">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h2>Admin Login</h2>
                <p>AI Enquiry Management System</p>
            </div>
            
            <?php if (!empty($error_message)): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($error_message); ?>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($success_message)): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?php echo htmlspecialchars($success_message); ?>
            </div>
            <?php endif; ?>
            
            <form action="login-process.php" method="POST" class="login-form" autocomplete="off">
                <div class="form-group">
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Username" required autofocus autocomplete="username">
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Password" required autocomplete="current-password">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="remember-me">
                        <input type="checkbox" name="remember_me" value="1">
                        <span class="checkmark"></span>
                        Remember me for 30 days
                    </label>
                </div>
                
                <button type="submit" class="login-btn">
                    <span>Login to Dashboard</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>
            
            <div class="login-footer">
                <div class="credentials-info">
                    <h4>Default Credentials:</h4>
                    <p><strong>Username:</strong> admin</p>
                    <p><strong>Password:</strong> 123456</p>
                </div>
                <div class="security-info">
                    <small>
                        <i class="fas fa-shield-alt"></i>
                        This system is secured with SSL encryption
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Auto-hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 300);
            }, 5000);
        });
        
        // Focus on username field
        const usernameField = document.querySelector('input[name="username"]');
        if (usernameField) {
            usernameField.focus();
        }
    });
    </script>
</body>
</html>
<?php
// In the login validation section, after successful login:
if ($user && password_verify($password, $user['password_hash'])) {
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_id'] = $user['id'];
    $_SESSION['admin_username'] = $user['username'];
    $_SESSION['admin_full_name'] = $user['full_name']; // Add this
    $_SESSION['admin_role'] = $user['role'];           // Add this
    $_SESSION['admin_email'] = $user['email'];         // Add this
    
    // Update last login
    $update_stmt = $conn->prepare("UPDATE admin_users SET last_login = NOW(), last_login_ip = ?, login_count = login_count + 1 WHERE id = ?");
    $update_stmt->bind_param("si", $_SERVER['REMOTE_ADDR'], $user['id']);
    $update_stmt->execute();
    $update_stmt->close();
    
    header('Location: dashboard.php');
    exit();
}
?>