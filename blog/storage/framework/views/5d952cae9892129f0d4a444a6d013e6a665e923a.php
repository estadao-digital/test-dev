<?php $__env->startSection('content'); ?>

    <div class="well">

        <?php echo Form::open(['url' => '/tester/salvar/', 'class' => 'form-horizontal']); ?>


        <fieldset>

            <legend>Legend</legend>
            <!-- Email -->
            <div class="form-group">
                <?php echo Form::label('name', 'Email:', ['class' => 'col-lg-2 control-label']); ?>

                <div class="col-lg-10">
                    <?php echo Form::email('name', $value = null, ['class' => 'form-control', 'placeholder' => 'email']); ?>

                </div>
            </div>

            <!-- Password -->
            
                
                
                    
                    
                        
                        
                    
                
            

            
            
                
                
                    
                    
                
            

            
            
                
                
                    
                        
                        

                    
                    
                        
                        
                    
                
            

            
            
                
                
                    
                
            

            
                
                    
                
            
            
                
                
                    
                        
                        
                        
                        
                        
                        
                        
                        
                    
                
            


            <!-- Submit Button -->
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <?php echo Form::submit('Submit', ['class' => 'btn btn-lg btn-info pull-right'] ); ?>

                </div>
            </div>



        </fieldset>

        <?php echo Form::close(); ?>


    </div>

    <div class="form-group">
        <div class="col-lg-10">
            <?php if($errors->any()): ?>
                <ul class="alert alert-danger">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e(@$error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('product.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>