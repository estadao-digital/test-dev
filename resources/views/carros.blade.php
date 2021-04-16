@extends('layout.app', ["current" => "carros" ])

@section('body')
    <h4>Listagem de Carros</h4>

    
<div class="card border">
    <div class="card-body">
        <h5 class="card-title">Cadastro de Veículos</h5>


        <table class="table table-ordered table-hover" id="tabelaCarros">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Ano</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
          
            </tbody>
        </table>
    
    </div>
    <div class="card-footer">
        @if(count($marcas)>0)
            <button class="btn btn-sm btn-primary" role="button" onClick="novoCarro()">
                Novo veículo
            </button>
        @else
            <a href="{{ route('marcas')}}" class="btn btn-sm btn-secondary">
                Adicionar Marcas
            </a>
            <p>
                (É necessário adicionar marcas primeiramente)
            </p>
        @endif
    </div>
</div>

<div class="modal" tabindex="1" id="dlgCarro">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" class="form-horizontal" id="formCarro">
                <div class="modal-header">
                    <h5 class="modal-title">Veículo</h5>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="id" class="form-control">

                    <div class="form-group">
                        <label for="marca" class="control-label">Marca</label>
                        <div class="input-group">
                             <select id="marca" class="form-control" required="required">

                             </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="modelo" class="control-label">Modelo</label>
                        <div class="input-group">
                            <input type="text" id="modelo" class="form-control" placeholder="Modelo do Veículo" required="required">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="ano" class="control-label">Ano</label>                        
                        <div class="input-group">
                             <input type="text"  onkeypress="return isNumber(event)" maxlength="9" id="ano" class="form-control" placeholder="Ano Veículo"  required="required">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="descricao" class="control-label">Especificações</label>                        
                        <div class="input-group">
                             <input rows="4" type="text" id="descricao" class="form-control" placeholder="Descreva aqui os detalhes do Veículo" required="required">
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
    
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function novoCarro() {
        $('#id').val('');
        $('#marca').val('');
        $('#modelo').val('');
        $('#ano').val('');
        $('#descricao').val('');
        $('#dlgCarro').modal('show');
    }


    function listarMarcas(){
        $.getJSON('api/marcas', function(data){
            for(i=0; i<data.length; i++){
                opcao = '<option value ="' + data[i].id + '">' 
                        + data[i].marca + '</option>';
                $('#marca').append(opcao); 
            }
        });
    }

    function marcaShow(marca_id, id){
        $.ajax({
            type: "GET",
            url: "/api/marcas/" + marca_id,
            data: "marca",
            success: function(data){
                var id_marca = "#marca_vel"+id;
                var marca_obj = JSON.parse(data);
                var marca = desmontaMarca(marca_obj);
                console.log(marca);
                $(id_marca).append(marca);
            },
        });
    }

    function desmontaMarca(obj){
        return obj.marca;
    }
   
    function montarLinha(c) {  
        marcaShow(c.marca_id, c.id);
        var linha = "<tr>" + 
            "<td>" + c.id + "</td>" +
            "<td id='marca_vel"+c.id+"'></td>" +
            "<td>" + c.modelo + "</td>" +
            "<td>" + c.ano + "</td>" +
            "<td>" +
              '<button class="btn btn-sm btn-primary" onclick="editar(' + c.id + ')"> Exibir/Editar </button> ' +
              '<button class="btn btn-sm btn-danger" onclick="remover(' + c.id + ')"> Apagar </button> ' +
            "</td>" +
            "</tr>";
        return linha;
    }

    function editar(id) {
        $.getJSON('/api/carros/'+id, function(data) { 

            $('#id').val(data.id);
            $('#marca').val(data.marca_id);
            $('#modelo').val(data.modelo);
            $('#ano').val(data.ano);
            $('#descricao').val(data.descricao);
            $('#dlgCarro').modal('show');            
        });        
    }
    
    function remover(id) {
        $.ajax({
            type: "DELETE",
            url: "/api/carros/" + id,
            context: this,
            success: function() {
                console.log('Apagou OK');
                linhas = $("#tabelaCarros>tbody>tr");
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
    
    function carregarCarros() {
        $.getJSON('/api/carros', function(carros) { 
            for(i=0;i<carros.length;i++) {
                linha = montarLinha(carros[i]);
                $('#tabelaCarros>tbody').append(linha);
            }
        });        
    }
    
    function criarCarro() {
        carro = { 
            marca_id: $("#marca").val(), 
            modelo: $("#modelo").val(), 
            ano: $("#ano").val(), 
            descricao: $("#descricao").val(), 
        };
        $.post("/api/carros", carro, function(data) {
            carros = JSON.parse(data);
            linha = montarLinha(carros);
            $('#tabelaCarros>tbody').append(linha);            
        });
    }
    
    
    function salvarCarro() {
        carro = { 
            id : $("#id").val(), 
            marca_id: $("#marca").val(), 
            ano: $("#ano").val(), 
            modelo: $("#modelo").val(), 
            descricao: $("#descricao").val(), 
        };
        $.ajax({
            type: "PUT",
            url: "/api/carros/" + carro.id,
            context: this,
            data: carro,
            success: function(data) {
                carro = JSON.parse(data);
                linhas = $("#tabelaCarros>tbody>tr");
                e = linhas.filter( function(i, e) { 
                    return ( e.cells[0].textContent == carro.id );
                });
                if (e) {
                    e[0].cells[0].textContent = carro.id;
                    e[0].cells[1].textContent = carro.marca_id;
                    e[0].cells[2].textContent = carro.modelo;
                    e[0].cells[3].textContent = carro.ano;
                    e[0].cells[3].textContent = carro.descricao;
                }
            },
            error: function(error) {
                console.log(error);
            }
        });        
    }
    
    
    $("#formCarro").submit( function(event){ 
        event.preventDefault(); 
        if ($("#id").val() != '')
            salvarCarro();
        else
            criarCarro();
            
        $("#dlgCarro").modal('hide');
    });
    
    $(function(){
        listarMarcas();
        carregarCarros();
    });
    </script>
@endsection