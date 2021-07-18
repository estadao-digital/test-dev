$(document).on("click","button",function(){

    if($(this).data("toggle"))
    {
        $("#"+$(this).data("toggle")).show();
    }
});


$(document).on("click",".close",function(){

    $(this).parent().parent().parent().hide();

});