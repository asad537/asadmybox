
    
@extends('layouts.frontend')
    


    @section('content')
 


<main class="main">
      @if (Session::has('message'))
        <div class="alert alert-success session-destroy my-sm-0 py-sm-3 text-center">
                <?php echo Session::get('message'); ?>
        </div>
    @endif
    
    
    
    
    <div style="background-color: rgb(231, 231, 231);">
        <div class="container">
            <div class="row">
                <div class="col-md-6" style="">
                    <div class="mt-5 mb-5" >
                        <div class="mt-2 test page-short">
                    <h1 class="h1 mb-4" style="color: rgb(0,0,0);">{{$get_product_data[0]->prod_name}}</h1> 
                            <div class="color-descrip" style="" class="mb-3">
                              <?php echo $get_product_data[0]->prod_short_desc;?>
                            </div>
                            <a href="{{url('get-quote/').'/'}}">
                                <button class="btn custom-btn custom-btn-2" style="color: #fff;border-radius: 99px;font-size: 1.2em;">Get A Quote</button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mt-5 mb-5">
                        <img alt="product" src="{{url('images').'/'.$get_product_data[0]->prod_image}}" style="width: 100%;" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pt-2 pb-2" style="background: #f4f4f4 !important;border-top: 1px solid #e7e7e7;">
        <div class="container">
            <div class="row" style="align-items:center;">
                <div class="col-md-7">
                    <div class="">
                        <p class="mb-0 para-star">All brands big and small love us
                            <span class="five stars ml-3" title="five stars">&#9733;</span>
                            <span class="five stars" title="five stars">&#9733;</span>
                            <span class="five stars" title="five stars">&#9733;</span>
                            <span class="five stars" title="five stars">&#9733;</span>
                            <span class="five stars" title="five stars">&#9733;</span>
                            read all reviews
                        </p>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="d-inline-flex">
                        <div class="pt-2 pb-2 pl-3 pr-3">
                           <a href="https://bit.ly/3JwAwWN" target="_blank">

                                  
										<img alt="google review" src="{{url('web/front/google-review.png')}}" style="width:100%;">
										</a>
                        </div>
                        <div class="pt-2 pb-2 pl-3 pr-3">
                          <a href="https://www.trustpilot.com/review/thelegacyprinting.com" target="_blank">
                            
										<img alt="trust pilot" src="{{url('web/front/Trust-pilot_1.png')}}" style="width:100%;">
										</a>
                        </div>
                        <div class="pt-2 pb-2 pl-3 pr-3">
                           <a href="https://www.bbb.org/us/ca/anaheim/profile/imprinting/the-legacy-printing-1126-1000061478" target="_blank">
                                  
										<img alt="Barked" src="{{url('web/front/BBB.png')}}" style="width:100%;">

										</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="feature-boxes-container mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="feature-box mx-md-3 feature-box-simple text-center">
                        <i class=""><img alt="icon3" src="{{url('web/front/icon3.png')}}" width="150" /></i>

                        <div class="feature-box-content mt-3">
                            <h3 style="font-weight: 500;font-size: 18px;">Customized Size</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-box mx-md-3 feature-box-simple text-center">
                        <i class=""><img alt="icon1" src="{{url('web/front/icon1.png')}}" width="150" /></i>

                        <div class="feature-box-content mt-3">
                            <h3 style="font-weight: 500;font-size: 18px;">Easy-To-Use Design Tool</h3>
                        </div>
                        
                    </div>
                    
                </div>
                <div class="col-md-3">
                    <div class="feature-box mx-md-3 feature-box-simple text-center">
                        <i class=""><img alt="icon2" src="{{url('web/front/icon2.png')}}" width="150" /></i>

                        <div class="feature-box-content mt-3">
                            <h3 style="font-weight: 500;font-size: 18px;">Recyclable Material</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-box mx-md-3 feature-box-simple text-center">
                        <i class=""><img alt="icon-04" src="{{url('web/front/icon-04.png')}}" width="150"/></i>

                        <div class="feature-box-content mt-3">
                            <h3 style="font-weight: 500;font-size: 18px;">Full Color Printing Inside & Out</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-area">
        <div class="container">
            <div class="row">
                <div class="col-md-6 second-description">
                    <div class="color-descrip">
                               <?php $xx =substr($get_product_data[0]->content_1,0,570); echo $xx; ?>
                    </div>
                    <div class="comment more">
                        <span class="read-more-show custom-btn mb-3" style="color:#fff !important; background-color: #00979F;border-radius: 99px;font-size: 1.2em;">
                            Read More
                            <i class="fa fa-angle-down"></i>
                        </span>
                       
                        <span class="read-more-content hide_content">
                            <?php $yy =substr($get_product_data[0]->content_1,570,200000) ?>
                            <?php echo $yy; ?>
                            <span class="read-more-hide hide_content custom-btn" style="color:#fff !important; background-color: #00979F;border-radius: 99px;font-size: 1.2em;">
                                Read Less 
                                <i class="fa fa-angle-up"></i>
                            </span>
                        </span>
                    </div>
                </div>

                <div class="col-md-6 justify-content-center">
                    <div class="">
                    <img alt="image legacy" src="{{url('images').'/'.$get_product_data[0]->content_image_1}}" style="width: 100%;" />
                    </div>
                </div>
            </div>
            <div class="row mt-4">

                <div class="col-md-6  justify-content-center">
                    <div class="">
                    <img alt="legacy image-2" src="{{url('images').'/'.$get_product_data[0]->content_image_2}}" style="width: 100%;" />
                    </div>
                </div>


                <div class="col-md-6 second-description">
                    <div class="">
                        <p class="description">
                            <?php $xx =substr($get_product_data[0]->content_2,0,700); echo $xx; ?>
                        </p>                    
                    </div>
                    <div class="comment more">
                        <span class="read-more-show hide_content custom-btn mb-3" style="color:#fff !important; background-color: #00979F;border-radius: 99px;font-size: 1.2em;">
                            Read More
                            <i class="fa fa-angle-down"></i>
                        </span>
                       
                        <span class="read-more-content">
                            <?php $yy =substr($get_product_data[0]->content_2,700,200000) ?>
                            <?php echo $yy; ?>
                            <span class="read-more-hide hide_content custom-btn" style="color:#fff !important; background-color: #00979F;border-radius: 99px;font-size: 1.2em;">
                                Read Less 
                                <i class="fa fa-angle-up"></i>
                            </span>
                        </span>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
    <div class="mt-5" style="background-color: #2c9fa4;">
        <div class="container">
            <div class="row">
                <div class="col-md-7" style="align-items: center; display: flex;">
                    <div class="mt-5 mb-5">
                        <div class="mt-2">
                            <p style="color: #fff; font-size: 30px;font-weight: 600;" class="">
                               Need to talk with packaging consultant call us now +44 (800) 0584211
                            </p>
                            <p style="color: #fff; font-size: 22px;">
                                You can also fill the attached form and one of our packaging consultant will call you shortly.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="mt-5 mb-5">
                        <form method="POST" onsubmit="return submitUserForm2();" action="{{url('ppc-form').'/'}}" class="form-border" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" name="name" placeholder="Name" />
                                </div>
                                <div class="form-group col-md-12">
                                    <input type="email" class="form-control" id="search_input" name="email" placeholder="Email" required />
                                </div>
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" name="phone" placeholder="Phone" />
                                </div>
                               
                                <div class="form-group col-md-12">
                                    <textarea class="form-control" placeholder="Message" id="exampleFormControlTextarea1" name="message" rows="3" cols="5"></textarea>
                                </div>

                                <div class="form-group col-md-12">
                                    <input type="file" class="form-control" name="image" placeholder="File" style="background: transparent; border: none; color: #fff;" />
                                </div>
                                <!-- Recaptcha start -->
                                <div class="form-group">
                                    <div class="g-recaptcha" data-sitekey="6LcvadQmAAAAALRmKpgtWzQTvmoeNz1y4EoP0-oo" data-callback="verifyCaptcha2" required=""></div>
                                    <div id="g-recaptcha-error2"></div>
                                </div>
                                <!-- Recaptcha start -->
                            </div>
                            <button class="btn btn-success custom-btn" type="submit" style="background:#fff !important;color: #29727A;">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="feature-boxes-container">
        <div class="container">
            <h3 class="text-center mb-5">1,000,000+ business professionals trust us with their printing</h3>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-box mx-md-3 feature-box-simple text-center">
                        <img class="mb-3 mt-1" alt="tfb7" src="{{url('web/front/tfb7.png')}}" style="width:120px;display: inline-flex;"/>
                        <div class="feature-box-content">
                            <h3 class="mb-2" style="font-size: 20px;font-weight: 600;">24/7 Customer service</h3>
                            <p style="font-size: 16px; color: #000000;">Excellent customer service anytime you need it.</p>
                        </div>
                        
                    </div>
                    
                </div>
                <div class="col-md-4">
                    <div class="feature-box mx-md-3 feature-box-simple text-center">
                        <img class="mb-3 mt-1" alt="relaible" src="{{url('web/front/relaible.png')}}" style="width:120px;display: inline-flex;"/>
                        <div class="feature-box-content">
                            <h3 class="mb-2" style="font-size: 20px;font-weight: 600;">Always Reliable</h3>
                            <p style="font-size: 16px; color: #000000;">The box you want. The way you want. Professional result guaranteed.</p>
                        </div>
                        
                    </div>
                   
                </div>
                <div class="col-md-4">
                    <div class="feature-box mx-md-3 feature-box-simple text-center">
                        <img class="mb-3 mt-1" alt="free-artwork" src="{{url('web/front/free-artwork.png')}}" style="width:120px;display: inline-flex;" />
                        <div class="feature-box-content">
                            <h3 class="mb-2" style="font-size: 20px;font-weight: 600;">Free Artwork Check</h3>

                            <p style="font-size: 16px; color: #000000;">A box specialist will give your artwork a hand-on review.</p>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
          
        </div>
       
    </div>


    
    <div class="pt-5 pb-5" style="background:rgb(231, 231, 231);">
        <div class="container">
            <div class="products-section pt-0 mb-4 text-center">
                <h2 class="section-title" style="font-size: 23px;">Related Products</h2>

                <div class="prod-sm-items owl-carousel owl-loaded owl-drag">
                <?php
                    foreach ($get_product_data as $i){?>
                       <?php  $temp = json_decode($i->related_prod);?>
                       <?php if(!empty($all_products)){ foreach ($all_products as $index){?>

                       <?php if(!empty($temp)){foreach ($temp as $key =>
                       $keyvalue) { if($keyvalue==$index->id){?>
                    <div class="product-default">
                        <figure>
                            <a href="{{ url(str_replace(' ','-', strtolower($index->prod_url))).'/'}}">
                                <img src="{{url('images/'.$index->prod_image)}}" width="280" height="280" alt="{{$index->prod_name}}" />
                            </a>
                        </figure>
                        <div class="">
                            <h3 class="product-title">
                                <a style="font-size: 20px;color: #00979f;text-decoration: none;" href="{{ url(str_replace(' ','-', strtolower($index->prod_url))).'/'}}"> {{$index->prod_name}} </a>
                            </h3>
                            <div class="ratings-container"></div>
                        </div>
                    </div>
                     
                                             
                <?php } } } } } } ?>

                </div>
                
            </div>
           
        </div>
    </div>
</main>
<style>
    .form-border input {border-radius:5px;}
    .form-border textarea {border-radius:5px;}
    @media (min-width: 992px)
    {   
        .feature-boxes-container .container {
    margin-top: 5rem;
    margin-bottom: 3rem;
}
        .h1 {font-size: 4rem;}    
    }
  
   .custom-btn-2{
    background: #2d9fa4 !important;
   }
   .test p{

color:rgb(0,0,0) !important;

   }
   .page-short h1{color:#00979F !important;font-size: 2.7em;font-weight: 600;line-height: 1.3;}
   .page-short p {font-size: 2rem;line-height: 1.6;}

   .feature-boxes-container i {
    width: 150px;
    height: 150px;
   }
input {font-size: 16px !important;}
textarea {font-size: 16px !important;}
.color-descrip p{color:#000;font-size:18px;}
.color-descrip span{font-size:18px;}
</style>
<style type="text/css">
    .read-more-show{
      cursor:pointer;
      color: #ed8323;
    }
    .read-more-hide{
      cursor:pointer;
      color: #ed8323;
    }

    .hide_content{
      display: none;
    }
</style>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
            $('.read-more-content').addClass('hide_content')
            $('.read-more-show, .read-more-hide').removeClass('hide_content')


            $('.read-more-show').on('click', function(e) {
              $(this).next('.read-more-content').removeClass('hide_content');
              $(this).addClass('hide_content');
              e.preventDefault();
            });


            $('.read-more-hide').on('click', function(e) {
              var p = $(this).parent('.read-more-content');
              p.addClass('hide_content');
              p.prev('.read-more-show').removeClass('hide_content');
              e.preventDefault();
            });
</script>
@endsection

