<?PHP

require 'api.php';

$recebeDados = new EnviaDados;

$json_php = $recebeDados->listaDados();


?>

<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    </head>
    <body >
        <div class="container">
                <div class="alert alert-primary" role="alert" id="header" >
                        <h1> Teste - Carros</h1>
                </div>

                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                        
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                          <span class="navbar-toggler-icon"></span>
                        </button>
                      
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                          <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                              <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                              <a onclick="return false;" href="cadastro.php" class="buscarPagina nav-link">Inserir</a>
                            </li>
                           
                           
                          </ul>

                          <form class="form-inline my-2 my-lg-0">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                          </form>
                        </div>
                      </nav>
                    
                        <div id="content">
                            <table class="table table-hover">
                                <thead>
                                  <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Marca</th>
                                    <th scope="col">Modelo</th>
                                    <th scope="col">Ano</th>
                                    <th scope="col">Editar</th>
                                    <th scope="col">Deletar</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?PHP
    
                                  foreach($json_php as $dados){ ?>
                                      
                                  <tr>
                                  <td><?=$dados['id'] ?></td>
                                  <td><?=$dados['marca'] ?></td>
                                  <td><?=$dados['modelo'] ?></td>
                                  <td><?=$dados['ano'] ?></td>
                                  <td>
                                  <button  onclick="return false;" href="editar.php?id=<?=$dados['id']?>" class="buscarPagina btn btn-info">Editar</button>
                                  
                                                                  
                                  </td>



                                  <td>
                                  <form id="deletaForm" onSubmit="return false;" method="post" action="carro.class.php">
                                    <input type="hidden" name="id" id="id" value="<?=$dados['id'] ?>">
                                    <input type="hidden" name="status" id="status" value="2">
                                    <button  onClick="deleta();" id="btnEnviar" class="btn btn-danger">Deletar</button>
                                  </form>
                                  
                                                                  
                                  </td>


                                  </tr>
                                  <?PHP      
                                   
                                }?>
                                  
                                </tbody>
                              </table>
                        </div>
                    
                 

 <div id="destino" class="result">

 Aguardando
</div>

        </div>
        <script src="js/vendor/jquery-3.3.1.js"></script>
        <script src="js/post.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>  
        <script>
            $(document).ready(function(){
                $(".buscarPagina").click(function(){
                    //Aqui estau retirando o conteudo da propriedade href “o link destino” e colocando em uma variavel
                    var link = $(this).attr('href');
                    $.ajax
                    ({
                        dataType: 'html',
                        url: link, //link da pagina que o ajax buscará
                        success: function(data)
                        {
                            $("#content").html(data).fadeIn(340); //Inserindo o retorno da pagina ajax
                        },
                        error: function(data){
                            $("#content").html("<center><p>ERRO ao carregar outra pagina</p></center>").fadeIn(300); //Em caso de erro ele exibe esta mensagem
                        }
                    }); 
                 
                });
            });
  function deleta(){
            var confirma = confirm('Deseja Deletar este Registro?');
if (confirma) {
  
              $.ajax({
                method: "post",
                url: "carro.class.php",
                data: $("#deletaForm").serialize(),
              });
              window.location.reload();
          
} else {
location.href='index.php';
}
}
            
        </script>
    </body>

</html>
