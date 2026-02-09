/* Demo Scripts for Bootstrap Carousel and Animate.css article
  on SitePoint by Maria Antonietta Perna
 */
  (function ($) {
    $(window).on("scroll", function () {
        var scroll = $(window).scrollTop();
        if (scroll < 400) {
            $("#sticky-header").removeClass("sticky");
            $("#back-top").fadeIn(500);
        } else {
            $("#sticky-header").addClass("sticky");
            $("#back-top").fadeIn(500);
        }
    });

    var blogSlider = function () {
        $(".owl-carousel.pb-feedback-slider").owlCarousel({
            dots: true,
            loop: true,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 2000,
            autoplayHoverPause: true,
            nav: true,
            navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
            responsive: {
                0: {
                    dotsEach: 5,
                    items: 1,
                },
                600: {
                    dotsEach: 3,
                    items: 2,
                },
                1200: {
                    dotsEach: 1,
                    items: 2,
                },
            },
        });
    };

    blogSlider();

    var relatedProdSlider = function () {
        $(".owl-carousel.pb-relatedProd-slider").owlCarousel({
            dots: false,
            loop: true,
            margin: 20,
            autoplay: true,
            autoplayTimeout: 2000,
            autoplayHoverPause: true,
            nav: true,
            navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
            responsive: {
                0: {
                    // dotsEach: 5,
                    items: 1,
                },
                600: {
                    // dotsEach: 3,
                    items: 2,
                },
                1200: {
                    // dotsEach: 1,
                    items: 3,
                },
            },
        });
    };

    relatedProdSlider();



    
    var proProdSlider = function () {
        $(".owl-carousel.pb-promProd-slider").owlCarousel({
            dots: false,
            loop: true,
            margin: 20,
            autoplay: true,
            autoplayTimeout: 2000,
            autoplayHoverPause: true,
            nav: true,
            navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
            responsive: {
                0: {
                    // dotsEach: 5,
                    items: 1,
                },
                600: {
                    // dotsEach: 3,
                    items: 2,
                },
                1200: {
                    // dotsEach: 1,
                    items: 4,
                },
            },
        });
    };

    proProdSlider();
    
    $(".prod-sm-items").owlCarousel({
        loop: true,
        margin: 10,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {
            0: {
                items: 3,
            },
            600: {
                items: 3,
            },
            1000: {
                items: 4,
            },
        },
    });
    $(".prod-sm-itemss").owlCarousel({
        loop: true,
        margin: 10,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {
            0: {
                items: 2,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 4,
            },
        },
    });
    /*------------------
  Single Product
--------------------*/
    $(".prod-sm-items img").on("click", function () {
        var imgurl = $(this).data("imgbigurl");
        var bigImg = $(".prod-items-pic").attr("src");
        if (imgurl != bigImg) {
            $(".prod-items-pic").attr({
                src: imgurl,
            });
        }
    });

    var clientsFeedback = function () {
        $("#testimonial-slider.owl-carousel").owlCarousel({
            dots: true,
            loop: false,
            margin: 30,
            autoplay: true,
            autoplayTimeout: 2000,
            autoplayHoverPause: true,
            nav: false,
            navText: false,
            responsive: {
                0: {
                    dotsEach: 5,
                    items: 1,
                },
                600: {
                    dotsEach: 3,
                    items: 2,
                },
                1200: {
                    dotsEach: 1,
                    items: 3,
                },
            },
        });
    };

    clientsFeedback();
    
    
    
    
    
    //customer start
     var clientsFeedbackx = function () {
        $("#testimonial-sliderx.owl-carousel").owlCarousel({
            dots: false,
            loop: true,
            margin: 30,
            autoplay: true,
            autoplayTimeout: 2000,
            autoplayHoverPause: true,
            nav: false,
            navText: false,
            responsive: {
                0: {
                    dotsEach: 5,
                    items: 6,
                },
                600: {
                    dotsEach: 3,
                    items: 6,
                },
                1200: {
                    dotsEach: 1,
                    items: 6,
                },
            },
        });
    };

    clientsFeedbackx();


    /* ---------------------------------------------------------------------------- */
    /* ---------------------------  // reveal Animation  on scroll //  -------------------- */
    /* ---------------------------------------------------------------------------- */

    $(document).ready(function () {
        function reveal() {
            var reveals = document.querySelectorAll(".reveal");

            for (var i = 0; i < reveals.length; i++) {
                var windowHeight = window.innerHeight;
                var elementTop = reveals[i].getBoundingClientRect().top;
                var elementVisible = 150;

                if (elementTop < windowHeight - elementVisible) {
                    reveals[i].classList.add("active");
                } else {
                    reveals[i].classList.remove("active");
                }
            }
        }
        window.addEventListener("scroll", reveal);
    });


    /* ---------------------------------------------------------------------------- */
    /* ---------------------------  // Show more or less content Dynamically //  -------------------- */
    /* ---------------------------------------------------------------------------- */



    $(document).ready(function () {
        // $(".content").hide();
        $(".show_hide").on("click", function () {
            
            var txt = $(".content").is(':visible') ? 'Read More' : 'Read Less';
            $(".show_hide").text(txt);
            $(this).next('.content').slideToggle(200);
        });
    });



    function AddReadMore() {
        //This limit you can set after how much characters you want to show Read More.
        var carLmt = 150;
        // Text to show when text is collapsed
        var readMoreTxt = " ... Read More";
        // Text to show when text is expanded
        var readLessTxt = " Read Less";
    
    
        //Traverse all selectors with this class and manupulate HTML part to show Read More
        $(".addReadMore").each(function() {
            if ($(this).find(".firstSec").length)
                return;
    
            var allstr = $(this).text();

            console.log(allstr);
            if (allstr.length > carLmt) {
                var firstSet = allstr.substring(0, carLmt);
                var secdHalf = allstr.substring(carLmt, allstr.length);
                var strtoadd =  firstSet  + "<span class='SecSec'>" + secdHalf + "</span><span class='readMore'  title='Click to Show More'>" + readMoreTxt + "</span><span class='readLess' title='Click to Show Less'>" + readLessTxt + "</span>";
                $(this).html(strtoadd);
            }
    
        });
        //Read More and Read Less Click Event binding
        $(document).on("click", ".readMore,.readLess", function() {
            $(this).closest(".addReadMore").toggleClass("showlesscontent showmorecontent",8000);
        });
    }
    $(function() {
        //Calling function after Page Load
        AddReadMore();
    });
    /* ---------------------------------------------------------------------------- */
    /* ---------------------------  // Go to scroll //  -------------------- */
    /* ---------------------------------------------------------------------------- */
    
    $(document).ready(function () {
        $("#goback2Top").hide();

        $(window).scroll(function () {
            if ($(this).scrollTop() > 700) {
                $("#goback2Top").show().fadeIn();
            } else {
                $("#goback2Top").hide().fadeOut();
            }
        });

        $("#goback2Top").click(function () {
            $("body, html").animate({ scrollTop: 0 }, 360);
            return false;
        });
    });
         /* ---------------------------------------------------------------------------- */
            /* ---------------------------  // Session desstroy //  -------------------- */
            /* ---------------------------------------------------------------------------- */
            
            
            setInterval(()=>{
                  $('.session-destroy').fadeOut() 
            } , 2000);
    
    /* ---------------------------------------------------------------------------- */
            /* ---------------------------  // Zendesk Chat //  -------------------- */
            /* ---------------------------------------------------------------------------- */
    
    

 window.zESettings = {
     webWidget: {
        chat: {
            connectOnPageLoad: true        
        }
    }
 };


 
    
         /* ---------------------------------------------------------------------------- */
            /* ---------------------------  // Recaptcha  Styling //  -------------------- */
            /* ---------------------------------------------------------------------------- */



            // document.getElementById("msform").addEventListener("submit",function(evt)
            // {
            //     var response = grecaptcha.getResponse();
            //     if(response.length == 0)
            //     {
            //           evt.preventDefault();
            //           document.getElementById("cpac").innerHTML = "Please Enter Capcha";
            //           return false;
            //     }else{
            //           return true;
            //     }
            // });
            
            
        
    
})(jQuery);
