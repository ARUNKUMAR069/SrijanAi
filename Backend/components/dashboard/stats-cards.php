<?php
// filepath: c:\xampp\htdocs\new4\backend\components\dashboard\stats-cards.php
?>

<!-- Modern Stats Cards -->
<div class="stats-grid">
    <div class="stat-card modern-card" data-stat="total">
        <div class="card-header">
            <div class="card-icon total">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="card-menu">
                <button class="menu-btn" onclick="toggleCardMenu(this)">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
            </div>
        </div>
        <div class="card-content">
            <h3 class="stat-number" data-count="<?php echo $stats['total']; ?>">
                <?php echo number_format($stats['total']); ?>
            </h3>
            <p class="stat-label">Total Enquiries</p>
            <div class="stat-trend">
                <span class="trend-indicator positive">
                    <i class="fas fa-arrow-up"></i> 12%
                </span>
                <span class="trend-period">vs last month</span>
            </div>
        </div>
    </div>
    
    <div class="stat-card modern-card" data-stat="today">
        <div class="card-header">
            <div class="card-icon today">
                <i class="fas fa-clock"></i>
            </div>
        </div>
        <div class="card-content">
            <h3 class="stat-number" data-count="<?php echo $stats['today']; ?>">
                <?php echo number_format($stats['today']); ?>
            </h3>
            <p class="stat-label">Today's Enquiries</p>
            <div class="stat-trend">
                <span class="trend-indicator positive">
                    <i class="fas fa-arrow-up"></i> 5%
                </span>
                <span class="trend-period">vs yesterday</span>
            </div>
        </div>
    </div>
    
    <div class="stat-card modern-card" data-stat="week">
        <div class="card-header">
            <div class="card-icon week">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
        <div class="card-content">
            <h3 class="stat-number" data-count="<?php echo $stats['week']; ?>">
                <?php echo number_format($stats['week']); ?>
            </h3>
            <p class="stat-label">This Week</p>
            <div class="stat-progress">
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 75%"></div>
                </div>
                <span class="progress-text">75% of target</span>
            </div>
        </div>
    </div>
    
    <div class="stat-card modern-card" data-stat="new">
        <div class="card-header">
            <div class="card-icon new">
                <i class="fas fa-star"></i>
            </div>
        </div>
        <div class="card-content">
            <h3 class="stat-number" data-count="<?php echo $stats['new_count']; ?>">
                <?php echo number_format($stats['new_count']); ?>
            </h3>
            <p class="stat-label">New Enquiries</p>
            <div class="stat-actions">
                <a href="?status=new" class="quick-action">View All</a>
            </div>
        </div>
    </div>
    
    <div class="stat-card modern-card urgent" data-stat="urgent">
        <div class="card-header">
            <div class="card-icon urgent">
                <i class="fas fa-fire"></i>
            </div>
        </div>
        <div class="card-content">
            <h3 class="stat-number" data-count="<?php echo $stats['urgent']; ?>">
                <?php echo number_format($stats['urgent']); ?>
            </h3>
            <p class="stat-label">Urgent Priority</p>
            <div class="stat-actions">
                <a href="?priority=urgent" class="quick-action urgent">Handle Now</a>
            </div>
        </div>
    </div>
    
    <div class="stat-card modern-card" data-stat="progress">
        <div class="card-header">
            <div class="card-icon progress">
                <i class="fas fa-spinner"></i>
            </div>
        </div>
        <div class="card-content">
            <h3 class="stat-number" data-count="<?php echo $stats['in_progress']; ?>">
                <?php echo number_format($stats['in_progress']); ?>
            </h3>
            <p class="stat-label">In Progress</p>
            <div class="stat-actions">
                <a href="?status=in_progress" class="quick-action">Continue Work</a>
            </div>
        </div>
    </div>
</div>