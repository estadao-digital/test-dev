$(document).ready(function(){
    $('#initialdate').mask('99/99/9999');

    $('#step1').click(function () {
        var strData = $('#initialdate').val();
        var partesData = strData.split("/");
        var data = new Date(partesData[2], partesData[1] - 1, partesData[0]);
        var today = new Date();
        if($('#initialdate').val().length < 10){
            $('.bg-danger').show();
        }else if( data <= today){
            $('.bg-danger').show();
        }else if( data > today.setDate(today.getDate() + 15)){
            $('.bg-danger').show();
        }else{
            $('.bg-danger').hide();
            $('#offerdate').submit();
        }
    });
});