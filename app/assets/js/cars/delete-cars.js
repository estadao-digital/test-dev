$(document).ready(function(){

    $(document).on('click', '.delete-car-button', function(){

        const _url = window.location.href;

        var car_id = $(this).attr('data-id');

        bootbox.confirm({

            message: "<h4>Você tem certeza?</h4>",
            buttons: {
                confirm: {
                    label: '<span class="glyphicon glyphicon-ok"></span> Sim',
                    className: 'btn-danger'
                },
                cancel: {
                    label: '<span class="glyphicon glyphicon-remove"></span> Não',
                    className: 'btn-primary'
                }
            },
            callback: function (result) {

                if(result==true){

                    $.ajax({
                        url: _url + "/api/carro/delete.php",
                        type : "POST",
                        dataType : 'json',
                        data : JSON.stringify({ id: car_id }),
                        success : function(result) {

                            showProducts();
                        },
                        error: function(xhr, resp, text) {

                            console.log(xhr, resp, text);
                        }
                    });

                }
            }
        });
    });
});