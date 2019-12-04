@extends('layout')

@section('title', 'Liste de professeurs')

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

<h1>Liste de professeurs</h1>
@if (count($professeurs) == 0)
<h2>La liste est vide</h2>
<p>Pas de professeur disponible. </p>
@else
<table id="table-professors-list" class="table">
    <thead>
        <tr>
            <th>Acronyme</th>
            <th>Nom</th>
            <th>Prenom</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($professeurs as $professeur)
        <tr>
            <td scope="row">{{$professeur["acronyme"]}} </td>
            <td>{{$professeur["nom"]}} </td>
            <td>{{$professeur["prenom"]}} </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
<!-- Form -->
<form method='post' action='{{ route('upload_professor') }}' enctype='multipart/form-data'>
    @csrf
    <div class="import-csv-container">
        <div class="form-check checkbox-csv">
            <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="check_delete_table" id="check_delete_table" checked>
                Supprimer la table avant l'import
            </label>
        </div>
        <div class="input-group">
            <div class="input-group-prepend">
                <input class="btn btn-info" type='submit' name='submit' value='Import' id='import-csv-button'> </div>
            <div class="custom-file">
                <input type="file" name="file" class="custom-file-input" id="import-csv">
                <label class="custom-file-label" for="import-csv">Choose csv file</label>
            </div>
        </div>
    </div>
</form>
<a id="create-professor-button" class="btn btn-info" href="{{ route('professeurs.create') }}" role="button">Ajouter
    professeur</a>

<div class="buttonBloc">
    <button type="button" id="accueilBtn" name="accueilBtn" onclick="window.location='{{ route('index') }}' "> > vers
        accueil </button>
    {{-- <button type="button" onclick="window.location='{{ route('courses.create') }}' "> > créer</button> --}}
</div>

<script>
    $("#import-csv").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
@endsection
