

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header card-header-primary">
            <div class="row">
                <div class="col-md-9">
                    <h4 class="card-title">Liste des Utilisateurs</h4>
                    <p class="card-category">Voici la liste des Utilisateurs enregistrés.</p>
                </div>
                <div class="col-md-3">
                    <div id="daterange" class="float-end" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%; text-align:center">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span>
                        <i class="fa fa-caret-down"></i>
                    </div>
                </div>
            </div>
            <!-- Age filter row -->
            <div class="row mt-2">
                <div class="col-md-4">
                    <div id="agefilter" class="float-end" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%; text-align:center">
                        <i class="fa fa-filter"></i>&nbsp;
                        <span id="agefilter-text">Age Range</span>
                        <i class="fa fa-caret-down"></i>
                    </div>
                    <div id="agefilter-options" class="d-none">
                        <input type="number" id="min_age" class="form-control" placeholder="Min Age">
                        <input type="number" id="max_age" class="form-control" placeholder="Max Age">
                        <button id="filter_age" class="btn btn-primary w-100 mt-2">Filter</button>
                        <button id="cancel_age" class="btn btn-secondary w-100 mt-2">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered data-table" id="users_table">
                    <thead class="text-primary">
                        <tr>
                            <th>Date D'affectation</th>
                            <th>Photo</th> 
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Age</th>
                            <th>Is_Congé</th>
                            <th>Matricule</th>
                            <th>Grade</th>
                            <th>Division</th>
                            <th>Service</th>
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
        $('#filter_age').on('click', function() {
        table.draw();
        });

        $('#cancel_age').on('click', function() {
            // Clear the age input fields
            $('#min_age').val('');
            $('#max_age').val('');

            // Hide the age filter options
            $('#agefilter-options').addClass('d-none');

            // Reset and redraw the table
            table.draw();
        });

        $('#agefilter').on('click', function() {
            $('#agefilter-options').toggleClass('d-none');
        });
        var table = $('#users_table').DataTable({
            processing: true,
            serverSide: true,
            lengthMenu: [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]], // Options for page length
            ajax: {
                url : "<?php echo e(route('users.index')); ?>",
                data : function(data){
                    var range = $('#daterange').data('daterangepicker');
                    data.from_date = range.startDate ? range.startDate.format('YYYY-MM-DD') : '';
                    data.to_date = range.endDate ? range.endDate.format('YYYY-MM-DD') : '';
                    data.min_age = $('#min_age').val();
                    data.max_age = $('#max_age').val();
                }
            },
            columns: [
                { data: 'created_at', name: 'created_at' },
                { data: 'photo', name: 'photo', orderable: false, searchable: false },
                { data: 'nomFr', name: 'nomFr' },
                { data: 'prenomFr', name: 'prenomFr' },
                { data: 'email', name: 'email' },
                { data: 'age', name: 'age' },
                { data: 'is_congé', name: 'is_congé' },
                { data: 'matricule', name: 'matricule' },
                { data: 'grade', name: 'grade' },
                { data: 'division', name: 'division' },
                { data: 'service', name: 'service' },
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

<?php echo $__env->make('Layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Application_RH_v17_08_vf\Application_RH_v26_07\resources\views/RH/users/listusers.blade.php ENDPATH**/ ?>