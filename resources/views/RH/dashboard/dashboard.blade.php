@extends('Layouts.layout')

@section('content')
<div class="row">
    <!-- Carte des utilisateurs totaux -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">person</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Total Users</p>
                    <h4 class="mb-0">{{ $totalUsers }}</h4>
                </div>
            </div>
        </div>
    </div>
    <!-- Carte des demandes totales -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">assignment</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Total Demandes</p>
                    <h4 class="mb-0">{{ $totalDemandes }}</h4>
                </div>
            </div>
        </div>
    </div>
    <!-- Carte des demandes non traitées -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">hourglass_empty</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Demandes Non Traitées</p>
                    <h4 class="mb-0">{{ $demandesNonTraitees }}</h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                @if($totalDemandes > 0)
                <p class="mb-0">
                    <span class="text-danger text-sm font-weight-bolder">
                        {{ round($demandesNonTraitees / $totalDemandes * 100, 2) }}%
                    </span> of total
                </p>
                @else
                    <p class="mb-0"><span class="text-success text-sm font-weight-bolder">0%</span> of total</p>
                @endif
            </div>
        </div>
    </div>
    <!-- Carte des demandes traitées -->
    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">check_circle</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Demandes Traitées</p>
                    <h4 class="mb-0">{{ $demandesTraitees }}</h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                @if($totalDemandes > 0)
                <p class="mb-0">
                    <span class="text-success text-sm font-weight-bolder">
                        {{ round($demandesTraitees / $totalDemandes * 100, 2) }}%
                    </span> of total
                </p>
                @else
                <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">0%</span> of total</p>
                @endif
            </div>
        </div>
    </div>
</div>



<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Charts</h5>
                <div class="d-flex">
                    <div id="piechart_3d" style="width: 50%; height: 500px;"></div>
                    <div id="piechart_3d_typedemande" style="width: 50%; height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>





<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
        var chartData = google.visualization.arrayToDataTable([
            ['Type', 'Number'],
            ['Demandes Non Traitées', {{ $demandesNonTraitees ?? 0 }}],
            ['Demandes Traitées', {{ $demandesTraitees ?? 0 }}]
        ]);

        var chartOptions = {
            title: 'Statut des Demandes',
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(chartData, chartOptions);

        var typeData = google.visualization.arrayToDataTable([
            ['Type', 'Number'],
            ['Attestation de travail', {{ $Atesstationtravail ?? 0 }}],
            ['Congé Exeptionnel', {{ $documentx ??0}}],
            ['Congé Annuel', {{ $congé  ??0  }}],
            ["Permission D'absence", {{ $permissionabs ??0 }}]

        ]);

        var typeOptions = {
            title: 'Types de Demandes',
            is3D: true,
        };

        var typeChart = new google.visualization.PieChart(document.getElementById('piechart_3d_typedemande'));
        typeChart.draw(typeData, typeOptions);
    }
</script>
@endsection