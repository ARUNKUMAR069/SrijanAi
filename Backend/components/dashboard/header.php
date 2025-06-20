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
                    <span class="subtitle">AI Enquiry Management System</span>
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
                        <span class="notification-badge"><?php echo $stats['new_count']; ?></span>
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
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['admin_full_name']); ?>&background=4f46e5&color=fff" 
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
</header>