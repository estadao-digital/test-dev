<?php
include '../app/Models/Carro.php';
?>

<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=10">

  <!--Css-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/main.css">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <!--Fonts-->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Oswald" rel="stylesheet">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <!--Others-->
  <!-- <link rel="stylesheet" href="/assets/css/jquery.sweet-dropdown.min.css"> -->


  <title>Estadão</title>
</head>
<body>

<header>
  <div class="container">
    <div class="row justify-content-center">

      <div class="col-3 pt-2">
        <div class="box-logo text-center py-3">
          <img src="/img/logo-blue.svg"/>
        </div>
      </div>

    </div>
  </div>
</header>

<!--Largura total do viewport-->
<div class="container-fluid">

  <div class="row justify-content-center">
    <div class="col-8 pb-2 cad-box">

      <div class="container">

        <div class="row justify-content-center">
          <div class="col-12" align="right">
                <a class="btn btn-primary" href="#" id="limpar"><span class="font-white"> Limpar / Cadastrar </span></a>
          </div>
        </div>

        <div class="row justify-content-center">

          <!--Edição de dados perfil Usuario-->
          <div class="col-12 mt-4">
            <form class="edit-profile-form" id="formCarro">
              <div class="form-row">

                <!--Primeiro bloco do mobile e primeira a esquerda desktop-->
                <div class="col-12">
                  <div class="row">

                    <!--Exibir apenas ao sucesso do envio do formulario-->
                    <?php
                    if (isset($created) && $created == true) {

                      print '
                      <div class="col-12 alert alert-success text-center">
                        Sucesso! Produto criado com sucesso.
                      </div>';
                    } elseif(isset($error) && $error == true) {
                      print '
                      <div class="col-12 alert alert-danger text-center">
                        Erro! Ocorreu um erro ao gravar o produto.
                      </div>';
                    }
                    ?>

                    <div class="form-group col-12">
                      <label for="marca">Marca</label>
                      <select class="form-control" name="marca" id="marca">
                        <option value="0" selected>-- Selecione uma Marca --</option>
                        <option value="GM">GM</option>
                        <option value="Fiat">Fiat</option>
                        <option value="Volkswagem">Volkswagem</option>
                      </select>
                    </div>

                    <div class="form-group col-12">
                        <label for="modelo">Modelo</label>
                        <input class="form-control" type="text" name="modelo" id="modelo" value=""/>
                    </div>

                    <div class="form-group col-12">
                      <label for="ano">Ano</label>
                      <input class="form-control" type="text" name="ano" id="ano" value=""/>
                    </div>

                      <div class="col-12 mt-4">
                        <div class="row justify-content-center">
                          <div class="form-group col-6 d-none d-lg-block">
                              <a id="salvar" data-product-id-change="0" class="btn btn-danger w-100"> Salvar cadastro</span> </a>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>


              </div>
            </form>
          </div>
        </div>



        <div class="row justify-content-center">
            <div class="col-12 mt-4">
              <table class="table">
                  <thead>
                  <tr>
                      <th scope="col">Marca</th>
                      <th scope="col">Modelo</th>
                      <th scope="col">Ano</th>
                      <th class="text-center" scope="col">Alterar</th>
                      <th class="text-center" scope="col">Excluir</th>
                  </tr>
                  </thead>
                  <tbody class="content-list">
                      <?php
                      $carro = new Carro();
                      $products = $carro->fetch();
                      if (!count($products)) {
                          print '
                          <tr>
                            <th colspan="5" class="text-center py-4"> --- Sem resultado --- </th>
                          </tr>';
                      }

                      foreach ($products as $product) {
                          print '
                            <tr>
                              <th scope="row">' . $product->marca .'</th>
                              <td>' . $product->modelo .'</td>
                              <td>' . $product->ano .'</td>
                              <td class="text-center"><a href="/carros/'. $product->id .'/?XDEBUG_SESSION_START" class="alterar"> <i class="fas fa-edit"></i> </a></td>
                              <td class="text-center"><a href="/carros/' . $product->id . '" class="deletar"> <i class="fa fa-trash fa-2" aria-hidden="true"></i> </a></td>
                            </tr>';
                      }
                      ?>
                  </tbody>
              </table>
          </div>
        </div>


      </div>

    </div>

  </div>

</div>

<script src="js/main.js"></script>
</body>
</html>