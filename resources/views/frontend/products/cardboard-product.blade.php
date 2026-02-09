


 @extends('layouts/frontend')


 @section('content')

 
   <style>
    
    .breadcrumb>li+li:before {
    padding: 0 5px;
    color: #ccc;
    content: "/\00a0";
}

        .breadcrumb {
    padding: 8px 15px;
    margin-bottom: 20px;
    list-style: none;
    background-color: #f5f5f5;
    border-radius: 4px;
}
    </style>
<div class="col-xs-12 col-sm-4 col-md-6 breadcrumb_div">
<ol class="breadcrumb" vocab="" typeof="BreadcrumbList">
	<li property="itemListElement" typeof="ListItem">
		<a property="item" typeof="WebPage" href="{{url('/')}}">  <i  style="color: #C4A283;" class="fa fa-home"></i> </a>
		<meta property="position" content="1"> </li>
 
	<li property="itemListElement" typeof="ListItem">
		<a property="item" typeof="WebPage" href="{{url('corrugation-display-boxes').'/'}}"> 
		<span property="name" style="color: #C4A283;">Corrugation Display Boxes</span></a>
		<meta content="3" property="position">
	</li>
	
 

</ol>
</div>


      <!-- =========================  Category-segment Area Start ========================= -->

 <div class="clearfix"></div>
    	<h1 property="name" style="color: black;text-align:center;">Corrugation Display Boxes</h1>
     

    <div class="clearfix"></div>
      <section class="category-segment pb-sm-5 py-4 mt-sm-4">
        <div class="container" style="">
            <div class="row">
                @foreach ($all_cardboardprods as $otherProd)
                   
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-md-3 mb-3 ">
                        <div class="category-product">
                            <div class="boxes-detailed-content">
                                <figure class="mb-0 newpic">
                                    <a class="aa-product-img" href="#">
                                        <img src="{{asset('images/'.$otherProd->prod_image)}}" width="100%" alt="{{$otherProd->prod_name}}" class="featured-image img-fluid" />
                                    </a>
                                    <figcaption class="text-image">
                                       
                                        <p class="product-title mt-2">{{$otherProd->prod_name}}</p>
                                    </figcaption>
                                    <div class="overlay">
                                        <div class="text">
                                            <div class="lightBlur-line"></div>
                                           <a href="{{url(str_replace(' ', '-', strtolower($otherProd->prod_url))).'/'}}">
                                                <p class="mx-5 info-2">
                                                    <?php 
                                                       echo $otherProd->prod_name ;
                                                    ?>
                                                </p>
                                             </a>
                                            <!--<a  style="pointer-events: none;" href="{{str_replace(' ', '-', strtolower($otherProd->prod_url))}}" class="btn hover-btn service-btn Portfolio-btn portfolio-border-hover">Shop Now <i class="fas fa-angle-right"></i> </a>-->
                                        </div>
                                    </div>
                                </figure>
                            </div>
                        </div>              
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    

  <!-- =========================  Category-segment Area End ========================= --> 



 @endsection

 @section('scripts')

 @endsection
