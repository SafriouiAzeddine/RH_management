@extends('layouts.layout')

@section('content')
<div class="container">
    <h1>Ajouter Demande</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('demandes.store') }}" method="POST" id="demandeForm">
        @csrf
        <div class="mb-3">
            <label for="id_typeDemande" class="form-label">Type de Demande</label>
            <select class="form-control" id="id_typeDemande" name="id_typeDemande" required>
                <option value="">Sélectionner un type de demande</option>
                @foreach($typedemandes as $type)
                    <option value="{{ $type->id }}">{{ $type->type_demande }}</option>
                @endforeach
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
@endsection
