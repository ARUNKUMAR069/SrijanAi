/**
 * Enhanced Theme Management with Animation Handling
 */

function toggleTheme() {
    const html = document.documentElement;
    const currentTheme = html.getAttribute('data-theme');
    const newTheme = currentTheme === 'light' ? 'dark' : 'light';
    const toggleButton = document.querySelector('.theme-toggle');
    
    // Pause all WOW animations during theme transition
    const wowElements = document.querySelectorAll('.wow');
    wowElements.forEach(el => {
        el.style.animationPlayState = 'paused';
    });
    
    // Add switching animation
    if (toggleButton) {
        toggleButton.classList.add('switching');
    }
    document.body.classList.add('theme-transitioning');
    
    // Apply theme change
    setTimeout(() => {
        html.setAttribute('data-theme', newTheme);
        localStorage.setItem('preferred-theme', newTheme);
        
        // Dispatch custom event
        window.dispatchEvent(new CustomEvent('themeChanged', {
            detail: { theme: newTheme }
        }));
    }, 100);
    
    // Resume animations and remove transition classes
    setTimeout(() => {
        if (toggleButton) {
            toggleButton.classList.remove('switching');
        }
        document.body.classList.remove('theme-transitioning');
        
        // Resume WOW animations
        wowElements.forEach(el => {
            el.style.animationPlayState = 'running';
        });
        
        // Re-initialize WOW if needed
        if (typeof WOW !== 'undefined') {
            new WOW().init();
        }
    }, 600);
}

// Initialize theme on page load
function initializeTheme() {
    const savedTheme = localStorage.getItem('preferred-theme');
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    let theme = savedTheme || (systemPrefersDark ? 'dark' : 'light');
    
    document.documentElement.setAttribute('data-theme', theme);
    
    // Show toggle button after theme is set
    setTimeout(() => {
        const toggleContainer = document.querySelector('.theme-toggle-container');
        if (toggleContainer) {
            toggleContainer.classList.add('visible');
        }
    }, 500);
}

// Enhanced system theme listener
function setupSystemThemeListener() {
    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
    
    mediaQuery.addEventListener('change', (e) => {
        if (!localStorage.getItem('preferred-theme')) {
            const newTheme = e.matches ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', newTheme);
        }
    });
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    initializeTheme();
    setupSystemThemeListener();
    
    // Keyboard support
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.shiftKey && e.key === 'T') {
            e.preventDefault();
            toggleTheme();
        }
    });
});

// Initialize immediately
initializeTheme();
