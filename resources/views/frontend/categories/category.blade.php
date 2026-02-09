@include('frontend/header')

<!-- CKEditor CDN -->
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
 
 <style>
     .nice-select{
         display: none !important;
     }
     
     .product-single .product-thumb{
         background: none !important;
     }
 
        .select-items div, .select-selected{
            background-color: white !important;color: black;
        }
  
      .cp-quote-title span{
          background: none !important;
      }
  </style>
 
<main>
        <!-- page title area start  -->
        <section class="page-title-area breadcrumb-spacing cp-bg-14">
       
         
        </section>
        <!-- page title area end  -->
             <!-- page title area start  -->
         
     
        
                <section class="hide-on-mobile" style="background-image: url('{{ url('images') . '/' . $category_name[0]->cate_banner }}');  width: 100%;
 
    background-size: cover;
    background-repeat: no-repeat;
        height: 450px;">
           
         <div class="zi-500 p-relative">
             
           
            <div class="container">
               
               <div class="cp-banner-content-space" style=" padding: 120px 0px 0px 0px!important;">
                  <div class="row align-items-center">
                     <div class="col-xl-5 col-lg-6 order-md-2">
                    
                     </div>
                     <div class="col-xl-7 col-lg-6 order-md-1">
                          <style>
                              .custom-center-section {
  text-align: center;
  margin-top: 200px;
}

@media (max-width: 768px) {
  .custom-center-section {
    margin-top: 100px; /* smaller on tablets/mobile */
  }
}

@media (max-width: 480px) {
  .custom-center-section {
    margin-top: 60px; /* even smaller on small phones */
  }
}

                          </style>
                     <div class="custom-center-section">
 

   <!-- Bottom Center Button (same as top) -->
   <div class="cp-banner-btn cp-two-btn wow mt-4" data-wow-delay="1.7s">
      <a href="{{ url('get-quote').'/' }}" class="cp-border-btn" style="height: 40px !important; line-height: 40px !important; background-color:#86C342; color:white !important;">
         Request Quote
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
               </div>
            </div>
         </div>
      </section>
 
       
        <!-- product area start  -->
        <div class="product-area pt-50 pb-50">
            
            <div class="container">
                <div class="row">
                    
               
                                 
                    <div class="col-xl-12 col-lg-12 order-lg-2">
                        <div class="cp-product-right mb-8 ">
                            <div class="row align-items-center mb-40">
                                
                                <div class="col-lg-8 col-md-6">
                                      <div class="page-title-wrapper t-center">
                            
                             <?php if($category_name[0]->parent_cate == 0){?>
                             
                             
                            <h6 class="page-title mb-10" style="    font-size: 20px !important;">{{$category_name[0]->cate_name}}</h6>
                               <?php } else{?>
                            <div class="breadcrumb-menu ">
                                <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                                    
                                    <ul class="trail-items">
                                               <i class="far fa-home" style="    padding: 5px;
    color: #86C342;"></i>
                                        <li class="trail-item trail-begin"><a href="{{url('/')}}"><span>Home</span></a>
                                        </li>
                                         <li class="trail-item trail-begin"><a href="{{url($sub_parent_match[0]->cate_url).'/'}}"><span>{{$sub_parent_match[0]->cate_name}}</span></a>
                                        </li>
                                        
                                        <li class="trail-item trail-end"><span>{{$category_name[0]->cate_name}}</span></li>
                                    </ul>
                                </nav>
                            </div>
                                     <div class="forthemobile mt-40">
              <div class="container">
            <div class="row align-items-end">
                
             <h2 class="cp-banner-title mb-1"
                              data-wow-delay="1.1s" style="font-size:30px !important;text-align:center;">{{$category_name[0]->cate_name}}</h2>
                        
                           <p class="cp-banner-text mb-0" style="width: 600px;padding:20px;text-align:center;"
                              data-wow-delay="1.4s">{{$category_name[0]->meta_description}}</p>
          </div>   </div>  </div>
          
                                <?php } ?>
                                
                        </div>
                                </div>
                         
                           <div class="col-md-4 hide-on-mobile ">
                               <div class="cp-filter-search p-relative">
                                         <form action="{{url('search').'/'}}" method="post" enctype="multipart/form-data">
                                             @csrf
                                              <input type="text" name="search" placeholder="What are you Looking For ? " required>
                                                 <button type="submit" style="background: none; border: none; cursor: pointer;">
        <i class="far fa-search" style="top: 40% !important;"></i>
    </button>
                                            </form>
                          </div>
                    </div>
                            </div>
                            
                            <div class="row mb-20">
                                
                                
                                   @foreach ($sub_products as $promItem1) 
    <div class="col-xl-2 col-lg-4 col-md-6 col-6 grid-item">
        <div class="">
            <div class="" style="background:none !important;">
                <a href="{{ url(str_replace(' ', '-', strtolower($promItem1->prod_url))) . '/' }}" class="">
                    @php
                        $imgName = $promItem1->prod_image;
                        $imgNameReadable = preg_replace('/\d+/', '', str_replace(['.webp', '.png', '.jpg', '-', '.'], [' ', '', '', ' ', ''], $imgName));
                        $prodGallery = is_array($promItem1->prod_gallery) ? $promItem1->prod_gallery : json_decode($promItem1->prod_gallery, true);
                        $firstGalleryImage = !empty($prodGallery) ? $prodGallery[1] : null;
                    @endphp
                    
                    <img 
                        style="border-radius:20px; padding: 5px; width:100%;" 
                        src="{{ url('images/' . $promItem1->prod_image) }}" 
                        alt="{{ trim($imgNameReadable) }}"
                    >
                </a>

                <ul class="product-links">
                    <li>
                        <a href="{{ url(str_replace(' ', '-', strtolower($promItem1->prod_url))) . '/' }}"></a>
                    </li>
                </ul>
            </div>

            <div class="product-description" style="background-color:white !important;">
                <div style="height: 45px; overflow: hidden; text-align:center;">
                    <h3 class="for-mobilexx" style="font-size:16px !important; line-height:1.3em;">
                       <a href="{{ url(str_replace(' ', '-', strtolower($promItem1->prod_url))) . '/' }}">  {{ \Illuminate\Support\Str::limit($promItem1->prod_name, 55) }}</a>
                    </h3>
                </div>
            </div>
        </div>
    </div>
@endforeach


 
                            </div>
                          
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
      
    
           
            <section class="cp-cta2-area pt-10 pb-10 cp-video-overlay bg-fixed bg-css " style="height: 70px;">
                
         <div class="container" > 
            <div class="cp-cta2-wrap scene d-flex align-items-center justify-content-between flex-wrap flex-xl-nowrap ow fadeInUp animated" data-wow-duration="2.3s" data-wow-delay="0.3s">
               <div class=" cp-cta2-title mb-20">
                  <p style="font-size:20px;color:white;">More Orders, More Savings! <span style="font-size: larger;color: #85c83f;"> Get 30% Off </span>On Bulk Orders !</p>
               </div>
               <div class="cp-cta2-btn mb-20" style="margin-top: -5px;">
                  <div class="cp-header-btn d-none d-md-block">
                           <a class="cp-btn" href="{{url('get-quote').'/'}}">
                         Order Now
                              <span class="cp-btn__inner">
                                 <span class="cp-btn__blobs">
                                    <span class="cp-btn__blob"></span>
                                    <span class="cp-btn__blob"></span>
                                    <span class="cp-btn__blob"></span>
                                    <span class="cp-btn__blob"></span>
                                 </span>
                              </span>
                           </a>
                        </div>
                
                  </a>
               </div>
            </div>
         </div>
      </section>
      
  
<style>
    .select-items div, .select-selected{
        width: 100%;
    }
    .cp-quote-wrapper {
    padding: 10px 50px !important;
}

</style>

            <section class="cp-contact-area"  style="background-color:#D3F3E6;">
            <div class="container-fluid" style="">
                <div class="row">

  <div class="col-lg-8">
                    
                    <div class="cp-quote-wrapper cp-border5" style="">
                    
                     <div class="cp-quote-form">
                        <form action="{{url('product_form_submit1').'/'}}" method="post">
                     
                            @csrf
                           <div class="cp-quote-box mb-10">
                              <h2 class="cp-quote-title"><span style="color:#86C342;">GET CUSTOM QUOTE</span></h2>
                      
                              <div class="row">
                                 <div class="col-lg-4">
                                    <div class="cp-input-field">
                                   
                                       <input type="text" id="name" name="name" required placeholder="Name *">
                                   
                                    </div>
                                 </div>
                                 <div class="col-lg-4">
                                    <div class="cp-input-field">
                                   
                                       <input type="email" id="email" name="email" required placeholder="E Mail*">
                                      
                                    </div>
                                 </div>
                                 <div class="col-lg-4">
                                    <div class="cp-input-field">
                                     
                                       <input type="text" id="phone" name="phone" required placeholder="Phone Number *">
                             
                                    </div>
                                 </div>
                              
                           
                                 
                                   <div class="col-xl-3 col-lg-6">
                                    <div class="cp-input-field">
                                 
                                       <input type="text" id="width" name="width" required placeholder="Width *">
                                      
                                    </div>
                                 </div>
                                 <div class="col-xl-3 col-lg-6">
                                    <div class="cp-input-field">
                                  
                                       <input type="text" id="height" name="height" required placeholder="Height *">
                                   
                                    </div>
                                 </div>
                                 <div class="col-xl-3 col-lg-6">
                                    <div class="cp-input-field">
                                       
                                       <input type="text" id="length" name="length" required placeholder="Length *">
                                   
                                    </div>
                                 </div>
                                  <div class="col-xl-3 col-lg-6">
                                    <div class="cp-input-field">
                                    
                                       <input type="text" id="length" name="qty" required placeholder="Quantity *">
                               
                                    </div>
                                 </div>
                                 
                
    
                                <?php $pp=DB::table('products')->get();?>
                    
          <div class="col-xl-4 col-lg-4">
              
              
              <div class="custom-select" style="width:100%;">
  <select name="prodname" style=" ">
       <option value="">Select Your Box Style</option>
   @foreach($pp as $p)
            <option value="{{$p->prod_name}}">{{$p->prod_name}}</option>
        @endforeach
  </select>
</div>
 

 
                                       
                                       
                                       
 
    </div>
 


                                 <div class="col-xl-4 col-lg-6 for-the-mobile">
                                    <div class="custom-select" style="width:100%;">
                                     
                                     <select class="form-control" name="stock" data-gtm-form-interact-field-id="3">
                                        <option value="Paper Stock">Select Paper Stock</option> 
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
                                 
                                 <div class="col-xl-4 col-lg-6 for-the-mobile">
                                     <div class="custom-select" style="width:100%;">
                                  
                                    <select class="form-control" name="color">
                                        <option>Select Color</option>
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
                                 
                                 
                                 
                                        <div class="col-xl-4 col-lg-6 mt-20" style="">
                                   <div class="custom-select" style="width:100%;">
<select class="form-control" name="coating" data-gtm-form-interact-field-id="0">
    <option value="Paper Coating">Select Paper Coating</option>
  <option value="Aqueous Coating">Aqueous Coating</option>
  <option value=" Semi Gloss"> Semi Gloss</option>
  <option value="Gloss UV">Gloss UV</option>
  <option value="Matte UV">Matte UV</option>
  <option value="Semi Matte">Semi Matte</option>
</select>
 
                                    </div>
                                 </div>
                                 
                                 <div class="col-xl-4 col-lg-6 mt-20">
                             <div class="custom-select" style="width:100%;">
                                    
<select class="form-control" name="cad_sample" data-gtm-form-interact-field-id="2">
    <option value="CAD Sample">Select CAD Sample</option>
  <option value="Yes">Yes</option>
  <option value="No">No</option>
</select>
 
                                    </div>
                                 </div>
                                         
    
                                 <div class="col-xl-4 col-lg-6 mt-20">
                                   <div class="custom-select" style="width:100%;">
                                  
                                       <select name="unit" style="">
                                             <option value="select units">Select Units</option>
                                          <option value="MM">MM</option>
                                          <option value="CM">CM</option>
                                      
                                       </select>
                                    </div>
                                 </div>
                                           
                           
                                    <div class="col-xl-12 mt-20">
                                    <div class="cp-input-field">
                                     
                                       <input type="text" id="phone" name="message" placeholder="Your Message">
                                    
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>
                           <div class="cp-quote-btn mb-10" style="    text-align: center;">
                               <div class="cp-input-field">
                                   <div class="g-recaptcha" id="category-quote-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}" data-callback="onCategoryQuoteCaptchaSuccess"></div>
                                   <div id="category-quote-captcha-error" style="color: #fff; font-size: 14px; font-weight: bold; margin-top: 10px; display: none; padding: 12px; background: #dc3545; border-radius: 5px;">
                                       ⚠️ Please complete the reCAPTCHA verification before submitting
                                   </div>
                               </div>
                              <button type="submit" class="cp-border2-btn" style="background-color:#86C342; color:white;">Instant Quote</button>
                           </div>
                        </form>
                        
                        <script>
                        var categoryQuoteCaptchaCompleted = false;
                        
                        function onCategoryQuoteCaptchaSuccess(token) {
                            categoryQuoteCaptchaCompleted = true;
                            var errorDiv = document.getElementById('category-quote-captcha-error');
                            if (errorDiv) {
                                errorDiv.style.display = 'none';
                            }
                        }
                        
                        (function() {
                            function initCategoryQuoteFormValidation() {
                                var forms = document.querySelectorAll('form[action*="product_form_submit1"]');
                                var errorDiv = document.getElementById('category-quote-captcha-error');
                                
                                if (forms.length === 0) return;
                                
                                forms[0].onsubmit = function(event) {
                                    if (!categoryQuoteCaptchaCompleted) {
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
                                            
                                            categoryQuoteCaptchaCompleted = false;
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
                                document.addEventListener('DOMContentLoaded', initCategoryQuoteFormValidation);
                            } else {
                                initCategoryQuoteFormValidation();
                            }
                        })();
                        </script>
                     </div>
                  </div>
                    </div>
                    
                      <div class="col-lg-4">
                        <img src="{{url('custom-boxes-sample-kit.webp')}}" style="margin-top: 50px;" alt="box-sample-kit">
                          </div>
                     </div>
                    </div>
                    
                    
    
                    </section>
                    
           
                     <style>
    .custom-scrollbar {
        height: 500px;
        overflow-y: auto;
        
        padding: 10px;
    }

    /* Custom scrollbar styles */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px; /* Adjust scrollbar width */
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1; /* Scrollbar track color */
        border-radius: 5px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #888; /* Scrollbar color */
        border-radius: 5px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #555; /* Scrollbar hover effect */
    }

    /* CKEditor content styling - Fix h1 margin-top spacing issue - AGGRESSIVE FIX */
    .custom-scrollbar h1 {
        margin-top: -50px !important;
        margin-bottom: 15px !important;
        line-height: 1.3 !important;
    }

    /* First h1 should have no top margin */
    .custom-scrollbar h1:first-child,
    .custom-scrollbar h1:first-of-type {
        margin-top: -50px !important;
        padding-top: 0 !important;
        margin-bottom: 15px !important;
    }
    
    .custom-scrollbar h2 {
        margin-top: 20px !important;
        margin-bottom: 12px !important;
        line-height: 1.3 !important;
    }
    
    .custom-scrollbar p {
        margin-bottom: 15px !important;
        line-height: 1.6 !important;
    }

    /* CKEditor content styling for bullet points */
    .custom-scrollbar ul,
    .custom-scrollbar ol {
        margin: 10px 0;
        padding-left: 30px;
    }

    .custom-scrollbar ul li {
        list-style-type: disc;
        margin: 5px 0;
    }

    .custom-scrollbar ol li {
        list-style-type: decimal;
        margin: 5px 0;
    }

    .custom-scrollbar li {
        display: list-item;
    }

    /* Mobile view fixes */
    @media (max-width: 768px) {
        .custom-scrollbar {
            padding: 15px !important;
            height: auto !important;
            max-height: 500px;
        }
        
        .custom-scrollbar * {
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        
        .custom-scrollbar h1 {
            font-size: 20px !important;
            margin-top: 15px !important;
            margin-bottom: 10px !important;
            line-height: 1.3 !important;
        }
        
        .custom-scrollbar h1:first-child,
        .custom-scrollbar h1:first-of-type {
            margin-top: 0 !important;
        }
        
        .custom-scrollbar h2 {
            font-size: 18px !important;
            margin-top: 15px !important;
            margin-bottom: 10px !important;
            line-height: 1.3 !important;
        }
        
        .custom-scrollbar h3 {
            font-size: 16px !important;
            margin-top: 12px !important;
            margin-bottom: 8px !important;
        }
        
        .custom-scrollbar p {
            font-size: 14px !important;
            line-height: 1.6 !important;
            margin-bottom: 12px !important;
        }
        
        .custom-scrollbar ul,
        .custom-scrollbar ol {
            padding-left: 20px !important;
            margin: 10px 0 !important;
        }
        
        .custom-scrollbar li {
            margin: 5px 0 !important;
            font-size: 14px !important;
        }
        
        .custom-scrollbar img {
            max-width: 100% !important;
            height: auto !important;
        }
        
        .custom-scrollbar table {
            width: 100% !important;
            font-size: 12px !important;
            display: block !important;
            overflow-x: auto !important;
        }
    }

    @media (max-width: 480px) {
        .custom-scrollbar {
            padding: 10px !important;
            height: auto !important;
            max-height: 400px;
        }
        
        .custom-scrollbar h1 {
            font-size: 18px !important;
            margin-top: 12px !important;
            margin-bottom: 8px !important;
            line-height: 1.3 !important;
        }
        
        .custom-scrollbar h1:first-child,
        .custom-scrollbar h1:first-of-type {
            margin-top: 0 !important;
        }
        
        .custom-scrollbar h2 {
            font-size: 16px !important;
            margin-top: 12px !important;
            margin-bottom: 8px !important;
            line-height: 1.3 !important;
        }
        
        .custom-scrollbar h3 {
            font-size: 14px !important;
            margin-top: 10px !important;
            margin-bottom: 6px !important;
        }
        
        .custom-scrollbar p {
            font-size: 13px !important;
            line-height: 1.5 !important;
            margin-bottom: 10px !important;
        }
        
        .custom-scrollbar ul,
        .custom-scrollbar ol {
            padding-left: 18px !important;
            margin: 8px 0 !important;
        }
        
        .custom-scrollbar li {
            font-size: 13px !important;
            margin: 4px 0 !important;
        }
        
        .custom-scrollbar img {
            max-width: 100% !important;
            height: auto !important;
        }
        
        .custom-scrollbar table {
            width: 100% !important;
            font-size: 11px !important;
            display: block !important;
            overflow-x: auto !important;
        }
    }
    
    /* Additional mobile fixes for tablets */
    @media (max-width: 991px) {
        .custom-scrollbar {
            padding: 12px !important;
        }
        
        .custom-scrollbar img {
            max-width: 100% !important;
            height: auto !important;
            display: block !important;
        }
    }
</style>
 <section class="mt-20">
        <div class="container">
    <div class="row">
        <div class="col-md-12 custom-scrollbar" style="height: 500px; overflow-y: auto;padding: 10px;">
      <?php echo  $get_category_by_id[0]->cate_long_desc ;?>
        </div>
    </div>
</div>

                   </section>  
 
            
                       <?php if(count($faqtable) >0  ){?>
        
        <section class="cp-services-area pb-20 p-relative z-index-1 mt--20 pt-20">
         
         <div class="container">
            <div class="row align-items-end">
                
                  
<div class="cp-cta2-title mb-0 pt-20">
 <p style="font-size: 30px; color: rgb(33 37 41 / var(--tw-text-opacity,1)); margin-top: -10px;    font-weight: 600;">FAQ's <span class="separator-text" style="font-weight: 100;">Explore answers to some relevant questions about creating a custom box. If you've any query, feel free to <a href="https://www.myboxprinting.com/contact-us/" style="color:#85C241;">contact us!</a></span>
                <span class="" style="  font-size:17px;  font-weight: 600;color:#86C342;">
              
                </span>
              </p>
</div>

</div></div>

 </section>
 
 
 
 
 <section class="cp-faq-area p-relative pt-20 pb-20 fix">
  <div class="container">
    <div class="row">
         <?php $sr=0; foreach ($faqtable as $pro_faq){ $sr++; ?>
         <div class="col-md-6">
                   <div class="accordion-item">
                              <h2 class="accordion-header" id="headingOne1<?php echo $sr ?>">
                                 <button class="accordion-button" style="    background-color: #86c442;color:white;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne1<?php echo $sr ?>" aria-expanded="true" aria-controls="collapseOne1<?php echo $sr ?>"><?php echo $pro_faq->question; ?></button>
                              </h2>
                              <div id="collapseOne1<?php echo $sr ?>" class="accordion-collapse collapse show" aria-labelledby="headingOne1<?php echo $sr ?>" data-bs-parent="#accordionExample">
                                 <div class="accordion-body">
                                          <?php echo $pro_faq->answer; ?>
                                          
                                 </div>
                              </div>
                           </div>
                       </div>
                       
                          <?php } ?>
                 </div>
         </div>
      </section>
      
         <?php }else {?>
        <?php echo "";?>
      <?php }?>
      
            <section class="cp-cta2-area pt-10 pb-10 cp-video-overlay bg-fixed bg-css " style="height: 70px;">
         <div class="container" > 
            <div class="cp-cta2-wrap scene d-flex align-items-center justify-content-between flex-wrap flex-xl-nowrap ow fadeInUp animated" data-wow-duration="2.3s" data-wow-delay="0.3s">
               <div class=" cp-cta2-title mb-20">
                  <p style="font-size:20px;color:white;">More Orders, More Savings! <span style="font-size: larger;color: #85c83f;"> Get 30% Off </span>On Bulk Orders !</p>
               </div>
               <div class="cp-cta2-btn mb-20" style="margin-top: -5px;">
                  <div class="cp-header-btn d-none d-md-block">
                           <a class="cp-btn" href="{{url('get-quote').'/'}}">
                         Order Now
                              <span class="cp-btn__inner">
                                 <span class="cp-btn__blobs">
                                    <span class="cp-btn__blob"></span>
                                    <span class="cp-btn__blob"></span>
                                    <span class="cp-btn__blob"></span>
                                    <span class="cp-btn__blob"></span>
                                 </span>
                              </span>
                           </a>
                        </div>
                
                  </a>
               </div>
            </div>
         </div>
      </section>
           <section class="cp-services-area pb-20 p-relative z-index-1 mt--20 pt-20" >
         
         <div class="container">
            <div class="row align-items-end">
                
                  
<div class="cp-cta2-title mb-0 pt-20 hide-on-mobile " >
 <p style="font-size: 30px; color: rgb(33 37 41 / var(--tw-text-opacity,1)); margin-top: -10px;    font-weight: 600;">Related and Inspiring Product <span class="separator-text" style="font-weight: 100;">Discover products that inspire and elevate your business.  </span>
                <span class="" style="  font-size:17px;  font-weight: 600;color:#86C342;">
              
                </span>
              </p>
</div>

</div></div>

 </section> 
             <section>
            <div class="container-fluid">
                <div class="row justify-content-center">
                     <?php $pp = DB::table('products')->orderBy('id', 'asc')->limit(4)->get(); ?>


                     @foreach ($pp as $pp) 
                                    
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product-single">
                                        <div class="product-thumb">
                                            <a href="{{ url(str_replace(' ', '-', strtolower($pp->prod_url))).'/'}}" class="image">
                                                <img class="pic-1" src="{{url('images').'/'.$pp->prod_image}}" alt="{{$pp->prod_altname}}">
                                                 <img class="pic-2" src="{{url('images').'/'.$pp->prod_image}}" alt="{{$pp->prod_altname}}">
                                            </a>
                                            <ul class="product-links">
                                               
                                                <li><a href="{{ url(str_replace(' ', '-', strtolower($pp->prod_url))).'/'}}"><i class="fal fa-eye"></i></a></li>
                                             
                                            </ul>
                                        </div>
                                        <div class="product-description" style="    background-color: #EAF6F0 !important;">
                                            <h4 class="product-name">
                                                <a href="{{ url(str_replace(' ', '-', strtolower($pp->prod_url))).'/'}}">{{$pp->prod_name}}</a>
                                            </h4>
                                             
                                        </div>
                                    </div>
                                </div>
                        
                        
                           @endforeach
                </div>
            </div>
        </section>
    </main>


@include('frontend/footer')