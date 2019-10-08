<?php if(Auth::user()): ?>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Informe abaixo as informações do Carro
                        <a class="float-right btn btn-secondary" href="<?php echo e(url ('cruds')); ?>">Listagem de Carros </a>
                    </div>
                    <div class="card-body">

                        <?php if(session('mensagem_sucesso')): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo e(\Illuminate\Support\Facades\Session::get('mensagem_sucesso')); ?>

                            </div>
                            <?php endif; ?>

                            <?php if(Request::is('*/editar')): ?>
                                <form method="post" action="<?php echo e(action('CrudController@atualizar', $cruds->id)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <form class="form-group">
                                        <a class="float-left">Marca: </a>&nbsp
                                        <select class="form-control" name="marca" autofocus>
                                                    
                                                        <option value="" <?php if($cruds->marca == ""): ?> selected <?php endif; ?>>Selecionar Marca</option>
                                                        <option value="volvo" <?php if($cruds->marca == "Volvo"): ?> selected  <?php endif; ?> >Volvo</option>
                                                        <option value="saab" <?php if($cruds->marca == "Saab"): ?> selected  <?php endif; ?>>Saab</option>
                                                        <option value="mercedes" <?php if($cruds->marca == "Mercedes"): ?> selected  <?php endif; ?>>Mercedes</option>
                                                        <option value="audi" <?php if($cruds->marca == "Audi"): ?> selected  <?php endif; ?>>Audi</option>
                                                    
                                                </select>
                                        <a class="float-left">Modelo: </a>&nbsp
                                        <input class="form-control" placeholder="Preencha este campo" name="modelo" autofocus type="text" value="<?php echo e($cruds->modelo); ?>">
                                        <a class="float-left">Ano: </a>&nbsp
                                        <input class="form-control" placeholder="Preencha este campo" name="ano" autofocus type="text" value="<?php echo e($cruds->ano); ?>">
                                        <p></p>
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                    </form>
                                    <?php else: ?>
                                         <form method="post" action="<?php echo e(route('salvar')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <form class="form-group">
                                                <a class="float-left">Marca: </a>&nbsp
                                                <select class="form-control" name="marca" autofocus>
                                                    <option value="">Selecionar Marca</option>
                                                    <option value="Volvo">Volvo</option>
                                                    <option value="Saab">Saab</option>
                                                    <option value="Mercedes">Mercedes</option>
                                                    <option value="Audi">Audi</option>
                                                </select>
                                                <a class="float-left">Modelo: </a>&nbsp
                                                <input class="form-control" placeholder="Preencha este campo" name="modelo" autofocus type="text" value="">
                                                <a class="float-left">Ano: </a>&nbsp
                                                <input class="form-control" placeholder="Preencha este campo" name="ano" autofocus type="text" value="">
                                                <p></p>
                                                <button type="submit" class="btn btn-primary">Salvar</button>
                                            </form>


                            <?php endif; ?>







</div>
</div>
</div>
</div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php endif; ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>