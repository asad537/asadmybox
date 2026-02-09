

@extends('layouts.frontend')
    


@section('content')
 
<style>
.get-quote-title-2{
    background-color:none !important;
}
    .about-page .breadcrumb {
     margin-bottom: 0rem; 
}
</style>

<section class="about-page about-page-segment">
    <div class="container">
        
        <div class="row justify-content-center">
            <div class="col-xl-12">
                
                <div class="text-center pb_heading head-3 pb-sm-2 pb-3">
                <ol class="breadcrumb" vocab="" typeof="BreadcrumbList">
	<li property="itemListElement" typeof="ListItem">
		<a property="item" typeof="WebPage" href="{{url('/')}}">  <i style="color: #c4a283;" class="fa fa-home" aria-hidden="true"></i> </a>
		<meta property="position" content="1"> </li>
 
	<li property="itemListElement" typeof="ListItem">
	 
		<span property="name" style="color: #c4a283;">Our Location</span> 
		<meta content="3" property="position">
	</li>
	 

</ol> 
                </div>
                 <h1 style="text-align:center;font-size:25px;">
                     Our Locations
                 </h1>
             <div class="row" style="padding:10px;">
                
                <?php
                    foreach ($states_cat as $i){?>
                       <?php  $temp = json_decode($i->state); ?>

                       <?php if(!empty($states_name)){ foreach ($states_name as $index){?>

                       <?php if(!empty($temp)){foreach ($temp as $key =>
                       $keyvalue) { if($keyvalue==$index->id){?>
                                  
                        <div class="col-md-3">
                      <?php  $uri_path = parse_url($i->cate_url, PHP_URL_PATH);
                      $uri_segments = explode('/', $uri_path);

                       $print_name_state = $uri_segments[1]; ?>
                        
                            <a href="{{url('our-location').'/'. str_replace(' ', '-', strtolower($index->states))}}">
                                <?php $img_name = $print_name_state;  ?>  
                                                
                                 <?php $img_name_w_o_dot = str_replace('.', '', $img_name); ?>  
                                 <?php $img_name_w_o_webp = str_replace('webp', '', $img_name_w_o_dot); ?>
                                 <?php $img_name_w_o_sub = str_replace('-', ' ', $img_name_w_o_webp); ?>
                                
                                 <?php  $words = preg_replace('/[0-9]+/', '', $img_name_w_o_sub);?>
                                 <?php $remove_png = str_replace('png', '', $words);?>
                                 <?php $remove_jpg = str_replace('jpg', '', $remove_png); ?>

                            <div class="mb-2">
                                <img src="{{url('images/'.$i->cate_image)}}"  alt="{{$remove_jpg}}" style="width:250px;"/>
                            </div>
                            <p style="text-transform: capitalize;font-size:14px;"><span style="font-weight: 600;color:#002471;">{{$index->states}}</span></p>
                            
                            
                            </a> 
                        </div>
                       
                       
                       <?php } } } } } } ?>
            </div>
<div class="row">
     

 
    </div>

                <style>
                    .page-link{
                        height:50px;
                        
                    }
                    .page-item.active .page-link{
                        font-size: 20px;
                    }
                </style>
      
            
                
      </div>
       <div class="row">
             <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                 </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-wrapper text-center mb-35">
                        <h2 class="section-title mb-5">  {{ $states_cat->links() }} </h2>
                    </div>
                </div>  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                 </div>
            </div>
    </div>
</div>
</section>

 
 @endsection

 @section('scripts')

 @endsection









