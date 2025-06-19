<?php
// filepath: c:\xampp\htdocs\new4\journal.php

// Include header
require_once 'includes/header.php';
?>

<main id="main-content" role="main">
    <!-- Page Title -->
    <section class="page-title" role="banner">
        <div class="auto-container">
            <h1 class="page-title_heading">Journal</h1>
            <div class="page-title_text">Tech Tales, Shared Perspectives</div>
        </div>
    </section>
    <!-- End Page Title -->

    <?php
    // Journal Cards Component
    if (file_exists('components/journal/journalcard.php')) {
        include 'components/journal/journalcard.php';
    }
    ?>
</main>

<?php
// Include footer
require_once 'includes/footer.php';
?>