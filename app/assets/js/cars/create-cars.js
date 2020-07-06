$(document).ready(function(){

    $(document).on('click', '.create-car-button', function(){

            const _url = window.location.href;

            $(document).on('submit', '#create-car-form', function(){

                var form_data=JSON.stringify($(this).serializeObject());

                $.ajax({
                    url: _url + "carros/create",
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

            $.getJSON(_url + "marcas", function(data){

                var marcas_options_html=`<select name='marca_id' class='form-control'>`;
                $.each(data.records, function(key, val){
                    marcas_options_html+=`<option value='` + val.id + `'>` + val.name + `</option>`;
                });

                marcas_options_html+=`</select>`;

                var create_car_html=`
              
                <div id='read-cars' class='btn btn-primary pull-right m-b-15px read-cars-button'>
                    <span class='glyphicon glyphicon-list'></span> Voltar
                </div>
                              
                <form id='create-car-form' action='#' method='post' border='0'>
                    <table class='table table-hover table-responsive table-bordered'>                 
                       
                       <tr>
                            <td>Marca</td>
                            <td>` + marcas_options_html + `</td>
                        </tr>
                        
                        <tr>
                            <td>Modelo</td>
                            <td><input type='text' name='modelo' class='form-control' required /></td>
                        </tr>
                                        
                        <tr>
                            <td>Ano</td>
                            <td><input type='number' min='1' name='ano' class='form-control' required /></td>
                        </tr>   
                                        
                        <tr>
                            <td></td>
                            <td>
                                <button type='submit' class='btn btn-primary'>
                                    <span class='glyphicon glyphicon-plus'></span> Criar Carro
                                </button>
                            </td>
                        </tr>
                 
                    </table>
                </form>`;

            $("#page-content").html(create_car_html);

            changePageTitle("Adicionar Carro");
        });
    });
});