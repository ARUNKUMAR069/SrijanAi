<!-- Enquiry Popup -->
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
            <form id="enquiryForm" class="enquiry-form">
                <div class="form-row">
                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="fas fa-user"></i>
                            <input type="text" id="fullName" name="fullName" placeholder="Full Name" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="email" name="email" placeholder="Email Address" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="fas fa-phone"></i>
                            <input type="tel" id="mobile" name="mobile" placeholder="Mobile Number" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="fas fa-cog"></i>
                            <select id="subject" name="subject" required>
                                <option value="">Select AI Service</option>
                                <option value="ai-chatbot">AI Chatbot Integration</option>
                                <option value="content-generation">AI Content Generation</option>
                                <option value="image-video-ai">AI Image/Video Generation</option>
                                <option value="automation">AI Automation Solutions</option>
                                <option value="custom-model">Custom AI Model Development</option>
                                <option value="consultation">Free Consultation</option>
                                <option value="other">Other Services</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="form-group full-width">
                    <div class="input-wrapper textarea-wrapper">
                        <i class="fas fa-message"></i>
                        <textarea id="message" name="message" placeholder="Tell us about your project requirements..." rows="4"></textarea>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="submit-btn">
                        <span>Get Free Quote</span>
                        <i class="fa-solid fa-arrow-right fa-fw"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>