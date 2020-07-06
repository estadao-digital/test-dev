$(document).ready(function(){

    $(document).on('click', '.update-car-button', function(){

        const _url = window.location.href;
        var id = $(this).attr('data-id');

        $.getJSON(_url + "carros/read-only?id=" + id, function(data){

            var modelo = data.modelo;
            var ano = data.ano;
            var marca_id = data.marca_id;
            var marca_name = data.marca_name;

            $.getJSON(_url + "marcas", function(data){

                var marcas_options_html=`<select name='marca_id' class='form-control'>`;

                $.each(data.records, function(key, val){

                    if(val.id==marca_id){ marcas_options_html+=`<option value='` + val.id + `' selected>` + val.name + `</option>`; }

                    else{ marcas_options_html+=`<option value='` + val.id + `'>` + val.name + `</option>`; }
                });
                marcas_options_html+=`</select>`;

                var update_car_html=`
                <div id='read-cars' class='btn btn-primary pull-right m-b-15px read-cars-button'>
                    <span class='glyphicon glyphicon-list'></span> Voltar
                </div>
                               
                <form id='update-car-form' action='#' method='post' border='0'>
                    <table class='table table-hover table-responsive table-bordered'>
                    
                        <tr>
                            <td>Marca</td>
                            <td>` + marcas_options_html + `</td>
                        </tr>  
                                       
                        <tr>
                            <td>Modelo</td>
                            <td><input value=\"` + modelo + `\" type='text' name='modelo' class='form-control' required /></td>
                        </tr>
                                         
                        <tr>
                            <td>Ano</td>
                            <td><input value=\"` + ano + `\" type='number' min='1' name='ano' class='form-control' required /></td>
                        </tr>
                          
                        <tr>                 
                            <td><input value=\"` + id + `\" name='id' type='hidden' /></td>
                 
                            <td>
                                <button type='submit' class='btn btn-info'>
                                    <span class='glyphicon glyphicon-edit'></span> Editar Carro
                                </button>
                            </td>
                 
                        </tr>
                 
                    </table>
                </form>`;

                $("#page-content").html(update_car_html);

                changePageTitle("Editar Carro");
            });
        });
    });

    $(document).on('submit', '#update-car-form', function(){

        const _url = window.location.href;
        var form_data=JSON.stringify($(this).serializeObject());

        $.ajax({
            url: _url + "carros/update",
            type : "POST",
            contentType : 'application/json',
            data : form_data,
            success : function(result) {

                showProducts();
            },
            error: function(xhr, resp, text) {

                console.log(xhr, resp, text);
            }
        });

        return false;
    });
});