<?php if(Auth::user()): ?>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Carros
                        <a class="float-right btn btn-success" href="<?php echo e(url ('cruds/novo')); ?>">Novo Carro </a>
                        
                    </div>
                    <div class="card-body">
                        <?php if(session('mensagem_sucesso')): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo e(\Illuminate\Support\Facades\Session::get('mensagem_sucesso')); ?>

                            </div>
                        <?php endif; ?>

                        <table class="table">
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Ano</th>
                            <th>Ações</th>
                            <tdbody>
                                <?php $__currentLoopData = $cruds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cruds): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($cruds->marca); ?></td>
                                    <td><?php echo e($cruds->modelo); ?></td>
                                    <td><?php echo e($cruds->ano); ?></td>
                                    <td>
                                        <a href="cruds/<?php echo e($cruds->id); ?>/editar" class="btn btn-primary btn-sm">Editar</a>

                                        <form method="post" style="display: inline" action="<?php echo e(action('CrudController@deletar', $cruds->id)); ?>">
                                            <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tdbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php endif; ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>