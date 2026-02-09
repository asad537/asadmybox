$(document).ready(function () {
    function AddReadMore() {
        var carLmt = 1500;
        var readMoreTxt = " ... Read More";
        var readLessTxt = " Read Less";
        
        $(".addReadMore").each(function() {
            if ($(this).find(".SecSec").length)
                return;

            var allstr = $(this).html();
            if (allstr.length > carLmt) {
                var firstSet = allstr.substring(0, carLmt);
                var secdHalf = allstr.substring(carLmt, allstr.length);
                var strtoadd = firstSet + "<span class='SecSec'>" + secdHalf + "</span><span class='readMore' title='Click to Show More'>" + readMoreTxt + "</span><span class='readLess' title='Click to Show Less'>" + readLessTxt + "</span>";
                $(this).html(strtoadd);
            }
        });

        $(document).on("click", ".readMore,.readLess", function() {
            $(this).closest(".addReadMore").toggleClass("showlesscontent showmorecontent");
        });
    }
    
    AddReadMore();
});
