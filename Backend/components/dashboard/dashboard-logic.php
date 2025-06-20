<?php
// filepath: c:\xampp\htdocs\new4\backend\components\dashboard\dashboard-logic.php

// Ensure all session variables are set
if (!isset($_SESSION['admin_full_name']) || !isset($_SESSION['admin_role'])) {
    $admin_stmt = $conn->prepare("SELECT full_name, role FROM admin_users WHERE id = ?");
    $admin_stmt->bind_param("i", $_SESSION['admin_id']);
    $admin_stmt->execute();
    $admin_result = $admin_stmt->get_result();
    
    if ($admin_data = $admin_result->fetch_assoc()) {
        $_SESSION['admin_full_name'] = $admin_data['full_name'];
        $_SESSION['admin_role'] = $admin_data['role'];
    } else {
        $_SESSION['admin_full_name'] = $_SESSION['admin_username'] ?? 'Admin';
        $_SESSION['admin_role'] = 'admin';
    }
    $admin_stmt->close();
}

// Handle status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'update_status' && isset($_POST['enquiry_id']) && isset($_POST['new_status'])) {
        $enquiry_id = (int)$_POST['enquiry_id'];
        $new_status = $_POST['new_status'];
        $admin_id = $_SESSION['admin_id'];
        
        $valid_statuses = ['new', 'read', 'in_progress', 'responded', 'closed'];
        if (in_array($new_status, $valid_statuses)) {
            $update_stmt = $conn->prepare("UPDATE enquiries SET status = ?, assigned_to = COALESCE(assigned_to, ?), updated_at = NOW() WHERE id = ?");
            $update_stmt->bind_param("sii", $new_status, $admin_id, $enquiry_id);
            
            if ($update_stmt->execute()) {
                $_SESSION['dashboard_message'] = "Enquiry status updated to " . ucfirst(str_replace('_', ' ', $new_status)) . " successfully!";
            } else {
                $_SESSION['dashboard_error'] = "Failed to update enquiry status.";
            }
            $update_stmt->close();
            
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit();
        }
    }
}

// Get filter parameters
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$priority_filter = isset($_GET['priority']) ? $_GET['priority'] : '';
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';

// Pagination
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$per_page = 15;
$offset = ($page - 1) * $per_page;

// Build WHERE clause
$where_conditions = [];
$params = [];
$param_types = '';

if ($status_filter && $status_filter !== 'all') {
    $where_conditions[] = "e.status = ?";
    $params[] = $status_filter;
    $param_types .= 's';
}

if ($priority_filter && $priority_filter !== 'all') {
    $where_conditions[] = "e.priority = ?";
    $params[] = $priority_filter;
    $param_types .= 's';
}

if ($search_query) {
    $where_conditions[] = "(e.full_name LIKE ? OR e.email LIKE ? OR e.subject LIKE ? OR e.message LIKE ?)";
    $search_term = "%$search_query%";
    $params = array_merge($params, [$search_term, $search_term, $search_term, $search_term]);
    $param_types .= 'ssss';
}

$where_clause = !empty($where_conditions) ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

// Count total enquiries
$count_query = "SELECT COUNT(*) as total FROM enquiries e $where_clause";
$count_stmt = $conn->prepare($count_query);
if (!empty($params)) {
    $count_stmt->bind_param($param_types, ...$params);
}
$count_stmt->execute();
$total_enquiries = $count_stmt->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_enquiries / $per_page);
$count_stmt->close();

// Fetch enquiries
$query = "SELECT e.*, au.username as assigned_admin, au.full_name as assigned_admin_name
          FROM enquiries e 
          LEFT JOIN admin_users au ON e.assigned_to = au.id 
          $where_clause 
          ORDER BY 
            CASE e.priority 
                WHEN 'urgent' THEN 1
                WHEN 'high' THEN 2  
                WHEN 'medium' THEN 3
                WHEN 'low' THEN 4
            END,
            e.created_at DESC 
          LIMIT ? OFFSET ?";

$stmt = $conn->prepare($query);
$params[] = $per_page;
$params[] = $offset;
$param_types .= 'ii';

if (!empty($params)) {
    $stmt->bind_param($param_types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Get statistics
$stats_query = "SELECT 
    COUNT(*) as total,
    COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN 1 END) as today,
    COUNT(CASE WHEN created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 END) as week,
    COUNT(CASE WHEN status = 'new' THEN 1 END) as new_count,
    COUNT(CASE WHEN status = 'in_progress' THEN 1 END) as in_progress,
    COUNT(CASE WHEN priority = 'urgent' THEN 1 END) as urgent
    FROM enquiries";

$stats_result = $conn->query($stats_query);
$stats = $stats_result->fetch_assoc();

// Messages
$success_message = isset($_SESSION['dashboard_message']) ? $_SESSION['dashboard_message'] : '';
$error_message = isset($_SESSION['dashboard_error']) ? $_SESSION['dashboard_error'] : '';

if ($success_message) unset($_SESSION['dashboard_message']);
if ($error_message) unset($_SESSION['dashboard_error']);
?>