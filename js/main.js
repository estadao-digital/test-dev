$(document).ready(function() {
    $('.showModal').click(function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        if (url.indexOf('#') == 0) {
            $(url).modal('open');
        } else {
            $.get(url, function(data) {
                $('' + data + '').modal();
            }).success(function() { $('input:text:visible:first').focus(); });
        }
    });
});



$(function(){
    $("#search").keyup(function(){
        var texto = $(this).val();
        $(".result li").css("display", "block");
		$(".result .item-car").each(function(){
            if($(this).text().toUpperCase().indexOf(texto.toUpperCase()) < 0)
                $(this).css("display", "none");
		});
	});
});