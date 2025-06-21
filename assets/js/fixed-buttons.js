// ====================================================================
// FIXED ACTION BUTTONS - GLOBAL FUNCTIONALITY
// ====================================================================

document.addEventListener('DOMContentLoaded', function() {
    const enquireButton = document.getElementById('enquireButton');
    const enquiryPopup = document.getElementById('enquiryPopup');
    
    // Handle Enquire Button Click
    if (enquireButton) {
        enquireButton.addEventListener('click', function() {
            // Check if we're on homepage (has popup)
            if (enquiryPopup) {
                // Show popup
                if (typeof showEnquiryPopup === 'function') {
                    showEnquiryPopup();
                }
            } else {
                // Redirect to contact page or homepage
                window.location.href = 'index.php#enquiry';
            }
            
            // Track analytics
            if (typeof gtag !== 'undefined') {
                gtag('event', 'enquire_button_clicked', {
                    event_category: 'engagement',
                    event_label: 'fixed_enquire_button',
                    value: 1
                });
            }
        });
        
        // Add hover effects
        enquireButton.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.05)';
        });
        
        enquireButton.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    }
    
    // Handle scroll behavior for buttons
    let lastScrollTop = 0;
    const fixedButtons = document.querySelector('.fixed-action-buttons');
    
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // Hide/show buttons on scroll (optional)
        if (scrollTop > lastScrollTop && scrollTop > 200) {
            // Scrolling down
            if (fixedButtons) {
                fixedButtons.style.transform = 'translateY(20px)';
                fixedButtons.style.opacity = '0.7';
            }
        } else {
            // Scrolling up
            if (fixedButtons) {
                fixedButtons.style.transform = 'translateY(0)';
                fixedButtons.style.opacity = '1';
            }
        }
        
        lastScrollTop = scrollTop;
    });
});