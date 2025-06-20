<?php
// filepath: c:\xampp\htdocs\new4\components\work\gallery-item.php

// This component renders a single gallery item
// $item variable is passed from the parent component
?>

<!-- Gallery Block One -->
<div class="gallery-block_one col-lg-4 col-md-6 col-sm-12">
    <div class="gallery-block_one-inner wow <?php echo htmlspecialchars($item['animation']); ?>" 
         data-wow-delay="0ms" 
         data-wow-duration="1500ms">
        <div class="gallery-block_one-content">
            <div class="gallery-block_one-image">
                <a href="single-work.php?id=<?php echo $item['id']; ?>" 
                   aria-label="View <?php echo htmlspecialchars($item['title']); ?> project">
                    <img src="<?php echo htmlspecialchars($item['image']); ?>" 
                         alt="<?php echo htmlspecialchars($item['title']); ?> - <?php echo htmlspecialchars($item['category']); ?> project" 
                         loading="lazy" />
                </a>
            </div>
            <div class="gallery-block_one-title"><?php echo htmlspecialchars($item['category']); ?></div>
            <h4 class="gallery-block_one-heading">
                <a href="single-work.php?id=<?php echo $item['id']; ?>">
                    <?php echo htmlspecialchars($item['title']); ?>
                </a>
            </h4>
        </div>
        <div class="service-block_one-more">
            <a class="view-more" 
               href="single-work.php?id=<?php echo $item['id']; ?>"
               aria-label="View <?php echo htmlspecialchars($item['title']); ?> project details">
                View Project <i class="fa-solid fa-arrow-right fa-fw" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</div>