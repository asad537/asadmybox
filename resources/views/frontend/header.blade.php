<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
     <meta name="robots" content="INDEX, FOLLOW">
    <meta name="ahrefs-site-verification" content="734739587cc07a31d3bc981b110ff48c7fbd54f0bb2335a9017debf16c456d0e">
    <meta name="google-site-verification" content="VdA4BGdldogiMr7agC7R2ZPKm6bCqwilpzHxUijO6DU" />
    <meta name="google-site-verification" content="LUJameeu7808bvBJNMue5tN5x5OAYkUHFKp0je6HJaw" />
    <meta name="google-site-verification" content="auHtA-bcijxV1y48by1XIC0SD2RSPuqoXu3uhMAgbDY" />
     <meta name="google-site-verification" content="o3W2tqSzRAjEeCBdwbDyJ9_fZGSCqOiAg5Qg6rAjET8" />
 
      <meta content="9b6ecf0263d925dfba3a3fb68ffa5583" name="p:domain_verify" />
    <title><?php echo $meta_title; ?></title>
    <meta name="description" content="<?php echo $meta_description; ?>">
    <meta name="keywords" content="<?php echo $meta_tags; ?>">
    <!--<link rel="alternate" hreflang="en-us" href="<?php //echo url()->current().'/'; ?>" />-->
    <!--<link rel="alternate" hreflang="x-default" href="<?php //echo url()->current().'/'; ?>"  />-->
    <link rel="canonical" href="<?php echo url()->current().'/'; ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- Place favicon.ico in the root directory -->
   <!-- Dynamic LCP image preloading moved to top for priority -->
@if(isset($product_r) && !empty($product_r) && !empty(json_decode($product_r[0]->prod_gallery)))
       <?php $firstImage = json_decode($product_r[0]->prod_gallery)[0]; ?>
       <!-- Preload for mobile devices only -->
       <link rel="preload" as="image" href="{{ asset('images/'.$firstImage) }}" fetchpriority="high" media="(max-width: 768px)">
       <!-- Critical Product Page CSS for Mobile LCP -->
       <style>
       .container{max-width:1200px;margin:0 auto;padding:0 15px}
       .row{display:flex;flex-wrap:wrap;margin:0 -15px}
       .col-lg-5,.col-lg-7{padding:0 15px}
       @media(min-width:992px){.col-lg-5{flex:0 0 41.666667%;max-width:41.666667%}.col-lg-7{flex:0 0 58.333333%;max-width:58.333333%}}
       @media(max-width:991px){.col-lg-5,.col-lg-7{flex:0 0 100%;max-width:100%}}
       .prod-items{position:relative;min-height:400px;border:2px solid #e8e8e8;border-radius:12px;overflow:hidden;background:#fff;box-shadow:0 2px 8px rgba(0,0,0,0.06)}
       .prod-items-pic{width:100%;height:auto;display:block;transition:transform 0.3s ease}
       .prod-items:hover .prod-items-pic{transform:scale(1.05)}
       .breadcrumb-trail{list-style:none;padding:0;margin:0;display:flex;flex-wrap:wrap;gap:5px}
       .trail-items{display:flex;align-items:center;gap:5px;list-style:none;padding:0;margin:0}
       .page-title-area{padding:20px 0;background:#f5f5f5}
       .shop-details-area{padding:20px 0}
       h1{font-size:28px;font-weight:700;margin:10px 0;color:#212529;line-height:1.3}
       /* Critical above-the-fold styles for product page */
       .cp-quote-wrapper{background:rgba(126,196,53,0.78);border-radius:15px;padding:40px 35px;position:relative;overflow:hidden;box-shadow:0 10px 30px rgba(134,195,66,0.3);margin-top:20px}
       .cp-quote-form h3{text-align:center;margin-bottom:20px;font-size:35px;font-weight:bold;color:#fff}
       .cp-input-field{margin-bottom:15px}
       .cp-input-field input,.cp-input-field select{width:100%;padding:12px;border:2px solid #fff;border-radius:8px;font-size:14px;background:#fff}
       .cp-border2-btn{display:inline-block;padding:15px 40px;background:#55990b;color:#fff;border:none;border-radius:10px;font-size:16px;font-weight:600;cursor:pointer;transition:all 0.3s ease}
       .cp-border2-btn:hover{background:#6ba03a;transform:translateY(-2px)}
       @media (max-width: 768px) {
           .prod-items { min-height: auto; aspect-ratio: 1/1; width: 100%; }
           .prod-items-pic { width: 100%; height: 100%; aspect-ratio: 1/1; object-fit: contain; }
           .cp-quote-wrapper { margin-top: 20px; padding: 25px 20px; }
           .cp-quote-form h3 { font-size: 24px !important; }
           .hide-on-mobile { display: none !important; }
       }
       </style>
   @elseif(isset($blog_detail) && !empty($blog_detail) && isset($blog_detail[0]))
       <?php $blogFeaturedImage = $blog_detail[0]->t_featured_image; ?>
       <!-- Preload blog featured image for mobile only -->
       <link rel="preload" as="image" href="{{ asset('images/blog/'.$blogFeaturedImage) }}" fetchpriority="high" media="(max-width: 768px)">
   @elseif(isset($our_home_slider) && isset($our_home_slider[0]))
       <link rel="preload" as="image" href="{{ url('images') . '/' . $our_home_slider[0]->slider_banner }}" fetchpriority="high">
   @else
       <link rel="preload" as="image" href="{{ url('MBP-custom-boxes.webp') }}" fetchpriority="high">
   @endif
   <link rel="shortcut icon" type="image/x-icon" href="{{url('mbp.png')}}">
   
   <!-- Preconnect to important domains -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
   <link rel="dns-prefetch" href="https://www.google.com">
   <link rel="dns-prefetch" href="https://www.googletagmanager.com">
   
   @php
       $mbpMainPath = public_path('box_assets/css/mbpmain.min.css');
       $mbpMainVersion = config('app.env') === 'local'
           ? time()
           : (file_exists($mbpMainPath) ? filemtime($mbpMainPath) : '');
       $mbpMainHref = url('box_assets/css/mbpmain.min.css') . ($mbpMainVersion ? '?v=' . $mbpMainVersion : '');
       $criticalStyles = [
           url('box_assets/css/2bootstrap.min.css'),
           $mbpMainHref,
       ];
       $nonCriticalStyles = [
           'https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css',
           url('box_assets/css/preloader.css'),
           url('box_assets/css/animate.min.css'),
           url('box_assets/css/swiper-bundle.css'),
           url('box_assets/css/backToTop.css'),
       ];

       if(!isset($isProductPage)) {
           $nonCriticalStyles[] = url('box_assets/css/magnific-popup.css');
           $nonCriticalStyles[] = url('box_assets/css/ui-range-slider.css');
           $nonCriticalStyles[] = url('box_assets/css/nice-select.css');
           $nonCriticalStyles[] = url('box_assets/css/hover-reveal.css');
           $nonCriticalStyles[] = url('box_assets/css/mbp_owl.carousel.min.css');
       }
   @endphp
    
    <!-- Inline Critical CSS for Above-the-Fold Content -->
    <style>
    *{margin:0;padding:0;box-sizing:border-box}body{font-family:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;line-height:1.5;text-rendering:optimizeLegibility;overflow-x:hidden;contain:layout style paint}html{scroll-behavior:smooth}.header-main{min-height:70px;background:#fff;position:relative;contain:layout}.logo{min-height:60px;display:flex!important;align-items:center;visibility:visible!important;opacity:1!important;contain:layout}.logo img{max-width:300px;height:auto;display:block!important;visibility:visible!important;will-change:auto}.hero-section{background:linear-gradient(135deg,#c6d8b7ff 0%,#e8e8e8 100%);min-height:500px;contain:layout style}.hero-title{font-size:32px;font-weight:700;color:#2c2c2c;line-height:1.3;contain:layout}.hero-subtitle{font-size:18px;color:#4d4b4bff;line-height:1.6;contain:layout}.hero-btn{display:inline-block;padding:12px 30px;background-color:#86C342;color:#fff!important;font-size:16px;font-weight:600;border-radius:5px;text-decoration:none;transition:all .3s ease;will-change:transform}@media (max-width:767px){.header-main{min-height:60px}.logo img{max-width:280px;width:auto;height:auto;max-height:60px}.hero-section{display:none!important}.hero-section-mobile{display:block!important;padding:30px 0!important}.hero-title{font-size:24px!important}.hero-subtitle{font-size:15px!important}.hide-on-mobile{display:none!important}.cp-services-area{padding-top:20px!important;margin-top:0!important}.hero-image-content{min-height:auto!important}.logos-wrapper{gap:15px!important}}@media (min-width:768px){.hero-section-mobile{display:none!important}}img{max-width:100%;height:auto;content-visibility:auto;contain:layout}img[loading="lazy"]{content-visibility:auto}.container{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto;contain:layout}@media (min-width:576px){.container{max-width:540px}}@media (min-width:768px){.container{max-width:720px}}@media (min-width:992px){.container{max-width:960px}}@media (min-width:1200px){.container{max-width:1140px}}.row{display:flex;flex-wrap:wrap;margin-right:-15px;margin-left:-15px;contain:layout}.col-6,.col-lg-6,.col-md-12{position:relative;width:100%;padding-right:15px;padding-left:15px}.col-6{flex:0 0 50%;max-width:50%}@media (min-width:768px){.col-md-12{flex:0 0 100%;max-width:100%}}@media (min-width:992px){.col-lg-6{flex:0 0 50%;max-width:50%}}.text-center{text-align:center!important}.mb-4{margin-bottom:1.5rem!important}.mt-40{margin-top:40px!important}.container-fluid{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}.d-none{display:none!important}.d-lg-none{display:block!important}@media (min-width:992px){.d-lg-none{display:none!important}}
    </style>
    <style>
    /*! MeanMenu 2.0.7 */
    a.meanmenu-reveal{display:none}.mean-container .mean-bar{float:left;width:100%;position:relative;background:#070337;padding:4px 0;min-height:42px;z-index:999999}.mean-container a.meanmenu-reveal{width:22px;height:22px;padding:13px 13px 11px 13px;position:absolute;top:0;right:0;cursor:pointer;color:#fff;text-decoration:none;font-size:16px;text-indent:-9999em;line-height:22px;font-size:1px;display:block;font-family:Arial,Helvetica,sans-serif;font-weight:700}.mean-container a.meanmenu-reveal span{display:block;background:#fff;height:3px;margin-top:3px}.mean-container .mean-nav{float:left;width:100%;background:#070337;margin-top:44px}.mean-container .mean-nav ul{padding:0;margin:0;width:100%;list-style-type:none}.mean-container .mean-nav ul li{position:relative;float:left;width:100%}.mean-container .mean-nav ul li a{display:block;float:left;width:90%;padding:15px 5%;margin:0;text-align:left;color:#fff;border-top:1px solid #e0e3ed;text-decoration:none;text-transform:uppercase}.mean-container .mean-nav ul li li a{width:80%;padding:10px 10%;text-shadow:none!important;visibility:visible}.mean-container .mean-nav ul li.mean-last a{border-bottom:none;margin-bottom:0}.mean-container .mean-nav ul li li li a{width:70%;padding:10px 15%}.mean-container .mean-nav ul li li li li a{width:60%;padding:10px 20%}.mean-container .mean-nav ul li li li li li a{width:50%;padding:10px 25%}.mean-container .mean-nav ul li a.mean-expand{margin-top:1px;width:26px;height:32px;text-align:center;position:absolute;right:0;top:0;z-index:2;font-weight:700;background:transparent;font-size:14px}.mean-container .mean-push{float:left;width:100%;padding:0;margin:0;clear:both}.mean-nav .wrapper{width:100%;padding:0;margin:0}.mean-container .mean-bar,.mean-container .mean-bar *{-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box}.mean-remove{display:none!important}
    
    /* Default CSS */
    .mt-5{margin-top:5px!important}.mt-10{margin-top:10px}.mt-15{margin-top:15px}.mt-20{margin-top:20px}.mt-25{margin-top:25px}.mt-30{margin-top:30px}.mt-35{margin-top:35px}.mt-40{margin-top:40px}.mt-45{margin-top:45px}.mt-50{margin-top:50px}.mt-55{margin-top:55px}.mt-60{margin-top:60px}.mt-65{margin-top:65px}.mt-70{margin-top:70px}.mt-75{margin-top:75px}.mt-80{margin-top:80px}.mt-85{margin-top:85px}.mt-90{margin-top:90px}.mt-95{margin-top:95px}.mt-100{margin-top:100px}.mt-105{margin-top:105px}.mt-110{margin-top:110px}.mt-115{margin-top:115px}.mt-120{margin-top:120px}.mt-125{margin-top:125px}.mt-130{margin-top:130px}.mt-135{margin-top:135px}.mt-140{margin-top:140px}.mt-145{margin-top:145px}.mt-150{margin-top:150px}.mt-155{margin-top:155px}.mt-160{margin-top:160px}.mt-165{margin-top:165px}.mt-170{margin-top:170px}.mt-175{margin-top:175px}.mt-180{margin-top:180px}.mt-185{margin-top:185px}.mt-190{margin-top:190px}.mt-195{margin-top:195px}.mt-200{margin-top:200px}.mb-5{margin-bottom:5px!important}.mb-10{margin-bottom:10px}.mb-15{margin-bottom:15px}.mb-20{margin-bottom:20px}.mb-25{margin-bottom:25px}.mb-30{margin-bottom:30px}.mb-35{margin-bottom:35px}.mb-40{margin-bottom:40px}.mb-45{margin-bottom:45px}.mb-50{margin-bottom:30px}.mb-55{margin-bottom:55px}.mb-60{margin-bottom:60px}.mb-65{margin-bottom:65px}.mb-70{margin-bottom:70px}.mb-75{margin-bottom:75px}.mb-80{margin-bottom:80px}.mb-85{margin-bottom:85px}.mb-90{margin-bottom:90px}.mb-95{margin-bottom:95px}.mb-100{margin-bottom:100px}.mb-105{margin-bottom:105px}.mb-110{margin-bottom:110px}.mb-115{margin-bottom:115px}.mb-120{margin-bottom:120px}.mb-125{margin-bottom:125px}.mb-130{margin-bottom:130px}.mb-135{margin-bottom:135px}.mb-140{margin-bottom:140px}.mb-145{margin-bottom:145px}.mb-150{margin-bottom:150px}.mb-155{margin-bottom:155px}.mb-160{margin-bottom:160px}.mb-165{margin-bottom:165px}.mb-170{margin-bottom:170px}.mb-175{margin-bottom:175px}.mb-180{margin-bottom:180px}.mb-185{margin-bottom:185px}.mb-190{margin-bottom:190px}.mb-195{margin-bottom:195px}.mb-200{margin-bottom:200px}.ml-5{margin-inline-start:5px}.ml-10{margin-inline-start:10px}.ml-15{margin-inline-start:15px}.ml-20{margin-inline-start:20px}.ml-25{margin-inline-start:25px}.ml-30{margin-inline-start:30px}.ml-35{margin-inline-start:35px}.ml-40{margin-inline-start:40px}.ml-45{margin-inline-start:45px}.ml-50{margin-inline-start:50px}.ml-55{margin-inline-start:55px}.ml-60{margin-inline-start:60px}.ml-65{margin-inline-start:65px}.ml-70{margin-inline-start:70px}.ml-75{margin-inline-start:75px}.ml-80{margin-inline-start:80px}.ml-85{margin-inline-start:85px}.ml-90{margin-inline-start:90px}.ml-95{margin-inline-start:95px}.ml-100{margin-inline-start:100px}.ml-105{margin-inline-start:105px}.ml-110{margin-inline-start:110px}.ml-115{margin-inline-start:115px}.ml-120{margin-inline-start:120px}.ml-125{margin-inline-start:125px}.ml-130{margin-inline-start:130px}.ml-135{margin-inline-start:135px}.ml-140{margin-inline-start:140px}.ml-145{margin-inline-start:145px}.ml-150{margin-inline-start:150px}.ml-155{margin-inline-start:155px}.ml-160{margin-inline-start:160px}.ml-165{margin-inline-start:165px}.ml-170{margin-inline-start:170px}.ml-175{margin-inline-start:175px}.ml-180{margin-inline-start:180px}.ml-185{margin-inline-start:185px}.ml-190{margin-inline-start:190px}.ml-195{margin-inline-start:195px}.ml-200{margin-inline-start:200px}.mr-5{margin-inline-end:5px}.mr-10{margin-inline-end:10px}.mr-15{margin-inline-end:15px}.mr-20{margin-inline-end:20px}.mr-25{margin-inline-end:25px}.mr-30{margin-inline-end:30px}.mr-35{margin-inline-end:35px}.mr-40{margin-inline-end:40px}.mr-45{margin-inline-end:45px}.mr-50{margin-inline-end:50px}.mr-55{margin-inline-end:55px}.mr-60{margin-inline-end:60px}.mr-65{margin-inline-end:65px}.mr-70{margin-inline-end:70px}.mr-75{margin-inline-end:75px}.mr-80{margin-inline-end:80px}.mr-85{margin-inline-end:85px}.mr-90{margin-inline-end:90px}.mr-95{margin-inline-end:95px}.mr-100{margin-inline-end:100px}.mr-105{margin-inline-end:105px}.mr-110{margin-inline-end:110px}.mr-115{margin-inline-end:115px}.mr-120{margin-inline-end:120px}.mr-125{margin-inline-end:125px}.mr-130{margin-inline-end:130px}.mr-135{margin-inline-end:135px}.mr-140{margin-inline-end:140px}.mr-145{margin-inline-end:145px}.mr-150{margin-inline-end:150px}.mr-155{margin-inline-end:155px}.mr-160{margin-inline-end:160px}.mr-165{margin-inline-end:165px}.mr-170{margin-inline-end:170px}.mr-175{margin-inline-end:175px}.mr-180{margin-inline-end:180px}.mr-185{margin-inline-end:185px}.mr-190{margin-inline-end:190px}.mr-195{margin-inline-end:195px}.mr-200{margin-inline-end:200px}.pt-5{padding-top:5px!important}.pt-10{padding-top:10px}.pt-15{padding-top:15px}.pt-20{padding-top:20px}.pt-25{padding-top:25px}.pt-30{padding-top:30px}.pt-35{padding-top:35px}.pt-40{padding-top:40px}.pt-45{padding-top:45px}.pt-50{padding-top:50px}.pt-55{padding-top:55px}.pt-60{padding-top:60px}.pt-65{padding-top:65px}.pt-70{padding-top:70px}.pt-75{padding-top:75px}.pt-80{padding-top:80px}.pt-85{padding-top:85px}.pt-90{padding-top:90px}.pt-95{padding-top:95px}.pt-100{padding-top:100px}.pt-105{padding-top:105px}.pt-110{padding-top:110px}.pt-115{padding-top:115px}.pt-120{padding-top:120px}.pt-125{padding-top:125px}.pt-130{padding-top:130px}.pt-135{padding-top:135px}.pt-140{padding-top:140px}.pt-145{padding-top:145px}.pt-150{padding-top:150px}.pt-155{padding-top:155px}.pt-160{padding-top:160px}.pt-165{padding-top:165px}.pt-170{padding-top:170px}.pt-175{padding-top:175px}.pt-180{padding-top:180px}.pt-185{padding-top:185px}.pt-190{padding-top:190px}.pt-195{padding-top:195px}.pt-200{padding-top:200px}.pb-5{padding-bottom:5px!important}.pb-10{padding-bottom:10px}.pb-15{padding-bottom:15px}.pb-20{padding-bottom:20px}.pb-25{padding-bottom:25px}.pb-30{padding-bottom:30px}.pb-35{padding-bottom:35px}.pb-40{padding-bottom:40px}.pb-45{padding-bottom:45px}.pb-50{padding-bottom:50px}.pb-55{padding-bottom:55px}.pb-60{padding-bottom:60px}.pb-65{padding-bottom:65px}.pb-70{padding-bottom:70px}.pb-75{padding-bottom:75px}.pb-80{padding-bottom:80px}.pb-85{padding-bottom:85px}.pb-90{padding-bottom:90px}.pb-95{padding-bottom:95px}.pb-100{padding-bottom:100px}.pb-105{padding-bottom:105px}.pb-110{padding-bottom:110px}.pb-115{padding-bottom:115px}.pb-120{padding-bottom:120px}.pb-125{padding-bottom:125px}.pb-130{padding-bottom:130px}.pb-135{padding-bottom:135px}.pb-140{padding-bottom:140px}.pb-145{padding-bottom:145px}.pb-150{padding-bottom:150px}.pb-155{padding-bottom:155px}.pb-160{padding-bottom:160px}.pb-165{padding-bottom:165px}.pb-170{padding-bottom:170px}.pb-175{padding-bottom:175px}.pb-180{padding-bottom:180px}.pb-185{padding-bottom:185px}.pb-190{padding-bottom:190px}.pb-195{padding-bottom:195px}.pb-200{padding-bottom:200px}.pl-5{padding-inline-start:5px}.pl-10{padding-inline-start:10px}.pl-15{padding-inline-start:15px}.pl-20{padding-inline-start:20px}.pl-25{padding-inline-start:25px}.pl-30{padding-inline-start:30px}.pl-35{padding-inline-start:35px}.pl-40{padding-inline-start:40px}.pl-45{padding-inline-start:45px}.pl-50{padding-inline-start:50px}.pl-55{padding-inline-start:55px}.pl-60{padding-inline-start:60px}.pl-65{padding-inline-start:65px}.pl-70{padding-inline-start:70px}.pl-75{padding-inline-start:75px}.pl-80{padding-inline-start:80px}.pl-85{padding-inline-start:85px}.pl-90{padding-inline-start:90px}.pl-95{padding-inline-start:95px}.pl-100{padding-inline-start:100px}.pl-105{padding-inline-start:105px}.pl-110{padding-inline-start:110px}.pl-115{padding-inline-start:115px}.pl-120{padding-inline-start:120px}.pl-125{padding-inline-start:125px}.pl-130{padding-inline-start:130px}.pl-135{padding-inline-start:135px}.pl-140{padding-inline-start:140px}.pl-145{padding-inline-start:145px}.pl-150{padding-inline-start:150px}.pl-155{padding-inline-start:155px}.pl-160{padding-inline-start:160px}.pl-165{padding-inline-start:165px}.pl-170{padding-inline-start:170px}.pl-175{padding-inline-start:175px}.pl-180{padding-inline-start:180px}.pl-185{padding-inline-start:185px}.pl-190{padding-inline-start:190px}.pl-195{padding-inline-start:195px}.pl-200{padding-inline-start:200px}.pr-5{padding-inline-end:5px}.pr-10{padding-inline-end:10px}.pr-15{padding-inline-end:15px}.pr-20{padding-inline-end:20px}.pr-25{padding-inline-end:25px}.pr-30{padding-inline-end:30px}.pr-35{padding-inline-end:35px}.pr-40{padding-inline-end:40px}.pr-45{padding-inline-end:45px}.pr-50{padding-inline-end:50px}.pr-55{padding-inline-end:55px}.pr-60{padding-inline-end:60px}.pr-65{padding-inline-end:65px}.pr-70{padding-inline-end:70px}.pr-75{padding-inline-end:75px}.pr-80{padding-inline-end:80px}.pr-85{padding-inline-end:85px}.pr-90{padding-inline-end:90px}.pr-95{padding-inline-end:95px}.pr-100{padding-inline-end:100px}.pr-105{padding-inline-end:105px}.pr-110{padding-inline-end:110px}.pr-115{padding-inline-end:115px}.pr-120{padding-inline-end:120px}.pr-125{padding-inline-end:125px}.pr-130{padding-inline-end:130px}.pr-135{padding-inline-end:135px}.pr-140{padding-inline-end:140px}.pr-145{padding-inline-end:145px}.pr-150{padding-inline-end:150px}.pr-155{padding-inline-end:155px}.pr-160{padding-inline-end:160px}.pr-165{padding-inline-end:165px}.pr-170{padding-inline-end:170px}.pr-175{padding-inline-end:175px}.pr-180{padding-inline-end:180px}.pr-185{padding-inline-end:185px}.pr-190{padding-inline-end:190px}.pr-195{padding-inline-end:195px}.pr-200{padding-inline-end:200px}
    </style>
    
   <!-- CSS here -->
   @foreach ($criticalStyles as $href)
       <link rel="stylesheet" href="{{ $href }}">
   @endforeach
   @foreach ($nonCriticalStyles as $href)
       <link rel="preload" as="style" href="{{ $href }}" onload="this.onload=null;this.rel='stylesheet'">
       <noscript><link rel="stylesheet" href="{{ $href }}"></noscript>
   @endforeach
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <!-- Preload critical fonts with font-display swap -->
   <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" onload="this.onload=null;this.rel='stylesheet'">
   <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"></noscript>
   
   <!-- Add font-display swap for Font Awesome -->
   <style>
   @font-face {
       font-family: 'Font Awesome 5 Pro';
       font-display: swap;
   }
   </style>
   <!-- Dynamic LCP image preloading removed from here -->



   <link rel="shortcut icon" type="image/x-icon" href="{{url('mbp.png')}}">
   
   <!-- Preload Font Awesome for faster icon rendering -->
   <link rel="preload" as="style" href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css">
   <!-- Google Tag Manager - Delayed until window load for performance -->
<script>
// Only load GTM after window load to prevent blocking LCP/FCP
window.addEventListener('load', function() {
    setTimeout(function() {
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-57RQCS36');
    }, 4000); // Delay 4 seconds after window load
});
</script>
<!-- End Google Tag Manager -->
 
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-57RQCS36"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->




       <style>
       /* Fix logo layout shift on mobile */
       .logo {
           min-height: 60px;
           display: flex !important;
           align-items: center;
           position: relative;
           flex-shrink: 0;
           visibility: visible !important;
           opacity: 1 !important;
           contain: layout;
       }
       
       .logo img {
           max-width: 300px;
           height: auto;
           display: block !important;
           object-fit: contain;
           visibility: visible !important;
           will-change: auto;
       }
       
       /* Force logo visibility on all screens */
       .header-main .logo,
       .header-main1 .logo,
       #menu-show-hide .logo {
           display: flex !important;
           visibility: visible !important;
           opacity: 1 !important;
           min-height: 60px !important;
           align-items: center !important;
       }
       
       .header-main .logo a,
       .header-main1 .logo a,
       #menu-show-hide .logo a {
           display: block !important;
           visibility: visible !important;
           opacity: 1 !important;
           width: 100% !important;
       }
       
       .header-main .logo img,
       .header-main1 .logo img,
       #menu-show-hide .logo img {
           display: block !important;
           visibility: visible !important;
           opacity: 1 !important;
           max-width: 300px !important;
           height: auto !important;
           width: auto !important;
       }
       
       /* Logo column visibility */
       .header-main .col-xl-3.col-6,
       .header-main1 .col-xl-3.col-6,
       #menu-show-hide .col-xl-3.col-6 {
           display: block !important;
           visibility: visible !important;
           opacity: 1 !important;
           min-height: 60px !important;
       }
       
       /* Desktop and tablet - ensure logo is visible */
       @media (min-width: 768px) {
           /* Ensure logo column is visible */
           .header-main .col-xl-3.col-6,
           .col-xl-3.col-6 {
               display: block !important;
               visibility: visible !important;
               opacity: 1 !important;
           }
           
           .header-main .logo,
           .logo,
           #menu-show-hide .logo {
               display: flex !important;
               visibility: visible !important;
               opacity: 1 !important;
               position: relative !important;
               z-index: 1 !important;
           }
           
           .header-main .logo a,
           .logo a,
           #menu-show-hide .logo a {
               display: block !important;
               visibility: visible !important;
               opacity: 1 !important;
           }
           
           .header-main .logo img,
           .logo img,
           #menu-show-hide .logo img,
           .header-main1 .logo img {
               display: block !important;
               visibility: visible !important;
               opacity: 1 !important;
               max-width: 340px !important;
               width: auto !important;
               height: auto !important;
               position: relative !important;
               z-index: 1 !important;
           }
       }
       
       /* Desktop view - larger logo */
       @media (min-width: 1200px) {
           /* Force logo column visibility - override Bootstrap */
           .header-main .col-xl-3.col-6,
           .header-main1 .col-xl-3.col-6,
           #menu-show-hide .col-xl-3.col-6,
           .col-xl-3.col-6 {
               display: block !important;
               visibility: visible !important;
               opacity: 1 !important;
               width: 25% !important;
               flex: 0 0 25% !important;
               max-width: 25% !important;
           }
           
           .header-main .logo,
           .header-main1 .logo,
           #menu-show-hide .logo,
           .logo {
               display: flex !important;
               visibility: visible !important;
               opacity: 1 !important;
               position: relative !important;
               z-index: 10 !important;
           }
           
           .header-main .logo a,
           .header-main1 .logo a,
           #menu-show-hide .logo a,
           .logo a {
               display: block !important;
               visibility: visible !important;
               opacity: 1 !important;
               width: 100% !important;
           }
           
           .header-main .logo img,
           .header-main1 .logo img,
           #menu-show-hide .logo img,
           .logo img {
               max-width: 300px !important;
               width: auto !important;
               height: 89px !important;
               display: block !important;
               visibility: visible !important;
               opacity: 1 !important;
               object-fit: contain !important;
               position: relative !important;
               z-index: 10 !important;
               
           }
       }
       
       /* Tablet view */
       @media (min-width: 768px) and (max-width: 1199px) {
           .logo {
               display: flex !important;
               visibility: visible !important;
           }
           
           .logo img {
               max-width: 340px !important;
               width: auto !important;
               height: auto !important;
               display: block !important;
               visibility: visible !important;
               opacity: 1 !important;
               object-fit: contain !important;
           }
       }
       
       /* Fix header-main layout shift */
       .header-main {
           min-height: 70px;
       }
       
       /* Mobile view - responsive like desktop */
       @media (max-width: 767px) {
           .header-main {
               min-height: 60px;
           }
           
           /* Logo styling - proper size like desktop */
           .header-main .logo {
               min-height: 50px !important;
               flex: 1 1 auto !important;
               max-width: none !important;
           }
           
           .header-main .logo img,
           .logo img,
           #menu-show-hide .logo img,
           .header-main1 .logo img {
               max-width: 340px !important;
               width: 280px !important;
               height: 100px !important;
             
               min-width: auto !important;
           }
           
           /* Proper spacing - like desktop view */
           .row.align-items-center {
               display: flex !important;
               align-items: center !important;
               justify-content: space-between !important;
               gap: 15px !important;
           }
           
           /* Logo column - takes available space */
           .col-xl-3.col-6 {
               flex: 1 1 auto !important;
               max-width: none !important;
               padding-right: 10px !important;
           }
           
           /* Menu column - fixed width for icons */
           .col-xl-9.col-6 {
               flex: 0 0 auto !important;
               min-width: 100px !important;
               max-width: 120px !important;
               padding-left: 10px !important;
           }
           
           /* Ensure hamburger menu has proper space */
           .menu-btn-wrap {
               min-width: 100px !important;
               flex-shrink: 0 !important;
               display: flex !important;
               align-items: center !important;
               justify-content: flex-end !important;
               gap: 10px !important;
           }
           
           /* Hide main menu on mobile - show only hamburger */
           .main-menu {
               display: none !important;
           }
           
           .main-menu ul {
               display: none !important;
           }
           
           .main-menu ul li {
               display: none !important;
           }
           
           /* Show hamburger menu button */
           .mobile-menu {
               display: block !important;
           }
           
           /* Ensure meanmenu hamburger is visible */
           .mean-container {
               display: block !important;
           }
           
           .meanmenu-reveal {
               display: block !important;
           }
       }
       
       /* Desktop - show menu, hide mobile menu */
       @media (min-width: 768px) {
           .main-menu {
               display: block !important;
           }
           
           .mobile-menu {
               display: none !important;
           }
       }
       
       .main-menu ul li a{
           color: black !important;
       }
 .main-menu ul li.menu-item-has-children:after {
   display: none !important;
}
@media only screen and (min-width: 992px) and (max-width: 1199px), only screen and (min-width: 768px) and (max-width: 991px), only screen and (min-width: 576px) and (max-width: 767px), (max-width: 575px) {
    .cp-services-area {
        padding-top: 40px !important;
    }
}

   @media (min-width: 768px) {
            .forthemobile{
      display: none !important;
  }
   }
  @media (min-width: 768px) {
      .desktop{
          display: none !important;
      }
  }
 
       @media (max-width: 768px) {
           
    .hide-on-mobile {
        display: none !important;
    }
    .for-the-mobile{
        margin-top: 20px;
    }
    .separator-text::before{
          display: none !important;
    }
    .for-mobile{
        font-size:20px !important;
    }
    .for-mobilexx{
        font-size:16px !important;
    }
    
     .for-mobile1{
        font-size:12px !important;
    }
     .footer-links {
        display: flex;
        flex-wrap: wrap;
        padding: 0;
        list-style: none;
    }

    .footer-links li {
        width: 50%; /* Two items per row */
        padding: 5px 0;
    }
}




        .select-items div, .select-selected{
            background-color: white !important;color: black;
        }
        
        /* Modern Inline Search Bar Styling */
        .main-menu ul li {
            position: relative;
        }
        .search-toggle-checkbox {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
            margin: 0;
            padding: 0;
            border: 0;
        }
        .inline-search-container {
            position: absolute;
            top: 100%;
            right: 0;
            z-index: 1000;
            margin-top: 10px;
            min-width: 300px;
            background: white;
            padding: 10px;
            border-radius: 8px;
            border: 3px solid #86c442;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: none;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }
        .search-toggle-checkbox:checked ~ .cp-search-btn-toggle ~ .inline-search-container,
        .search-toggle-checkbox:checked ~ .inline-search-container {
            display: block;
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .cp-search-btn-toggle {
            display: inline-block;
            cursor: pointer;
            user-select: none;
            -webkit-user-select: none;
            -webkit-tap-highlight-color: transparent;
        }
        .modern-search-form {
            width: 100%;
        }
        .modern-search-container {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
        }
        .modern-search-input {
            width: 100%;
            padding: 12px 50px 12px 20px;
            border: 2px solid #86c442;
            border-radius: 50px;
            background-color: #ffffff;
            font-size: 16px;
            color: #333;
            outline: none;
            box-shadow: 0 2px 8px rgba(134, 196, 66, 0.15);
            transition: all 0.3s ease;
        }
        .modern-search-input::placeholder {
            color: #999;
        }
        .modern-search-input:focus {
            box-shadow: 0 4px 12px rgba(134, 196, 66, 0.25);
            border-color: #6ba03a;
        }
        .modern-search-button {
            position: absolute;
            right: 8px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px 12px;
            color: #999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.3s ease;
        }
        .modern-search-button:hover {
            color: #86c442;
        }
        .modern-search-button i {
            font-size: 18px;
        }
        /* Mobile Header Search Bar */
        .mobile-search-header {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            position: relative;
            margin-right: 8px;
        }
        .mobile-search-header-menu {
            display: flex;
            align-items: center;
            position: relative;
        }
        @media (max-width: 768px) {
            .mobile-search-header {
                display: none;
            }
            .mobile-search-header-menu {
                display: flex;
            }
        }
        @media (min-width: 769px) {
            .mobile-search-header-menu {
                display: none;
            }
        }
        .mobile-search-checkbox {
            display: none;
        }
        .mobile-search-icon,
        .mobile-search-icon-menu {
            display: inline-block;
            cursor: pointer;
            padding: 8px;
            font-size: 18px;
            color: #333;
            -webkit-tap-highlight-color: transparent;
        }
        /* Simple Dropdown Search */
        .mobile-search-dropdown,
        .mobile-search-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            width: calc(100vw - 30px);
            max-width: 350px;
            margin-top: 10px;
            z-index: 99999;
            display: none;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }
        .mobile-search-checkbox:checked ~ .mobile-search-dropdown,
        .mobile-search-checkbox:checked ~ .mobile-search-dropdown-menu {
            display: block;
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .mobile-search-form {
            width: 100%;
        }
        .mobile-search-wrapper-dropdown {
            position: relative;
            display: flex;
            align-items: center;
            background: white;
            border: 2px solid #86c442;
            border-radius: 50px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            padding: 5px;
            width: 100%;
        }
        .mobile-search-input-dropdown {
            flex: 1;
            border: none;
            border-radius: 50px;
            padding: 12px 15px 12px 20px;
            font-size: 14px;
            outline: none;
            background: transparent;
            color: #333;
            margin: 0;
        }
        .mobile-search-input-dropdown:focus {
            outline: none;
            box-shadow: none;
        }
        .mobile-search-input-dropdown::placeholder {
            color: #999;
        }
        .mobile-search-submit-dropdown {
            position: absolute;
            right: 5px;
            background: #86c442;
            border: none;
            cursor: pointer;
            padding: 10px;
            width: 40px;
            height: 40px;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }
        .mobile-search-submit-dropdown:hover {
            background: #6ba03a;
        }
        .mobile-search-submit-dropdown i {
            font-size: 16px;
            color: white;
        }
        @media (max-width: 768px) {
            .mobile-search-wrapper-dropdown {
                margin-top: 9px;
                margin-left: 41px;
            }
            .search-toggle-wrapper {
                position: relative;
            }
            .inline-search-container {
                min-width: calc(100vw - 30px);
                max-width: calc(100vw - 30px);
                width: calc(100vw - 30px);
                right: 15px;
                left: auto;
                position: fixed !important;
                top: 70px !important;
                bottom: auto !important;
                margin: 0;
                z-index: 99999 !important;
                display: none !important;
                opacity: 0 !important;
                visibility: hidden !important;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15) !important;
            }
            .search-toggle-checkbox:checked ~ .cp-search-btn-toggle ~ .inline-search-container,
            .search-toggle-checkbox:checked ~ .inline-search-container {
                display: block !important;
                opacity: 1 !important;
                visibility: visible !important;
                transform: translateY(0) !important;
            }
            .modern-search-input {
                padding: 12px 50px 12px 20px;
                font-size: 16px;
            }
            .cp-search-btn-toggle {
                display: inline-block !important;
                cursor: pointer !important;
                -webkit-tap-highlight-color: transparent;
                padding: 8px !important;
                user-select: none;
                -webkit-user-select: none;
                touch-action: manipulation;
                pointer-events: auto !important;
            }
            .cp-search-btn-toggle i {
                font-size: 18px;
                pointer-events: none;
            }
            .search-toggle-checkbox {
                position: absolute;
                opacity: 0;
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                cursor: pointer;
                z-index: 2;
                top: 0;
                left: 0;
            }
        }
    </style>
  
   <style>
   .nice-select{
       display: none !important;
   }
       /*the container must be positioned relative:*/
.custom-select {
  position: relative;
  font-family: Arial;
  display: inline-block;
}

.custom-select select {
  display: none; /*hide original SELECT element:*/
}

.select-selected {
  background-color: DodgerBlue;
  border-radius: 10px 10px 0px 0px;
}

.select-selected-bottom-rounded {
  border-radius: 10px 10px 10px 10px;
}

.select-selected-bottom-square {
  border-radius: 10px 10px 0px 0px;
}

/*style the arrow inside the select element:*/
.select-selected:after {
  position: absolute;
  content: "";
  top: 45%;
  right: 10px;
  width: 0;
  height: 0;
  border: 6px solid transparent;
  border-color: #fff transparent transparent transparent;
}

/*point the arrow upwards when the select box is open (active):*/
.select-selected.select-arrow-active:after {
  border-color: transparent transparent #fff transparent;
  top: 25%;
}


@media only screen and (min-width: 576px) and (max-width: 767px), (max-width: 575px) {
    .page-title-area {
        height: 150px !important;  
    }
}
@media only screen and (min-width: 992px) {
  .just-on-mobile {
    display: none !important;
  }
}




/*set the styling and height for the list when the select box is open (active), the overflow-y property controls the scrolling:*/
.select-items{
  border-radius: 0px 0px 10px 10px;
  height: 110px;
  overflow-y: auto;
  position: absolute;
  background-color: DodgerBlue;
  top: 100%;
  left: 0;
  right: 0;
  z-index: 99;
}

/*style the items (options), including the selected item:*/
.select-items div,.select-selected {
  
  padding: 8px 16px;
  border: 1px solid transparent;
  border-color: transparent transparent rgba(0, 0, 0, 0.1) transparent;
  cursor: pointer;
  user-select: none;
}

/*hide the items when the select box is closed:*/
.select-hide {
  display: none;
}

.select-items div:hover, .same-as-selected {
  background-color: rgba(0, 0, 0, 0.1);
  -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.1);
}

/* scrollbar width */
.select-items::-webkit-scrollbar {
  width: 15px;
}

/* scrollbar track */
.select-items::-webkit-scrollbar-track {
  background:  #c7e3ff;
  border-radius: 0px 0px 10px 0px;
  -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
}
 
/* scrollbar handle */
.select-items::-webkit-scrollbar-thumb {
  background: #8ac5ff;
  border-radius: 10px; /* optional rounded handle */
  -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
  background-image: -webkit-linear-gradient(45deg,
	                                          rgba(255, 255, 255, .2) 25%,
											  transparent 25%,
											  transparent 50%,
											  rgba(255, 255, 255, .2) 50%,
											  rgba(255, 255, 255, .2) 75%,
											  transparent 75%,
											  transparent);
}

/* scrollbar handle on hover */
.select-items::-webkit-scrollbar-thumb:hover {
  background: white;
  background-image: -webkit-linear-gradient(45deg,
	                                          rgba(255, 255, 255, .2) 25%,
											  transparent 25%,
											  transparent 50%,
											  rgba(255, 255, 255, .2) 50%,
											  rgba(255, 255, 255, .2) 75%,
											  transparent 75%,
											  transparent);
}
   </style>
 
    
    <style>
    .separator-text {
    font-size: 17px;
    color: black;
    position: relative;
    padding-left: 15px; /* Adjust spacing */
}

.separator-text::before {
    content: "";
    position: absolute;
    left: 0px; /* Adjust position */
    background: #8c8c8c;
    width: 3px;
    height: 20px;
    top: 50%;
    transform: translateY(-50%);
}

</style>




<script>
    setTimeout(function() {
        (function(w,d,s,l,i){
            w[l]=w[l]||[];
            w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});
            var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';
            j.async=true;
            j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;
            f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','G-BNXEWT8LEG');
    }, 10000); // 20 seconds in milliseconds
</script>

 <?php if(!empty($video)): ?>
 
 <?php echo $video; ?>
 
 <?php endif; ?> 
    
<!-- twitter Card -->
<?php if(!empty($twitter_card)): ?>
 
 <?php echo $twitter_card; ?>
 
 <?php endif; ?> 
 <!-- OPen Graph -->
 <?php if(!empty($open_graph)): ?>
 
 <?php echo $open_graph; ?>
 
 <?php endif; ?> 
 
    <!-- SERP FEATURE Start-->
<?php if(!empty($BreadcrumbList)): ?>
<script type="application/ld+json">
<?php echo $BreadcrumbList; ?>
</script>
<?php endif; ?> 
<!-- SERP FEATURE End-->
 <!-- FAQ's code -->
 <?php if(!empty($faq_schema)): ?>
<script type="application/ld+json">
<?php echo $faq_schema; ?>
  
</script>
<?php endif; ?> 
<!-- Rating Code -->
<?php if(!empty($rating_code)): ?>
<script type="application/ld+json">
<?php echo $rating_code; ?>
  
</script>
<?php endif; ?> 
<!-- Business Listing Code -->
<?php if(!empty($business_listing)): ?>
<script type="application/ld+json">
<?php echo $business_listing; ?>
  
</script>
<?php endif; ?> 
<!-- Blog Detail Page Code -->
<?php if(!empty($blog_detail_page)): ?>
<script type="application/ld+json">
<?php echo $blog_detail_page; ?>
  
</script>
<?php endif; ?> 
 
<?php if(!empty($BreadcrumbList)): ?>
<script type="application/ld+json">
<?php echo $BreadcrumbList; ?>
  
</script>
<?php endif; ?>

   <style>
    .owl-carousel .item {
        text-align: center;
        padding: 10px;
    }

    .owl-carousel .item img {
        max-width: 100%;
        height: auto;
        border-radius: 5px;
    }
</style>

   <style>
       .tp-theme-settings{
           display:none !important;
       }
       
       /* Sticky Header Styles - Optimized for performance */
       .sticky-header {
           position: sticky;
           top: 0;
           z-index: 9999;
           background: white;
           box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
           transition: transform 0.3s ease;
           will-change: transform;
           contain: layout style;
       }
       
       .sticky-header .cp-header {
           background: white !important;
       }
       
       .header-main {
           height: auto !important;
           padding: 6px 0;
           contain: layout;
       }
   </style>
                       
<style>
  .scroll-home {
    max-height: 550px; /* Set the maximum height for scrolling */
    overflow-y: auto;  /* Enable vertical scrolling */
    padding: 10px;      /* Optional: Add padding for better aesthetics */
    border: 1px solid #ccc; /* Optional: Add a border for clarity */
    border-radius: 10px; /* Optional: Smooth rounded corners */
  }

  /* Custom Scrollbar Styles */
  .scroll-home::-webkit-scrollbar {
    width: 8px; /* Scrollbar width */
  }

  .scroll-home::-webkit-scrollbar-track {
    background: #f1f1f1; /* Track background */
  }

  .scroll-home::-webkit-scrollbar-thumb {
    background: red; /* Scrollbar color */
    border-radius: 10px; /* Rounded scrollbar */
  }

  .scroll-home::-webkit-scrollbar-thumb:hover {
    background: darkred; /* Scrollbar color on hover */
  }
</style>
</head>

<body>
   <header class="sticky-header">
      <div class="cp-header cp-header1 cp-header-transparent add-z-index-500" >
         <div class="cp-header1-top d-none d-md-block">
            <div class="container-fluid" style="    background-color: #86c442c7;">
          <div class="cp-header2-top cp-bg-12 d-none d-md-block">
            <div class="container-fluid" style="    background-color: #86c442c7;">
               <div class="cp-header2-top-wrap d-flex align-items-center justify-content-between">
                  <div class="cp-header2-top-item">
                     <div class="cp-header2-info">
                        <ul>
                           <li style="color:white;"><a href="tel:847-200-0974" style="color:white;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="1em" height="1em" fill="currentColor" style="vertical-align: -0.125em;"><path d="M497.39 361.8l-112-48a24 24 0 0 0-28 6.9l-49.6 60.6A370.66 370.66 0 0 1 130.6 204.11l60.6-49.6a24 24 0 0 0 6.9-28l-48-112A24 24 0 0 0 126.9 0H24C10.8 0 0 10.8 0 24c0 269.5 218.5 488 488 488 13.2 0 24-10.8 24-24V384.801a24 24 0 0 0-14.61-23.001z"/></svg> 847-200-0974</a></li>
                           <li  style="color:white;"><a href="mailto:support@myboxprinting.com" style="color:white;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="1em" height="1em" fill="currentColor" style="vertical-align: -0.125em;"><path d="M464 64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V112c0-26.51-21.49-48-48-48zm0 48v40.805c-22.422 18.259-58.168 46.651-134.587 106.49-16.841 13.247-50.201 45.072-73.413 44.701-23.208.375-56.579-31.459-73.413-44.701C106.18 199.465 70.425 171.067 48 152.805V112h416zM48 400V214.398c22.914 18.251 54.658 41.413 120.46 92.953 37.6 29.66 87.52 74.32 87.54 79.54 0-5.18 49.77-49.74 87.54-79.54 65.801-51.539 97.545-74.702 120.46-92.953V400H48z"/></svg>support@myboxprinting.com</a>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <!--<div class="cp-header2-top-item d-none d-xl-block">-->
                  <!--   <div class="cp-header2-offer">-->
                  <!--      <span>Black Friday Big Offer..?</span>-->
                  <!--   </div>-->
                  <!--</div>-->
                   <style>
        .cart-container {
            position: relative;
            display: inline-block;
            font-size: 24px;
            cursor: pointer;
        }

        .cart-icon {
            color: white;
            font-size: 36px;
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background-color: red;
            color: white;
            font-size: 14px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
    </style>

                  <div class="cp-header2-top-item">
                     <div class="cp-header2-order-currency d-flex align-items-center">
                          <div class="cp-header2-order-tack"  style="color:white;">
                           <a href="{{ url('contact-us').'/'}}" style="color:white;">Contact Us</a>
                        </div>
                        <div class="cp-header2-order-tack"  style="color:white;">
                           <a href="{{ url('why-mbp').'/'}}" style="color:white;">Why MBP</a>
                        </div>
                        
                    <div class="cp-header2-order-tack"  style="color:white;">
                 <a href="{{ url('blog').'/'}}" style="color:white;">Latest Blogs</a>
                            
                              
                              
                        </div>
                         
                        <div class="cp-header2-order-tack">
                                <div class="cart-container">
                                    <a href="{{url('cart').'/'}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="1.3em" height="1.3em" fill="currentColor" class="cart-icon"><path d="M528.12 301.319l47.273-208C578.806 78.301 567.391 64 551.99 64H159.208l-9.166-44.81C147.758 8.021 137.93 0 126.529 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24h69.883l70.248 343.435C147.325 417.1 136 435.222 136 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-15.674-6.447-29.835-16.824-40h209.647C430.447 426.165 424 440.326 424 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-22.172-12.888-41.332-31.579-50.405l5.517-24.276c3.413-15.018-8.002-29.319-23.403-29.319H218.117l-6.545-32h293.145c11.206 0 20.92-7.754 23.403-18.681z"/></svg>
                                        <span class="cart-badge" id="cart-count">{{$cartCount}}</span>
                                    </a>
                                </div>
                        </div>
                       
                     </div>
                  </div>
               </div>
            </div>
         </div>
            </div>
         </div>
         <style>
             @media (min-width: 992px) {
.dropdown-menu1.mega-dropdown-2 {
        min-width: 600px !important;
    }
}
.navbar-expand-xl .navbar-nav .dropdown-menu {
    box-shadow: rgba(0, 0, 0, 0.05) 0 13px 42px 11px;
    border: 0;
}
@media (min-width: 1200px) {
    .navbar-expand-xl .navbar-nav .dropdown-menu {
        position: absolute;
    }
}
.navbar-nav .dropdown-menu {
  
      float: none;
}

.dropdown-menu {
 
    top: 100%;
    left: 0;
    z-index: 1000;
    padding: .5rem 0;
    margin: .125rem 0 0;
    font-size: 1rem;
    color: #212529;
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box; 
    border-radius: .25rem;
}
@media (min-width: 992px) {
    .mega-dropdown-items {
        width: 45% !important;
        display: inline-block !important;
    }
}
ul li {
    list-style-type: none;
}
.navbar-nav:not(.sm-collapsible) .sm-nowrap>li>.dropdown-item {
    white-space: nowrap;
}
         </style>
         
    
         <div id="menu-show-hide" class="header-main header-main1 mobile-space1 lh-1">
            <div class="container-fluid">
               <div class="row align-items-center">
                  <div class="col-xl-3 col-6">
                     <div class="logo">
                           <a href="{{url('/')}}"><img src="{{url('my-box-printing-logo.svg')}}" alt="MYBOX Printing Logo" width="300" height="60" onerror="this.onerror=null; this.src='{{ url('assets/img/my-box-printing-logo.svg') }}';" ></a>
                     </div>
                  </div>
                  <div class="col-xl-9 col-6">
                     <div class="menu-btn-wrap d-flex align-items-center justify-content-end">
                         <!-- Mobile Search Bar -->
                         <div class="d-xl-none mobile-search-header">
                            <input type="checkbox" id="mobile-header-search-toggle" class="mobile-search-checkbox">
                            <label for="mobile-header-search-toggle" class="mobile-search-icon">
                                <i class="fal fa-search"></i>
                            </label>
                            <!-- Simple Dropdown Search -->
                            <div class="mobile-search-dropdown">
                                <form action="{{url('search').'/'}}" method="post" enctype="multipart/form-data" class="mobile-search-form">
                                    @csrf
                                    <div class="mobile-search-wrapper-dropdown">
                                        <input type="text" name="search" placeholder="Search..." required class="mobile-search-input-dropdown">
                                        <button type="submit" class="mobile-search-submit-dropdown">
                                            <i class="fal fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                         </div>
                         
                        <div class="main-menu main-menu1">
                           <nav id="mobile-menu">
                               
                                  
                              <ul>
                                    <li><a href="{{url('/')}}">Home</a></li>
                                      @foreach ($parent_category as $mainCate)
                                 <li class="menu-item-has-children">
                                    <a href="{{  url(str_replace( ' ','-',strtolower($mainCate->cate_url))).'/'}}">{{ $mainCate->cate_name }}</a>
                                    <ul class="sub-menu dropdown-menu1 mega-dropdown-2">
                                      @php
                                          $subcategories = collect($all_subcategory)->filter(function($subCate) use ($mainCate) {
                                              return $subCate->parent_cate == $mainCate->id;
                                          })->sortBy(function($item) {
                                              // Put "Retail Boxes" first (like Cardboard Boxes position)
                                              if (stripos($item->cate_name, 'Retail Boxes') !== false) {
                                                  return '0';
                                              }
                                              // Put "Cardboard Boxes" after Retail Boxes
                                              if (stripos($item->cate_name, 'Cardboard Boxes') !== false) {
                                                  return '1';
                                              }
                                              // Keep other items in their original order
                                              return $item->id;
                                          })->values();
                                      @endphp
                                      @foreach ($subcategories as $subCate)
                                       <li class="menu-item mega-dropdown-items ">
                                        
                                          <a href="{{ url(str_replace( ' ','-',strtolower($subCate->cate_url))).'/'}}">   <img src="{{url('images').'/'.$subCate->cate_image}}"  style="width:50px;height:50px;">  {{$subCate->cate_name}}</a>
                                             
                                       </li>
                                  @endforeach
                                    </ul>
                                 </li>
                             @endforeach
                             
                             
                             
                              <li><a   href="{{ url('printing-products').'/'}}">Printing Products</a></li>
                                <!--<li><a href="{{url('why-mbp').'/'}}">Why MBP</a></li>-->
                                <li class="just-on-mobile"><a href="{{url('blog').'/'}}">Latest Blogs</a></li>
                        
                                <li class="search-toggle-wrapper">
                                  <input type="checkbox" id="search-toggle-mobile" class="search-toggle-checkbox">
                                  <label for="search-toggle-mobile" class="cp-search-btn-toggle">
                                      <i class="fal fa-search"></i>
                                  </label>
                                  <div class="cp-filter-search p-relative inline-search-container">
                                      <form action="{{url('search').'/'}}" method="post" enctype="multipart/form-data" class="modern-search-form">
        @csrf
        <div class="modern-search-container">
            <input type="text" name="search" placeholder="Search..." required class="modern-search-input">
            <button type="submit" class="modern-search-button">
                <i class="fal fa-search"></i>
            </button>
        </div>
    </form>
</div>

                              </li>
                              </ul>
                           </nav>
                        </div>
                        <div class="cp-header-btn d-none d-md-block">
                           <a class="cp-btn" style="background-color:#86c442c7;" href="{{url('beat-my-price/').'/'}}">
                         Beat My Price
                              
                           </a>
                        </div>
                        <div class="cp-header-toggle-btn d-xl-none d-flex align-items-center" style="margin-right: 18px;">
                           <!-- Mobile Search Bar Next to Menu -->
                           <div class="mobile-search-header-menu">
                              <input type="checkbox" id="mobile-header-search-toggle-menu" class="mobile-search-checkbox">
                              <label for="mobile-header-search-toggle-menu" class="mobile-search-icon-menu">
                                  <i class="fal fa-search"></i>
                              </label>
                              <!-- Simple Dropdown Search -->
                              <div class="mobile-search-dropdown-menu">
                                  <form action="{{url('search').'/'}}" method="post" enctype="multipart/form-data" class="mobile-search-form">
                                      @csrf
                                      <div class="mobile-search-wrapper-dropdown">
                                          <input type="text" name="search" placeholder="Search..." required class="mobile-search-input-dropdown">
                                          <button type="submit" class="mobile-search-submit-dropdown">
                                              <i class="fal fa-search"></i>
                                          </button>
                                      </div>
                                  </form>
                              </div>
                           </div>
                           <div class="menu-bar" style="margin-left: 10px;">
                              <button type="button" class="side-toggle" aria-controls="offcanvas-menu" aria-expanded="false">
                                 <div class="bar-icon">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                 </div>
                              </button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </header>
      <!-- side toggle start -->
   <div class="fix">
      <div id="offcanvas-menu" class="side-info">
         <div class="side-info-content">
            <div class="offset-widget offset-logo mb-50">
               <div class="row align-items-center">
                  <div class="col-9">
                     <a href="{{url('/')}}">
                       <img src="{{url('public/my-box-printing-logo.svg')}}" alt="Logo" width="319" height="64" style="width: 319px;margin-left: -51px;">
                     </a>
                  </div>
                  <div class="col-3 text-end">
                     <button class="side-info-close">
                        <i class="fal fa-times"></i>
                     </button>
                  </div>
               </div>
            </div>
            <div class="mobile-menu fix"></div>
            <div class="offset-widget offset-support mb-30">
               <h3 class="cp-offset-widget-title">Contact Info</h3>
               <div class="footer-support">
                  <div class="irc-item support-meta">
                     <div class="irc-item-icon">
                        <i class="fal fa-phone-alt"></i>
                     </div>
                   
                     <div class="irc-item-content">
                        <p><b>Call Now </b></p>
                        <div class="support-number for-mobile1">
                           <a href="tel:847-200-0974"> 847-200-0974</a>
                        </div>
                     </div>
                  </div>
                  <div class="irc-item support-meta">
                     <div class="irc-item-icon">
                        <i class="fal fa-envelope"></i>
                     </div>
                     <div class="irc-item-content">
                        <p><b>Mail Us</b></p>
                        <div class="support-number for-mobile1">
                           <a href="mailto:support@myboxprinting.com">support@myboxprinting.com</a>
                        </div>
                     </div>
                  </div>
                  <div class="irc-item support-meta">
                     <div class="irc-item-icon">
                        <i class="fal fa-map-marker-alt"></i>
                     </div>
                     <div class="irc-item-content">
                        <p><b>Location</b></p>
                        <div class="support-number for-mobile1">
                           <a href="#" target="_blank">9933 Franklin Ave,
Suite # 112
Franklin Park, IL 60131, United States</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
       
         </div>
      </div>
   </div>
   
   <!-- side toggle end -->

   <div class="offcanvas-overlay"></div>
   <div class="offcanvas-overlay-white"></div>
   
   <script>
   // Immediate Mobile Menu Toggle (Vanilla JS)
   document.addEventListener('DOMContentLoaded', function() {
       var sideToggles = document.querySelectorAll('.side-toggle');
       var sideInfo = document.querySelector('.side-info');
       var overlay = document.querySelector('.offcanvas-overlay');
       var closeBtn = document.querySelector('.side-info-close');
       
       function openMenu() {
           if(sideInfo) sideInfo.classList.add('info-open');
           if(overlay) overlay.classList.add('overlay-open');
       }
       
       function closeMenu() {
           if(sideInfo) sideInfo.classList.remove('info-open');
           if(overlay) overlay.classList.remove('overlay-open');
       }
       
       if (sideToggles.length > 0) {
           sideToggles.forEach(function(btn) {
               btn.addEventListener('click', function(e) {
                   e.preventDefault();
                   openMenu();
               });
           });
       }
       
       if (closeBtn) {
           closeBtn.addEventListener('click', function(e) {
               e.preventDefault();
               closeMenu();
           });
       }
       
       if (overlay) {
           overlay.addEventListener('click', function(e) {
               e.preventDefault();
               closeMenu();
           });
       }
   });
   
   // Close search bar when clicking outside
   document.addEventListener('click', function(event) {
       // Use setTimeout to allow the checkbox state to update first
       setTimeout(function() {
           // Desktop search bar
           const desktopSearchToggle = document.getElementById('search-toggle-mobile');
           const desktopSearchContainer = document.querySelector('.inline-search-container');
           const desktopSearchLabel = document.querySelector('label[for="search-toggle-mobile"]');
           
           // Mobile header search bar
           const mobileHeaderToggle = document.getElementById('mobile-header-search-toggle');
           const mobileHeaderContainer = document.querySelector('.mobile-search-dropdown');
           const mobileHeaderLabel = document.querySelector('label[for="mobile-header-search-toggle"]');
           
           // Mobile menu search bar
           const mobileMenuToggle = document.getElementById('mobile-header-search-toggle-menu');
           const mobileMenuContainer = document.querySelector('.mobile-search-dropdown-menu');
           const mobileMenuLabel = document.querySelector('label[for="mobile-header-search-toggle-menu"]');
           
           // Check desktop search
           if (desktopSearchToggle && desktopSearchToggle.checked) {
               if (desktopSearchContainer && !desktopSearchContainer.contains(event.target) && 
                   desktopSearchLabel && !desktopSearchLabel.contains(event.target) &&
                   event.target !== desktopSearchToggle) {
                   desktopSearchToggle.checked = false;
               }
           }
           
           // Check mobile header search
           if (mobileHeaderToggle && mobileHeaderToggle.checked) {
               if (mobileHeaderContainer && !mobileHeaderContainer.contains(event.target) && 
                   mobileHeaderLabel && !mobileHeaderLabel.contains(event.target) &&
                   event.target !== mobileHeaderToggle) {
                   mobileHeaderToggle.checked = false;
               }
           }
           
           // Check mobile menu search
           if (mobileMenuToggle && mobileMenuToggle.checked) {
               if (mobileMenuContainer && !mobileMenuContainer.contains(event.target) && 
                   mobileMenuLabel && !mobileMenuLabel.contains(event.target) &&
                   event.target !== mobileMenuToggle) {
                   mobileMenuToggle.checked = false;
               }
           }
       }, 10);
   });
   </script>
   
   