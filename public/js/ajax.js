$(document).ready(function(){

    var url = "/index.php";

     $('#marca').on('change',function () {
            var idMarca = $(this).val();
            $.get('/modelos/' + idMarca, function (modelos) {
                 $('#modelos').empty();
            var i =0;
      
                $.each(modelos, function (key, modelo) {
                    
                    var size = modelo.length;
                    while(i < size){
                        $('#modelo').append('<option value=' + modelo[i].id + '>' + modelo[i].nome + '</option>');
                        i++;
                    }          
                   
                });
            });
        });

    
    $('.open-modal').click(function(){
        var carro_id = $(this).val();

        $.get(url + '/carros/' + carro_id, function (data) {
            
            console.log(data);
            $('#carro_id').val(data.id);
            $('#marca').val(data.marca);
            $('#modelo').val(data.modelo);
            $('#ano').val(data.ano);
            $('#btn-save').val("update");

            $('#myModal').modal('show');
        }) 
    });

  
    $('#btn-add').click(function(){
        $('#btn-save').val("add");
        $('#frmcarros').trigger("reset");
        $('#myModal').modal('show');
    });


    $('.delete-carro').click(function(){
        var carro_id = $(this).val();

        $.ajax({

            type: "DELETE",
            url: url + '/carros/' + carro_id,
            success: function (data) {
                console.log(data);

                $("#carro" + carro_id).remove();
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
            marca: $('#marca').val(),
            modelo: $('#modelo').val(),
            ano: $('#ano').val(),
        }

    
        var state = $('#btn-save').val();

        var type = "POST"; 
        var carro_id = $('#carro_id').val();;
        var my_url = url;

        if (state == "update"){
            type = "PUT"; 
            my_url += '/carros/' + carro_id;
        }

        console.log(formData);

        $.ajax({

            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);

                var carro = '<tr id="carro' + data.id + '"><td>' + data.id + '</td><td>' + data.carro + '</td><td>' + data.description + '</td><td>' + data.created_at + '</td>';
                carro += '<td><button class="btn btn-warning btn-xs btn-detail open-modal" value="' + data.id + '">Edit</button>';
                carro += '<button class="btn btn-danger btn-xs btn-delete delete-carro" value="' + data.id + '">Delete</button></td></tr>';

                if (state == "add"){ //if user added a new record
                    $('#carros-list').append(carro);
                }else{ //if user updated an existing record

                    $("#carro" + carro_id).replaceWith( carro );
                }

                $('#frmcarros').trigger("reset");

                $('#myModal').modal('hide')
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

});




