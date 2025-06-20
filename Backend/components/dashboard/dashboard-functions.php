<?php
// filepath: c:\xampp\htdocs\new4\backend\components\dashboard\dashboard-functions.php

// Helper function for time ago
function timeAgo($datetime) {
    $time = time() - strtotime($datetime);
    
    if ($time < 60) return 'Just now';
    if ($time < 3600) return floor($time/60) . 'm ago';
    if ($time < 86400) return floor($time/3600) . 'h ago';
    if ($time < 2592000) return floor($time/86400) . 'd ago';
    
    return date('M j, Y', strtotime($datetime));
}

// Function to get priority icon
function getPriorityIcon($priority) {
    switch ($priority) {
        case 'urgent':
            return '<i class="fas fa-fire" aria-hidden="true"></i>';
        case 'high':
            return '<i class="fas fa-exclamation-triangle" aria-hidden="true"></i>';
        case 'medium':
            return '<i class="fas fa-circle" aria-hidden="true"></i>';
        case 'low':
            return '<i class="fas fa-circle-o" aria-hidden="true"></i>';
        default:
            return '<i class="fas fa-circle" aria-hidden="true"></i>';
    }
}

// Function to get status badge class
function getStatusBadgeClass($status) {
    $classes = [
        'new' => 'status-new',
        'read' => 'status-read',
        'in_progress' => 'status-progress',
        'responded' => 'status-responded',
        'closed' => 'status-closed'
    ];
    
    return $classes[$status] ?? 'status-default';
}

// Function to format enquiry message
function formatMessage($message, $limit = 50) {
    $message = htmlspecialchars($message ?: '');
    if (strlen($message) > $limit) {
        return substr($message, 0, $limit) . '...';
    }
    return $message;
}
?>