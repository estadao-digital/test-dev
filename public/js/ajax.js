$(document).ready(function(){

    var url = "/test-dev/public/cars";

    
    $('.open-modal').click(function(){
        var car_id = $(this).val();

        $.get(url + '/carros/' + car_id, function (data) {
            
            console.log(data);
            $('#car_id').val(data.id);
            $('#marca').val(data.marca);
            $('#modelo').val(data.modelo);
            $('#btn-save').val("update");

            $('#myModal').modal('show');
        }) 
    });

  
    $('#btn-add').click(function(){
        $('#btn-save').val("add");
        $('#frmcars').trigger("reset");
        $('#myModal').modal('show');
    });


    $('.delete-car').click(function(){
        var car_id = $(this).val();

        $.ajax({

            type: "DELETE",
            url: url + '/carros/' + car_id,
            success: function (data) {
                console.log(data);

                $("#car" + car_id).remove();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });


    $("#btn-save").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })

        e.preventDefault(); 

        var formData = {
            marca: $('#car').val(),
            modelo: $('#description').val(),
            ano: $('#ano').val(),
        }

    
        var state = $('#btn-save').val();

        var type = "POST"; 
        var car_id = $('#car_id').val();;
        var my_url = url;

        if (state == "update"){
            type = "PUT"; 
            my_url += '/carros/' + car_id;
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
                    $('#cars-list').append(car);
                }else{ //if user updated an existing record

                    $("#car" + car_id).replaceWith( car );
                }

                $('#frmcars').trigger("reset");

                $('#myModal').modal('hide')
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
});