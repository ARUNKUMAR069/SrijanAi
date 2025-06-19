
<div id="enquiryPopup" class="popup-overlay">
    <div class="popup-container">
        <div class="popup-header">
            <div class="popup-header-content">
                <div class="popup-title">AI Services</div>
                <h3 class="popup-heading">Get Free Consultation</h3>
                <div class="popup-subtitle">Transform your business with cutting-edge AI solutions</div>
            </div>
            <button class="popup-close" id="closePopup">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="popup-body">
            <!-- Success Message (Hidden by default) -->
            <div class="success-message" id="successMessage" style="display: none;">
                <i class="fas fa-check-circle"></i>
                <div class="success-text">
                    <h4>Thank You!</h4>
                    <p>Your enquiry has been submitted successfully. We'll get back to you within 24 hours.</p>
                </div>
            </div>
            
            <!-- Error Message (Hidden by default) -->
            <div class="error-message" id="errorMessage" style="display: none;">
                <i class="fas fa-exclamation-circle"></i>
                <div class="error-text">
                    <h4>Submission Failed</h4>
                    <p id="errorText">Something went wrong. Please try again.</p>
                </div>
            </div>
            
            <form id="enquiryForm" class="enquiry-form">
                <!-- CSRF Token for security -->
                <input type="hidden" name="csrf_token" value="<?php echo isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : ''; ?>">
                
                <div class="form-row">
                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="fas fa-user"></i>
                            <input type="text" id="fullName" name="fullName" placeholder="Full Name *" required minlength="2" maxlength="100">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="email" name="email" placeholder="Email Address *" required maxlength="255">
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="fas fa-phone"></i>
                            <input type="tel" id="mobile" name="mobile" placeholder="Mobile Number *" required pattern="[0-9+\-\s()]{10,15}" maxlength="20">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="fas fa-cog"></i>
                            <select id="subject" name="subject" required>
                                <option value="">Select AI Service *</option>
                                <option value="AI Chatbot Integration">AI Chatbot Integration</option>
                                <option value="AI Content Generation">AI Content Generation</option>
                                <option value="AI Image/Video Generation">AI Image/Video Generation</option>
                                <option value="AI Automation Solutions">AI Automation Solutions</option>
                                <option value="Custom AI Model Development">Custom AI Model Development</option>
                                <option value="Machine Learning Consulting">Machine Learning Consulting</option>
                                <option value="Data Science Solutions">Data Science Solutions</option>
                                <option value="AI Integration Services">AI Integration Services</option>
                                <option value="Free Consultation">Free Consultation</option>
                                <option value="Other AI Services">Other AI Services</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="form-group full-width">
                    <div class="input-wrapper textarea-wrapper">
                        <i class="fas fa-message"></i>
                        <textarea id="message" name="message" placeholder="Tell us about your project requirements, budget, timeline..." rows="4" maxlength="1000"></textarea>
                    </div>
                </div>
                
                <!-- Privacy Notice -->
                <div class="privacy-notice">
                    <small>
                        <i class="fas fa-shield-alt"></i>
                        Your information is secure and will only be used to provide you with AI consultation services.
                    </small>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="submit-btn" id="submitBtn">
                        <span class="btn-text">Get Free Quote</span>
                        <span class="btn-loader" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i> Submitting...
                        </span>
                        <i class="fa-solid fa-arrow-right fa-fw btn-icon"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
