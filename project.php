<?php
// filepath: c:\xampp\htdocs\new4\project.php

require_once 'db.php';

// Get project slug from URL
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

if (empty($slug)) {
    header('HTTP/1.0 404 Not Found');
    include '404.php';
    exit();
}

// Fetch project details
$stmt = $conn->prepare("SELECT * FROM projects WHERE slug = ? AND status = 'active'");
$stmt->bind_param("s", $slug);
$stmt->execute();
$project = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$project) {
    header('HTTP/1.0 404 Not Found');
    include '404.php';
    exit();
}

// Parse gallery images
$gallery_images = json_decode($project['image_gallery'], true) ?: [];

// Set page title and meta
$page_title = $project['title'] . ' - Project Details';
$page_description = $project['description'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Stylesheets -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/lighttheme.css" rel="stylesheet">
    <link href="assets/css/responsive.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
    <link rel="icon" href="assets/images/favicon.png" type="image/x-icon">
    
    <!-- Responsive -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
</head>

<body class="hidden-bar-wrapper">
    <div class="page-wrapper">
        <!-- Include header -->
        <?php include 'components/common/header.php'; ?>
        
        <!-- Page Title -->
        <section class="page-title">
            <div class="page-title_shapes" style="background-image:url(assets/images/background/page-title-1.png)"></div>
            <div class="page-title_bg" style="background-image:url(assets/images/background/page-title-bg.jpg)"></div>
            <div class="page-title_icons" style="background-image:url(assets/images/background/page-title-icons.png)"></div>
            <div class="auto-container">
                <h2><?php echo htmlspecialchars($project['title']); ?></h2>
                <ul class="bread-crumb clearfix">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="portfolio.php">Portfolio</a></li>
                    <li><?php echo htmlspecialchars($project['title']); ?></li>
                </ul>
            </div>
        </section>
        
        <!-- Dynamic Single Work Section -->
        <section class="single-work">
            <div class="auto-container">
                <div class="row clearfix">
                    <!-- Images Column -->
                    <div class="column col-lg-6 col-md-12 col-sm-12">
                        <?php if (!empty($gallery_images)): ?>
                            <?php foreach ($gallery_images as $image): ?>
                                <div class="single-work_image">
                                    <img src="<?php echo htmlspecialchars($image); ?>" 
                                         alt="<?php echo htmlspecialchars($project['title']); ?>" />
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="single-work_image">
                                <img src="<?php echo htmlspecialchars($project['image_main']); ?>" 
                                     alt="<?php echo htmlspecialchars($project['title']); ?>" />
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Content Column -->
                    <div class="column col-lg-6 col-md-12 col-sm-12">
                        <h2 class="single-work_title"><?php echo htmlspecialchars($project['title']); ?></h2>
                        
                        <?php if ($project['description']): ?>
                            <p><?php echo nl2br(htmlspecialchars($project['description'])); ?></p>
                        <?php endif; ?>
                        
                        <?php if ($project['detailed_description']): ?>
                            <p><?php echo nl2br(htmlspecialchars($project['detailed_description'])); ?></p>
                        <?php endif; ?>
                        
                        <ul class="single-work_list">
                            <?php if ($project['date_completed']): ?>
                                <li>
                                    Date
                                    <span><?php echo date('d F Y', strtotime($project['date_completed'])); ?></span>
                                </li>
                            <?php endif; ?>
                            
                            <li>
                                Category
                                <span><?php echo htmlspecialchars($project['category']); ?></span>
                            </li>
                            
                            <?php if ($project['services']): ?>
                                <li>
                                    Services
                                    <span><?php echo htmlspecialchars($project['services']); ?></span>
                                </li>
                            <?php endif; ?>
                            
                            <?php if ($project['project_url']): ?>
                                <li>
                                    URL
                                    <span><a href="<?php echo htmlspecialchars($project['project_url']); ?>" target="_blank"><?php echo htmlspecialchars($project['project_url']); ?></a></span>
                                </li>
                            <?php endif; ?>
                        </ul>
                        
                        <!-- Navigation Buttons -->
                        <div class="project-navigation mt-4">
                            <a href="portfolio.php" class="btn btn-primary">
                                <i class="fa fa-arrow-left"></i> Back to Portfolio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Include footer -->
        <?php include 'components/common/footer.php'; ?>
    </div>
    
    <!-- Include scripts -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/appear.js"></script>
    <script src="assets/js/wow.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>