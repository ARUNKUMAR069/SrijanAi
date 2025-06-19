<?php
// filepath: c:\xampp\htdocs\new4\backend\db.php

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'ai_enquiry_system');

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$create_db = "CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if ($conn->query($create_db) === FALSE) {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db(DB_NAME);

// Set charset to utf8mb4
$conn->set_charset("utf8mb4");

// Create enquiries table if it doesn't exist
$create_table = "CREATE TABLE IF NOT EXISTS enquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    mobile VARCHAR(20) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT,
    ip_address VARCHAR(45) DEFAULT NULL,
    user_agent TEXT DEFAULT NULL,
    source VARCHAR(50) DEFAULT 'website',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status ENUM('new', 'read', 'in_progress', 'responded', 'closed') DEFAULT 'new',
    priority ENUM('low', 'medium', 'high', 'urgent') DEFAULT 'medium',
    assigned_to INT DEFAULT NULL,
    notes TEXT DEFAULT NULL,
    INDEX idx_email (email),
    INDEX idx_mobile (mobile),
    INDEX idx_created_at (created_at),
    INDEX idx_status (status),
    INDEX idx_priority (priority)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($conn->query($create_table) === FALSE) {
    die("Error creating table: " . $conn->error);
}

// Create admin_users table if it doesn't exist
$create_admin_table = "CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(255) DEFAULT NULL,
    full_name VARCHAR(255) DEFAULT NULL,
    role ENUM('admin', 'manager', 'agent', 'viewer') DEFAULT 'admin',
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    last_login TIMESTAMP NULL DEFAULT NULL,
    last_login_ip VARCHAR(45) DEFAULT NULL,
    login_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_username (username),
    INDEX idx_status (status),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($conn->query($create_admin_table) === FALSE) {
    die("Error creating admin_users table: " . $conn->error);
}

// Create login_attempts table if it doesn't exist
$create_login_table = "CREATE TABLE IF NOT EXISTS login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL,
    username VARCHAR(50) DEFAULT NULL,
    success TINYINT(1) NOT NULL DEFAULT 0,
    failure_reason VARCHAR(100) DEFAULT NULL,
    user_agent TEXT DEFAULT NULL,
    attempted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_ip_address (ip_address),
    INDEX idx_username (username),
    INDEX idx_attempted_at (attempted_at),
    INDEX idx_success (success)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($conn->query($create_login_table) === FALSE) {
    die("Error creating login_attempts table: " . $conn->error);
}

// Insert default admin user if not exists
$check_admin = "SELECT id FROM admin_users WHERE username = 'admin'";
$result = $conn->query($check_admin);

if ($result->num_rows == 0) {
    $default_password = password_hash('123456', PASSWORD_DEFAULT);
    $insert_admin = "INSERT INTO admin_users (username, password_hash, email, full_name, role) 
                     VALUES ('admin', '$default_password', 'admin@aicompany.com', 'System Administrator', 'admin')";
    $conn->query($insert_admin);
}

// Function to sanitize input
function sanitize_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return mysqli_real_escape_string($conn, $data);
}

// Function to validate email
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to validate mobile
function validate_mobile($mobile) {
    return preg_match('/^[0-9+\-\s()]{10,15}$/', $mobile);
}

// Function to log activity
function log_activity($admin_id, $action, $details = '') {
    global $conn;
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    
    $stmt = $conn->prepare("INSERT INTO login_attempts (ip_address, username, success, failure_reason, user_agent) VALUES (?, ?, ?, ?, ?)");
    if ($stmt) {
        $username = $admin_id ? "admin_id_$admin_id" : 'unknown';
        $success = ($action == 'login_success') ? 1 : 0;
        $stmt->bind_param("ssiss", $ip_address, $username, $success, $details, $user_agent);
        $stmt->execute();
        $stmt->close();
    }
}
?>