<?php
// Include footer
require_once 'includes/header.php';
?>

<div class="page-wrapper image-layer" style="background-image:url(assets/images/background/4.jpg)">	
 	

	

	
	<!-- Single Work -->

    <?php
    // Awards Section
    if (file_exists('components/single-work.php')) {
        include 'components/single-work.php';
    }
    ?>
	<!-- End Single Work -->
	

	
</div>
<!-- End PageWrapper -->
<?php
// Include footer
require_once 'includes/footer.php';
?>