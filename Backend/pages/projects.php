<?php
// filepath: c:\xampp\htdocs\new4\Backend\pages\projects.php

session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

require_once '../db.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add_project':
                // Handle file uploads
                $image_main = '';
                $gallery_images = [];
                
                // Handle main image upload
                if (isset($_FILES['image_main']) && $_FILES['image_main']['error'] === UPLOAD_ERR_OK) {
                    $upload_dir = '../../assets/images/projects/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    
                    $file_extension = pathinfo($_FILES['image_main']['name'], PATHINFO_EXTENSION);
                    $filename = uniqid() . '.' . $file_extension;
                    $upload_path = $upload_dir . $filename;
                    
                    if (move_uploaded_file($_FILES['image_main']['tmp_name'], $upload_path)) {
                        $image_main = 'assets/images/projects/' . $filename;
                    }
                }
                
                // Handle gallery images
                if (isset($_FILES['gallery_images'])) {
                    $upload_dir = '../../assets/images/projects/gallery/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    
                    foreach ($_FILES['gallery_images']['tmp_name'] as $key => $tmp_name) {
                        if ($_FILES['gallery_images']['error'][$key] === UPLOAD_ERR_OK) {
                            $file_extension = pathinfo($_FILES['gallery_images']['name'][$key], PATHINFO_EXTENSION);
                            $filename = uniqid() . '.' . $file_extension;
                            $upload_path = $upload_dir . $filename;
                            
                            if (move_uploaded_file($tmp_name, $upload_path)) {
                                $gallery_images[] = 'assets/images/projects/gallery/' . $filename;
                            }
                        }
                    }
                }
                
                // Create slug from title
                $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_POST['title'])));
                
                $stmt = $conn->prepare("INSERT INTO projects (title, slug, category, description, detailed_description, image_main, image_gallery, services, project_url, date_completed, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $gallery_json = json_encode($gallery_images);
                $stmt->bind_param("sssssssssss", 
                    $_POST['title'], 
                    $slug, 
                    $_POST['category'], 
                    $_POST['description'], 
                    $_POST['detailed_description'], 
                    $image_main, 
                    $gallery_json, 
                    $_POST['services'], 
                    $_POST['project_url'], 
                    $_POST['date_completed'], 
                    $_POST['status']
                );
                
                if ($stmt->execute()) {
                    $_SESSION['success_message'] = 'Project added successfully!';
                } else {
                    $_SESSION['error_message'] = 'Error adding project.';
                }
                $stmt->close();
                break;
                
            case 'update_project':
                $id = $_POST['project_id'];
                $image_main = $_POST['current_image_main'];
                $gallery_images = json_decode($_POST['current_gallery_images'], true) ?: [];
                
                // Handle main image upload
                if (isset($_FILES['image_main']) && $_FILES['image_main']['error'] === UPLOAD_ERR_OK) {
                    $upload_dir = '../../assets/images/projects/';
                    $file_extension = pathinfo($_FILES['image_main']['name'], PATHINFO_EXTENSION);
                    $filename = uniqid() . '.' . $file_extension;
                    $upload_path = $upload_dir . $filename;
                    
                    if (move_uploaded_file($_FILES['image_main']['tmp_name'], $upload_path)) {
                        $image_main = 'assets/images/projects/' . $filename;
                    }
                }
                
                // Handle gallery images
                if (isset($_FILES['gallery_images'])) {
                    $upload_dir = '../../assets/images/projects/gallery/';
                    
                    foreach ($_FILES['gallery_images']['tmp_name'] as $key => $tmp_name) {
                        if ($_FILES['gallery_images']['error'][$key] === UPLOAD_ERR_OK) {
                            $file_extension = pathinfo($_FILES['gallery_images']['name'][$key], PATHINFO_EXTENSION);
                            $filename = uniqid() . '.' . $file_extension;
                            $upload_path = $upload_dir . $filename;
                            
                            if (move_uploaded_file($tmp_name, $upload_path)) {
                                $gallery_images[] = 'assets/images/projects/gallery/' . $filename;
                            }
                        }
                    }
                }
                
                $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_POST['title'])));
                $gallery_json = json_encode($gallery_images);
                
                $stmt = $conn->prepare("UPDATE projects SET title=?, slug=?, category=?, description=?, detailed_description=?, image_main=?, image_gallery=?, services=?, project_url=?, date_completed=?, status=? WHERE id=?");
                $stmt->bind_param("sssssssssssi", 
                    $_POST['title'], 
                    $slug, 
                    $_POST['category'], 
                    $_POST['description'], 
                    $_POST['detailed_description'], 
                    $image_main, 
                    $gallery_json, 
                    $_POST['services'], 
                    $_POST['project_url'], 
                    $_POST['date_completed'], 
                    $_POST['status'],
                    $id
                );
                
                if ($stmt->execute()) {
                    $_SESSION['success_message'] = 'Project updated successfully!';
                } else {
                    $_SESSION['error_message'] = 'Error updating project.';
                }
                $stmt->close();
                break;
                
            case 'delete_project':
                $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
                $stmt->bind_param("i", $_POST['project_id']);
                
                if ($stmt->execute()) {
                    $_SESSION['success_message'] = 'Project deleted successfully!';
                } else {
                    $_SESSION['error_message'] = 'Error deleting project.';
                }
                $stmt->close();
                break;
        }
        
        header('Location: projects.php');
        exit();
    }
}

// Fetch projects with filtering and search
$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter_category = isset($_GET['category']) ? $_GET['category'] : '';
$filter_status = isset($_GET['status']) ? $_GET['status'] : '';

$query = "SELECT * FROM projects WHERE 1=1";
$params = [];
$types = "";

if (!empty($search)) {
    $query .= " AND (title LIKE ? OR description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types .= "ss";
}

if (!empty($filter_category)) {
    $query .= " AND category = ?";
    $params[] = $filter_category;
    $types .= "s";
}

if (!empty($filter_status)) {
    $query .= " AND status = ?";
    $params[] = $filter_status;
    $types .= "s";
}

$query .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$projects = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Get categories for filter dropdown
$categories = $conn->query("SELECT DISTINCT category FROM projects WHERE category IS NOT NULL AND category != ''")->fetch_all(MYSQLI_ASSOC);

// Get project statistics
$stats = [];
$stats['total'] = count($projects);
$stats['active'] = count(array_filter($projects, function($p) { return $p['status'] === 'active'; }));
$stats['inactive'] = count(array_filter($projects, function($p) { return $p['status'] === 'inactive'; }));

// Get messages
$success_message = $_SESSION['success_message'] ?? '';
$error_message = $_SESSION['error_message'] ?? '';
unset($_SESSION['success_message'], $_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects Management - Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="../assets/css/projects.css" rel="stylesheet">
</head>
<body class="projects-management-page">
    <div class="dashboard-wrapper">
        <!-- Include header -->
        <?php include '../components/dashboard/header.php'; ?>
        
        <!-- Main Content -->
        <main class="main-content">
            <div class="content-wrapper">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="header-content">
                        <div class="header-left">
                            <div class="page-icon">
                                <div class="icon-wrapper">
                                    <i class="fas fa-project-diagram"></i>
                                </div>
                            </div>
                            <div class="page-info">
                                <h1 class="page-title">Projects Management</h1>
                                <p class="page-description">Manage your portfolio projects and showcase your creative work</p>
                            </div>
                        </div>
                        
                        <div class="header-actions">
                            <button class="action-btn secondary" onclick="exportProjects()">
                                <i class="fas fa-download"></i>
                                <span>Export</span>
                            </button>
                            <button class="action-btn primary" onclick="openAddModal()">
                                <i class="fas fa-plus"></i>
                                <span>Add Project</span>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Statistics Dashboard -->
                    <div class="stats-dashboard">
                        <div class="stat-card primary-stat">
                            <div class="stat-icon">
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value"><?php echo $stats['total']; ?></div>
                                <div class="stat-label">Total Projects</div>
                                <div class="stat-trend">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>+12% from last month</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="stat-card success-stat">
                            <div class="stat-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value"><?php echo $stats['active']; ?></div>
                                <div class="stat-label">Active Projects</div>
                                <div class="stat-trend">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>+8% from last month</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="stat-card warning-stat">
                            <div class="stat-icon">
                                <i class="fas fa-pause-circle"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value"><?php echo $stats['inactive']; ?></div>
                                <div class="stat-label">Inactive Projects</div>
                                <div class="stat-trend">
                                    <i class="fas fa-arrow-down"></i>
                                    <span>-3% from last month</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="stat-card info-stat">
                            <div class="stat-icon">
                                <i class="fas fa-eye"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value">1.2K</div>
                                <div class="stat-label">Total Views</div>
                                <div class="stat-trend">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>+15% from last month</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Alert Messages -->
                <?php if ($success_message): ?>
                    <div class="alert alert-success">
                        <div class="alert-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="alert-content">
                            <span><?php echo htmlspecialchars($success_message); ?></span>
                        </div>
                        <button class="alert-close" onclick="closeAlert(this)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                <?php endif; ?>
                
                <?php if ($error_message): ?>
                    <div class="alert alert-error">
                        <div class="alert-icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div class="alert-content">
                            <span><?php echo htmlspecialchars($error_message); ?></span>
                        </div>
                        <button class="alert-close" onclick="closeAlert(this)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                <?php endif; ?>
                
                <!-- Projects Section -->
                <div class="projects-section">
                    <div class="section-header">
                        <div class="section-title">
                            <h2>Project Library</h2>
                            <span class="project-count"><?php echo count($projects); ?> projects</span>
                        </div>
                        
                        <div class="section-controls">
                            <div class="view-switcher">
                                <button class="view-btn active" data-view="grid" onclick="switchView('grid')" title="Grid View">
                                    <i class="fas fa-th-large"></i>
                                </button>
                                <button class="view-btn" data-view="list" onclick="switchView('list')" title="List View">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                            
                            <div class="bulk-actions">
                                <button class="bulk-btn" onclick="selectAll()" title="Select All">
                                    <i class="fas fa-check-square"></i>
                                </button>
                                <button class="bulk-btn" onclick="bulkDelete()" title="Delete Selected">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Filters Bar -->
                    <div class="filters-section">
                        <form method="GET" class="filters-form">
                            <div class="filter-group search-group">
                                <div class="search-container">
                                    <i class="fas fa-search search-icon"></i>
                                    <input type="text" name="search" placeholder="Search projects by title or description..." 
                                           value="<?php echo htmlspecialchars($search); ?>" class="search-input">
                                </div>
                            </div>
                            
                            <div class="filter-group">
                                <label class="filter-label">Category</label>
                                <select name="category" class="filter-select">
                                    <option value="">All Categories</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo htmlspecialchars($cat['category']); ?>" 
                                                <?php echo $filter_category === $cat['category'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars(ucfirst(str_replace('-', ' ', $cat['category']))); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="filter-group">
                                <label class="filter-label">Status</label>
                                <select name="status" class="filter-select">
                                    <option value="">All Status</option>
                                    <option value="active" <?php echo $filter_status === 'active' ? 'selected' : ''; ?>>Active</option>
                                    <option value="inactive" <?php echo $filter_status === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                            
                            <div class="filter-actions">
                                <button type="submit" class="filter-btn apply-btn">
                                    <i class="fas fa-filter"></i>
                                    <span>Apply Filters</span>
                                </button>
                                <a href="projects.php" class="filter-btn clear-btn">
                                    <i class="fas fa-times"></i>
                                    <span>Clear</span>
                                </a>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Projects Container -->
                    <div class="projects-container">
                        <?php if (!empty($projects)): ?>
                            <!-- Grid View -->
                            <div class="projects-grid view-grid active">
                                <?php foreach ($projects as $project): ?>
                                    <div class="project-card" data-project-id="<?php echo $project['id']; ?>">
                                        <div class="card-header">
                                            <div class="card-checkbox">
                                                <input type="checkbox" class="project-checkbox" value="<?php echo $project['id']; ?>">
                                                <span class="checkmark"></span>
                                            </div>
                                            <div class="card-status">
                                                <span class="status-badge status-<?php echo $project['status']; ?>">
                                                    <?php echo ucfirst($project['status']); ?>
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="project-image">
                                            <img src="../../<?php echo htmlspecialchars($project['image_main']); ?>" 
                                                 alt="<?php echo htmlspecialchars($project['title']); ?>" 
                                                 loading="lazy">
                                            <div class="image-overlay">
                                                <div class="overlay-actions">
                                                    <button class="overlay-btn" onclick="viewProject('<?php echo urlencode($project['slug']); ?>')" 
                                                            title="View Project">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="overlay-btn" onclick="editProject(<?php echo $project['id']; ?>)" 
                                                            title="Edit Project">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="overlay-btn delete-btn" onclick="deleteProject(<?php echo $project['id']; ?>)" 
                                                            title="Delete Project">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="project-content">
                                            <div class="project-category">
                                                <i class="fas fa-tag"></i>
                                                <span><?php echo htmlspecialchars(ucfirst(str_replace('-', ' ', $project['category']))); ?></span>
                                            </div>
                                            
                                            <h3 class="project-title">
                                                <?php echo htmlspecialchars($project['title']); ?>
                                            </h3>
                                            
                                            <p class="project-description">
                                                <?php echo htmlspecialchars(substr($project['description'], 0, 120)); ?>
                                                <?php if (strlen($project['description']) > 120): ?>...<?php endif; ?>
                                            </p>
                                            
                                            <div class="project-meta">
                                                <div class="meta-item">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    <span><?php echo date('M j, Y', strtotime($project['created_at'])); ?></span>
                                                </div>
                                                <?php if ($project['project_url']): ?>
                                                    <div class="meta-item">
                                                        <a href="<?php echo htmlspecialchars($project['project_url']); ?>" 
                                                           target="_blank" class="external-link">
                                                            <i class="fas fa-external-link-alt"></i>
                                                            <span>Live Preview</span>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="card-footer">
                                            <div class="quick-actions">
                                                <button class="quick-action-btn" onclick="duplicateProject(<?php echo $project['id']; ?>)" 
                                                        title="Duplicate Project">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                                <button class="quick-action-btn" onclick="toggleStatus(<?php echo $project['id']; ?>)" 
                                                        title="Toggle Status">
                                                    <i class="fas fa-toggle-<?php echo $project['status'] === 'active' ? 'on' : 'off'; ?>"></i>
                                                </button>
                                                <button class="quick-action-btn" onclick="shareProject('<?php echo urlencode($project['slug']); ?>')" 
                                                        title="Share Project">
                                                    <i class="fas fa-share-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <!-- List View -->
                            <div class="projects-list view-list">
                                <div class="list-header">
                                    <div class="list-column">
                                        <input type="checkbox" id="selectAllList" onclick="toggleSelectAll()">
                                        <span>Project</span>
                                    </div>
                                    <div class="list-column">Category</div>
                                    <div class="list-column">Status</div>
                                    <div class="list-column">Created</div>
                                    <div class="list-column">Actions</div>
                                </div>
                                
                                <div class="list-body">
                                    <?php foreach ($projects as $project): ?>
                                        <div class="list-row" data-project-id="<?php echo $project['id']; ?>">
                                            <div class="list-column project-column">
                                                <input type="checkbox" class="project-checkbox" value="<?php echo $project['id']; ?>">
                                                <div class="project-info">
                                                    <div class="project-thumbnail">
                                                        <img src="../../<?php echo htmlspecialchars($project['image_main']); ?>" 
                                                             alt="<?php echo htmlspecialchars($project['title']); ?>">
                                                    </div>
                                                    <div class="project-details">
                                                        <div class="project-name">
                                                            <?php echo htmlspecialchars($project['title']); ?>
                                                        </div>
                                                        <div class="project-slug">
                                                            <?php echo htmlspecialchars($project['slug']); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="list-column">
                                                <span class="category-tag">
                                                    <?php echo htmlspecialchars(ucfirst(str_replace('-', ' ', $project['category']))); ?>
                                                </span>
                                            </div>
                                            
                                            <div class="list-column">
                                                <span class="status-badge status-<?php echo $project['status']; ?>">
                                                    <i class="fas fa-circle"></i>
                                                    <?php echo ucfirst($project['status']); ?>
                                                </span>
                                            </div>
                                            
                                            <div class="list-column">
                                                <div class="date-info">
                                                    <div class="date-primary">
                                                        <?php echo date('M j, Y', strtotime($project['created_at'])); ?>
                                                    </div>
                                                    <div class="date-secondary">
                                                        <?php echo date('g:i A', strtotime($project['created_at'])); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="list-column">
                                                <div class="action-buttons">
                                                    <button class="action-btn view-btn" 
                                                            onclick="viewProject('<?php echo urlencode($project['slug']); ?>')" 
                                                            title="View Project">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="action-btn edit-btn" 
                                                            onclick="editProject(<?php echo $project['id']; ?>)" 
                                                            title="Edit Project">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="action-btn delete-btn" 
                                                            onclick="deleteProject(<?php echo $project['id']; ?>)" 
                                                            title="Delete Project">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- Empty State -->
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-folder-open"></i>
                                </div>
                                <h3 class="empty-title">No Projects Found</h3>
                                <p class="empty-description">
                                    Start building your amazing portfolio by creating your first project. 
                                    Showcase your creativity and attract potential clients!
                                </p>
                                <button class="empty-action-btn" onclick="openAddModal()">
                                    <i class="fas fa-plus"></i>
                                    <span>Create Your First Project</span>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Add/Edit Project Modal -->
    <div id="projectModal" class="modal-overlay">
        <div class="modal-container large-modal">
            <div class="modal-header">
                <div class="modal-title-section">
                    <div class="modal-icon">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <div class="modal-title-content">
                        <h3 id="modal-title">Add New Project</h3>
                        <p class="modal-subtitle">Create a stunning project for your portfolio</p>
                    </div>
                </div>
                <button class="modal-close" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="projectForm" method="POST" enctype="multipart/form-data" class="project-form">
                <div class="modal-body">
                    <input type="hidden" name="action" value="add_project" id="form-action">
                    <input type="hidden" name="project_id" id="project-id">
                    <input type="hidden" name="current_image_main" id="current-image-main">
                    <input type="hidden" name="current_gallery_images" id="current-gallery-images">
                    
                    <div class="form-sections">
                        <!-- Basic Information Section -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div class="section-title">
                                    <h4>Basic Information</h4>
                                    <p>Essential details about your project</p>
                                </div>
                            </div>
                            
                            <div class="form-grid">
                                <div class="form-group full-width">
                                    <label for="title" class="form-label">Project Title *</label>
                                    <input type="text" id="title" name="title" class="form-input" required 
                                           placeholder="Enter an engaging project title">
                                    <div class="form-help">This will be the main title displayed in your portfolio</div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="category" class="form-label">Category *</label>
                                    <select id="category" name="category" class="form-select" required>
                                        <option value="">Select Category</option>
                                        <option value="branding">🎨 Branding</option>
                                        <option value="web-design">💻 Web Design</option>
                                        <option value="mobile-app">📱 Mobile App</option>
                                        <option value="ui-ux">🎯 UI/UX Design</option>
                                        <option value="logo-design">✨ Logo Design</option>
                                        <option value="print-design">📄 Print Design</option>
                                        <option value="packaging">📦 Packaging</option>
                                        <option value="illustration">🎨 Illustration</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="status" class="form-label">Status</label>
                                    <select id="status" name="status" class="form-select">
                                        <option value="active">✅ Active</option>
                                        <option value="inactive">⏸️ Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Project Details Section -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon">
                                    <i class="fas fa-align-left"></i>
                                </div>
                                <div class="section-title">
                                    <h4>Project Details</h4>
                                    <p>Detailed information about your project</p>
                                </div>
                            </div>
                            
                            <div class="form-grid">
                                <div class="form-group full-width">
                                    <label for="description" class="form-label">Short Description</label>
                                    <textarea id="description" name="description" class="form-textarea" rows="3"
                                              placeholder="A compelling brief description of your project"></textarea>
                                    <div class="form-help">This appears in project listings and previews</div>
                                </div>
                                
                                <div class="form-group full-width">
                                    <label for="detailed_description" class="form-label">Detailed Description</label>
                                    <textarea id="detailed_description" name="detailed_description" class="form-textarea" rows="6"
                                              placeholder="Tell the complete story of your project, including challenges, solutions, and outcomes"></textarea>
                                    <div class="form-help">Full project description for the detailed project page</div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="services" class="form-label">Services Provided</label>
                                    <input type="text" id="services" name="services" class="form-input" 
                                           placeholder="e.g., Logo Design, Business Cards, Website">
                                    <div class="form-help">Comma-separated list of services</div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="project_url" class="form-label">Project URL</label>
                                    <input type="url" id="project_url" name="project_url" class="form-input" 
                                           placeholder="https://example.com">
                                    <div class="form-help">Link to the live project (optional)</div>
                                </div>
                                
                                <div class="form-group full-width">
                                    <label for="date_completed" class="form-label">Completion Date</label>
                                    <input type="date" id="date_completed" name="date_completed" class="form-input">
                                    <div class="form-help">When was this project completed?</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Media Upload Section -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon">
                                    <i class="fas fa-images"></i>
                                </div>
                                <div class="section-title">
                                    <h4>Project Media</h4>
                                    <p>Upload high-quality images to showcase your work</p>
                                </div>
                            </div>
                            
                            <div class="form-grid">
                                <div class="form-group full-width">
                                    <label for="image_main" class="form-label">Main Project Image *</label>
                                    <div class="file-upload-area main-image-upload" id="main-image-upload">
                                        <div class="upload-content">
                                            <div class="upload-icon">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                            </div>
                                            <div class="upload-text">
                                                <h4>Drop your main image here</h4>
                                                <p>or <span class="upload-link">browse files</span></p>
                                            </div>
                                            <div class="upload-specs">
                                                <span>PNG, JPG, WebP up to 5MB</span>
                                            </div>
                                        </div>
                                        <input type="file" id="image_main" name="image_main" accept="image/*" 
                                               class="file-input" required>
                                    </div>
                                    <div class="image-preview" id="main-image-preview"></div>
                                </div>
                                
                                <div class="form-group full-width">
                                    <label for="gallery_images" class="form-label">Gallery Images</label>
                                    <div class="file-upload-area gallery-upload" id="gallery-images-upload">
                                        <div class="upload-content">
                                            <div class="upload-icon">
                                                <i class="fas fa-images"></i>
                                            </div>
                                            <div class="upload-text">
                                                <h4>Upload multiple images</h4>
                                                <p>Showcase different aspects of your project</p>
                                            </div>
                                            <div class="upload-specs">
                                                <span>PNG, JPG, WebP up to 5MB each</span>
                                            </div>
                                        </div>
                                        <input type="file" id="gallery_images" name="gallery_images[]" accept="image/*" 
                                               class="file-input" multiple>
                                    </div>
                                    <div class="images-preview" id="gallery-images-preview"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">
                        <i class="fas fa-times"></i>
                        <span>Cancel</span>
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        <span id="submit-text">Save Project</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal-overlay">
        <div class="modal-container small-modal">
            <div class="modal-header danger">
                <div class="modal-title-section">
                    <div class="modal-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="modal-title-content">
                        <h3>Delete Project</h3>
                        <p class="modal-subtitle">This action cannot be undone</p>
                    </div>
                </div>
            </div>
            
            <div class="modal-body">
                <div class="delete-warning">
                    <p>Are you sure you want to delete this project? This will permanently remove:</p>
                    <ul class="delete-list">
                        <li>Project information and details</li>
                        <li>All uploaded images</li>
                        <li>Project statistics and data</li>
                    </ul>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">
                    <span>Cancel</span>
                </button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                    <i class="fas fa-trash"></i>
                    <span>Delete Project</span>
                </button>
            </div>
        </div>
    </div>
    
    <!-- JavaScript -->
    <script>
        let projectToDelete = null;
        
        // View project
        function viewProject(slug) {
            window.open(`../../project.php?slug=${slug}`, '_blank');
        }
        
        // Edit project
        function editProject(id) {
            // Fetch project data and populate modal
            fetch(`get_project.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        populateEditForm(data.project);
                        openEditModal();
                    }
                })
                .catch(error => console.error('Error:', error));
        }
        
        function populateEditForm(project) {
            document.getElementById('form-action').value = 'update_project';
            document.getElementById('project-id').value = project.id;
            document.getElementById('modal-title').textContent = 'Edit Project';
            document.getElementById('submit-text').textContent = 'Update Project';
            
            document.getElementById('title').value = project.title;
            document.getElementById('category').value = project.category;
            document.getElementById('status').value = project.status;
            document.getElementById('description').value = project.description;
            document.getElementById('detailed_description').value = project.detailed_description;
            document.getElementById('services').value = project.services;
            document.getElementById('project_url').value = project.project_url;
            document.getElementById('date_completed').value = project.date_completed;
            
            document.getElementById('current-image-main').value = project.image_main;
            document.getElementById('current-gallery-images').value = project.image_gallery;
        }
        
        // Delete project
        function deleteProject(id) {
            projectToDelete = id;
            document.getElementById('deleteModal').style.display = 'block';
        }
        
        function confirmDelete() {
            if (projectToDelete) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="delete_project">
                    <input type="hidden" name="project_id" value="${projectToDelete}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
        
        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
            projectToDelete = null;
        }
        
        // Modal functions
        function openAddModal() {
            resetForm();
            document.getElementById('projectModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
        
        function openEditModal() {
            document.getElementById('projectModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
        
        function closeModal() {
            document.getElementById('projectModal').style.display = 'none';
            document.body.style.overflow = '';
            resetForm();
        }
        
        function resetForm() {
            document.getElementById('projectForm').reset();
            document.getElementById('form-action').value = 'add_project';
            document.getElementById('modal-title').textContent = 'Add New Project';
            document.getElementById('submit-text').textContent = 'Save Project';
            document.getElementById('main-image-preview').innerHTML = '';
            document.getElementById('gallery-images-preview').innerHTML = '';
        }
        
        // View switcher
        function switchView(view) {
            document.querySelectorAll('.view-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelector(`[data-view="${view}"]`).classList.add('active');
            
            if (view === 'grid') {
                document.querySelector('.projects-grid').classList.add('active');
                document.querySelector('.projects-list').classList.remove('active');
            } else {
                document.querySelector('.projects-list').classList.add('active');
                document.querySelector('.projects-grid').classList.remove('active');
            }
        }
        
        // Alert functions
        function closeAlert(element) {
            element.parentElement.style.display = 'none';
        }
        
        // Bulk actions
        function selectAll() {
            const checkboxes = document.querySelectorAll('.project-checkbox');
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            checkboxes.forEach(cb => cb.checked = !allChecked);
        }
        
        function toggleSelectAll() {
            const selectAllCheckbox = document.getElementById('selectAllList');
            const checkboxes = document.querySelectorAll('.project-checkbox');
            checkboxes.forEach(cb => cb.checked = selectAllCheckbox.checked);
        }
        
        function bulkDelete() {
            const selected = document.querySelectorAll('.project-checkbox:checked');
            if (selected.length === 0) {
                alert('Please select projects to delete');
                return;
            }
            
            if (confirm(`Are you sure you want to delete ${selected.length} project(s)?`)) {
                // Implement bulk delete logic
                console.log('Bulk delete:', Array.from(selected).map(cb => cb.value));
            }
        }
        
        // Export function
        function exportProjects() {
            window.location.href = 'export_projects.php';
        }
        
        // Additional functions
        function duplicateProject(id) {
            console.log('Duplicate project:', id);
        }
        
        function toggleStatus(id) {
            console.log('Toggle status:', id);
        }
        
        function shareProject(slug) {
            const url = `${window.location.origin}/project.php?slug=${slug}`;
            navigator.clipboard.writeText(url).then(() => {
                alert('Project URL copied to clipboard!');
            });
        }
        
        // File upload handling
        document.addEventListener('DOMContentLoaded', function() {
            // Handle main image upload
            const mainImageInput = document.getElementById('image_main');
            const mainImagePreview = document.getElementById('main-image-preview');
            
            mainImageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        mainImagePreview.innerHTML = `
                            <div class="preview-image">
                                <img src="${e.target.result}" alt="Preview">
                                <button type="button" class="remove-image" onclick="removeMainImage()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        `;
                    };
                    reader.readAsDataURL(file);
                }
            });
            
            // Handle gallery images upload
            const galleryImagesInput = document.getElementById('gallery_images');
            const galleryImagesPreview = document.getElementById('gallery-images-preview');
            
            galleryImagesInput.addEventListener('change', function(e) {
                const files = Array.from(e.target.files);
                galleryImagesPreview.innerHTML = '';
                
                files.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewDiv = document.createElement('div');
                        previewDiv.className = 'preview-image';
                        previewDiv.innerHTML = `
                            <img src="${e.target.result}" alt="Gallery Preview">
                            <button type="button" class="remove-image" onclick="removeGalleryImage(${index})">
                                <i class="fas fa-times"></i>
                            </button>
                        `;
                        galleryImagesPreview.appendChild(previewDiv);
                    };
                    reader.readAsDataURL(file);
                });
            });
        });
        
        function removeMainImage() {
            document.getElementById('image_main').value = '';
            document.getElementById('main-image-preview').innerHTML = '';
        }
        
        function removeGalleryImage(index) {
            // Implementation for removing specific gallery image
            console.log('Remove gallery image at index:', index);
        }
    </script>
</body>
</html>