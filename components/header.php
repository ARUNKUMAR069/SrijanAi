<header class="main-header">
    
    <!-- Header Lower -->
    <div class="header-lower">
        <div class="auto-container">
            <div class="inner-container">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    
                    <div class="logo-box">
                        <div class="logo">
                            <a href="index.php">
                                <!-- Dark theme logo -->
                                <img src="assets/images/logo.png" alt="Logo" title="Logo" class="theme-logo dark-logo">
                                <!-- Light theme logo -->
                                <img src="assets/images/logo2.png" alt="Logo" title="Logo" class="theme-logo light-logo">
                            </a>
                        </div>
                    </div>
                    
                    <div class="nav-outer d-flex flex-wrap">
                        <!-- Main Menu -->
                        <nav class="main-menu navbar-expand-md">
                            <div class="navbar-collapse collapse clearfix" id="navbarSupportedContent">
                                <ul class="navigation clearfix">
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="about.php">About</a></li>
                                    <li class="dropdown"><a href="#">Journal</a>
                                        <ul>
                                            <li><a href="journal.php">Journal</a></li>
                                            <li><a href="journal-detail.php">Journal Detail</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown"><a href="#">Work</a>
                                        <ul>
                                            <li><a href="work.php">Work</a></li>
                                            <li><a href="single-work.php">Work Detail</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="contact.php">Contact</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>

                    <!-- Mobile Navigation Toggler with Hamburger Icon -->
                    <div class="mobile-nav-toggler">
                        <div class="hamburger-icon">
                            <img src="assets/hamburger.png" alt="Menu" class="hamburger-img">
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!--End Header Lower-->
    
    <!-- Mobile Menu - ALWAYS DARK THEME -->
    <div class="mobile-menu-overlay mobile-menu-force-dark">
        <div class="mobile-menu-container">
            <div class="mobile-menu-header">
                <div class="mobile-logo">
                    <a href="index.php">
                        <!-- Always show dark logo in mobile menu -->
                        <img src="assets/images/logo.png" alt="Logo" class="mobile-menu-logo">
                    </a>
                </div>
                <button class="mobile-close-btn">
                    <span class="close-line close-line-1"></span>
                    <span class="close-line close-line-2"></span>
                </button>
            </div>
            
            <nav class="mobile-navigation">
                <ul class="mobile-nav-list">
                    <li class="mobile-nav-item">
                        <a href="index.php" class="mobile-nav-link">Home</a>
                    </li>
                    <li class="mobile-nav-item">
                        <a href="about.php" class="mobile-nav-link">About</a>
                    </li>
                    <li class="mobile-nav-item mobile-dropdown">
                        <a href="#" class="mobile-nav-link">Journal</a>
                        <button class="mobile-dropdown-toggle">
                            <span class="dropdown-icon"></span>
                        </button>
                        <ul class="mobile-dropdown-menu">
                            <li><a href="journal.php" class="mobile-nav-link sub-link">Journal</a></li>
                            <li><a href="journal-detail.php" class="mobile-nav-link sub-link">Journal Detail</a></li>
                        </ul>
                    </li>
                    <li class="mobile-nav-item mobile-dropdown">
                        <a href="#" class="mobile-nav-link">Work</a>
                        <button class="mobile-dropdown-toggle">
                            <span class="dropdown-icon"></span>
                        </button>
                        <ul class="mobile-dropdown-menu">
                            <li><a href="work.php" class="mobile-nav-link sub-link">Work</a></li>
                            <li><a href="single-work.php" class="mobile-nav-link sub-link">Work Detail</a></li>
                        </ul>
                    </li>
                    <li class="mobile-nav-item">
                        <a href="contact.php" class="mobile-nav-link">Contact</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- End Mobile Menu -->

</header>
<!-- End Main Header -->

<style>
/* ====================================================================
   MOBILE HEADER - HAMBURGER ICON IMPLEMENTATION
   ==================================================================== */

/* Logo Theme Switching - ONLY FOR MAIN HEADER */
.theme-logo {
    transition: all 0.3s ease;
    max-height: 60px;
    width: auto;
}

.light-logo {
    display: none;
}

.dark-logo {
    display: block;
}

[data-theme="light"] .main-header .light-logo {
    display: block !important;
}

[data-theme="light"] .main-header .dark-logo {
    display: none !important;
}

/* ====================================================================
   MOBILE HEADER BACKGROUND REMOVAL
   ==================================================================== */

@media (max-width: 991px) {
    .main-header {
        background: transparent !important;
        background-color: transparent !important;
        background-image: none !important;
        box-shadow: none !important;
        border: none !important;
        backdrop-filter: none !important;
    }
    
    .main-header .header-lower,
    .main-header .inner-container,
    .main-header .auto-container {
        background: transparent !important;
        background-color: transparent !important;
        box-shadow: none !important;
        border: none !important;
    }
}

/* ====================================================================
   MOBILE NAVIGATION TOGGLER - HAMBURGER ICON
   ==================================================================== */

.mobile-nav-toggler {
    display: none;
    width: 50px;
    height: 50px;
    position: relative;
    cursor: pointer;
    z-index: 1000;
    background: transparent;
    border: none;
    padding: 8px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.mobile-nav-toggler:hover {
    background: rgba(255, 255, 255, 0.1);
}

[data-theme="light"] .mobile-nav-toggler:hover {
    background: rgba(0, 0, 0, 0.05);
}

.hamburger-icon {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.hamburger-img {
    width: 28px;
    height: 28px;
    transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    transform-origin: center;
}

/* Dark Theme: White hamburger icon */
.hamburger-img {
    filter: brightness(0) saturate(100%) invert(1); /* White for dark theme */
}

/* Light Theme: Black hamburger icon */
[data-theme="light"] .hamburger-img {
    filter: brightness(0) saturate(100%) !important; /* Black for light theme */
}

/* OVERRIDE: When mobile menu is active, ALWAYS show white hamburger */
.mobile-menu-active .hamburger-img {
    filter: brightness(0) saturate(100%) invert(1) !important; /* Force white when menu is open */
    transform: rotate(90deg) scale(0.8);
    opacity: 0.8;
}

/* ====================================================================
   MOBILE MENU OVERLAY - FORCE DARK THEME ALWAYS
   ==================================================================== */

.mobile-menu-overlay.mobile-menu-force-dark {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    /* FORCE DARK: Using fixed dark color instead of CSS variables */
    background: #1a1a1a !important; /* Fixed dark background */
    z-index: 9999;
    transform: translateX(-100%);
    transition: transform 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    overflow-y: auto;
}

.mobile-menu-active .mobile-menu-overlay {
    transform: translateX(0);
}

/* ====================================================================
   MOBILE MENU CONTAINER - FORCE DARK STYLING
   ==================================================================== */

.mobile-menu-force-dark .mobile-menu-container {
    padding: 20px 25px;
    height: 100%;
    display: flex;
    flex-direction: column;
    /* FORCE DARK: Ensure container always has dark background */
    background-color: #1a1a1a !important;
    color: #ffffff !important;
}

/* ADDITIONAL OVERRIDE: Force dark styling regardless of any theme */
[data-theme="light"] .mobile-menu-force-dark .mobile-menu-container,
[data-theme="dark"] .mobile-menu-force-dark .mobile-menu-container,
.mobile-menu-force-dark .mobile-menu-container {
    background-color: #1a1a1a !important;
    background: #1a1a1a !important;
    color: #ffffff !important;
}

/* Force all child elements to inherit proper colors */
.mobile-menu-force-dark .mobile-menu-container * {
    color: inherit !important;
}

/* Ensure no theme variables affect the container */
.mobile-menu-force-dark .mobile-menu-container {
    /* Override any CSS variables that might affect styling */
    --bg-color: #1a1a1a !important;
    --text-color: #ffffff !important;
    --border-color: rgba(255, 255, 255, 0.1) !important;
}

.mobile-menu-force-dark .mobile-menu-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 30px;
    /* FORCE DARK: Fixed white border */
    border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
    margin-bottom: 40px;
}

.mobile-menu-force-dark .mobile-menu-logo {
    max-height: 50px;
    width: auto;
}

/* ====================================================================
   MOBILE CLOSE BUTTON - FORCE WHITE ALWAYS
   ==================================================================== */

.mobile-menu-force-dark .mobile-close-btn {
    width: 45px;
    height: 45px;
    /* FORCE DARK: Fixed white/transparent styling */
    background: rgba(255, 255, 255, 0.1) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.mobile-menu-force-dark .mobile-close-btn:hover {
    background: rgba(255, 255, 255, 0.2) !important;
    transform: rotate(90deg);
}

.mobile-menu-force-dark .close-line {
    position: absolute;
    width: 20px;
    height: 2px;
    /* FORCE DARK: Fixed white lines */
    background-color: #ffffff !important;
    border-radius: 1px;
    transition: all 0.3s ease;
}

.mobile-menu-force-dark .close-line-1 {
    transform: rotate(45deg);
}

.mobile-menu-force-dark .close-line-2 {
    transform: rotate(-45deg);
}

/* ====================================================================
   MOBILE NAVIGATION MENU - FORCE DARK STYLING
   ==================================================================== */

.mobile-menu-force-dark .mobile-navigation {
    flex: 1;
}

.mobile-menu-force-dark .mobile-nav-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.mobile-menu-force-dark .mobile-nav-item {
    position: relative;
    /* FORCE DARK: Fixed white border */
    border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
    opacity: 0;
    transform: translateX(-30px);
    animation: slideInMobile 0.6s ease forwards;
}

.mobile-menu-force-dark .mobile-nav-item:nth-child(1) { animation-delay: 0.1s; }
.mobile-menu-force-dark .mobile-nav-item:nth-child(2) { animation-delay: 0.2s; }
.mobile-menu-force-dark .mobile-nav-item:nth-child(3) { animation-delay: 0.3s; }
.mobile-menu-force-dark .mobile-nav-item:nth-child(4) { animation-delay: 0.4s; }
.mobile-menu-force-dark .mobile-nav-item:nth-child(5) { animation-delay: 0.5s; }

@keyframes slideInMobile {
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.mobile-menu-force-dark .mobile-nav-link {
    display: block;
    padding: 20px 0;
    /* FORCE DARK: Fixed white text */
    color: #ffffff !important;
    text-decoration: none;
    font-size: 18px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    position: relative;
}

.mobile-menu-force-dark .mobile-nav-link::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    width: 0;
    height: 2px;
    /* FORCE DARK: Fixed gradient colors */
    background: linear-gradient(90deg, #ff6b35, #f7931e) !important;
    transition: width 0.4s ease;
    transform: translateY(-50%);
}

.mobile-menu-force-dark .mobile-nav-link:hover {
    /* FORCE DARK: Fixed orange color */
    color: #ff6b35 !important;
    padding-left: 20px;
}

.mobile-menu-force-dark .mobile-nav-link:hover::before {
    width: 15px;
}

/* Sub Navigation Links - FORCE DARK */
.mobile-menu-force-dark .mobile-nav-link.sub-link {
    font-size: 16px;
    font-weight: 400;
    padding: 15px 0 15px 30px;
    /* FORCE DARK: Fixed light white text */
    color: rgba(255, 255, 255, 0.8) !important;
    text-transform: none;
    letter-spacing: 0.5px;
}

.mobile-menu-force-dark .mobile-nav-link.sub-link:hover {
    /* FORCE DARK: Fixed orange color */
    color: #ff6b35 !important;
    padding-left: 50px;
}

/* ====================================================================
   MOBILE DROPDOWN FUNCTIONALITY - FORCE DARK STYLING
   ==================================================================== */

.mobile-menu-force-dark .mobile-dropdown {
    position: relative;
}

.mobile-menu-force-dark .mobile-dropdown-toggle {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    width: 35px;
    height: 35px;
    /* FORCE DARK: Fixed white/transparent styling */
    background: rgba(255, 255, 255, 0.1) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.mobile-menu-force-dark .dropdown-icon {
    width: 12px;
    height: 12px;
    /* FORCE DARK: Fixed white borders */
    border-right: 2px solid #ffffff !important;
    border-bottom: 2px solid #ffffff !important;
    transform: rotate(45deg);
    transition: transform 0.3s ease;
}

.mobile-menu-force-dark .mobile-dropdown.active .dropdown-icon {
    transform: rotate(225deg);
}

.mobile-menu-force-dark .mobile-dropdown-menu {
    list-style: none;
    margin: 0;
    padding: 0;
    /* FORCE DARK: Fixed dark background */
    background: rgba(0, 0, 0, 0.4) !important;
    border-radius: 8px;
    margin-top: 10px;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s ease;
}

.mobile-menu-force-dark .mobile-dropdown.active .mobile-dropdown-menu {
    max-height: 200px;
}

/* ====================================================================
   THEME OVERRIDE PREVENTION - FORCE DARK MENU
   ==================================================================== */

/* Prevent ANY theme-based overrides on mobile menu */
[data-theme="light"] .mobile-menu-force-dark,
[data-theme="light"] .mobile-menu-force-dark *,
[data-theme="dark"] .mobile-menu-force-dark,
[data-theme="dark"] .mobile-menu-force-dark * {
    /* Reset any theme-based color variables to fixed values */
    --mobile-bg: #1a1a1a !important;
    --mobile-text: #ffffff !important;
    --mobile-border: rgba(255, 255, 255, 0.1) !important;
    --mobile-accent: #ff6b35 !important;
}

/* Additional safety overrides */
.mobile-menu-force-dark,
.mobile-menu-force-dark * {
    /* Prevent inheritance of theme colors */
    color: inherit !important;
}

/* ====================================================================
   MOBILE RESPONSIVE BREAKPOINTS
   ==================================================================== */

@media (max-width: 991px) {
    .mobile-nav-toggler {
        display: flex !important;
        align-items: center;
        justify-content: center;
    }
    
    .main-menu {
        display: none !important;
    }
    
    .logo-box .logo img {
        max-height: 45px;
    }
}

@media (max-width: 768px) {
    .logo-box .logo img {
        max-height: 40px;
    }
    
    .mobile-menu-force-dark .mobile-menu-container {
        padding: 15px 20px;
    }
    
    .mobile-menu-force-dark .mobile-nav-link {
        font-size: 16px;
        padding: 18px 0;
    }
    
    .hamburger-img {
        width: 24px;
        height: 24px;
    }
}

@media (max-width: 576px) {
    .logo-box .logo img {
        max-height: 35px;
    }
    
    .mobile-menu-force-dark .mobile-menu-container {
        padding: 15px;
    }
    
    .mobile-menu-force-dark .mobile-nav-link {
        font-size: 15px;
        padding: 16px 0;
    }
    
    .hamburger-img {
        width: 22px;
        height: 22px;
    }
    
    .mobile-nav-toggler {
        width: 45px;
        height: 45px;
    }
}

/* ====================================================================
   PREVENT BODY SCROLL WHEN MENU IS OPEN
   ==================================================================== */

body.mobile-menu-active {
    overflow: hidden !important;
    position: fixed !important;
    width: 100% !important;
}

/* ====================================================================
   ACCESSIBILITY AND FOCUS STATES
   ==================================================================== */

.mobile-nav-toggler:focus,
.mobile-menu-force-dark .mobile-close-btn:focus,
.mobile-menu-force-dark .mobile-dropdown-toggle:focus {
    outline: 2px solid #ff6b35;
    outline-offset: 2px;
}

.mobile-menu-force-dark .mobile-nav-link:focus {
    outline: 2px solid #ff6b35;
    outline-offset: 2px;
    background: rgba(255, 107, 53, 0.1);
}

/* High Contrast Support */
@media (prefers-contrast: high) {
    [data-theme="light"] .hamburger-img {
        filter: brightness(0) saturate(100%) contrast(2) !important;
    }
    
    .hamburger-img {
        filter: brightness(0) saturate(100%) invert(1) contrast(2) !important;
    }
    
    .mobile-menu-active .hamburger-img {
        filter: brightness(0) saturate(100%) invert(1) contrast(2) !important;
    }
}

/* ====================================================================
   ANIMATION IMPROVEMENTS
   ==================================================================== */

/* Smooth transitions for theme switching */
.hamburger-img {
    transition: filter 0.3s ease, transform 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

/* Loading state animation */
.mobile-nav-toggler.loading .hamburger-img {
    animation: pulse 1s infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.7;
    }
}

/* Enhanced hover effects */
.mobile-nav-toggler:hover .hamburger-img {
    transform: scale(1.1);
}

.mobile-menu-active .mobile-nav-toggler:hover .hamburger-img {
    transform: rotate(90deg) scale(0.9);
}
</style>

<script>
// ====================================================================
// MOBILE MENU FUNCTIONALITY - FORCE DARK THEME VERSION
// ====================================================================

document.addEventListener('DOMContentLoaded', function() {
    
    // Theme Logo Management (ONLY for main header, mobile menu always uses dark logo)
    function updateLogos(theme) {
        // Only update main header logos
        const mainHeaderDarkLogos = document.querySelectorAll('.main-header .dark-logo');
        const mainHeaderLightLogos = document.querySelectorAll('.main-header .light-logo');
        
        if (theme === 'light') {
            mainHeaderDarkLogos.forEach(logo => logo.style.display = 'none');
            mainHeaderLightLogos.forEach(logo => logo.style.display = 'block');
        } else {
            mainHeaderDarkLogos.forEach(logo => logo.style.display = 'block');
            mainHeaderLightLogos.forEach(logo => logo.style.display = 'none');
        }
        
        // Mobile menu ALWAYS shows dark logo - no theme dependency
        const mobileMenuLogo = document.querySelector('.mobile-menu-logo');
        if (mobileMenuLogo) {
            mobileMenuLogo.style.display = 'block';
            mobileMenuLogo.style.opacity = '1';
            mobileMenuLogo.style.visibility = 'visible';
        }
    }
    
    // Initialize logos
    const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
    updateLogos(currentTheme);
    
    // Listen for theme changes (only affects main header)
    window.addEventListener('themeChanged', function(e) {
        updateLogos(e.detail.theme);
    });
    
    // Mobile Menu Elements
    const mobileToggler = document.querySelector('.mobile-nav-toggler');
    const mobileCloseBtn = document.querySelector('.mobile-close-btn');
    const mobileOverlay = document.querySelector('.mobile-menu-overlay');
    const hamburgerImg = document.querySelector('.hamburger-img');
    const body = document.body;
    
    // Mobile Menu Functions
    function openMobileMenu() {
        body.classList.add('mobile-menu-active');
        
        // Force hamburger to white when menu opens
        if (hamburgerImg) {
            hamburgerImg.style.filter = 'brightness(0) saturate(100%) invert(1) !important';
        }
        
        // Add loading state briefly
        if (mobileToggler) {
            mobileToggler.classList.add('loading');
            setTimeout(() => {
                mobileToggler.classList.remove('loading');
            }, 300);
        }
        
        // Reset animations
        const menuItems = document.querySelectorAll('.mobile-nav-item');
        menuItems.forEach((item, index) => {
            item.style.animationDelay = (index * 0.1) + 's';
            item.style.animation = 'slideInMobile 0.6s ease forwards';
        });
    }
    
    function closeMobileMenu() {
        body.classList.remove('mobile-menu-active');
        
        // Restore hamburger color based on theme
        if (hamburgerImg) {
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
            if (currentTheme === 'light') {
                hamburgerImg.style.filter = 'brightness(0) saturate(100%)'; // Black for light theme
            } else {
                hamburgerImg.style.filter = 'brightness(0) saturate(100%) invert(1)'; // White for dark theme
            }
        }
        
        // Close all dropdowns
        const dropdowns = document.querySelectorAll('.mobile-dropdown');
        dropdowns.forEach(dropdown => {
            dropdown.classList.remove('active');
        });
    }
    
    // Event Listeners
    if (mobileToggler) {
        mobileToggler.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            openMobileMenu();
        });
    }
    
    if (mobileCloseBtn) {
        mobileCloseBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closeMobileMenu();
        });
    }
    
    // Close on overlay click
    if (mobileOverlay) {
        mobileOverlay.addEventListener('click', function(e) {
            if (e.target === mobileOverlay) {
                closeMobileMenu();
            }
        });
    }
    
    // Dropdown Toggle Functionality
    const dropdownToggles = document.querySelectorAll('.mobile-dropdown-toggle');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const dropdown = this.closest('.mobile-dropdown');
            const isActive = dropdown.classList.contains('active');
            
            // Close all other dropdowns
            dropdownToggles.forEach(otherToggle => {
                const otherDropdown = otherToggle.closest('.mobile-dropdown');
                if (otherDropdown !== dropdown) {
                    otherDropdown.classList.remove('active');
                }
            });
            
            // Toggle current dropdown
            if (isActive) {
                dropdown.classList.remove('active');
            } else {
                dropdown.classList.add('active');
            }
        });
    });
    
    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.keyCode === 27 && body.classList.contains('mobile-menu-active')) {
            closeMobileMenu();
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 991 && body.classList.contains('mobile-menu-active')) {
            closeMobileMenu();
        }
    });
    
    // Handle orientation change
    window.addEventListener('orientationchange', function() {
        setTimeout(function() {
            if (window.innerWidth > 991 && body.classList.contains('mobile-menu-active')) {
                closeMobileMenu();
            }
        }, 500);
    });
    
    // Smooth scroll for anchor links
    const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
    mobileNavLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href && href.startsWith('#')) {
                closeMobileMenu();
            }
        });
    });
    
    // Enhanced hamburger icon handling
    if (hamburgerImg) {
        // Preload image
        const img = new Image();
        img.src = 'assets/hamburger.png';
        
        // Handle image load error
        hamburgerImg.addEventListener('error', function() {
            console.warn('Hamburger icon not found, falling back to text');
            this.style.display = 'none';
            this.parentElement.innerHTML = '<span style="color: inherit; font-size: 20px;">☰</span>';
        });
    }
    
    // Force mobile menu consistency on theme change
    window.addEventListener('themeChanged', function(e) {
        // Ensure mobile menu elements maintain dark styling
        const mobileMenuOverlay = document.querySelector('.mobile-menu-force-dark');
        if (mobileMenuOverlay) {
            // Force reapply dark styles
            mobileMenuOverlay.style.background = '#1a1a1a';
        }
        
        // Update hamburger color only if menu is closed
        if (!body.classList.contains('mobile-menu-active') && hamburgerImg) {
            if (e.detail.theme === 'light') {
                hamburgerImg.style.filter = 'brightness(0) saturate(100%)'; // Black for light theme
            } else {
                hamburgerImg.style.filter = 'brightness(0) saturate(100%) invert(1)'; // White for dark theme
            }
        }
    });
    
});
</script>