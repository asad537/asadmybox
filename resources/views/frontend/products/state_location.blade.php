

@extends('layouts.frontend')
    


@section('content')

<style>


    .post_category_widget .cat-list li a, .post_category_widget .cat-list li a > p{
        font-size: 16px !important;
    line-height: 2 !important;
    color: #202020 !important;
    font-weight: 400 !important;
    }
    .cmb-formProd_style .form-group .form-control {
           font-weight: 400 !important;
    }
    
    .card-view .card-title{
           font-weight: 400 !important;
    }
    input.block-level-btn, a.block-level-btn
   {
           font-weight: 400 !important;
    }
    
  .cmb_cate_inners {
       position: -webkit-sticky;
    position: sticky;
    top: 150px;
    z-index: 1000;
    background-color: #f1f1f1;
    padding: 20px;
    margin-bottom: 30px;
    border: 1px solid #dddddd;
    position: sticky !important;
    top: 100px;
  }
  
  .leftsidebar_title {
    color: #ffffff;
    font-size: 18px;
    font-weight: 600;
    position: relative;
    letter-spacing: 1px;
    margin-top: 10px;
    margin-bottom: 10px;
    padding-top: 12px;
    padding-bottom: 12px;
    text-transform: capitalize;
    background: #2d9fa4;
    text-align: center;
  }
  
  @media (max-width: 578px) {
    .leftsidebar_title {
      color: #ffffff;
      font-size: 16px;
      padding-top: 8px;
      padding-bottom: 8px;
    }
  }
  
  .single_sidebar_widget {
    background: #f1f1f1;
  }
  
  .post_category_widget .cat-list li {
    border-bottom: 1px solid #2d9fa4;
    transition: all 0.3s ease 0s;
  }
  .post_category_widget .cat-list li a ,  .post_category_widget .cat-list li a > p {
    font-size: 15px !important;
    line-height: 2;
    color: #202020;
    font-weight: 500;
  }
  
  .card-view {
    text-align: center;
    border-radius: 0;
  }
  .card-view .card-title {
    color: #2d9fa4;
    font-weight: 700;
  }
  .card-view .card-body {
    background-color: transparent;
    border: 0px;
  }
  
  .card-view img {
    /*height: 200px;*/
    /*width: 100%;*/
    object-fit: fill;
  }
  /*============================== 
  Category page CSS End
  ===============================*/
  
  @media (max-width: 578px) {
    .card-view .card-title {
      color: #2d9fa4;
      font-weight: 700;
      font-size: 14px;
    }
    .get-quote-title-2 {
      font-size: 18px;
    }
  
    input.block-level-btn,
    a.block-level-btn {
      margin-bottom: 10px;
      height: 35px;
      border-radius: 0px;
      padding: 2px 0px;
      width: 120px;
      font-weight: 600;
      font-size: 14px;
    }
  }
   /* ========================= User Dashboard ========================= */
 @media screen and (min-width:768px){

}

 @media screen and (max-width:768px){
       .tab button {
   padding: 10px 0px !important;
   font-size:12px !important;
}
}
 
 
 
 
 
 .login-user {
     display: inline-flex;
     /*padding: 10px 35px 10px 38px;*/
 }
 .dashboard-pad {
    background-color: #fff;
    border: 1px solid #e6e6e6;
    padding: 20px 0px 30px 40px;
 }
 .dashboard-section {
    background-color: #f2f3f3;
    padding: 50px 0px 50px 0px;
 }
 .login-user .dashboard-img {
    border-radius: 50%;
    display: inline-block;
    width: 100px !important;
    height: 100px;
    object-fit: fill;
 }
 .login-user .dashboard-img {
     max-width: 100px !important;
 }
 .mar-bot-p {
     margin-bottom:7px;
 }
 .button-pad {
    padding: 7px 55.8px 7px 55.8px;
    margin-right: -4px !important;
    border-radius: 0px;
    color: #464e60;
 }
 .button-pad:hover {
     border-bottom: 1px solid blue;
     border-right: 1px solid blue;
     border-left: 1px solid blue;
 }
 .button-pad:target{
    background-color: #f7f8fa;
 }
 
/* Style the tab */
.tab {
overflow: visible;
border: 1px solid #ccc;
background-color: #f1f1f1;
background-color: #ffff;
border: 1px solid #EAEDEF;
display: flex;
justify-content: space-around;
}

/* Style the buttons inside the tab */
.tab button {
background-color: inherit;
float: left;
border: none;
outline: none;
cursor: pointer;
padding: 14px 16px;
transition: 0.3s;
font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
background-color: #ccc;
}

/* Style the tab content */

.tab button {
padding: 8px 16px;
border-bottom: 1px solid #EAEDEF;
border-right: 1px solid #EAEDEF;
border-left: 1px solid #EAEDEF;
flex-grow: 1;
color: #292b2c;
}

.tab button.active{
background-color: #f7f8fa;
border-bottom: 2px solid #2d9fa4;
position: relative;
color: #2d9fa4;
}
.tab button.active::before{
content: ' ';
position: absolute;
display: block;
left: 50%;
bottom: -12px;
border: 5px solid #2d9fa4;
border-color: #2d9fa4 transparent transparent;
margin-left: -5px;
}
.tabcontent {
margin-top: 50px;
display: none;
padding: 6px 12px;
border: 1px solid #EAEDEF;
background: white;
}
.txt-cen-padd {
text-align: center;
padding: 20px 0px 10px 0px;
background-color: #ffffff;
}
.img-upd-btn {
padding: 20px 0px 20px 10px;
}
.dashboard-btn {
    background: #bf0a30;
    color: #ffffff;
    border-radius: 0px;
}
  
  .card-view {
    text-align: center;
    border-radius: 0;
  }
  .card-view .card-title {
    color: #2d9fa4;
    font-weight: 700;
  }
  .card-view .card-body {
    background-color: transparent;
    border: 0px;
  }
  
  .card-view img {
    /*height: 200px;*/
    /*width: 100%;*/
    object-fit: fill;
  }
  /*============================== 
  Category page CSS End
  ===============================*/
  
  @media (max-width: 578px) {
    .card-view .card-title {
      color: #2d9fa4;
      font-weight: 700;
      font-size: 14px;
    }
    .get-quote-title-2 {
      font-size: 18px;
    }
  
    input.block-level-btn,
    a.block-level-btn {
      margin-bottom: 10px;
      height: 35px;
      border-radius: 0px;
      padding: 2px 0px;
      width: 120px;
      font-weight: 600;
      font-size: 14px;
    }
  }
   /* ========================= User Dashboard ========================= */
 @media screen and (min-width:768px){

}

 @media screen and (max-width:768px){
       .tab button {
   padding: 10px 0px !important;
   font-size:12px !important;
}
}
 
 
 
  .cmb-formProd_style {
    border: 2px solid #f2f1f1;
    /* border-top: 5px solid #2d9fa4; */
    background-color: #f1f1f1;
    padding-top: 10px;
  }
  
  .cmb-formProd_style .form-group .form-control {
    height: 35px;
    line-height: 23px;
    padding: 5px 10px;
    font-size: 10px;
    border-color: #d8d3d0;
    border-radius: 0px;
    box-shadow: none;
    color: #000000;
    text-transform: none;
    font-weight: 600;
    background: transparent;
    transition: background-color 200ms linear;
    border: 1px solid #2d9fa4;
    letter-spacing: 5;
    
  }
  .cmb-formProd_style .product-form-inputs::placeholder{
    color: #000000;
  }
  .cmb-formProd_style .form-group {
    font-size: 12px;
    text-transform: none;
    color: #323232;
    font-weight: 700;
  }
  
  .cmb-formProd_style .product-form-inputs {
    height: 35px;
    line-height: 23px;
    box-shadow: none;
    background: transparent;
    transition: background-color 200ms linear;
    border: 2px solid #d8d3d0;
    padding: 5px 10px;
    font-size: 12px;
    border-color: #e7ebf1;
    border-radius: 0px;
  }
  .product-form-inputs.h-auto {
    height: auto;
    text-align: left;
    padding-left: 20px;
  }
  
  input.block-level-btn,
  a.block-level-btn {
    margin-bottom: 5px;
    height: 35px;
    padding: 2px 15px;
    width: 130px;
    font-weight: 600;
    display: inline-block;
    font-size: 15px;
    color: #2d9fa4;
    border: 1px solid rgb(225, 225, 227);
    background-color: rgb(225, 225, 227);
    border-radius: 30px;
    box-shadow: rgb(183 197 205) -4px 5px 5px;
  }

.white-btn.block-level-btn
{
  background-color: transparent;
  color: #ffffff;
  border: 1px solid #ffffff;
  box-shadow: none;
}
  a.block-level-btn {
    line-height: 2;
  }
  
  .explaination-boxes {
    font-family: Arial, Verdana;
    font-size: 10pt;
    font-style: normal;
    font-variant-ligatures: normal;
    font-variant-caps: normal;
    font-weight: normal;
    text-align: justify;
  }
  
  .get-quote-title-2 {
    background-color: #2d9fa4;
    padding: 12px 0;
    color: #ffffff;
    font-size: 28px;
  }
  
  .qoute-innner {
    border-top: 4px solid #2d9fa4;
    text-align: left;
  }
  .qoute-innner h2 {
    font-weight: 600;
    padding-top: 10px;
  }
  
  @media (max-width: 578px) {
    .qoute-innner h2 {
      font-size: 20px;
    }
  }
  
  .get-quote-title {
    background-color: #f1f1f1;
    color: #2d9fa4;
    font-size: 18px;
    font-weight: 600;
    padding: 16px 0;
    margin-top: 0px;
    text-align: center;
    margin-bottom: 10px;
    border: 2px solid #2d9fa4;
  }
  @media (max-width: 578px) {
    .get-quote-title {
      font-size: 18px;
      padding: 10px 0;
    }
  }
  
  .get-quote-title-2 {
    background-color: #2d9fa4;
    padding: 12px 0;
    color: #ffffff;
    font-size: 28px;
  }
  
  .qoute-innner {
    border-top: 4px solid #2d9fa4;
    text-align: left;
  }
  .qoute-innner h2 {
    font-weight: 600;
    padding-top: 10px;
  }
  
  @media (max-width: 578px) {
    .qoute-innner h2 {
      font-size: 20px;
    }
  
      
      
  }
.list li{
    padding: 0px 0 0px 0px !important;
}
.list li:before{
    display:none !important;
}

 


 /* ========================= User Dashboard ========================= */
</style>
<!--================main wrapper =================-->
    <main id="cmb_wrapper overflow-x-hidden">
              @if (Session::has('message'))
        <div class="alert alert-success session-destroy my-sm-0 py-sm-3 text-center">
                <?php echo Session::get('message'); ?>
        </div>
    @endif

<ol class="breadcrumb" vocab="" typeof="BreadcrumbList">
	<li property="itemListElement" typeof="ListItem">
		<a property="item" typeof="WebPage" href="https://www.thelegacyprinting.com.au">  <i style="color: #00979f;" class="fa fa-home" aria-hidden="true"></i> </a>
		<meta property="position" content="1"> </li>
	<li property="itemListElement" typeof="ListItem">
		<a property="item" typeof="WebPage" href="{{url('our-location').'/'}}"> 
		<span property="name" style="color: #00979f;">Our Location</span> </a>
		<meta content="2" property="position">
	</li>
	<li property="itemListElement" typeof="ListItem">
	 
		<span property="name" style="color: #00979f;">     {{$get_state[0]->states}}</span> 
		<meta content="3" property="position">
	</li>

</ol>
        <section class="category-segment" style="margin-bottom:100px;">
            <div class="container-fluid" style="">
               
                <div class="row">
                <div class="col-xl-9    pr-xl-2 pr-md-3">
                    
                    <div class="row m-0">
                    <div class="col-md-3 pl-xl-0 pl-md-1 pr-xl-3 pr-md-0 col-md-3 pl-xl-0 pl-md-1 pr-xl-3 pr-md-0 d-none d-lg-block">
                        <div class="cmb_cate_inners">
                            
                            
                        <aside class="single_sidebar_widget post_category_widget">
                            
                            
                            <h4 class="widget_title leftsidebar_title">Useful Links</h4>
                           
                            <ul class="list cat-list">
                               
                                 
                                 <li>
                                    <a href="{{url('our-location').'/'}}" class="d-flex">
                                    <p class="my-sm-2 my-2">Locations</p>
                                    </a>
                                </li>
                                
                                
                                
                                
                                <?php   $states_cat = DB::table('statescategories')->orderBy('id','desc')->limit(15)->get();  ?>
                                
                                
                                    @foreach($states_cat as $link1)
                                <li>
                                    <a href="{{url($link1->cate_url).'/'}}" class="d-flex">
                                    <p class="my-sm-2 my-2" style=" text-transform: capitalize;">{{$link1->cate_name}}</p>
                                    </a>
                                </li>
                                @endforeach
                                
                          
                                 
                                   
                                
                                
                                
                            
                            </ul>
                        </aside>
                        </div>
                    </div>
                    <div class="col-md-9 pl-md-2  pr-xl-0 pr-md-2 ">
                        <h1 style="text-align:center;text-transform: capitalize;">
                            {{$get_state[0]->states}}
                            
                        </h1>
                        <div class="mb-4">
                              <img src="{{url('images/'.$get_state[0]->image)}}" alt="cosmetic-boxes-2" class="img-fluid w-100" />
              
                        </div>
                        <div class="row">
                            
                         
                               
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mb-md-3 mb-3     pr-xl-2 ">
                                
                                
                                        
                               
                                
                            
                        
                            </div>
                             
                        </div>
                        
                                
                                
                        <div class="row">
                            
                         
                               
                   
                                
                                
                                        
                             
                            
                        
                        
                        <?php  
                        $id = strval($get_state[0]->id);
 
$output = [$id];
$json_output = json_encode($output);

 

                        
                      $data1111= DB::table('statescategories')->where('state',$json_output)->get();
                        
                        
               
?>
 
 
    <?php foreach ($data1111 as $cc) : ?>
        <div class="col-md-6">
            <p><a style="color:black;" href="<?= url($cc->cate_url); ?>"><?= $cc->cate_name; ?></a></p>
        </div>
    <?php endforeach; ?>
 
                        
                        
     
              
              
            
                             
                        </div>
                        
                        <h2 style="color:#2D9FA4">Packaging Services in   {{$get_state[0]->states}} </h2>
                          <p><?php echo $get_state[0]->longdescription?></p>
                    </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="text-left " style="position: sticky;top: 120px;">
                    <h5 class="get-quote-title mb-sm-4">GET CUSTOM QUOTE</h5>
                <form id="contactForm" onsubmit="return submitUserForm2();" action="{{ url('email_requote_form').'/' }}" method="post" class="cmb-formProd_style">
                        
                         @csrf
                         
                         
                        @csrf
                        <div class="container-fluid">
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                            <label for="">Name <span class="required">*</span>
                            </label>
                            <input type="text" name="name" value="" placeholder="Your Name *" required="" class="form-control product-form-inputs" />
                            </div>
                            <div class="form-group col-md-6 col-12">
                            <label for="">Email <span class="required">*</span>
                            </label>
                            <input id="search_input" type="email" name="email" value="" placeholder="Your Email *" required="" style="" class="form-control product-form-inputs" />
                            </div>
                            
                            <div class="form-group col-md-12 col-12">
                            <label for="">Stock <span class="required">*</span>
                            </label>
                            <select name="stock" class="form-control product-form-inputs" required="" style="">
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
                            <label for="">Contact no <span class="required">*</span>
                            </label>
                            <input type="text" name="phone" value="" placeholder="Contact no *" required="" style=" color: #000;" class="form-control product-form-inputs" />
                            </div>
                            <div class="form-group col-md-6 col-12">
                            <label for="">Box style <span class="required">*</span>
                            </label>
                              <select name="box_style" class="form-control" required="">
                                        <option value="">Select Product</option>
                                        @foreach ($all_products as $item)
                                              <option value="{{ $item->id }}"> {{ $item->prod_name }} </option>
                                         @endforeach
                                    </select>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-md-6 col-12">
                            <label for="">color <span class="required">*</span>
                            </label>
                            <select name="color" required="" class="form-control product-form-inputs">
                                <option value="1 Color">1 Color</option>
                                <option value="2 Color">2 Color</option>
                                <option value="3 Color">3 Color</option>
                                <option value="4 Color">4 Color</option>
                                <option value="4/1 Color">4/1 Color</option>
                                <option value="4/2 Color">4/2 Color</option>
                                <option value="4/3 Color">4/3 Color</option>
                                <option value="4/4 Color">4/4 Color</option>
                                <option value="4 Color+PMS">4 Color+PMS</option>
                            </select>
                            </div>
                            <div class="form-group col-md-6 col-12">
                            <label for="">type <span class="required">*</span>
                            </label>
                            <select name="type" required="" class="form-control product-form-inputs">
                                <option value="Get Quote">Get Quote</option>
                                <option value="Get Template">Get Template</option>
                            </select>
                            </div>
                            <div class="form-group col-md-3 pr-xl-2 col-12">
                            <label for="">Length <span class="required">*</span>
                            </label>
                            <input type="text" name="length" value="" placeholder="length *" required="" class="form-control product-form-inputs" />
                            </div>
                            <div class="form-group col-md-3 pr-xl-2 pl-xl-2 col-12">
                            <label for="">width <span class="required">*</span>
                            </label>
                            <input type="text" name="width" value="" placeholder="width *" required="" class="form-control product-form-inputs" />
                            </div>
                            <div class="form-group col-md-3 pr-xl-2 pl-xl-2 col-12">
                            <label for="">height <span class="required">*</span>
                            </label>
                            <input type="text" name="height" value="" placeholder="height *" required="" class="form-control product-form-inputs" />
                            </div>
                            <div class="form-group col-md-3 pl-xl-2 col-12">
                            <label for="">Unit <span class="required">*</span>
                            </label>
                            <select name="inches" class="form-control product-form-inputs">
                                <option value="Inch">inch</option>
                                <option value="cm">cm</option>
                                <option value="mm">mm</option>
                            </select>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-4 col-sm-4 col-12 form-group">
                            <label for="">Quantity <span class="required">*</span>
                            </label>
                            <input type="text" name="qt1" id="qty" value="" placeholder="QTY1 Required" required="" class="form-control product-form-inputs" />
                            </div>
                            <div class="col-md-4 col-sm-4 col-12 form-group">
                            <label for="">Quantity1</label>
                            <input type="text" name="qt2" id="qty" value="" placeholder="QTY2" class="form-control product-form-inputs" />
                            </div>
                            <div class="col-md-4 col-sm-4 col-12 form-group">
                            <label for="">Quantity2</label>
                            <input type="text" name="qty3" id="qty" value="" placeholder="QTY3" class="form-control product-form-inputs" />
                            </div>
                            <div class="col-md-12 col-sm-4  form-group col-12">
                            <label for="">Recaptcha</label>
                                    <div class="form-group">
                                        <div class="g-recaptcha" data-sitekey="6LcvadQmAAAAALRmKpgtWzQTvmoeNz1y4EoP0-oo" data-callback="verifyCaptcha2" required></div>
                                        <div id="g-recaptcha-error2"></div>
                                    </div>
                            </div>
                            <div class="col-md-12 text-center ">
                            <input type="submit" name="btnSubmit" value="SUBMIT" class="d-block mx-auto block-level-btn" />
                            </div>
                        </div>
                        </div>
                    </form>
                    </div>
                </div>
                </div>
            </div>
        </section>
      
        

    </main>
 @endsection

 @section('scripts')

 @endsection





    

