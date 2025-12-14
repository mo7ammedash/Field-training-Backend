<!DOCTYPE html>
<html>
<head>
    <title>Team</title>
</head>
<body>
    <h2>Our Team</h2>

    <table border="1" cellpadding="10">
        <tr>
            <th>Name</th>
            <th>Role</th>
        </tr>

        <?php $__currentLoopData = $team; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($member['name']); ?></td>
                <td><?php echo e($member['role']); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
</body>
</html>
<?php /**PATH D:\Course Laravel\w02\resources\views/team.blade.php ENDPATH**/ ?>