/**
 * 
 * This file contains all general functions of the application
 * 
 */

function isNormalInteger(str) {
    var n = Math.floor(Number(str));
    return n !== Infinity && String(n) === str && n >= 0;
}

function renderListCar(element) {
    $('table.cars').find('tbody').append([
        '<tr>',
            "<input type='hidden' class='car_id' value='"+element.id+"'>",
            "<td class='brand_name'>"+element.brand_name+"</td>",
            "<td class='model'>"+element.model+"</td>",
            "<td class='year'>"+element.year+"</td>",
            "<td class='buttons'>",
                "<button type='button' class='btn btn-success' onclick='editCar(this)'>",
                    "<i class='fas fa-pencil-alt'></i>",
                    "<i class='fas fa-save hidden'></i>",
                "</button>",
                "<button type='button' class='btn btn-danger' onclick='deleteCar(this)'>",
                    "<i class='fas fa-trash-alt'></i>",
                "</button>",
            "</td>",
        "</tr>"
    ].join(''));
}

function renderBrandList(element, index, array) {
    $('datalist#brands').append([
        '<option value="'+element.brand_name+'">'
    ].join(''));
}


/**
 * Ajax to render the list of cars into the main view
 */
function getListCar(){
    $.ajax({
        type: "GET",
        url: "api/carros",
        success: function(data) {
            data.data.forEach(renderListCar);
            $('.filter').find('input').first().focus();
        }
    });
    $.ajax({
        type: "GET",
        url: "api/marcas",
        success: function(data) {
            data.data.forEach(renderBrandList);
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
    var unindexed_array = $(button).closest('tr').find('th :input').serializeArray();
    var indexed_array = {};
    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    $.ajax({
        type: "POST",
        url: "api/carros",
        data: JSON.stringify(indexed_array),
        success: function(data) {
            if(data.status == 201){
                $('.alert').find('span').text(data.message);  //add text to alert
                $('.alert').removeClass('alert-danger').addClass('alert-success').fadeIn();     //shows alert
                //getListCar();
                renderListCar(data.data);
                $('.form-add').find('input').each(function(){
                    $(this).val('');
                });
                setTimeout(function(){ $('.alert').fadeOut(); }, 3000);     //fade it out after 3 seconds
            } else{
                data.errors.forEach(function(element){
                    $('.alert').find('span').text(element);
                });  //add text to alert
                $('.alert').removeClass('alert-success').addClass('alert-danger').fadeIn();     //shows alert
                setTimeout(function(){ $('.alert').fadeOut(); }, 3000);     //fade it out after 3 seconds
            }
            $('.filter').find('input').first().focus();
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
        type: "DELETE",
        url: "api/carros/"+id,
        success: function(data) {
            if(data.status == 201){
                $('.alert').find('span').text(data.message);  //add text to alert
                $('.alert').removeClass('alert-danger').addClass('alert-success').fadeIn();     //shows alert
                row.remove();
                setTimeout(function(){ $('.alert').fadeOut(); }, 3000);     //fade it out after 3 seconds
            } else{
                $('.alert').find('span').text(data.message);  //add text to alert
                $('.alert').removeClass('alert-success').addClass('alert-danger').fadeIn();     //shows alert
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

function renderRowEdited(row){
    var edit_button = row.find('.buttons').find('button').first();

    row.find('td').not('.buttons').each(function(){
        var value = $(this).find('input').val();
        $(this).html(value);
    });
    edit_button.attr('onclick', "editCar(this);");
    edit_button.find('svg.fa-pencil-alt').removeClass('hidden');   //hide edit icon
    edit_button.find('svg.fa-save').addClass('hidden');      //show save icon
}

/**
 * Ajax to edit some car from db
 * then reload the view
 * Yes, I should just edit the row, but doing this garantee to 
 * position the edited row into the right position
 */
function saveEditCar(button){
    var row = $(button).closest('tr'),
        id = row.find('input').val(),
        unindexed_array = $(button).closest('tr').find('td :input').serializeArray(),
        indexed_array = {};

    row.find('.alert').fadeOut().remove(); //remove all previous alerts

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });
    
    $.ajax({
        type: "PUT",
        url: "api/carros/"+id,
        data: JSON.stringify(indexed_array),
        success: function(data) {
            if(data.status == 201){
                $('.alert').find('span').text(data.message);  //add text to alert
                $('.alert').removeClass('alert-danger').addClass('alert-success').fadeIn();     //shows alert
                //getListCar();
                renderRowEdited(row);

                setTimeout(function(){ $('.alert').fadeOut(); }, 3000);     //fade it out after 3 seconds
            } else{
                $('.alert').find('span').text(data.message);  //add text to alert
                for (var index in data.errors) {
                    if(isNormalInteger(index)){
                        $('.alert').find('span').text(data.errors[index]);  //add text to alert
                        $('.alert').removeClass('alert-success').addClass('alert-danger').fadeIn();     //shows alert
                        setTimeout(function(){ $('.alert').fadeOut(); }, 3000);     //fade it out after 3 seconds
                    } else{
                        row.find('.'+index).append($('.alert').clone());
                        row.find('.'+index).find('.alert').find('span').text(data.errors[index]);
                        row.find('.alert').addClass('alert-danger').fadeIn();     //shows alert
                        setTimeout(function(){ row.find('.alert').fadeOut().remove(); }, 10000);     //fade it out after 3 seconds
                    }
                }  //add text to alert
                
            }
        }
    });
}

$(document).ready(function(){
    getListCar(); //initial render of car's list

    // Fade out the alert, after clicking the 'x' button
    $('.alert .close').click(function(){
        $('.alert').fadeOut();
    });
});
