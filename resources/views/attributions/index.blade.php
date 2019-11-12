@extends('layout')

@section('title', 'Liste des attributions')

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

<h1>Liste des attributions</h1>
@if(count($attributions) == 0)
<h2>La liste est vide</h2>
<p>Pas d'attributions 😀</p>
@else
<table id="table-professors-list" class="table">
    <thead>
        <tr>
            <th>Professeur Acronyme</th>
            <th>Cours</th>
            <th>Groupe</th>
            <th>Quadrimestre</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($attributions as $attribution)
        <tr>
            <td scope="row">{{$attribution["professor_acronyme"]}} </td>
            <td>{{$attribution["course_id"]}} </td>
            <td>{{$attribution["group_id"]}} </td>
            <td>{{$attribution["quadrimester"]}} </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

<!-- Form -->
<form method='post' action='{{ route('upload_professor') }}' enctype='multipart/form-data'>
    @csrf
    <div class="input-group">
        <div class="input-group-prepend">
            <input class="btn btn-info" type='submit' name='submit' value='Import' id='import-csv-button'> </div>
        <div class="custom-file">
            <input type="file" name="file" class="custom-file-input" id="import-csv">
            <label class="custom-file-label" for="import-csv">Choose csv file</label>
        </div>
    </div>
</form>


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
