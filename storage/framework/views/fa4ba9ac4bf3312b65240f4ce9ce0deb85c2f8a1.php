

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header card-header-primary">
            <div class="row">
                <div class="col col-9">
                    <h4 class="card-title">Liste des Demandes</h4>
                    <p class="card-category">Voici la liste des Demandes enregistrés.</p>
                </div>
                <div class="col col-3">
                    <div id="daterange" class="float-end" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%; text-align:center">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span>
                        <i class="fa fa-caret-down"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered data-table" id="daterange_table">
                    <thead class="text-primary">
                        <tr>
                            <th>Date de création</th>
                            <th>Type de demande</th>
                            <th>Status de demande</th>
                            <th>Nombre de jours du congé</th>
                            <th>Date de début</th>
                            <th>Date de fin</th>
                            <th>Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript">
    $(function () {
        // Définir la plage de dates par défaut pour le daterangepicker
        var start_date = moment().startOf('year');
        var end_date = moment().add(1, 'year').startOf('year');

        $('#daterange span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

        $('#daterange').daterangepicker({
            startDate: start_date,
            endDate: end_date,
            locale: {
                format: 'MMMM D, YYYY' // Format de la date affichée
            }
        });

        var table = $('#daterange_table').DataTable({
            processing: true,
            serverSide: true,
            lengthMenu: [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
            ajax: {
                url: "<?php echo e(route('demandes.index')); ?>",
                data: function (data) {
                    var range = $('#daterange').data('daterangepicker');
                    data.from_date = range.startDate ? range.startDate.format('YYYY-MM-DD') : '';
                    data.to_date = range.endDate ? range.endDate.format('YYYY-MM-DD') : '';
                }
            },
            columns: [
                { data: 'created_at', name: 'created_at' },
                { data: 'type_demande', name: 'type_demande' },
                { data: 'status_demande', name: 'status_demande' },
                { data: 'nbr_jours', name: 'nbr_jours' },
                { data: 'date_debut', name: 'date_debut' },
                { data: 'date_fin', name: 'date_fin' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Recharger les données lorsque les dates sont modifiées
        $('#daterange').on('apply.daterangepicker', function (ev, picker) {
            table.draw();
        });
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Application_RH_v17_08_vf\Application_RH_v26_07\resources\views/Fonctionnaire/demandes/listdemandes.blade.php ENDPATH**/ ?>