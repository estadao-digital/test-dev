var update = false;
var carUpdate = false;
var _carros = [];


$(document).ready(function () {

    getCarros();

    $(document).on('click','#cardAddButton',function(){
        $("#cardMain").hide();
        $("#cardAdd").show();
        update = false;

        $("#cardAddText").html("Adicionar Carro");
    });

    $(document).on('click','#cardAddBack',function(){

        $("[name='modelo']").val('');
        $("[name='marca']").val('Audi');
        $("[name='ano']").val('');

        $("#cardAdd").hide();
        $("#cardMain").show();
    });

    $(document).on('click','.updateCarro',function(){
        
        let id = $(this).data('id');

        carUpdate = _carros[id];

        $("[name='modelo']").val(carUpdate.modelo);
        $("[name='marca']").val(carUpdate.marca);
        $("[name='ano']").val(carUpdate.ano);

        $("#cardAddText").html("Modificar Carro");

        $("#cardMain").hide();
        $("#cardAdd").show();
        update = true;
    });
    

    $(document).on('click', '#modalButton', function (e) {

        var carro = { modelo: $("[name='modelo']").val(), marca: $("[name='marca']").val(), ano: $("[name='ano']").val() };

        if (!update) {
            insertCarro({ modelo: $("[name='modelo']").val(), marca: $("[name='marca']").val(), ano: $("[name='ano']").val() });
        }
        else {
            updateCarro({ modelo: $("[name='modelo']").val(), marca: $("[name='marca']").val(), ano: $("[name='ano']").val(),id:carUpdate.id });
        }

    });

    $(document).on('click','.deleteCarro',function(){
        deleteCarro($(this).data("id"));
    });
});


function getCarros() {

    $.ajax({
        url: "http://localhost:8080/api/carros",
        dataType: "json",
        headers: {
            'Content-Type': 'application/json'
        },
        success: function (data) {

            var tableBody = ``;

            _carros = [...data.carros];

            if( _carros.length >0)
            {
                _carros.forEach((carro,index ) => {
                    tableBody += `  <tr>
                                        <td>${carro.modelo}</td>
                                        <td>${carro.marca}</td>
                                        <td>${carro.ano}</td>
                                        <td>
                                            <svg data-id="${index}" class="updateCarro" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="19pt" height="17pt" viewBox="0 0 19 17" version="1.1"> <path style=" stroke:none;fill-rule:nonzero;fill-opacity:1;" d="M 13.269531 11.453125 L 14.324219 10.390625 C 14.492188 10.222656 14.777344 10.339844 14.777344 10.578125 L 14.777344 15.40625 C 14.777344 16.285156 14.070312 17 13.195312 17 L 1.582031 17 C 0.710938 17 0 16.285156 0 15.40625 L 0 3.71875 C 0 2.839844 0.710938 2.125 1.582031 2.125 L 10.605469 2.125 C 10.839844 2.125 10.957031 2.410156 10.792969 2.578125 L 9.738281 3.640625 C 9.6875 3.691406 9.621094 3.71875 9.550781 3.71875 L 1.582031 3.71875 L 1.582031 15.40625 L 13.195312 15.40625 L 13.195312 11.636719 C 13.195312 11.566406 13.222656 11.5 13.269531 11.453125 Z M 18.4375 4.75 L 9.773438 13.46875 L 6.792969 13.800781 C 5.925781 13.898438 5.191406 13.164062 5.289062 12.289062 L 5.617188 9.285156 L 14.28125 0.566406 C 15.035156 -0.191406 16.253906 -0.191406 17.007812 0.566406 L 18.433594 2.003906 C 19.1875 2.761719 19.1875 3.996094 18.4375 4.75 Z M 15.175781 5.777344 L 13.261719 3.847656 L 7.132812 10.019531 L 6.890625 12.1875 L 9.042969 11.945312 Z M 17.3125 3.132812 L 15.890625 1.695312 C 15.753906 1.558594 15.53125 1.558594 15.402344 1.695312 L 14.382812 2.722656 L 16.296875 4.652344 L 17.316406 3.625 C 17.449219 3.484375 17.449219 3.265625 17.3125 3.132812 Z M 17.3125 3.132812 "/></svg>
                                            <svg data-id="${carro.id}" class="deleteCarro" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" width="24px" height="24px"><path d="M 10 2 L 9 3 L 4 3 L 4 5 L 5 5 L 5 20 C 5 20.522222 5.1913289 21.05461 5.5683594 21.431641 C 5.9453899 21.808671 6.4777778 22 7 22 L 17 22 C 17.522222 22 18.05461 21.808671 18.431641 21.431641 C 18.808671 21.05461 19 20.522222 19 20 L 19 5 L 20 5 L 20 3 L 15 3 L 14 2 L 10 2 z M 7 5 L 17 5 L 17 20 L 7 20 L 7 5 z M 9 7 L 9 18 L 11 18 L 11 7 L 9 7 z M 13 7 L 13 18 L 15 18 L 15 7 L 13 7 z"/></svg>
                                        </td>
                                </tr>`;
                });
            }
            else
            {
                tableBody = `<tr  style="height:500px">
                                <td colspan="4">Não há nenhum carro adicionado 😢 <br> <br> Clique no botão abaixo para adicionar um carro.</td>
                            </tr>`;
            }

            tableBody +=`<tr> <td colspan="4"> <button type="button" id="cardAddButton"  class="ripple" style="width:100%; border-radius:0px;" >Novo Carro</button> </td> </tr>`;

            

            $("#tableCarros > tbody").html(tableBody);

        },
        error: function (error) {
            console.log(error);
        }
    });
}


function insertCarro(carro) {
    
    $.ajax({
        url: "http://localhost:8080/api/carros",
        dataType: "json",
        processData: false,
        method:"POST",
        data:JSON.stringify(carro),
        headers: {
            'Content-Type': 'application/json'
        },
        success: function (data) {

            $("#cardAddBack").click();
            getCarros();
            
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function updateCarro(carro) {
    $.ajax({
        url: "http://localhost:8080/api/carros/"+carro.id, 
        dataType: "json",
        processData: false,
        method:"PUT",
        data:JSON.stringify(carro),
        success: function (result) {
            $("#cardAddBack").click();
            getCarros();
        }
    });
}

function deleteCarro(id) {
    $.ajax({
        url: "http://localhost:8080/api/carros/"+id,
        dataType: "json",
        processData: false,
        method:"DELETE",
        success: function (data) {
            getCarros();  
        },
        error: function (error) {
            console.log(error);
        }
    });
}

