<?php
// filepath: c:\xampp\htdocs\new4\backend\components\dashboard\filters.php
?>

<!-- Modern Filters Panel -->
<div class="filters-panel modern-panel">
    <div class="panel-header">
        <h3 class="panel-title">
            <i class="fas fa-filter"></i>
            Filters & Search
        </h3>
        <div class="panel-actions">
            <button class="btn-toggle-filters" onclick="toggleFiltersPanel()">
                <i class="fas fa-chevron-up"></i>
            </button>
        </div>
    </div>
    
    <div class="panel-content" id="filtersContent">
        <form method="GET" class="modern-filters-form">
            <div class="filters-row">
                <div class="filter-group">
                    <label for="status" class="filter-label">
                        <i class="fas fa-tag"></i>
                        Status
                    </label>
                    <select name="status" id="status" class="modern-select">
                        <option value="">All Statuses</option>
                        <option value="new" <?php echo $status_filter === 'new' ? 'selected' : ''; ?>>
                            <i class="fas fa-circle text-blue"></i> New
                        </option>
                        <option value="read" <?php echo $status_filter === 'read' ? 'selected' : ''; ?>>
                            <i class="fas fa-eye text-green"></i> Read
                        </option>
                        <option value="in_progress" <?php echo $status_filter === 'in_progress' ? 'selected' : ''; ?>>
                            <i class="fas fa-spinner text-orange"></i> In Progress
                        </option>
                        <option value="responded" <?php echo $status_filter === 'responded' ? 'selected' : ''; ?>>
                            <i class="fas fa-reply text-purple"></i> Responded
                        </option>
                        <option value="closed" <?php echo $status_filter === 'closed' ? 'selected' : ''; ?>>
                            <i class="fas fa-check-circle text-gray"></i> Closed
                        </option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="priority" class="filter-label">
                        <i class="fas fa-exclamation-triangle"></i>
                        Priority
                    </label>
                    <select name="priority" id="priority" class="modern-select">
                        <option value="">All Priorities</option>
                        <option value="low" <?php echo $priority_filter === 'low' ? 'selected' : ''; ?>>
                            <i class="fas fa-circle text-green"></i> Low
                        </option>
                        <option value="medium" <?php echo $priority_filter === 'medium' ? 'selected' : ''; ?>>
                            <i class="fas fa-circle text-yellow"></i> Medium
                        </option>
                        <option value="high" <?php echo $priority_filter === 'high' ? 'selected' : ''; ?>>
                            <i class="fas fa-circle text-orange"></i> High
                        </option>
                        <option value="urgent" <?php echo $priority_filter === 'urgent' ? 'selected' : ''; ?>>
                            <i class="fas fa-fire text-red"></i> Urgent
                        </option>
                    </select>
                </div>
                
                <div class="filter-group search-group">
                    <label for="search" class="filter-label">
                        <i class="fas fa-search"></i>
                        Search
                    </label>
                    <div class="search-input-wrapper">
                        <input type="text" name="search" id="search" 
                               class="modern-input search-input" 
                               placeholder="Name, email, subject..." 
                               value="<?php echo htmlspecialchars($search_query); ?>">
                        <button type="button" class="search-clear" onclick="clearSearch()" 
                                style="display: <?php echo $search_query ? 'block' : 'none'; ?>">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="filters-actions">
                <button type="submit" class="modern-btn primary">
                    <i class="fas fa-filter"></i>
                    Apply Filters
                </button>
                
                <a href="dashboard.php" class="modern-btn secondary">
                    <i class="fas fa-refresh"></i>
                    Reset
                </a>
                
                <button type="button" class="modern-btn outline" onclick="saveFilters()">
                    <i class="fas fa-save"></i>
                    Save View
                </button>
            </div>
        </form>
    </div>
</div>