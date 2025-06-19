<?php
// filepath: c:\xampp\htdocs\new4\index.php

// Include header
require_once 'includes/header.php';
?>

<main id="main-content" role="main">
    <?php
    // Banner Section
    if (file_exists('components/home/banner.php')) {
        include 'components/home/banner.php';
    }
    ?>

    <?php
    // Services Section
    if (file_exists('components/home/services.php')) {
        include 'components/home/services.php';
    }
    ?>

    <?php
    // Gallery Section
    if (file_exists('components/home/gallery.php')) {
        include 'components/home/gallery.php';
    }
    ?>

    <?php
    // Journal Section
    if (file_exists('components/home/journal.php')) {
        include 'components/home/journal.php';
    }
    ?>

    <?php
    // Testimonials Section
    if (file_exists('components/home/testimonials.php')) {
        include 'components/home/testimonials.php';
    }
    ?>

    <?php
    // Stats Section
    if (file_exists('components/home/stats.php')) {
        include 'components/home/stats.php';
    }
    ?>

    <?php
    // Awards Section
    if (file_exists('components/home/awards.php')) {
        include 'components/home/awards.php';
    }
    ?>
</main>

<?php
// Include footer
require_once 'includes/footer.php';
?>