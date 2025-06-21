
<!-- WhatsApp Widget -->
<div class="whatsapp-widget">
    <!-- WhatsApp Floating Button -->
    <div class="whatsapp-float">
        <a href="https://wa.me/+918699202699?text=Hello%20SrijanAI%20Innovations%20Pvt.%20Ltd.,%20I%20would%20like%20to%20know%20more%20about%20your%20services!" 
           target="_blank" 
           aria-label="Contact us on WhatsApp"
           class="whatsapp-float-btn">
            <img src="assets/images/whats.png" alt="WhatsApp" class="" c>
            <div class="whatsapp-pulse"></div>
        </a>
    </div>

    <!-- WhatsApp Popup -->
    <div class="whatsapp-popup" id="whatsappPopup">
        <div class="whatsapp-popup-close" id="whatsappClose">
            <i class="fas fa-times"></i>
        </div>
        <div class="whatsapp-popup-header">
            <div class="whatsapp-avatar">
                <img src="assets/images/whats.png" alt="Support" class="avatar-img">
                <div class="online-indicator"></div>
            </div>
            <div class="whatsapp-header-text">
                <h4 class="whatsapp-popup-title">SrijanAI Support</h4>
                <span class="whatsapp-status">Online</span>
            </div>
        </div>
        <div class="whatsapp-popup-body">
            <div class="whatsapp-message">
                <div class="message-bubble">
                    <p class="whatsapp-popup-message">🚀 Revolutionize Your Business with AI!</p>
                    <p class="whatsapp-popup-submessage">Send us a Hi to get started and discover how our AI solutions can transform your workflow.</p>
                    <span class="message-time">Just now</span>
                </div>
            </div>
        </div>
        <div class="whatsapp-popup-footer">
            <a href="https://wa.me/+918699202699?text=Hello%20SrijanAI%20Innovations%20Pvt.%20Ltd.,%20I%20would%20like%20to%20know%20more%20about%20your%20services!"
               class="whatsapp-popup-button" 
               target="_blank"
               id="whatsappSendBtn">
                <i class="fab fa-whatsapp"></i>
                <span>Send Message</span>
                <div class="button-shine"></div>
            </a>
        </div>
    </div>
</div>

<style>
/* ====================================================================
   FIXED ACTION BUTTONS CONTAINER
   ==================================================================== */

.fixed-action-buttons {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 999990;
}

.fixed-action-buttons > * {
    pointer-events: auto;
}

/* ====================================================================
   ENQUIRY BUTTON - BOTTOM LEFT
   ==================================================================== */

.enquire-button {
    position: fixed;
    bottom: 30px;
    left: 30px;
    background: linear-gradient(135deg, #ba024a 0%, #540045 100%);
    color: #ffffff;
    padding: 15px 25px;
    border-radius: 50px;
    cursor: pointer;
    box-shadow: 0 10px 30px rgba(186, 2, 74, 0.4);
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    z-index: 999995;
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 160px;
    border: 2px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.enquire-button:hover {
    transform: translateY(-5px) scale(1.05);
    box-shadow: 0 15px 40px rgba(186, 2, 74, 0.6);
    background: linear-gradient(135deg, #d4026b 0%, #6b0051 100%);
}

.enquire-button-content {
    display: flex;
    align-items: center;
    gap: 10px;
    position: relative;
}

.enquire-button i {
    font-size: 18px;
    color: #ffffff;
}

.enquire-text {
    font-weight: 600;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.enquire-pulse {
    position: absolute;
    top: -15px;
    left: -15px;
    right: -15px;
    bottom: -15px;
    border: 2px solid rgba(186, 2, 74, 0.6);
    border-radius: 50px;
    animation: enquirePulse 2s infinite;
}

@keyframes enquirePulse {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    70% {
        transform: scale(1.1);
        opacity: 0;
    }
    100% {
        transform: scale(1.1);
        opacity: 0;
    }
}

/* ====================================================================
   WHATSAPP WIDGET - RIGHT MIDDLE
   ==================================================================== */

.whatsapp-widget-container {
    position: fixed;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 999995;
}

.whatsapp-widget {
    position: relative;
    /* Remove previous positioning */
}

/* ====================================================================
   WHATSAPP FLOATING BUTTON
   ==================================================================== */

.whatsapp-float {
    position: relative;
    z-index: 999999;
}

.whatsapp-float-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
    border-radius: 50%;
    box-shadow: 0 8px 25px rgba(37, 211, 102, 0.4);
    transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    position: relative;
    overflow: hidden;
    text-decoration: none;
    border: 2px solid rgba(255, 255, 255, 0.2);
}

.whatsapp-float-btn:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 12px 35px rgba(37, 211, 102, 0.6);
    text-decoration: none;
}

.whatsapp-icon {
    width: 32px;
    height: 32px;
    filter: brightness(0) invert(1);
    transition: transform 0.3s ease;
    z-index: 2;
    position: relative;
}

.whatsapp-float-btn:hover .whatsapp-icon {
    transform: scale(1.1);
}

/* Pulse Animation */
.whatsapp-pulse {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: rgba(37, 211, 102, 0.3);
    animation: whatsappPulse 2s infinite;
    pointer-events: none;
}

@keyframes whatsappPulse {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    70% {
        transform: scale(1.4);
        opacity: 0;
    }
    100% {
        transform: scale(1.4);
        opacity: 0;
    }
}

/* ====================================================================
   WHATSAPP POPUP - POSITIONED LEFT OF BUTTON
   ==================================================================== */

.whatsapp-popup {
    position: absolute;
    right: 80px;
    top: 50%;
    transform: translateY(-50%);
    background: #ffffff;
    width: 320px;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    opacity: 0;
    visibility: hidden;
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    overflow: hidden;
    border: 1px solid rgba(0, 0, 0, 0.1);
    z-index: 999998;
}

.whatsapp-popup.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(-50%) scale(1);
}

.whatsapp-popup::before {
    content: '';
    position: absolute;
    top: 50%;
    right: -8px;
    transform: translateY(-50%);
    width: 0;
    height: 0;
    border-top: 8px solid transparent;
    border-bottom: 8px solid transparent;
    border-left: 8px solid #ffffff;
    filter: drop-shadow(2px 0 3px rgba(0, 0, 0, 0.1));
}

/* ====================================================================
   POPUP HEADER
   ==================================================================== */

.whatsapp-popup-header {
    background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
    padding: 16px 20px;
    display: flex;
    align-items: center;
    position: relative;
}

.whatsapp-avatar {
    position: relative;
    margin-right: 12px;
}

.avatar-img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid rgba(255, 255, 255, 0.3);
    object-fit: cover;
}

.online-indicator {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 10px;
    height: 10px;
    background: #00ff00;
    border-radius: 50%;
    border: 2px solid #ffffff;
    animation: onlineBlink 2s infinite;
}

@keyframes onlineBlink {
    0%, 50% { opacity: 1; }
    51%, 100% { opacity: 0.7; }
}

.whatsapp-header-text {
    flex: 1;
}

.whatsapp-popup-title {
    color: #ffffff;
    font-size: 16px;
    font-weight: 600;
    margin: 0 0 2px 0;
    font-family: 'Inter', sans-serif;
}

.whatsapp-status {
    color: rgba(255, 255, 255, 0.9);
    font-size: 12px;
    font-weight: 400;
}

.whatsapp-popup-close {
    position: absolute;
    top: 12px;
    right: 15px;
    color: rgba(255, 255, 255, 0.8);
    cursor: pointer;
    font-size: 16px;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.whatsapp-popup-close:hover {
    color: #ffffff;
    background: rgba(255, 255, 255, 0.1);
}

/* ====================================================================
   POPUP BODY
   ==================================================================== */

.whatsapp-popup-body {
    padding: 20px;
    background: #f0f0f0;
    position: relative;
}

.whatsapp-popup-body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 20% 50%, rgba(37, 211, 102, 0.05) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(18, 140, 126, 0.05) 0%, transparent 50%),
        radial-gradient(circle at 40% 80%, rgba(37, 211, 102, 0.03) 0%, transparent 50%);
    pointer-events: none;
}

.whatsapp-message {
    position: relative;
    z-index: 1;
}

.message-bubble {
    background: #ffffff;
    padding: 15px;
    border-radius: 12px 12px 12px 4px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    position: relative;
    margin-bottom: 15px;
}

.message-bubble::before {
    content: '';
    position: absolute;
    bottom: -2px;
    left: -8px;
    width: 0;
    height: 0;
    border-top: 8px solid #ffffff;
    border-left: 8px solid transparent;
}

.whatsapp-popup-message {
    color: #333333;
    font-size: 14px;
    font-weight: 600;
    margin: 0 0 8px 0;
    line-height: 1.4;
}

.whatsapp-popup-submessage {
    color: #666666;
    font-size: 13px;
    margin: 0 0 10px 0;
    line-height: 1.4;
}

.message-time {
    color: #999999;
    font-size: 11px;
    float: right;
    margin-top: 5px;
}

/* ====================================================================
   POPUP FOOTER
   ==================================================================== */

.whatsapp-popup-footer {
    padding: 15px 20px 20px;
    background: #ffffff;
}

.whatsapp-popup-button {
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
    color: #ffffff;
    padding: 12px 20px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    border: none;
    box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
    position: relative;
    overflow: hidden;
    width: 100%;
}

.whatsapp-popup-button i {
    margin-right: 8px;
    font-size: 16px;
}

.whatsapp-popup-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
    color: #ffffff;
    text-decoration: none;
}

.button-shine {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s ease;
}

.whatsapp-popup-button:hover .button-shine {
    left: 100%;
}

/* ====================================================================
   RESPONSIVE DESIGN
   ==================================================================== */

@media (max-width: 768px) {
    .whatsapp-widget-container {
        right: 15px;
    }
    
    .enquire-button {
        bottom: 20px;
        left: 20px;
        padding: 12px 20px;
        min-width: 140px;
    }
    
    .whatsapp-popup {
        width: calc(100vw - 100px);
        max-width: 300px;
        right: 80px;
    }
    
    .whatsapp-float-btn {
        width: 55px;
        height: 55px;
    }
    
    .whatsapp-icon {
        width: 28px;
        height: 28px;
    }
    
    .enquire-text {
        font-size: 13px;
    }
}

@media (max-width: 480px) {
    .whatsapp-widget-container {
        right: 10px;
    }
    
    .enquire-button {
        bottom: 15px;
        left: 15px;
        padding: 10px 18px;
        min-width: 120px;
    }
    
    .whatsapp-popup {
        width: calc(100vw - 80px);
        max-width: 280px;
        right: 70px;
    }
    
    .whatsapp-popup-header {
        padding: 14px 16px;
    }
    
    .whatsapp-popup-body {
        padding: 16px;
    }
    
    .whatsapp-popup-footer {
        padding: 12px 16px 16px;
    }
    
    .whatsapp-float-btn {
        width: 50px;
        height: 50px;
    }
    
    .whatsapp-icon {
        width: 26px;
        height: 26px;
    }
    
    .enquire-text {
        font-size: 12px;
    }
    
    .enquire-button i {
        font-size: 16px;
    }
}

/* ====================================================================
   VERY SMALL SCREENS
   ==================================================================== */

@media (max-width: 360px) {
    .whatsapp-popup {
        right: 60px;
        width: calc(100vw - 70px);
    }
    
    .enquire-button {
        padding: 8px 15px;
        min-width: 100px;
    }
    
    .enquire-text {
        display: none; /* Hide text on very small screens */
    }
    
    .whatsapp-float-btn {
        width: 45px;
        height: 45px;
    }
    
    .whatsapp-icon {
        width: 24px;
        height: 24px;
    }
}

/* ====================================================================
   DARK THEME SUPPORT
   ==================================================================== */

[data-theme="dark"] .whatsapp-popup {
    background: #2a2a2a;
    border-color: rgba(255, 255, 255, 0.1);
}

[data-theme="dark"] .whatsapp-popup::before {
    border-left-color: #2a2a2a;
}

[data-theme="dark"] .whatsapp-popup_body {
    background: #1e1e1e;
}

[data-theme="dark"] .message-bubble {
    background: #333333;
    color: #ffffff;
}

[data-theme="dark"] .whatsapp-popup-message {
    color: #ffffff;
}

[data-theme="dark"] .whatsapp-popup-submessage {
    color: #cccccc;
}

[data-theme="dark"] .whatsapp-popup-footer {
    background: #2a2a2a;
}

/* ====================================================================
   ACCESSIBILITY IMPROVEMENTS
   ==================================================================== */

.whatsapp-float-btn:focus,
.whatsapp-popup-button:focus,
.enquire-button:focus {
    outline: 2px solid #25d366;
    outline-offset: 2px;
}

.whatsapp-popup-close:focus {
    outline: 2px solid rgba(255, 255, 255, 0.5);
    outline-offset: 2px;
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    .whatsapp-pulse,
    .enquire-pulse,
    .online-indicator,
    .button-shine {
        animation: none;
    }
    
    .whatsapp-float-btn,
    .whatsapp-popup,
    .whatsapp-popup-button,
    .enquire-button {
        transition: none;
    }
}
</style>

<script>
// ====================================================================
// WHATSAPP WIDGET FUNCTIONALITY
// ====================================================================

document.addEventListener('DOMContentLoaded', function() {
    const popup = document.getElementById('whatsappPopup');
    const closeBtn = document.getElementById('whatsappClose');
    const sendBtn = document.getElementById('whatsappSendBtn');
    const floatBtn = document.querySelector('.whatsapp-float-btn');
    
    // Configuration
    const config = {
        showDelay: 8000,        // Show popup after 8 seconds
        reshowDelay: 300000,    // Show again after 5 minutes
        storageKey: 'whatsappPopupState'
    };
    
    // Get popup state from localStorage
    function getPopupState() {
        const stored = localStorage.getItem(config.storageKey);
        return stored ? JSON.parse(stored) : {
            hasSeenToday: false,
            lastShown: 0,
            dismissedToday: false
        };
    }
    
    // Save popup state to localStorage
    function savePopupState(state) {
        localStorage.setItem(config.storageKey, JSON.stringify(state));
    }
    
    // Check if it's a new day
    function isNewDay(timestamp) {
        const lastDate = new Date(timestamp);
        const today = new Date();
        return lastDate.toDateString() !== today.toDateString();
    }
    
    // Show popup with animation
    function showPopup() {
        if (!popup) return;
        popup.classList.add('show');
        
        // Track analytics
        if (typeof gtag !== 'undefined') {
            gtag('event', 'whatsapp_popup_shown', {
                event_category: 'engagement',
                event_label: 'whatsapp_widget'
            });
        }
    }
    
    // Hide popup with animation
    function hidePopup() {
        if (!popup) return;
        popup.classList.remove('show');
        
        // Update state
        const state = getPopupState();
        state.dismissedToday = true;
        state.lastShown = Date.now();
        savePopupState(state);
    }
    
    // Handle popup display logic
    function handlePopupDisplay() {
        const state = getPopupState();
        const now = Date.now();
        
        // Reset state if it's a new day
        if (isNewDay(state.lastShown)) {
            state.hasSeenToday = false;
            state.dismissedToday = false;
        }
        
        // Don't show if dismissed today
        if (state.dismissedToday) {
            return;
        }
        
        // Show popup after delay
        setTimeout(() => {
            showPopup();
            state.hasSeenToday = true;
            state.lastShown = now;
            savePopupState(state);
        }, config.showDelay);
    }
    
    // Event Listeners
    if (closeBtn) {
        closeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            hidePopup();
        });
    }
    
    if (sendBtn) {
        sendBtn.addEventListener('click', function() {
            hidePopup();
            
            // Track analytics
            if (typeof gtag !== 'undefined') {
                gtag('event', 'whatsapp_message_clicked', {
                    event_category: 'conversion',
                    event_label: 'whatsapp_widget',
                    value: 1
                });
            }
        });
    }
    
    if (floatBtn) {
        // Click to show popup
        floatBtn.addEventListener('click', function(e) {
            if (!popup.classList.contains('show')) {
                e.preventDefault();
                showPopup();
            }
        });
        
        // Track analytics for float button clicks
        floatBtn.addEventListener('click', function() {
            if (typeof gtag !== 'undefined') {
                gtag('event', 'whatsapp_float_clicked', {
                    event_category: 'conversion',
                    event_label: 'whatsapp_widget',
                    value: 1
                });
            }
        });
    }
    
    // Close popup when clicking outside
    document.addEventListener('click', function(e) {
        if (popup && popup.classList.contains('show')) {
            if (!popup.contains(e.target) && !floatBtn.contains(e.target)) {
                hidePopup();
            }
        }
    });
    
    // ESC key to close popup
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && popup && popup.classList.contains('show')) {
            hidePopup();
        }
    });
    
    // Initialize popup display
    handlePopupDisplay();
});
</script>