---
<?php echo $frontmatter; ?>

---
<!-- START_INFO -->
<?php echo $infoText; ?>

<!-- END_INFO -->

<?php $__currentLoopData = $parsedRoutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $routes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if($group): ?>
#<?php echo e($group); ?>

<?php endif; ?>
<?php $__currentLoopData = $routes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parsedRoute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if($writeCompareFile === true): ?>
<?php echo $parsedRoute['output']; ?>

<?php else: ?>
<?php echo isset($parsedRoute['modified_output']) ? $parsedRoute['modified_output'] : $parsedRoute['output']; ?>

<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
