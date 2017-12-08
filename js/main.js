$( document ).ready(function() {

    var page = 1;
    var is_ajax_fire = 0;

    gerenciaDados();
    
    function gerenciaDados() {
        $.ajax({
            dataType: 'json',
            url: 'api.php',
            data: {page:page}
        }).done(function(data){
            preencherLista(data);
            is_ajax_fire = 1;
        }).fail(function() {
            alert( "error" );
        });
    
    }

    function preencherLista(data) {
        var	rows = '';
        $.each( data, function( key, value ) {
 
            rows = rows + '<tr>';
            rows = rows + '<td>'+value.id+'</td>';
            rows = rows + '<td>'+value.marca+'</td>';
            rows = rows + '<td>'+value.modelo+'</td>';
            rows = rows + '<td>'+value.ano+'</td>';
            rows = rows + '<td data-id="'+value.id+'">';
            rows = rows + '<button data-toggle="modal" data-target="#edit-item" class="btn btn-primary edit-item">Edit</button> ';
            rows = rows + '<button class="btn btn-danger remove-item">Delete</button>';
            rows = rows + '</td>';
            rows = rows + '</tr>';
        });
    
        $("tbody").html(rows);
    }
    
    function obterDados() {
        $.ajax({
            dataType: 'json',
            url: 'api.php',
            data: {page:page}
        }).done(function(data){
                preencherLista(data);
        });
    }
    
    $(".crud-submit").click(function(e){
        e.preventDefault();
         var marca = $("#create-item").find("select[name='marca']").val();
        var modelo= $("#create-item").find("input[name='modelo']").val();
        var ano   = $("#create-item").find("input[name='ano']").val();
        if(marca != '' && modelo != '' && ano != ''){
            $.ajax({
                dataType: 'json',
                type:'POST',
                url: "api.php",
                data:{marca:marca, modelo:modelo, ano:ano}
            }).done(function(data){
                console.log(data);
                $("#create-item").find("select[name='marca']").val('');
                $("#create-item").find("input[name='modelo']").val('');
                $("#create-item").find("input[name='ano']").val('');
                obterDados();
                $(".modal").modal('hide');
                toastr.success('Carro Creado com sucesso.', 'Alerta de sucesso', {timeOut: 5000});
            }).fail(function() {
                alert( "error" );
            });
        }else{
            alert('Você não preencheu a Marca ou Modelo ou Ano do Veiculo.')
        }
    });

    $("body").on("click",".remove-item",function(){
        var id = $(this).parent("td").data('id');
        var c_obj = $(this).parents("tr");

        $.ajax({
            dataType: 'json',
            type:'DELETE',
            url: url + 'api.php',
            data:{id:id}
        }).done(function(data){
            c_obj.remove();
            toastr.success('Item Excluido com sucesso.', 'Alerta Sucesso', {timeOut: 5000});
            obterDados();
        });

    });
 
 
    $("body").on("click",".edit-item",function(){
        
        var id     = $(this).parent("td").data('id');
        var ano    = $(this).parent("td").prev("td").text();
        var modelo = $(this).parent("td").prev("td").prev("td").text();
        var marca  = $(this).parent("td").prev("td").prev("td").prev("td").text();

        $("#edit-item").find("select[name='marca']").val(marca);
        $("#edit-item").find("input[name='modelo']").val(modelo);
        $("#edit-item").find("input[name='ano']").val(ano);
        $("#edit-item").find(".edit-id").val(id);
    
    });
    
    
    $(".crud-submit-edit").click(function(e){
    
        e.preventDefault();
        var marca = $("#edit-item").find("select[name='marca']").val();
        var modelo= $("#edit-item").find("input[name='modelo']").val();
        var ano   = $("#edit-item").find("input[name='ano']").val();
        var id = $("#edit-item").find(".edit-id").val();
        if(marca != '' && modelo != '' && ano != ''){
            $.ajax({
                dataType: 'json',
                type:'PUT',
                url: 'api.php',
                data: {marca:marca, modelo:modelo, ano:ano,id:id}
            }).done(function(data){
                obterDados();
                $(".modal").modal('hide');
                toastr.success('Item atualizado com sucesso.', 'Alerta Sucesso', {timeOut: 5000});
            });
        }else{
            alert('Você não preencheu a Marca ou Modelo ou Ano do Veiculo.')
        }
    
    });



});