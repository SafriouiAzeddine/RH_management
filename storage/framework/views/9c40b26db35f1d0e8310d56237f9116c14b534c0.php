

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>Ajouter Demande</h1>
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="<?php echo e(route('demandes.store')); ?>" method="POST" id="demandeForm">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label for="id_typeDemande" class="form-label">Type de Demande</label>
            <select class="form-control" id="id_typeDemande" name="id_typeDemande" required>
                <option value="">Sélectionner un type de demande</option>
                <?php $__currentLoopData = $typedemandes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($type->id); ?>"><?php echo e($type->type_demande); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div id="congeFields" style="display: none;">
            <div class="mb-3">
                <label for="date_debut" class="form-label">Date de Début</label>
                <input type="date" class="form-control" id="date_debut" name="date_debut">
            </div>
            <div class="mb-3">
                <label for="nbr_jours" class="form-label">Nombre de Jours</label>
                <input type="number" class="form-control" id="nbr_jours" name="nbr_jours">
            </div>
        </div>

        <button type="submit" class="btn btn-primary" onclick="return confirm('Êtes-vous sûr de vouloir ajouter cette demande ?')">Demander</button>
    </form>
</div>

<script>
document.getElementById('id_typeDemande').addEventListener('change', function () {
    var congeFields = document.getElementById('congeFields');
    if (this.value == '2' || this.value == '3'|| this.value == '4') {
        congeFields.style.display = 'block';
    } else {
        congeFields.style.display = 'none';
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Application_RH_v17_08_vf\Application_RH_v26_07\resources\views/Fonctionnaire/demandes/create.blade.php ENDPATH**/ ?>