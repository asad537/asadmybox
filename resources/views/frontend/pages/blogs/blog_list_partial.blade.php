@if(count($blogs) > 0)
    <div class="row">
        @foreach($blogs as $blogs_itemss)
            <div class="col-md-6">
                <?php 
                $img_name = $blogs_itemss->t_featured_image;
                $img_name_w_o_dot = str_replace('.', '', $img_name);
                $img_name_w_o_webp = str_replace('webp', '', $img_name_w_o_dot);
                ?>
                <article>
                    <div class="cp-news-item mb-40">
                        <div class="cp-news-img fix p-relative w-img">
                            <div class="cp-img-overlay "></div>
                            <a href="{{ url('blog/'.str_replace(' ', '-', strtolower($blogs_itemss->t_slug) )).'/'}}">
                                <img src="{{ asset('images/blog/'.$blogs_itemss->t_featured_image )}}" alt="{{$img_name_w_o_webp}}" width="630" height="315" loading="lazy" decoding="async">
                            </a>
                        </div>
                        <div class="cp-news-content">
                            <div class="cp-news1-meta mb-25">
                                <span><?php 
                                $date = $blogs_itemss->time; 
                                $formattedDate = date("F d, Y", strtotime($date));
                                echo $formattedDate;  
                                ?></span>
                            </div>
                            <h3 class="cp-news2-title mb-2" style="font-size:20px;">
                                <a href="{{ url('blog/'.str_replace(' ', '-', strtolower($blogs_itemss->t_slug) )).'/'}}"> {{ $blogs_itemss->t_title }}</a>
                            </h3>
                            <div class="cp-news-btn-share d-flex align-items-center justify-content-between">
                                <div class="cp-news-btn line-height1">
                                    <a href="{{ url('blog/'.str_replace(' ', '-', strtolower($blogs_itemss->t_slug) )).'/'}}" class="cp-border-btn">
                                        Continue Reading
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-5">
        <h3 class="text-muted">No blogs found matching your search.</h3>
    </div>
@endif
