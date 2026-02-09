@php $isBlogPage = true; @endphp
@include('frontend/header')
 
 
<!-- Critical inline CSS for blog page above-the-fold content -->
<style>
/* Critical blog page styles - prevent FOUC and CLS */
.cp-news-details-area { padding: 40px 0; background: #fff; }
.container { max-width: 1200px; margin: 0 auto; padding: 0 15px; }
.row { display: flex; flex-wrap: wrap; margin: 0 -15px; }
.col-xl-8, .col-lg-7 { padding: 0 15px; }
@media(min-width:1200px) { .col-xl-8 { flex: 0 0 66.666667%; max-width: 66.666667%; } }
@media(min-width:992px) { .col-lg-7 { flex: 0 0 58.333333%; max-width: 58.333333%; } }
@media(max-width:991px) { .col-xl-8, .col-lg-7 { flex: 0 0 100%; max-width: 100%; } }

/* Blog title - LCP candidate */
.cp-news2-title {
    font-size: 26px;
    font-weight: 700;
    line-height: 1.3;
    margin-bottom: 25px;
    color: #212529;
    min-height: 35px;
    contain: layout;
    font-display: swap; /* Prevent invisible text */
}

/* Featured image container - LCP element */
.cp-news-details-img {
    position: relative;
    width: 100%;
    margin: 0; /* Remove white borders */
    overflow: hidden;
    border-radius: 0; /* Remove border radius for edge-to-edge */
    aspect-ratio: 16/9;
    background: #f5f5f5;
    contain: layout; /* Optimize rendering */
}

.cp-news-details-img img {
    width: 100%;
    height: 100%;
   
    display: block;
    image-rendering: -webkit-optimize-contrast; /* Faster rendering */
    image-rendering: crisp-edges;
}

/* Meta info */
.cp-news1-meta {
    display: flex;
    gap: 20px;
    margin-bottom: 25px;
    font-size: 14px;
    color: #666;
}

/* Content area */
.cp-news-details-content {
    margin-bottom: 40px;
}

.cp-news-details-text {
    font-size: 16px;
    line-height: 1.8;
    color: #333;
}

/* Mobile optimizations - Reorder for faster LCP */
@media (max-width: 768px) {
    /* Enable flexbox on parent container */
    .cp-news-details-wrap {
        display: flex;
        flex-direction: column;
    }
    
    /* Title appears after image on mobile */
    .cp-news2-title {
        font-size: 20px; /* Smaller for faster paint */
        min-height: 25px;
        order: 2;
        margin-bottom: 12px;
        line-height: 1.2;
        font-display: swap;
        contain: layout style paint;
    }
    
    /* Featured image appears first on mobile (LCP element) */
    .cp-news-details-img {
        aspect-ratio: auto; /* Let image determine height */
        margin: 0; /* Remove all margins/borders */
        order: 1;
        border-radius: 0; /* No border radius */
        will-change: auto; /* Optimize compositing */
        height: auto; /* Auto height for full image */
    }
    
    .cp-news-details-img img {
        object-fit: contain; /* Show full image */
        height: auto; /* Auto height */
        image-rendering: auto; /* Better quality on mobile */
    }
    
    /* Content comes after title */
    .cp-news-details-content {
        order: 3;
    }
    
    /* Reduce padding on mobile for faster FCP */
    .cp-news-details-area {
        padding: 0; /* Remove padding for edge-to-edge image */
    }
    
    .container {
        padding: 0; /* Remove padding for full-width image */
    }
    
    .cp-news-details-wrap {
        padding: 0; /* Remove padding */
    }
    
    /* Add padding back for text content */
    .cp-news2-title,
    .cp-news-details-content,
    .cp-news1-meta {
        padding: 0 10px; /* Add padding to text only */
    }
    
    /* Optimize meta section */
    .cp-news1-meta {
        gap: 12px;
        font-size: 13px;
        margin-bottom: 15px;
    }
    
    /* Hide non-critical elements initially */
    .hide-on-mobile {
        display: none !important;
    }
    
    /* Adjust header spacing on mobile */
    .page-title-area {
        padding-top: 85px !important;
        padding-bottom: 10px !important;
    }

    /* Mobile Breadcrumb Optimization */
    .breadcrumb-trail .trail-items {
        gap: 5px !important;
        flex-wrap: nowrap !important; /* Prevent wrapping */
        overflow: hidden;
    }
    
    .breadcrumb-trail .trail-item {
        font-size: 12px !important;
        white-space: nowrap;
    }
    
    /* Show title but truncate */
    .breadcrumb-trail .trail-end {
        display: block !important;
        max-width: 150px; /* Limit width */
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    /* Optimize sidebar rendering */
    .cp-news-sidebar {
        content-visibility: auto; /* Lazy render below fold */
    }
}

/* Prevent CLS for sidebar */
.cp-news-sidebar {
    min-height: 400px;
    contain: layout;
}

.cp-news-widget {
    margin-bottom: 40px;
}

/* Improved circular image styling for sidebar */
.cp-news-widget-post-img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
    background: #f5f5f5;
    border: 2px solid #e8e8e8;
    transition: all 0.3s ease;
}

.cp-news-widget-post-img:hover {
    border-color: #7ec435;
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(126, 196, 53, 0.2);
}

.cp-news-widget-post-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.cp-news-widget-post-item {
    display: flex;
    gap: 15px;
    align-items: flex-start;
}

.cp-news-widget-post-text {
    flex: 1;
    min-width: 0;
}

.cp-news-widget-post-text h4 {
    font-size: 15px;
    line-height: 1.4;
    margin-bottom: 8px;
}

.cp-news-widget-post-text h4 a {
    color: #212529;
    text-decoration: none;
    transition: color 0.3s ease;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.cp-news-widget-post-text h4 a:hover {
    color: #7ec435;
}

.cp-news-widget-meta {
    font-size: 13px;
    color: #666;
}

@media (max-width: 768px) {
    .cp-news-widget-post-img {
        width: 60px;
        height: 60px;
    }
    
    .cp-news-widget-post-text h4 {
        font-size: 14px;
    }
}
</style>

<style>
@media only screen and (max-width: 767px) {
 p {
    text-align: justify !important;
    text-justify: inter-word;
    word-break: break-word;
    hyphens: auto;
  }
}
@media only screen and (min-width: 768px) {
p{
         text-align:justify !important;
}
}
    h1 {
        text-align: left !important;
    font-size: 26px !important;
}
  h2 {
        text-align: left !important;
    font-size: 22px !important;
}
h3{
      text-align: left !important;
}
h4{
      text-align: left !important;
}
</style>
    
       <section class="page-title-area breadcrumb-spacing cp-bg-14" style="padding-top: 200px;background-color: #fff; padding-bottom: 20px;">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        @foreach($blog_detail as $post)
                        <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs" style="position: relative; z-index: 10;">
                            <ul class="trail-items" style="list-style: none; padding: 0; margin: 0; display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">
                                <li class="trail-item trail-begin">
                                    <a href="{{url('/')}}" style="color: #666; text-decoration: none; font-size: 14px;">
                                        <i class="fa fa-home" style="margin-right: 5px; color: #7ec435;"></i>Home
                                    </a>
                                </li>
                                <li class="trail-item" style="color: #999; font-size: 12px;">
                                    <i class="fa fa-chevron-right"></i>
                                </li>
                                <li class="trail-item">
                                    <a href="{{ url('blog').'/'}}" style="color: #666; text-decoration: none; font-size: 14px;">Blog</a>
                                </li>
                                <li class="trail-item" style="color: #999; font-size: 12px;">
                                    <i class="fa fa-chevron-right"></i>
                                </li>
                                <li class="trail-item trail-end">
                                    <span style="color: #7ec435; font-weight: 600; font-size: 14px;">{{ $post->t_title }}</span>
                                </li>
                            </ul>
                        </nav>
                        @break
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        
        <section class="cp-news-details-area white-bg pt-40 pb-40">
         <div class="container">
            <div class="row">
               <div class="col-xl-8 col-lg-7">
                  <div class="cp-news-details-wrap pr-30">
                      
                      
                      
                      
                          @foreach ($blog_detail as $singleItem)
                                 <h1 class="cp-news2-title mb-25">{{ $singleItem->t_title }}</h1>
                     <!-- Remove WOW animation for faster rendering -->
                     <div>
                        <div class="cp-news-details-img p-relative w-img">
                           <!-- Remove overlay for performance -->
                           @php
                               $featuredImage = $singleItem->t_featured_image;
                               $imageAlt = str_replace(['.', 'webp'], '', $featuredImage);
                           @endphp
                           <img src="{{asset('images/blog/'. $featuredImage)}}" 
                                alt="{{$imageAlt}}"
                                width="800"
                                height="450"
                                fetchpriority="high"
                                loading="eager"
                                decoding="async">
                        </div>
                        <div class="cp-news-details-content mb-40">
                           <div class="cp-news1-meta mb-25">
                              <span><a href="#">Emilly</a></span>
                              <span><?php 
$date = $singleItem->time; 
$formattedDate = date("F d, Y", strtotime($date));

echo $formattedDate;  
?></span>
                         
                           </div>
                    
                           <p class="cp-news-details-text mb-20">
                                         <?php echo $singleItem->t_d_text ;?>
                               
                               
                           </p>
                          
                          
                         
                           
                       
                        </div>
                     </div>
                
                      @endforeach
                     <!--<div class="cp-news2-d-related-post mb-60 wow fadeInUp  animated" data-wow-duration="1.5s" data-wow-delay="0.3" style="visibility: visible; animation-duration: 1.5s; animation-name: fadeInUp;">-->
                     <!--   <div class="cp-news2-d-related-wrap mb-30">-->
                     <!--      <h4 class="cp-news2-subtitle mb-0 line-height1">Related Post</h4>-->
                     <!--      <div class="cp-news2-d-related-wrap">-->
                     <!--         <div class="cp-news2-d-related-navigation">-->
                     <!--            <button class="cp-news2-button-prev" tabindex="0" aria-label="Previous slide" aria-controls="swiper-wrapper-19544fe8d9eb7fc4"><i class="fas fa-chevron-left"></i></button>-->
                     <!--            <button class="cp-news2-button-next" tabindex="0" aria-label="Next slide" aria-controls="swiper-wrapper-19544fe8d9eb7fc4"><i class="fas fa-chevron-right"></i></button>-->
                     <!--         </div>-->
                     <!--      </div>-->
                     <!--   </div>-->
                     <!--   <div class="swiper-container cp-news2-related-active swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events">-->
                     <!--      <div class="swiper-wrapper" id="swiper-wrapper-19544fe8d9eb7fc4" aria-live="off" style="transition-duration: 0ms; transform: translate3d(-460px, 0px, 0px);"><div class="swiper-slide swiper-slide-duplicate swiper-slide-prev" data-swiper-slide-index="1" role="group" aria-label="1 / 7" style="width: 430px; margin-right: 30px;">-->
                     <!--            <article>-->
                     <!--               <div class="cp-news-item">-->
                     <!--                  <div class="cp-news-img fix p-relative w-img">-->
                     <!--                     <div class="cp-img-overlay wow" style="visibility: visible; animation-name: panel;"></div>-->
                     <!--                     <a href="news-details.html"><img src="assets/img/news/news-3.jpg" alt="news"></a>-->
                     <!--                  </div>-->
                     <!--                  <div class="cp-news-content one">-->
                     <!--                     <div class="cp-news1-meta mb-25">-->
                     <!--                        <div class="cp-news1-meta mb-25">-->
                     <!--                           <span>January 02, 2023</span>-->
                     <!--                           <span><a href="news-details.html"><i class="fal fa-comments"></i> 04-->
                     <!--                                 Comments</a></span>-->
                     <!--                        </div>-->
                     <!--                     </div>-->
                     <!--                     <h3 class="cp-news-title"><a href="news-details.html">What Mockup Type Do you-->
                     <!--                           Accept for Printing</a></h3>-->
                     <!--                     <h5 class="cp-news-post-by">Author : <a href="#">Mr Harry</a></h5>-->
                     <!--                  </div>-->
                     <!--               </div>-->
                     <!--            </article>-->
                     <!--         </div><div class="swiper-slide swiper-slide-duplicate swiper-slide-active" data-swiper-slide-index="2" role="group" aria-label="2 / 7" style="width: 430px; margin-right: 30px;">-->
                     <!--            <article>-->
                     <!--               <div class="cp-news-item">-->
                     <!--                  <div class="cp-news-img fix p-relative w-img">-->
                     <!--                     <div class="cp-img-overlay wow" style="visibility: visible; animation-name: panel;"></div>-->
                     <!--                     <a href="news-details.html"><img src="assets/img/news/news-4.jpg" alt="news"></a>-->
                     <!--                  </div>-->
                     <!--                  <div class="cp-news-content one">-->
                     <!--                     <div class="cp-news1-meta mb-25">-->
                     <!--                        <span>January 02, 2023</span>-->
                     <!--                        <span><a href="news-details.html"><i class="fal fa-comments"></i> 04-->
                     <!--                              Comments</a></span>-->
                     <!--                     </div>-->
                     <!--                     <h3 class="cp-news-title"><a href="news-details.html">Holiday Cards For-->
                     <!--                           Businesses That Customers</a></h3>-->
                     <!--                     <h5 class="cp-news-post-by">Author : <a href="#">Mr Harry</a></h5>-->
                     <!--                  </div>-->
                     <!--               </div>-->
                     <!--            </article>-->
                     <!--         </div>-->
                     <!--         <div class="swiper-slide swiper-slide-next" data-swiper-slide-index="0" role="group" aria-label="3 / 7" style="width: 430px; margin-right: 30px;">-->
                     <!--            <article>-->
                     <!--               <div class="cp-news-item">-->
                     <!--                  <div class="cp-news-img fix p-relative w-img">-->
                     <!--                     <div class="cp-img-overlay wow" style="visibility: visible; animation-name: panel;"></div>-->
                     <!--                     <a href="news-details.html"><img src="assets/img/news/news-2.jpg" alt="news"></a>-->
                     <!--                  </div>-->
                     <!--                  <div class="cp-news-content one">-->
                     <!--                     <div class="cp-news1-meta mb-25">-->
                     <!--                        <span>January 02, 2023</span>-->
                     <!--                        <span><a href="news-details.html"><i class="fal fa-comments"></i> 04-->
                     <!--                              Comments</a></span>-->
                     <!--                     </div>-->
                     <!--                     <h3 class="cp-news-title"><a href="news-details.html">Can you Scan my Hard-->
                     <!--                           copies into Electronic</a></h3>-->
                     <!--                     <h5 class="cp-news-post-by">Author : <a href="#">Mr Don</a></h5>-->
                     <!--                  </div>-->
                     <!--               </div>-->
                     <!--            </article>-->
                     <!--         </div>-->
                     <!--         <div class="swiper-slide swiper-slide-duplicate-prev" data-swiper-slide-index="1" role="group" aria-label="4 / 7" style="width: 430px; margin-right: 30px;">-->
                     <!--            <article>-->
                     <!--               <div class="cp-news-item">-->
                     <!--                  <div class="cp-news-img fix p-relative w-img">-->
                     <!--                     <div class="cp-img-overlay wow" style="visibility: visible; animation-name: panel;"></div>-->
                     <!--                     <a href="news-details.html"><img src="assets/img/news/news-3.jpg" alt="news"></a>-->
                     <!--                  </div>-->
                     <!--                  <div class="cp-news-content one">-->
                     <!--                     <div class="cp-news1-meta mb-25">-->
                     <!--                        <div class="cp-news1-meta mb-25">-->
                     <!--                           <span>January 02, 2023</span>-->
                     <!--                           <span><a href="news-details.html"><i class="fal fa-comments"></i> 04-->
                     <!--                                 Comments</a></span>-->
                     <!--                        </div>-->
                     <!--                     </div>-->
                     <!--                     <h3 class="cp-news-title"><a href="news-details.html">What Mockup Type Do you-->
                     <!--                           Accept for Printing</a></h3>-->
                     <!--                     <h5 class="cp-news-post-by">Author : <a href="#">Mr Harry</a></h5>-->
                     <!--                  </div>-->
                     <!--               </div>-->
                     <!--            </article>-->
                     <!--         </div>-->
                     <!--         <div class="swiper-slide swiper-slide-duplicate-active" data-swiper-slide-index="2" role="group" aria-label="5 / 7" style="width: 430px; margin-right: 30px;">-->
                     <!--            <article>-->
                     <!--               <div class="cp-news-item">-->
                     <!--                  <div class="cp-news-img fix p-relative w-img">-->
                     <!--                     <div class="cp-img-overlay wow" style="visibility: visible; animation-name: panel;"></div>-->
                     <!--                     <a href="news-details.html"><img src="assets/img/news/news-4.jpg" alt="news"></a>-->
                     <!--                  </div>-->
                     <!--                  <div class="cp-news-content one">-->
                     <!--                     <div class="cp-news1-meta mb-25">-->
                     <!--                        <span>January 02, 2023</span>-->
                     <!--                        <span><a href="news-details.html"><i class="fal fa-comments"></i> 04-->
                     <!--                              Comments</a></span>-->
                     <!--                     </div>-->
                     <!--                     <h3 class="cp-news-title"><a href="news-details.html">Holiday Cards For-->
                     <!--                           Businesses That Customers</a></h3>-->
                     <!--                     <h5 class="cp-news-post-by">Author : <a href="#">Mr Harry</a></h5>-->
                     <!--                  </div>-->
                     <!--               </div>-->
                     <!--            </article>-->
                     <!--         </div>-->
                     <!--      <div class="swiper-slide swiper-slide-duplicate swiper-slide-duplicate-next" data-swiper-slide-index="0" role="group" aria-label="6 / 7" style="width: 430px; margin-right: 30px;">-->
                     <!--            <article>-->
                     <!--               <div class="cp-news-item">-->
                     <!--                  <div class="cp-news-img fix p-relative w-img">-->
                     <!--                     <div class="cp-img-overlay wow" style="visibility: visible; animation-name: panel;"></div>-->
                     <!--                     <a href="news-details.html"><img src="assets/img/news/news-2.jpg" alt="news"></a>-->
                     <!--                  </div>-->
                     <!--                  <div class="cp-news-content one">-->
                     <!--                     <div class="cp-news1-meta mb-25">-->
                     <!--                        <span>January 02, 2023</span>-->
                     <!--                        <span><a href="news-details.html"><i class="fal fa-comments"></i> 04-->
                     <!--                              Comments</a></span>-->
                     <!--                     </div>-->
                     <!--                     <h3 class="cp-news-title"><a href="news-details.html">Can you Scan my Hard-->
                     <!--                           copies into Electronic</a></h3>-->
                     <!--                     <h5 class="cp-news-post-by">Author : <a href="#">Mr Don</a></h5>-->
                     <!--                  </div>-->
                     <!--               </div>-->
                     <!--            </article>-->
                     <!--         </div><div class="swiper-slide swiper-slide-duplicate" data-swiper-slide-index="1" role="group" aria-label="7 / 7" style="width: 430px; margin-right: 30px;">-->
                     <!--            <article>-->
                     <!--               <div class="cp-news-item">-->
                     <!--                  <div class="cp-news-img fix p-relative w-img">-->
                     <!--                     <div class="cp-img-overlay wow" style="visibility: visible; animation-name: panel;"></div>-->
                     <!--                     <a href="news-details.html"><img src="assets/img/news/news-3.jpg" alt="news"></a>-->
                     <!--                  </div>-->
                     <!--                  <div class="cp-news-content one">-->
                     <!--                     <div class="cp-news1-meta mb-25">-->
                     <!--                        <div class="cp-news1-meta mb-25">-->
                     <!--                           <span>January 02, 2023</span>-->
                     <!--                           <span><a href="news-details.html"><i class="fal fa-comments"></i> 04-->
                     <!--                                 Comments</a></span>-->
                     <!--                        </div>-->
                     <!--                     </div>-->
                     <!--                     <h3 class="cp-news-title"><a href="news-details.html">What Mockup Type Do you-->
                     <!--                           Accept for Printing</a></h3>-->
                     <!--                     <h5 class="cp-news-post-by">Author : <a href="#">Mr Harry</a></h5>-->
                     <!--                  </div>-->
                     <!--               </div>-->
                     <!--            </article>-->
                     <!--         </div></div>-->
                     <!--   <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>-->
                     <!--</div>-->
                
                  </div>
               </div>
               <div class="col-xl-4 col-lg-5">
                  <div class="cp-news-sidebar">
                     <!--<div class="cp-news-widget mb-40 wow fadeInUp  animated" data-wow-duration="1.5s" data-wow-delay="0.3" style="visibility: visible; animation-duration: 1.5s; animation-name: fadeInUp;">-->
                     <!--   <h4 class="cp-news-widget-title">Search Here</h4>-->
                     <!--   <div class="cp-news-widget-search p-relative">-->
                     <!--      <form action="#">-->
                     <!--         <div class="cp-input-field">-->
                     <!--            <input type="text" placeholder="Search Here" required="">-->
                     <!--            <i class="far fa-search"></i>-->
                     <!--         </div>-->
                     <!--      </form>-->
                     <!--   </div>-->
                     <!--</div>-->
                     <!--<div class="cp-news-widget mb-40 wow fadeInUp  animated" data-wow-duration="1.5s" data-wow-delay="0.3" style="visibility: visible; animation-duration: 1.5s; animation-name: fadeInUp;">-->
                     <!--   <div class="cp-news-widget-about t-center">-->
                     <!--      <div class="cp-news-widget-about-img br-img-50 mb-30">-->
                     <!--         <img src="assets/img/about/about-4.jpg" alt="about">-->
                     <!--      </div>-->
                     <!--      <h3 class="cp-news-widget-about-title mb-15">Mr. Johan Doe</h3>-->
                     <!--      <p class="mb-25">I'm Johan Doe, and this is my creative space. I think that Services doesn't-->
                     <!--         have to cost a fortune. I hope you enjoy and come back often.</p>-->
                     <!--      <div class="cp-news-about-social">-->
                     <!--         <ul>-->
                     <!--            <li><a href="#"><i class="fab fa-facebook"></i></a></li>-->
                     <!--            <li><a href="#"><i class="fab fa-twitter"></i></a></li>-->
                     <!--            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>-->
                     <!--            <li><a href="#"><i class="fab fa-youtube"></i></a></li>-->
                     <!--         </ul>-->
                     <!--      </div>-->
                     <!--   </div>-->
                     <!--</div>-->
                     <!-- Remove WOW animation from sidebar -->
                     <div class="cp-news-widget mb-40">
                        <h4 class="cp-news-widget-title">Recent Update</h4>
                        <div class="cp-news-widget-post">
                                @foreach($all_blogs as $limit_post )
                            <?php $img_name = $limit_post->t_featured_image ;  ?>  
                                                
                                                     <?php $img_name_w_o_dot = str_replace('.', '', $img_name); ?>  
                                                    <?php $img_name_w_o_webp = str_replace('webp', '', $img_name_w_o_dot); ?>  
                                                    
                           <div class="cp-news-widget-post-item mb-30">
                              <div class="cp-news-widget-post-img br-img-50">
                                 <a href="{{ url('blog/'.str_replace(' ', '-', strtolower($limit_post->t_slug))).'/'}}">
                                    <!-- Lazy load sidebar images -->
                                    <img src="{{asset('images/blog/'.$limit_post->t_featured_image)}}" 
                                         alt="{{$img_name_w_o_webp}}"
                                         loading="lazy"
                                         width="80"
                                         height="80">
                                 </a>
                              </div>
                              <div class="cp-news-widget-post-text">
                                 <h4><a href="{{ url('blog/'.str_replace(' ', '-', strtolower($limit_post->t_slug))).'/'}}">       {{ $limit_post->t_title }}</a></h4>
                                 <div class="cp-news-widget-meta">
                                    <span><?php 
$date = $limit_post->time;
 
$formattedDate = date("F d, Y", strtotime($date));

echo $formattedDate;  
?>
</span>
                                 </div>
                              </div>
                           </div>
                                   @endforeach
                           
                          
                            
                        </div>
                     </div>
                     <?php $categories=DB::table('categories')->where('parent_cate','!=','0')->get();?>
                     <!-- Remove WOW animation from categories -->
                     <div class="cp-news-widget mb-40">
                        <h4 class="cp-news-widget-title">Hot Category</h4>
                        <div class="cp-news-widget-cat">
                           <ul>
                               
                               @foreach($categories as $pp)
                               
                            <li><a href="{{url(str_replace(' ', '-', strtolower($pp->cate_url))).'/'}}"> <i class="fa fa-arrow-right"></i> {{ $pp->cate_name }} </a></li>
                              @endforeach
                           </ul>
                        </div>
                     </div>
                     
                    
                  </div>
               </div>
            </div>
         </div>
      </section>
        
        @include('frontend/footer')