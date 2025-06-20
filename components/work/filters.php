<?php
// filepath: c:\xampp\htdocs\new4\components\work\filters.php

// Portfolio filter categories
$categories = [
    'all' => 'All Projects',
    'branding' => 'Branding',
    'web-design' => 'Web Design',
    'mobile-app' => 'Mobile Apps',
    'ui-ux' => 'UI/UX Design'
];

$current_filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
?>

<!-- Portfolio Filters -->
<section class="portfolio-filters">
    <div class="auto-container">
        <div class="filter-tabs">
            <div class="filter-btns text-center">
                <?php foreach ($categories as $key => $label): ?>
                    <button class="filter-btn <?php echo $current_filter === $key ? 'active' : ''; ?>" 
                            data-filter="<?php echo $key; ?>"
                            onclick="filterPortfolio('<?php echo $key; ?>')">
                        <?php echo htmlspecialchars($label); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<!-- End Portfolio Filters -->

<script>
function filterPortfolio(category) {
    // Update URL without refresh
    const url = new URL(window.location);
    if (category === 'all') {
        url.searchParams.delete('filter');
    } else {
        url.searchParams.set('filter', category);
    }
    window.history.pushState({}, '', url);
    
    // Show/hide items based on filter
    const items = document.querySelectorAll('.gallery-block_one');
    items.forEach(item => {
        const itemCategory = item.querySelector('.gallery-block_one-title').textContent.trim();
        if (category === 'all' || itemCategory === category) {
            item.style.display = 'block';
            item.classList.add('wow', 'fadeIn');
        } else {
            item.style.display = 'none';
        }
    });
    
    // Update active button
    document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelector(`[data-filter="${category}"]`).classList.add('active');
}
</script>