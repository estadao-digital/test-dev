function renderListCar(){
    $.ajax({
        type: "POST",
        url: "controllers/CarsController.php/getCars",
        success: function(data) {
            $("#main-container").html(data);
            $('.filter').find('input').first().focus();
        }
    });
}

function addCar(button){
    $.ajax({
        type: "POST",
        url: "controllers/CarsController.php/addCar",
        data: $(button).closest('tr').find('th :input').serialize(),
        success: function(data) {
            var data_parse = JSON.parse(data);
            if(data_parse.status == 201){
                $('.alert').find('span').text(data_parse.message);
                $('.alert').addClass('alert-success').fadeIn();
                renderListCar();
                setTimeout(function(){ $('.alert').fadeOut(); }, 3000);
            } else{
                $('.alert').find('span').text(data_parse.message);
                $('.alert').addClass('alert-danger').fadeIn();
                setTimeout(function(){ $('.alert').fadeOut(); }, 3000);
            }
        }
    });
}

function deleteCar(button){
    var row = $(button).closest('tr'),
        id = row.find('input').val();
    $.ajax({
        type: "POST",
        url: "controllers/CarsController.php/deleteCar/"+id,
        success: function(data) {
            var data_parse = JSON.parse(data);
            if(data_parse.status == 201){
                $('.alert').find('span').text(data_parse.message);
                $('.alert').addClass('alert-success').fadeIn();
                row.remove();
                setTimeout(function(){ $('.alert').fadeOut(); }, 3000);
            } else{
                $('.alert').find('span').text(data_parse.message);
                $('.alert').addClass('alert-danger').fadeIn();
                setTimeout(function(){ $('.alert').fadeOut(); }, 3000);
            }
        }
    });
}

function editCar(button){
    var row = $(button).closest('tr'),
        id = row.find('input').val(),
        edit_button = row.find('.buttons').find('button').first();

    row.find('td').not('.buttons').each(function(){
        var value = $(this).html();
        $(this).html($('.filters').find('th').eq($(this).index()-1).html());
        $(this).find('input').val(value);
    });
    edit_button.attr('onclick', "saveEditCar(this);");
    edit_button.find('svg.fa-pencil-alt').addClass('hidden');
    edit_button.find('svg.fa-save').removeClass('hidden');
}

function saveEditCar(button){
    var row = $(button).closest('tr'),
        id = row.find('input').val();
    $.ajax({
        type: "POST",
        url: "controllers/CarsController.php/updateCar/"+id,
        data: $(button).closest('tr').find('td :input').serialize(),
        success: function(data) {
            var data_parse = JSON.parse(data);
            if(data_parse.status == 201){
                $('.alert').find('span').text(data_parse.message);
                $('.alert').addClass('alert-success').fadeIn();
                renderListCar();
                setTimeout(function(){ $('.alert').fadeOut(); }, 3000);
            } else{
                $('.alert').find('span').text(data_parse.message);
                $('.alert').addClass('alert-danger').fadeIn();
                setTimeout(function(){ $('.alert').fadeOut(); }, 3000);
            }
        }
    });
}

$(document).ready(function(){
    renderListCar();

    $('.alert .close').click(function(){
        $('.alert').fadeOut();
    });
});