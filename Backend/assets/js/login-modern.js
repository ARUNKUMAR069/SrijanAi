/**
 * Simple Login JavaScript - Fixed White Layer Issue
 */

class SimpleLoginManager {
    constructor() {
        this.isFormSubmitting = false;
        this.init();
    }

    init() {
        this.setupAlertSystem();
        this.setupFormHandling();
        this.setupInputEffects();
        this.setupKeyboardShortcuts();
        this.setupSecurityFeatures();
        this.setupDemoFeatures();
        this.focusUsername();
        this.fixInputStyling(); // Add this to fix text visibility
    }

    // Fix input styling to ensure text is visible
    fixInputStyling() {
        const inputs = document.querySelectorAll('.modern-input');
        inputs.forEach(input => {
            // Force white background and dark text
            input.style.backgroundColor = '#ffffff';
            input.style.color = '#111827';
            
            // Fix autofill styling
            if (input.matches(':-webkit-autofill')) {
                input.style.webkitBoxShadow = '0 0 0 30px white inset';
                input.style.webkitTextFillColor = '#111827';
            }
        });
    }

    // Simple alert system
    setupAlertSystem() {
        const alerts = document.querySelectorAll('.modern-alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.parentNode.removeChild(alert);
                }
            }, 5000);
        });

        document.querySelectorAll('.alert-close').forEach(button => {
            button.addEventListener('click', (e) => {
                const alert = e.target.closest('.modern-alert');
                if (alert && alert.parentNode) {
                    alert.parentNode.removeChild(alert);
                }
            });
        });
    }

    // Simple form handling
    setupFormHandling() {
        const loginForm = document.querySelector('.login-form');
        const loginBtn = document.querySelector('.login-btn');
        
        if (!loginForm || !loginBtn) return;

        loginForm.addEventListener('submit', (e) => {
            if (this.isFormSubmitting) {
                e.preventDefault();
                return;
            }

            if (!this.validateForm()) {
                e.preventDefault();
                return;
            }

            this.isFormSubmitting = true;
            this.showLoadingState();
        });
    }

    validateForm() {
        const username = document.querySelector('input[name="username"]');
        const password = document.querySelector('input[name="password"]');
        let isValid = true;

        this.clearErrors();

        if (!username.value.trim()) {
            this.showFieldError(username, 'Username is required');
            isValid = false;
        }

        if (!password.value) {
            this.showFieldError(password, 'Password is required');
            isValid = false;
        }

        return isValid;
    }

    showFieldError(input, message) {
        input.style.borderColor = '#ef4444';
        input.style.backgroundColor = 'rgba(239, 68, 68, 0.05)';
        input.style.color = '#111827'; // Ensure text stays dark
        
        const existingError = input.parentElement.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.textContent = message;
        errorDiv.style.color = '#ef4444';
        errorDiv.style.fontSize = '0.75rem';
        errorDiv.style.marginTop = '0.25rem';
        errorDiv.style.fontWeight = '500';
        input.parentElement.appendChild(errorDiv);
    }

    clearErrors() {
        document.querySelectorAll('.field-error').forEach(error => error.remove());
        
        document.querySelectorAll('.modern-input').forEach(input => {
            input.style.borderColor = '';
            input.style.backgroundColor = '#ffffff'; // Keep white background
            input.style.color = '#111827'; // Keep dark text
        });
    }

    showLoadingState() {
        const loginBtn = document.querySelector('.login-btn');
        const btnText = document.querySelector('.btn-text');
        const btnIcon = document.querySelector('.btn-icon');
        const btnLoading = document.querySelector('.btn-loading');

        if (!loginBtn) return;

        loginBtn.disabled = true;
        loginBtn.style.opacity = '0.8';
        
        if (btnText) btnText.style.display = 'none';
        if (btnIcon) btnIcon.style.display = 'none';
        if (btnLoading) btnLoading.style.display = 'flex';
    }

    // Enhanced input effects with proper styling
    setupInputEffects() {
        const inputs = document.querySelectorAll('.modern-input');
        
        inputs.forEach(input => {
            // Force proper styling immediately
            this.applyInputStyling(input);
            
            input.addEventListener('input', () => {
                this.clearFieldError(input);
                this.updateInputState(input);
                this.applyInputStyling(input); // Reapply styling
            });

            input.addEventListener('focus', () => {
                input.parentElement.classList.add('focused');
                this.applyInputStyling(input); // Reapply styling
            });
            
            input.addEventListener('blur', () => {
                input.parentElement.classList.remove('focused');
                this.applyInputStyling(input); // Reapply styling
            });

            this.updateInputState(input);
        });
    }

    applyInputStyling(input) {
        // Force white background and dark text
        input.style.backgroundColor = '#ffffff';
        input.style.color = '#111827';
        
        // Handle autofill state
        if (input.matches(':-webkit-autofill')) {
            input.style.webkitBoxShadow = '0 0 0 30px white inset !important';
            input.style.webkitTextFillColor = '#111827 !important';
        }
    }

    updateInputState(input) {
        if (input.value.trim()) {
            input.classList.add('has-value');
        } else {
            input.classList.remove('has-value');
        }
    }

    clearFieldError(input) {
        input.style.borderColor = '';
        input.style.backgroundColor = '#ffffff'; // Keep white background
        input.style.color = '#111827'; // Keep dark text
        const error = input.parentElement.querySelector('.field-error');
        if (error) error.remove();
    }

    // Keyboard shortcuts
    setupKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            if (e.altKey && e.key.toLowerCase() === 'u') {
                e.preventDefault();
                const username = document.querySelector('input[name="username"]');
                if (username) username.focus();
            }
            
            if (e.altKey && e.key.toLowerCase() === 'p') {
                e.preventDefault();
                const password = document.querySelector('input[name="password"]');
                if (password) password.focus();
            }

            if (e.key === 'Escape') {
                this.clearForm();
            }
        });
    }

    clearForm() {
        const inputs = document.querySelectorAll('.modern-input');
        inputs.forEach(input => {
            input.value = '';
            this.updateInputState(input);
            this.applyInputStyling(input); // Reapply styling after clear
        });
        this.clearErrors();
    }

    focusUsername() {
        const usernameField = document.querySelector('input[name="username"]');
        if (usernameField && !this.isMobileDevice()) {
            setTimeout(() => {
                usernameField.focus();
                this.applyInputStyling(usernameField); // Apply styling after focus
            }, 100);
        }
    }

    // Security features
    setupSecurityFeatures() {
        document.addEventListener('contextmenu', (e) => {
            e.preventDefault();
        });
        
        document.addEventListener('keydown', (e) => {
            if (e.key === 'F12' || 
                (e.ctrlKey && e.shiftKey && e.key === 'I') ||
                (e.ctrlKey && e.key === 'u')) {
                e.preventDefault();
            }
        });
        
        window.addEventListener('beforeunload', () => {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => form.reset());
        });
    }

    // Demo features
    setupDemoFeatures() {
        const logo = document.querySelector('.login-logo');
        if (logo) {
            logo.addEventListener('dblclick', () => {
                this.fillDemoCredentials();
            });
        }

        document.querySelectorAll('.copy-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const text = e.target.closest('.credential-item').querySelector('.value').textContent;
                this.copyToClipboard(text, button);
            });
        });
    }

    fillDemoCredentials() {
        const username = document.querySelector('input[name="username"]');
        const password = document.querySelector('input[name="password"]');
        
        if (username) {
            username.value = 'admin';
            this.updateInputState(username);
            this.applyInputStyling(username);
        }
        
        if (password) {
            password.value = '123456';
            this.updateInputState(password);
            this.applyInputStyling(password);
        }
        
        this.clearErrors();
    }

    copyToClipboard(text, button) {
        const originalContent = button.innerHTML;
        
        navigator.clipboard.writeText(text).then(() => {
            button.innerHTML = '<i class="fas fa-check"></i>';
            button.classList.add('copied');
            
            this.autoFillFromCopy(text);
            
            setTimeout(() => {
                button.innerHTML = originalContent;
                button.classList.remove('copied');
            }, 2000);
            
        }).catch(() => {
            this.fallbackCopy(text, button, originalContent);
        });
    }

    fallbackCopy(text, button, originalContent) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.opacity = '0';
        document.body.appendChild(textArea);
        textArea.select();
        
        try {
            document.execCommand('copy');
            button.innerHTML = '<i class="fas fa-check"></i>';
            button.classList.add('copied');
            this.autoFillFromCopy(text);
        } catch (err) {
            console.error('Copy failed:', err);
        } finally {
            document.body.removeChild(textArea);
            setTimeout(() => {
                button.innerHTML = originalContent;
                button.classList.remove('copied');
            }, 2000);
        }
    }

    autoFillFromCopy(text) {
        if (text === 'admin') {
            const username = document.querySelector('input[name="username"]');
            if (username) {
                username.value = text;
                this.updateInputState(username);
                this.applyInputStyling(username);
            }
        } else if (text === '123456') {
            const password = document.querySelector('input[name="password"]');
            if (password) {
                password.value = text;
                this.updateInputState(password);
                this.applyInputStyling(password);
            }
        }
    }

    isMobileDevice() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }
}

// Global functions for backward compatibility
function togglePassword() {
    const passwordField = document.querySelector('input[name="password"]');
    const toggleIcon = document.getElementById('passwordToggleIcon');
    
    if (!passwordField || !toggleIcon) return;
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
    
    // Ensure text remains visible after toggle
    passwordField.style.backgroundColor = '#ffffff';
    passwordField.style.color = '#111827';
}

function copyToClipboard(text, button) {
    if (window.loginManager) {
        window.loginManager.copyToClipboard(text, button);
    }
}

function fillDemoCredentials() {
    if (window.loginManager) {
        window.loginManager.fillDemoCredentials();
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.loginManager = new SimpleLoginManager();
});

// Add critical CSS for input visibility
const criticalStyles = document.createElement('style');
criticalStyles.textContent = `
    .modern-input,
    .modern-input:focus,
    .modern-input:active,
    .modern-input.has-value {
        background-color: #ffffff !important;
        color: #111827 !important;
    }
    
    .modern-input::placeholder {
        color: #6b7280 !important;
        opacity: 1 !important;
    }
    
    .modern-input:-webkit-autofill,
    .modern-input:-webkit-autofill:hover,
    .modern-input:-webkit-autofill:focus {
        -webkit-box-shadow: 0 0 0 30px white inset !important;
        -webkit-text-fill-color: #111827 !important;
        background-color: white !important;
    }
`;
document.head.appendChild(criticalStyles);