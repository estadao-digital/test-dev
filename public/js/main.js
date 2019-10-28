function addRow(row) {

    let $table = $("#carrosTable");

    let tr = '<tr data-idCarro="'+row.id+'">'+
                '<td>'+row.id+'</td>'+
                '<td>'+row.marca+'</td>'+
                '<td>'+row.modelo+'</td>'+
                '<td>'+row.ano+'</td>'+
                '<td><button type="button" class="btn btn-primary" onclick="editCarro(this)" data-idCarro="'+row.id+'" data-toggle="modal" data-target="#modalExemplo"><i class="fas fa-wrench"></i></button></td>'+
                '<td><button name="deleteCarro" onclick="removeCarro(this)" data-idCarro="'+row.id+'" class="btn btn-danger deleteCarro"><i class="fa fa-trash"></i></button></td>'+
            '</tr>';

    //console.log(tr);

    $table.find('tbody').append(tr);

}

function removeCarro(el, edit=false)
{

    let id = $(el).data("idcarro");
    //let key = $(el).data("key");

    $.ajax({
        url: '/api/carros/'+id,
        //dataType: 'json',
        type: 'DELETE',
        success: function (response) {
            console.log(response);

            if (typeof response.id == "number"){
                $(el).closest('tr').remove();
            }


        }
    });

}

function editCarro(el)
{

    $("#formEditar")[0].reset();

    let id = $(el).data("idcarro");

    $.ajax({
        url: '/api/carros/' + id,
        type: 'GET',
        success: function (response) {
            console.log(response);

            $("#marcaEdt").val(response.marca);

            $("#modeloEdt").val(response.modelo);

            $("#anoEdt").val(response.ano);

            $("#update").attr("data-idupdatecarro", response.id);
        }
    });
}

$("#update").click(function () {

    let form = $("#formEditar").serializeArray();
    let id = $(this).attr("data-idupdatecarro");

    $.ajax({
        url: '/api/carros/' + id,
        type: 'PUT',
        data: form,
        dataType: 'json',
        success: function (data) {

            if (typeof data.id == "number"){

                $("#carrosTable").find("tr").each(function(index, el) {
                    if ( $(el).attr("data-idcarro") == id ){
                        console.log('bateu');

                        $(el).find("td:eq(1)").text(data.marca);
                        $(el).find("td:eq(2)").text(data.modelo);
                        $(el).find("td:eq(3)").text(data.ano);



                    }
                });

            }

            /*if (data.success === "true"){
                let msg = data.msg;
                $.alert({
                    title: 'Contato atualizado',
                    content: msg,
                    buttons: {
                        confirm: {
                            text: 'OK',
                            action: function () {
                                location.reload();
                            }
                        },

                    }

                });
            }*/

        }
    });

});



$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$("#store").click(function () {
    let data = $("#formCadastro").serializeArray();

    $.ajax({
        url: '/api/carros',
        type: 'POST',
        data: data,
        success: function (response) {
            console.log(response);
            addRow(response);
        }
    });
});

window.onload = function(){

    $.ajax({
        url: '/api/carros',
        type: 'GET',
        success: function (response) {
            console.log(response);

            //console.log(typeof(response));

            $.each(response, function(index, val) {
                addRow(val);
            });
        }
    });
}
