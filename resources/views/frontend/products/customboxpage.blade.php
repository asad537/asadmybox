@include('frontend/header')
 
<style>
  #text11 {
    display: none;
  }
    #text1 {
    display: none;
  }
  
</style>
<style>

.accordion-button:not(.collapsed) {
    color: #ffffff !important;
    background-color: #86c542 !important;
    box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.125);
}



    .cp-banner-height {
    min-height:auto !important;

        
        
    }
    
 .cp-testimonial2-icon2 {
    left: 8px;
       top: 80px !important;

    -webkit-transform: rotate(180deg);
    -moz-transform: rotate(180deg);
    -ms-transform: rotate(180deg);
    transform: rotate(180deg);
}
.cp-testimonial2-icon1 {
    right: 15px !important;
    bottom: 23px !important;
}

    .cp-testimonial2-text p {
   
    line-height: 30px !important;
}


 .cp-testimonial2-text p{
     font-size:20px !important;
 }
</style>
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

     <section class="page-title-area breadcrumb-spacing cp-bg-14">
      
        </section>
        
<main class="main">
                   @if (Session::has('message'))
            <div class="alert alert-success session-destroy my-sm-0 py-sm-3 text-center">
                    <?php echo Session::get('message'); ?>
            </div>
        @endif
    <div class="" style="background: #978F64; padding: 0px 0px 0px 0px;height: 60px;">
        <div class="container">
         
        
            <div class="text-center">
               
                    <h1 style="color: #fff; font-size: 30px; line-height: 60px; font-weight: 600;">CUSTOM BOX PACKAGING</h1>
                   
               
            </div>
        </div>
    </div>
    <div class="" style="background:#e1dec4;padding: 10px 25px 10px 40px;">
        <div class="row" style="align-items:center;">
            <div class="col-md-6">
                <div style="">
                    <h2 style="color: black;font-weight: 600;font-size: 33px;">
                       Turn Ideas Into Custom Boxes
                    </h2>
                    <p style="color: black;font-size: 17px;text-align:justify;">
                     
                     Customization is the key to standing out in any platform, your product should attract customers by its appearance in one glance. Adding value to your product not only increases sales but also leaves a permanent impact on the customer.
Custom boxes are a great way for branding, and also, your product has a perfect fit in them.    We at <a href="{{url('/')}}" style="color:#86C442;">MyBoxPrinting</a> give you wide customization options that elevate your brand and make your brand worth more.


							
                        		
                    
                    </p>
     <p style="color: black;font-size: 17px; text-align:justify">
             
There are unlimited types of boxes that give the freedom of branding how you want it to be. The look of the product is enhanced by the box in which it is kept. Not only this, the customer will have an extraordinary unboxing experience that is also unforgettable.
Being the owner of your brand, you know the basic needs for your product. Here’s an overview of custom boxes from idea to finished product.

	
                    
                    

                    </p>

                </div>
            </div>

            <div class="col-md-6">
                <div class="">
                    <img alt="custom boxes" src="{{url('customboxes/custom design 2.png')}}" style="width:100%;" />
                </div>
            </div>
        </div>
    </div>
    <!--<div class="pt-2 pb-2" style="background: #637553 !important;border-top: 1px solid #e7e7e7;">-->
    <!--    <div class="container">-->
    <!--        <div class="row" style="align-items:center;">-->
    <!--            <div class="col-md-7">-->
    <!--                <div class="">-->
    <!--                    <p class="mb-0 para-star" style="color:white;">Feedback from our valued customers-->
    <!--                        <span class="five stars ml-3" title="five stars">★</span>-->
    <!--                        <span class="five stars" title="five stars">★</span>-->
    <!--                        <span class="five stars" title="five stars">★</span>-->
    <!--                        <span class="five stars" title="five stars">★</span>-->
    <!--                        <span class="five stars" title="five stars">★</span>-->
    <!--                    </p>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="col-md-5">-->
    <!--                <div class="d-inline-flex">-->
    <!--                    <div class="pt-2 pb-2 pl-3 pr-3">-->
    <!--                        <a href="#" target="_blank">-->
    <!--                        <img src="{{url('box_assets/img/google-reviws-logo.webp')}}" style="width: 100px;" alt="google-review">-->
    <!--                        </a>-->
    <!--                    </div>-->
                        <!--<div class="pt-2 pb-2 pl-3 pr-3">-->
                        <!--    <a href="#" target="_blank">-->
                        <!--    <img src="{{url('box_assets/img/Trust-pilot_1.png')}}" style="width: 100%;" alt="Trust-pilot">-->
                        <!--    </a>-->
                        <!--</div>-->
                        
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
    <style>
   .slider-wrapper {
      position: relative;
      overflow: hidden;
    }

    .slider-track {
      display: flex;
      gap: 20px;
      transition: transform 0.3s ease;
      scroll-behavior: smooth;
      overflow-x: auto;
      padding: 10px 40px;
    }

    .slider-track::-webkit-scrollbar {
      display: none;
    }

    .product-single {
      width: 230px;
      height: 230px;
      background-color: white;
      border-radius: 16px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.08);
      overflow: hidden;
      flex-shrink: 0;
      text-align: center;
    }

    .product-thumb img {
      width: 100%;
      height: 150px;
      object-fit: cover;
      border-bottom: 1px solid #eee;
    }

    .product-description {
      padding: 10px;
    }

    .product-description h4 {
      font-size: 16px;
      margin: 0;
    }

    .slider-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: black;
      color: white;
      border: none;
      border-radius: 50%;
      width: 36px;
      height: 36px;
      cursor: pointer;
      z-index: 1;
    }

    .slider-btn.left {
      left: 5px;
    }

    .slider-btn.right {
      right: 5px;
    }
    .box-card {
  width: 230px;
 
  background-color: white;
  border-radius: 16px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.08);
  overflow: hidden;
  flex-shrink: 0;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  text-align: center;
}

.box-image {
  width: 100%;
  height: 180px;
  object-fit: cover;
  display: block;
}

.box-title {
  padding: 8px;
 
}

.box-title h4 {
  margin: 0;
  font-size: 14px;
  font-weight: bold;
  color: black;
}

.box-title h4 a {
  text-decoration: none;
  color: inherit;
}.slider-btn {
  width: 48px;
  height: 48px;
  font-size: 18px;
  background: rgba(0,0,0,0.85);
}



  </style>
  
      <section class="cp-services-area pb-20 p-relative z-index-1 mt--20 pt-20 hide-on-mobile">
            
            <div class="container">
            <div class="row align-items-end">
            
            
            <div class="cp-cta2-title mb-0 pt-20">
            <p style="font-size: 45px; color: rgb(33 37 41 / var(--tw-text-opacity,1));    font-weight: 600;text-align:center;"> Hot Selling Custom Boxes 
            </p>
            </div>
            
            </div></div>
            
            </section>
    <div class="product-area" style="    margin-bottom: 30px;">
            <div class="container"  style="max-width:95%;">
                  <div class="col-xl-12 col-lg-12 order-lg-2">
                        <div class="cp-product-right" style="">
                           
                         <div class="row">
<div class="slider-wrapper">
  <button class="slider-btn left" onclick="scrollSlider(-1)"><i class="fas fa-chevron-left"></i></button>
  <button class="slider-btn right" onclick="scrollSlider(1)"><i class="fas fa-chevron-right"></i></button>

  <div class="slider-track" id="productSlider">
 

<div class="box-card">
  <a href="{{url('custom-shipping-boxes').'/'}}">
    <img class="box-image" src="{{url('images/custom-shipping-boxes.webp')}}" alt="custom shipping boxes">
  </a>
  <div class="box-title">
    <h4><a href="{{url('custom-shipping-boxes').'/'}}">Custom Shipping Boxes</a></h4>
  </div>
</div>


<div class="box-card">
  <a href="{{url('cardboard-boxes').'/'}}">
    <img class="box-image" src="{{url('images/Cardboard-Boxes.webp')}}" alt="cardboard boxes">
  </a>
  <div class="box-title">
    <h4><a href="{{url('cardboard-boxes').'/'}}">Cardboard Boxes</a></h4>
  </div>
</div>

<div class="box-card">
  <a href="{{url('mailer-boxes').'/'}}">
    <img class="box-image" src="{{url('images/Mailer-boxes.webp')}}" alt="mailer boxes">
  </a>
  <div class="box-title">
    <h4><a href="{{url('mailer-boxes').'/'}}">Mailer Boxes </a></h4>
  </div>
</div>


<div class="box-card">
  <a href="{{url('luxury-rigid-boxes').'/'}}">
    <img class="box-image" src="{{url('images/elegant-tie-packaging.webp')}}" alt="luxury rigid boxes">
  </a>
  <div class="box-title">
    <h4><a href="{{url('luxury-rigid-boxes').'/'}}">Luxury Rigid Boxes </a></h4>
  </div>
</div>

<div class="box-card">
  <a href="{{url('bakery-boxes-with-window').'/'}}">
    <img class="box-image" src="{{url('images/bakery-boxes-with-window.webp')}}" alt="bakery boxes with window">
  </a>
  <div class="box-title">
    <h4><a href="{{url('bakery-boxes-with-window').'/'}}">Bakery Boxes With Window</a></h4>
  </div>
</div>

<div class="box-card">
  <a href="{{url('business-card-boxes').'/'}}">
    <img class="box-image" src="{{url('images/business-card-boxes.webp')}}" alt="business card boxes">
  </a>
  <div class="box-title">
    <h4><a href="{{url('business-card-boxes').'/'}}">Business Card Boxes
</a></h4>
  </div>
</div>

<div class="box-card">
  <a href="{{url('eco-friendly-boxes').'/'}}">
    <img class="box-image" src="{{url('images/eco-friednly-boxes.webp')}}" alt="eco friendly boxes">
  </a>
  <div class="box-title">
    <h4><a href="{{url('eco-friendly-boxes').'/'}}">Eco Friendly Boxes
</a></h4>
  </div>
</div>


<div class="box-card">
  <a href="{{url('cosmetic-boxes').'/'}}">
    <img class="box-image" src="{{url('images/Cosmetic-Boxes.webp')}}" alt="cosmetic boxes">
  </a>
  <div class="box-title">
    <h4><a href="{{url('cosmetic-boxes').'/'}}">Cosmetic Boxes
</a></h4>
  </div>
</div>

 
  </div>
</div>



  <!-- Repeat similar structure for more boxes -->
  
</div>

                          
                        </div>
                    </div>
            </div>
        </div>
    
    
    <div class="" style="padding: 50px 0px; background: #f6fff2;">
        <div class="container">
            <div class="row">
                 <div class="col-md-6 p-0">
                    <div class="">
                        <img alt="eco friendly packaging solutions" src="{{url('customboxes/eco-friendly.png')}}" style="width: 100%; padding: 0px 20px;" />
                    </div>
                </div>
                <div class="col-md-6" style="display: inline-flex; align-items: center; padding: 0px 30px 0px 50px;">
                    <div style="">
        
                        <h2 style="color: black;font-weight: 600;font-size: 30px; ">
           Eco-Friendly Packaging Solutions
                        </h2>
                        <p style="color: black;font-size: 17px;    text-align: justify;">
                       We at MyBoxPrinting offer eco-friendly, sustainable solutions to your packaging problems. At one stop, you can avail the following services.

                        </p>
  <style>
  .three-column-list {
    display: flex;
    flex-wrap: wrap;
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .three-column-list li {
    flex: 1 0 50%;
    padding: 8px;
    box-sizing: border-box;
  }
</style>
              
              
                        <ul class="three-column-list" style="    margin-left: 15px;">
 <li style="list-style: disc;color: black !important;"><a href="{{url('retail-boxes').'/'}}" style="color:#176700;">Retail Packaging</a></li>
                              
 <li style="list-style: disc;color: black !important;">Custom Boxes</li>
  <li style="list-style: disc;color: black !important;"><a href="{{url('gift-boxes').'/'}}" style="color:#176700;">Gift Packaging</a></li>
  <li style="list-style: disc;color: black !important;">Mylar Packaging</li>

    <li style="list-style: disc;color: black !important;"><a href="{{url('cosmetic-boxes').'/'}}" style="color:#176700;">Cosmetic Packaging</a></li>

 <li style="list-style: disc;color: black !important;">Cardboard Packaging</li>
  
<li style="list-style: disc;color: black !important;"><a href="{{url('cbd-packaging').'/'}}" style="color:#176700;">CBD Packaging</a></li>
 <li style="list-style: disc;color: black !important;">Rigid Packaging</li>


                                 </ul>
                       
                        <span id="text11">
                            <div class="comment1 more1">                  
                                <span class="read-more-content1">
                                 
             

                       <ul class="three-column-list" style="    margin-left: 15px;">


<li style="list-style: disc;color: black !important;">Bakery Packaging</li>
<li style="list-style: disc;color: black !important;">Tobacco Packaging</li>

  <li style="list-style: disc;color: black !important;">Kraft Packaging</li>

  <li style="list-style: disc;color: black !important;">Luxury-Branded Boxes</li>
  <li style="list-style: disc;color: black !important;">Display Packaging</li>
    <li style="list-style: disc;color: black !important;">Shipping and Mailer Boxes</li>
    <li style="list-style: disc;color: black !important;">Eco-Friendly Packaging</li>
  <li style="list-style: disc;color: black !important;">Food & Beverage Packaging</li>
    <li style="list-style: disc;color: black !important;">Rectangular and Metalized Packaging</li>
</ul>
<p style="color:black; text-align:justify;">
    We are dealing with all of the above-mentioned industries and many others as well.
There is no hard and fast rule for the box packaging. We only require the dimensions of the product to customize it accordingly.

</p>
                                </span>
                            </div>
                        </span>
                        <div class="btn-container">
                            <button id="toggle11" style="color:white !important;background-color:black !important;">Read More</button>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
     
    <div class="" style="background: rgb(247, 247, 247); padding-top: 25px;">
        <div class="container">
            <div class="text-center">
                <h2 style="color: rgb(33, 33, 33);font-weight: 600;font-size: 35px;">Key Features</h2>
                <p style="color: rgb(0, 0, 0);">Stand Out from the Norm</p>
            </div>
            <div class="pb-4">
                <div class="row">
                    <div class="col-sm-12 col-md-3" >
                        <div class="feature-box text-center pb-4" style="background-color: #EEC9B8; border-radius: 9px; padding: 25px 10px 0px 10px;height: 352px;">
                            <a href="#order" class="link-to-tab">
                                <i class="">
                                    <img alt="customer support" src="{{url('icon/free-logo-and-customer-support-oicon.png')}}" />
                                </i>
                            </a>
                            <div class="feature-box-content" >
                                <h4 style="font-weight: 600;color: black;    margin-top: 10px;">Free Design Support</h4>
                                <p style="color: rgb(0, 0, 0);font-size: 16px;text-align:justify;">
                                We offer free design support for your custom box as well as free logo services. For your custom product, we create custom product boxes.
                                </p>
                            </div>
                        </div>
                    </div>
                         <div class="col-sm-12 col-md-3">
                        <div class="feature-box text-center pb-4" style="background-color: #D2F7D6; border-radius: 9px; padding: 25px 10px 0px 10px;height: 352px;">
                            <a href="#order" class="link-to-tab">
                                <i class="">
                                    <img alt="affordable prices" src="{{url('icon/affordable-price-icon.png')}}" />
                                </i>
                            </a>
                            <div class="feature-box-content">
                                <h4 style="font-weight: 600;color: black;    margin-top: 10px;">Affordable Prices 
</h4>
                                <p style="color: rgb(0, 0, 0);font-size: 16px;text-align:justify;">
                                  Our prices are very reasonable, and the quality we offer is high-end. This makes our customers satisfied.
                                </p>
                            </div>
                        </div>
                    </div>
                          <div class="col-sm-12 col-md-3">
                        <div class="feature-box text-center pb-4" style="background-color: #FFD6EE; border-radius: 9px; padding: 25px 10px 0px 10px;height: 352px;">
                            <a href="#order" class="link-to-tab">
                                <i class="">
                                    <img alt="no minimum order quantity policy" src="{{url('icon/no-moq-icon.png')}}" />
                                </i>
                            </a>
                            <div class="feature-box-content">
                                <h4 style="font-weight: 600;color: black;   margin-top: 10px;">No MOQ</h4>
                                <p style="color: rgb(0, 0, 0);font-size: 16px;text-align:justify;">
                                 We have no minimum order quantity (MOQ) policy, whether it is a small order or a larger order. We give our full support to our clients, which helps them not to worry about the budget.
                                </p>
                            </div>
                        </div>
                    </div>
                           <div class="col-sm-12 col-md-3">
                        <div class="feature-box text-center pb-4" style="background-color:#FDFAB6; border-radius: 9px; padding: 25px 10px 0px 10px;height: 352px;">
                            <a href="#order" class="link-to-tab">
                                <i class="">
                                    <img alt="no cost on shipping" src="{{url('icon/free-shipping-icon.png')}}" />
                                </i>
                            </a>
                            <div class="feature-box-content">
                                <h4 style="font-weight: 600;color: black;    margin-top: 10px;">Free Shipping</h4>
                                <p style="color: rgb(0, 0, 0);font-size: 16px;text-align:justify;">
                      Our shipping method is smooth. Once your order is completed, we offer free shipping across the United States of America to your doorstep.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="" style="padding:20px 0px; background:#E7E4CC;">
        <div class="container">
            <div class="row">
                <div class="col-md-6" style="display: inline-flex; align-items: center; padding: 0px 30px 0px 50px;">
                    <div style="">
        
                        <h2 style="color: black;font-weight: 600;font-size: 30px; ">
                    How It Works!
                        </h2>
                        <p style="color: black;font-size: 17px;">
                     Let's learn the process! How to order custom-printed boxes.

                        </p>
                        <h3 style="color: black;">
                            1. Choose The Right Box

                        </h3>
                        <p style="color: black; font-size: 17px; text-align:justify;">
                         Custom packaging includes shipping box, rigid box, <a href="{{url('mailer-boxes').'/'}}" style="color:#86C442;">mailer box</a>, or <a href="{{url('product-boxes').'/'}}" style="color:#86C442;">product box</a>, you need to figure out which one will work for your brand
                        </p>
                        <h3 style="color: black;">
                                      2.  Configure Your Box Measurements
                                    </h3>
                                    <p style="color: black; font-size: 17px;text-align:justify;">
                                      Measure your product and pick the shape for your packaging boxes. So that the product fit in perfectly.</p>
                                  
                                  <h3 style="color: black;">
                                     3.  Design Your Box

                                  </h3>
                                   <p style="color: black; font-size: 17px;text-align:justify;">
                                    After all of the details are clear, our designer will make a mock-up design for approval. When you approve the design, our production will get started.</p>
                                    
                                    
                        
                        <span id="text">
                            <div class="comment more mt-3">                  
                                <span class="read-more-content">
                                    
                                    
                                       <h3 style="color: black;">
                                   4.   Proofing Process

                                  </h3>
                                   <p style="color: black; font-size: 17px;text-align:justify;">
                                     Once a sample is made, we send our design to the customer if he demands. So that the customer can verify all the details by putting the product in the box.</p>
                                     
                                           <h3 style="color: black;">
                                  5.   Receiving Your Box

                                  </h3>
                                   <p style="color: black; font-size: 17px;text-align:justify;">
                                    Once everything is finalized, you will receive your retail packaging order within 5 to 10 business days.</p>
                                    
                                    
                                       <h3 style="color: black;">
                               6.   Assembling Your Box
                                  </h3>
                                   <p style="color: black; font-size: 17px;text-align:justify;">
                                    You can assemble your box by yourself, and your custom-printed box is ready to elevate your brand appearance and for an unforgettable unboxing experience.</p>
                                    
                                    
                                    
                                
                                    
                                    
                                    
                                    
                                    
                                </span>
                            </div>
                        </span>
                        <div class="btn-container">
                            <button id="toggle" style="color:white !important;background-color:black !important;">Read More</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 p-0">
                    <div class="">
                        <img alt="how custom box packaging works" src="{{url('how-it-1-works.png')}}" style="width: 100%; padding: 0px 20px;" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    
    
   
    
    
    
    <div class="" style="padding: 50px 0px;">
        <div class="container">
            <div class="row">
                <div class="col-md-5 p-0">
                    <div class="">
                        <img alt="customization importance over non customization" src="{{url('customboxes/Customized-3.png')}}" style="width: 100%; padding: 0px 20px;" />
                    </div>
                </div>
                <div class="col-md-7" style="display: inline-flex; align-items: center; padding: 0px 30px 0px 50px;">
                    <div style="">
                     
                        <h2 style="color: rgb(0, 0, 0);font-weight: 600;font-size: 30px;">
                       Why Is Customization Important?

                        </h2>
                        <p style="color: rgb(0, 0, 0);font-size: 17px;text-align:justify">
                      Customization in any brand makes it unique and stands out from other brands. Every business has a story that is depicted from its packaging, the unboxing experience that brings joy.</p>
                   <p style="color: rgb(0, 0, 0);font-size: 17px;text-align:justify">
                          Custom box style is linked to a specific brand, and we make it durable and stylish, using corrugated cardboard and kraft. Also, you can add a logo to your box with premium printing and designing services.
                      </p>
                       
                                    
                                    <p style="color: rgb(0, 0, 0);font-size: 17px;text-align:justify">
                                 It becomes a style statement of your brand to choose from custom designs. Our design team makes sure that the design is up to date and according to the current market trends. </p>
                         
                             
                       
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    
 
      
          <section class="cp-feature-area p-relative cp-bg-2 zi-1 pt-10 pb-10" style="background-color:#D4F3E5 !important;">
         
         <div class="container">
             
              <div class="row justify-content-center">
               <div class="col-xl-12 col-lg-12">
                        <div class="cp-cta2-title mb-0 pt-30" >
            <p style="font-size: 30px; color: rgb(33 37 41 / var(--tw-text-opacity,1)); margin-top: -10px;    font-weight: 600;">Order a Free Custom Box
           <span class="hide-on-mobile separator-text" style="font-weight: 100;">Order free MyBoxPrinting sample to experience Luxury</span>
            
            </p>
            </div>
            </div>
            
        
          <div class="row">

  <div class="col-lg-9">
                    
                    <div class="cp-quote-wrapper">
                    
                     <div class="cp-quote-form">
                                           <form action="{{url('customboxes_form_submit').'/'}}" method="post">
                     
                            @csrf
                           <div class="cp-quote-box mb-10">
                              
                      
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
                    
          <div class="col-xl-4 col-lg-4 for-the-mobile">
              
              
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
                                   <div class="g-recaptcha" id="custombox-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}" data-callback="onCustomboxCaptchaSuccess"></div>
                                   <div id="custombox-captcha-error" style="color: #fff; font-size: 14px; font-weight: bold; margin-top: 10px; display: none; padding: 12px; background: #dc3545; border-radius: 5px;">
                                       ⚠️ Please complete the reCAPTCHA verification before submitting
                                   </div>
                               </div>
                              <button type="submit" class="" style="background-color:#6CCFA0; color:white;">Order Now</button>
                           </div>
                        </form>
                        
                        <script>
                        var customboxCaptchaCompleted = false;
                        
                        function onCustomboxCaptchaSuccess(token) {
                            customboxCaptchaCompleted = true;
                            var errorDiv = document.getElementById('custombox-captcha-error');
                            if (errorDiv) {
                                errorDiv.style.display = 'none';
                            }
                        }
                        
                        (function() {
                            function initCustomboxFormValidation() {
                                var forms = document.querySelectorAll('form[action*="customboxes_form_submit"]');
                                var errorDiv = document.getElementById('custombox-captcha-error');
                                
                                if (forms.length === 0) return;
                                
                                forms[0].onsubmit = function(event) {
                                    if (!customboxCaptchaCompleted) {
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
                                            
                                            customboxCaptchaCompleted = false;
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
                                document.addEventListener('DOMContentLoaded', initCustomboxFormValidation);
                            } else {
                                initCustomboxFormValidation();
                            }
                        })();
                        </script>
                     </div>
                  </div>
                    </div>
                    
                      <div class="col-lg-3">
                          <img src="{{url('custom-quote.png')}}" alt="get free quote" style="height:100%;Width:100%;">
                          </div>
                     </div>
         </div>
      </section>
    
    <div class="" style="background:#6CCFA0;">
        <div class="container text-center" style="padding: 20px 0px 0px 0px;
    height: 60px;">
            <h2 style="color:white; font-weight: 600;font-size: 20px;">
                   MyBoxPrinting - Sustainability with Luxury Where Packaging Meets Excellence !
 
 
            </h2>
        </div>
    </div>
    <div class="" style="padding: 20px 0px 0px;">
     
        <div class="container">
            <h2 class="mb-10 text-center" style="color: black;font-weight: 600;font-size: 45px;">
               High Quality Material
            </h2>
            <div class="row">
                <div class="col-md-3">
                    <div class="feature-box mx-md-3 feature-box-simple text-center">
                        <img class="mb-3" alt="corrugated cardboard" src="{{url('customboxes/Corrugated cardboard.png')}}" style="display: inline-flex;"/>
                        <div class="feature-box-content">
                            <h3 class="mb-2" style="font-size: 20px;font-weight: 600;"> Corrugated Cardboard</h3>
                            <!--<p style="color: #000000;">Corrugated Cardboard is Made From Paper Pulp.</p>-->
                        </div>
                       
                    </div>
                   
                </div>
                <div class="col-md-3">
                    <div class="feature-box mx-md-3 feature-box-simple text-center">
                        <img class="mb-3 mt-1" alt="kraft" src="{{url('customboxes/Kraft material-2.png')}}" style="display: inline-flex;"/>
                        <div class="feature-box-content">
                            <h3 class="mb-2" style="font-size: 20px;font-weight: 600;">Kraft</h3>
                   <!--<p style="color: #000000;">Kraft is Made Up of Wood Pulp And Is Mostly Used For Food Packaging</p>-->
                        </div> 
                    </div>
                   
                </div>
                <div class="col-md-3">
                    <div class="feature-box mx-md-3 feature-box-simple text-center">
                        <img class="mb-3 mt-1" alt="paper packaging" src="{{url('customboxes/paper-packaging-2.png')}}" style="display: inline-flex;" />
                        <div class="feature-box-content">
                            <h3 class="mb-2" style="font-size: 20px;font-weight: 600;">Paper Packaging</h3>
                              <!--<p style="color: #000000;"> Paper Packaging Is Wood Pulp And Also Recycleable</p>-->

                        </div>
                      
                    </div>
          
                </div>
                
                 <div class="col-md-3">
                    <div class="feature-box mx-md-3 feature-box-simple text-center">
                        <img class="mb-3" alt="chipboard" src="{{url('customboxes/chipboard.png')}}" style="display: inline-flex;"/>
                        <div class="feature-box-content">
                            <h3 class="mb-2" style="font-size: 20px;font-weight: 600;"> ChipBoard</h3>
                            <!--<p style="color: #000000;">Chipboard is Harder Form of Material Mostly Used in Rigid Boxes</p>-->
                        </div>
                      
                    </div>
             
                </div>
            </div>
        </div>
    </div>
  
     <div class="" style="padding: 10px 0px 0px;">
       <div class="container my-5">
 
    <h2 style="font-size:30px !Important;color:black;">Order Custom Boxes</h2>
    <p style="color:black;text-align:justify;">Boxes are the keepers, they keep the product in an environment that gives a secure place.</p>
    <p style="color:black;text-align:justify;">You've got an idea about your product, and you want to make it happen with a custom size or shape, or printing designs, we can make it happen for you. What we do is work on your idea and provide you with the product.</p>

    <h2 style="font-size:22px !Important;color:black;">For Better Understanding</h2>

    <h3 style="font-size:18px;color:black;">Idea</h3>
    <p style="color:black;text-align:justify;">You already have an idea about how your product will look better, in what type of packaging, what kind of printing, and what kind of customization is needed. We streamline your ideas and make a mockup for our customers.</p>

    <h3 style="font-size:18px !Important;color:black;">Customization</h3>
    <p style="color:black;text-align:justify;">We will customize according to your given details, if needed, to design from the size of the box and the artwork that will be printed on the box for branding.</p>

    <h3 style="color:black;font-size:18px;">Market Packaging Trends</h3>
    <p style="color:black;text-align:justify;">The market has various trends within a time frame, as the design trend changes. In the past few years, the market has been doing more of a minimalist design that looks appealing as well. Apart from market trends, we are the trendsetters!</p>
    <p style="color:black;text-align:justify;"> We customize and deliver the design that is bold and unique in a way that attracts the customer directly and maximizes your sales. We have made all types of custom boxes; you just name it, we have it.</p>

  <span id="text1">
 <div class="comment more mt-3">                  
 <span class="read-more-content11">
        <h2 style="font-size:22px !Important;color:black;">Get Excellent Trims & Add-ons</h2>
    <p style="color:black;text-align:justify;">We offer different types of add-ons to your custom box, such as embossing, debossing, and foiling.</p>

    <h3 style="font-size:18px;color:black;">Embossing</h3>
    <p style="color:black;text-align:justify;">Embossing means the specific logo or slogan will be shown as a raised impression, which will make it prominent and eye-catching. It will also enhance the appearance of your product.</p>

 <h3 style="font-size:18px;color:black;">Debossing</h3>
    <p style="color:black;text-align:justify;">Debossing is the opposite of embossing; it will put the impression downwards, which is a way to create custom designs and is made by a stylish corrugated cardboard mailer.</p>

    <h3 style="font-size:18px;color:black;">Foiling</h3>
    <p style="color:black;text-align:justify;">We use various types of foiling that will help you to make an attractive and appealing print on the customized box.</p>

    <p style="color:black;text-align:justify;">We have a variety of enhancements that make the box stand out in clusters.</p>
    <ul>
      <li style=" color:black;   list-style-type: disc;margin-left: 20px;">Ribbon tie</li>
      <li style="  color:black;  list-style-type: disc;margin-left: 20px;">Corner ribbon</li>
      <li style="color:black;    list-style-type: disc;margin-left: 20px;">Ribbon bow handle</li>
      <li style=" color:black;   list-style-type: disc;margin-left: 20px;">Magnetic box closure</li>
      <li style="  color:black;  list-style-type: disc;margin-left: 20px;"> Grommet hanging hole</li>
    </ul>
<br>
    <h2 style="font-size:22px !Important;color:black;">Types of Material Used For Custom Boxes</h2>
    <p style="color:black;text-align:justify;">We are an eco-friendly packaging industry that offers customizable options with high-quality biodegradable material. Customers always prefer quality over quantity.</p>

     <h3 style="font-size:18px;color:black;">Corrugated Cardboard</h3>
    <p style="color:black;text-align:justify;">Corrugated cardboard refers to thick paper-pulp that is collectively strong and protective for shipping purposes. You can always pick your custom-printed cardboard box for your brand because it is durable and lightweight at the same time. Custom printing and packaging make your brand look unique. Whether you want digital printing or offset printing, we can provide you with both.</p>

  <h3 style="font-size:18px;color:black;">Kraft</h3>
    <p style="color:black;text-align:justify;">Kraft is made up of 80% wood pulp, its composition makes it ideal for packaging. It is more light-weighted than corrugated cardboard and budget-friendly as well. Packaging for your business can be very crucial and time-consuming to choose from the designs, and order a sample.</p>
    
    
     
    
    <h3 style="font-size:18px;color:black;">Paper Packaging</h3>
  <p style="color:black;text-align:justify;">Paper-based packaging includes products such as cardboard, paperboard, and paper bags. They are made from sustainable and recyclable resources.These types of boxes are used precisely: if there is any document or the product is related to the food industry. They are sustainable, recyclable, and reliable.</p>
 

  <h3 style="font-size:18px;color:black;">Pop-up Lid Boxes</h3>
  <p style="color:black;text-align:justify;">Pop-up lid boxes are mysterious and luxurious. They give the vibe of opening a treasure box, making customers excited to open them. These boxes are also reusable and are commonly used for gifting or long-term storage.</p>

  <h2 style="font-size:22px;color:black;">Packaging in Different Businesses</h2>

  <h3 style="font-size:18px;color:black;">Apparel Industry</h3>
  <p style="color:black;text-align:justify;">The apparel industry is one of the largest industries in the world. It’s more than just a need for clothes—it’s about making a fashion statement. Packaging plays a vital role in presenting these products to customers attractively and securely.</p>

  <h3 style="font-size:18px;color:black;">Male Clothing Industry</h3>
  <p style="color:black;text-align:justify;">For men's clothing, luxurious packaging enhances the value and excitement. Shirt and <a href="{{url('tie-boxes').'/'}}" style="color:#86C342;">tie boxes</a> are great examples of this packaging style.</p>

  <h3 style="font-size:18px;color:black;">Female Clothing Industry</h3>
  <p style="color:black;text-align:justify;">With more product options available, packaging becomes the first impression in the female clothing industry. A well-designed box influences the customer’s decision instantly.</p>

  <h3 style="font-size:18px;color:black;">Food Industry</h3>
  <p style="color:black;text-align:justify;">In the <a href="{{url('food-and-beverage').'/'}}" style="color:#86C342;"> food and beverage industry</a>, hygiene is the top priority. Since it’s a vast and sensitive industry, packaging ensures cleanliness, safety, and product integrity.</p>

  <h3 style="font-size:18px;color:black;">Cosmetic Industry (CBD Packaging)</h3>
  <p style="color:black;text-align:justify;">As consumers become more aware of organic and inorganic ingredients in cosmetics, packaging plays a major role. The demand for high-quality packaging has increased significantly in the cosmetics and skincare sectors.</p>

  <h3 style="font-size:18px;color:black;">Rigid Packaging & CBD Packaging</h3>
  <p style="color:black;text-align:justify;">These are commonly used for premium cosmetic products like serums. CBD and hemp packaging solutions provide security and visual appeal.</p>

  <h3 style="font-size:18px;color:black;">Perfume Business</h3>
  <p style="color:black;text-align:justify;">This luxurious industry demands protective and visually captivating packaging. <a href="{{url('perfume-boxes').'/'}}" style="color:#86C342;">  Custom rigid perfume boxes</a> with inserts ensure the perfume stays secure and enhances the unboxing experience.</p>

  <h3 style="font-size:18px;color:black;">Gift Boxes</h3>
  <p style="color:black;text-align:justify;">Gift boxes are used across various industries to offer a personalized experience to customers, adding value to the product and enhancing the gifting moment.</p>

  <h2 style="font-size:22px;color:black;">Why Choose My Box Printing for Custom Box Packaging?</h2>

  <h3 style="font-size:18px;color:black;">Customized Sizes</h3>
  <p style="color:black;text-align:justify;">We provide a wide range of box sizes tailored to your brand and product. Mockups are also available to visualize the final look before production.</p>

  <h3 style="font-size:18px;color:black;">Free Logo and Custom Box Design Support</h3>
  <p style="color:black;text-align:justify;">We offer free design and logo services. Our expert design team uses 3D tools to make your packaging stand out in the market.</p>

  <h3 style="font-size:18px;color:black;">Unbeatable Prices</h3>
  <p style="color:black;text-align:justify;">We offer premium quality at affordable prices, ensuring great value for money.</p>

  <h3 style="font-size:18px;color:black;">No MOQ</h3>
  <p style="color:black;text-align:justify;">We have a no minimum order quantity policy. Whether you need a small or large batch, we’ve got you covered—no budget worries!</p>

  <h3 style="font-size:18px;color:black;">Digital Printing</h3>
  <p style="color:black;text-align:justify;">We offer high-quality printing for logos and branding. Whether you need CMYK or retail box printing, we are your one-stop packaging solution.</p>

  <h3 style="font-size:18px;color:black;">Free Shipping Across the USA</h3>
  <p style="color:black;text-align:justify;">We provide free doorstep delivery across the United States for every completed order.</p>

  <h3 style="font-size:18px;color:black;">Customer Support</h3>
  <p style="color:black;text-align:justify;">We offer 24/7 customer service. Our team is always ready to assist you with any issues or concerns regarding your order.</p>

    
    
    
    
    
    
    
    

 
   </span>
   
    </div>
      </span>
     
     <div class="btn-container">
                            <button id="toggle1" style="color:white !important;background-color:black !important;">Read More</button>
                        </div>
   
 
</div>

            </div>
    <!-- ========================= Featured-product Area Start ========================= -->
 
 <section class="cp-services-area pb-20 p-relative z-index-1 mt--20 pt-20 hide-on-mobile ">
         
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
 
 
 <section class="cp-faq-area p-relative pt-20 pb-20 fix hide-on-mobile ">
  <div class="container">
    <div class="row">
        
   
             
                      <div class="col-md-6">
                 
                 
                         <div class="accordion-item" >
                              <h2 class="accordion-header" id="headingOne1">
                                 <button class="accordion-button" style="    background-color: #86c442;color:white;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1" style="color:white;">What does a custom box mean?</button>
                              </h2>
                              <div id="collapseOne1" class="accordion-collapse collapse show" aria-labelledby="headingOne1" data-bs-parent="#accordionExample">
                                 <div class="accordion-body">Custom box means made to order, on a specific design, or add your logo according to your brand needs.</div>
                              </div>
                           </div>
                           
                           
                            
          
</div>

  <div class="col-md-6">

 <div class="accordion-item" >
                              <h2 class="accordion-header" id="headingOne">
                                 <button class="accordion-button" style="    background-color: #86c442;color:white;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">What does custom packaging mean?</button>
                              </h2>
                              <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                 <div class="accordion-body">Custom packaging means a packaging that is made according to the size of the products and their dimensions. so that the products fit in perfectly.</div>
                              </div>
                           </div>
                           
                           
                           
 


</div>


  <div class="col-md-6">


 <div class="accordion-item "  style="visibility: visible; animation-delay: 0.4s;">
  <h2 class="accordion-header" id="headingTwo111">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo111" aria-expanded="false" aria-controls="collapseTwo111">What is an RSC Box?
 </button>
  </h2>
  <div id="collapseTwo111" class="accordion-collapse collapse" aria-labelledby="headingTwo111" data-bs-parent="#accordionExample1">
    <div class="accordion-body">
      <p style="text-algin:justify;">These are the most common types of boxes. RSC means regular slotted container.
</p>
    </div>
  </div>
</div>
</div>

  <div class="col-md-6">
      
 <div class="accordion-item "  style="visibility: visible; animation-delay: 0.4s;">
  <h2 class="accordion-header" id="headingTwo1111">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo1111" aria-expanded="false" aria-controls="collapseTwo1111">Are shipping boxes reusable?
 </button>
  </h2>
  <div id="collapseTwo1111" class="accordion-collapse collapse" aria-labelledby="headingTwo1111" data-bs-parent="#accordionExample11">
    <div class="accordion-body">
      <p style="text-algin:justify;">Yes, shipping boxes are reusable as they are durable and also recyclable.
</p>
    </div>
  </div>
</div>
</div>

  <div class="col-md-6">

 <div class="accordion-item "  style="visibility: visible; animation-delay: 0.4s;">
  <h2 class="accordion-header" id="headingTwo1111w">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo1111w" aria-expanded="false" aria-controls="collapseTwo1111w">How long will it take for my boxes to arrive?

 </button>
  </h2>
  <div id="collapseTwo1111w" class="accordion-collapse collapse" aria-labelledby="headingTwo1111w" data-bs-parent="#accordionExample11w">
    <div class="accordion-body">
      <p style="text-algin:justify;">It may take 5 to 10 business days to receive your order.
</p>
    </div>
  </div>
</div>
</div>

  
  
  <div class="col-md-6">

 <div class="accordion-item "  style="visibility: visible; animation-delay: 0.4s;">
  <h2 class="accordion-header" id="headingTwo1111w1">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo1111w1" aria-expanded="false" aria-controls="collapseTwo1111w1">How do I know if my art is printable on the custom boxes?

 </button>
  </h2>
  <div id="collapseTwo1111w1" class="accordion-collapse collapse" aria-labelledby="headingTwo1111w1" data-bs-parent="#accordionExample11w">
    <div class="accordion-body">
      <p style="text-algin:justify;">You can send us your artwork, and our team will check all the details and send you a mockup of your packaging.
</p>
    </div>
  </div>
</div>
</div>


         
         
           
               
               
            </div>
         </div>
      </section>
</main>
<style type="text/css">
#text{
display:none;
}
#text1{
display:none;
}
button{
  user-select:none;
  -webkit-user-select:none;
  -moz-user-select:none;
  -ms-user-select:none;
  cursor:pointer;
  border:none;
  box-sizing:border-box;
  padding: 12px 15px 12px 15px !important;
    background-color: #f9dbd3;
    border-radius: 5px;
    font-size: 1em;
    color: #2e9fa5;
}
.button1{
  user-select:none;
  -webkit-user-select:none;
  -moz-user-select:none;
  -ms-user-select:none;
  cursor:pointer;
  border:none;
  box-sizing:border-box;
  padding: 12px 15px 12px 15px !important;
    background-color: #c4a283;
    border-radius: 5px;
    font-size: 1em;
    color: #fff;
}

</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
  $("#toggle11").click(function() {
    var elem = $("#toggle11").text();
    if (elem == "Read More") {
      //Stuff to do when btn is in the read more state
      $("#toggle11").text("Read Less");
      $("#text11").slideDown();
    } else {
      //Stuff to do when btn is in the read less state
      $("#toggle11").text("Read More");
      $("#text11").slideUp();
    }
  });
});
</script>

<script>
$(document).ready(function() {
  $("#toggle").click(function() {
    var elem = $("#toggle").text();
    if (elem == "Read More") {
      //Stuff to do when btn is in the read more state
      $("#toggle").text("Read Less");
      $("#text").slideDown();
    } else {
      //Stuff to do when btn is in the read less state
      $("#toggle").text("Read More");
      $("#text").slideUp();
    }
  });
});
</script>


<script>
$(document).ready(function() {
  $("#toggle1").click(function() {
    var elem = $("#toggle1").text();
    if (elem == "Read More") {
      //Stuff to do when btn is in the read more state
      $("#toggle1").text("Read Less");
      $("#text1").slideDown();
    } else {
      //Stuff to do when btn is in the read less state
      $("#toggle1").text("Read More");
      $("#text1").slideUp();
    }
  });
});
</script>
@include('frontend/footer')
<script>
  function scrollSlider(direction) {
    const slider = document.getElementById('productSlider');
    const scrollAmount = 250; // Adjust based on box width + margin
    slider.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
  }
</script>
