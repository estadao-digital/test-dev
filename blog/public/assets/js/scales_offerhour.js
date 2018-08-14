$(document).ready(function () {
    $('#in').mask('99:99', {autoclear: true});
    $('#out').mask('99:99', {autoclear: true});



    $('#step2').click(function () {
        var strData = $('input#data').val();
        var partesData = strData.split("/");
        var hourin = $('#in').val();
        var partein = hourin.split(":");
        var start = new Date(partesData[2], partesData[1]-1, partesData[0] , partein[0],partein[1]);
        var hourout = $('#out').val();
        var parteout = hourout.split(":");
        var end = new Date(partesData[2], partesData[1]-1, partesData[0] , parteout[0],parteout[1]);
        var diff = moment.utc(moment(end,"DD/MM/YYYY HH:mm").diff(moment(start,"DD/MM/YYYY HH:mm"))).format("HH:mm");
        var duration = $("input#duration").val();
        if($('#in').val().length > 0  && $('#out').val().length> 0){
            if (end <= start){
                $('.bg-danger').show();
            }else if(diff < duration){
                $('.bg-danger').show();
            }else{
                $('.bg-danger').hide();
                $('#offerhour').submit();
            }
        }else if($('#in').val().length == 0  && $('#out').val().length == 0 && !$('#option-any').is(':checked')){
            $('.bg-danger').show();
        }else{
            $('.bg-danger').hide();
            $('#offerhour').submit();
        }
    });
    $('#option-any').click(function () {
        if($('#option-any').is(':checked')){
            $('#in').val('');
            $('#out').val('');
        }
    });
    $('#in').blur(function () {
        if($('#in').val()  != ''){
            $('#option-any').prop('checked',false);
        }
    });
    $('#out').blur(function () {
        if($('#out').val()  != ''){
            $('#option-any').prop('checked',false);
        }
    });



});
