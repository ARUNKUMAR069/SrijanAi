class EnquiryPopup {
    constructor() {
        this.popup = document.getElementById('enquiryPopup');
        this.form = document.getElementById('enquiryForm');
        this.closeBtn = document.getElementById('closePopup');
        this.enquireBtn = document.getElementById('enquireButton');
        this.submitBtn = document.getElementById('submitBtn');
        this.successMessage = document.getElementById('successMessage');
        this.errorMessage = document.getElementById('errorMessage');
        
        // API endpoint for form submission
        this.apiEndpoint = 'backend/enquiry-submit.php';
        
        // State management
        this.isVisible = false;
        this.autoShowTimer = null;
        
        this.init();
    }
    
    init() {
        // Auto-show popup after 3 seconds if not shown before
        this.autoShowTimer = setTimeout(() => {
            if (!sessionStorage.getItem('popupShown') && !this.isVisible) {
                this.showPopup();
            }
        }, 3000);
        
        // Event listeners
        this.setupEventListeners();
        
        // Real-time validation
        this.setupValidation();
        
        // Add animation classes
        this.addAnimationClasses();
        
        // Ensure popup is initially hidden and removed from layout
        this.hidePopupCompletely();
    }
    
    setupEventListeners() {
        // Close button
        if (this.closeBtn) {
            this.closeBtn.addEventListener('click', () => this.hidePopup());
        }
        
        // Overlay click to close
        if (this.popup) {
            this.popup.addEventListener('click', (e) => {
                if (e.target === this.popup) {
                    this.hidePopup();
                }
            });
        }
        
        // Enquire button
        if (this.enquireBtn) {
            this.enquireBtn.addEventListener('click', () => {
                this.showPopupFromButton();
            });
        }
        
        // Form submission
        if (this.form) {
            this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        }
        
        // ESC key to close
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isVisible) {
                this.hidePopup();
            }
        });
        
        // Prevent accidental closure on popup container click
        const container = this.popup?.querySelector('.popup-container');
        if (container) {
            container.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        }
        
        // Handle window resize
        window.addEventListener('resize', () => {
            if (this.isVisible) {
                this.centerPopup();
            }
        });
        
        // Handle orientation change
        window.addEventListener('orientationchange', () => {
            if (this.isVisible) {
                setTimeout(() => {
                    this.centerPopup();
                }, 100);
            }
        });
    }
    
    addAnimationClasses() {
        const container = this.popup?.querySelector('.popup-container');
        if (container) {
            container.classList.add('wow', 'fadeInUp');
        }
    }
    
    centerPopup() {
        if (this.popup && this.isVisible) {
            // Force re-center by briefly removing and re-adding centering
            this.popup.style.display = 'flex';
            this.popup.style.alignItems = 'center';
            this.popup.style.justifyContent = 'center';
        }
    }
    
    showPopup() {
        if (this.isVisible) return;
        
        // Clear auto-show timer
        if (this.autoShowTimer) {
            clearTimeout(this.autoShowTimer);
            this.autoShowTimer = null;
        }
        
        // Prevent body scroll
        document.body.classList.add('popup-open');
        document.body.style.overflow = 'hidden';
        
        // Show popup with proper centering
        this.popup.style.display = 'flex';
        this.popup.style.alignItems = 'center';
        this.popup.style.justifyContent = 'center';
        this.popup.style.position = 'fixed';
        this.popup.style.top = '0';
        this.popup.style.left = '0';
        this.popup.style.width = '100%';
        this.popup.style.height = '100%';
        this.popup.style.zIndex = '999999';
        
        // Force reflow
        this.popup.offsetHeight;
        
        // Add active class for animation
        requestAnimationFrame(() => {
            this.popup.classList.add('active');
            this.isVisible = true;
        });
        
        // Mark as shown in session
        if (!sessionStorage.getItem('popupShown')) {
            sessionStorage.setItem('popupShown', 'true');
        }
        
        // Hide any existing messages
        this.hideMessages();
        
        // Focus first input for accessibility
        setTimeout(() => {
            const firstInput = this.form?.querySelector('input[type="text"]');
            if (firstInput) {
                firstInput.focus();
            }
        }, 500);
    }
    
    showPopupFromButton() {
        // Add click animation to button
        if (this.enquireBtn) {
            this.enquireBtn.classList.add('clicked');
            setTimeout(() => {
                this.enquireBtn.classList.remove('clicked');
            }, 300);
        }
        
        this.showPopup();
    }
    
    hidePopup() {
        if (!this.isVisible) return;
        
        // Start hiding animation
        this.popup.classList.remove('active');
        this.isVisible = false;
        
        // Restore body scroll
        document.body.classList.remove('popup-open');
        document.body.style.overflow = '';
        
        // After animation completes, completely remove from DOM flow
        setTimeout(() => {
            this.hidePopupCompletely();
        }, 400);
        
        // Hide messages when closing
        this.hideMessages();
    }
    
    hidePopupCompletely() {
        if (this.popup) {
            this.popup.style.display = 'none';
            this.popup.style.pointerEvents = 'none';
            this.popup.style.zIndex = '-1';
            this.popup.style.opacity = '0';
            this.popup.style.visibility = 'hidden';
        }
    }
    
    removeFromDOM() {
        // Completely remove popup from DOM
        if (this.popup && this.popup.parentNode) {
            this.popup.parentNode.removeChild(this.popup);
        }
    }
    
    hideMessages() {
        if (this.successMessage) {
            this.successMessage.style.display = 'none';
            this.successMessage.classList.remove('show');
        }
        if (this.errorMessage) {
            this.errorMessage.style.display = 'none';
            this.errorMessage.classList.remove('show');
        }
    }
    
    showSuccessMessage(message = null) {
        this.hideMessages();
        
        if (this.successMessage) {
            if (message) {
                const textElement = this.successMessage.querySelector('p');
                if (textElement) {
                    textElement.textContent = message;
                }
            }
            this.successMessage.style.display = 'block';
            this.successMessage.classList.add('show');
            
            // Scroll to top of popup
            this.popup.querySelector('.popup-body').scrollTop = 0;
            
            // Auto-close and remove from DOM after success
            setTimeout(() => {
                this.hidePopup();
                setTimeout(() => {
                    this.removeFromDOM();
                }, 500);
            }, 3000);
        }
    }
    
    showErrorMessage(message = 'Something went wrong. Please try again.') {
        this.hideMessages();
        
        if (this.errorMessage) {
            const errorText = document.getElementById('errorText');
            if (errorText) {
                errorText.textContent = message;
            }
            this.errorMessage.style.display = 'block';
            this.errorMessage.classList.add('show');
            
            // Scroll to top of popup
            this.popup.querySelector('.popup-body').scrollTop = 0;
        }
    }
    
    setupValidation() {
        const inputs = this.form.querySelectorAll('input, select, textarea');
        
        inputs.forEach(input => {
            input.addEventListener('blur', () => this.validateField(input));
            input.addEventListener('input', () => this.clearError(input));
            
            // Add focus animation
            input.addEventListener('focus', () => {
                const icon = input.parentNode.querySelector('i');
                if (icon) {
                    icon.style.transform = 'scale(1.1)';
                    icon.style.color = 'var(--color-two)';
                }
            });
            
            input.addEventListener('blur', () => {
                const icon = input.parentNode.querySelector('i');
                if (icon) {
                    icon.style.transform = 'scale(1)';
                    icon.style.color = 'var(--main-color)';
                }
            });
        });
    }
    
    validateField(field) {
        const formGroup = field.closest('.form-group');
        let isValid = true;
        let errorMessage = '';
        
        // Remove existing error
        this.clearError(field);
        
        // Required field validation
        if (field.required && !field.value.trim()) {
            isValid = false;
            errorMessage = 'This field is required';
        }
        
        // Specific validations
        switch (field.type) {
            case 'email':
                if (field.value && !this.isValidEmail(field.value)) {
                    isValid = false;
                    errorMessage = 'Please enter a valid email address';
                }
                break;
                
            case 'tel':
                if (field.value && !this.isValidPhone(field.value)) {
                    isValid = false;
                    errorMessage = 'Please enter a valid phone number (10-15 digits)';
                }
                break;
        }
        
        // Name validation
        if (field.name === 'fullName' && field.value.trim().length < 2) {
            isValid = false;
            errorMessage = 'Name must be at least 2 characters long';
        }
        
        if (!isValid) {
            this.showError(formGroup, errorMessage);
        }
        
        return isValid;
    }
    
    clearError(field) {
        const formGroup = field.closest('.form-group');
        formGroup.classList.remove('error');
        const errorMsg = formGroup.querySelector('.error-message');
        if (errorMsg) {
            errorMsg.remove();
        }
    }
    
    showError(formGroup, message) {
        formGroup.classList.add('error');
        
        // Remove existing error message
        const existingError = formGroup.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
        
        // Add new error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = message;
        errorDiv.style.cssText = `
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        `;
        formGroup.appendChild(errorDiv);
    }
    
    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email.trim());
    }
    
    isValidPhone(phone) {
        const phoneRegex = /^[0-9+\-\s()]{10,15}$/;
        return phoneRegex.test(phone.replace(/\s/g, ''));
    }
    
    async handleSubmit(e) {
        e.preventDefault();
        
        // Hide any existing messages
        this.hideMessages();
        
        // Validate all fields
        const inputs = this.form.querySelectorAll('input[required], select[required], textarea[required]');
        let isFormValid = true;
        
        inputs.forEach(input => {
            if (!this.validateField(input)) {
                isFormValid = false;
            }
        });
        
        if (!isFormValid) {
            this.showErrorMessage('Please fix the errors above and try again.');
            return;
        }
        
        // Show loading state
        this.setLoadingState(true);
        
        // Collect form data
        const formData = new FormData(this.form);
        
        // Add additional data
        formData.append('source', 'website_popup');
        formData.append('user_agent', navigator.userAgent);
        formData.append('referrer', document.referrer);
        
        try {
            // Submit to backend
            const response = await this.submitEnquiry(formData);
            
            if (response.success) {
                // Show success message and auto-close
                this.showSuccessMessage(response.message);
                
                // Reset form
                this.form.reset();
                
            } else {
                // Show error message
                this.showErrorMessage(response.message || 'Failed to submit enquiry. Please try again.');
            }
            
        } catch (error) {
            console.error('Form submission error:', error);
            this.showErrorMessage('Network error. Please check your connection and try again.');
        } finally {
            // Remove loading state
            this.setLoadingState(false);
        }
    }
    
    setLoadingState(loading) {
        if (loading) {
            this.submitBtn.classList.add('loading');
            this.submitBtn.disabled = true;
        } else {
            this.submitBtn.classList.remove('loading');
            this.submitBtn.disabled = false;
        }
    }
    
    async submitEnquiry(formData) {
        const response = await fetch(this.apiEndpoint, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return await response.json();
        } else {
            // If response is not JSON, treat as error
            const text = await response.text();
            throw new Error('Invalid response format: ' + text);
        }
    }
}

// Initialize popup when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new EnquiryPopup();
});

// Utility functions for external use
window.showEnquiryPopup = function() {
    const popup = document.getElementById('enquiryPopup');
    if (popup) {
        popup.style.display = 'flex';
        popup.style.alignItems = 'center';
        popup.style.justifyContent = 'center';
        popup.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
};

window.hideEnquireButton = function() {
    const button = document.getElementById('enquireButton');
    if (button) {
        button.style.display = 'none';
    }
};

window.showEnquireButton = function() {
    const button = document.getElementById('enquireButton');
    if (button) {
        button.style.display = 'block';
    }
};

// Remove popup from DOM completely
window.removeEnquiryPopup = function() {
    const popup = document.getElementById('enquiryPopup');
    if (popup && popup.parentNode) {
        popup.parentNode.removeChild(popup);
    }
};