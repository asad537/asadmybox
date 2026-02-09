@extends('layouts.frontend')




@section('content')


    <!-- ========================= blog Area Start ========================= -->


     

        <!-- =========================  blog-segment Area Start ========================= -->
        <section class="blog spad py-sm-5  py-4">
            <div class="container">
                <div class="text-center pb_heading head-3 pb-sm-2 pb-3">
                  
                   <p class="text-center short_title"><span>Blog page</span></p>
                    
                </div>
           
                <div class="row">
                      <?php   if(count($search_blogs)>0){?>
                      
                  
                                @foreach($search_blogs as $singleItem)
                                      <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="blog__item">
                                                <div class="blog__item__pic">
                                                    <img src="{{ URL::asset('images'.'/'.'blog'.'/'.$singleItem->t_featured_image) }}" alt="" class="img-fluid blog-img">
                                                </div>
                                                <div class="blog__item__text">
                                                    <ul>
                                                        <li><i class="fa fa-calendar-o" aria-hidden="true"></i>{{ $singleItem->dtAdded }}</li>
                                                    </ul>
                                                    <h5>
                                                      <a href="{{ url(str_replace(' ' , '-' , 'blog'.'/'. strtolower($singleItem->t_slug))).'/'}}">{{ $singleItem->t_title }}</a>
                                                    </h5>
                                                    
                                                       <?php
                                                        $maxLen =   $singleItem->t_d_text;
                                                        echo  $limit = substr($maxLen, 0 , 70);
                        
                                                        if( strlen($maxLen) > 70 ){
                                                            echo "...";
                                                        }
                                                    ?>    
                                                    
                                                    <a href="{{ url(str_replace(' ' , '-' , 'blog'.'/'. strtolower($singleItem->t_slug))).'/'}}" class="blog__btn">READ MORE <span class="arrow_right"></span></a>
                                                </div>
                                            </div>
                                    </div>
                             @endforeach
                     
                     
                   
                 
                 
                 
                 
                  
              <?php } else {?>
              
               <div class="col-lg-4 col-md-4 px-1 pd-50">
                            			<center><h3>No Results Found!!</h3></center>
                            		</div>
              
              <?php }  ?> 
                       
                                   
                              		
                            	

                </div>
            </div>
        </section>
    
        <!-- =========================  blog-segment Area End ========================= -->

@endsection



@section('scripts')



@endsection
