@extends('layout')

@section('title', 'Ajout d\'un professeur')

@section('content')

@if(Session::has('warning'))
<p class="alert alert-danger csv-messages">{{ Session::get('warning') }}</p>
@endif
@if(Session::has('success'))
<p class="alert alert-success csv-messages">{{ Session::get('success') }}</p>
@endif
@if(Session::has('error'))
<div class="alert alert-danger csv-messages">{{ session('error') }}</div>
@endif

<h1>Ajout d'un professeur</h1>

<form method='POST' action='{{ route('professeurs.store') }}' enctype='multipart/form-data'>
    @csrf
    <div class="form-group">
        <label for="professor-select">Entrez l'acronyme</label>
        <input type="text" class="form-control" name="acronyme"/>
    </div>

    <div class="form-group">
        <label for="name-select">Entrez le nom</label>
        <input type="text" class="form-control" name="nom"/>
    </div>

    <div class="form-group">
        <label for="lastname-select">Entrez le prénom</label>
                <input type="text" class="form-control" name="prenom"/>
    </div>

    <button id="submit-add-professor" type="submit" class="btn btn-info">Valider</button>
</form>


<div class="buttonBloc">
    <button type="button" id="accueilBtn" name="accueilBtn" onclick="window.location='{{ route('index') }}' "> > vers
        accueil </button>
    <button type="button" onclick="window.location='{{ route('professeurs.index') }}' "> > Retour</button>
</div>

<script>
    $("#import-csv").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

</script>
@endsection