<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Montek Creative Agency Business HTML-5 Template | About Us</title>
	<!-- Stylesheets -->
	<link href="assets/css/bootstrap.css" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet">
	<link href="assets/css/responsive.css" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,600;1,700&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

	<link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
	<link rel="icon" href="assets/images/favicon.png" type="image/x-icon">

	<!-- Responsive -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

</head>

<body>

	<div class="page-wrapper image-layer" style="background-image:url(assets/images/background/4.jpg)">
		<!-- Main Header -->
		<?php
		// Header Component
		file_exists('components/header.php') ? require_once 'components/header.php' : print '<!-- Header component not found -->';
		?>
		<!-- End Main Header -->

		<!-- Page Title -->
		<section class="page-title">
			<div class="auto-container">
				<h1 class="page-title_heading">About</h1>
				<div class="page-title_text">Introducing Our Identity</div>
			</div>
		</section>
		<!-- End Page Title -->

		<!-- Team One -->
			<?php
			// Team Component
			file_exists('components/about/team-one.php') ? require_once 'components/about/team-one.php' : print '<!-- Team component not found -->';
			?>
		<!-- End Team One -->

		<!-- Stats One -->
		<?php
		// Stats Component
		file_exists('components/about/stats.php') ? require_once 'components/about/stats.php' : print '<!-- Stats component not found -->';
		?>
		<!-- End Stats One -->

		<!-- Awards One -->
		<?php
		// Awards Component
		file_exists('components/about/awards.php') ? require_once 'components/about/awards.php' : print '<!-- Awards component not found -->';
		?>
		<!-- End Awards One -->

		<!-- Testimonial One -->
		<?php
		// Testimonial Component
		file_exists('components/about/testimonial.php') ? require_once 'components/about/testimonial.php' : print '<!-- Testimonial component not found -->';
		?>
		<!-- End Testimonial One -->

		<!-- Main Footer -->
		<?php
		// Footer Component
		file_exists('components/footer.php') ? require_once 'components/footer.php' : print '<!-- Footer component not found -->';
		?>
		<!-- End Main Footer -->

	</div>
	<!-- End PageWrapper -->
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
	<!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
	<!--[if lt IE 9]><script src="js/respond.js"></script><![endif]-->

</body>

</html>