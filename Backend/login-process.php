<?php
// filepath: c:\xampp\htdocs\new4\backend\login-process.php

session_start();
require_once 'db.php';

// Rate limiting - max 5 attempts per IP per 15 minutes
$max_attempts = 5;
$lockout_time = 15 * 60; // 15 minutes

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $remember_me = isset($_POST['remember_me']) ? true : false;
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    
    // Check rate limiting
    $stmt = $conn->prepare("SELECT COUNT(*) as attempts FROM login_attempts WHERE ip_address = ? AND success = 0 AND attempted_at > DATE_SUB(NOW(), INTERVAL ? SECOND)");
    $stmt->bind_param("si", $ip_address, $lockout_time);
    $stmt->execute();
    $result = $stmt->get_result();
    $attempts = $result->fetch_assoc()['attempts'];
    $stmt->close();
    
    if ($attempts >= $max_attempts) {
        // Log the blocked attempt
        log_activity(null, 'login_blocked', 'Too many failed attempts');
        
        $_SESSION['login_error'] = "Too many failed login attempts. Please try again in 15 minutes.";
        header('Location: login.php');
        exit();
    }
    
    // Validate input
    if (empty($username) || empty($password)) {
        log_activity(null, 'login_failed', 'Empty username or password');
        $_SESSION['login_error'] = 'Please enter both username and password';
        header('Location: login.php');
        exit();
    }
    
    // Check against database
    $stmt = $conn->prepare("SELECT id, username, password_hash, full_name, role, status FROM admin_users WHERE username = ? AND status = 'active' LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password_hash'])) {
            // Login successful
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_full_name'] = $user['full_name'];
            $_SESSION['admin_role'] = $user['role'];
            $_SESSION['login_time'] = time();
            
            // Update last login
            $update_stmt = $conn->prepare("UPDATE admin_users SET last_login = NOW(), last_login_ip = ?, login_count = login_count + 1 WHERE id = ?");
            $update_stmt->bind_param("si", $ip_address, $user['id']);
            $update_stmt->execute();
            $update_stmt->close();
            
            // Set remember me cookie
            if ($remember_me) {
                $cookie_value = base64_encode($user['id'] . ':' . hash('sha256', $user['password_hash']));
                setcookie('remember_admin', $cookie_value, time() + (30 * 24 * 60 * 60), '/', '', true, true); // 30 days
            }
            
            // Log successful login
            log_activity($user['id'], 'login_success', 'Successful login');
            
            // Clean old failed attempts for this IP
            $clean_stmt = $conn->prepare("DELETE FROM login_attempts WHERE ip_address = ? AND success = 0");
            $clean_stmt->bind_param("s", $ip_address);
            $clean_stmt->execute();
            $clean_stmt->close();
            
            header('Location: dashboard.php');
            exit();
        }
    }
    
    // Login failed
    log_activity(null, 'login_failed', "Failed login attempt for username: $username");
    
    $stmt->close();
    $_SESSION['login_error'] = 'Invalid username or password';
    header('Location: login.php');
    exit();
    
} else {
    // Invalid request method
    header('Location: login.php');
    exit();
}
?>