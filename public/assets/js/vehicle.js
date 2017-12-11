$(document).ready(function() {

    $('#form-vehicle').submit(function(){
       var dados = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: '/module/Vehicle/src/Ajax/vehicle.php',
            dataType: 'json',
            data: dados,
            success: function(data) {

                if (data.success == true) {
                    $('#list-vehicle').html('<img src="/public/assets/images/loading.gif" alt="Carregando.." title="Carregando.." style="display:block;margin:0 auto;" />');
                    $('#vehicle').modal('toggle');

                    var html = '';
                    $.each(data.vehicles, function(key, value){
                        html += '<div class="col-sm-4 col-md-3" id="'+value.id+'"> <div class="product__item"> <img src="/public/assets/images/car.png" alt="'+value.brand_name+' '+value.model+'" title="'+value.brand_name+' '+value.model+'" class="img-responsive"> <div class="product__name">'+value.brand_name+' '+value.model+'</div> <p>Ano: '+value.year+' - '+value.year_model+'</p> <a href="javascript:void(0)" onclick="edit('+value.id+')" title="Editar"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a> <a href="javascript:void(0)" onclick="del('+value.id+')" title="Excluir"> <i class="fa fa-trash-o" aria-hidden="true"></i> </a> </div></div>';
                    });

                    setTimeout(function(){
                        $('#list-vehicle').html(html);
                    }, 300);
                }
                if (data.success == false) {
                    $('#message').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Atenção!</strong> '+data.message+'</div>');
                }
            },
            error: function(request){
                $('#message').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Atenção!</strong> '+request.responseText+'</div>');
            }
        });

        return false;
    });

    $('#add-vehicle').click(function(){
        $("#form-vehicle").trigger('reset');
        $('#edit').val(0);
    });
});
function edit(id){
    $.ajax({
        type: 'GET',
        url: '/module/Vehicle/src/Ajax/edit-vehicle.php',
        dataType: 'json',
        data: {'id':id},
        success: function(data) {
            if (data.success == true) {
                 var modal = $('#vehicle');
                 modal.find('.modal-body #edit').val(id);
                 modal.find('.modal-body #brand').val(data.vehicle.brand_id).change();
                 modal.find('.modal-body #model').val(data.vehicle.model);
                 modal.find('.modal-body #year').val(data.vehicle.year).change();
                 modal.find('.modal-body #yearModel').val(data.vehicle.year_model).change();

                $('#vehicle').modal({
                    show: true
                });
            }
            if (data.success == false) {
                console.log(data.message);
            }
        },
        error: function(request){
            console.log(request.responseText);
        }
    });
}
function del(id){
    $.ajax({
        type: 'GET',
        url: '/module/Vehicle/src/Ajax/delete-vehicle.php',
        dataType: 'json',
        data: {'id':id},
        success: function(data) {
            if (data.success == true) {
                $('#'+id).fadeOut(800, function () {
                    $('#'+id).remove();
                });
            }
            if (data.success == false) {
                console.log(data.message);
            }
        },
        error: function(request){
            console.log(request.responseText);
        }
    });
}