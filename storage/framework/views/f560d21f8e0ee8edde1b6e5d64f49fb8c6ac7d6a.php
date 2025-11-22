

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>Notifications</h1>
    <?php if($filteredNotifications): ?>
        <ul>
            <?php $__currentLoopData = $filteredNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <a href="<?php echo e(route('notifications.show', $notification->id)); ?>">
                        <?php if(isset($notification->data['status'])): ?>
                            Votre demande de type <?php echo e($notification->data['type_demande']); ?> a été <?php echo e($notification->data['status']); ?>.
                        <?php else: ?>
                            Nouvelle demande de type <?php echo e($notification->data['type_demande']); ?> par l'utilisateur <?php echo e($notification->data['user_name']); ?>

                        <?php endif; ?>
                    </a>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php else: ?>
        <p>Aucune demande en attente.</p>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Application_RH_v17_08_vf\Application_RH_v26_07\resources\views/RH/notifications/listnotifications.blade.php ENDPATH**/ ?>