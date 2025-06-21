<?php
// filepath: c:\xampp\htdocs\new4\about.php

// Include header
require_once 'includes/header.php';
?>

<main id="main-content" role="main">
    <!-- Page Title -->
    <section class="page-title" role="banner">
        <div class="auto-container">
            <h1 class="page-title_heading">About</h1>
            <div class="page-title_text">Introducing Our Identity</div>
        </div>
    </section>
    <!-- End Page Title -->

    <?php
    // Team Component
    if (file_exists('components/about/team-one.php')) {
        include 'components/about/team-one.php';
    }
    ?>

    <?php
    // Stats Component
    if (file_exists('components/home/stats.php')) {
        include 'components/about/stats.php';
    }
    ?>

    <?php
    // Awards Component
    if (file_exists('components/about/awards.php')) {
        include 'components/about/awards.php';
    }
    ?>

    <?php
    // Testimonial Component
    if (file_exists('components/about/testimonial.php')) {
        include 'components/about/testimonial.php';
    }
    ?>
</main>

<?php
// Include footer
require_once 'includes/footer.php';
?>