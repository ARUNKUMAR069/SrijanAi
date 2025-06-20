<?php
// filepath: c:\xampp\htdocs\new4\backend\components\dashboard\enquiries-table.php
?>

<!-- Modern Enquiries Table -->
<div class="table-panel modern-panel">
    <div class="panel-header">
        <div class="header-left">
            <h3 class="panel-title">
                <i class="fas fa-list"></i>
                Enquiries
                <span class="count-badge"><?php echo number_format($total_enquiries); ?></span>
            </h3>
            <div class="view-options">
                <button class="view-btn active" data-view="table" onclick="switchView('table')">
                    <i class="fas fa-table"></i>
                </button>
                <button class="view-btn" data-view="cards" onclick="switchView('cards')">
                    <i class="fas fa-th-large"></i>
                </button>
            </div>
        </div>
        
        <div class="header-right">
            <div class="table-actions">
                <button class="modern-btn outline" onclick="bulkActions()">
                    <i class="fas fa-check-square"></i>
                    Bulk Actions
                </button>
                
                <button class="modern-btn outline" onclick="window.location.reload()">
                    <i class="fas fa-sync-alt"></i>
                    Refresh
                </button>
                
                <button class="modern-btn primary" onclick="exportData()">
                    <i class="fas fa-download"></i>
                    Export
                </button>
            </div>
        </div>
    </div>
    
    <div class="panel-content">
        <?php if ($result->num_rows > 0): ?>
        <div class="table-container modern-table">
            <table class="enquiries-table">
                <thead>
                    <tr>
                        <th class="checkbox-column">
                            <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                        </th>
                        <th class="sortable" data-sort="id">
                            ID <i class="fas fa-sort"></i>
                        </th>
                        <th class="sortable" data-sort="name">
                            Contact <i class="fas fa-sort"></i>
                        </th>
                        <th class="sortable" data-sort="subject">
                            Subject <i class="fas fa-sort"></i>
                        </th>
                        <th>Message</th>
                        <th class="sortable" data-sort="date">
                            Date <i class="fas fa-sort"></i>
                        </th>
                        <th class="sortable" data-sort="status">
                            Status <i class="fas fa-sort"></i>
                        </th>
                        <th class="sortable" data-sort="priority">
                            Priority <i class="fas fa-sort"></i>
                        </th>
                        <th class="actions-column">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="enquiry-row priority-<?php echo $row['priority']; ?> status-<?php echo $row['status']; ?>" 
                        data-enquiry-id="<?php echo $row['id']; ?>">
                        
                        <td class="checkbox-column">
                            <input type="checkbox" class="row-checkbox" value="<?php echo $row['id']; ?>">
                        </td>
                        
                        <td class="id-column">
                            <span class="enquiry-id">#<?php echo str_pad($row['id'], 4, '0', STR_PAD_LEFT); ?></span>
                        </td>
                        
                        <td class="contact-column">
                            <div class="contact-info">
                                <div class="contact-avatar">
                                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($row['full_name']); ?>&background=random" 
                                         alt="<?php echo htmlspecialchars($row['full_name']); ?>">
                                </div>
                                <div class="contact-details">
                                    <div class="contact-name"><?php echo htmlspecialchars($row['full_name']); ?></div>
                                    <div class="contact-email">
                                        <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>">
                                            <?php echo htmlspecialchars($row['email']); ?>
                                        </a>
                                    </div>
                                    <div class="contact-phone">
                                        <a href="tel:<?php echo htmlspecialchars($row['mobile']); ?>">
                                            <?php echo htmlspecialchars($row['mobile']); ?>
                                        </a>
                                    </div>
                                    <?php if ($row['assigned_admin']): ?>
                                    <div class="assigned-to">
                                        <i class="fas fa-user-tag"></i>
                                        <?php echo htmlspecialchars($row['assigned_admin_name'] ?: $row['assigned_admin']); ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        
                        <td class="subject-column">
                            <div class="subject-text">
                                <?php echo htmlspecialchars($row['subject']); ?>
                            </div>
                        </td>
                        
                        <td class="message-column">
                            <div class="message-preview">
                                <?php echo formatMessage($row['message'], 60); ?>
                                <?php if (strlen($row['message']) > 60): ?>
                                <button class="view-full-btn" onclick="viewEnquiry(<?php echo $row['id']; ?>)">
                                    <i class="fas fa-expand-alt"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                        </td>
                        
                        <td class="date-column">
                            <div class="date-info">
                                <div class="date-primary"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></div>
                                <div class="date-time"><?php echo date('H:i', strtotime($row['created_at'])); ?></div>
                                <div class="date-relative"><?php echo timeAgo($row['created_at']); ?></div>
                            </div>
                        </td>
                        
                        <td class="status-column">
                            <form method="POST" class="status-form">
                                <input type="hidden" name="action" value="update_status">
                                <input type="hidden" name="enquiry_id" value="<?php echo $row['id']; ?>">
                                <select name="new_status" class="modern-status-select <?php echo getStatusBadgeClass($row['status']); ?>" 
                                        onchange="updateStatus(this)">
                                    <option value="new" <?php echo $row['status'] === 'new' ? 'selected' : ''; ?>>New</option>
                                    <option value="read" <?php echo $row['status'] === 'read' ? 'selected' : ''; ?>>Read</option>
                                    <option value="in_progress" <?php echo $row['status'] === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                                    <option value="responded" <?php echo $row['status'] === 'responded' ? 'selected' : ''; ?>>Responded</option>
                                    <option value="closed" <?php echo $row['status'] === 'closed' ? 'selected' : ''; ?>>Closed</option>
                                </select>
                            </form>
                        </td>
                        
                        <td class="priority-column">
                            <span class="priority-badge priority-<?php echo $row['priority']; ?>">
                                <?php echo getPriorityIcon($row['priority']); ?>
                                <span class="priority-text"><?php echo ucfirst($row['priority']); ?></span>
                            </span>
                        </td>
                        
                        <td class="actions-column">
                            <div class="actions-dropdown">
                                <button class="actions-toggle" onclick="toggleRowActions(this)">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="actions-menu">
                                    <a href="#" class="action-item" onclick="viewEnquiry(<?php echo $row['id']; ?>)">
                                        <i class="fas fa-eye"></i> View Details
                                    </a>
                                    <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" class="action-item">
                                        <i class="fas fa-envelope"></i> Send Email
                                    </a>
                                    <a href="#" class="action-item" onclick="assignEnquiry(<?php echo $row['id']; ?>)">
                                        <i class="fas fa-user-tag"></i> Assign
                                    </a>
                                    <div class="action-divider"></div>
                                    <a href="#" class="action-item danger" onclick="deleteEnquiry(<?php echo $row['id']; ?>)">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Modern Pagination -->
        <?php if ($total_pages > 1): ?>
        <div class="modern-pagination">
            <div class="pagination-info">
                Showing <?php echo (($page - 1) * $per_page) + 1; ?> to 
                <?php echo min($page * $per_page, $total_enquiries); ?> of 
                <?php echo number_format($total_enquiries); ?> entries
            </div>
            
            <div class="pagination-controls">
                <?php if ($page > 1): ?>
                <a href="?page=1&status=<?php echo urlencode($status_filter); ?>&priority=<?php echo urlencode($priority_filter); ?>&search=<?php echo urlencode($search_query); ?>" 
                   class="page-btn first">
                    <i class="fas fa-angle-double-left"></i>
                </a>
                <a href="?page=<?php echo $page - 1; ?>&status=<?php echo urlencode($status_filter); ?>&priority=<?php echo urlencode($priority_filter); ?>&search=<?php echo urlencode($search_query); ?>" 
                   class="page-btn prev">
                    <i class="fas fa-angle-left"></i>
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
                
                <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo $page + 1; ?>&status=<?php echo urlencode($status_filter); ?>&priority=<?php echo urlencode($priority_filter); ?>&search=<?php echo urlencode($search_query); ?>" 
                   class="page-btn next">
                    <i class="fas fa-angle-right"></i>
                </a>
                <a href="?page=<?php echo $total_pages; ?>&status=<?php echo urlencode($status_filter); ?>&priority=<?php echo urlencode($priority_filter); ?>&search=<?php echo urlencode($search_query); ?>" 
                   class="page-btn last">
                    <i class="fas fa-angle-double-right"></i>
                </a>
                <?php endif; ?>
            </div>
            
            <div class="pagination-jump">
                <input type="number" class="page-input" min="1" max="<?php echo $total_pages; ?>" 
                       value="<?php echo $page; ?>" onchange="jumpToPage(this.value)">
                <span>of <?php echo $total_pages; ?></span>
            </div>
        </div>
        <?php else: ?>
        <div class="no-data-state">
            <div class="no-data-icon">
                <i class="fas fa-inbox"></i>
            </div>
            <h3>No Enquiries Found</h3>
            <p>
                <?php if ($search_query || $status_filter || $priority_filter): ?>
                    No enquiries match your current filters.
                    <a href="dashboard.php" class="modern-btn outline">Clear filters</a>
                <?php else: ?>
                    No enquiry submissions have been received yet.
                <?php endif; ?>
            </p>
        </div>
        <?php endif; ?>
    </div>
</div>div>
</div>