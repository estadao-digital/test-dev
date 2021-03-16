<!DOCTYPE html>
<html lang="en">

<head>
  <?php
include 'includes/header.php';
?>
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">

</head>

<body data-layout="horizontal">
  <!-- Top Bar Start -->
  <div class="topbar">
    <?php
      include 'includes/headernav.php';
    ?>
    <!--topbar-inner-->
    <?php include 'includes/menu.php';?>
  </div><!-- Top Bar End -->
  <div class="page-wrapper">
    <!-- Page Content-->
    <div class="page-content">
      <div class="container-fluid">
        <!-- Page-Title -->
        <!-- Formulario Carro -->
        <div class="row" id="form-carro">
          <div class="col-sm-12">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="mt-0 header-title">Cadastro de Carros</h4>
                  <p class="text-muted mb-3"></p>
                  <form id="form-cadastro-carro" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id_carro"/>
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group row">

                          <label for="example-text-input" class="col-form-label text-left">Marca</label>
                          <div class="col-sm-3">
                            <select class="form-control" name="marca" id="marca">
                              <option>Escolha a Marca</option>
                            </select>
                        </div>
                        <label for="example-text-input" class="col-form-label text-left">Modelo</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control" name="modelo" id="modelo">
                      </div>
                      <label for="example-text-input" class="col-form-label text-left">Ano</label>
                      <div class="col-sm-3">
                          <input type="number" class="form-control " name="ano" id="ano">

                      </div>
                    </div>
                    <div class="form-group row">
                            <div class="col-sm-12 text-right">
                              <a style="color: #1761fd" id="btn-voltar" class="btn btn-outline-primary">Voltar</a>
                              <button type="submit" id="btn-submit" class="btn btn-outline-success">Cadastrar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- END Formulario Carro -->
        <!-- LISTA Carros -->
        <div class="row" id="lista-carro">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="btn-toolbar float-right">
                  <div class="btn-group focus-btn-group">
                    <button type="button" class="btn btn-outline-primary waves-effect waves-light" id="novo-carro" style="margin-bottom: 32px;">
                      <span class="fas fa-car"></span> Novo Carro
                    </button>
                  </div>
                </div>
                <h4 class="mt-0 header-title">Carros</h4>
                <div class="table-responsive">
                <table id="datatable" class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                  <thead>
                    <tr>
                      <th >ID</th>
                      <th >Marca</th>
                      <th >Modelo</th>
                      <th >Ano</th>
                      <th >Ação</th>
                    </tr>
                  </thead>
                  <tbody id="dados-carros">
                  </tbody>
                </table>
              </div>
              </div>
            </div>
          </div>
        </div>
        <!-- End lista Carro -->
      </div>
      <?php include 'includes/footer.php'?>
      <script src="js/carro.js"></script>
</body>

</html>
