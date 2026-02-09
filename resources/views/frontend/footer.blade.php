 <!-- footer area start  -->
<footer>
   <div class="cp-footer-wrap cp-bg-6 pt-20">
         <!--<div class="cp-footer2-shape one cp-bg-move-xy zi--1">-->
         <!--   <img src="{{url('box_assets/img/footer-shape-2.png')}}" alt="footer-shape">-->
         <!--</div>-->
         <!--<div class="cp-footer-shape two cp-bg-move-xy zi--1">-->
         <!--   <img src="{{url('box_assets/img/footer-shape-3.png')}}" alt="footer-shape">-->
         <!--</div>-->
         <div class="container-fluid">
            <div class="cp-footer-wrap mb-10">
               <div class="row">
                  <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6">
                     <div class="cp-footer-widget mb-60">
                        <div class="logo mb-20" style="">
                         <a href="{{url('/')}}"><img src="{{url('my-box-printing-logo.svg')}}" alt="logo" width="300" height="60"></a>
                        </div>
                        <p>The vision behind “MyBoxPrinting” is to set new standards of excellence in printing and packaging services.</p>
                        <div class="footer-reviews hide-on-mobile">
                          <a href="https://g.page/r/CXoS0VYj1SlmEBI/review" target="_blank" rel="noopener noreferrer">
                            <img src="{{url('box_assets/img/google-reviws-logo.webp')}}" alt="Google Reviews Logo" width="145" height="58" loading="lazy">
                          </a>
                          <a href="https://www.trustpilot.com/review/myboxprinting.com" target="_blank" rel="noopener noreferrer">
                            <img src="{{url('box_assets/img/Trust-pilot_1.png')}}" alt="Trustpilot Logo" width="100" height="" loading="lazy">
                          </a>
                        </div>
      <!--<br>-->
      <!--<br>-->
      
                        <img src="{{url('satisfaction-guarantee.webp')}}" alt="satisfaction-guarantee" width="150" height="150" loading="lazy">
                        <img src="{{url('postive-ssl.webp')}}" alt="postive-ssl" width="150" height="150" loading="lazy">
                         
    
  
    
                     </div>
                     
                  </div>
                  <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 hide-on-mobile ">
                     <div class="cp-footer-widget mb-60">
                        <h3 class="cp-footer-widget-title">Hot Categories</h3>
                        <div class="cp-footer-widget-link">
                           <ul>
                                   <?php $new_arrivals= DB::table('categories')->orderBy('id', 'desc')->limit(8)->get();?>

                         @foreach($new_arrivals as $new_arrivals)
                            <li><a class="" href="{{url($new_arrivals->cate_url).'/'}}">{{$new_arrivals->cate_name}}</a></li>
                            @endforeach
                            
                             
                           </ul>
                        </div>
                     </div>
                  </div>
                  <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 hide-on-mobile ">
                     <div class="cp-footer-widget mb-60">
                        <h3 class="cp-footer-widget-title">Products</h3>
                        <div class="cp-footer-widget-link">
                           <ul>
                                  <li><a class="" href="{{url('custom-box-packaging').'/'}}">Custom Boxes</a></li>
                                  
                                   <?php $pp= DB::table('products')->orderBy('id', 'asc')->limit(8)->get();?>

                         @foreach($pp as $pp)
                            <li><a class="" href="{{url($pp->prod_url).'/'}}">{{$pp->prod_name}}</a></li>
                            @endforeach
                            
                             
                           </ul>
                        </div>
                     </div>
                  </div>
                 <div class="col-12 col-xxl-2 col-xl-3 col-lg-4 col-md-6">
    <div class="cp-footer-widget mb-60">
        <h3 class="cp-footer-widget-title">Useful Links</h3>
        <div class="cp-footer-widget-link">
            <ul class="footer-links">
                <li><a href="{{url('beat-my-price').'/'}}" title="Beat my Price">Beat my Price</a></li>
                <li><a href="{{url('get-quote/').'/'}}" title="Get a Quote">Get a Quote</a></li>
                <li><a href="{{url('contact-us').'/'}}" title="Contact US">Contact US</a></li>
                <?php $dynamic_page = DB::table('dynamic_pages')->get(); ?>
                @foreach ($dynamic_page as $item)
                    <li><a href="{{ url(str_replace(' ', '-', strtolower($item->page_url))).'/'}}" title="{{$item->page_name}}">{{$item->page_name}}</a></li>
                @endforeach
                <li><a href="{{url('sitemap.html').'/'}}" title="Sitemap">Sitemap</a></li>
            </ul>
        </div>
    </div>
</div>
 <style>
     .cp-footer-email-form input{
         width:400px !important;
     }
 </style>

                  <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 hide-on-mobile ">
                     <div class="cp-footer-widget mb-60">
                        <h3 class="cp-footer-widget-title">Newsletter</h3>
                        <p class="mb-25">Subscribe to our newsletter to get helpful industry news and the latest packaging ideas!</p>
                         <div class="cp-footer-email-form mb-45">
                        <form action="{{url('email_subcribe').'/'}}" method="post">
                                @csrf
                           <input type="email" name="email_subcribe" placeholder="Enter Your Email" required>
                           <button type="submit" class="cp-btn" style="    width: 150px;">
                              Subscribe <i class="fal fa-paper-plane"></i>
                             
                           </button>
                        </form>
                     </div>
                     
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="container">
            <div class="cp-copy2-border">
               <div class="row">
                  <div class="col-lg-4">
                     <div class="cp-copy2-text">
                        <p>Copyright 2026 | Design By <a target="_blank" href="#">MyBoxPrinting
                           </a></p>
                     </div>
                  </div>
                    <?php $socials_media=DB::table('socials_media')->get();?>
                    
                  <div class="col-lg-8">
                   <div class="cp-footer-social">
                        <ul>
                           <li>
                              <a target="_blank" href="{{$socials_media[0]->facebook_link}}">facebook <i class="fab fa-facebook-f"></i></a>
                           </li>
                                <li><a target="_blank" href="https://www.pinterest.com/myboxprintingus/">Pinterest <i class="fab fa-pinterest"></i></a></li>
                  
                           <li><a target="_blank" href="{{$socials_media[0]->twitter_link}}">Twitter <i class="fab fa-twitter"></i></a></li>
                           <li><a target="_blank" href="{{$socials_media[0]->instagram_link}}">Instagram <i class="fab fa-instagram"></i></a></li>
                           <li><a target="_blank" href="{{$socials_media[0]->youtube_link}}">YouTube <i class="fab fa-youtube"></i></a></li>
                           <li><a target="_blank" href="{{$socials_media[0]->linkedin_link}}">Linkedin <i class="fab fa-linkedin-in"></i></a></li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </footer>
 
   <!-- Critical scripts but deferred for TBT reduction - dependencies managed via defer order or DOMContentLoaded -->
   <script defer src="{{url('box_assets/js/jquery-3.6.0.min.js')}}"></script>
   <script defer src="{{url('box_assets/js/bootstrap.bundle.min.js')}}"></script>
   
   <!-- Defer non-critical scripts for better FCP/LCP -->
   <script defer src="{{url('box_assets/js/waypoints.min.js')}}"></script>
   <script defer src="{{url('box_assets/js/meanmenu.js')}}"></script>
   <script defer src="{{url('box_assets/js/swiper-bundle.min.js')}}"></script>
   @if(!isset($isProductPage) && !isset($isBlogPage))
   <script defer src="{{url('box_assets/js/magnific-popup.min.js')}}"></script>
   @endif
   <script defer src="{{url('box_assets/js/parallax.min.js')}}"></script>
   <script defer src="{{url('box_assets/js/backToTop.js')}}"></script>
   <!-- <script defer src="{{url('box_assets/js/nice-select.min.js')}}"></script> -->
   <script defer src="{{url('box_assets/js/counterup.min.js')}}"></script>
   <script defer src="{{url('box_assets/js/ajax-form.js')}}"></script>
   @if(!isset($isProductPage) && !isset($isBlogPage))
   <script defer src="{{url('box_assets/js/wow.min.js')}}"></script>
   <script defer src="{{url('box_assets/js/isotope.pkgd.min.js')}}"></script>
   <script defer src="{{url('box_assets/js/imagesloaded.pkgd.min.js')}}"></script>
   <script defer src="{{url('box_assets/js/tilt.jquery.min.js')}}"></script>
   <script defer src="{{url('box_assets/js/main_owl.carousel.min.js')}}"></script>
   @endif
   <script defer src="{{url('box_assets/js/beforeafter.jquery-1.0.0.js')}}"></script>
   
   <!-- Heavy scripts loaded last with defer -->
   @if(!Request::is('/') && !isset($isProductPage))
   <script defer src="{{url('box_assets/js/jquery-ui-slider-range.min.js')}}"></script>
   @endif
   @if(!Request::is('/') && !isset($isProductPage))
   <script defer src="{{url('box_assets/js/jquery.ez-plus.min.js')}}"></script>
   @endif
   <!-- <script defer src="{{url('box_assets/js/tween-max.js')}}"></script> -->
   <script defer src="{{url('box_assets/js/main.js')}}"></script>
   
   <!-- Mobile Performance Optimization Script -->
   <script defer src="{{url('box_assets/js/mobile-performance.js')}}"></script>
   
 <script>
        // Delay Zendesk until window load to prevent blocking LCP/FCP
        var scriptLoadedz = false;
        function loadZendesk() {
            if (scriptLoadedz) return;
            scriptLoadedz = true;
            var scriptz = document.createElement('script');
            scriptz.id = 'ze-snippet';
            scriptz.src = 'https://static.zdassets.com/ekr/snippet.js?key=f3a32a9c-7305-49a5-b7fe-d15b22476662';
            document.body.appendChild(scriptz);
        }

        // Load Zendesk after window load with delay
        window.addEventListener('load', function() {
            setTimeout(function() {
                if ('requestIdleCallback' in window) {
                    requestIdleCallback(loadZendesk);
                } else {
                    setTimeout(loadZendesk, 1000);
                }
            }, 3000); // 3 second delay after window load
        }, { passive: true });
    </script>
     <script>
        const lazyBgObserver = new IntersectionObserver((entries, observer) => {
         entries.forEach(entry => {
        if (entry.isIntersecting) {
            const bgElement = entry.target;
            bgElement.style.backgroundImage = `url(${bgElement.dataset.bg})`;
            bgElement.classList.remove("lazy-bg");
            observer.unobserve(bgElement);
                }
            });
        });
        
        document.querySelectorAll('.lazy-bg').forEach(element => {
            lazyBgObserver.observe(element);
        });
    </script>
    
 <script>
     // Initialize Custom Select Logic on DOMContentLoaded for faster interactivity
     document.addEventListener('DOMContentLoaded', function() {
             var x, i, j, l, ll, selElmnt, a, b, c;
            /*look for any elements with the class "custom-select":*/
            x = document.getElementsByClassName("custom-select");
            l = x.length;
    for (i = 0; i < l; i++) {
      selElmnt = x[i].getElementsByTagName("select")[0];
      if (!selElmnt) continue; // Skip if no select found
      if (x[i].getElementsByClassName("select-selected").length > 0) continue; // Skip if already initialized
      ll = selElmnt.length;
      /*for each element, create a new DIV that will act as the selected item:*/
      a = document.createElement("DIV");
      a.setAttribute("class", "select-selected select-selected-bottom-rounded");
      a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
      x[i].appendChild(a);
      /*for each element, create a new DIV that will contain the option list:*/
      b = document.createElement("DIV");
      b.setAttribute("class", "select-items select-hide");
      for (j = 1; j < ll; j++) {
        /*for each option in the original select element,
        create a new DIV that will act as an option item:*/
        c = document.createElement("DIV");
        c.innerHTML = selElmnt.options[j].innerHTML;
        c.addEventListener("click", function(e) {
            /*when an item is clicked, update the original select box,
            and the selected item:*/
            var y, i, k, s, h, sl, yl;
            s = this.parentNode.parentNode.getElementsByTagName("select")[0];
            sl = s.length;
            h = this.parentNode.previousSibling;
            for (i = 0; i < sl; i++) {
              if (s.options[i].innerHTML == this.innerHTML) {
                s.selectedIndex = i;
                h.innerHTML = this.innerHTML;
                y = this.parentNode.getElementsByClassName("same-as-selected");
                yl = y.length;
                for (k = 0; k < yl; k++) {
                  y[k].removeAttribute("class");
                }
                this.setAttribute("class", "same-as-selected");
                break;
              }
            }
            h.click();
        });
        b.appendChild(c);
      }
      x[i].appendChild(b);
      a.addEventListener("click", function(e) {
          /*when the select box is clicked, close any other select boxes,
          and open/close the current select box:*/
          e.stopPropagation();
          closeAllSelect(this);
          this.nextSibling.classList.toggle("select-hide");
          this.classList.toggle("select-arrow-active");
          this.classList.toggle("select-selected-bottom-square");
        });
    }
    function closeAllSelect(elmnt) {
      /*a function that will close all select boxes in the document,
      except the current select box:*/
      var x, y, i, xl, yl, arrNo = [];
      x = document.getElementsByClassName("select-items");
      y = document.getElementsByClassName("select-selected");
      xl = x.length;
      yl = y.length;
      for (i = 0; i < yl; i++) {
        if (elmnt == y[i]) {
          arrNo.push(i)
        } else {
          y[i].classList.remove("select-arrow-active");
          y[i].classList.remove("select-selected-bottom-square");
        }
      }
      for (i = 0; i < xl; i++) {
        if (arrNo.indexOf(i)) {
          x[i].classList.add("select-hide");
        }
      }
    }
    /*if the user clicks anywhere outside the select box,
    then close all select boxes:*/
    document.addEventListener("click", closeAllSelect);
     });
 </script>
 
 
 <!-- Include JavaScript to toggle the extra content -->
<script>
 
$('.moreless-button').click(function() {
  $('.moretext').slideToggle();
  if ($('.moreless-button').text() == "Read more") {
    $(this).text("Read less")
  } else {
    $(this).text("Read more")
  }
});
</script>




    <style>
        #quote-cart-pay-call {
 
    position: fixed;
    cursor: pointer;
    
    z-index: 99999999;
    background-color: #86C342;
    color: white;
    font-weight: 600;
    top: 50%;
    left: -65px;
    text-decoration: none;
    padding: 7px 20px;
    transform: rotate(90deg);
    font-size: 20px; 
}
    </style> 
 
<!--<a class="quick-view" style="border-radius: 10px" id="quote-cart-pay-call"  href="{{url('get-quote').'/'}}"><i class="fal fa-envelope-open-text">-->
<!--Instant Quote-->
<!--</i>-->
<!-- </a>-->
<!--<div class="smt-app smt-app-whatsapp force-desktop">-->
<!--            <div class="waves-whatsapp sm-shake bottom-right   sm-fixed hover-opacity sm-button sm-button-text sm-rounded" style="background-color:#896E54;">-->
<!--                <a href="https://wa.me/16308850045" target="_blank">-->
<!--                    <img alt="" src="https://www.corrugationboxes.com/whatsapp.svg">-->
<!--                    <span>&nbsp;</span>-->
<!--                    <span style="color: rgb(255, 255, 255);">Any questions? Inquire on Whatsapp</span>-->
<!--                    <span>&nbsp;&nbsp;</span>-->
<!--                    <div class="sm-red-dot"></div>-->
<!--                </a>-->
<!--            </div>-->
<!--        </div>-->
 
 
 <script>
document.addEventListener('DOMContentLoaded', function() {
    $(document).on("click", ".read-more, .read-less", function () {
        $(this).closest(".add-read-more").toggleClass("show-less-content show-more-content");
    });
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Owl Carousel
        $(".prod-sm-items").owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 3000,
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 4
                }
            }
        });

        // Handle thumbnail click
        $('.gallery-thumbnail').on('click', function () {
            const newSrc = $(this).data('src'); // Get the new image source from data-src
            $('#main-image').attr('src', newSrc); // Update the main image's src attribute
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const video = document.getElementById('scrollVideo');

        if ('IntersectionObserver' in window && video) {
            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        video.play();
                        observer.unobserve(video); // play only once
                    }
                });
            }, { threshold: 0.5 });

            observer.observe(video);
        } else {
            // fallback for older browsers
            video.play();
        }
    });
</script>



</body>

</html>
