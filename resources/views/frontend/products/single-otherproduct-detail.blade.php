@extends('layouts/frontend')
<style>
.qoute-innner h1.prd_name{
	background: white !important;
 
}
 
.qoute-innner {
    text-align: left;
    border: none !important;
     padding: 0px;
}
.owl-dots{
	display:none !important
}
</style>
  

@section('content')

        @if (Session::has('message'))
            <div class="alert alert-success session-destroy my-sm-0 py-sm-3 text-center">
                    <?php echo Session::get('message'); ?>
            </div>
        @endif
 <!-- ========================= bbreadcrumb-view Area Start ========================= -->
 
 

<div class="col-xs-12 col-sm-4 col-md-6 breadcrumb_div">
 <ol class="breadcrumb" vocab="" typeof="BreadcrumbList">
	<li property="itemListElement" typeof="ListItem">
		<a property="item" typeof="WebPage" href="{{url('/')}}">  <i  style="color: #09878c;" class="fa fa-home"></i> </a>
		<meta property="position" content="1"> </li>
    <li property="itemListElement" typeof="ListItem">
        <a property="item" typeof="WebPage" href="{{$breadcrum_url}}"> 
        <span property="name" style="color: #09878c;">{{$breadcrum_title}}</span></a>
        <meta content="3" property="position">
    </li>
	<li property="itemListElement" typeof="ListItem">
		<a property="item" typeof="WebPage" href="{{ url(str_replace(' ', '-', strtolower($url_links[0]->prod_name))).'/'}}"> 
		<span property="name" style="color: #09878c;">  {{  $url_links[0]->prod_name }}</span></a>
		<meta content="3" property="position">
	</li>
	
 

</ol>
</div>



   <div class="clearfix"></div>
 
    <!-- ========================= breadcrumb-view Area End ========================= -->


    
     <!--================main wrapper =================-->

     <main id="pb-wrapper overflow-x-hidden">

    <!-- ========================= Product-info-features Area Start ========================= -->

        <section id="Product-info-features" class=" text-center  mt-sm-4">
             <div class="container">
                 <div class="row">

                    <div class="col-lg-6  text-center">
                       
                 
                            <div class="cbb-product-detail">
                                <div class="prod-items">
        
         

                                @if (!empty($url_links))
                                     @foreach ($url_links as $main_image)
                                           <?php $image = json_decode($main_image->prod_gallery); ?>     
   
                                            
                                            <?php $img_name = $image[0] ;  ?>  
                                                
                                                     <?php $img_name_w_o_dot = str_replace('.', '', $img_name); ?>  
                                                    <?php $img_name_w_o_webp = str_replace('webp', '', $img_name_w_o_dot); ?>  
                                               <img class="prod-items-pic img-fluid" src="{{ asset('images/'.$img_name) }}" alt="{{$img_name_w_o_webp}}"/>
                                            

                                     @endforeach
                                @endif
        
                                </div>
                                <div class="prod-sm-items owl-carousel product_gallery_mar">
        
                                         @if(!empty($url_links))
                                                @foreach ($url_links as $item)
                                                    <?php  $images = json_decode($item->prod_gallery);?>
                                                  @if(!empty($images))
                                                            @foreach ($images as $image)
                                                                <img class="img-fluid" data-imgbigurl="{{url('images/'.$image)}}"  src="{{url('images/'.$image)}}" alt="{{$img_name_w_o_webp}}" class="" />
                                                            @endforeach
                                                     @endif
                                                @endforeach
                                        @endif
        
                                </div>
                            
                        </div>
                       

                        
                        
                    </div>
                    
                    <div class="col-lg-6 pb-prod-detail">
                        <!-- <h1 class="get-quote-title-2 text-left px-3">COSMETIC PACKAGING</h1> -->

             
                        <div class="qoute-innner">
                          <h1 class="prd_name" style="color:black;">{{$url_links[0]->prod_name}}</h1>
                    
                                 
                                      <p class="addReadMore showlesscontent text-justify" style="color:#000000">
                                        <?php echo $url_links[0]->prod_short_desc?>
                                     </p> 
                               
                        </div>

                        

						<div class="row on_set_img" style="background:rgb(236, 236, 236);align-items:center;margin: 0px 20px 0px 20px;text-align: center;">
							<div class="col-md-6">
								<div class="info-boxes-slider py-3">
									<p style="line-height: 2.2;margin-bottom: 0px;color: #30459e;font-size: 15px;font-weight: 600;">(4.8 Google Reviews)</p>
								</div>
							</div>
							<div class="col-md-6">
								<div class="info-boxes-slider d-flex">
									<div class="" style="padding:0px 10px;">
									<a href="https://bit.ly/3JwAwWN" target="_blank">

                                  
										<img alt="google review" src="{{url('front/google-review.png')}}" style="width:40px; height:17px;">
										</a>
									</div>
									<!--<div class="" style="padding:0px 10px;">-->

									<!--<a href="https://www.trustpilot.com/review/thelegacyprinting.com" target="_blank">-->
                            
									<!--	<img alt="trust pilot" src="{{url('front/Trust-pilot_1.png')}}" style="width:40px; height:17px;">-->
									<!--	</a>-->
									<!--</div>-->
									<div class="" style="padding:0px 10px;">

									<a href="https://www.bbb.org/us/ca/anaheim/profile/imprinting/the-legacy-printing-1126-1000061478" target="_blank">
                                  
										<img alt="Barked" src="{{url('front/BBB.png')}}" style="width:40px; height:17px;">

										</a>
									</div>
									</div>
								</div>
						    </div>
                        <div class="text-left">
                        

                            <form class="product__form" action="{{url('product_form_submit').'/'}}" method="post" onsubmit="return submitUserForm2();">
                                      <input  type="hidden"   value="{{ $url_links[0]->prod_url }}" name="prodname1" />
                                         @csrf
                                <div class="container-fluid" style="padding: 20px;">
                                    <div class="row">
                                        <div class="form-group col-md-4 col-12">
                                            <input type="text" name="name" value="" placeholder="Name *" required="" class="form-control product-form-inputs" />
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                      
                                            <input type="email" name="email" id="search_input" value="" placeholder="Email *" required="" style=""  class="form-control product-form-inputs" />
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                         
                                            <select name="stock" class="form-control product-form-inputs" required="" style="" >
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
                                        <div class="form-group col-md-6 col-12">
                                         
                                            <input type="text" name="phone" value="" placeholder="Contact no *" required="" style=" color: #000;"  class="form-control product-form-inputs" />
                                        </div>
                                        <div class="form-group col-md-6 col-12">
                                       
                                            <input type="text" name="product_name" value="{{$url_links[0]->prod_name}}" placeholder="Box Style" required="" class="form-control product-form-inputs" readonly="" />
                                        </div>
                                    
                                        <div class="clearfix"></div>
                                        <div class="form-group col-md-6 col-12"> 
											<select id="inputState" class="form-control product-form-inputs" name="printing"> 
                                                <option value="Printing Option">Printing Option</option>
                                                <option value="1/0 CMYK">1/0 CMYK</option>
                                                <option value="2/0 CMYK">2/0 CMYK</option>
                                                <option value="3/0 CMYK">3/0 CMYK</option>
                                                <option value="4/0 CMYK">4/0 CMYK</option>
                                                <option value="4/1 CMYK">4/1 CMYK</option>
                                                <option value="4/2 CMYK">4/2 CMYK</option>
                                                <option value="4/3 CMYK">4/3 CMYK</option>
                                                <option value="4/4 CMYK">4/4 CMYK</option>
                                            </select>
                                        </div>
										<div class="col-md-6 col-sm-6 col-12 form-group">
                                        
										<input type="text" name="qty" id="qty" value="" placeholder="Quantity (Min 100) *" required="" class="form-control product-form-inputs" />
									</div>
                                        <div class="form-group col-md-3 pr-lg-2 col-12">
                                            <input type="text" name="length" value="" placeholder="length *" required="" class="form-control product-form-inputs" />
                                        </div>
                                        <div class="form-group col-md-3 pr-lg-2 pl-lg-2 col-12">
                                           <input type="text" name="width" value="" placeholder="width *" required="" class="form-control product-form-inputs" />
                                        </div>
                                        <div class="form-group col-md-3  pr-lg-2 pl-lg-2 col-12">
                                            <input type="text" name="height" value="" placeholder="height *" required="" class="form-control product-form-inputs" />
                                        </div>
                                        <div class="form-group col-md-3 pl-lg-2 col-12">
                                           
                                            <select name="unit" class="form-control product-form-inputs">
                                                <option value="Inch">inch</option>
                                                <option value="cm">cm</option>
                                                <option value="mm">mm</option>
                                            </select>
                                        </div>
                                        <div class="clearfix"></div>
                                        <input type="hidden" name="pid" value="13" />
                                        
                                        <div class="col-md-12 col-sm-12 col-12 " >
											
                                            <textarea name="message" aria-label="message" rows="4" cols="" class="h-auto form-control product-form-inputs ">Message</textarea>
                                            
                                        </div>
                                        
                                         
										<div class="form-group p-3">
											<div class="g-recaptcha" data-sitekey="6LcvadQmAAAAALRmKpgtWzQTvmoeNz1y4EoP0-oo" data-callback="verifyCaptcha2" required=""></div>
											<div id="g-recaptcha-error2"></div>
										</div>
                                        
                                       
                                        
                                 
                                         <div class="col-md-12 text-center  mb-4 btn_product__1">
                                             <div class="text-center mt-sm-4 mt-3 mb-sm-0 mb-3 btn_product__2">
                                                 <button   type="submit"  class="btn-View-All px-sm-5 btn_product__3"  >Get Quote</button>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                          </div>
                    </div>
                    

                 </div>
             </div>
         </section>

         <div class="d-flex"  style="background-color: #00979f;padding: 15px 0px;justify-content:center;">
			<div class="text-center d-flex" style="align-items:center;">
				<img alt="Sales person legacy" src="{{url('web/front/slaes-person-image.png')}}" style="margin: 0px 15px;">
				<span style="color: rgb(255,255,255);font-size: 18px;font-weight: 600;">Our expert team is on hand to help you unlock branded packaging. <a style="color: rgb(255,255,255);font-size: 18px;font-weight: 600;" href="https://www.thelegacyprinting.co.uk/contact-us">Say Hello </a></span>
				<img alt="1f44b" src="{{url('web/front/1f44b.svg')}}" width="20" style="margin: 0px 10px;">
			</div>
	</div>

<!-- Tabs-section Start -->
<div id="tabs">
    <div class="container px-sm-4" >
        <div class="row">
            <div class="col-12 text-center">
                <nav>
                    <div class="nav nav-tabs nav-fill mb-sm-4" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-profile-tab" data-toggle="tab" href="#premier--profile" role="tab" aria-controls="premier--profile" aria-selected="true"> Specifications</a>
                     
                    <a class="nav-item nav-link" id="nav-desc-tab" data-toggle="tab" href="#premier--desc" role="tab" aria-controls="premier--desc" aria-selected="false" >Description</a>
                    <a class="nav-item nav-link " id="nav-desc-tab1" data-toggle="tab" href="#premier--desc1" role="tab" aria-controls="premier--desc1" aria-selected="false">
                    Material</a>
					  <a class="nav-item nav-link " id="nav-desc-tabx" data-toggle="tab" href="#premier--descx" role="tab" aria-controls="premier--descx" aria-selected="false">
                   Order Process</a>
                      

                      
                    </div>
                </nav>
                <div class="tab-content py-sm-4 px-0 px-sm-4 px-3" id="nav-tabContent"  style="">
				<div class="tab-pane " id="premier--descx" role="tabpanel" aria-labelledby="nav-desc-tabx">
                 
                            <div class="product-size-content">
								<div class="row">
									<div class="col-md-12">
										<div class="text-center">
											<h2 class="">3 Step Order Processing</h2>
											<p>Looking for custom packaging? Make it a breeze by following our four easy steps - soon you’ll be on your way to meeting all your packaging needs!</p>
										</div>
										<div class="feature-boxes-container">
											<div class="container">
												<div class="row">
													<div class="col-md-4">
														<div class="feature-box mx-md-3 feature-box-simple text-center">
															<i class=""><img src="{{url('front/click-1.png')}}" alt="Send Quote Request"></i>

															<div class="feature-box-content">
																<h3 style="    padding: 20px;font-size: 20px;">Send Quote Request</h3>

																<p>Just fill up the quote form and submit it for evaluation by one of our packaging experts.</p>
															</div>
															<!-- End .feature-box-content -->
														</div>
														<!-- End .feature-box -->
													</div>
													<!-- End .col-md-4 -->

													<div class="col-md-4">
														<div class="feature-box mx-md-3 feature-box-simple text-center">
															<i class="">
                                                            <img src="{{url('front/customer-service.png')}}" alt="Consult with our expert"></i>

															<div class="feature-box-content">
																<h3  style="    padding: 20px;font-size: 20px;">Consult with our expert</h3>

																<p>Get professional advice on your quote to cut costs &amp; improve efficiency.</p>
															</div>
															<!-- End .feature-box-content -->
														</div>
														<!-- End .feature-box -->
													</div>
													<!-- End .col-md-4 -->

													<div class="col-md-4">
														<div class="feature-box mx-md-3 feature-box-simple text-center">
															<i class=""><img src="{{url('front/van-car.png')}}" alt="Production &amp; shipping"></i>

															<div class="feature-box-content">
																<h3  style=" font-size: 20px;">Production &amp; shipping</h3>

																<p>Allow us to handle the full manufacturing and shipment once everything is prepared for production!</p>
															</div>
															<!-- End .feature-box-content -->
														</div>
														<!-- End .feature-box -->
													</div>
													<!-- End .col-md-4 -->
												</div>
												<!-- End .row -->
											</div>
											<!-- End .container -->
										</div>
									</div>
									<!-- End .col-md-4 -->
								</div>
								<!-- End .row -->
							</div>
                            
                            </div>

                    <div class="tab-pane " id="premier--desc" role="tabpanel" aria-labelledby="nav-desc-tab"><?php echo $url_links[0]->prod_long_desc ; ?></div>
                    <div class="tab-pane " id="premier--desc1" role="tabpanel" aria-labelledby="nav-desc-tab1">
                        
                
                
                    <div class="product-ons-content mb-5">
								<h2 class="section-title mb-5" style="font-size: 25px;">Box Features</h2>
								<div class="prod-sm-itemss owl-carousel owl-loaded owl-drag ">
			                         <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
                                <div class="owl-stage-outer"><div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1720px;"><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                            
			                                    <img src="{{url('front/3-Flaps-Tuck-Top-Lid.webp')}}" width="200" height="200" alt="3-Flaps-Tuck-Top-Lid">
			                                
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">3 Flaps Tuck Top Lid</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                             
			                                    <img src="{{url('front/Cherry locks.webp')}}" width="200" height="200" alt="Cherry locks">
			                             
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Cherry locks</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                              
			                                    <img src="{{url('front/Roll End Tray.webp')}}" width="200" height="200" alt="Roll End Tra">
			                             
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Roll End Tray</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                               
			                                    <img src="{{url('front/Tear Strip.webp')}}" width="200" height="200" alt="Tear Strip">
			                            
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Tear Strip</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                             
			                                    <img src="{{url('front/Tuck Top Lid.webp')}}" width="200" height="200" alt="Tuck Top Lid">
			                          
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                   <p style="font-size: 16px;font-weight: 600;">Tuck Top Lid</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                             
			                                    <img src="{{url('front/Perforation.webp')}}" width="200" height="200" alt="Perforation">
			                            
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Perforation</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div></div></div><div class="owl-nav disabled"><button type="button" title="nav" role="presentation" class="owl-prev"><i class="icon-angle-left"></i></button><button type="button" title="nav" role="presentation" class="owl-next"><i class="icon-angle-right"></i></button></div><div class="owl-dots"><button role="button" title="dot" class="owl-dot active"><span></span></button><button role="button" title="dot" class="owl-dot"><span></span></button></div></div>
								<!-- End .row -->
								<h2 class="section-title mt-5 mb-5" style="font-size: 25px;">Materials</h2>
                                <div class="prod-sm-itemss owl-carousel owl-loaded owl-drag">
			                         <!-- product 2 -->
			                        
			                         <!-- product 3 -->
			                        
			                         <!-- product 4 -->
			                        
			                         <!-- product 5 -->
			                        
			                         <!-- product 6 -->
			                        
			                         <!-- product 7 -->
			                        
			                         <!-- product 7 -->
			                        
			                         <!-- product 8 -->
			                        
			                         <!-- product 9 -->
			                        
			                         <!-- product 10 -->
			                        
			                         <!-- product 11 -->
			                        
			                         <!-- product 12 -->
			                        
			                         <!-- product 13 -->
			                        
                                <div class="owl-stage-outer"><div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 3726px;"><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                               
			                                    <img src="{{url('front/SBS C1S.webp')}}" width="200" height="200" alt="SBS C1S">
			                              
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">SBS C1S</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                                
			                                    <img src="{{url('front/SBS C2S.webp')}}" width="200" height="200" alt="SBS C2S">
			                              
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">SBS C2S</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                            
			                                    <img src="{{url('front/CCNB.webp')}}" width="200" height="200" alt="CCNB">
			                             
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">CCNB</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                                
			                                    <img src="{{url('front/Fully Recycled CCNB.webp')}}" width="200" height="200" alt="Fully Recycled CCNB">
			                           
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Fully Recycled CCNB</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                              
			                                    <img src="{{url('front/Natural Brown Kraft.webp')}}" width="200" height="200" alt="Natural Brown Kraft">
			                           
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Natural Brown Kraft</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                            
			                                    <img src="{{url('front/White Kraft.webp')}}" width="200" height="200" alt="White Kraft">
			                          
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                  <p style="font-size: 16px;font-weight: 600;">White Kraft</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                               
			                                    <img src="{{url('front/Black Kraft.webp')}}" width="200" height="200" alt="Black Kraft">
			                           
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                   <p style="font-size: 16px;font-weight: 600;">Black Kraft</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                          
			                                    <img src="{{url('front/Uncoated Unbleached Kraft (UUK).webp')}}" width="200" height="200" alt="Uncoated Unbleached Kraft (UUK)">
			                       
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Uncoated Unbleached Kraft (UUK)</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                            
			                                    <img src="{{url('front/Clay Coated Kraft Back (CCK).webp')}}" width="200" height="200" alt="Clay Coated Kraft Back (CCK)">
			                         
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Clay Coated Kraft Back (CCK)</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                              
			                                    <img src="{{url('front/Clay Natural Kraft (CNK).webp')}}" width="200" height="200" alt="Clay Natural Kraft (CNK)">
			                          
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Clay Natural Kraft (CNK)</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                               
			                                    <img src="{{url('front/Metallic Paper.webp')}}" width="200" height="200" alt="Metallic Paper">
			                          
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Metallic Paper</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                               
			                                    <img src="{{url('front/Holographic.webp')}}" width="200" height="200" alt="Holographic">
			                            
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Holographic</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                              
			                                    <img src="{{url('front/Textured.webp')}}" width="200" height="200" alt="Textured">
			                             
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Textured</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div></div></div><div class="owl-nav disabled"><button type="button" title="nav" role="presentation" class="owl-prev"><i class="icon-angle-left"></i></button><button type="button" title="nav" role="presentation" class="owl-next"><i class="icon-angle-right"></i></button></div><div class="owl-dots"><button role="button" title="dot" class="owl-dot active"><span></span></button><button role="button" title="dot" class="owl-dot"><span></span></button><button role="button" title="dot" class="owl-dot"><span></span></button><button role="button" title="dot" class="owl-dot"><span></span></button></div></div>
								<!-- End .row -->
								<h2 class="section-title mt-5 mb-5" style="font-size: 25px;">Printing Methods</h2>
                                <div class="prod-sm-itemss owl-carousel owl-loaded owl-drag">
			                        <!-- product 1 -->
			                        
			                         <!-- product 1 -->
			                        
			                         <!-- product 1 -->
			                        
			                         <!-- product 1 -->
			                        
                                <div class="owl-stage-outer"><div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1147px;"><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                             
			                                    <img src="{{url('front/Offset Print.webp')}}" width="200" height="200" alt="Offset Print">
			                         
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Offset Print</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                        
			                                    <img src="{{url('front/Digital Print.webp')}}" width="200" height="200" alt="Digital Print">
			                        
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Digital Print</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                           
			                                    <img src="{{url('front/UV Print.webp')}}" width="200" height="200" alt="UV Print">
			                           
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">UV Print</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                                
			                                    <img src="{{url('front/Scodix Digital Enhancement.webp')}}" width="200" height="200" alt="Scodix Digital Enhancement">
			                               
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Scodix Digital Enhancement</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div></div></div><div class="owl-nav disabled"><button type="button" title="nav" role="presentation" class="owl-prev"><i class="icon-angle-left"></i></button><button type="button" title="nav" role="presentation" class="owl-next"><i class="icon-angle-right"></i></button></div><div class="owl-dots disabled"><button role="button" title="dot" class="owl-dot active"><span></span></button></div></div>
								<!-- End .row -->
								<h2 class="section-title mt-5 mb-5" style="font-size: 25px;">Inks</h2>
                                <div class="prod-sm-itemss owl-carousel owl-loaded owl-drag">
			                         <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
                                <div class="owl-stage-outer"><div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1720px;"><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                               
			                                    <img src="{{url('front/Water-based Inks.webp')}}" width="200" height="200" alt="Water-based Inks">
			                        
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Water-based Inks</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                             
			                                    <img src="{{url('front/Soy Vegetable Based Inks.webp')}}" width="200" height="200" alt="Soy/Vegetable Based Inks">
			                           
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Soy/Vegetable Based Inks</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                               
			                                    <img src="{{url('front/Fluorescent Color Inks.webp')}}" width="200" height="200" alt="Fluorescent Color Inks">
			                          
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Fluorescent Color Inks</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                             
			                                    <img src="{{url('front/Oil Based Inks.webp')}}" width="200" height="200" alt="Oil Based Inks">
			                            
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Oil Based Inks</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                             
			                                    <img src="{{url('front/Pantone.webp')}}" width="200" height="200" alt="Pantone">
			                            
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Pantone</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                              
			                                    <img src="{{url('front/Pantone Metallic.webp')}}" width="200" height="200" alt="Pantone Metallic">
			                           
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Pantone Metallic</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div></div></div><div class="owl-nav disabled"><button type="button" title="nav" role="presentation" class="owl-prev"><i class="icon-angle-left"></i></button><button type="button" title="nav" role="presentation" class="owl-next"><i class="icon-angle-right"></i></button></div><div class="owl-dots"><button role="button" title="dot" class="owl-dot active"><span></span></button><button role="button" title="dot" class="owl-dot"><span></span></button></div></div>
								<!-- End .row -->
								<h2 class="section-title mt-5 mb-5" style="font-size: 25px;">Finishing</h2>
                                <div class="prod-sm-itemss owl-carousel owl-loaded owl-drag">
			                         <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
                                <div class="owl-stage-outer"><div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 2293px;"><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                            
			                                    <img src="{{url('front/Aqueous Coating.webp')}}" width="200" height="200" alt="Aqueous Coating">
			                            
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Aqueous Coating</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                            
			                                    <img src="{{url('front/UV Coating.webp')}}" width="200" height="200" alt="UV Coating">
			                           
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">UV Coating</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                                
			                                    <img src="{{url('front/Spot Gloss UV.webp')}}" width="200" height="200" alt="Spot Gloss UV">
			                              
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Spot Gloss UV</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                                
			                                    <img src="{{url('front/Soft Touch Coating.webp')}}" width="200" height="200" alt="Soft Touch Coating">
			                              
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Soft Touch Coating</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                             
			                                    <img src="{{url('front/Varnish.webp')}}" width="200" height="200" alt="Varnish">
			                           
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Varnish</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                          
			                                    <img src="{{url('front/Lamination.webp')}}" width="200" height="200" alt="Lamination">
			                        
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Lamination</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                         
			                                    <img src="{{url('front/Anti-scratch lamination.webp')}}" width="200" height="200" alt="Anti-scratch lamination">
			                           
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Anti-scratch lamination</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                                
			                                    <img src="{{url('front/Soft touchSilk Lamination.webp')}}" width="200" height="200" alt="Soft touch / Silk Lamination">
			                                
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Soft touch / Silk Lamination</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div></div></div><div class="owl-nav disabled"><button type="button" title="nav" role="presentation" class="owl-prev"><i class="icon-angle-left"></i></button><button type="button" title="nav" role="presentation" class="owl-next"><i class="icon-angle-right"></i></button></div><div class="owl-dots"><button role="button" title="dot" class="owl-dot active"><span></span></button><button role="button" title="dot" class="owl-dot"><span></span></button></div></div>
								<!-- End .row -->
								<h2 class="section-title mt-5 mb-5" style="font-size: 25px;">ADDITIONAL OPTIONS</h2>
                                <div class="prod-sm-itemss owl-carousel owl-loaded owl-drag">
			                         <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
                                <div class="owl-stage-outer"><div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 2007px;"><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                           
			                                    <img src="{{url('front/Hot Foil Stamping.webp')}}" width="200" height="200" alt="Hot Foil Stamping">
			                             
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Hot Foil Stamping</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                             
			                                    <img src="{{url('front/Cold Foil Printing.webp')}}" width="200" height="200" alt="Cold Foil Printing">
			                        
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Cold Foil Printing</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                           
			                                    <img src="{{url('front/Blind Embossing.webp')}}" width="200" height="200" alt="Blind Embossing">
			                       
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Blind Embossing</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                             
			                                    <img src="{{url('front/Blind Debossing.webp')}}" width="200" height="200" alt="Blind Debossing">
			                        
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Blind Debossing</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                              
			                                    <img src="{{url('front/Registered Embossing.webp')}}" width="200" height="200" alt="Registered Embossing">
			                           
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Registered Embossing</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                              
			                                    <img src="{{url('front/Combination Embossing.webp')}}" width="200" height="200" alt="Combination Embossing">
			                          
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Combination Embossing</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                                
			                                    <img src="{{url('front/Window Patching.webp')}}" width="200" height="200" alt="Window Patching">
			                              
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Window Patching</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div></div></div><div class="owl-nav disabled"><button type="button" title="nav" role="presentation" class="owl-prev"><i class="icon-angle-left"></i></button><button type="button" title="nav" role="presentation" class="owl-next"><i class="icon-angle-right"></i></button></div><div class="owl-dots"><button role="button" title="dot" class="owl-dot active"><span></span></button><button role="button" title="dot" class="owl-dot"><span></span></button></div></div>
								<!-- End .row -->
								<h2 class="section-title mt-5 mb-5" style="font-size: 25px;">Add ons</h2>
                                <div class="prod-sm-itemss owl-carousel owl-loaded owl-drag">    
			                         <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
			                        <!-- product 1 -->
			                        
                                <div class="owl-stage-outer"><div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 2293px;"><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                               
			                                    <img src="{{url('front/Natural Kraft Paperboard Insert.webp')}}" width="200" height="200" alt="Natural Kraft Paperboard Insert">
			                   
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Natural Kraft Paperboard Insert</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                            
			                                    <img src="{{url('front/Folding Carton Box Divider Inserts.webp')}}" width="200" height="200" alt="Folding Carton Box Divider Inserts">
			                         
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Folding Carton Box Divider Inserts</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                            
			                                    <img src="{{url('front/Natural Kraft Corrugated Insert.webp')}}" width="200" height="200" alt="Natural Kraft Corrugated Insert">
			                       
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Natural Kraft Corrugated Insert</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item active" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                            
			                                    <img src="{{url('front/Corrugated Box Divider Inserts.webp')}}" width="200" height="200" alt="Corrugated Box Divider Inserts">
			                         
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Corrugated Box Divider Inserts</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                             
			                                    <img src="{{url('front/Standard White Corrugated Insert.webp')}}" width="200" height="200" alt="Standard White Corrugated Insert">
			                       
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">Standard White Corrugated Insert</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                              
			                                    <img src="{{url('front/PETG Blister Insert.webp')}}" width="200" height="200" alt="PETG Blister Insert Embossing">
			                       
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">PETG Blister Insert Embossing</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                               
			                                    <img src="{{url('front/PVC Blister Insert.webp')}}" width="200" height="200" alt="PVC Blister Insert">
			                          
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">PVC Blister Insert</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div><div class="owl-item" style="width: 266.6px; margin-right: 20px;"><div class="product-default inner-quickview inner-icon" style="    background: #fff;border-radius: 15px;box-shadow: 3px 0px 13px 0px rgb(231, 231, 231);padding: 10px 10px 10px 10px;">
			                            <figure>
			                           
			                                    <img src="{{url('front/HIPS Blister Insert.webp')}}" width="200" height="200" alt="HIPS Blister Insert">
			                          
			                            </figure>
			                            <div class="">
			                                <h3 class="product-title">
			                                    <p style="font-size: 16px;font-weight: 600;">HIPS Blister Insert</p>
			                                </h3>
			                                <!-- End .product-container -->
			                            </div>
			                            <!-- End . -->
			                        </div></div></div></div><div class="owl-nav disabled"><button type="button" title="nav" role="presentation" class="owl-prev"><i class="icon-angle-left"></i></button><button type="button" title="nav" role="presentation" class="owl-next"><i class="icon-angle-right"></i></button></div><div class="owl-dots"><button role="button" title="dot" class="owl-dot active"><span></span></button><button role="button" title="dot" class="owl-dot"><span></span></button></div></div>
								<!-- End .row -->
							</div></div>

                    <div class="tab-pane fade active show" id="premier--profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <table class="table table-sm table-bordered table-striped">
                        <tbody class="ttttbody">
									<tr>
										<th>DIMENSIONS</th>
										<td>All Custom Sizes &amp; Shapes</td>
									</tr>
									<tr>
										<th>PRINTING</th>
										<td>CMYK, PMS, No Printing</td>
									</tr>
									<tr>
										<th>PAPER STOCK</th>
										<td>10pt to 28pt (60lb to 400lb) Eco-Friendly Kraft, E-flute Corrugated, Bux Board, Cardstock</td>
									</tr>
									<tr>
										<th>QUANTITIES</th>
										<td>100 – 500,000</td>
									</tr>
									<tr>
										<th>COATING</th>
										<td>Gloss, Matte, Spot UV</td>
									</tr>
									<tr>
										<th>DEFAULT PROCESS</th>
										<td>Die Cutting, Gluing, Scoring, Perforation</td>
									</tr>
									<tr>
										<th>OPTIONS</th>
										<td>Custom Window Cut Out, Gold/Silver Foiling, Embossing, Raised Ink, PVC Sheet.</td>
									</tr>
									<tr>
										<th>PROOF</th>
										<td>Flat View, 3D Mock-up, Free Sample Kit (On request)</td>
									</tr>
									<tr>
										<th>TURN AROUND TIME</th>
										<td>8-10 Business Days , Rush</td>
									</tr>
								</tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<?php if(count($faqtable) >0  ){?>
<div id="pb-testimonial-segment" class="pb-testimonial-segment" style="padding-bottom: 0px !important;">
	<div class="container  pb-sm-4 pb-sm-0">
		<div class=" text-center pb_heading  head-3 ">
			<p class="text-center short_title"> <span>Frequently Asked Questions</span></p>
		</div>
		<div class="row"> 


 
<div class="accordion col-md-12">


<?php $sr=0; foreach ($faqtable as $pro_faq){ $sr++; ?>



	<div class="accordion-section"> 
        <a href="#accordion-<?php echo $sr ?>" class="accordion-section-title">
 
        <?php echo $pro_faq->question; ?>    
 
        <span class="plus">+</span><span class="minus">-</span></a>



		<div id="accordion-<?php echo $sr ?>" class="accordion-section-content" style="display: none;">
			<p style="color:black;">
            
            <?php echo $pro_faq->answer; ?>
            </p>
			 
		</div>
	</div>
 	<?php } ?>
 
	 
</div>

        </div>
	</div>
</div>
<?php }else {?>
					<?php echo "";?>
				<?php }?>
	<div id="pb-testimonial-segment" class="pb-testimonial-segment" style="padding-bottom: 0px !important;">
		<div class="container  pb-sm-4 pb-sm-0" >

            <div class=" text-center pb_heading">
            <p class="text-center short_title"> <span>Related Product</span></p>
            </div>

             <div class="row">
                 
                 
                 
			 <?php
                    foreach ($url_links as $i){?>
                       <?php  $temp = json_decode($i->related_prod); ?>

                       <?php if(!empty($all_product)){ foreach ($all_product as $eachProd){?>

                       <?php if(!empty($temp)){foreach ($temp as $key =>
                       $keyvalue) { if($keyvalue==$eachProd->id){?> 
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12 mb-md-3 mb-3 pr-xl-2">
                              <div class="category-product product-default">
                                  <div class="boxes-detailed-content">
                                      
                                      <figure class="mb-0 newpic">
                                          <a class="aa-product-img" href="{{ url(str_replace(' ','-', strtolower($eachProd->prod_url))).'/'}}">
                                
                                      <?php $images = json_decode($eachProd->prod_gallery);
                                                                
                                                                $i = 1;
                                                            ?>
                                        
                                                          @if(!empty($images))  
                             
                                                                    <img class="img-fluid" src="<?php foreach($images as $key=>$value){if($i==1){echo url('images/'.$value);}$i++;} ?>" alt="{{$eachProd->prod_name}}" class="" />
                                                                
                                                           @endif
                                                               </a>
    
                                          <figcaption class="text-image">

                                              <h4 class="product-title t2">
                                                
                                              <?php if(strlen($eachProd->prod_name)> 17)
                                                                   {
                                                                       echo substr($eachProd->prod_name,0, 17).'...';
                                                                   }
                                                                   else{
                                                                      echo  $eachProd->prod_name;
                                                                   }
                                                                
                                                                 ?>
                                              </h4>
                                          </figcaption>
     
                                      </figure>
                                  </div>
                              </div>
                          </div>         
					<?php } } } } } } ?>
               

                
            </div>
		</div>
	</div>

	<section class=" ">
            <div class="container">
                <div class="text-center pb_heading head-3 mb-sm-5">
                    <p class="text-center short_title"><span>Feedback From Our Valued Customers</span></p>
                </div>
            </div>
            <div class="container">
                <div id="testimonial-slider" class="owl-carousel">
                    @foreach ($our_testimonial as $testimonial_slider)
                    <div class="item"  <?php
                    $incTestmonial = 1;
                    $incTestmonial == 1 ? 'active' : '';
                    ?>>
                        <div class="testimonail-main">
                            <div class="testimonial-inner">
                                <span class="icon icon-1  fa fa-quote-left"></span>
                                 <p class="addReadMore showlesscontent description ">
                                    {{substr($testimonial_slider->slider_description,0,strlen($testimonial_slider->slider_description))}}   
                                </p>
                                
                            </div>
                            <div class="testimonial-content d-inline-flex" style="align-items:center;">
                               
                                <div class="pic">
                                    <img  width="100px" height="100px"
                                     src="{{ asset('images/'.$testimonial_slider->slider_image) }}" alt="image" />
                                </div>
                                <h3 class="title">{{ $testimonial_slider->main_title }}</h3>
                            </div>
                            
                        </div>
                    </div>
                @endforeach
        
                 
                </div>
            </div>
        </section>




		 
    <!-- ========================= pb-testimonial-segment  Area End ========================= -->
     </main>

    <!--================== End wrapper ================== -->
@endsection

@section('scripts')

@endsection

