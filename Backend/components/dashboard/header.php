<?php
// filepath: c:\xampp\htdocs\new4\backend\components\dashboard\header.php
?>

<!-- Modern Dashboard Header -->
<header class="dashboard-header modern-header">
    <div class="header-content">
        <div class="header-left">
            <div class="logo-section">
                <div class="dashboard-logo">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="header-titles">
                    <h1 class="main-title">Admin Dashboard</h1>
                    <span class="subtitle">Management Console</span>
                </div>
            </div>
        </div>
        
        <div class="header-center">
            <div class="search-container">
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="global-search" placeholder="Quick search..." 
                           onkeyup="globalSearch(this.value)">
                </div>
            </div>
        </div>
        
        <div class="header-right">
            <div class="header-actions">
                <!-- Notifications -->
                <div class="action-item notifications">
                    <button class="action-btn" onclick="toggleNotifications()">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge"><?php echo $stats['new_count'] ?? 0; ?></span>
                    </button>
                    <div class="notifications-dropdown" id="notificationsDropdown">
                        <div class="notifications-header">
                            <h4>Recent Notifications</h4>
                            <span class="mark-all-read">Mark all read</span>
                        </div>
                        <div class="notifications-list">
                            <div class="notification-item new">
                                <i class="fas fa-envelope text-primary"></i>
                                <div class="notification-content">
                                    <p>New enquiry received</p>
                                    <small>2 minutes ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Settings -->
                <div class="action-item">
                    <button class="action-btn" onclick="toggleSettings()">
                        <i class="fas fa-cog"></i>
                    </button>
                </div>
                
                <!-- Admin Profile -->
                <div class="admin-profile">
                    <div class="profile-info">
                        <div class="profile-avatar">
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['admin_full_name'] ?? 'Admin'); ?>&background=4f46e5&color=fff" 
                                 alt="Admin Avatar">
                        </div>
                        <div class="profile-details">
                            <span class="admin-name"><?php echo htmlspecialchars($_SESSION['admin_full_name'] ?: $_SESSION['admin_username'] ?: 'Admin'); ?></span>
                            <span class="admin-role"><?php echo htmlspecialchars(ucfirst($_SESSION['admin_role'] ?: 'admin')); ?></span>
                        </div>
                        <div class="profile-dropdown-toggle" onclick="toggleProfileMenu()">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                    
                    <div class="profile-dropdown" id="profileDropdown">
                        <a href="profile.php" class="dropdown-item">
                            <i class="fas fa-user"></i> Profile Settings
                        </a>
                        <a href="preferences.php" class="dropdown-item">
                            <i class="fas fa-cog"></i> Preferences
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="logout.php" class="dropdown-item logout" 
                           onclick="return confirm('Are you sure you want to logout?')">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Mini Navigation Bar -->
    <nav class="mini-navbar">
        <div class="mini-nav-container">
            <div class="mini-nav-left">
                <div class="breadcrumb-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">
                                <i class="fas fa-home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" id="current-page">
                            Overview
                        </li>
                    </ol>
                </div>
            </div>
            
            <div class="mini-nav-center">
                <div class="quick-nav-menu">
                    <div class="quick-nav-item" data-tooltip="Dashboard Overview">
                        <a href="dashboard.php" class="quick-nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Overview</span>
                        </a>
                    </div>
                    
                    <div class="quick-nav-item" data-tooltip="Enquiries Management">
                        <a href="enquiries.php" class="quick-nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'enquiries.php' ? 'active' : ''; ?>">
                            <i class="fas fa-envelope"></i>
                            <span>Enquiries</span>
                            <?php if (($stats['new_count'] ?? 0) > 0): ?>
                                <span class="nav-badge"><?php echo $stats['new_count']; ?></span>
                            <?php endif; ?>
                        </a>
                    </div>
                    
                    <div class="quick-nav-item" data-tooltip="Projects Management">
                        <a href="projects.php" class="quick-nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'projects.php' ? 'active' : ''; ?>">
                            <i class="fas fa-project-diagram"></i>
                            <span>Projects</span>
                        </a>
                    </div>
                    
                    <div class="quick-nav-item" data-tooltip="User Management">
                        <a href="users.php" class="quick-nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : ''; ?>">
                            <i class="fas fa-users"></i>
                            <span>Users</span>
                        </a>
                    </div>
                    
                    <div class="quick-nav-item" data-tooltip="Analytics & Reports">
                        <a href="analytics.php" class="quick-nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'analytics.php' ? 'active' : ''; ?>">
                            <i class="fas fa-chart-bar"></i>
                            <span>Analytics</span>
                        </a>
                    </div>
                    
                    <div class="quick-nav-item" data-tooltip="Settings">
                        <a href="settings.php" class="quick-nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : ''; ?>">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="mini-nav-right">
                <div class="quick-actions">
                    <button class="quick-action-btn" onclick="refreshData()" data-tooltip="Refresh Data">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    
                    <button class="quick-action-btn" onclick="exportData()" data-tooltip="Export Data">
                        <i class="fas fa-download"></i>
                    </button>
                    
                    <button class="quick-action-btn" onclick="toggleFullscreen()" data-tooltip="Toggle Fullscreen">
                        <i class="fas fa-expand"></i>
                    </button>
                    
                    <div class="view-mode-toggle">
                        <button class="view-mode-btn active" data-view="grid" onclick="switchView('grid')" data-tooltip="Grid View">
                            <i class="fas fa-th"></i>
                        </button>
                        <button class="view-mode-btn" data-view="list" onclick="switchView('list')" data-tooltip="List View">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<style>
/* Mini Navigation Bar Styles */
.mini-navbar {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    padding: 0.75rem 0;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.mini-nav-container {
    max-width: 1400px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 2rem;
}

/* Breadcrumb Styles */
.breadcrumb-container {
    display: flex;
    align-items: center;
}

.breadcrumb {
    display: flex;
    align-items: center;
    margin: 0;
    padding: 0;
    list-style: none;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    padding: 0.5rem 1rem;
    backdrop-filter: blur(10px);
}

.breadcrumb-item {
    display: flex;
    align-items: center;
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.875rem;
}

.breadcrumb-item:not(:last-child)::after {
    content: '/';
    margin: 0 0.5rem;
    color: rgba(255, 255, 255, 0.5);
}

.breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: color 0.3s ease;
}

.breadcrumb-item a:hover {
    color: white;
}

.breadcrumb-item.active {
    color: white;
    font-weight: 600;
}

/* Quick Navigation Menu */
.quick-nav-menu {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 25px;
    padding: 0.5rem;
    backdrop-filter: blur(10px);
}

.quick-nav-item {
    position: relative;
}

.quick-nav-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
    white-space: nowrap;
}

.quick-nav-link:hover {
    background: rgba(255, 255, 255, 0.15);
    color: white;
    transform: translateY(-1px);
}

.quick-nav-link.active {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.quick-nav-link i {
    font-size: 1rem;
}

.nav-badge {
    position: absolute;
    top: -0.25rem;
    right: -0.25rem;
    background: #ff4757;
    color: white;
    font-size: 0.625rem;
    padding: 0.125rem 0.375rem;
    border-radius: 10px;
    font-weight: 600;
    min-width: 1.25rem;
    text-align: center;
    animation: pulse 2s infinite;
}

/* Quick Actions */
.quick-actions {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.quick-action-btn {
    background: rgba(255, 255, 255, 0.1);
    border: none;
    color: rgba(255, 255, 255, 0.8);
    padding: 0.75rem;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quick-action-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    transform: translateY(-2px);
}

.view-mode-toggle {
    display: flex;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    padding: 0.25rem;
    backdrop-filter: blur(10px);
}

.view-mode-btn {
    background: none;
    border: none;
    color: rgba(255, 255, 255, 0.7);
    padding: 0.5rem 0.75rem;
    border-radius: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

.view-mode-btn.active {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.view-mode-btn:hover:not(.active) {
    color: rgba(255, 255, 255, 0.9);
}

/* Tooltip Styles */
[data-tooltip] {
    position: relative;
}

[data-tooltip]:hover::before {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0, 0, 0, 0.9);
    color: white;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    font-size: 0.75rem;
    white-space: nowrap;
    z-index: 1000;
    margin-bottom: 0.5rem;
    opacity: 0;
    animation: fadeInTooltip 0.3s ease-in-out forwards;
}

[data-tooltip]:hover::after {
    content: '';
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    border: 5px solid transparent;
    border-top-color: rgba(0, 0, 0, 0.9);
    z-index: 1000;
    margin-bottom: -5px;
    opacity: 0;
    animation: fadeInTooltip 0.3s ease-in-out forwards;
}

@keyframes fadeInTooltip {
    from {
        opacity: 0;
        transform: translateX(-50%) translateY(5px);
    }
    to {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}

/* Responsive Design */
@media (max-width: 1200px) {
    .mini-nav-container {
        padding: 0 1.5rem;
    }
    
    .quick-nav-link span {
        display: none;
    }
    
    .quick-nav-link {
        padding: 0.75rem;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        justify-content: center;
    }
}

@media (max-width: 768px) {
    .mini-navbar {
        padding: 0.5rem 0;
    }
    
    .mini-nav-container {
        flex-direction: column;
        gap: 1rem;
        padding: 0 1rem;
    }
    
    .breadcrumb-container {
        order: 3;
    }
    
    .quick-nav-menu {
        order: 1;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .quick-actions {
        order: 2;
    }
    
    .quick-nav-menu {
        gap: 0.25rem;
        padding: 0.25rem;
    }
    
    .quick-nav-link {
        padding: 0.5rem;
        font-size: 0.8rem;
    }
}

@media (max-width: 480px) {
    .breadcrumb {
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
    }
    
    .quick-action-btn {
        width: 35px;
        height: 35px;
        font-size: 0.875rem;
    }
    
    .view-mode-btn {
        padding: 0.375rem 0.5rem;
        font-size: 0.75rem;
    }
}

/* Additional Header Styles */
.subtitle {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.8rem;
    font-weight: 400;
}
</style>

<script>
// Mini Navigation JavaScript Functions
function refreshData() {
    window.location.reload();
}

function exportData() {
    // Implement export functionality
    console.log('Export data function called');
}

function toggleFullscreen() {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
    } else {
        document.exitFullscreen();
    }
}

function switchView(viewType) {
    // Remove active class from all view buttons
    document.querySelectorAll('.view-mode-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Add active class to clicked button
    document.querySelector(`[data-view="${viewType}"]`).classList.add('active');
    
    // Implement view switching logic here
    console.log('Switched to ' + viewType + ' view');
}

// Update breadcrumb based on current page
document.addEventListener('DOMContentLoaded', function() {
    const currentPage = document.getElementById('current-page');
    const pageName = document.title.split(' - ')[0] || 'Overview';
    currentPage.textContent = pageName;
});

// Auto-update notification badge
function updateNotificationBadge(count) {
    const badge = document.querySelector('.notification-badge');
    const navBadge = document.querySelector('.nav-badge');
    
    if (badge) {
        badge.textContent = count;
        badge.style.display = count > 0 ? 'block' : 'none';
    }
    
    if (navBadge) {
        navBadge.textContent = count;
        navBadge.style.display = count > 0 ? 'block' : 'none';
    }
}
</script>