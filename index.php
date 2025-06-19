<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Montek Creative Agency Business HTML-5 Template | Homepage</title>

    <!-- Stylesheets -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/responsive.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
    <link rel="icon" href="assets/images/favicon.png" type="image/x-icon">
    <link href="assets/css/popup-styles.css" rel="stylesheet">
    <link href="assets/css/lighttheme.css" rel="stylesheet">
    <!-- Responsive -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
</head>

<body>

    <div class="page-wrapper">

        <?php
        // Header Component
        file_exists('components/header.php') ? require_once 'components/header.php' : print '<!-- Header component not found -->';
        ?>

        <?php
        // Banner Section
        file_exists('components/home/banner.php') ? include 'components/home/banner.php' : print '<!-- Banner component not found -->';
        ?>

        <?php
        // Services Section
        file_exists('components/home/services.php') ? include 'components/home/services.php' : print '<!-- Services component not found -->';
        ?>

        <?php
        // Include Gallery Section
        file_exists('components/home/gallery.php') ? include 'components/home/gallery.php' : print '<!-- Gallery component not found -->';
        ?>

        <?php
        // Journal Section
        file_exists('components/home/journal.php') ? include 'components/home/journal.php' : print '<!-- Journal component not found -->';
        ?>

        <?php
        // Testimonials Section
        file_exists('components/home/testimonials.php') ? include 'components/home/testimonials.php' : print '<!-- Testimonials component not found -->';
        ?>

        <?php
        // Stats Section
        file_exists('components/home/stats.php') ? include 'components/home/stats.php' : print '<!-- Stats component not found -->';
        ?>

        <?php
        // Awards Section
        file_exists('components/home/awards.php') ? include 'components/home/awards.php' : print '<!-- Awards component not found -->';
        ?>

        <?php
        // Footer Component
        file_exists('components/footer.php') ? include 'components/footer.php' : print '<!-- Footer component not found -->';
        ?>
    </div>
    <?php
    file_exists('components/popup/enquiry-popup.php') ? include 'components/popup/enquiry-popup.php' : print '<!-- Enquiry Popup component not found -->';
    ?>
    <!-- Fixed Enquire Now Button -->
    <div id="enquireButton" class="enquire-button">
        <div class="enquire-button-content">
            <i class="fas fa-headset"></i>
            <span class="enquire-text">Enquire Now</span>
            <div class="enquire-pulse"></div>
        </div>
    </div>
    <?php include 'components/theme-toggle.php'; ?>

    <link href="assets/css/popup-styles.css" rel="stylesheet">
    <script src="assets/js/popup-script.js"></script>
    <!-- End PageWrapper -->

    <!-- JavaScript Files -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/appear.js"></script>
    <script src="assets/js/wow.js"></script>
    <script src="assets/js/swiper.min.js"></script>
    <script src="assets/js/odometer.js"></script>
    <script src="assets/js/gsap.min.js"></script>
    <script src="assets/js/SplitText.min.js"></script>
    <script src="assets/js/ScrollTrigger.min.js"></script>
    <script src="assets/js/ScrollToPlugin.min.js"></script>
    <script src="assets/js/ScrollSmoother.min.js"></script>
    <script src="assets/js/script.js"></script>


    <script src="assets/js/popup-script.js"></script>
    <script src="assets/js/theme.js"></script>

    <!--[if lt IE 9]>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
<![endif]-->

    <!--[if lt IE 9]>
<script src="assets/js/respond.js"></script>
<![endif]-->

</body>

</html>