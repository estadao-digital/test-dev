$(document).ready(function(){
    $('#submit_offertype').click(function () {
        if($('input[name=offertype]').is(':checked')){
            $('#offertype').submit();
        }
    });

});
