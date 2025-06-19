<?php
// filepath: c:\xampp\htdocs\new4\contact.php

// Include header
require_once 'includes/header.php';
?>

<main id="main-content" role="main">
    <!-- Page Title -->
    <section class="page-title" role="banner">
        <div class="auto-container">
            <h1 class="page-title_heading">Contact</h1>
            <div class="page-title_text">Reach Out, Let's Collaborate</div>
        </div>
    </section>
    <!-- End Page Title -->

    <?php
    // Contact Component
    if (file_exists('components/contact/contactone.php')) {
        include 'components/contact/contactone.php';
    }
    ?>
</main>

<?php
// Include footer
require_once 'includes/footer.php';
?>