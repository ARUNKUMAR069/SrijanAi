<?php
// filepath: c:\xampp\htdocs\new4\components\work\portfolio.php

// Portfolio data - this could come from a database
$portfolio_items = [
    [
        'id' => 1,
        'title' => 'Glossy',
        'category' => 'branding',
        'image' => 'assets/images/gallery/1.jpg',
        'animation' => 'fadeInLeft'
    ],
    [
        'id' => 2,
        'title' => 'Boxkit',
        'category' => 'branding',
        'image' => 'assets/images/gallery/2.jpg',
        'animation' => 'fadeInUp'
    ],
    [
        'id' => 3,
        'title' => 'Landscape',
        'category' => 'branding',
        'image' => 'assets/images/gallery/3.jpg',
        'animation' => 'fadeInRight'
    ],
    [
        'id' => 4,
        'title' => 'Brando',
        'category' => 'branding',
        'image' => 'assets/images/gallery/4.jpg',
        'animation' => 'fadeInLeft'
    ],
    [
        'id' => 5,
        'title' => 'Tabzen',
        'category' => 'branding',
        'image' => 'assets/images/gallery/5.jpg',
        'animation' => 'fadeInUp'
    ],
    [
        'id' => 6,
        'title' => 'Minio',
        'category' => 'branding',
        'image' => 'assets/images/gallery/6.jpg',
        'animation' => 'fadeInRight'
    ],
    [
        'id' => 7,
        'title' => 'Glossy Pro',
        'category' => 'branding',
        'image' => 'assets/images/gallery/7.jpg',
        'animation' => 'fadeInLeft'
    ],
    [
        'id' => 8,
        'title' => 'Boxkit Pro',
        'category' => 'branding',
        'image' => 'assets/images/gallery/8.jpg',
        'animation' => 'fadeInUp'
    ],
    [
        'id' => 9,
        'title' => 'Landscape Pro',
        'category' => 'branding',
        'image' => 'assets/images/gallery/9.jpg',
        'animation' => 'fadeInRight'
    ],
    [
        'id' => 10,
        'title' => 'Brando Pro',
        'category' => 'branding',
        'image' => 'assets/images/gallery/10.jpg',
        'animation' => 'fadeInLeft'
    ],
    [
        'id' => 11,
        'title' => 'Tabzen Pro',
        'category' => 'branding',
        'image' => 'assets/images/gallery/11.jpg',
        'animation' => 'fadeInUp'
    ],
    [
        'id' => 12,
        'title' => 'Minio Pro',
        'category' => 'branding',
        'image' => 'assets/images/gallery/12.jpg',
        'animation' => 'fadeInRight'
    ]
];
?>

<!-- Work One -->
<section class="work-one">
    <div class="auto-container">
        <div class="row clearfix">
            <?php foreach ($portfolio_items as $item): ?>
                <?php include 'components/work/gallery-item.php'; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- End Work One -->