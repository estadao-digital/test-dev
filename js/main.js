const url = 'http://localhost:8080/carros/';

//===============================================
$(document).ready(function(){
    changeView('listar');

    //===============================================
    $(document).on('click', '.btn-view', function(){
        var view = $(this).data('view');
        var data = { id: $(this).data('id') };
        changeView(view, data);
    })

    //===============================================
    $(document).on('submit', '#form', function(e){
        e.preventDefault();
        var marca = $('#marca').val();
        var modelo = $('#modelo').val();
        var ano = $('#ano').val();
        var id = $('#id').val();
        //Array
        var data = { marca: marca, modelo: modelo, ano: ano };
        //Verificar vazio
        $('#msg').html('');
        if($.isEmptyObject(data.marca) || $.isEmptyObject(data.modelo) || $.isEmptyObject(data.ano)){
            $('#msg').html('Preencher todos os campos');
            return;
        }
        if(id){
            //Atualizar carro
            updateCar(id, JSON.stringify(data), function(output){
                changeView('listar');
            });
        } else {
            //Inserir carro
            insert(JSON.stringify(data), function(output){
                changeView('listar');
            });
        }
    });

    //===============================================
    $(document).on('click', '.btn-delete', function(){
        var id = $(this).data('id');
        deleteCar(id, function(output){
            if(output){
                changeView('listar');
            }
        });
    });

});

//===============================================
updateCar = (id, data, output) => {
    $.ajax({
        url: url+id,
        type: 'PUT',
        data: data,
        dataType: 'json',
        success: function(response) {
            output(response);
        }
    });
}

//===============================================
deleteCar = (id, output) => {
    $.ajax({
        url: url+id,
        type: 'DELETE',
        dataType: 'json',
        success: function(response) {
            output(response);
        }
    });
}

//===============================================
insert = (data, output) => {
    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function(response) {
          output(response);
        }
    });
}

//===============================================
changeView = (view, data = null) => {
    $('#content').load("/view/"+view+".php", {
        data: data
    }, function() {});
}

//===============================================
addHtml = (data, where) => {
    $(where).html(data);
}