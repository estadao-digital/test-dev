<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Teste para desenvolvedor do Estadão">
    <meta name="author" content="Péricles ZM">
    <link rel="shortcut icon" href="http://statics.estadao.com.br/s2016/favicon.ico" >

    <title>Cadastro de veículos</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    


    <style>
        .logo-blue {
            background: url('http://statics.estadao.com.br/s2016/portal/img/svg/logo-blue.svg') 0 0 no-repeat;
            background-size: auto auto;
            height:30px;
            margin-top:15px
        }
        .footer{
            background-color: #cccc;
            margin-top:20px
        }
    </style>
  </head>

  <body>

    <div class="container">
      <header class="header clearfix">
        
        <h3 class="text-muted">        
            <div class="logo-blue"></div>
        </h3>
      </header>

      <main role="main">

        <div class="jumbotron">
          <h3>Cadastro de veículos</h3>
          <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo .</p>          
        </div>

        <div class="card" >
            <div class="card-header" >
                Veículos cadastrados 
                <button type="button" style="float:right" class="btn btn-sm btn-primary" onclick="novoCarro()"> + Adicionar</button>
            </div>  
            <ul id="listaCarros" class="list-group list-group-flush">                
            </ul>
        </div>

      </main>

      <footer class="footer">
        <p>Estadão</p>
      </footer>
    </div> <!-- /container -->


<div class="modal fade" id="telaModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cadastro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formCarro">
          <div class="form-group">
            <label for="inputMarca">Marca</label>
                <select class="form-control" id="inputMarca" name="inputMarca">
                <option value="">Escolha uma marca</option>
                <option value="1">Chevrolet</option>
                <option value="2">Fiat</option>
                <option value="3">Honda</option>
                <option value="4">Hyundai</option>
                <option value="5">Volkswagen</option>      
            </select>
          </div>
        <div class="form-group">
            <label for="inputModelo" class="col-form-label">Modelo:</label>
            <input type="text" class="form-control" id="inputModelo" name="inputModelo" required>
          </div>
          <div class="form-group">
            <label for="inputAno" class="col-form-label">Ano:</label>
            <input type="text" class="form-control" id="inputAno" name="inputAno" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
          <input type="hidden" class="form-control" id="inputId" name="inputId" >
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-sm btn-primary" onclick="gravar()">Gravar</button>
      </div>
    </div>
  </div>
</div>

      

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

<script> 
   function carregarCarro(id){        
        $.ajax({
            type: 'GET',
            url: '/api/carros/'+id ,
            dataType: "json", // data type of response        
        }).done( function(data){
            console.log(data);
            $("#inputMarca").val(data.marca);
            $('#inputModelo').val(data.modelo);
            $('#inputAno').val(data.ano);
            $('#inputId').val(id);
            $('#telaModal').modal('show'); 
        });        
    }

   function excluirCarro(id){    
       if (confirm('Deseja excluir esse item?')){    
        $.ajax({
            type: 'DELETE',
            url: '/api/carros/'+id ,
            dataType: "json", // data type of response        
        }).done( function(data){
            console.log(data);
            findAll();
            alert(data.msg);            
        });        
       }else{
           return null;
       }
    }

   function novoCarro(id){       
            $("#inputMarca").val("");
            $('#inputModelo').val('');
            $('#inputAno').val('');
            $('#inputId').val('');
            $('#telaModal').modal('show'); 
    }

    function gravar(){
        var id = $('#inputId').val();        
        if(id){
            var acao = 'PUT';
            var url  = '/api/carros/'+id ;
        }else{
            var acao = 'POST';
            var url  = '/api/carros/' ;
        }
        
        var form = $('#formCarro'); 
        $.ajax({
            type: acao,
            url: url ,
            data: form.serialize(),
            dataType: "json", // data type of response        
        }).done( function(data){
            console.log(data);
            alert(data.msg);
        });
        findAll();
        $('#telaModal').modal('hide'); 
    }

    function findAll() {    
        $.ajax({
            type: 'GET',
            url: '/api/carros/' ,
            dataType: "json", // data type of response        
        }).done( function(data){
            console.log(data);
            $('#listaCarros li').remove();
            if(data.msg){
                $('#listaCarros').append('<li class="list-group-item">'+data.msg+'</li>');
            }else{
                $.each(data, function(i, item) {
                    var r = '<li class="list-group-item">Modelo: '+ item.modelo;
                        r += '<span class="badge badge-secondary badge-light"> Ano '+item.ano+' </span>';
                        r += '<div class="btn-group btn-group-sm" role="group" aria-label="..." style="float:right">';
                        r += '<button type="button" class="btn btn-sm btn-primary botaoEditar" onclick="carregarCarro('+i+')">Editar</button>';
                        r += '<button type="button" class="btn btn-sm btn-danger botaoExcluir" onclick="excluirCarro('+i+')">Excluir</button>';
                        r += '</div>';
                        r += '</li>';
                    $('#listaCarros').append(r);
                });
            }
        });
    }

 $(document).ready(function() {
            findAll();            
});


</script>

  </body>
</html>