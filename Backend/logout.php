<?php
// filepath: c:\xampp\htdocs\new4\backend\logout.php

session_start();

// Log the logout activity
if (isset($_SESSION['admin_id'])) {
    require_once 'db.php';
    log_activity($_SESSION['admin_id'], 'logout', 'User logged out');
}

// Clear remember me cookie
if (isset($_COOKIE['remember_admin'])) {
    setcookie('remember_admin', '', time() - 3600, '/', '', true, true);
}

// Destroy all session data
$_SESSION = array();

// Destroy session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Destroy session
session_destroy();

// Set success message for login page
session_start();
$_SESSION['login_success'] = 'You have been successfully logged out.';

// Redirect to login page
header('Location: login.php');
exit();
?>