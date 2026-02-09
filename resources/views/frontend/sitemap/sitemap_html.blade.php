@include('frontend/header')
        <!-- page title area start  -->
        <section class="page-title-area breadcrumb-spacing cp-bg-14" style="background-color: var(--clr-bg-14);">
       
         
        </section>

<section class="about-page about-page-segment py-sm-5 pb-4 mt-sm-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                
                <div class="text-center pb_heading head-3 pb-sm-2 pb-3">
                   
                    <div class="text-center pb_heading head-3 pb-sm-2 pb-3">
                        <p class="text-center short_title"></p><h1 style="font-weight: 900;
    font-size: 30px;
    letter-spacing: 1px;
    color: rgb(0, 0, 0);
    position: relative;
    text-transform: uppercase;
    font-family: Raleway, sans-serif;">Our Category</h1><p></p>
                    </div>
         
                </div>
             
                
<div class="row">
    
    @foreach($all_subcategory as $pp)
<div class="col-md-3">
  <a href="{{ url(str_replace( ' ','-',strtolower($pp->cate_url))).'/'}}">
      
 <p>{{$pp->cate_name}}</p>
 
   </a> 
</div>
    @endforeach
</div>

                
                
                
      </div>
    </div>
</section>






<section class="about-page about-page-segment py-sm-5 pb-4 mt-sm-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                
                <div class="text-center pb_heading head-3 pb-sm-2 pb-3">
                   
                    <div class="text-center pb_heading head-3 pb-sm-2 pb-3">
                        <p class="text-center short_title"></p><h1 style="font-weight: 900;
    font-size: 30px;
    letter-spacing: 1px;
    color: rgb(0, 0, 0);
    position: relative;
    text-transform: uppercase;
    font-family: Raleway, sans-serif;">Our Products</h1><p></p>
                    </div>
         
                </div>
             
                
<div class="row">
    
    @foreach($all_pro as $p1)
<div class="col-md-3 ">
  <a href="{{ url(str_replace( ' ','-',strtolower($p1->prod_url)))}}">
      
 <p>{{$p1->prod_name}}</p>
 
   </a> 
</div>
    @endforeach
</div>
                
                
                
      </div>
    </div>
</section>



@include('frontend/footer')