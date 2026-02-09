 

@include('frontend/header')
 
<main>
        <!-- page title area start  -->
        <section class="page-title-area breadcrumb-spacing cp-bg-14">
       
         
        </section>
        <!-- page title area end  -->

        <!-- product area start  -->
        <div class="product-area pt-50 pb-50">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 col-lg-8 order-lg-2">
                        <div class="cp-product-right mb-80 wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".3s" style="visibility: visible; animation-duration: 1.5s; animation-delay: 0.3s; animation-name: fadeInUp;">
                            <div class="row align-items-center mb-40">
                                
                                <div class="col-lg-8 col-md-6">
                                      <div class="page-title-wrapper t-center">
                            
                       
                            <div class="breadcrumb-menu ">
                                <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                                    
                                    <ul class="trail-items">
                                               <i class="far fa-home" style="    padding: 5px;
    color: #ff3738;"></i>
                                        <li class="trail-item trail-begin"><a href="{{url('/')}}"><span>Home</span></a>
                                        </li>
                                          
                                        <li class="trail-item trail-end"><span><?php echo $searchLinks ; ?></span></li>
                                    </ul>
                                </nav>
                            </div>
                          
                                
                        </div>
                                </div>
                           
                            </div>
                            
                            
                            
                               
                
                
                
                         <div class="row mb-20">
    @if (!empty($search_prods) && $search_prods->count() > 0)
        @foreach ($search_prods as $searchProd)
            <div class="col-xl-4 col-sm-6">
                <div class="product-single">
                    <div class="product-thumb">
                        <a href="{{ url(str_replace(' ','-',strtolower($searchProd->prod_url))).'/' }}" class="image">
                            <?php $images = (array)json_decode($searchProd->prod_gallery); ?>
                            @if(!empty($images[1]))
                                <img style="width:100%;" class="prod-items-pic img-fluid" src="{{ url('images'.'/'.$searchProd->prod_image) }}" alt="{{ $images[1] }}" />
                            @endif
                        </a>
                        <ul class="product-links">
                            <li><a href="{{ url(str_replace(' ','-',strtolower($searchProd->prod_url))).'/' }}"><i class="fal fa-eye"></i></a></li>
                        </ul>
                    </div>
                    <div class="product-description">
                        <h4 class="product-name">
                            <a href="{{ url(str_replace(' ','-',strtolower($searchProd->prod_url))).'/' }}">{{ $searchProd->prod_name }}</a>
                        </h4>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-12">
            <p class="text-center" style="font-size: 18px; color: #555; margin-top: 20px; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;">
                No data found.
            </p>
        </div>
    @endif
</div>

                          
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 order-lg-1">
                        <div class="product-left-wrapper mb-80 wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".3s" style="visibility: visible; animation-duration: 1.5s; animation-delay: 0.3s; animation-name: fadeInUp;">
                            <div class="product-left-item mb-50">
                                <h6 class="product-widget-title">Category</h6>
                                <ul class="product-categories">
                                    <?php $categories=DB::table('categories')->where('parent_cate','!=','0')->orderby('id','desc')->get();?>
                                    @foreach ($categories as $main_cate)
                                    <li><a href="{{  url(str_replace( ' ','-',strtolower($main_cate->cate_url))).'/'}}">{{$main_cate->cate_name}}</a></li>
                                    
                                     @endforeach
                                </ul>
                            </div>
                         
                            <div class="product-left-item mb-50">
                                <h6 class="product-widget-title">Top Products</h6>
                                <ul class="product_list_widget">
                                 <?php $pp = DB::table('products')->inRandomOrder()->limit(5)->get(); ?>

                                     
                                     
                                     @foreach($pp as $pp)
                                    <li class="d-flex">
                                        <div class="product-widget-thumb">
                                            <div class="product-widget-thumb-inner">
                                                <a href="{{ url(str_replace(' ', '-', strtolower($pp->prod_url))).'/'}}">
                                                    <img src="{{url('images').'/'.$pp->prod_image}}" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="product" loading="lazy"> </a>
                                            </div>
                                        </div>
                                        <div class="product-widget-info">
                                            <h4 class="product-widget-title">
                                                <a href="{{ url(str_replace(' ', '-', strtolower($pp->prod_url))).'/'}}">{{$pp->prod_name}}</a>
                                            </h4>
                                            
                                        </div>
                                    </li>
                                    @endforeach
                                
                                </ul>
                            </div>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
    
 
    </main>


@include('frontend/footer')