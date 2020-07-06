$(document).ready(function(){

    $(document).on('click', '.read-one-car-button', function(){

        const _url = window.location.href;
        var id = $(this).attr('data-id');

        $.getJSON(_url + "/api/carro/read_one.php?id=" + id, function(data){

            var read_one_car_html=` 
          
            <div id='read-cars' class='btn btn-primary pull-right m-b-15px read-cars-button'>
                <span class='glyphicon glyphicon-list'></span> Voltar
            </div>
            
            <table class='table table-bordered table-hover'>             
               
                <tr>
                    <td class='w-30-pct'>Modelo</td>
                    <td class='w-70-pct'>` + data.modelo + `</td>
                </tr>
                            
                <tr>
                    <td>Ano</td>
                    <td>` + data.ano + `</td>
                </tr>
                     
                <tr>
                    <td>Marca</td>
                    <td>` + data.marca_name + `</td>
                </tr>
             
            </table>`;

            $("#page-content").html(read_one_car_html);

            changePageTitle("Detalhe do Carro");
        });
    });

});