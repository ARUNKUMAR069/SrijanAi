<?php
// filepath: c:\xampp\htdocs\new4\backend\login-process.php

session_start();

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit();
}

require_once 'db.php';

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$remember_me = isset($_POST['remember_me']) && $_POST['remember_me'] === '1';

// Basic validation
if (empty($username) || empty($password)) {
    $_SESSION['login_error'] = 'Please enter both username and password.';
    header('Location: login.php');
    exit();
}

// Rate limiting - prevent brute force attacks
$ip_address = $_SERVER['REMOTE_ADDR'];
$rate_limit_key = "login_attempts_" . $ip_address;

// Check if there's an existing rate limit (you'd implement this with Redis/Memcached in production)
// For now, we'll use a simple session-based approach

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt_time'] = time();
}

// Reset attempts if more than 15 minutes have passed
if (time() - $_SESSION['last_attempt_time'] > 900) {
    $_SESSION['login_attempts'] = 0;
}

// Check if too many attempts
if ($_SESSION['login_attempts'] >= 5) {
    $_SESSION['login_error'] = 'Too many failed login attempts. Please try again in 15 minutes.';
    header('Location: login.php');
    exit();
}

try {
    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT id, username, password_hash, full_name, email, role, status, last_login FROM admin_users WHERE username = ? AND status = 'active'");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    
    // Verify credentials
    if ($user && password_verify($password, $user['password_hash'])) {
        // Reset login attempts on successful login
        $_SESSION['login_attempts'] = 0;
        unset($_SESSION['last_attempt_time']);
        
        // Set session variables
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_username'] = $user['username'];
        $_SESSION['admin_full_name'] = $user['full_name'];
        $_SESSION['admin_role'] = $user['role'];
        $_SESSION['admin_email'] = $user['email'];
        $_SESSION['login_time'] = time();
        
        // Update last login information
        $update_stmt = $conn->prepare("UPDATE admin_users SET last_login = NOW(), last_login_ip = ?, login_count = login_count + 1 WHERE id = ?");
        $update_stmt->bind_param("si", $ip_address, $user['id']);
        $update_stmt->execute();
        $update_stmt->close();
        
        // Handle "Remember Me" functionality
        if ($remember_me) {
            // Generate a secure random token
            $token = bin2hex(random_bytes(32));
            $expires = time() + (30 * 24 * 60 * 60); // 30 days
            
            // Store token in database
            $token_stmt = $conn->prepare("INSERT INTO admin_remember_tokens (user_id, token_hash, expires_at, ip_address) VALUES (?, ?, FROM_UNIXTIME(?), ?)");
            $token_hash = password_hash($token, PASSWORD_DEFAULT);
            $token_stmt->bind_param("isss", $user['id'], $token_hash, $expires, $ip_address);
            $token_stmt->execute();
            $token_stmt->close();
            
            // Set secure cookie
            setcookie('remember_token', $token, [
                'expires' => $expires,
                'path' => '/',
                'domain' => '',
                'secure' => isset($_SERVER['HTTPS']),
                'httponly' => true,
                'samesite' => 'Strict'
            ]);
        }
        
        // Log successful login
        error_log("Successful admin login: " . $username . " from IP: " . $ip_address);
        
        // Redirect to dashboard
        header('Location: dashboard.php');
        exit();
        
    } else {
        // Increment failed attempts
        $_SESSION['login_attempts']++;
        $_SESSION['last_attempt_time'] = time();
        
        // Log failed login attempt
        error_log("Failed admin login attempt: " . $username . " from IP: " . $ip_address);
        
        // Generic error message to prevent username enumeration
        $_SESSION['login_error'] = 'Invalid username or password. Please try again.';
        header('Location: login.php');
        exit();
    }
    
} catch (Exception $e) {
    error_log("Login error: " . $e->getMessage());
    $_SESSION['login_error'] = 'A system error occurred. Please try again later.';
    header('Location: login.php');
    exit();
}
?>