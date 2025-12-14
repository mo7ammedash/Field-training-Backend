<!DOCTYPE html>
<html>
<head>
    <title>Features</title>
</head>
<body>
    <h2>Laravel Features</h2>

    <ul>
        <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($feature); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</body>
</html>
<?php /**PATH D:\Course Laravel\w02\resources\views/features.blade.php ENDPATH**/ ?>