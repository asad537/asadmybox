 

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
                                          
                                        <li class="trail-item trail-end"><span>Printing Products</span></li>
                                    </ul>
                                </nav>
                            </div>
                          
                                
                        </div>
                                </div>
                           
                            </div>
                            
                            
                            
                               
                
                <h1 style="font-size:20px;">
                    Printing Products
                </h1>
                
                            <div class="row mb-20">
                                    @foreach ($all_otherprods as $promItem)  
                                    
                                <div class="col-xl-4 col-sm-6">
                                    <div class="product-single">
                                        <div class="product-thumb">
                                            <a href="{{  url(str_replace(' ','-',strtolower($promItem->prod_url))).'/'}}" class="image">
                                         @php
                                    $imgName = $promItem->prod_image;
                                    $imgNameReadable = preg_replace('/\d+/', '', str_replace(['.webp', '.png', '.jpg', '-', '.'], [' ', '', '', ' ', ''], $imgName));
                                    $prodGallery = is_array($promItem->prod_gallery) ? $promItem->prod_gallery : json_decode($promItem->prod_gallery, true);
                                    $firstGalleryImage = !empty($prodGallery) ? $prodGallery[1] : null;
                                @endphp
                                <img class="pic-1" src="{{ url('images/' . $promItem->prod_image) }}" alt="{{ trim($imgNameReadable) }}">
                                @if ($firstGalleryImage)
                                    <img class="pic-2" src="{{ url('images/' . $firstGalleryImage) }}" alt="{{ trim($imgNameReadable) }}">
                                @endif
                                               
                                            </a>
                                            <ul class="product-links">
                                               
                                                <li><a href="{{  url(str_replace(' ','-',strtolower($promItem->prod_url))).'/'}}"  ><i class="fal fa-eye"></i></a></li>
                                             
                                            </ul>
                                        </div>
                                        <div class="product-description">
                                            <h4 class="product-name">
                                                <a href="{{  url(str_replace(' ','-',strtolower($promItem->prod_url))).'/'}}">{{$promItem->prod_name}}</a>
                                            </h4>
                                             
                                        </div>
                                    </div>
                                </div>
                        
                        
                           @endforeach
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