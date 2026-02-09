@php $isProductPage = true; @endphp
@include('frontend/header')

<!-- Critical CSS for above-the-fold content -->

<style>
    .nice-select{
        display:none !important;
    }
    h2{
        font-size: 22px !important;
    }
    .card{
        height: 580px;
        border-radius:12px;
        border:1px solid #e8e8e8;
        transition:all 0.3s ease;
    }
    .card:hover{
        box-shadow:0 4px 12px rgba(0,0,0,0.1);
        transform:translateY(-4px);
    }
    /* Critical mobile optimizations */
    @media (max-width: 768px) {
        .tab-pane .card {
            height: auto;
            min-height: 400px;
        }
        /* Optimize form rendering on mobile */
        .cp-quote-form {
             contain: layout style;
        }
        /* Reduce initial paint for product description */
        .product-details-content {
            contain: layout style;
        }
        
        /* Fix Breadcrumb CLS */
        .page-title-wrapper {
            min-height: 85px !important; /* Increased for multi-line breadcrumbs */
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 18px;
        }
        
        /* Fix Product Image CLS */
        .prod-items {
            overflow: hidden;
            aspect-ratio: 1/1; 
            width: 100%;
            display: block;
            min-height: auto;
            position: relative;
            background: #fff; /* Prevent transparent flash */
        }
        
        .prod-items img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .prod-sm-items-swiper {
           min-height: 110px; /* Reserve space for thumbnails */
        }
    }

    /* Optimize gallery thumbnails */
    .prod-sm-items-swiper {
        min-height: 110px;
        overflow: hidden; 
    }
    /* Reduce layout shifts */
    .cp-services-item img {
        aspect-ratio: 4/3;
        object-fit: cover;
    }
    
    .prod-items {
        overflow: hidden;
        aspect-ratio: 1/1;
        width: 100%;
        position: relative;
    }
    
    .page-title-wrapper {
        min-height: 54px; 
            margin-top: 18px;
    }
    
    /* Critical Swiper CSS to prevent CLS - Scoped */
    .prod-sm-items-swiper .swiper-wrapper {
        display: flex;
        box-sizing: content-box;
    }
    .prod-sm-items-swiper .swiper-slide {
        flex-shrink: 0;
        height: 100%;
        position: relative;
    }
    
    /* Prevent CLS for product title and price section */
    h1 {
        min-height: 30px;
        contain: layout;
    }
    
    .cp-quote-wrapper {
        min-height: 400px; /* Reserve space for form */
        contain: layout style;
    }
    
    @media (max-width: 768px) {
        .cp-quote-wrapper {
            min-height: 600px; /* More space needed on mobile */
        }
    }
</style>


 <style>
        .select-items div, .select-selected{
            background-color: white !important;color: black;
        }
        
        /* Social Media Sidebar */
        .social-sidebar {
            position: absolute;
            right: 0px;
            top: 60%;
            transform: translateY(-50%);
            z-index: 999;
            background: #86C342;
            border-radius: 40px;
            padding: 10px 5px;
            box-shadow: 0 4px 15px rgba(134,195,66,0.3);
        }
        .social-sidebar a {
            display: flex;
            width: 37px;
            height: 41px;
            margin: 6px 0;
            background: #fff;
            border-radius: 50%;
            align-items: center;
            justify-content: center;
            color: #000;
            font-size: 14px;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .social-sidebar a:hover {
            transform: scale(1.15);
            background: #000;
            color: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        
        /* Quote Form Decorative Dots */
        .quote-dots {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            overflow: hidden;
        }
        .quote-dot {
            position: absolute;
            width: 8px;
            height: 8px;
            background: rgba(255,255,255,0.4);
            border-radius: 50%;
            animation: float 3s infinite ease-in-out;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        @media (max-width: 768px) {
            .social-sidebar {
                display: none;
            }
        }
    </style>
 <main>

        <!-- Social Media Sidebar -->
        <?php $socials_media_sidebar = DB::table('socials_media')->first(); ?>
        <div class="social-sidebar">
            <a href="{{$socials_media_sidebar->facebook_link}}" target="_blank" rel="noopener" aria-label="Facebook">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="{{$socials_media_sidebar->twitter_link}}" target="_blank" rel="noopener" aria-label="Twitter">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="https://www.pinterest.com/myboxprintingus/" target="_blank" rel="noopener" aria-label="Pinterest">
                <i class="fab fa-pinterest-p"></i>
            </a>
            <a href="{{$socials_media_sidebar->linkedin_link}}" target="_blank" rel="noopener" aria-label="LinkedIn">
                <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="{{$socials_media_sidebar->instagram_link}}" target="_blank" rel="noopener" aria-label="Instagram">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="{{$socials_media_sidebar->youtube_link}}" target="_blank" rel="noopener" aria-label="YouTube">
                <i class="fab fa-youtube"></i>
            </a>
        </div>

        <!-- page title area start  -->
        <section class="page-title-area breadcrumb-spacing cp-bg-14">
        
        </section>
        <!-- page title area end  -->
      <section class="shop-details-area pt-10 pb-10 fix">
               <div class="container">
                <div class="row">
                    <div class="col-xxl-6">
                        <div class="page-title-wrapper t-center">
          
                            <div class="breadcrumb-menu">
                             
                                <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                                    <ul class="trail-items">
                                        <i class="far fa-home" style="    padding: 5px;
    color: #86C342;"></i>
                                        <li class="trail-item trail-begin"><a href="{{url('/')}}"><span>Home</span></a>
                                        </li>
                                        
                                        <?php
				 $check = $get_product_data[0]->prod_url;
				 $checkProduct = DB::table('products')->where(['prod_url'=>$get_product_data[0]->prod_url])->get();
				 $checkProduct1 = DB::table('cardboardboxes')->where(['prod_url'=>$get_product_data[0]->prod_url])->get();
		 
					 
				?>
				<?php if(count($checkProduct)) {?>
               	<li class="trail-item trail-end"><a style="  " href="{{url($main_category_c_url).'/'}}"><span>{{$main_category_c}}</span></a></li>
               	<li class="trail-item trail-end"><a style="" href="{{url($sub_cat_name_pro_url).'/'}}"><span>{{$sub_cat_name_pro}}</span></a></li>
               	<li class="trail-item trail-end"><span>{{$product_name_thi[0]->prod_name}}</span></li>
				<?php } else{?>
					 
						<li class="trail-item trail-end"><span>{{$product_name_thi[0]->prod_name}}</span></li>
					<?php } ?>
					
					
				
				
                                       
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            </section>
            
            <style>
                .gallery-thumbnail {
    border: 2px solid #e8e8e8;
    border-radius: 8px;
    margin: 5px;
    transition: all 0.3s ease;
    cursor: pointer;
    opacity:0.7;
}
.gallery-thumbnail:hover,
.gallery-thumbnail.active {
    border-color: #86C342;
    opacity:1;
    box-shadow:0 2px 8px rgba(134,195,66,0.3);
}
            </style>
        <!-- shop details area start  -->
        <section class="shop-details-area pt-10 pb-10 fix">
            <div class="container">
                <div class="row">
           <div class="col-lg-5 text-center">
    <div class="cbb-product-detail">
        <!-- Main Image -->
        <div class="prod-items" style=" border: 3px solid #F7F7F7;">
            @if (!empty($product_r) && !empty(json_decode($product_r[0]->prod_gallery)))
                <?php $firstImage = json_decode($product_r[0]->prod_gallery)[0]; ?>
                <img id="main-image" class="prod-items-pic img-fluid" 
                     src="{{ asset('images/'.$firstImage) }}" 
                     width="500" height="500"
                     fetchpriority="high"
                     loading="eager"
                     decoding="async"
                     title="{{$get_product_data[0]->prod_name}}" 
                     alt="{{ str_replace(['.', 'webp'], '', $firstImage) }}" 
                     aria-label="{{$get_product_data[0]->prod_name}}" />
            @else
                <img id="main-image" class="prod-items-pic img-fluid" 
                     src="{{ asset('images/default.jpg') }}"  
                     width="500" height="500"
                     fetchpriority="high"
                     loading="eager"
                     decoding="async"
                     alt="Default Image" />
            @endif
        </div>

        <!-- Thumbnails Gallery - Swiper Optimized -->
        <div class="prod-sm-items-swiper swiper container mt-20">
             <div class="swiper-wrapper">
            @if (!empty($product_r))
                @foreach ($product_r as $item)
                    <?php $images = json_decode($item->prod_gallery); ?>
                    @if (!empty($images))
                        @foreach ($images as $image)
                            <div class="swiper-slide">
                            <img 
                                class="img-fluid gallery-thumbnail" 
                                data-src="{{ url('images/'.$image) }}" 
                                src="{{ url('images/'.$image) }}" 
                                width="100" height="100"
                                loading="lazy"
                                title="{{$get_product_data[0]->prod_name}}"
                                alt="{{ str_replace(['.', 'webp'], '', $image) }}"  
                                aria-label="{{$get_product_data[0]->prod_name}}" />
                            </div>
                        @endforeach
                    @endif
                @endforeach
            @endif
             </div>
             <!-- Add Arrows -->
            <div class="swiper-button-next" style="color: #86C342; transform: scale(0.6);"></div>
            <div class="swiper-button-prev" style="color: #86C342; transform: scale(0.6);"></div>
        </div>
    </div>
    
    <!--add to cart button-f start-->
    <!--<form method="POST" action="{{ url('/cart/add/'.$get_product_data[0]->id).'/' }}" class="text-center">-->
    <!--    @csrf-->
    <!--    <button type="submit" class="btn mt_btn_yellow" style="margin-top: 25px;background-color: #86C342;font-size: 20px;color: #fff;border-radius: 4px;" id="add-to-cart" name="add-to-cart">Add to Cart</button>-->
    <!--</form>-->
    <!--add to cart button-f end-->
    
    <style>
/* Trusted By Critical CSS moved to head to prevent CLS */
.trusted-by-wrapper {
  text-align: center;
  margin: 20px auto;
  display: block;
  visibility: visible;
  opacity: 1;
  min-height: 100px; /* Reserve space to prevent CLS */
}
@media (max-width: 768px) {
    .trusted-by-wrapper {
        min-height: 160px; /* Reserve more space for stacked mobile layout */
    }
}

.heading {
  font-size: 14px;
  font-weight: 700;
  letter-spacing: 0.5px;
  margin-bottom: 20px;
  display: block;
  color: #000;
}

.logos-wrapper {
  display: flex;
  gap: 15px;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
  visibility: visible;
}

/* Review Badge Styles */
.review-badge {
  display: inline-block;
  visibility: visible;
  background: white;
  border: 1px solid #e0e0e0;
  border-radius: 30px;
  padding: 12px 20px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.review-badge:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.review-badge a {
  text-decoration: none;
  color: inherit;
}

.badge-content {
  display: flex;
  flex-direction: row;
  align-items: center;
  gap: 12px;
}

/* Google Badge Specific */
.google-badge .google-logo-section {
  display: flex;
  align-items: center;
  gap: 6px;
}

.google-badge .google-g-icon {
  width: 24px;
  height: 24px;
}

.google-badge .google-text {
  font-size: 12px;
  color: #5f6368;
  font-weight: 400;
}

.google-badge .badge-rating {
  display: flex;
  align-items: center;
  gap: 6px;
}

.google-badge .rating-number {
  font-size: 20px;
  font-weight: 700;
  color: #202124;
  line-height: 1;
}

.google-badge .stars {
  display: flex;
  gap: 1px;
}

.google-badge .star {
  color: #FBBC04;
  font-size: 14px;
}

/* TrustPilot Badge Specific */
.trustpilot-badge .badge-content {
  gap: 10px;
}

.trustpilot-badge .tp-logo-wrapper {
  display: flex;
  align-items: center;
  gap: 4px;
}

.trustpilot-badge .tp-star-icon {
  width: 20px;
  height: 20px;
}

.trustpilot-badge .tp-text-logo {
  font-size: 14px;
  font-weight: 700;
  color: #191919;
}

.trustpilot-badge .tp-rating-section {
  display: flex;
  align-items: center;
}

.trustpilot-badge .tp-stars-row {
  display: flex;
  gap: 2px;
}

.trustpilot-badge .tp-star-box {
  background: #00B67A;
  color: white;
  font-size: 12px;
  width: 20px;
  height: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 2px;
}

.trustpilot-badge .tp-star-box.half {
  background: linear-gradient(90deg, #00B67A 50%, #dcdce6 50%);
}

.trustpilot-badge .tp-score-section {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  line-height: 1.2;
}

.trustpilot-badge .tp-excellent {
  font-size: 11px;
  font-weight: 600;
  color: #191919;
}

.trustpilot-badge .tp-score {
  font-size: 11px;
  font-weight: 400;
  color: #5f6368;
}

/* Mobile optimization */
@media (max-width: 768px) {
  .trusted-by-wrapper {
    margin: 10px auto;
    padding: 5px;
  }
  
  .heading {
    font-size: 12px;
    margin-bottom: 15px;
  }
  
  .logos-wrapper {
    gap: 10px;
    flex-wrap: wrap;
  }
  
  .review-badge {
    padding: 10px 15px;
    border-radius: 25px;
  }
  
  .google-badge .google-g-icon {
    width: 20px;
    height: 20px;
  }
  
  .google-badge .rating-number {
    font-size: 18px;
  }
  
  .google-badge .star {
    font-size: 12px;
  }
  
  .trustpilot-badge .tp-star-box {
    width: 16px;
    height: 16px;
    font-size: 10px;
  }
  
  .google-badge .google-text {
    font-size: 10px;
  }
  
  .trustpilot-badge .tp-text-logo {
    font-size: 12px;
  }
}

@media (max-width: 480px) {
  .logos-wrapper {
    gap: 8px;
    flex-direction: column;
  }
  
  .heading {
    font-size: 11px;
  }
  
  .review-badge {
    padding: 8px 14px;
    border-radius: 20px;
  }
  
  .google-badge .google-g-icon {
    width: 18px;
    height: 18px;
  }
  
  .google-badge .rating-number {
    font-size: 16px;
  }
  
  .trustpilot-badge .tp-star-icon {
    width: 16px;
    height: 16px;
  }
  
  .trustpilot-badge .tp-text-logo {
    font-size: 14px;
  }
}
</style>
<div class="trusted-by-wrapper">
 
  <div class="logos-wrapper">
    <!-- Google Reviews Badge -->
    <div class="review-badge google-badge">
      <a href="https://g.page/r/CXoS0VYj1SlmEBI/review" target="_blank" rel="noopener noreferrer">
        <div class="badge-content">
          <div class="google-logo-section">
            <svg class="google-g-icon" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
              <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
              <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
              <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
              <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
            </svg>
            <span class="google-text">Business Review</span>
          </div>
          <div class="badge-rating">
            <span class="rating-number">5.0</span>
            <div class="stars">
              <span class="star">★</span>
              <span class="star">★</span>
              <span class="star">★</span>
              <span class="star">★</span>
              <span class="star">★</span>
            </div>
          </div>
        </div>
      </a>
    </div>
    
    <!-- TrustPilot Badge -->
    <div class="review-badge trustpilot-badge">
      <a href="https://www.trustpilot.com/review/myboxprinting.com" target="_blank" rel="noopener noreferrer">
        <div class="badge-content">
          <div class="tp-logo-wrapper">
            <svg class="tp-star-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path fill="#00B67A" d="M12 0L15.09 7.26L23 8.27L17.5 13.14L18.82 21.02L12 17.27L5.18 21.02L6.5 13.14L1 8.27L8.91 7.26L12 0Z"/>
            </svg>
            <span class="tp-text-logo">Trustpilot</span>
          </div>
          <div class="tp-rating-section">
            <div class="tp-stars-row">
              <span class="tp-star-box">★</span>
              <span class="tp-star-box">★</span>
              <span class="tp-star-box">★</span>
              <span class="tp-star-box">★</span>
              <span class="tp-star-box half">★</span>
            </div>
          </div>
          <div class="tp-score-section">
            <span class="tp-excellent">Excellent</span>
            <span class="tp-score">4.9/5</span>
          </div>
        </div>
      </a>
    </div>
  </div>
</div>

<style>
.add-read-more.show-less-content .second-section,
.add-read-more.show-less-content .read-less {
   display: none;
}

.add-read-more.show-more-content .read-more {
   display: none;
}

.add-read-more .read-more,
.add-read-more .read-less {
   font-weight: bold;
   margin-left: 5px;
   color: #86C442;
   cursor: pointer;
}
</style>

</div>


                    <div class="col-lg-7">
                        
                <h1 style="margin-top:0;margin-left:10px;margin-bottom:15px;font-size:22px;">{{$get_product_data[0]->prod_name}}</h1>
                            <div class="container" style="padding:10px;">
                <div class="row">
                    <div class="col-md-12">
                        <?php
function getLimitedContent($content, $wordLimit = 33) {
    $words = explode(' ', strip_tags($content)); // Remove HTML tags but keep words
    if (count($words) > $wordLimit) {
        $firstPart = implode(' ', array_slice($words, 0, $wordLimit));
        $remainingPart = implode(' ', array_slice($words, $wordLimit));
        return "<span class='first-section'>{$firstPart}</span>
                <span class='second-section'>{$remainingPart}</span>
                <span class='read-more' title='Click to Show More'> ...read more</span>
                <span class='read-less' title='Click to Show Less'> read less</span>";
    }
    return $content; // If content is short, return as is
}

$prod_short_desc = $get_product_data[0]->prod_short_desc;
?>

<p class="add-read-more show-less-content" style="text-align:justify;margin-top:-10px;"><?php echo getLimitedContent($prod_short_desc); ?></p>

 



                    </div>
            </div>
            </div>
                             @if (Session::has('message'))
            <div class="alert alert-success session-destroy my-sm-0 py-sm-3 text-center">
                    <?php echo Session::get('message'); ?>
            </div>
        @endif
                    <div class="cp-quote-wrapper cp-border5" style="background:rgba(126, 196, 53, 0.78);border-radius:15px;padding:40px 35px;position:relative;overflow:hidden;box-shadow:0 10px 30px rgba(134,195,66,0.3);">
                    
                    <!-- Decorative Dots -->
                    <div class="quote-dots">
                        <span class="quote-dot" style="top:8%;left:5%;animation-delay:0s;"></span>
                        <span class="quote-dot" style="top:12%;left:15%;animation-delay:0.5s;"></span>
                        <span class="quote-dot" style="top:18%;left:85%;animation-delay:1s;"></span>
                        <span class="quote-dot" style="top:25%;right:10%;animation-delay:1.5s;"></span>
                        <span class="quote-dot" style="top:35%;left:8%;animation-delay:2s;"></span>
                        <span class="quote-dot" style="top:45%;right:5%;animation-delay:2.5s;"></span>
                        <span class="quote-dot" style="top:55%;left:12%;animation-delay:0.8s;"></span>
                        <span class="quote-dot" style="top:65%;right:15%;animation-delay:1.2s;"></span>
                        <span class="quote-dot" style="top:75%;left:20%;animation-delay:1.8s;"></span>
                        <span class="quote-dot" style="top:85%;right:8%;animation-delay:2.2s;"></span>
                        <span class="quote-dot" style="top:5%;left:50%;animation-delay:0.3s;"></span>
                        <span class="quote-dot" style="top:92%;left:50%;animation-delay:2.8s;"></span>
                        <span class="quote-dot" style="top:28%;left:30%;animation-delay:1.3s;width:6px;height:6px;"></span>
                        <span class="quote-dot" style="top:42%;right:25%;animation-delay:1.7s;width:6px;height:6px;"></span>
                        <span class="quote-dot" style="top:62%;left:70%;animation-delay:2.3s;width:6px;height:6px;"></span>
                        <span class="quote-dot" style="top:78%;right:40%;animation-delay:0.6s;width:6px;height:6px;"></span>
                        <span class="quote-dot" style="top:15%;right:30%;animation-delay:1.1s;width:5px;height:5px;"></span>
                        <span class="quote-dot" style="top:88%;left:35%;animation-delay:2.6s;width:7px;height:7px;"></span>
                    </div>
                    
                     <div class="cp-quote-form" style="position:relative;z-index:1;">
                        <form action="{{url('product_form_submit').'/'}}" method="post" enctype="multipart/form-data">
                             @csrf
                             
                        <input  type="hidden"   value="{{$get_product_data[0]->prod_name}}" name="prodname" />
                           
                           <div class="cp-quote-box">
                              <h3 style="text-align:center;margin-bottom:20px;font-size:35px;font-weight:bold;"><span style="color:white;">GET CUSTOM QUOTE</span></h3>
                              <div class="row">
                                 <div class="col-lg-4">
                                    <div class="cp-input-field">
                                     
                                       <input type="text" id="name" name="name" required placeholder="Name *">
                                    
                                    </div>
                                 </div>
                                 <div class="col-lg-4">
                                    <div class="cp-input-field">
                               
                                       <input type="email" id="email" name="email" required placeholder="Email *">
                                     
                                    </div>
                                 </div>
                                 <div class="col-lg-4">
                                    <div class="cp-input-field">
                                  
                                       <input type="tel" id="phone" name="phone" required placeholder="Phone Number *" pattern="^\+?\d*$" inputmode="tel" oninput="this.value=this.value.replace(/(?!^)\+/g,'').replace(/[^0-9+]/g,'')">
                            
                                    </div>
                                 </div>
                              
                           
                                 
                                   <div class="col-xl-3 col-lg-6">
                                    <div class="cp-input-field">
                                     
                                       <input type="number" id="width" name="width" required placeholder="Width *" step="any" inputmode="decimal">
                                      
                                    </div>
                                 </div>
                                 <div class="col-xl-3 col-lg-6">
                                    <div class="cp-input-field">
                                     
                                       <input type="number" id="height" name="height" required placeholder="Height *" step="any" inputmode="decimal">
                                     
                                    </div>
                                 </div>
                                 <div class="col-xl-3 col-lg-6">
                                    <div class="cp-input-field">
                                  
                                       <input type="number" id="length" name="length" required placeholder="Length *" step="any" inputmode="decimal">
                                     
                                    </div>
                                 </div>
                                 <div class="col-xl-3 col-lg-6 ">
                                   <div class="custom-select" style="width:100%;">
                                          <select  name="unit">
                                          <option value="Inches">Inches</option>
                                          <option value="mm">MM</option>
                                          <option value="cm">CM</option>
                                  
                                       </select>
                                    </div>
                                 </div>
                                 
                                 
                                                    
          <div class="col-xl-6 col-lg-6 for-the-mobile">
              
              
              <div class="custom-select" style="width:100%;">
  <select name="stock" style=" ">
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
    
            <div class="col-xl-6 col-lg-6 for-the-mobile">
                                      <div class="custom-select" style="width:100%;">
                                       
<select class="form-control" name="coating" data-gtm-form-interact-field-id="0">
    <option>Select Paper Coating</option>
  <option value="Aqueous Coating">Aqueous Coating</option>
  <option value=" Semi Gloss"> Semi Gloss</option>
  <option value="Gloss UV">Gloss UV</option>
  <option value="Matte UV">Matte UV</option>
  <option value="Semi Matte">Semi Matte</option>
</select>
                                    </div>
                                 </div>
                                 
                                 
                                 
                                 <div class="col-xl-4 col-lg-4">
                                   <div class="custom-select" style="width:100%;    margin-top: 20px;">
                                      
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
                                      <div class="custom-select" style="width:100%;    margin-top: 20px;">
                                       
<select  name="cad_sample">
    <option>CAD Sample</option>
  <option value="Yes">Yes</option>
  <option value="No">No</option>
</select>
 
                                    </div>
                                 </div>
                                         
 
                                           
                                 <div class="col-xl-4 col-lg-6">
                                    <div class="cp-input-field" style="    margin-top: 20px;">
                                     
                                       <input type="text" id="length" name="qty" required placeholder="Quantity *">
                                           
                                    </div>
                                 </div>
                                 <div class="col-xl-4" style="margin-left: 230px;margin-bottom: px;">
                                   
                                          <input type="file" id="fileupload" name="image" style="margin-bottom: 20px;">
                                          
                                   
                                 </div>
                                    <div class="col-xl-12">
                                    <div class="cp-input-field">
                                   
                                       <input type="text" id="phone" name="message" placeholder="Your Message">
                                    
                                    </div>
                                 </div>
                              </div>
                           {{-- Lazy Load ReCAPTCHA to reduce TBT --}}
                           <div class="cp-quote-btn mb-10" style="    text-align: center;">
                               <div class="cp-input-field">
                                   <div class="g-recaptcha" id="product-detail-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}" data-callback="onProductDetailCaptchaSuccess"></div>
                                   <div id="product-detail-captcha-error" style="color: #fff; font-size: 14px; font-weight: bold; margin-top: 10px; display: none; padding: 12px; background: #dc3545; border-radius: 5px;">
                                       ⚠️ Please complete the reCAPTCHA verification before submitting
                                   </div>
                               </div>
                              <button type="submit" class="cp-border2-btn" style="background-color:#55990b; color:white;border-radius:10px !important;">Sent Quote</button>
                           </div>
                        </form>
                        
                        <script>
                        var productDetailCaptchaCompleted = false;
                        var recaptchaScriptLoaded = false;
                        
                        function onProductDetailCaptchaSuccess(token) {
                            productDetailCaptchaCompleted = true;
                            var errorDiv = document.getElementById('product-detail-captcha-error');
                            if (errorDiv) {
                                errorDiv.style.display = 'none';
                            }
                        }

                        function loadRecaptchaScript() {
                            if (recaptchaScriptLoaded) return;
                            recaptchaScriptLoaded = true;
                            
                            var script = document.createElement('script');
                            script.src = "https://www.google.com/recaptcha/enterprise.js";
                            script.async = true;
                            script.defer = true;
                            document.body.appendChild(script);
                        }

                        (function() {
                            function initProductDetailFormValidation() {
                                var form = document.querySelector('form[action*="product_form_submit"]');
                                var errorDiv = document.getElementById('product-detail-captcha-error');
                                
                                if (!form) return;

                                // Lazy Load Listeners (Interaction + Timeout)
                                var events = ['mouseenter', 'focusin', 'click', 'touchstart'];
                                events.forEach(function(e) {
                                    form.addEventListener(e, loadRecaptchaScript, { once: true, passive: true });
                                });
                                // Fallback: Load after 4 seconds to avoid TBT impact but ensure visibility
                                setTimeout(loadRecaptchaScript, 4000);
                                
                                form.onsubmit = function(event) {
                                    // Ensure script is loaded if they somehow bypassed listeners and timeout (unlikely)
                                    if (!recaptchaScriptLoaded) {
                                        loadRecaptchaScript();
                                        event.preventDefault(); 
                                        return false;
                                    }

                                    if (!productDetailCaptchaCompleted) {
                                        event.preventDefault();
                                        event.stopPropagation();
                                        
                                        if (errorDiv) {
                                            errorDiv.style.display = 'block';
                                            errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                        }
                                        
                                        return false;
                                    }
                                    
                                    // Double check grecaptcha object availability
                                    if (typeof grecaptcha !== 'undefined' && typeof grecaptcha.getResponse === 'function') {
                                        try {
                                            var response = grecaptcha.getResponse();
                                            if (!response || response.length === 0) {
                                                event.preventDefault();
                                                event.stopPropagation();
                                                if (errorDiv) {
                                                    errorDiv.style.display = 'block';
                                                    errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                                }
                                                productDetailCaptchaCompleted = false;
                                                return false;
                                            }
                                        } catch(e) {
                                            // Ignore if getResponse fails (e.g. not rendered yet), let server handle or validation fail
                                        }
                                    }
                                    
                                    if (errorDiv) {
                                        errorDiv.style.display = 'none';
                                    }
                                    
                                    return true;
                                };
                            }
                            
                            if (document.readyState === 'loading') {
                                document.addEventListener('DOMContentLoaded', initProductDetailFormValidation);
                            } else {
                                initProductDetailFormValidation();
                            }
                        })();
                        </script>

                     </div>
                  </div>
                    </div>
                </div>
                <div class="product_info-faq-area pb-0 pt-20">
                    <div class="product-details-tab-wrapper">
                        <nav class="product-details-nav mb-60">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="pro-info-1-tab" data-bs-toggle="tab" href="#pro-info-1" role="tab" aria-selected="true"> SPECIFICATION</a>
                                <!--<a class="nav-item nav-link" id="pro-info-2-tab" data-bs-toggle="tab" href="#pro-info-2" role="tab" aria-selected="false">Description</a>-->
                                <a class="nav-item nav-link  hide-on-mobile" id="pro-info-3-tab" data-bs-toggle="tab" href="#pro-info-3" role="tab" aria-selected="false">BOX FEATURES</a>
                                 <a class="nav-item nav-link" id="pro-info-4-tab" data-bs-toggle="tab" href="#pro-info-4" role="tab" aria-selected="false">MATERIALS</a>
                                 <a class="nav-item nav-link  hide-on-mobile" id="pro-info-5-tab" data-bs-toggle="tab" href="#pro-info-5" role="tab" aria-selected="false">PRINTING METHODS</a>
                                 <a class="nav-item nav-link  hide-on-mobile" id="pro-info-6-tab" data-bs-toggle="tab" href="#pro-info-6" role="tab" aria-selected="false">INKS</a>
                                 <a class="nav-item nav-link " id="pro-info-7-tab" data-bs-toggle="tab" href="#pro-info-7" role="tab" aria-selected="false">FINISHING</a>
                                 <a class="nav-item nav-link hide-on-mobile" id="pro-info-8-tab" data-bs-toggle="tab" href="#pro-info-8" role="tab" aria-selected="false">ADD-ONS</a>


                            </div>
                        </nav>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="product-details-content mb-30">
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade active show" id="pro-info-1" role="tabpanel">
                                            <div class="tabs-wrapper">
                                                <div class="product__details-des">
                                                   
                                               <table class="table table-bordered category_product_tab_table specification">
                      <thead>
                       <tr style="background-color:#EAF6F0;">
                          <th scope="col" class="">Dimensions</th>
                          <th scope="col" class="bg_blue_table second_links">All Custom Sizes &amp; Shapes</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row" class="blue_no">Printing</th>
                          <td class="black_td">CMYK, PMS, No Printing</td>
                        </tr>
                  <tr style="background-color:#EAF6F0;">
                          <th scope="row" class="blue_no">Paper Stock</th>
                          <td class="black_td">10pt to 28pt (60lb to 400lb) Eco-Friendly Kraft, E-flute Corrugated, Bux Board, Cardstock</td>
                        </tr>
                         <tr>
                          <th scope="row" class="blue_no">Quantities</th>
                          <td class="black_td">100 - 500,000</td>
                        </tr>
                      <tr style="background-color:#EAF6F0;">
                          <th scope="row" class="blue_no">Coating</th>
                          <td class="black_td">Gloss, Matte, Spot UV</td>
                        </tr>
                         <tr>
                          <th scope="row" class="blue_no">Default Process</th>
                          <td class="black_td">Die Cutting, Gluing, Scoring, Perforation</td>
                        </tr>
                       <tr style="background-color:#EAF6F0;">
                          <th scope="row" class="blue_no">Options</th>
                          <td class="black_td">Custom Window Cut Out, Gold/Silver Foiling, Embossing, Raised Ink, PVC Sheet.</td>
                        </tr>
                         <tr>
                          <th scope="row" class="blue_no">Proof</th>
                          <td class="black_td">Flat View, 3D Mock-up, Physical Sampling (On request)</td>
                        </tr>
                      <tr style="background-color:#EAF6F0;">
                          <th scope="row" class="blue_no">Turn Around Time</th>
                          <td class="black_td">4-6 Business Days , Rush</td>
                        </tr>
                      </tbody>
                    </table>
                                                </div>
                                            </div>
                                        </div>
                                     
                                        <div class="tab-pane fade" id="pro-info-3" role="tabpanel">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                  <div class="container">
                    
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('3-Flaps-Tuck-Top-Lid.webp')}}" class="card-img-top" alt="3 Flaps Tuck Top Lid" loading="lazy" decoding="async" width="300" height="200">
                                  <div class="card-body">
                                    <p class="card-text" style="text-align:justify;">This style of folding cartons has three tab locks on the top lid that tuck in to close the box. These flaps tuck into the holes for closing the product without the need for any adhesive or glue.
</p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('Cherry locks.webp')}}" class="card-img-top" alt="Cherry locks" loading="lazy" decoding="async" width="300" height="200">
                                  <div class="card-body">
                                    <p class="card-text" style="text-align:justify;">Cherry locks, also known as friction locks or snap locks, contain two ear-shaped flaps. These flaps help to lock the box without the need for any adhesive or glue.
</p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('Roll End Tray.webp')}}" class="card-img-top" alt="Roll End Tray" loading="lazy" decoding="async" width="300" height="200">
                                  <div class="card-body">
                                    <p class="card-text" style="text-align:justify;">A Roll End Tray is also known as a walker lock tray or tray with self-locking ends. The tray folds over the side walls, and the small tabs fit into the slot, ensuring a secure closure without any adhesive. </p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('Tear Strip.webp')}}" class="card-img-top" alt="Tear Strip" loading="lazy" decoding="async" width="300" height="200">
                                  <div class="card-body">
                                    <p class="card-text" style="text-align:justify;">The tear strips are the kind of perforated line or strips you can pull to open a box without the need for any tool. The removed tear strip also leaves a mark that the box was opened.
</p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                           <div class="card" style="margin-top:20px;margin-bottom:20px;">
                              <img src="{{url('Tuck Top Lid.webp')}}" class="card-img-top" alt="Tuck Top Lid" loading="lazy" decoding="async" width="300" height="200">
                              <div class="card-body">
                                <p class="card-text" style="text-align:justify;">The tuck top lid is hinged to the box base that contains a flap on the top. The flap tucks into the slot to secure the box. This style is commonly used for folding cartons, corrugated boxes and mailer boxes.
</p>
                              </div>
                        </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('Perforation.webp')}}" class="card-img-top" alt="Perforation" loading="lazy" decoding="async" width="300" height="200">
                                  <div class="card-body">
                                    <p class="card-text" style="text-align:justify;">Perforation in packaging contains small holes or cuts that facilitate easy opening, product ventilation, moisture control, and portioning. It makes it easy to tear the material.
</p>
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
                
               
                                                </div>
                                            </div>
                                        </div>
                                        
                                         <div class="tab-pane fade" id="pro-info-4" role="tabpanel">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                  
                    <div class="container">
                  
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img data-src="{{url('material/black-kraft.webp')}}" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='200'%3E%3C/svg%3E" class="card-img-top lazy-tab-img" alt="Black Kraft" loading="lazy" decoding="async" width="300" height="200">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Black Kraft</p>
                                       <p style="text-align:justify;">It is a clean and attractive solid black color. That is depicting a touch of luxury. It is eco-friendly yet printable. Mostly foil printings are a perfect option for them.</p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('material/card-stock.webp')}}" class="card-img-top" alt="Card Stock">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Card Stock</p>
                                    <p style="text-align:justify;">This is thicker than normal paper and is used for making postcards. Cardstock paper can be coated or uncoated.</p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('material/holographic.webp')}}" class="card-img-top" alt="Holographic">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Holographic</p>
                                       <p style="text-align:justify;">These are famous and widely used in the cosmetic and apparel industry. It gives 3D effects from any angle to create attractive packaging.</p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('material/grey-chipboard.webp')}}" class="card-img-top" alt="Grey Chipboard">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Grey Chipboard</p>
                                    <p style="text-align:justify;">It is made from recycled material, also known as uncoated recycled paperboard. This is mainly used for its sturdiness and thickness.</p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                           <div class="card" style="margin-top:20px;margin-bottom:20px;">
                              <img src="{{url('material/mettalic.webp')}}" class="card-img-top" alt="Mettalic">
                              <div class="card-body">
                                <p class="card-text" style="font-size: 17px;font-weight: 500;">Mettalic</p>
                                <p style="text-align:justify;">
                                    Metallic paper features a high-gloss metallic look, with excellent printability features, strong fold and tear-resistant, and is specifically used for premium packaging.
                                </p>
                              </div>
                        </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('material/natural-brown -craft.webp')}}" class="card-img-top" alt="Natural Brown Kraft">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Natural Brown Kraft</p>
                                     <p style="text-align:justify;">It is popular among those with eco-conscious brands and organic products. This material offers a rustic, earthy look. which gives them a feel of nature and sustainable packaging.</p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('material/textured-material.webp')}}" class="card-img-top" alt="Textured Material">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Textured Material</p>
                                    <p  style="text-align:justify;">
                                        These papers have an uneven texture that is appealing. Mostly, these surfaces work great for embossing and debossing purposes.

                                    </p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('material/white-craft.webp')}}" class="card-img-top" alt="White Kraft">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">White Kraft</p>
                                    <p style="text-align:justify;">The strength of Kraft and a clean, natural appearance are a great combination. White Kraft is often used where brands want an eco-friendly appearance but with a bright, printable surface.</p>
                                  </div>
                            </div>
                        </div>
                        
                           <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('materials/Bux-Board.webp')}}" class="card-img-top" alt="White Kraft">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Bux Board</p>
                                    <p style="text-align:justify;">Bux Board is a thick type of paperboard made from recycled paper stock. It is an eco-friendly and durable material for the packaging of fragile and retail products. Available in thicknesses of  10pt to 28pt. </p>
                                  </div>
                            </div>
                        </div>
                        
                          <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('materials/Cardboard.webp')}}" class="card-img-top" alt="White Kraft">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Cardboard</p>
                                    <p style="text-align:justify;">Cardboard is a durable material made from paper pulp or recycled fibres. It is a budget-friendly material ideal for e-commerce products, shipping boxes, and product packaging. Available in thicknesses of 10pt to 28pt.
</p>
                                  </div>
                            </div>
                        </div>
                          <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('materials/Coated-Paper.webp')}}" class="card-img-top" alt="White Kraft">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Coated Paper</p>
                                    <p style="text-align:justify;">Coated paper is a paper material treated with a coating to improve its smoothness, brightness, and printable surface. The coating for this material is made from clay, chalk, or other materials. Ideal for premium product packaging and food packaging.
</p>
                                  </div>
                            </div>
                        </div>
                        
                        
                         <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('materials/Corrugate-cardboard.webp')}}" class="card-img-top" alt="White Kraft">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Corrugate Cardboard</p>
                                    <p style="text-align:justify;">Corrugated Cardboard is a triple-layered material made by corrugating a layer between the two cardboard layers. The inner layer may be Kraft, recycled paper, or test paper. It is sturdy enough for the packaging and shipping of heavyweight items.
</p>
                                  </div>
                            </div>
                        </div>
                     
                     <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('materials/PaperBoard.webp')}}" class="card-img-top" alt="White Kraft">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Paper Board</p>
                                    <p style="text-align:justify;">Paperboard is a durable paper-based material thicker than paper. This material is made from virgin wood fibres or recycled materials, ideal for product packaging. 
</p>
                                  </div>
                            </div>
                        </div>
                        
                        
                         <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('materials/Rigid-Stock.webp')}}" class="card-img-top" alt="White Kraft">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Rigid Stock</p>
                                    <p style="text-align:justify;">Rigid Stock is a luxury material resulting from the blending of card stock and paper stock. It is a high-quality, non-bending, and sturdy material for the packaging of luxury and limited-edition products like watches, jewelry, and gift items.
</p>
                                  </div>
                            </div>
                        </div>
                        
                          <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('materials/Wax-Paper.webp')}}" class="card-img-top" alt="White Kraft">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Wax Paper</p>
                                    <p style="text-align:justify;">Wax Paper is made from cellulose that has a food-safe coating resistant to fats and oils. This paper material is ideal for food packaging and take-out orders to prevent grease and oil from spoiling the carry bags.
</p>
                                  </div>
                            </div>
                        </div>
                        
                        
                        
                        
                       
                    </div>
                </div>
               
                                                </div>
                                            </div>
                                        </div>
                                        
                                          <div class="tab-pane fade" id="pro-info-5" role="tabpanel">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                  
                     <div class="container">
                  
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('Offset Print.webp')}}" class="card-img-top" alt="Offset Print">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Offset Printing</p>
                                     <p style="text-align:justify;"> Offset lithography is a three-step method of commercial printing. It works on the principle that oil and water repel each other. It uses three cylinders. It transfers the image from the printing plate to the rubber plate, then to the paper.</p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('Digital Print.webp')}}" class="card-img-top" alt="Digital Print">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Digital Print</p>
                                    <p style="text-align:justify;">
                                        Digital Printing is a modern printing process that does not use a printing plate. It transfers the image directly onto the paper using CMYK inks. It is Ideal for printing on cardstock, folding cartons, fabrics, plastic, and synthetic substrates.

                                    </p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('UV Print.webp')}}" class="card-img-top" alt="UV Print">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">UV Print</p>
                                    <p style="text-align:justify;">UV printing is a fast digital printing technique that uses high-intensity UV lamps to dry and cure the ink. This technique is ideal for 3D printing on cylindrical objects like cups and bottles. The ink does not smudge on the paper.
</p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('Scodix Digital Enhancement.webp')}}" class="card-img-top" alt="Scodix Digital Enhancement">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Scodix Digital Enhancement</p>
                                    <p style="text-align:justify;">
                                        This printing technique applies premium and high-quality digital embellishments and finishes to printed materials. It creates 3D effects, foiling, and metallic textures directly onto the paper without using plates or molds. Best for packaging, business and greeting cards, and book covers.

                                    </p>
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
               
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                          <div class="tab-pane fade" id="pro-info-6" role="tabpanel">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                  
                     <div class="container">
                  
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('Water-based Inks.webp')}}" class="card-img-top" alt="Water-based Inks">
                                  <div class="card-body">
                                
                                     <p class="card-text" style="font-size: 17px;font-weight: 500;">Water-based Inks</p>
                                    <p style="text-align:justify;">Sustainable and responsible alternative to traditional solvent-based inks. The water-based inks use water as the main solvent. They are made from water, acrylic resins, and organic solvents that quickly absorb into the fabric. They produce rich, high-quality, and colorful prints.</p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('Soy Vegetable Based Inks.webp')}}" class="card-img-top" alt="Soy/Vegetable Based Inks">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Soy/Vegetable Based Inks</p>
                                     <p style="text-align:justify;">Vegetable inks are renewable and recyclable inks made with vegetable oil, soybean oil, or corn oil. They are an eco-friendly alternative to petroleum-based inks that reduce the VOCs (Volatile Organic Compounds) in the air while printing.
</p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('Fluorescent Color Inks.webp')}}" class="card-img-top" alt="Fluorescent Color Inks">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Fluorescent Color Inks</p>
                                    <p style="text-align:justify;"> The fluorescent color inks make the printing glow extra bright. The special ink has tiny glowing bits that make the designs pop on the substrates. The main fluorescent colors for inks include pink, green, orange, yellow, and blue. 
</p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('Oil Based Inks.webp')}}" class="card-img-top" alt="Oil Based Inks">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Oil Based Inks</p>
                                     <p style="text-align:justify;">Oil based inks are composed of soybean, vegetable, or mineral oils, hydrocarbons, and pigments. These inks are famous for their vibrant colors, excellent adhesion, longevity, and rich color output. They are great for printing on folding cartons, mailers, and paper bags.
 </p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('Pantone.webp')}}" class="card-img-top" alt="Pantone">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Pantone</p>
                                     <p style="text-align:justify;">
                                         Inks based on the PMS, which is a standardized color reproduction system. These inks are pre-mixed spot colors resulting from a precise ink formula. Each color is assigned a PMS number on the Pantone color chart. Best for company logos.

                                     </p>
                                    
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('Pantone Metallic.webp')}}" class="card-img-top" alt="Pantone Metallic">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Pantone Metallic</p>
                                         <p style="text-align:justify;">
                                             Pantone metallic inks are special printing inks that add a metallic shine to the printed materials. These inks contain fine metal flakes like aluminum and brass to ensure an eye-catching metallic effect in packaging. 

                                         </p>
                                    
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
               
                                                </div>
                                            </div>
                                        </div>
                                        
                                          <div class="tab-pane fade" id="pro-info-7" role="tabpanel">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                       <div class="container">
                   
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('finishing/anti-scratch -lamination.webp')}}" class="card-img-top" alt="Anti Scratch Lamination">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Anti Scratch Lamination</p>
                                    <p style="text-align:justify">BOPP (biaxially oriented polypropylene) lamination, which resists scratches, scuffs, and fingerprints. Provides a smooth finish with added protection for boxes that are handled heavily.</p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('finishing/aqueous-Coating.webp')}}" class="card-img-top" alt="Aqueous Coating">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Aqueous Coating</p>
                                     <p style="text-align:justify">A fast-drying, water-based finish that provides light protection and a clean surface feel. Comes in gloss or matte, this eco-friendly coating is great for boxed printed pieces and also resists fingerprints and minor scuffs.</p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('finishing/lamination- finishing.webp')}}" class="card-img-top" alt="Lamination Finishing">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Lamination Finishing</p>
                                     <p style="text-align:justify">A thin film is layered onto the surface of the box to improve durability and moisture resistance. Perfect for protecting full-color designs and maintaining box integrity through shipping or retail handling.</p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('finishing/matte-lamination.webp')}}" class="card-img-top" alt="Matte Lamination">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Matte Lamination</p>
                                     <p style="text-align:justify">Adds a velvet touch to your packaging, leaving a soft matte surface that feels premium to the touch. This is ideal for brands that are interested in a more physical, elegant unboxing experience where shine and glare have been removed.</p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('finishing/soft-touch- coating.webp')}}" class="card-img-top" alt="Soft Touch Coating">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Soft Touch Coating</p>
                                     <p style="text-align:justify">Adds a velvet touch to your packaging, leaving a soft matte surface that feels premium to the touch. This is ideal for brands that are interested in a more physical, elegant unboxing experience where shine and glare have been removed.</p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('finishing/soft-touch-silk- lamination.webp')}}" class="card-img-top" alt="Soft Touch Silk Lamination">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 16px;font-weight: 500;">Soft Touch Silk Lamination</p>
                                    <p style="text-align:justify">It combines the soft-touch feel of a paper with the durability of lamination. It is available in matte or satin and provides a luxurious finish, making it a great option for retail and subscription packaging.</p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('finishing/spot-glass-uv.webp')}}" class="card-img-top" alt="Spot Glass UV">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Spot Glass UV</p>
                                       <p style="text-align:justify">Gloss coating is applied to specific areas of the print, contributing contrast and focus. Commonly used on logos or text to create shine against a matte background. Coating is UV cured to allow for durability.</p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('finishing/varnish.webp')}}" class="card-img-top" alt="Varnish">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Varnish</p>
                               <p style="text-align:justify">A clear coating that adds shine, smoothness, and print protection. It can be applied with CMYK presses and comes in gloss, satin, or matte finishes. Great for making colors pop and keeping expenses low.</p>
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
                
               
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                          <div class="tab-pane fade" id="pro-info-8" role="tabpanel">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                     <div class="container">
               
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('adones/natural-kraft paperboard-insert.webp')}}" class="card-img-top" alt="Natural Kraft Paperboard Insert">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Natural Kraft Paperboard Insert</p>
                                     <p style="text-align:justify;">Inserts or compartments made of 100% recyclable material that offer cushioning in the shipping boxes. This material is a blend of virgin and recycled paper pulp that gives a natural brown color. Available in thickness from 12 pt. to 28 pt.</p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('adones/folding-carton box-divider-inserts.webp')}}" class="card-img-top" alt="Folding Carton Box Divider Inserts">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Folding Carton Box Divider Inserts</p>
                                    <p style="text-align:justify;"> 
                                    These inserts are custom-fitted to secure products in place, protect fragile products that need extra protection. They are made from paperboard, which makes them great for cosmetics, pharmaceuticals, and food packaging.

                                    </p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('adones/natural-craft corrugated-insert.webp')}}" class="card-img-top" alt="Natural Kraft Corrugated Insert">
                                  <div class="card-body" > 
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Natural Kraft Corrugated Insert</p>
                                   <p style="text-align:justify;"> 
                                        These inserts are made from unbleached Kraft corrugated material. They keep the things in place in the packaging and offer a cushioning effect. These inserts are best for organizing fragile items, foods, electronics, and glassware.

                                    </p>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('adones/corrugated-box divider-inserts.webp')}}" class="card-img-top" alt="Corrugated Box Divider Inserts">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Corrugated Box Divider Inserts</p>
                                     <p style="text-align:justify;"> 
                                        These inserts are made of durable corrugated cardboard to divide the interior space of the box. These dividers keep the products in their place, separate from each other, and protect fragile items. 

                                    </p>
                                  </div>
                            </div>
                        </div>
                         <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('adones/pvc-patching-cards.webp')}}" class="card-img-top" alt="Corrugated Box Divider Inserts">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">PVC Patching Cards
</p>
                                     <p style="text-align:justify;"> 
                                       PVC patching cards are made from Polyvinyl chloride, which is a waterproof material. They are suitable for outdoor application. They allow Pantone color matching and 3D design elements that deliver temporary information.
 

                                    </p>
                                  </div>
                            </div>
                        </div>
                        
                        
                           <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('adones/ribbon- handles.webp')}}" class="card-img-top" alt="Corrugated Box Divider Inserts">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Ribbon Handles
</p>
                                     <p style="text-align:justify;"> 
Ribbon handles are soft and fabric straps that are added to the paper bags carrying paper bags and add a stylish look. The ribbons are of cotton or satin material, perfect for shopping bags, gift bags, and other types of packaging.
 

                                    </p>
                                  </div>
                            </div>
                        </div>
                              <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('adones/Embossing.webp')}}" class="card-img-top" alt="Corrugated Box Divider Inserts">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Embossing

</p>
                                     <p style="text-align:justify;"> 
Embossing raises the branding and design elements on the surface of packaging. The customer can touch and feel the raised elements. This leaves a lasting impression on their sensory memory about your brand.

 

                                    </p>
                                  </div>
                            </div>
                        </div>
                        
                         <div class="col-md-3">
                            <div class="card" style="margin-top:20px;margin-bottom:20px;">
                                  <img src="{{url('adones/debossing.webp')}}" class="card-img-top" alt="Corrugated Box Divider Inserts">
                                  <div class="card-body">
                                    <p class="card-text" style="font-size: 17px;font-weight: 500;">Debossing

</p>
                                     <p style="text-align:justify;"> 
Debossing is the opposite of embossing. In this technique, the design and branding elements are imprinted into the packaging. The imprinted design makes the customers interested in the packaging. 

 

                                    </p>
                                  </div>
                            </div>
                        </div>
                        
                        
                        
                        
                    </div>
                </div>
                
               
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="cp-cta2-area pt-10 pb-10 cp-video-overlay bg-fixed bg-css " style="height: 70px;">
         <div class="container"> 
            <div class="cp-cta2-wrap scene d-flex align-items-center justify-content-between flex-wrap flex-xl-nowrap ow fadeInUp animated" data-wow-duration="2.3s" data-wow-delay="0.3s">
               <div class=" cp-cta2-title mb-15">
                  <p style="font-size:20px;color:white;">More Orders, More Savings! <span style="font-size: larger;color: #85c83f;"> Get 30% Off </span>On Bulk Orders !</p>
               </div>
               <div class="cp-cta2-btn mb-20" style="margin-top: -5px;">
                  <div class="cp-header-btn d-none d-md-block">
                           <a class="cp-btn" href="https://www.myboxprinting.com/get-quote/" style="background:#86C342;">
                         Order Now
                              
                           </a>
                        </div>
                
                  
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
</style>
 <section class="mt-20">
        <div class="container">
    <div class="row">
        <div class="col-md-12 custom-scrollbar" style="height: 500px; overflow-y: auto;padding: 10px;">
            <?php echo $get_product_data[0]->prod_long_desc ; ?>
        </div>
    </div>
</div>

                   </section>        
                   
                   
                     <section class="cp-feature-area p-relative cp-bg-2 zi-1 pt-10 pb-10 mt-20" style="background-color:#D3F3E6 !important;">
         
         <div class="container">
             
              <div class="row justify-content-center">
               <div class="col-xl-12 col-lg-12">
                        <div class="cp-cta2-title mb-0 pt-30" >
            <p style="font-size: 30px; color: rgb(33 37 41 / var(--tw-text-opacity,1)); margin-top: -10px;    font-weight: 600;">Order a Sample Kit
           <span class="hide-on-mobile separator-text" style="font-weight: 100;">Order a MyBoxPrinting Sample Kit to see our premium materials and print quality firsthand.</span>
            
            </p>
            </div>
            </div>
            
        
            <div class="row">
      
               <div class="col-xl-8 col-lg-8 col-sm-6">
                 
                    <div class="cp-quote-wrapperss" style="">
                    
                     <div class="cp-quote-form">
                        <form action="{{url('sample_kit').'/'}}" method="post" id="sample-kit-form">
                     
                            @csrf
                           <div class="cp-quote-box mb-10">
                              
                               @if(Session::has('message_for_kit'))
                               <div class="alert alert-info" style="background-color: #86C342; color: white; border: none; margin-bottom: 20px;">
                                   {{ Session::get('message_for_kit') }}
                               </div>
                               @endif

                              <div class="row">
                                 <div class="col-lg-4">
                                    <div class="cp-input-field">
 
                                       <input type="text" id="name" name="name" required placeholder="Name *">
                                       
                                    </div>
                                 </div>
                                 <div class="col-lg-4">
                                    <div class="cp-input-field">
                                
                                       <input type="email" id="email" name="email" required placeholder="Email *">
                               
                                    </div>
                                 </div>
                                 <div class="col-lg-4">
                                    <div class="cp-input-field">
                                    
                                       <input type="tel" id="phone" name="phone"  placeholder="Phone Number" pattern="^\+?\d*$" inputmode="tel" oninput="this.value=this.value.replace(/(?!^)\+/g,'').replace(/[^0-9+]/g,'')">
                                  
                                    </div>
                                 </div>
                              
                           
                                 
                                   <div class="col-xl-4 col-lg-4">
                                    <div class="cp-input-field">
                                     
                                       <input type="text" id="width" name="companyname" placeholder="Company Name" >
                                    
                                    </div>
                                 </div>
                                 <div class="col-xl-4 col-lg-4">
                                    <div class="cp-input-field">
                                       <input type="text" id="height" name="website" placeholder="Website">
                                      
                                    </div>
                                 </div>
                                 <div class="col-xl-4 col-lg-4">
                                    <div class="cp-input-field">
                                      
                                       <input type="text" id="length" name="physicaladdress" placeholder="Physical Address">
                                       
                                    </div>
                                 </div>
                                  <div class="col-xl-4 col-lg-4">
                                    <div class="cp-input-field"> 
                                       <input type="text" id="length" name="qty" placeholder="Quantity">
                                     
                                    </div>
                                 </div>
                                 
                

    
                                <?php $pp=DB::table('products')->get();?>
                    
          <div class="col-xl-4 col-lg-4">
              
              
              <div class="custom-select " style="width:100%;">
  <select name="prodname" style=" ">
       <option value="">Select Your Box Style</option>
   @foreach($pp as $p)
            <option value="{{$p->prod_name}}">{{$p->prod_name}}</option>
        @endforeach
  </select>
</div>
 

 
                                       
                                       
                                       
 
    </div>
    
       <div class="col-xl-4 col-lg-4 for-the-mobile">
                                    <div class="cp-input-field"> 
                                       <input type="text" id="length" name="msg" placeholder="Message">
                                     
                                    </div>
                                 </div>
                                 
                                 
  
  
                   
                              </div>
                           </div>

                            <div class="cp-quote-btn mb-10" style="text-align: center;">
                                <div class="cp-input-field">
                                    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}" data-callback="onSampleKitCaptchaSuccess"></div>
                                    <div id="sample-kit-captcha-error" style="color: #fff; font-size: 14px; font-weight: bold; margin-top: 10px; display: none; padding: 12px; background: #dc3545; border-radius: 5px;">
                                        ⚠️ Please complete the reCAPTCHA verification before submitting
                                    </div>
                                </div>
                               <button type="submit" class="cp-border2-btn" style="background-color:#86C342; color:white;">Order Now</button>
                            </div>
                        </form>
                        <script>
                        var sampleKitCaptchaCompleted = false;
                        function onSampleKitCaptchaSuccess(token) {
                            sampleKitCaptchaCompleted = true;
                            document.getElementById('sample-kit-captcha-error').style.display = 'none';
                        }
                        
                        document.getElementById('sample-kit-form').onsubmit = function(event) {
                            if (!sampleKitCaptchaCompleted) {
                                event.preventDefault();
                                document.getElementById('sample-kit-captcha-error').style.display = 'block';
                                return false;
                            }
                        };
                        </script>
                     </div>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-sm-6" style="text-align:center;">
                   <img src="{{url('custom-boxes-sample-kit.webp')}}" style="height:300px;margin-top:0px;" alt="box-sample-kit" loading="lazy" decoding="async" width="300" height="300">
               </div>
            </div>
         </div>
      </section>
                            
                            <style>
                                .cp-faq-wrap .accordion-item:last-of-type .accordion-button.collapsed{
                                    height: 20px;
                                }
                                .cp-faq-wrap .accordion-button::after{
                                    top: 10px !important;
                                }
                            </style>            
        <!-- shop details area end  -->
<?php if(count($faqtable) >0  ){?>
        <!-- faq area start here  -->
        <section class="cp-faq-area cp-bg-14 pt-30 pb-30">
            <div class="container">
                      <section class="cp-services-area pb-20 p-relative z-index-1 mt--20 pt-20" >
         
         <div class="container">
            <div class="row align-items-end">
                
                  
<div class="cp-cta2-title mb-0 pt-20" >
 <p style="font-size: 30px; color: rgb(33 37 41 / var(--tw-text-opacity,1)); margin-top: -10px;    font-weight: 600;">FAQ's <span class="separator-text" style="font-weight: 100;">Explore answers to some relevant questions about creating a custom box. If you've any query, feel free to <a href="{{url('contact-us/').'/'}}" style="color:#85C241;">contact us!</a></span>
                <span class="" style="  font-size:17px;  font-weight: 600;color:#86C342;">
              
                </span>
              </p>
</div>

</div></div>

 </section> 
      
                        <div class="cp-faq-wrap cp-faq-p-space-right">
                            <div class="accordion" id="accordionExample">
                                
                                <div class="row">
                                    
                                    
                                       <?php $sr=0; foreach ($faqtable as $pro_faq){ $sr++; ?>
 
                    <div class="col-lg-6">
                                    
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo1<?php echo $sr ?>">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo1<?php echo $sr ?>" aria-expanded="false" aria-controls="collapseTwo1<?php echo $sr ?>">        <?php echo $pro_faq->question; ?>  </button>
                                    </h2>
                                    <div id="collapseTwo1<?php echo $sr ?>" class="accordion-collapse collapse" aria-labelledby="headingTwo1<?php echo $sr ?>" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">   <?php echo $pro_faq->answer; ?></div>
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
        <!-- faq area end here  -->
        
            <section class="cp-services-area pb-20 p-relative z-index-1 mt--20 pt-20 hide-on-mobile" >
         
         <div class="container">
            <div class="row align-items-end">
                
                  <style>.separator-text::before{margin-left: 10px;}</style>
<div class="cp-cta2-title mb-0 pt-20 mt-20" >
 <p style="font-size: 30px; color: rgb(33 37 41 / var(--tw-text-opacity,1)); margin-top: -20px;    font-weight: 600;">Customer Reviews<span class="separator-text" style="font-weight: 100;">
  See why clients trust us through their honest, real feedback read MyBoxPrinting reviews
 </span>
                <span class="" style="  font-size:17px;  font-weight: 600;color:#86C342;">
              
                </span>
              </p>
</div>

</div>
      <div class="d-none d-sm-block">
         <div class="cp-testimonial2-nav cp-slider-round-button-wrap d-flex justify-content-end cp-test-space zi-5 p-relative">
            <div class="cp-slider-round-button cp-testimonial2-button-prev"><i class="fas fa-chevron-left"></i></div>
            <div class="cp-slider-round-button cp-testimonial2-button-next"><i class="fas fa-chevron-right"></i></div>
         </div>
      </div>
      </div>

 </section> 
 
 
 
  
 <section class="cp-testimonial2-area pt-20 pb-20 hide-on-mobile">
   <div class="container">
      <div class="row">
         <div class="swiper-container cp-testimonial2-active">
            <div class="swiper-wrapper">
               @foreach ($our_testimonial as $testimonial_slider)
               <div class="swiper-slide col-md-6 col-12" style="    background-color: #F6F9FE;
    border-radius: 20px;">
                  <div class="cp-testimonial2-item-wrap mb-20">
                     <div class="cp-testimonial2-item">
                        <div class="cp-testimonial2-text p-relative">
                   
                         
                           <div class="cp-testimonial2-author" style="margin-inline-start:0px !important;">
                           <div>
                              <img src="{{ url('images').'/'.$testimonial_slider->slider_image }}" alt="{{ $testimonial_slider->main_title }}" style="width:60px;height:60px; border-radius:50px;" loading="lazy" decoding="async" width="60" height="60">
                           </div>
                          
                           <div class="cp-testimonial2-author-text">
                              <h3>{{ $testimonial_slider->main_title }}</h3>
                               <i class="fas fa-star" style="color: #FFD700;"></i>
                           <i class="fas fa-star" style="color: #FFD700;"></i>
                           <i class="fas fa-star" style="color: #FFD700;"></i>
                           <i class="fas fa-star" style="color: #FFD700;"></i>
                           <i class="fas fa-star" style="color: #FFD700;"></i>
                           </div>
                           
                        </div>
                        
                           <p><div class="cp-testimonial2-icon cp-testimonial2-icon2 p-absolute">
                                       <i class="fas fa-quote-right"></i>
                                    </div>{{ $testimonial_slider->slider_description }}
                                    <div class="cp-testimonial2-icon cp-testimonial2-icon1 p-absolute">
                                       <i class="fas fa-quote-right"></i>
                                    </div>
                                    </p>
                        </div>
                        
                     </div>
                  </div>
               </div>
               @endforeach
            </div>
         </div>
      </div>

      <!-- Navigation Buttons -->

   </div>
</section>

   <section class="cp-services-area pb-20 p-relative z-index-1 mt--20 pt-20 hide-on-mobile" >
         
         <div class="container">
            <div class="row align-items-end">
                
                  
<div class="cp-cta2-title mb-0 pt-20" >
 <p style="font-size: 30px; color: rgb(33 37 41 / var(--tw-text-opacity,1)); margin-top: -10px;    font-weight: 600;">Related and Inspiring Product <span class="separator-text" style="font-weight: 100;">Discover products that inspire and elevate your business.  </span>
                <span class="" style="  font-size:17px;  font-weight: 600;color:#86C342;">
              
                </span>
              </p>
</div>

</div></div>

 </section> 
        <!-- shop related product area start  -->
        <section class="cp-related-product pt-50 pb-50 ">
            <div class="container">
               
                <div class="row">
                        @foreach ($rel_prod as $eachProd)    
                        
                        
                   <div class="col-xl-3 col-sm-6 col-6">
                                    <div class="cp-services-item t-center mb-30 ">
                                       
                                       
                                       
                             <a href="{{ url(str_replace(' ','-', strtolower($eachProd->prod_url))).'/'}}" class="">
                                        <div class="cp-services-img w-img">
                                            
                                                                        
                                                                        
                                                                        
                                      <?php $images = json_decode($eachProd->prod_gallery);
                                                                
                                                                $i = 1;
                                                            ?>
                                        
                                                          @if(!empty($images))  
                                                                    <img class="pic-ss1" src="<?php foreach($images as $key=>$value){if($i==1){echo url('images/'.$value);}$i++;} ?>" alt="{{$eachProd->prod_name}}" loading="lazy" decoding="async" width="300" height="300" />

                                                           @endif
                                       
                                        </div>
                                                                                                              </a>
                                        <div class="product-description" style="background-color:#EAF6F0 !important;">
                                            <h4 class="product-name">
                                                <a href="{{ url(str_replace(' ','-', strtolower($eachProd->prod_url))).'/'}}"> <?php  echo  $eachProd->prod_name;?></a>
                                            </h4>
                                             
                                        </div>
                                    </div>
                                </div>
                                     @endforeach 
                                
                                
                                
                </div>
            </div>
        </section>
 

    </main>
    
    <!-- Load non-critical CSS deferred -->
    <link rel="stylesheet" href="{{ asset('box_assets/css/product-page-deferred.css') }}" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="{{ asset('box_assets/css/product-page-deferred.css') }}"></noscript>
    
    @include('frontend/footer')
<script>
   document.addEventListener('DOMContentLoaded', function() {
       if (typeof Swiper !== 'undefined') {
           var swiper = new Swiper('.cp-testimonial2-active', {
              slidesPerView: 2, // Show two testimonails per row
              spaceBetween: 30,
              loop:false,
              navigation: {
                 nextEl: '.cp-testimonial2-button-next',
                 prevEl: '.cp-testimonial2-button-prev',
              },
              breakpoints: {
                 768: { slidesPerView: 2 }, // 2 slides on tablets and above
                 576: { slidesPerView: 1 }  // 1 slide on small screens
              }
           });
           
           // Initialize Product Thumbnails Swiper
            var productThumbsSwiper = new Swiper('.prod-sm-items-swiper', {
               slidesPerView: 4,
               spaceBetween: 10,
               loop: true,
               navigation: {
                   nextEl: '.swiper-button-next',
                   prevEl: '.swiper-button-prev',
               },
               breakpoints: {
                   0: { slidesPerView: 3, spaceBetween: 5 },
                   480: { slidesPerView: 3, spaceBetween: 8 },
                   768: { slidesPerView: 4, spaceBetween: 10 },
                   1024: { slidesPerView: 5, spaceBetween: 10 }
               }
           });

           // Handle thumbnail click with delegation for Swiper loop
            document.querySelector('.prod-sm-items-swiper').addEventListener('click', function(e) {
                if (e.target.classList.contains('gallery-thumbnail')) {
                    const newSrc = e.target.getAttribute('data-src');
                    const mainImage = document.getElementById('main-image');
                    if (mainImage && newSrc) {
                        mainImage.src = newSrc;
                    }
                }
            });
       }
   });
   
   // Optimize images for better LCP/FCP on mobile
   document.addEventListener('DOMContentLoaded', function() {
      // Add lazy loading to all tab images except first tab
      const tabPanes = document.querySelectorAll('.tab-pane:not(.active)');
      tabPanes.forEach(pane => {
         const images = pane.querySelectorAll('img:not([loading])');
         images.forEach(img => {
            img.setAttribute('loading', 'lazy');
            img.setAttribute('decoding', 'async');
            if (!img.hasAttribute('width')) {
               img.setAttribute('width', '300');
               img.setAttribute('height', '200');
            }
         });
      });

      // Lazy load tab content when clicked
      const tabLinks = document.querySelectorAll('.nav-link');
      const loadedTabs = new Set(['pro-info-1']);
      
      tabLinks.forEach(link => {
         link.addEventListener('click', function() {
            const targetId = this.getAttribute('href').substring(1);
            
            if (!loadedTabs.has(targetId)) {
               const tabPane = document.getElementById(targetId);
               if (tabPane) {
                  // Load images with data-src attribute
                  const lazyImages = tabPane.querySelectorAll('img.lazy-tab-img[data-src]');
                  lazyImages.forEach(img => {
                     if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        img.classList.remove('lazy-tab-img');
                     }
                  });
                  
                  // Also handle data-lazy-src
                  const images = tabPane.querySelectorAll('img[data-lazy-src]');
                  images.forEach(img => {
                     if (img.dataset.lazySrc) {
                        img.src = img.dataset.lazySrc;
                        img.removeAttribute('data-lazy-src');
                     }
                  });
                  loadedTabs.add(targetId);
               }
            }
         });
      });

      // Optimize related products images
      const relatedImages = document.querySelectorAll('.cp-related-product img');
      relatedImages.forEach(img => {
         if (!img.hasAttribute('loading')) {
            img.setAttribute('loading', 'lazy');
            img.setAttribute('decoding', 'async');
         }
      });

      // Defer non-critical interactions
       
       // Initialize read more/less functionality using event delegation
       document.addEventListener('click', function(e) {
          if (e.target && e.target.classList.contains('read-more')) {
             const wrapper = e.target.closest('.add-read-more');
             if (wrapper) {
                wrapper.classList.remove('show-less-content');
                wrapper.classList.add('show-more-content');
             }
          }
          if (e.target && e.target.classList.contains('read-less')) {
             const wrapper = e.target.closest('.add-read-more');
             if (wrapper) {
                wrapper.classList.remove('show-more-content');
                wrapper.classList.add('show-less-content');
             }
          }
       });
   });
</script>
