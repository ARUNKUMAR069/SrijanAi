<?php
// filepath: c:\xampp\htdocs\new4\backend\components\dashboard\alerts.php
?>

<!-- Modern Alert System -->
<div class="alerts-container">
    <?php if ($success_message): ?>
    <div class="alert alert-success modern-alert" data-alert="success">
        <div class="alert-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="alert-content">
            <h4>Success!</h4>
            <p><?php echo htmlspecialchars($success_message); ?></p>
        </div>
        <button class="alert-close" onclick="closeAlert(this)">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <?php endif; ?>

    <?php if ($error_message): ?>
    <div class="alert alert-error modern-alert" data-alert="error">
        <div class="alert-icon">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <div class="alert-content">
            <h4>Error!</h4>
            <p><?php echo htmlspecialchars($error_message); ?></p>
        </div>
        <button class="alert-close" onclick="closeAlert(this)">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <?php endif; ?>
</div>