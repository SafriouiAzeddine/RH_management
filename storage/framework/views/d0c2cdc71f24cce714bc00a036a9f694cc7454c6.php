<!-- resources/views/admin/notifications/show.blade.php -->



<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>Details of Request</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date of Creation</th>
                <th>Type of Request</th>
                <th>Status of Demande</th>
                <?php if(Auth::user()->role == '1'): ?>
                <th>Action</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo e($demande->created_at->format('d/m/Y H:i')); ?></td>
                <td><?php echo e($demande->typeDemande->type_demande); ?></td>
 
                <td>
                    <span class="badge
                        <?php if($demande->id_status == 2): ?> bg-success
                        <?php elseif($demande->id_status == 3): ?> bg-danger
                        <?php else: ?> bg-secondary
                        <?php endif; ?>">
                        <?php echo e($demande->statusDemande->status_demande); ?>

                    </span>
                </td>
                <?php if(Auth::user()->role == '1'): ?>
                <td>
                    <!-- Add your action here, e.g., verify the profile -->
                    <a href="<?php echo e(route('profileadmin.show',$demande->id)); ?>" class="btn btn-primary">Verify Profile</a>
                </td>
                <?php endif; ?>
            </tr>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Application_RH_v17_08_vf\Application_RH_v26_07\resources\views/RH/notifications/show.blade.php ENDPATH**/ ?>