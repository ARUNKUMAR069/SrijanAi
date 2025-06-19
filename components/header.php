
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
                                <img src="assets/images/logo2.png"  alt="Logo" title="Logo" class="theme-logo light-logo">
                            </a>
                        </div>
                    </div>
                    
                    <div class="nav-outer d-flex flex-wrap">
                        <!-- Main Menu -->
                        <nav class="main-menu navbar-expand-md">
                            <div class="navbar-header">
                                <!-- Toggle Button -->    	
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            
                            <div class="navbar-collapse collapse clearfix" id="navbarSupportedContent">
                                <ul class="navigation clearfix">
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="about.php">About</a></li>
                                    <li class="dropdown"><a href="#">journal</a>
                                        <ul>
                                            <li><a href="journal.php">journal</a></li>
                                            <li><a href="journal-detail.php">journal detail</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown"><a href="#">work</a>
                                        <ul>
                                            <li><a href="work.php">work</a></li>
                                            <li><a href="single-work.php">work detail</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="contact.php">Contact</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>

                    <!-- Mobile Navigation Toggler -->
                    <div class="mobile-nav-toggler">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 6l16 0" /><path d="M4 12l16 0" /><path d="M4 18l16 0" /></svg>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!--End Header Lower-->
    
    <!-- Mobile Menu  -->
    <div class="mobile-menu">
        <div class="menu-backdrop"></div>
        <div class="close-btn"><span class="icon fa-solid fa-xmark fa-fw"></span></div>
        
        <nav class="menu-box">
            <div class="nav-logo">
                <a href="index.php">
                    <!-- Dark theme mobile logo -->
                    <img src="assets/images/mobile-logo.png" alt="Logo" title="Logo" class="theme-logo dark-logo">
                    <!-- Light theme mobile logo -->
                    <img src="assets/images/logo2.jpg" alt="Logo" title="Logo" class="theme-logo light-logo">
                </a>
            </div>
            <div class="menu-outer"><!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header--></div>
        </nav>
    </div>
    <!-- End Mobile Menu -->

</header>
<!-- End Main Header -->

<style>
    /* Logo theme switching styles */
    .theme-logo {
        transition: opacity 0.3s ease;
    }
    
    /* Default state - hide light logo */
    .light-logo {
        display: none;
    }
    
    /* Light theme - show light logo, hide dark logo */
    [data-theme="light"] .light-logo {
        display: inline-block;
    }
    
    [data-theme="light"] .dark-logo {
        display: none;
    }
</style>

<script>
    // Add listener for theme changes
    window.addEventListener('themeChanged', function(e) {
        updateLogos(e.detail.theme);
    });
    
    // Update logos on page load
    document.addEventListener('DOMContentLoaded', function() {
        const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
        updateLogos(currentTheme);
    });
    
    // Function to update logos based on theme
    function updateLogos(theme) {
        const darkLogos = document.querySelectorAll('.dark-logo');
        const lightLogos = document.querySelectorAll('.light-logo');
        
        if (theme === 'light') {
            darkLogos.forEach(logo => logo.style.display = 'none');
            lightLogos.forEach(logo => logo.style.display = 'inline-block');
        } else {
            darkLogos.forEach(logo => logo.style.display = 'inline-block');
            lightLogos.forEach(logo => logo.style.display = 'none');
        }
    }
</script>