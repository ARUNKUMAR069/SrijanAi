<?php
// filepath: c:\xampp\htdocs\new4\includes\footer.php

$current_page = getCurrentPage();
?>

        <!-- Main Footer -->
        <?php
        if (file_exists('components/footer.php')) {
            require_once 'components/footer.php';
        } else {
            echo '<!-- Footer component not found -->';
        }
        ?>
        <!-- End Main Footer -->

    </div>
    <!-- End PageWrapper -->

    <?php if ($current_page === 'index'): ?>
    <!-- Homepage specific elements -->
    <?php
    if (file_exists('components/popup/enquiry-popup.php')) {
        include 'components/popup/enquiry-popup.php';
    }
    ?>
    
    <!-- Fixed Enquire Now Button -->
    <div id="enquireButton" class="enquire-button" role="button" tabindex="0" aria-label="Open enquiry form">
        <div class="enquire-button-content">
            <i class="fas fa-headset" aria-hidden="true"></i>
            <span class="enquire-text">Enquire Now</span>
            <div class="enquire-pulse" aria-hidden="true"></div>
        </div>
    </div>
    
    <?php include 'components/theme-toggle.php'; ?>
    <?php endif; ?>

    <!-- Core JavaScript Libraries -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/appear.js"></script>
    <script src="assets/js/wow.js"></script>
    <script src="assets/js/swiper.min.js"></script>
    <script src="assets/js/odometer.js"></script>
    
    <!-- GSAP Animation Libraries -->
    <script src="assets/js/gsap.min.js"></script>
    <script src="assets/js/SplitText.min.js"></script>
    <script src="assets/js/ScrollTrigger.min.js"></script>
    <script src="assets/js/ScrollToPlugin.min.js"></script>
    <script src="assets/js/ScrollSmoother.min.js"></script>
    
    <!-- Main Theme Script -->
    <script src="assets/js/script.js"></script>
    
    <?php if ($current_page === 'index'): ?>
    <!-- Homepage specific scripts -->
    <script src="assets/js/popup-script.js"></script>
    <script src="assets/js/theme.js"></script>
    <?php endif; ?>

    <!-- IE9 Support -->
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <script src="assets/js/respond.js"></script>
    <![endif]-->

    <!-- Performance monitoring -->
    <script>
        // Log Core Web Vitals
        if ('web-vital' in window) {
            import('https://unpkg.com/web-vitals?module').then(({getCLS, getFID, getFCP, getLCP, getTTFB}) => {
                getCLS(console.log);
                getFID(console.log);
                getFCP(console.log);
                getLCP(console.log);
                getTTFB(console.log);
            });
        }
    </script>
</body>
</html>