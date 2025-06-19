<?php
// filepath: c:\xampp\htdocs\new4\includes\header.php

require_once 'includes/config.php';

$seo = getPageSEO();
$current_page = getCurrentPage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    
    <!-- SEO Meta Tags -->
    <title><?php echo htmlspecialchars($seo['title']); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($seo['description']); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($seo['keywords']); ?>">
    <meta name="author" content="<?php echo htmlspecialchars($seo['author']); ?>">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="<?php echo htmlspecialchars($seo['canonical']); ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="<?php echo htmlspecialchars($seo['og_type']); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($seo['canonical']); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($seo['title']); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($seo['description']); ?>">
    <meta property="og:image" content="<?php echo SITE_URL; ?>/assets/images/og-image.jpg">
    <meta property="og:site_name" content="<?php echo SITE_NAME; ?>">
    <meta property="og:locale" content="<?php echo $seo['og_locale']; ?>">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo htmlspecialchars($seo['canonical']); ?>">
    <meta property="twitter:title" content="<?php echo htmlspecialchars($seo['title']); ?>">
    <meta property="twitter:description" content="<?php echo htmlspecialchars($seo['description']); ?>">
    <meta property="twitter:image" content="<?php echo SITE_URL; ?>/assets/images/twitter-image.jpg">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
    <link rel="icon" href="assets/images/favicon.png" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
    
    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    
    <!-- Critical CSS (Bootstrap & Core) -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/responsive.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,600;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <?php if ($current_page === 'index'): ?>
    <!-- Homepage specific styles -->
    <link href="assets/css/lighttheme.css" rel="stylesheet">
    <link href="assets/css/popup-styles.css" rel="stylesheet">
    <?php endif; ?>
    
    <!-- Schema.org structured data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "<?php echo SITE_NAME; ?>",
        "description": "<?php echo $seo['description']; ?>",
        "url": "<?php echo SITE_URL; ?>",
        "logo": "<?php echo SITE_URL; ?>/assets/images/logo.png",
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "<?php echo SITE_PHONE; ?>",
            "contactType": "customer service",
            "email": "<?php echo SITE_EMAIL; ?>",
            "availableLanguage": "English"
        },
        "sameAs": [
            "https://www.linkedin.com/company/yourcompany",
            "https://twitter.com/yourcompany",
            "https://www.facebook.com/yourcompany"
        ]
    }
    </script>
    
    <!-- Google Analytics (replace with your tracking ID) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=GA_TRACKING_ID"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'GA_TRACKING_ID');
    </script>
</head>

<body class="<?php echo $current_page === 'journal' ? 'dark-theme' : ''; ?>">
    <!-- Skip to content for accessibility -->
    <a href="#main-content" class="skip-link" style="position:absolute;left:-9999px;z-index:999999;padding:8px;background:#000;color:#fff;text-decoration:none;" 
       onfocus="this.style.left='6px'" onblur="this.style.left='-9999px'">Skip to main content</a>

    <div class="page-wrapper <?php echo in_array($current_page, ['journal', 'journal-detail', 'contact', 'about']) ? 'image-layer' : ''; ?>" 
         <?php if (in_array($current_page, ['journal', 'journal-detail', 'contact', 'about'])): ?>
         style="background-image:url(assets/images/background/4.jpg)"
         <?php endif; ?>>
        
        <!-- Header Component -->
        <?php
        if (file_exists('components/header.php')) {
            require_once 'components/header.php';
        } else {
            echo '<!-- Header component not found -->';
        }
        ?>