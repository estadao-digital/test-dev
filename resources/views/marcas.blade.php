@extends('layout.app', ["current" => "marcas"])

@section('body')

<h4>Marcas dos Veículos</h4>

    
<div class="card border">
    <div class="card-body">
        <h5 class="card-title">Listagem</h5>


        <table class="table table-ordered table-hover" id="tabelaMarcas">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Marca</th>
                </tr>
            </thead>
            <tbody>
          
            </tbody>
        </table>
    
    </div>
    <div class="card-footer">
        <button class="btn btn-sm btn-primary" role="button" onClick="novaMarca()">
            Nova Marca
        </button>
    </div>
</div>

<div class="modal" tabindex="1" id="dlgMarca">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" class="form-horizontal" id="formMarca">
                <div class="modal-header">
                    <h5 class="modal-title">Nova Marca</h5>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="id" class="form-control">

                    <div class="form-group">
                        <label for="marca" class="control-label">Marca</label>                        
                        <div class="input-group">
                             <input type="text" id="marca" class="form-control" placeholder="Marca">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <button type="cancel" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card-footer">
    </div>

</div>
@endsection


@section('javascript')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });


        console.log('aqui');
        function novaMarca(){
            $('#id').val('');
            $('#marca').val('');
            $('#dlgMarca').modal('show');
        }

   
    function montarLinha(m) {  
        
        var linha = "<tr>" + 
            "<td>" + m.id + "</td>" +
            "<td>" + m.marca+ "</td>" +
            "<td>" +
              '<button class="btn btn-sm btn-primary" onclick="editar(' + m.id + ')"> Editar </button> ' +
            "</td>" +
            "</tr>";
        return linha;
    }
    
    function editar(id) {
        $.getJSON('/api/marcas/'+id, function(data) { 
            $('#id').val(data.id);
            $('#marca').val(data.marca);
            $('#dlgMarca').modal('show');            
        });        
    }
    
    function remover(id) {
        $.ajax({
            type: "DELETE",
            url: "/api/marcas/" + id,
            context: this,
            success: function() {
                console.log('Apagou OK');
                linhas = $("#tabelaMarcas>tbody>tr");
                e = linhas.filter( function(i, elemento) { 
                    return elemento.cells[0].textContent == id; 
                });
                if (e)
                    e.remove();
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
    
    function carregarMarcas() {
        $.getJSON('/api/marcas', function(marcas) { 
            for(i=0;i<marcas.length;i++) {
                linha = montarLinha(marcas[i]);
                $('#tabelaMarcas>tbody').append(linha);
            }
        });        
    }
    
    function criarMarca() {
        marca = { 
            marca: $("#marca").val(), 
        };
        $.post("/api/marcas", marca, function(data) {
            marca = JSON.parse(data);
            linha = montarLinha(marca);
            $('#tabelaMarcas>tbody').append(linha);            
        });
    }
    
    
    function salvarMarca() {
        marca_vel = { 
            id : $("#id").val(), 
            marca: $("#marca").val(), 
        };
        $.ajax({
            type: "PUT",
            url: "/api/marcas/" + marca_vel.id,
            context: this,
            data: marca_vel,
            success: function(data) {
                marca = JSON.parse(data);
                linhas = $("#tabelaMarcas>tbody>tr");
                e = linhas.filter( function(i, e) { 
                    return ( e.cells[0].textContent == marca.id );
                });
                if (e) {
                    e[0].cells[0].textContent = marca.id;
                    e[0].cells[1].textContent = marca.marca;
                }
            },
            error: function(error) {
                console.log(error);
            }
        });        
    }
    
    
    $("#formMarca").submit( function(event){ 
        event.preventDefault(); 
        if ($("#id").val() != '')
            salvarMarca();
        else
            criarMarca();
            
        $("#dlgMarca").modal('hide');
    });
    
    
    $(function(){
        carregarMarcas();
    });
    </script>
@endsection