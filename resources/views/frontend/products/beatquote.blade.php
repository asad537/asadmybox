@include('frontend/header')
 
 <style>
     /* Minimalist Premium UI - Fixed Alignment and Height */
     .nice-select { display: none !important; }
     
     .selectize-control.single .selectize-input, 
     .selectize-control.single .selectize-input input {
         height: 52px !important;
         border-radius: 10px !important;
         border: none !important;
         padding: 0 20px !important;
         font-size: 15px !important;
         box-shadow: none !important;
         background: #f1f5f9 !important;
         transition: all 0.3s ease !important;
         line-height: 52px !important;
         display: flex !important;
         align-items: center !important;
     }

     .selectize-control.single .selectize-input.focus,
     .selectize-control.single .selectize-input.dropdown-active {
         background: #f1f5f9 !important; /* Keep same background to prevent "box" effect */
         box-shadow: none !important;
         border: none !important;
         outline: none !important;
     }

     .selectize-control.single .selectize-input::after {
         border: none !important; /* Hide default arrow to use our cleaner one if needed */
     }

     .selectize-dropdown {
         border-radius: 10px !important;
         box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
         border: none !important;
         margin-top: 1px !important;
         z-index: 1000 !important;
         background: #fff !important;
     }

     .cp-quote-wrapper {
         background: #ffffff !important;
         padding: 50px 40px !important;
         border-radius: 25px !important;
         box-shadow: 0 20px 40px -12px rgba(0,0,0,0.08) !important;
         margin-top: -120px;
         position: relative;
         z-index: 10;
     }

     .cp-quote-title {
         font-size: 38px !important;
         font-weight: 800 !important;
         margin-bottom: 10px !important;
         letter-spacing: -1px;
     }

     .cp-quote-box h1 { text-align: center; }
     .cp-quote-box p { 
         text-align: center; 
         margin-bottom: 40px !important; 
         color: #64748b;
         font-size: 17px;
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
         font-size: 12px !important;
         display: block;
         text-transform: uppercase;
         letter-spacing: 0.5px;
         padding-left: 2px;
     }

     .cp-input-container {
         position: relative;
         width: 100%;
     }

     .cp-input-field input {
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
         border-radius: 10px !important;
         border: none !important;
         padding: 15px 20px 15px 50px !important;
         font-size: 15px !important;
         background: #f1f5f9 !important;
         width: 100%;
         min-height: 120px;
         transition: all 0.3s ease;
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

     .cp-in {
         position: absolute;
         right: 18px;
         top: 50%;
         transform: translateY(-50%);
         color: #64748b !important;
         font-weight: 700 !important;
         font-size: 12px !important;
         z-index: 5;
     }

     .cp-border2-btn {
         height: 58px !important;
         line-height: 58px !important;
         padding: 0 40px !important;
         font-size: 16px !important;
         font-weight: 700 !important;
         border-radius: 12px !important;
         text-transform: uppercase !important;
         letter-spacing: 1.5px !important;
         transition: all 0.3s ease !important;
         border: none !important;
         background: linear-gradient(135deg, #86C442 0%, #6da335 100%) !important;
         color: white !important;
         width: auto !important; /* Changed from 100% */
         min-width: 250px;
         margin: 0 !important; /* Removed auto margin */
         display: inline-block !important; /* Changed from block */
         box-shadow: 0 8px 15px rgba(134, 196, 66, 0.2) !important;
     }

     .cp-border2-btn:hover {
         transform: translateY(-3px) !important;
         box-shadow: 0 12px 20px rgba(134, 196, 66, 0.3) !important;
     }

     .cp-file {
         border: 2px solid #e2e8f0 !important; /* Switch to solid for cleaner look */
         border-radius: 10px !important;
         background: #f8fafc !important;
         height: 52px !important;
         display: flex !important;
         align-items: center !important;
         transition: all 0.3s ease !important;
         overflow: hidden !important;
         position: relative !important;
         cursor: pointer !important;
         box-shadow: none !important;
     }

     .cp-file:hover {
         border-color: #86C442 !important;
         background: #ffffff !important;
     }

     /* Force hide the default browser button */
     .cp-file input[type="file"] {
         position: absolute !important;
         top: 0 !important;
         left: 0 !important;
         width: 100% !important;
         height: 100% !important;
         opacity: 0 !important;
         cursor: pointer !important;
         z-index: 20 !important;
         padding: 0 !important;
         margin: 0 !important;
         font-size: 100px !important; /* Makes the clickable area large */
     }

     .file-placeholder {
         flex-grow: 1 !important;
         padding-left: 45px !important;
         color: #64748b !important;
         font-size: 14px !important;
         white-space: nowrap !important;
         overflow: hidden !important;
         text-overflow: ellipsis !important;
         font-weight: 500 !important;
         line-height: 52px !important;
         z-index: 5 !important;
     }

     .cp-file i.fa-upload-icon {
         position: absolute !important;
         left: 18px !important;
         top: 50% !important;
         transform: translateY(-50%) !important;
         color: #86C442 !important;
         font-size: 16px !important;
         z-index: 6 !important;
     }

     .file-btn {
         background: #86C442 !important;
         color: white !important;
         height: 100% !important;
         padding: 0 20px !important;
         display: flex !important;
         align-items: center !important;
         font-weight: 700 !important;
         font-size: 11px !important;
         text-transform: uppercase !important;
         letter-spacing: 1px !important;
         transition: background 0.3s ease !important;
         z-index: 5 !important;
         border: none !important;
     }

     .cp-file:hover .file-btn {
         background: #75b032 !important;
     }

     .page-title-area {
         padding: 100px 0 160px !important;
         background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?q=80&w=2070&auto=format&fit=crop') center/cover !important;
     }

     #beat-quote-recaptcha { 
         margin-bottom: 0px !important;
     }
     
     .cp-quote-btn { 
         margin-top: 50px; 
         width: 100%;
     }
     
     .cp-footer-actions {
         display: grid;
         grid-template-columns: 1fr auto 1fr; /* 3-column grid for precise centering */
         align-items: center;
         width: 100%;
         gap: 20px;
     }
     
     .captcha-container {
         grid-column: 1;
         display: flex;
         justify-content: flex-start;
     }
     
     .cp-border2-btn {
         grid-column: 2; /* Center column */
         height: 58px !important;
         line-height: 58px !important;
         padding: 0 40px !important;
         font-size: 16px !important;
         font-weight: 700 !important;
         border-radius: 12px !important;
         text-transform: uppercase !important;
         letter-spacing: 1.5px !important;
         transition: all 0.3s ease !important;
         border: none !important;
         background: linear-gradient(135deg, #86C442 0%, #6da335 100%) !important;
         color: white !important;
         width: auto !important;
         min-width: 250px;
         margin: 0 !important;
         display: inline-block !important;
         box-shadow: 0 8px 15px rgba(134, 196, 66, 0.2) !important;
     }
     
     .empty-spacer {
         grid-column: 3;
     }

     @media (max-width: 991px) {
         .cp-footer-actions {
             display: flex;
             flex-direction: column;
             gap: 25px;
         }
         .captcha-container {
             justify-content: center;
         }
         .empty-spacer { display: none; }
     }

     @media (max-width: 768px) {
         .cp-quote-wrapper { padding: 30px 15px !important; margin-top: -50px; }
         .cp-quote-title { font-size: 28px !important; }
     }
 </style>
    
       <section class="page-title-area breadcrumb-spacing cp-bg-14">
       
        
        </section>
    
<section class="cp-contact-area pt-50 pb-80">
            <div class="container">
                <div class="row">

  <div class="col-lg-12">
                             @if (Session::has('message'))
            <div class="alert alert-success session-destroy my-sm-0 py-sm-3 text-center">
                    <?php echo Session::get('message'); ?>
            </div>
        @endif
                    <div class="cp-quote-wrapper">
                    
                     <div class="cp-quote-form">
                        <form action="{{url('beat-my-prices').'/'}}" method="post" id="beat-quote-form" enctype="multipart/form-data">
                     
                            @csrf
                           <div class="cp-quote-box mb-10">
                              <h1 class="cp-quote-title"><span style="color:#86C442;">We’ll Beat Your Price Quote</span></h1>
                              <p>Without compromising on quality!</p>

                               @if(Session::has('message'))
                               <div class="alert alert-success session-destroy my-sm-0 py-sm-3 text-center" style="margin-bottom: 20px;">
                                   <?php echo Session::get('message'); ?>
                               </div>
                               @endif
                              <div class="row">
                                 <div class="col-lg-4">
                                    <div class="cp-input-field">
                                       <label for="name">Name *</label>
                                       <div class="cp-input-container">
                                          <input type="text" id="name" name="name" required>
                                          <i class="far fa-user"></i>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-lg-4">
                                    <div class="cp-input-field">
                                       <label for="email">E-Mail *</label>
                                       <div class="cp-input-container">
                                          <input type="email" id="email" name="email" required>
                                          <i class="far fa-envelope-open"></i>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-lg-4">
                                    <div class="cp-input-field">
                                       <label for="phone">Phone Number *</label>
                                       <div class="cp-input-container">
                                          <input type="text" id="phone" name="phone" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                          <i class="far fa-phone"></i>
                                       </div>
                                    </div>
                                 </div>
                              
                           
                                 
                                   <div class="col-xl-3 col-lg-6">
                                    <div class="cp-input-field">
                                       <label for="width">Width *</label>
                                       <div class="cp-input-container">
                                          <input type="text" id="width" name="width" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                          <span class="cp-in">in</span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-xl-3 col-lg-6">
                                    <div class="cp-input-field">
                                       <label for="height">Height *</label>
                                       <div class="cp-input-container">
                                          <input type="text" id="height" name="height" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                          <span class="cp-in">in</span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-xl-3 col-lg-6">
                                    <div class="cp-input-field">
                                       <label for="length">Length *</label>
                                       <div class="cp-input-container">
                                          <input type="text" id="length" name="length" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                          <span class="cp-in">in</span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-xl-3 col-lg-6">
                                    <div class="cp-input-field">
                                       <label for="unit">Unit</label>
                                       <select id="unit" name="unit" class="form-control">
                                          <option>mm</option>
                                          <option>cm</option>
                                          <option>m</option>
                                       </select>
                                    </div>
                                 </div>
                                <?php $pp=DB::table('products')->get();?>
                    
          <div class="col-xl-4 col-lg-6">
                                      <div class="cp-input-field">
                                       <label for="unit">Your Box Style</label>
                  <select id="select-state" class="form-control custom-dropdown" name="prodname" >
 
 @foreach($pp as $p)
        <option value="{{$p->prod_name}}">{{$p->prod_name}}</option>
    @endforeach
  </select>
  </div>
    </div>
  
 


                                 <div class="col-xl-4 col-lg-6">
                                    <div class="cp-input-field">
                                       <label for="unit">Paper Stock</label>
                                     <select class="form-control" name="stock" data-gtm-form-interact-field-id="3">
  <option value="12pt Cardboard Stock">12pt Cardboard Stock</option>
  <option value="14pt Cardboard Stock">14pt Cardboard Stock</option>
  <option value="16pt Cardboard Stock">16pt Cardboard Stock</option>
  <option value="18pt Cardboard Stock">18pt Cardboard Stock</option>
  <option value="20pt Cardboard Stock">20pt Cardboard Stock</option>
  <option value="22pt Cardboard Stock">22pt Cardboard Stock</option>
  <option value="24pt Cardboard Stock">24pt Cardboard Stock</option>
  <option value="Kraft Stock">Kraft Stock</option>
  <option value="Recycled BuxBoard">Recycled BuxBoard</option>
  <option value="Corrugated Stock">Corrugated Stock</option>
  <option value="No Printing Required">No Printing Required</option>
</select>
 
                                    </div>
                                 </div>
                                 
                                 <div class="col-xl-4 col-lg-6">
                                    <div class="cp-input-field">
                                       <label for="unit">Color</label>
                                    <select class="form-control" name="color">
  <option value="1 colour">1 Colour</option>
  <option value="2 colour">2 Colour</option>
  <option value="3 colour">3 Colour</option>
  <option value="4 colour">4 Colour</option>
  <option value="4/1 colour">4/1 Colour</option>
  <option value="4/2 colour">4/2 Colour</option>
  <option value="4/3 colour">4/3 Colour</option>
  <option value="4/4 colour">4/4 Colour</option>
</select>
 
                                    </div>
                                 </div>
                                 
                                        <div class="col-xl-4 col-lg-6">
                                    <div class="cp-input-field">
                                       <label for="unit">Paper Coating *</label>
<select class="form-control" name="coating" data-gtm-form-interact-field-id="0">
  <option value="Aqueous Coating">Aqueous Coating</option>
  <option value=" Semi Gloss"> Semi Gloss</option>
  <option value="Gloss UV">Gloss UV</option>
  <option value="Matte UV">Matte UV</option>
  <option value="Semi Matte">Semi Matte</option>
</select>
 
                                    </div>
                                 </div>
                                 
                                 <div class="col-xl-4 col-lg-6">
                                    <div class="cp-input-field">
                                       <label for="unit">CAD Sample *</label>
<select class="form-control" name="cad_sample" data-gtm-form-interact-field-id="2">
  <option value="Yes">Yes</option>
  <option value="No">No</option>
</select>
 
                                    </div>
                                 </div>
                                         
 
                                           
                                 <div class="col-xl-4 col-lg-6">
                                     <div class="cp-input-field">
                                        <label for="qty">Quantity *</label>
                                        <div class="cp-input-container">
                                           <input type="text" id="qty" name="qty" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                           <span class="cp-in">Min 100</span>
                                        </div>
                                     </div>
                                  </div>
                                 <div class="col-xl-4">
                                     <div class="cp-input-field">
                                        <label for="fileupload">Upload File Here</label>
                                        <div class="cp-input-container">
                                           <div class="cp-file">
                                              <input type="file" id="fileupload" name="file" onchange="updateFileName(this)">
                                              <i class="fas fa-file-upload fa-upload-icon"></i>
                                              <div class="file-placeholder" id="file-name-display">Attach quote or design...</div>
                                              <div class="file-btn">Upload</div>
                                           </div>
                                        </div>
                                     </div>
                                  </div>
                                    <div class="col-xl-12">
                                    <div class="cp-input-field message-field">
                                       <label for="message">Your Message</label>
                                       <div class="cp-input-container">
                                          <textarea id="message" name="message" placeholder="Tell us more about your requirements..."></textarea>
                                          <i class="far fa-edit" style="top: 25px !important;"></i>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                            <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>
                             <div class="cp-quote-btn mb-10">
                                 <div class="cp-footer-actions">
                                     <div class="captcha-container">
                                         <div class="g-recaptcha" id="beat-quote-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}" data-callback="onBeatQuoteCaptchaSuccess"></div>
                                     </div>
                                     <button type="submit" class="cp-border2-btn">Beat my Price</button>
                                     <div class="empty-spacer"></div>
                                 </div>
                                 <div id="beat-quote-captcha-error" style="color: #fff; font-size: 14px; font-weight: bold; margin-top: 15px; display: none; padding: 12px; background: #dc3545; border-radius: 5px; width: 100%; max-width: 600px; margin-left: auto; margin-right: auto;">
                                     ⚠️ Please complete the reCAPTCHA verification before submitting
                                 </div>
                             </div>
                        </form>
                        <script>
                        var beatQuoteCaptchaCompleted = false;
                        
                        function onBeatQuoteCaptchaSuccess(token) {
                            beatQuoteCaptchaCompleted = true;
                            var errorDiv = document.getElementById('beat-quote-captcha-error');
                            if (errorDiv) {
                                errorDiv.style.display = 'none';
                            }
                        }
                        
                        (function() {
                            function initBeatQuoteFormValidation() {
                                var form = document.getElementById('beat-quote-form');
                                var errorDiv = document.getElementById('beat-quote-captcha-error');
                                
                                if (!form) return;
                                
                                form.onsubmit = function(event) {
                                    if (!beatQuoteCaptchaCompleted) {
                                        event.preventDefault();
                                        event.stopPropagation();
                                        event.stopImmediatePropagation();
                                        
                                        if (errorDiv) {
                                            errorDiv.style.display = 'block';
                                            errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                        }
                                        
                                        return false;
                                    }
                                    
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
                                            
                                            beatQuoteCaptchaCompleted = false;
                                            return false;
                                        }
                                    }
                                    
                                    if (errorDiv) {
                                        errorDiv.style.display = 'none';
                                    }
                                    
                                    return true;
                                };
                            }
                            
                            if (document.readyState === 'loading') {
                                document.addEventListener('DOMContentLoaded', initBeatQuoteFormValidation);
                            } else {
                                initBeatQuoteFormValidation();
                            }
                        })();
                        </script>
                     </div>
                  </div>
                    </div>
                     </div>
                    </div>
                    
                    
    
                    </section>
                    
                    
                        
<section class="cp-contact-area pt-30 pb-80">
            <div class="container">
                <div class="row justify-content-center">
               <div class="col-xl-8 col-lg-7">
                  <div class="cp-case-study-title mb-60 t-center">
                     <div class="cp-section-title">
                        <span class="cp-subtitle mb-15">MyBoxPrinting</span>
                        <h2 class="cp-title">Create <span>stunning
                              custom boxes</span> <br> for your business</h2>
                     </div>
                  </div>
               </div> 
            </div>
            
            
            
            <?php $pp= DB::table('products')->limit(8)->orderBy('id','asc')->get();?>
                <div class="row">
                    @foreach($pp as $p)
                    <div class="col-xl-3 col-sm-6">
                                    <div class="product-single">
                                        <div class="product-thumb">
                                            <a href="{{ url(str_replace(' ','-', strtolower($p->prod_url))).'/'}}" class="image">
                                                                         <img class="pic-1" src="{{ url('images/' . $p->prod_image) }}" alt="{{ $p->prod_altname }}">
                                                                    <img class="pic-2" src="{{ url('images/' . $p->prod_image) }}" alt="{{ $p->prod_altname }}">
                                                                               
                                            </a>
                                            <ul class="product-links">
                                               
                                                <li><a href="{{ url(str_replace(' ','-', strtolower($p->prod_url))).'/'}}"><i class="fal fa-eye"></i></a></li>
                                             
                                            </ul>
                                        </div>
                                        <div class="product-description">
                                            <h4 class="product-name">
                                                <a href="{{ url(str_replace(' ','-', strtolower($p->prod_url))).'/'}}"> <?php if(strlen($p->prod_name)> 17)
                                                                   {
                                                                       echo substr($p->prod_name,0, 17).'...';
                                                                   }
                                                                   else{
                                                                      echo  $p->prod_name;
                                                                   }
                                                                
                                                                 ?></a>
                                            </h4>
                                             
                                        </div>
                                    </div>
                                </div>
                    
                    @endforeach
                    </div>
                    </div>
        </section>
                    
                    
                  <section class="cp-services2-area pb-150">
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-xl-8">
                  <div class="cp-services2-title-wrap t-center mb-65">
                     <div class="cp-section-title">
                        <span class="cp-subtitle mb-15">Why Choose Us</span>
                        <h2 class="cp-title mb-25">
                           ECO-FRIENDLY 
 <span>PRODUCT </span> PACKAGING!</h2>
                        
                     </div>
                  </div>
               </div>
            </div>
            <div class="cp-services2-item-wrap mb-30">
               <div class="row">
                  <div class="col-xxl-3 col-md-6 col-sm-12">
                     <div class="cp-service2-item p-relative img-hover-left-right-item mb-40">
                        <div class="cp-service2-img p-absolute img-hover-left-right" data-background="{{url('box_assets/img/services-8.jpg')}}" style="background-image: url('box_assets/img/services-8.jpg');"></div>
                        <div class="cp-service2-icon m-img mb-20" style="    text-align: center;">
                           <img src="{{url('box_assets/img/free-shipping.png')}}" alt="free-shipping" style="width:90px;height:90px;">
                        </div>
                        <div class="cp-service2-content p-relative zi-5">
                           <h4 class="cp-service2-title mb-15" style="    text-align: center;">FREE SHIPPING</h4>
                           <p class="cp-service2-text">Every order regardless of its size is delivered across the USA for free

</p>
                          
                        </div>
                     </div>
                  </div>
                  <div class="col-xxl-3 col-md-6 col-sm-12">
                     <div class="cp-service2-item p-relative img-hover-left-right-item mb-40 ">
                        <div class="cp-service2-img p-absolute img-hover-left-right" data-background="{{url('box_assets/img/services-8.jpg')}}" style="background-image: url('box_assets/img/services-8.jpg');"></div>
                        <div class="cp-service2-icon m-img mb-20" style="    text-align: center;">
                          <img src="{{url('box_assets/img/free-design.png')}}" alt="free-design" style="width:90px;height:90px;">
                        </div>
                        <div class="cp-service2-content p-relative zi-5" style="    text-align: center;">
                           <h4 class="cp-service2-title mb-15">FREE DESIGN</h4>
                           <p class="cp-service2-text">Free of cost custom design support by packaging experts</p>
                  
                        </div>
                     </div>
                  </div>
                  <div class="col-xxl-3 col-md-6 col-sm-12">
                     <div class="cp-service2-item p-relative img-hover-left-right-item mb-40 ">
                           <div class="cp-service2-img p-absolute img-hover-left-right" data-background="{{url('box_assets/img/services-8.jpg')}}" style="background-image: url('box_assets/img/services-8.jpg');"></div>
                        <div class="cp-service2-icon m-img mb-20" style="    text-align: center;">
                         <img src="{{url('box_assets/img/cost.png')}}" alt="cost-icon" style="width:90px;height:90px;">
                        </div>
                        <div class="cp-service2-content p-relative zi-5" style="    text-align: center;">
                           <h4 class="cp-service2-title mb-15">NO SETUP COST
                           </h4>
                           <p class="cp-service2-text">100% waiver on pre-press cost including die and plate making</p>
                                    </div>
                     </div>
                  </div>
                  <div class="col-xxl-3 col-md-6 col-sm-12">
                     <div class="cp-service2-item p-relative img-hover-left-right-item mb-40">
                       <div class="cp-service2-img p-absolute img-hover-left-right" data-background="{{url('box_assets/img/services-8.jpg')}}" style="background-image: url('box_assets/img/services-8.jpg');"></div>
                        <div class="cp-service2-icon m-img mb-20" style="    text-align: center;">
                           <img src="{{url('box_assets/img/satisfaction.png')}}" alt="satisfaction" style="width:90px;height:90px;">
                        </div>
                        <div class="cp-service2-content p-relative zi-5" style="    text-align: center;">
                           <h4 class="cp-service2-title mb-15">SATISFACTION GUARANTEED


                           </h4>
                           <p class="cp-service2-text">Premium quality boxes at guaranteed lowest pricing

</p>
            
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row justify-content-center">
               <div class="col-xl-6">
                  <div class="cp-services-view-btn t-center">
                     <a href="{{url('by-industry').'/'}}" class="cp-border-btn">View All
                        <span class="cp-border-btn__inner">
                           <span class="cp-border-btn__blobs">
                              <span class="cp-border-btn__blob"></span>
                              <span class="cp-border-btn__blob"></span>
                              <span class="cp-border-btn__blob"></span>
                              <span class="cp-border-btn__blob"></span>
                           </span>
                        </span>
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </section>
                    @include('frontend/footer')
 
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />


<script>
    $(document).ready(function () {
    $('select').selectize({
        sortField: 'text'
    });
});

function updateFileName(input) {
    var fileName = input.files[0] ? input.files[0].name : "Attach quote or design...";
    document.getElementById('file-name-display').innerText = fileName;
}
</script>
