<?php
// filepath: c:\xampp\htdocs\new4\includes\config.php

// Site Configuration
define('SITE_NAME', 'Srijan AI Solutions');
define('SITE_TAGLINE', 'Innovative AI Solutions for Modern Business');
define('SITE_URL', 'https://srijanai.in/');
define('SITE_EMAIL', 'hello@srijanai.in');
define('SITE_PHONE', '+1-555-0123');

// Default SEO Settings
$default_seo = [
    'title' => 'Srijan AI Solutions - Innovative AI Solutions for Modern Business',
    'description' => 'Leading AI consulting company providing custom AI solutions, machine learning services, and intelligent automation for businesses worldwide.',
    'keywords' => 'AI solutions, machine learning, artificial intelligence, AI consulting, automation, data science',
    'author' => 'Srijan AI Solutions',
    'canonical' => SITE_URL,
    'og_type' => 'website',
    'og_locale' => 'en_US'
];

// Page-specific SEO data
$page_seo = [
    'index' => [
        'title' => 'Home - Srijan AI Solutions | Leading AI & Machine Learning Company',
        'description' => 'Transform your business with cutting-edge AI solutions. Expert AI consulting, custom ML models, and intelligent automation services.',
        'keywords' => 'AI company, machine learning services, AI consulting, business automation, AI solutions',
    ],
    'about' => [
        'title' => 'About Us - Srijan AI Solutions | Our AI Expertise & Team',
        'description' => 'Meet our expert AI team and learn about our mission to revolutionize business through innovative artificial intelligence solutions.',
        'keywords' => 'AI team, AI experts, AI company about, machine learning specialists',
    ],
    'contact' => [
        'title' => 'Contact Us - Srijan AI Solutions | Get in Touch for AI Solutions',
        'description' => 'Contact our AI experts for consultation. We provide custom AI solutions, machine learning services, and intelligent automation.',
        'keywords' => 'AI consultation, contact AI company, AI services inquiry',
    ],
    'journal' => [
        'title' => 'Tech Journal - Srijan AI Solutions | AI News & Insights',
        'description' => 'Stay updated with latest AI trends, machine learning insights, and technology news from our expert team.',
        'keywords' => 'AI blog, machine learning news, AI insights, technology trends',
    ],
    'journal-detail' => [
        'title' => 'Journal Article - Srijan AI Solutions',
        'description' => 'In-depth analysis and insights on artificial intelligence and machine learning technologies.',
        'keywords' => 'AI article, machine learning insights, AI technology',
    ]
];

// Get current page name
function getCurrentPage() {
    $current_page = basename($_SERVER['PHP_SELF'], '.php');
    return $current_page;
}

// Get SEO data for current page
function getPageSEO() {
    global $page_seo, $default_seo;
    $current_page = getCurrentPage();
    
    if (isset($page_seo[$current_page])) {
        return array_merge($default_seo, $page_seo[$current_page]);
    }
    
    return $default_seo;
}
?>