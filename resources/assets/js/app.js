$(document).ready(function(){
    $( "#to_top" ).click(function() {
        $('html, body').animate({ scrollTop: 0 }, '800');
    });
});

$(window).scroll(function(){
    if($(window).scrollTop() > 600){
        $("#to_top").fadeIn("slow");
    }
});

$(window).scroll(function(){
    if($(window).scrollTop() < 600){
        $("#to_top").fadeOut("fast");
    }
});
