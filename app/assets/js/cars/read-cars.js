$(document).ready(function(){

    showProducts();

    $(document).on('click', '.read-cars-button', function(){
        showProducts();
    });

});

function showProducts(){

    const _url = window.location.href;

    $.getJSON(_url + "carros", function(data){

        var read_products_html=`
        
        <div id='create-car' class='btn btn-primary pull-right m-b-15px create-car-button'>
            <span class='glyphicon glyphicon-plus'></span> Adicionar Carro
        </div>
        
        <table class='table table-bordered table-hover'>
            <tr>
                <th class='w-10-pct'>ID</th>
                <th class='w-10-pct'>Marca</th>
                <th class='w-15-pct'>Modelo</th>
                <th class='w-10-pct'>Ano</th>
                <th class='w-25-pct text-align-center'>Ação</th>
            </tr>`;

            $.each(data.records, function(key, val) {

                read_products_html+=`
                    <tr>
                        <td>` + val.id + `</td>
                        <td>` + val.marca_name + `</td>
                        <td>` + val.modelo + `</td>
                        <td>` + val.ano + `</td>
                        <td>
                            <!-- visualizar -->
                            <button class='btn btn-primary m-r-10px read-one-car-button' data-id='` + val.id + `'>
                                <span class='glyphicon glyphicon-eye-open'></span> Detalhes
                            </button>

                            <!-- editar -->
                            <button class='btn btn-info m-r-10px update-car-button' data-id='` + val.id + `'>
                                <span class='glyphicon glyphicon-edit'></span> Editar
                            </button>

                            <!-- deletar -->
                            <button class='btn btn-danger delete-car-button' data-id='` + val.id + `'>
                                <span class='glyphicon glyphicon-remove'></span> Deletar
                            </button>
                        </td>
                    </tr>`;
            });

        read_products_html+=`</table>`;

        $("#page-content").html(read_products_html);

        changePageTitle("Test-DEV - Mini API de Carros");

    });
}
