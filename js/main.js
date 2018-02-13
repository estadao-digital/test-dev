/**
 * 
 * This file contains all general functions of the application
 * 
 * I don't call the api directly from ajax
 * My internal controller that calls the api, proccess the information 
 * and returns the view rendered
 * (Multiple frameworks use this method)
 * I know it's being depracated with react and angular, 
 * but it was told to use pure javascript on the instructions (okay, I used jQuery, sorry)
 * 
 */

/**
 * Ajax to render the list of cars into the main view
 */
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

/**
 * Ajax to add some car into the db
 * then reload the view
 * Yes, I should just add the row, but doing this garantee to 
 * position the new row into the right position
 */
function addCar(button){
    $.ajax({
        type: "POST",
        url: "controllers/CarsController.php/addCar",
        data: $(button).closest('tr').find('th :input').serialize(),
        success: function(data) {
            var data_parse = JSON.parse(data);
            if(data_parse.status == 201){
                $('.alert').find('span').text(data_parse.message);  //add text to alert
                $('.alert').addClass('alert-success').fadeIn();     //shows alert
                renderListCar();
                setTimeout(function(){ $('.alert').fadeOut(); }, 3000);     //fade it out after 3 seconds
            } else{
                $('.alert').find('span').text(data_parse.message);  //add text to alert
                $('.alert').addClass('alert-danger').fadeIn();     //shows alert
                setTimeout(function(){ $('.alert').fadeOut(); }, 3000);     //fade it out after 3 seconds
            }
        }
    });
}

/**
 * Ajax to remove some car from db
 * then remove the row
 */
function deleteCar(button){
    var row = $(button).closest('tr'),
        id = row.find('input').val();
    $.ajax({
        type: "POST",
        url: "controllers/CarsController.php/deleteCar/"+id,
        success: function(data) {
            var data_parse = JSON.parse(data);
            if(data_parse.status == 201){
                $('.alert').find('span').text(data_parse.message);  //add text to alert
                $('.alert').addClass('alert-success').fadeIn();     //shows alert
                row.remove();
                setTimeout(function(){ $('.alert').fadeOut(); }, 3000);     //fade it out after 3 seconds
            } else{
                $('.alert').find('span').text(data_parse.message);  //add text to alert
                $('.alert').addClass('alert-danger').fadeIn();     //shows alert
                setTimeout(function(){ $('.alert').fadeOut(); }, 3000);     //fade it out after 3 seconds
            }
        }
    });
}

/**
 * Function to change the row that will be edited
 */
function editCar(button){
    var row = $(button).closest('tr'),
        id = row.find('input').val(),
        edit_button = row.find('.buttons').find('button').first();

    row.find('td').not('.buttons').each(function(){
        var value = $(this).html();
        $(this).html($('.filters').find('th').eq($(this).index()-1).html()); //copy input fields from filters to the row that will be edited
        $(this).find('input').val(value); //add the values to recently created input
    });
    edit_button.attr('onclick', "saveEditCar(this);");
    edit_button.find('svg.fa-pencil-alt').addClass('hidden');   //hide edit icon
    edit_button.find('svg.fa-save').removeClass('hidden');      //show save icon
}

/**
 * Ajax to edit some car from db
 * then reload the view
 * Yes, I should just edit the row, but doing this garantee to 
 * position the edited row into the right position
 */
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
                $('.alert').find('span').text(data_parse.message);  //add text to alert
                $('.alert').addClass('alert-success').fadeIn();     //shows alert
                renderListCar();
                setTimeout(function(){ $('.alert').fadeOut(); }, 3000);     //fade it out after 3 seconds
            } else{
                $('.alert').find('span').text(data_parse.message);  //add text to alert
                $('.alert').addClass('alert-danger').fadeIn();     //shows alert
                setTimeout(function(){ $('.alert').fadeOut(); }, 3000);     //fade it out after 3 seconds
            }
        }
    });
}

$(document).ready(function(){
    renderListCar(); //initial render of car's list

    // Fade out the alert, after clicking the 'x' button
    $('.alert .close').click(function(){
        $('.alert').fadeOut();
    });
});
