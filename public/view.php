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

  <link rel="shortcut icon" href="img/favicon.ico">

  <title>Estadão</title>
</head>
<body>

<!-- Modal -->
<div class="modal fade" id="excludeModal" tabindex="-1" role="dialog" aria-labelledby="excludeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="excludeModalLabel">Excluir Carro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Deseja realmente excluir este carro?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button data-href-exclude="#" data-modelo="" data-marca="" type="button" class="btn btn-primary confirmar-exclusao">Confirmar exclusão</button>
            </div>
        </div>
    </div>
</div>


<header>
  <div class="container">
    <div class="row justify-content-center">

      <div class="col-8 box-logo text-center pt-5">
        <img src="/img/logo-blue.svg"  />
      </div>

    </div>
  </div>
</header>

<!--Largura total do viewport-->
<div class="container-fluid">

  <div class="row justify-content-center">
    <div class="col-12 pb-2 cad-box">

      <div class="container">

        <div class="row justify-content-center">

          <!--Edição de dados perfil Usuario-->
          <div class="col-9 mt-4">
            <form class="edit-profile-form" id="formCarro">
              <div class="form-row">

                <div class="col-12">
                  <div class="row row-content"> <!-- content-line é usado no JS pra colocar os alerts -->

                    <!-- O JS injeta os alerts do Bootstrap 4 aqui, via prepend() method. -->

                    <div class="col-12 mt-3" align="right">
                      <div class="row row-alteracao">
                      </div>
                    </div>

                    <div class="form-group col-12">
                      <label for="marca">Marca</label>
                      <select class="form-control" name="marca" id="marca">
                        <option value="0" selected>Escolha uma marca</option>
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

                    <div class="form-group col-12">
                        <div class="row justify-content-center">
                            <div class="col-12 text-center">
                                <button id="salvar" data-product-id-change="0" class="btn btn-danger btn-salvar"> Salvar Cadastro </button>
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
              <!-- id="table-list" foi usado como ponto de partida para a declaração dos eventos de click nos ícones
              edit e delete. Ocorre que o JQuery não funciona após o append() ou html() da nova listagem vinda do
              servidor. Ao carregar a listagem pela primeira vez, o seletor $(".editIcon") funcionava sem problemas. Ao
              carregar novos ícones com o mesmo class, o JQuery para de funcionar. A solução para o problema foi partir
              de um componente pai que não foi recarregado e logo em seguida indicar o class dos ícones. -->


              <table class="table" id="table-list">
                  <thead>
                  <tr>
                      <th scope="col">Marca</th>
                      <th class="col-modelo" scope="col">Modelo</th>
                      <th class="col-ano" scope="col">Ano</th>
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
                              <td>' . $product->marca .'</td>
                              <td class="col-modelo">' . $product->modelo .'</td>
                              <td class="col-ano">' . $product->ano .'</td>
                              <td class="text-center"> <!-- Editar -->
                                <a href="/carros/'. $product->id .'" class="editIcon"><i class="fas fa-edit"></i></a>
                              </td>
                              <td class="text-center"> <!-- Excluir -->
                                <a href="/carros/' . $product->id . '" data-toggle="modal" data-target="#excludeModal" class="deleteIcon"><i class="fa fa-trash fa-2" aria-hidden="true"></i></a>
                              </td>
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

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="js/main.js"></script>
</body>
</html>