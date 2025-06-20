<?php
// filepath: c:\xampp\htdocs\new4\backend\components\dashboard\modal.php
?>

<!-- Modern Modal System -->
<div id="enquiryModal" class="modern-modal" style="display: none;">
    <div class="modal-backdrop" onclick="closeModal()"></div>
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">
                <i class="fas fa-envelope-open"></i>
                Enquiry Details
            </h3>
            <div class="modal-actions">
                <button class="modal-action-btn" onclick="printEnquiry()">
                    <i class="fas fa-print"></i>
                </button>
                <button class="modal-action-btn" onclick="exportEnquiry()">
                    <i class="fas fa-download"></i>
                </button>
                <button class="modal-close" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <div class="modal-body" id="modalBody">
            <div class="modal-loading">
                <div class="loading-spinner">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                <p>Loading enquiry details...</p>
            </div>
        </div>
        
        <div class="modal-footer">
            <button class="modern-btn secondary" onclick="closeModal()">
                Close
            </button>
            <button class="modern-btn primary" onclick="replyToEnquiry()">
                <i class="fas fa-reply"></i>
                Reply to Customer
            </button>
        </div>
    </div>
</div>

<!-- Quick Actions Modal -->
<div id="quickActionsModal" class="modern-modal" style="display: none;">
    <div class="modal-backdrop" onclick="closeQuickActions()"></div>
    <div class="modal-container small">
        <div class="modal-header">
            <h3 class="modal-title">Quick Actions</h3>
            <button class="modal-close" onclick="closeQuickActions()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="quick-actions-grid">
                <button class="quick-action-btn" onclick="bulkUpdateStatus('read')">
                    <i class="fas fa-eye"></i>
                    Mark as Read
                </button>
                <button class="quick-action-btn" onclick="bulkUpdateStatus('in_progress')">
                    <i class="fas fa-spinner"></i>
                    Set In Progress
                </button>
                <button class="quick-action-btn" onclick="bulkAssign()">
                    <i class="fas fa-user-tag"></i>
                    Assign to Me
                </button>
                <button class="quick-action-btn danger" onclick="bulkDelete()">
                    <i class="fas fa-trash"></i>
                    Delete Selected
                </button>
            </div>
        </div>
    </div>
</div>