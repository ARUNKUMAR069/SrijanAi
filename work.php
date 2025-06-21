<?php
// filepath: c:\xampp\htdocs\new4\index.php

// Include header
require_once 'includes/header.php';
?>



<div class="page-wrapper image-layer" style="background-image:url(assets/images/background/4.jpg)">
	<!-- Main Header -->
	

	<!-- End Main Header -->

	<!-- Page Title -->
	<section class="page-title">
		<div class="auto-container">
			<h1 class="page-title_heading">Work</h1>
			<div class="page-title_text">Crafting Dreams, Forging Reality</div>
		</div>
	</section>
	<!-- End Page Title -->

	<!-- Work One -->
	<?php
	// Gallery Section
	if (file_exists('components/home/gallery.php')) {
		include 'components/home/gallery.php';
	}
	?>

	<!-- End Team One -->

	<!-- Main Footer -->


	<!-- End Main Footer -->

</div>
<?php
// Include footer
require_once 'includes/footer.php';
?>