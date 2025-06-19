<?php
// filepath: c:\xampp\htdocs\new4\journal-detail.php

// Include header
require_once 'includes/header.php';
?>

<main id="main-content" role="main">
    <?php
    // Journal Detail Component
    if (file_exists('components/journaldetail/journaldetail.php')) {
        include 'components/journaldetail/journaldetail.php';
    }
    ?>
</main>

<?php
// Include footer
require_once 'includes/footer.php';
?>