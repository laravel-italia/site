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

$('.collapse').on('shown.bs.collapse', function(){
    $(this)
        .parent()
        .find(".glyphicon-plus")
        .removeClass("glyphicon-plus")
        .addClass("glyphicon-minus");

}).on('hidden.bs.collapse', function(){
    $(this)
        .parent()
        .find(".glyphicon-minus")
        .removeClass("glyphicon-minus")
        .addClass("glyphicon-plus");

});