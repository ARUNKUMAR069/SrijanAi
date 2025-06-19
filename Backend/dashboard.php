
<?php
// filepath: c:\xampp\htdocs\new4\backend\dashboard.php

session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

require_once 'db.php';

// Ensure all session variables are set (fix for warnings)
if (!isset($_SESSION['admin_full_name']) || !isset($_SESSION['admin_role'])) {
    // Get admin details from database
    $admin_stmt = $conn->prepare("SELECT full_name, role FROM admin_users WHERE id = ?");
    $admin_stmt->bind_param("i", $_SESSION['admin_id']);
    $admin_stmt->execute();
    $admin_result = $admin_stmt->get_result();
    
    if ($admin_data = $admin_result->fetch_assoc()) {
        $_SESSION['admin_full_name'] = $admin_data['full_name'];
        $_SESSION['admin_role'] = $admin_data['role'];
    } else {
        // Fallback values
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
            
            // Redirect to prevent form resubmission
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit();
        }
    }
}

// Get filter parameters
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$priority_filter = isset($_GET['priority']) ? $_GET['priority'] : '';
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';

// Get enquiries with pagination
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

// Get messages
$success_message = isset($_SESSION['dashboard_message']) ? $_SESSION['dashboard_message'] : '';
$error_message = isset($_SESSION['dashboard_error']) ? $_SESSION['dashboard_error'] : '';

// Clear messages after displaying
if ($success_message) unset($_SESSION['dashboard_message']);
if ($error_message) unset($_SESSION['dashboard_error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - AI Enquiry System</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="robots" content="noindex, nofollow">
</head>
<body class="dashboard-page">
    <div class="dashboard-container">
        <!-- Header -->
        <header class="dashboard-header">
            <div class="header-content">
                <div class="header-left">
                    <h1><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h1>
                    <span class="subtitle">AI Enquiry Management System</span>
                </div>
                <div class="header-right">
                    <div class="admin-info">
                        <i class="fas fa-user-circle"></i>
                        <span>Welcome, <?php echo htmlspecialchars($_SESSION['admin_full_name'] ?: $_SESSION['admin_username'] ?: 'Admin'); ?></span>
                        <span class="role-badge"><?php echo htmlspecialchars(ucfirst($_SESSION['admin_role'] ?: 'admin')); ?></span>
                    </div>
                    <a href="logout.php" class="logout-btn" onclick="return confirm('Are you sure you want to logout?')">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </div>
            </div>
        </header>

        <!-- Messages -->
        <?php if ($success_message): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?php echo htmlspecialchars($success_message); ?>
        </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo htmlspecialchars($error_message); ?>
        </div>
        <?php endif; ?>

        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="stat-content">
                    <h3><?php echo number_format($stats['total']); ?></h3>
                    <p>Total Enquiries</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <h3><?php echo number_format($stats['today']); ?></h3>
                    <p>Today's Enquiries</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-content">
                    <h3><?php echo number_format($stats['week']); ?></h3>
                    <p>This Week</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-content">
                    <h3><?php echo number_format($stats['new_count']); ?></h3>
                    <p>New Enquiries</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon urgent">
                    <i class="fas fa-fire"></i>
                </div>
                <div class="stat-content">
                    <h3><?php echo number_format($stats['urgent']); ?></h3>
                    <p>Urgent Priority</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon progress">
                    <i class="fas fa-spinner"></i>
                </div>
                <div class="stat-content">
                    <h3><?php echo number_format($stats['in_progress']); ?></h3>
                    <p>In Progress</p>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters-container">
            <form method="GET" class="filters-form">
                <div class="filter-group">
                    <label for="status">Status:</label>
                    <select name="status" id="status">
                        <option value="">All Statuses</option>
                        <option value="new" <?php echo $status_filter === 'new' ? 'selected' : ''; ?>>New</option>
                        <option value="read" <?php echo $status_filter === 'read' ? 'selected' : ''; ?>>Read</option>
                        <option value="in_progress" <?php echo $status_filter === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                        <option value="responded" <?php echo $status_filter === 'responded' ? 'selected' : ''; ?>>Responded</option>
                        <option value="closed" <?php echo $status_filter === 'closed' ? 'selected' : ''; ?>>Closed</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="priority">Priority:</label>
                    <select name="priority" id="priority">
                        <option value="">All Priorities</option>
                        <option value="low" <?php echo $priority_filter === 'low' ? 'selected' : ''; ?>>Low</option>
                        <option value="medium" <?php echo $priority_filter === 'medium' ? 'selected' : ''; ?>>Medium</option>
                        <option value="high" <?php echo $priority_filter === 'high' ? 'selected' : ''; ?>>High</option>
                        <option value="urgent" <?php echo $priority_filter === 'urgent' ? 'selected' : ''; ?>>Urgent</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="search">Search:</label>
                    <input type="text" name="search" id="search" placeholder="Name, email, subject..." value="<?php echo htmlspecialchars($search_query); ?>">
                </div>
                
                <button type="submit" class="filter-btn">
                    <i class="fas fa-filter"></i> Filter
                </button>
                
                <a href="dashboard.php" class="clear-btn">
                    <i class="fas fa-times"></i> Clear
                </a>
            </form>
        </div>

        <!-- Enquiries Table -->
        <div class="table-container">
            <div class="table-header">
                <h2><i class="fas fa-list"></i> Enquiries (<?php echo number_format($total_enquiries); ?> total)</h2>
                <div class="table-actions">
                    <button onclick="window.location.reload()" class="refresh-btn">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button onclick="exportData()" class="export-btn">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>
            
            <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="enquiries-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr data-enquiry-id="<?php echo $row['id']; ?>" class="enquiry-row priority-<?php echo $row['priority']; ?> status-<?php echo $row['status']; ?>">
                            <td class="id-cell"><?php echo htmlspecialchars($row['id']); ?></td>
                            <td class="name-cell">
                                <strong><?php echo htmlspecialchars($row['full_name']); ?></strong>
                                <?php if ($row['assigned_admin']): ?>
                                <br><small class="assigned">Assigned to: <?php echo htmlspecialchars($row['assigned_admin_name'] ?: $row['assigned_admin']); ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" class="email-link">
                                    <?php echo htmlspecialchars($row['email']); ?>
                                </a>
                            </td>
                            <td>
                                <a href="tel:<?php echo htmlspecialchars($row['mobile']); ?>" class="phone-link">
                                    <?php echo htmlspecialchars($row['mobile']); ?>
                                </a>
                            </td>
                            <td class="subject-cell">
                                <?php echo htmlspecialchars($row['subject']); ?>
                            </td>
                            <td class="message-cell">
                                <?php 
                                $message = htmlspecialchars($row['message'] ?: '');
                                echo strlen($message) > 50 ? substr($message, 0, 50) . '...' : $message;
                                ?>
                                <?php if (strlen($message) > 50): ?>
                                <br><a href="#" onclick="showFullMessage(<?php echo $row['id']; ?>)" class="view-more">View Full</a>
                                <?php endif; ?>
                            </td>
                            <td class="date-cell">
                                <span class="date"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></span>
                                <span class="time"><?php echo date('H:i', strtotime($row['created_at'])); ?></span>
                                <br><small class="time-ago"><?php echo timeAgo($row['created_at']); ?></small>
                            </td>
                            <td>
                                <form method="POST" class="status-form" style="display: inline;">
                                    <input type="hidden" name="action" value="update_status">
                                    <input type="hidden" name="enquiry_id" value="<?php echo $row['id']; ?>">
                                    <select name="new_status" onchange="updateStatus(this)" class="status-select status-<?php echo $row['status']; ?>">
                                        <option value="new" <?php echo $row['status'] === 'new' ? 'selected' : ''; ?>>New</option>
                                        <option value="read" <?php echo $row['status'] === 'read' ? 'selected' : ''; ?>>Read</option>
                                        <option value="in_progress" <?php echo $row['status'] === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                                        <option value="responded" <?php echo $row['status'] === 'responded' ? 'selected' : ''; ?>>Responded</option>
                                        <option value="closed" <?php echo $row['status'] === 'closed' ? 'selected' : ''; ?>>Closed</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <span class="priority-badge priority-<?php echo $row['priority']; ?>">
                                    <?php if ($row['priority'] === 'urgent'): ?>
                                        <i class="fas fa-fire"></i>
                                    <?php elseif ($row['priority'] === 'high'): ?>
                                        <i class="fas fa-exclamation-triangle"></i>
                                    <?php endif; ?>
                                    <?php echo ucfirst($row['priority']); ?>
                                </span>
                            </td>
                            <td class="actions-cell">
                                <div class="action-buttons">
                                    <button onclick="viewEnquiry(<?php echo $row['id']; ?>)" class="action-btn view-btn" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button onclick="emailCustomer('<?php echo htmlspecialchars($row['email']); ?>')" class="action-btn email-btn" title="Send Email">
                                        <i class="fas fa-envelope"></i>
                                    </button>
                                    <button onclick="deleteEnquiry(<?php echo $row['id']; ?>)" class="action-btn delete-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>&status=<?php echo urlencode($status_filter); ?>&priority=<?php echo urlencode($priority_filter); ?>&search=<?php echo urlencode($search_query); ?>" class="page-btn">
                    <i class="fas fa-chevron-left"></i> Previous
                </a>
                <?php endif; ?>
                
                <div class="page-numbers">
                    <?php
                    $start = max(1, $page - 2);
                    $end = min($total_pages, $page + 2);
                    
                    for ($i = $start; $i <= $end; $i++):
                    ?>
                    <a href="?page=<?php echo $i; ?>&status=<?php echo urlencode($status_filter); ?>&priority=<?php echo urlencode($priority_filter); ?>&search=<?php echo urlencode($search_query); ?>" 
                       class="page-number <?php echo $i === $page ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                    <?php endfor; ?>
                </div>
                
                <span class="page-info">
                    Page <?php echo $page; ?> of <?php echo $total_pages; ?> 
                    (<?php echo number_format($total_enquiries); ?> total entries)
                </span>
                
                <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo $page + 1; ?>&status=<?php echo urlencode($status_filter); ?>&priority=<?php echo urlencode($priority_filter); ?>&search=<?php echo urlencode($search_query); ?>" class="page-btn">
                    Next <i class="fas fa-chevron-right"></i>
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            
            <?php else: ?>
            <div class="no-data">
                <i class="fas fa-inbox"></i>
                <h3>No Enquiries Found</h3>
                <p>
                    <?php if ($search_query || $status_filter || $priority_filter): ?>
                        No enquiries match your current filters. <a href="dashboard.php">Clear filters</a> to see all enquiries.
                    <?php else: ?>
                        No enquiry submissions have been received yet.
                    <?php endif; ?>
                </p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal for viewing full enquiry details -->
    <div id="enquiryModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Enquiry Details</h3>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    <script>
    // Auto-hide alerts
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
    });

    function updateStatus(selectElement) {
        if (confirm('Are you sure you want to change the status of this enquiry?')) {
            selectElement.form.submit();
        } else {
            // Reset to original value if cancelled
            selectElement.selectedIndex = selectElement.defaultIndex;
        }
    }

    function viewEnquiry(id) {
        fetch(`enquiry-details.php?id=${id}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById('modalBody').innerHTML = data;
                document.getElementById('enquiryModal').style.display = 'block';
            })
            .catch(error => {
                alert('Error loading enquiry details: ' + error.message);
            });
    }

    function showFullMessage(id) {
        viewEnquiry(id);
    }

    function closeModal() {
        document.getElementById('enquiryModal').style.display = 'none';
    }

    function emailCustomer(email) {
        window.location.href = `mailto:${email}`;
    }

    function deleteEnquiry(id) {
        if (confirm('Are you sure you want to delete this enquiry? This action cannot be undone.')) {
            fetch('delete-enquiry.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `enquiry_id=${id}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error deleting enquiry: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error deleting enquiry: ' + error.message);
            });
        }
    }

    function exportData() {
        const params = new URLSearchParams(window.location.search);
        const exportUrl = 'export-enquiries.php?' + params.toString();
        window.open(exportUrl, '_blank');
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('enquiryModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
    </script>
</body>
</html>

<?php
// Helper function for time ago
function timeAgo($datetime) {
    $time = time() - strtotime($datetime);
    
    if ($time < 60) return 'Just now';
    if ($time < 3600) return floor($time/60) . 'm ago';
    if ($time < 86400) return floor($time/3600) . 'h ago';
    if ($time < 2592000) return floor($time/86400) . 'd ago';
    
    return date('M j, Y', strtotime($datetime));
}

$stmt->close();
$conn->close();
?>