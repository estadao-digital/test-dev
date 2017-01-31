/**
 * Created by felipefranco on 23/01/17.
 */
$(document).ready(function(){

    var url = "/estadao-crud/public/carros";

    //display modal form for car editing
    $('.open-modal').click(function(){
        var carro_id = $(this).val();

        $.get(url + '/show/' + carro_id, function (data) {
            //success data
            console.log(data);
            $('#carro_id').val(data.id);
            $('#carro').val(data.carro);
            $('#description').val(data.description);
            $('#btn-save').val("update");

            $('#myModal').modal('show');
        })
    });

    //display modal form for creating new Car
    $('#btn-add').click(function(){
        $('#btn-save').val("add");
        $('#frmCarros').trigger("reset");
        $('#myModal').modal('show');
    });

    //delete car and remove it from list
    $('.delete-car').click(function(){
        var car_id = $(this).val();

        $.ajax({

            type: "DELETE",
            url: url + '/' + car_id,
            success: function (data) {
                console.log(data);

                $("#car" + car_id).remove();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

    //create new car / update existing car
    $("#btn-save").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })

        e.preventDefault();

        var formData = {
            car: $('#car').val(),
            description: $('#description').val(),
        }

        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-save').val();

        var type = "POST"; //for creating new resource
        var car_id = $('#car_id').val();;
        var my_url = url;

        if (state == "update"){
            type = "PUT"; //for updating existing resource
            my_url += '/' + car_id;
        }

        console.log(formData);

        $.ajax({

            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);

                var car = '<tr id="car' + data.id + '"><td>' + data.id + '</td><td>' + data.car + '</td><td>' + data.description + '</td><td>' + data.created_at + '</td>';
                car += '<td><button class="btn btn-warning btn-xs btn-detail open-modal" value="' + data.id + '">Edit</button>';
                car += '<button class="btn btn-danger btn-xs btn-delete delete-car" value="' + data.id + '">Delete</button></td></tr>';

                if (state == "add"){ //if user added a new record
                    $('#carros-list').append(car);
                }else{ //if user updated an existing record

                    $("#car" + car_id).replaceWith( car );
                }

                $('#frmCarros').trigger("reset");

                $('#myModal').modal('hide')
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
});