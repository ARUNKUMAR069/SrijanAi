<?php

// filepath: c:\xampp\htdocs\new4\backend\dashboard.php

session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

require_once 'db.php';
require_once 'components/dashboard/dashboard-functions.php';

// Include dashboard logic
include 'components/dashboard/dashboard-logic.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - AI Enquiry System</title>
    <link rel="stylesheet" href="assets/css/dashboard-modern.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="robots" content="noindex, nofollow">
</head>
<body class="dashboard-page">
    <div class="dashboard-container">
        <?php include 'components/dashboard/header.php'; ?>
        <?php include 'components/dashboard/alerts.php'; ?>
        <?php include 'components/dashboard/stats-cards.php'; ?>
        <?php include 'components/dashboard/filters.php'; ?>
        <?php include 'components/dashboard/enquiries-table.php'; ?>
        <?php include 'components/dashboard/modal.php'; ?>
    </div>
    
    <script src="assets/js/modern-dashboard.js"></script>
</body>
</html>