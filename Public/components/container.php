<div class="container">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row justify-content-between">
                    <div class="col-12 col-sm-7 text-center text-sm-start">
                        <h2 class=''>Gerenciamento de <b>Veículos</b></h2>
                    </div>
                    <div class="col-12 col-sm-3 col-lg-3 text-center text-sm-end mt-2 mt-sm-0">
                        <a href="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal"><i
                                class="material-icons">&#xE147;</i> <span>Novo Veículo</span></a>

                    </div>
                </div>
            </div>
            <?php require './Public/components/table.php' ?>
        </div>
    </div>
    <?php require './Public/components/toasts.php' ?>
</div>