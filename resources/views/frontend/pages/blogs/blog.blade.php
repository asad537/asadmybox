@include('frontend/header')
 
<style>
    .pt-20{
        padding-top: 40px !important;
    }
    .pb-20{
        padding-bottom: 30px !important;
    }
    
    .cp-news-widget-title {
        position: relative;
    }
    
    .cp-news-widget-title::after {
        content: "";
        position: absolute;
        width: 90px;
        height: 2px;
        top: 30%;
        transform: translateY(-50%);
        left: 100%;
        background: linear-gradient(90deg, rgb(134, 194, 66) 0%, rgba(237, 76, 92, 0) 100%);
        border-radius: 30px;
    }
    
    /* Blog Pagination Styling - Simple Style */
    .cp-pagination {
        margin-top: 0;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .cp-pagination nav {
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .cp-pagination .pagination {
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .cp-pagination .pagination {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        flex-wrap: nowrap;
        gap: 5px;
        list-style: none;
        padding: 0;
        margin: 0;
        overflow-x: hidden;
        overflow-y: hidden;
        white-space: nowrap;
        max-width: 100%;
        background: none !important;
        border: none !important;
        box-shadow: none !important;
    }
    
    /* Hide scrollbar */
    .cp-pagination .pagination::-webkit-scrollbar {
        display: none;
    }
    
    .cp-pagination .pagination {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    
    .cp-pagination .pagination li {
        display: inline-block;
        margin: 0 !important;
        padding: 0;
        flex-shrink: 0;
    }
    
    .cp-pagination .pagination li a,
    .cp-pagination .pagination li span {
        display: inline-block;
        padding: 5px 10px;
        min-width: auto;
        text-align: center;
        color:rgb(7, 7, 7);
        background-color: transparent !important;
        border: none !important;
        border-radius: 0;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 400;
        font-size: 16px;
        box-shadow: none !important;
        margin: 0;
    }
    
    .cp-pagination .pagination li a:hover {
        color: #86C342;
        background-color: transparent !important;
    }
    
    .cp-pagination .pagination li.active span,
    .cp-pagination .pagination li.active a,
    .cp-pagination .pagination > .active > span,
    .cp-pagination .pagination > .active > a {
        background-color: transparent !important;
        color:#86C342 !important;
        border: none !important;
        cursor: default;
        font-weight: 600;
    }
    
    .cp-pagination .pagination li.disabled span,
    .cp-pagination .pagination li.disabled a {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
        color:rgb(10, 10, 10);
    }
    
    @media (max-width: 768px) {
        .cp-pagination .pagination li {
            margin: 0 2px;
        }
        
        .cp-pagination .pagination li a,
        .cp-pagination .pagination li span {
            padding: 6px 10px;
            font-size: 14px;
        }
    }
    
    /* Continue Reading Button Hover Styling */
    .cp-border-btn {
        color: #333 !important;
        border-color: #86C342 !important;
        transition: all 0.3s ease;
    }
    
    .cp-border-btn:hover {
        background-color: #86C342 !important;
        color: #fff !important;
        border-color: #86C342 !important;
    }
    
    /* Blog Title - Limit to 2 lines with ellipsis */
    .cp-news2-title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.4;
        min-height: 2.8em;
        max-height: 2.8em;
    }
    
    /* Remove bottom margin from last blog items (last row) */
    .cp-news-wrap .row .col-md-6:last-child .cp-news-item,
    .cp-news-wrap .row .col-md-6:last-child article,
    .cp-news-wrap .row .col-md-6:last-child {
        margin-bottom: 0 !important;
    }
    
    /* Also remove margin from second last if it's in the last row */
    .cp-news-wrap .row .col-md-6:nth-last-child(-n+2) .cp-news-item {
        margin-bottom: 0 !important;
    }
    
    /* Remove margin from cp-news-item class on last items */
    .cp-news-wrap .row > div:last-child .cp-news-item,
    .cp-news-wrap .row > div:nth-last-child(2) .cp-news-item {
        margin-bottom: 0 !important;
    }
    
    .cp-news2-title a {
        display: block;
        color: inherit;
        text-decoration: none;
    }
    
    .cp-news2-title a:hover {
        color: #86C342;
    }
    
    /* Redesigned Search Bar Styling */
    .cp-search-wrap {
        margin-bottom: 20px;
    }
    @media (min-width: 769px) {
        .cp-search-wrap {
            margin-right: -92px;
        }
    }
    .cp-search-form {
        position: relative;
        width: 100%;
        max-width: 320px;
        margin-left: auto;
    }
    .cp-search-form input {
        width: 100%;
        height: 48px;
        background: #ffffff;
        border: 1px solid #e1e1e1;
        border-radius: 10px;
        padding: 0 45px 0 15px;
        font-size: 16px;
        color: #333;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }
    .cp-search-form input::placeholder {
        color: #999;
        font-weight: 400;
        font-size: 15px;
    }
    .cp-search-form input:focus {
        border-color: #86C342;
        outline: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.04);
    }
    .cp-search-form button {
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        width: 45px;
        background: transparent;
        color: #777;
        border: none;
        font-size: 18px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .cp-search-form button:hover {
        color: #86C342;
    }
    
    @media (max-width: 768px) {
        .cp-search-wrap {
            margin-right: 0;
            margin-bottom: 25px;
            padding: 0 10px;
        }
        .cp-search-form {
            max-width: 100%;
            margin-left: 0;
        }
        .cp-search-form input {
            height: 55px;
            font-size: 18px;
            width: 100%;
        }
    }
</style>


    
       <section class="page-title-area breadcrumb-spacing cp-bg-14">
       
           @if (Session::has('message'))
        <div class="alert alert-success session-destroy my-sm-0 py-sm-3 text-center">
                <?php echo Session::get('message'); ?>
        </div>
    @endif
        </section>
    <section class="cp-news-area white-bg pt-10 " style="padding-bottom: 10px !important;">
         <div class="container">
             <div class="row align-items-center mb-0">
                 <div class="col-md-7">
                     <h1 class="cp-news-widget-title" style="font-size:30px; padding-bottom: 5px; margin-bottom: 15px;">Our Latest Blogs</h1>
                 </div>
                 <div class="col-md-5">
                    <div class="cp-search-wrap">
                        <form action="javascript:void(0);" method="POST" class="cp-search-form" id="live-blog-search-form">
                            @csrf
                            <input type="text" name="blogsearch" id="blog-search-input" placeholder="search blogs" autocomplete="off">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                 </div>
             </div>
            <div class="row">
               <div class="col-xl-8 col-lg-8">
                   <div class="cp-news-wrap mb-0 pr-30" id="blog-items-container">
                      @include('frontend.pages.blogs.blog_list_partial', ['blogs' => $all_blogss])
                   </div>
                  
                  <!-- Pagination - Only below blogs -->
                  <div class="cp-pagination  mb-0" style="margin-top: -15 !important;">
                     <nav aria-label="Blog Pagination">
                       <ul class="pagination justify-content-start" id="blog-pagination">
                          {!! $all_blogss->onEachSide(2)->links() !!}
                       </ul>
                     </nav>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4">
                  <div class="cp-news-sidebar mb-30">
                      <?php $categories=DB::table('categories')->where('parent_cate','!=','0')->get();?>
                      
                      
                      
                     <div class="cp-news-widget mb-40 wow fadeInUp  animated" data-wow-duration="1.5s" data-wow-delay="0.3" style="visibility: visible; animation-duration: 1.5s; animation-name: fadeInUp;">
                        <h4 class="cp-news-widget-title">Hot Category</h4>
                        <div class="cp-news-widget-cat">
                           <ul>
                                
                               @foreach($categories as $pp)
                               
                            <li><a href="{{url(str_replace(' ', '-', strtolower($pp->cate_url))).'/'}}"> <i class="fa fa-arrow-right"></i> {{ $pp->cate_name }} </a></li>
                              @endforeach
                                      
                              
                           </ul>
                        </div>
                     </div>
                  
                      
                  </div>
               </div>
            </div>
         </div>
      </section>
      
      
      @include('frontend/footer')
 

<script>
$(document).ready(function () {
    // Simple pagination - Show current page ± 3 numbers
    function updatePagination() {
        var $pagination = $('#blog-pagination');
        var $items = $pagination.find('li');
        var currentPage = 1;
        
        // Find current active page
        $items.each(function() {
            if ($(this).hasClass('active')) {
                var pageText = $(this).find('span, a').text().trim();
                currentPage = parseInt(pageText) || 1;
            }
        });
        
        // Show current page ± 3 numbers (total 7 numbers: 3 before, current, 3 after)
        var startPage = Math.max(1, currentPage - 3);
        var endPage = currentPage + 3;
        
        // Show/hide pagination items
        $items.each(function() {
            var $this = $(this);
            var linkText = $this.find('a, span').text().trim();
            var pageNum = parseInt(linkText);
            var isArrow = linkText === '‹' || linkText === '›' || linkText === '«' || linkText === '»' || 
                         linkText === 'Previous' || linkText === 'Next' || linkText.indexOf('...') !== -1;
            
            // Always show arrows/prev/next
            if (isArrow || $this.hasClass('disabled')) {
                $this.show();
                return;
            }
            
            // Always show active page
            if ($this.hasClass('active')) {
                $this.show();
                return;
            }
            
            // Show current page ± 3 numbers
            if (!isNaN(pageNum) && pageNum >= startPage && pageNum <= endPage) {
                $this.show();
            } else {
                $this.hide();
            }
        });
    }
    
    // Run on page load
    updatePagination();

    // LIVE SEARCH AJAX
    let searchTimer;
    const searchInput = $('#blog-search-input');
    const container = $('#blog-items-container');
    const pagination = $('.cp-pagination');
    const originalContent = container.html();

    function performSearch() {
        const query = searchInput.val().trim();
        
        if (query.length === 0) {
            container.html(originalContent);
            pagination.show();
            return;
        }

        if (query.length < 2) return;

        container.css('opacity', '0.5');

        $.ajax({
            url: "{{ url('blog-search') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                blogsearch: query
            },
            success: function(response) {
                container.html(response).css('opacity', '1');
                pagination.hide(); // Hide pagination during search
            },
            error: function() {
                container.css('opacity', '1');
                console.error('Search failed');
            }
        });
    }

    searchInput.on('keyup', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(performSearch, 500);
    });

    $('#live-blog-search-form').on('submit', function(e) {
        e.preventDefault();
        clearTimeout(searchTimer);
        performSearch();
    });
});
</script>