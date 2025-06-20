<?php
// filepath: c:\xampp\htdocs\new4\backend\components\dashboard\enquiries-table.php

// This component should receive data from the main dashboard, not create its own connection
// Remove the independent database connection logic and use the data passed from dashboard.php

// Ensure we have the required data from the main dashboard
if (!isset($result) || !isset($total_enquiries) || !isset($stats)) {
    // Fallback if data is not properly passed
    $enquiries = [];
    $total_enquiries = 0;
    $total_pages = 0;
    $currentPage = 1;
    $itemsPerPage = 15;
} else {
    // Use data from main dashboard
    $enquiries = [];
    while ($row = $result->fetch_assoc()) {
        $enquiries[] = $row;
    }
    
    $currentPage = $page ?? 1;
    $itemsPerPage = $per_page ?? 15;
    
    // Build query string for pagination
    $queryParams = $_GET;
    unset($queryParams['page']);
    $queryString = !empty($queryParams) ? '&' . http_build_query($queryParams) : '';
}
?>

<div class="enquiries-section modern-section">
    <div class="section-header">
        <div class="section-title">
            <h3><i class="fas fa-inbox"></i> Enquiry Management</h3>
            <p>Manage and respond to customer enquiries</p>
            <small class="stats-summary">
                <i class="fas fa-info-circle"></i>
                Total: <?php echo number_format($stats['total'] ?? 0); ?> | 
                New: <?php echo number_format($stats['new_count'] ?? 0); ?> | 
                Urgent: <?php echo number_format($stats['urgent'] ?? 0); ?>
            </small>
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
                <div class="search-container">
                    <div class="search-input-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" class="search-input" placeholder="Search enquiries..." 
                               id="enquiry-search" value="<?php echo htmlspecialchars($search_query ?? ''); ?>">
                    </div>
                </div>
                <div class="filter-container">
                    <select class="filter-select" id="status-filter">
                        <option value="">All Status</option>
                        <option value="new" <?php echo ($status_filter ?? '') === 'new' ? 'selected' : ''; ?>>New</option>
                        <option value="read" <?php echo ($status_filter ?? '') === 'read' ? 'selected' : ''; ?>>Read</option>
                        <option value="in_progress" <?php echo ($status_filter ?? '') === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                        <option value="responded" <?php echo ($status_filter ?? '') === 'responded' ? 'selected' : ''; ?>>Responded</option>
                        <option value="closed" <?php echo ($status_filter ?? '') === 'closed' ? 'selected' : ''; ?>>Closed</option>
                    </select>
                </div>
                <div class="bulk-actions">
                    <label class="modern-checkbox">
                        <input type="checkbox" id="select-all" onchange="toggleSelectAll(this)">
                        <span class="checkmark"><i class="fas fa-check"></i></span>
                        <span class="checkbox-text">Select All</span>
                    </label>
                </div>
            </div>
            <div class="table-info">
                <span class="total-count">Total: <?php echo number_format($total_enquiries); ?> enquiries</span>
                <span class="filtered-count" id="filtered-count" style="display: none;"></span>
            </div>
        </div>

        <?php if (empty($enquiries)): ?>
            <div class="empty-state modern-empty-state">
                <div class="empty-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <h3>No Enquiries Found</h3>
                <p>There are no enquiries matching your current filters.</p>
                <div class="empty-actions">
                    <a href="dashboard.php" class="modern-btn btn-primary">
                        <i class="fas fa-refresh"></i>
                        Reset Filters
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="table-wrapper">
                <table class="modern-table modern-data-table" id="enquiries-table">
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
                            <th class="sortable" data-sort="full_name">
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
                            <th class="sortable" data-sort="priority">
                                Priority <i class="fas fa-sort"></i>
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
                                <td class="id-col" data-column="id">
                                    <span class="enquiry-id">#<?php echo str_pad($enquiry['id'], 4, '0', STR_PAD_LEFT); ?></span>
                                </td>
                                <td class="name-col" data-column="full_name">
                                    <div class="customer-info">
                                        <div class="customer-name"><?php echo htmlspecialchars($enquiry['full_name']); ?></div>
                                        <?php if (!empty($enquiry['mobile'])): ?>
                                            <div class="customer-phone">
                                                <i class="fas fa-phone"></i>
                                                <?php echo htmlspecialchars($enquiry['mobile']); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="email-col" data-column="email">
                                    <a href="mailto:<?php echo htmlspecialchars($enquiry['email']); ?>" class="email-link">
                                        <?php echo htmlspecialchars($enquiry['email']); ?>
                                    </a>
                                </td>
                                <td class="subject-col" data-column="subject">
                                    <div class="subject-text" title="<?php echo htmlspecialchars($enquiry['subject']); ?>">
                                        <?php echo htmlspecialchars(substr($enquiry['subject'], 0, 50) . (strlen($enquiry['subject']) > 50 ? '...' : '')); ?>
                                    </div>
                                </td>
                                <td class="status-col" data-column="status">
                                    <span class="status-badge status-<?php echo strtolower($enquiry['status'] ?? 'new'); ?>">
                                        <?php 
                                        $status = $enquiry['status'] ?? 'new';
                                        $statusIcons = [
                                            'new' => 'fas fa-circle',
                                            'read' => 'fas fa-eye',
                                            'in_progress' => 'fas fa-spinner',
                                            'responded' => 'fas fa-reply',
                                            'closed' => 'fas fa-check-circle'
                                        ];
                                        $icon = $statusIcons[$status] ?? 'fas fa-question-circle';
                                        ?>
                                        <i class="<?php echo $icon; ?>"></i>
                                        <?php echo ucwords(str_replace('_', ' ', $status)); ?>
                                    </span>
                                </td>
                                <td class="priority-col" data-column="priority">
                                    <span class="priority-badge priority-<?php echo strtolower($enquiry['priority'] ?? 'medium'); ?>">
                                        <?php 
                                        $priority = $enquiry['priority'] ?? 'medium';
                                        $priorityIcons = [
                                            'low' => 'fas fa-circle',
                                            'medium' => 'fas fa-circle',
                                            'high' => 'fas fa-exclamation-triangle',
                                            'urgent' => 'fas fa-fire'
                                        ];
                                        $icon = $priorityIcons[$priority] ?? 'fas fa-circle';
                                        ?>
                                        <i class="<?php echo $icon; ?>"></i>
                                        <?php echo ucfirst($priority); ?>
                                    </span>
                                </td>
                                <td class="date-col" data-column="created_at">
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
                                                onclick="editStatus(<?php echo $enquiry['id']; ?>, '<?php echo $enquiry['status']; ?>')" 
                                                title="Change Status">
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
            <?php if ($total_pages > 1): ?>
                <div class="pagination-container">
                    <div class="pagination-info">
                        <span>
                            Showing <?php echo number_format((($currentPage - 1) * $itemsPerPage) + 1); ?> to 
                            <?php echo number_format(min($currentPage * $itemsPerPage, $total_enquiries)); ?> of 
                            <?php echo number_format($total_enquiries); ?> entries
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
                        $endPage = min($total_pages, $currentPage + 2);
                        
                        for ($i = $startPage; $i <= $endPage; $i++):
                        ?>
                            <a href="?page=<?php echo $i; ?><?php echo $queryString; ?>" 
                               class="page-link <?php echo $i == $currentPage ? 'active' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($currentPage < $total_pages): ?>
                            <a href="?page=<?php echo $currentPage + 1; ?><?php echo $queryString; ?>" class="page-link">
                                <i class="fas fa-angle-right"></i>
                            </a>
                            <a href="?page=<?php echo $total_pages; ?><?php echo $queryString; ?>" class="page-link">
                                <i class="fas fa-angle-double-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Modal for viewing/editing enquiries -->
<div class="modal-overlay" id="modal-overlay" style="display: none;"></div>
<div id="enquiry-modal" class="modern-modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modal-title">Enquiry Details</h3>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body" id="modal-body">
            <!-- Content loaded dynamically -->
        </div>
        <div class="modal-footer">
            <button class="modern-btn btn-secondary" onclick="closeModal()">Close</button>
            <button class="modern-btn btn-primary" id="modal-action-btn">Update</button>
        </div>
    </div>
</div>

<script>
// Enhanced enquiry management
function viewEnquiry(id) {
    const row = document.querySelector(`[data-id="${id}"]`);
    if (!row) return;
    
    const name = row.querySelector('.customer-name')?.textContent || '';
    const email = row.querySelector('.email-link')?.textContent || '';
    const phone = row.querySelector('.customer-phone')?.textContent?.replace(/.*fa-phone.*/, '').trim() || '';
    const subject = row.querySelector('.subject-text')?.title || row.querySelector('.subject-text')?.textContent || '';
    const status = row.querySelector('.status-badge')?.textContent?.trim() || '';
    const priority = row.querySelector('.priority-badge')?.textContent?.trim() || '';
    const date = row.querySelector('.date-primary')?.textContent || '';
    const time = row.querySelector('.date-secondary')?.textContent || '';
    
    const content = `
        <div class="enquiry-details">
            <div class="detail-grid">
                <div class="detail-item">
                    <label>Name:</label>
                    <span>${name}</span>
                </div>
                <div class="detail-item">
                    <label>Email:</label>
                    <span><a href="mailto:${email}">${email}</a></span>
                </div>
                <div class="detail-item">
                    <label>Phone:</label>
                    <span>${phone}</span>
                </div>
                <div class="detail-item">
                    <label>Subject:</label>
                    <span>${subject}</span>
                </div>
                <div class="detail-item">
                    <label>Status:</label>
                    <span>${status}</span>
                </div>
                <div class="detail-item">
                    <label>Priority:</label>
                    <span>${priority}</span>
                </div>
                <div class="detail-item full-width">
                    <label>Date:</label>
                    <span>${date} at ${time}</span>
                </div>
            </div>
        </div>
    `;
    
    openModal(`Enquiry #${String(id).padStart(4, '0')}`, content);
}

function editStatus(id, currentStatus) {
    const content = `
        <form id="statusForm" onsubmit="updateStatus(event, ${id})">
            <div class="form-group">
                <label for="newStatus">Change Status:</label>
                <select id="newStatus" class="modern-select" required>
                    <option value="new" ${currentStatus === 'new' ? 'selected' : ''}>New</option>
                    <option value="read" ${currentStatus === 'read' ? 'selected' : ''}>Read</option>
                    <option value="in_progress" ${currentStatus === 'in_progress' ? 'selected' : ''}>In Progress</option>
                    <option value="responded" ${currentStatus === 'responded' ? 'selected' : ''}>Responded</option>
                    <option value="closed" ${currentStatus === 'closed' ? 'selected' : ''}>Closed</option>
                </select>
            </div>
        </form>
    `;
    
    openModal('Update Status', content);
    document.getElementById('modal-action-btn').onclick = () => document.getElementById('statusForm').submit();
}

function updateStatus(event, id) {
    event.preventDefault();
    const newStatus = document.getElementById('newStatus').value;
    
    const formData = new FormData();
    formData.append('action', 'update_status');
    formData.append('enquiry_id', id);
    formData.append('new_status', newStatus);
    
    fetch(window.location.href, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            window.location.reload();
        } else {
            alert('Failed to update status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
}

function replyEnquiry(id) {
    // Implementation for email reply
    alert('Reply functionality - integrate with email system');
}

function deleteEnquiry(id) {
    if (confirm('Are you sure you want to delete this enquiry?')) {
        // Implementation for delete
        alert('Delete functionality - implement backend deletion');
    }
}

function openModal(title, content) {
    document.getElementById('modal-title').textContent = title;
    document.getElementById('modal-body').innerHTML = content;
    document.getElementById('enquiry-modal').style.display = 'block';
    document.getElementById('modal-overlay').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('enquiry-modal').style.display = 'none';
    document.getElementById('modal-overlay').style.display = 'none';
    document.body.style.overflow = '';
}

// Enhanced table functionality
function toggleSelectAll(checkbox) {
    const checkboxes = document.querySelectorAll('.enquiry-checkbox');
    checkboxes.forEach(cb => {
        if (cb.closest('tr').style.display !== 'none') {
            cb.checked = checkbox.checked;
        }
    });
    updateBulkActions();
}

function updateBulkActions() {
    const selected = document.querySelectorAll('.enquiry-checkbox:checked');
    const bulkBtn = document.getElementById('bulk-delete-btn');
    
    if (selected.length > 0) {
        bulkBtn.style.display = 'inline-flex';
        bulkBtn.innerHTML = `<i class="fas fa-trash"></i> Delete Selected (${selected.length})`;
    } else {
        bulkBtn.style.display = 'none';
    }
}

// Search and filter functionality
document.getElementById('enquiry-search').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('.enquiry-row');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

document.getElementById('status-filter').addEventListener('change', function() {
    window.location.href = updateUrlParameter(window.location.href, 'status', this.value);
});

function updateUrlParameter(url, param, value) {
    const urlObj = new URL(url);
    if (value) {
        urlObj.searchParams.set(param, value);
    } else {
        urlObj.searchParams.delete(param);
    }
    return urlObj.toString();
}

// Close modal on overlay click
document.getElementById('modal-overlay').addEventListener('click', closeModal);

// Close modal on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
});
</script>

<style>
/* Enhanced styles for better integration */
.stats-summary {
    display: block;
    margin-top: 8px;
    padding: 8px 12px;
    background: rgba(79, 70, 229, 0.1);
    border-radius: 6px;
    border-left: 3px solid #4f46e5;
    font-size: 0.75rem;
    color: #4f46e5;
}

.detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 16px;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.detail-item.full-width {
    grid-column: 1 / -1;
}

.detail-item label {
    font-weight: 600;
    color: #374151;
    font-size: 0.875rem;
}

.detail-item span {
    color: #6b7280;
    font-size: 0.875rem;
}

.form-group {
    margin-bottom: 16px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #374151;
}

.modern-select {
    width: 100%;
    padding: 12px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 0.875rem;
    background: white;
}

.modern-select:focus {
    outline: none;
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

/* Missing styles for enquiries-table.php */
.enquiries-section {
    margin: 1rem 2rem;
    max-width: 1400px;
    margin-left: auto;
    margin-right: auto;
}

.modern-section {
    background: var(--card-background);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
}

.section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
}

.section-title h3 {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 0.5rem 0;
}

.section-title p {
    color: var(--text-secondary);
    font-size: 0.875rem;
    margin: 0;
}

.section-actions {
    display: flex;
    gap: 0.5rem;
}

.modern-table-container {
    background: white;
    border-radius: var(--border-radius);
    overflow: hidden;
}

.table-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.5rem;
    background: var(--background-color);
    border-bottom: 1px solid var(--border-color);
}

.table-controls {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
}

.search-container {
    flex: 1;
    max-width: 300px;
}

.search-input-wrapper {
    position: relative;
}

.search-input-wrapper i {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-secondary);
}

.search-input {
    width: 100%;
    padding: 0.75rem 0.75rem 0.75rem 2.5rem;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    font-size: 0.875rem;
}

.filter-container {
    min-width: 150px;
}

.filter-select {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    font-size: 0.875rem;
    background: white;
}

.bulk-actions {
    display: flex;
    align-items: center;
}

.modern-checkbox {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
}

.modern-checkbox input[type="checkbox"] {
    display: none;
}

.modern-checkbox .checkmark {
    width: 1.25rem;
    height: 1.25rem;
    border: 2px solid var(--border-color);
    border-radius: 0.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
}

.modern-checkbox input[type="checkbox"]:checked + .checkmark {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

.checkbox-text {
    font-size: 0.875rem;
    color: var(--text-primary);
}

.table-info {
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.total-count {
    font-weight: 500;
}

.empty-state {
    text-align: center;
    padding: 3rem 1.5rem;
}

.modern-empty-state {
    background: white;
    border-radius: var(--border-radius);
}

.empty-icon {
    font-size: 3rem;
    color: var(--text-secondary);
    margin-bottom: 1rem;
}

.empty-state h3 {
    color: var(--text-primary);
    margin: 0 0 0.5rem 0;
}

.empty-state p {
    color: var(--text-secondary);
    margin: 0 0 1.5rem 0;
}

.empty-actions {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
}

.table-wrapper {
    overflow-x: auto;
}

.modern-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.875rem;
}

.modern-data-table th {
    background: var(--background-color);
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: var(--text-primary);
    border-bottom: 1px solid var(--border-color);
    white-space: nowrap;
}

.modern-data-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
    vertical-align: top;
}

.sortable {
    cursor: pointer;
    user-select: none;
}

.sortable:hover {
    background: #e5e7eb;
}

.sortable i {
    margin-left: 0.5rem;
    opacity: 0.5;
}

.enquiry-row {
    transition: var(--transition);
}

.enquiry-row:hover {
    background: rgba(79, 70, 229, 0.02);
}

.checkbox-col {
    width: 3rem;
    text-align: center;
}

.id-col {
    width: 5rem;
}

.enquiry-id {
    font-family: 'JetBrains Mono', 'Fira Code', monospace;
    font-size: 0.75rem;
    background: var(--background-color);
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-weight: 600;
}

.customer-info {
    min-width: 0;
}

.customer-name {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.customer-phone {
    font-size: 0.75rem;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.email-link {
    color: var(--text-secondary);
    text-decoration: none;
}

.email-link:hover {
    color: var(--primary-color);
    text-decoration: underline;
}

.subject-text {
    color: var(--text-primary);
    line-height: 1.4;
}

.status-badge,
.priority-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.status-new {
    background: rgba(59, 130, 246, 0.1);
    color: #1d4ed8;
}

.status-read {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.status-in_progress {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
}

.status-responded {
    background: rgba(139, 92, 246, 0.1);
    color: #7c3aed;
}

.status-closed {
    background: rgba(107, 114, 128, 0.1);
    color: #374151;
}

.priority-low {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
}

.priority-medium {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
}

.priority-high {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
}

.priority-urgent {
    background: rgba(239, 68, 68, 0.2);
    color: #991b1b;
}

.date-info {
    text-align: left;
    min-width: 120px;
}

.date-primary {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.125rem;
}

.date-secondary {
    font-size: 0.75rem;
    color: var(--text-secondary);
}

.actions-col {
    width: 140px;
}

.action-buttons {
    display: flex;
    gap: 0.25rem;
}

.action-btn {
    padding: 0.375rem;
    border: 1px solid var(--border-color);
    background: white;
    border-radius: 0.25rem;
    cursor: pointer;
    transition: var(--transition);
    color: var(--text-secondary);
}

.action-btn:hover {
    background: var(--background-color);
    color: var(--text-primary);
}

.btn-view:hover {
    color: var(--primary-color);
    border-color: var(--primary-color);
}

.btn-edit:hover {
    color: #059669;
    border-color: #059669;
}

.btn-reply:hover {
    color: #7c3aed;
    border-color: #7c3aed;
}

.btn-delete:hover {
    color: var(--error-color);
    border-color: var(--error-color);
}

.pagination-container {
    display: flex;
    align-items: center;
    justify-content: between;
    padding: 1rem 1.5rem;
    background: var(--background-color);
    border-top: 1px solid var(--border-color);
}

.pagination-info {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.page-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 0.75rem;
    margin: 0 0.125rem;
    border: 1px solid var(--border-color);
    background: white;
    color: var(--text-secondary);
    text-decoration: none;
    border-radius: 0.25rem;
    transition: var(--transition);
}

.page-link:hover {
    background: var(--background-color);
    color: var(--text-primary);
}

.page-link.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

.modern-modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-lg);
    width: 90%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
    z-index: 1001;
}

.modal-content {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
}

.modal-header h3 {
    margin: 0;
    color: var(--text-primary);
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: var(--text-secondary);
    padding: 0.25rem;
}

.modal-close:hover {
    color: var(--text-primary);
}

.modal-body {
    flex: 1;
    padding: 1.5rem;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
    padding: 1.5rem;
    border-top: 1px solid var(--border-color);
}

/* Button variants */
.btn-primary {
    background: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background: var(--primary-hover);
}

.btn-secondary {
    background: var(--secondary-color);
    color: white;
}

.btn-secondary:hover {
    background: #374151;
}

.btn-danger {
    background: var(--error-color);
    color: white;
}

.btn-danger:hover {
    background: #dc2626;
}
</style>