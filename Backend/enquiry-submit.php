<?php
// filepath: c:\xampp\htdocs\new4\backend\components\dashboard\enquiries-table.php

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}
?>

<div class="enquiries-section modern-section">
    <div class="section-header">
        <div class="section-title">
            <h3><i class="fas fa-inbox"></i> Enquiry Management</h3>
            <p>Manage and respond to customer enquiries</p>
        </div>
        <div class="section-actions">
            <button class="modern-btn btn-primary" onclick="exportEnquiries()">
                <i class="fas fa-download"></i>
                Export Data
            </button>
            <button class="modern-btn btn-danger" onclick="bulkDelete()" id="bulk-delete-btn" style="display: none;">
                <i class="fas fa-trash"></i>
                Delete Selected
            </button>
        </div>
    </div>

    <div class="table-container modern-table-container">
        <div class="table-header">
            <div class="table-controls">
                <div class="bulk-actions">
                    <label class="modern-checkbox">
                        <input type="checkbox" id="select-all" onchange="toggleSelectAll(this)">
                        <span class="checkmark"><i class="fas fa-check"></i></span>
                        <span class="checkbox-text">Select All</span>
                    </label>
                </div>
                <div class="table-info">
                    <span class="total-count">Total: <?php echo $totalEnquiries; ?> enquiries</span>
                    <span class="filtered-count" id="filtered-count" style="display: none;"></span>
                </div>
            </div>
        </div>

        <?php if (empty($enquiries)): ?>
            <div class="empty-state modern-empty-state">
                <div class="empty-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <h3>No Enquiries Found</h3>
                <p>There are no enquiries to display at the moment.</p>
                <div class="empty-actions">
                    <button class="modern-btn btn-primary" onclick="location.reload()">
                        <i class="fas fa-refresh"></i>
                        Refresh
                    </button>
                </div>
            </div>
        <?php else: ?>
            <div class="table-wrapper">
                <table class="modern-table" id="enquiries-table">
                    <thead>
                        <tr>
                            <th class="checkbox-col">
                                <label class="modern-checkbox">
                                    <input type="checkbox" id="header-select-all" onchange="toggleSelectAll(this)">
                                    <span class="checkmark"><i class="fas fa-check"></i></span>
                                </label>
                            </th>
                            <th class="sortable" data-sort="id">
                                ID <i class="fas fa-sort"></i>
                            </th>
                            <th class="sortable" data-sort="name">
                                Name <i class="fas fa-sort"></i>
                            </th>
                            <th class="sortable" data-sort="email">
                                Email <i class="fas fa-sort"></i>
                            </th>
                            <th class="sortable" data-sort="subject">
                                Subject <i class="fas fa-sort"></i>
                            </th>
                            <th class="sortable" data-sort="status">
                                Status <i class="fas fa-sort"></i>
                            </th>
                            <th class="sortable" data-sort="created_at">
                                Date <i class="fas fa-sort"></i>
                            </th>
                            <th class="actions-col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($enquiries as $enquiry): ?>
                            <tr class="enquiry-row" data-id="<?php echo $enquiry['id']; ?>">
                                <td class="checkbox-col">
                                    <label class="modern-checkbox">
                                        <input type="checkbox" class="enquiry-checkbox" value="<?php echo $enquiry['id']; ?>" onchange="updateBulkActions()">
                                        <span class="checkmark"><i class="fas fa-check"></i></span>
                                    </label>
                                </td>
                                <td class="id-col">
                                    <span class="enquiry-id">#<?php echo str_pad($enquiry['id'], 4, '0', STR_PAD_LEFT); ?></span>
                                </td>
                                <td class="name-col">
                                    <div class="customer-info">
                                        <div class="customer-name"><?php echo htmlspecialchars($enquiry['name']); ?></div>
                                        <?php if (!empty($enquiry['phone'])): ?>
                                            <div class="customer-phone">
                                                <i class="fas fa-phone"></i>
                                                <?php echo htmlspecialchars($enquiry['phone']); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="email-col">
                                    <a href="mailto:<?php echo htmlspecialchars($enquiry['email']); ?>" class="email-link">
                                        <?php echo htmlspecialchars($enquiry['email']); ?>
                                    </a>
                                </td>
                                <td class="subject-col">
                                    <div class="subject-text" title="<?php echo htmlspecialchars($enquiry['subject']); ?>">
                                        <?php echo htmlspecialchars(substr($enquiry['subject'], 0, 50) . (strlen($enquiry['subject']) > 50 ? '...' : '')); ?>
                                    </div>
                                </td>
                                <td class="status-col">
                                    <span class="status-badge status-<?php echo strtolower($enquiry['status']); ?>">
                                        <?php 
                                        $statusIcons = [
                                            'pending' => 'fas fa-clock',
                                            'in_progress' => 'fas fa-spinner',
                                            'resolved' => 'fas fa-check-circle',
                                            'closed' => 'fas fa-times-circle'
                                        ];
                                        $icon = $statusIcons[$enquiry['status']] ?? 'fas fa-question-circle';
                                        ?>
                                        <i class="<?php echo $icon; ?>"></i>
                                        <?php echo ucwords(str_replace('_', ' ', $enquiry['status'])); ?>
                                    </span>
                                </td>
                                <td class="date-col">
                                    <div class="date-info">
                                        <div class="date-primary">
                                            <?php echo date('M j, Y', strtotime($enquiry['created_at'])); ?>
                                        </div>
                                        <div class="date-secondary">
                                            <?php echo date('g:i A', strtotime($enquiry['created_at'])); ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="actions-col">
                                    <div class="action-buttons">
                                        <button class="action-btn btn-view" 
                                                onclick="viewEnquiry(<?php echo $enquiry['id']; ?>)" 
                                                title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn btn-edit" 
                                                onclick="editEnquiry(<?php echo $enquiry['id']; ?>)" 
                                                title="Edit Status">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn btn-reply" 
                                                onclick="replyEnquiry(<?php echo $enquiry['id']; ?>)" 
                                                title="Reply">
                                            <i class="fas fa-reply"></i>
                                        </button>
                                        <button class="action-btn btn-delete" 
                                                onclick="deleteEnquiry(<?php echo $enquiry['id']; ?>)" 
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <div class="pagination-container">
                    <div class="pagination-info">
                        <span>
                            Showing <?php echo (($currentPage - 1) * $itemsPerPage) + 1; ?> to 
                            <?php echo min($currentPage * $itemsPerPage, $totalEnquiries); ?> of 
                            <?php echo $totalEnquiries; ?> entries
                        </span>
                    </div>
                    <div class="pagination modern-pagination">
                        <?php if ($currentPage > 1): ?>
                            <a href="?page=1<?php echo $queryString; ?>" class="page-link">
                                <i class="fas fa-angle-double-left"></i>
                            </a>
                            <a href="?page=<?php echo $currentPage - 1; ?><?php echo $queryString; ?>" class="page-link">
                                <i class="fas fa-angle-left"></i>
                            </a>
                        <?php endif; ?>

                        <?php
                        $startPage = max(1, $currentPage - 2);
                        $endPage = min($totalPages, $currentPage + 2);
                        
                        for ($i = $startPage; $i <= $endPage; $i++):
                        ?>
                            <a href="?page=<?php echo $i; ?><?php echo $queryString; ?>" 
                               class="page-link <?php echo $i == $currentPage ? 'active' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($currentPage < $totalPages): ?>
                            <a href="?page=<?php echo $currentPage + 1; ?><?php echo $queryString; ?>" class="page-link">
                                <i class="fas fa-angle-right"></i>
                            </a>
                            <a href="?page=<?php echo $totalPages; ?><?php echo $queryString; ?>" class="page-link">
                                <i class="fas fa-angle-double-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<script>
// Table functionality
function toggleSelectAll(checkbox) {
    const checkboxes = document.querySelectorAll('.enquiry-checkbox');
    checkboxes.forEach(cb => cb.checked = checkbox.checked);
    updateBulkActions();
}

function updateBulkActions() {
    const selectedCount = document.querySelectorAll('.enquiry-checkbox:checked').length;
    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
    
    if (selectedCount > 0) {
        bulkDeleteBtn.style.display = 'inline-flex';
        bulkDeleteBtn.querySelector('span')?.remove();
        bulkDeleteBtn.innerHTML += `<span> (${selectedCount})</span>`;
    } else {
        bulkDeleteBtn.style.display = 'none';
    }
}

function viewEnquiry(id) {
    // Implement view functionality
    console.log('View enquiry:', id);
}

function editEnquiry(id) {
    // Implement edit functionality
    console.log('Edit enquiry:', id);
}

function replyEnquiry(id) {
    // Implement reply functionality
    console.log('Reply to enquiry:', id);
}

function deleteEnquiry(id) {
    if (confirm('Are you sure you want to delete this enquiry?')) {
        // Implement delete functionality
        console.log('Delete enquiry:', id);
    }
}

function bulkDelete() {
    const selected = document.querySelectorAll('.enquiry-checkbox:checked');
    if (selected.length === 0) return;
    
    if (confirm(`Are you sure you want to delete ${selected.length} enquiry(ies)?`)) {
        // Implement bulk delete functionality
        console.log('Bulk delete:', Array.from(selected).map(cb => cb.value));
    }
}

function exportEnquiries() {
    // Implement export functionality
    console.log('Export enquiries');
}
</script>