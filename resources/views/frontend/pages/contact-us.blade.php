@include('frontend/header')

 <style>
     /* Minimalist Premium UI - Contact Us Page */
     .cp-contact-form-wrap {
         background: #ffffff !important;
         padding: 50px 40px !important;
         border-radius: 25px !important;
         box-shadow: 0 20px 40px -12px rgba(0,0,0,0.08) !important;
     }

     .cp-contact-title {
         font-size: 32px !important;
         font-weight: 800 !important;
         margin-bottom: 30px !important;
         letter-spacing: -0.5px;
     }

     .cp-input-field {
         margin-bottom: 20px;
         position: relative;
         display: flex;
         flex-direction: column;
     }

     .cp-input-field label {
         font-weight: 700 !important;
         color: #475569 !important;
         margin-bottom: 6px !important;
         font-size: 11px !important;
         display: block;
         text-transform: uppercase;
         letter-spacing: 0.8px;
         padding-left: 2px;
     }

     .cp-input-container {
         position: relative;
         width: 100%;
     }

     .cp-input-field input, 
     .cp-input-field textarea {
         height: 52px !important;
         border-radius: 10px !important;
         border: none !important;
         padding: 0 20px 0 50px !important;
         font-size: 15px !important;
         background: #f1f5f9 !important;
         width: 100%;
         transition: all 0.3s ease;
     }

     .cp-input-field textarea {
         min-height: 150px !important;
         padding: 15px 20px 15px 50px !important;
     }

     .cp-input-field input:focus, 
     .cp-input-field textarea:focus {
         background: #fff !important;
         box-shadow: 0 10px 20px -5px rgba(134, 196, 66, 0.2) !important;
         outline: none;
     }

     .cp-input-field i {
         position: absolute;
         left: 18px;
         top: 50%;
         transform: translateY(-50%);
         color: #86C442 !important;
         font-size: 16px !important;
         pointer-events: none;
         z-index: 5;
     }

     .cp-input-field.textarea i {
         top: 25px !important;
         transform: none;
     }

     .cp-border2-btn {
         height: 58px !important;
         line-height: 58px !important;
         padding: 0 45px !important;
         font-size: 16px !important;
         font-weight: 700 !important;
         border-radius: 12px !important;
         text-transform: uppercase !important;
         letter-spacing: 1.5px !important;
         transition: all 0.3s ease !important;
         border: none !important;
         background: linear-gradient(135deg, #86C442 0%, #6da335 100%) !important;
         color: white !important;
         display: inline-block !important;
         box-shadow: 0 8px 15px rgba(134, 196, 66, 0.2) !important;
         min-width: 250px;
         cursor: pointer;
     }

     .cp-border2-btn:hover {
         transform: translateY(-3px) !important;
         box-shadow: 0 12px 20px rgba(134, 196, 66, 0.3) !important;
     }

     .cp-footer-actions {
         display: flex;
         flex-wrap: wrap;
         gap: 20px;
         align-items: center;
         justify-content: flex-start;
         margin-top: 30px;
     }

     @media (max-width: 991px) {
         .cp-footer-actions {
             flex-direction: column;
             align-items: center;
             text-align: center;
         }
         .captcha-container {
             display: flex;
             justify-content: center;
             width: 100%;
         }
     }
 </style>

<section class="page-title-area breadcrumb-spacing cp-bg-14">
</section>

<section class="cp-contact-area pt-20 pb-20">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="cp-contact-content">
                    <h1 class="cp-contact-title mb-20">Let's Talk to us.</h1>
                    
                    <div class="cp-contact-info mb-50">
                        <ul>
                            <li>
                                <i class="far fa-phone-alt"></i>
                                <a href="tel:1-302-703-0304">1-302-703-0304</a>
                            </li>
                            <li>
                                <i class="far fa-phone-alt"></i>
                                <a href="tel:847-200-0974">847-200-0974</a>
                            </li>
                            <li><i class="fal fa-envelope"></i><a href="mailto:support@myboxprinting.com">support@myboxprinting.com</a></li>
                            <li>
                                <i class="far fa-fax"></i>
                                <a href="tel:1-302-703-0305">1-302-703-0305</a>
                            </li>
                            <li><i class="fal fa-home-lg-alt"></i><a target="_blank" href="https://www.google.com/maps/@23.7739014,90.3640911,17z"> 9933 Franklin Ave, Suite # 112 Franklin Park, IL 60131, United States</a></li>
                        </ul>
                    </div>
                    <h4 class="cp-contact-subtitle">Administrative Hours</h4>
                    <p class="cp-contact-text mb-0">Mon - Friday / 9:00AM - 5:00PM PST</p>
                </div>
            </div>
            <div class="col-lg-6">
                @if (Session::has('message'))
                <div class="alert alert-success session-destroy my-sm-0 py-sm-3 text-center">
                    <?php echo Session::get('message'); ?>
                </div>
                @endif
                
                <div class="cp-contact-form-wrap mb-70 wow fadeInUp animated" data-wow-duration="1.5s" style="visibility: visible; animation-duration: 1.5s; animation-name: fadeInUp;">
                    <h3 class="cp-contact-title mb-25">Send us a message</h3>
                    <div class="cp-contact-form">
                         <form method="post" class="bg-transparent" id="msform" action="{{url('email_contact_us_c').'/'}}">
                            @csrf 
                            <div class="cp-input-field">
                                <label for="contact_name">Name *</label>
                                <div class="cp-input-container">
                                    <input type="text" id="contact_name" name="contact_name" required="">
                                    <i class="far fa-user"></i>
                                </div>
                            </div>
                            <div class="cp-input-field">
                                <label for="contact_email">E-Mail *</label>
                                <div class="cp-input-container">
                                    <input type="email" id="contact_email" name="contact_email" required="" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title="Must contain @ and . (e.g. user@example.com)">
                                    <i class="far fa-envelope-open"></i>
                                </div>
                            </div>
                            <div class="cp-input-field">
                                <label for="contact_phone">Contact Number *</label>
                                <div class="cp-input-container">
                                    <input type="tel" id="contact_phone" name="contact_phone" required="" maxlength="15" pattern="[0-9+]+" oninput="this.value = this.value.replace(/[^0-9+]/g, '')" title="Please enter numbers only">
                                    <i class="far fa-phone"></i>
                                </div>
                            </div>
                            <div class="cp-input-field">
                                <label for="contact_subject">Subject</label>
                                <div class="cp-input-container">
                                    <input type="text" id="contact_subject" name="contact_subject">
                                    <i class="far fa-envelope-open"></i>
                                </div>
                            </div>
                            <div class="cp-input-field textarea">
                                <label for="contact_message">Type Your Message</label>
                                <div class="cp-input-container">
                                    <textarea id="contact_message" name="contact_message" placeholder="How can we help you?"></textarea>
                                    <i class="far fa-edit"></i>
                                </div>
                            </div>
                            
                            <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>
                            
                            <div class="cp-footer-actions">
                                <div class="captcha-container">
                                    <div class="g-recaptcha" id="contact-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}" data-callback="onCaptchaSuccess"></div>
                                </div>
                                <button type="submit" id="submit-btn" class="cp-border2-btn">
                                    Send Message
                                </button>
                            </div>

                            <div id="captcha-error" style="color: #fff; font-size: 14px; font-weight: bold; margin-top: 15px; display: none; padding: 12px; background: #dc3545; border-radius: 5px; width: 100%;">
                                ⚠️ Please complete the reCAPTCHA verification before submitting
                            </div>
                        </form>
                    </div>
                </div>
                
                <script>
                var captchaCompleted = false;
                
                // Callback when captcha is successfully completed
                function onCaptchaSuccess(token) {
                    captchaCompleted = true;
                    var errorDiv = document.getElementById('captcha-error');
                    if (errorDiv) {
                        errorDiv.style.display = 'none';
                    }
                }
                
                (function() {
                    function initFormValidation() {
                        var form = document.getElementById('msform');
                        var errorDiv = document.getElementById('captcha-error');
                        
                        if (!form) return;
                        
                        form.onsubmit = function(event) {
                            // Check if captcha is completed using our flag
                            if (!captchaCompleted) {
                                event.preventDefault();
                                event.stopPropagation();
                                event.stopImmediatePropagation();
                                
                                // Show error message
                                if (errorDiv) {
                                    errorDiv.style.display = 'block';
                                    errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                }
                                
                                return false;
                            }
                            
                            // Double check with grecaptcha if available
                            if (typeof grecaptcha !== 'undefined' && typeof grecaptcha.getResponse === 'function') {
                                var response = grecaptcha.getResponse();
                                if (!response || response.length === 0) {
                                    event.preventDefault();
                                    event.stopPropagation();
                                    event.stopImmediatePropagation();
                                    
                                    if (errorDiv) {
                                        errorDiv.style.display = 'block';
                                        errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                    }
                                    
                                    captchaCompleted = false;
                                    return false;
                                }
                            }
                            
                            // Hide error if captcha is completed
                            if (errorDiv) {
                                errorDiv.style.display = 'none';
                            }
                            
                            return true;
                        };
                    }
                    
                    // Wait for DOM to be ready
                    if (document.readyState === 'loading') {
                        document.addEventListener('DOMContentLoaded', initFormValidation);
                    } else {
                        initFormValidation();
                    }
                })();
                </script>
            </div>
        </div>
    </div>
</section>

@include('frontend/footer')
