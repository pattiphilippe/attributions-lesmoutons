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

<h1>Attribution de cours à un prof</h1>

<form method='POST' action='{{ route('attributions.store') }}' enctype='multipart/form-data'>
    @csrf
    <div class="form-group">
        <label for="professor-select">Choisissez le professeur</label>
        <select class="form-control" name="professor" id="professor-select">
            @foreach ($professors as $professor)
                <option value="{{ $professor->acronyme }}">{{ $professor->acronyme }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="group-select">Choisissez le group</label>
        <select class="form-control" name="group" id="group-select">
            @foreach ($groupes as $group)
                <option value="{{ $group->nom }}">{{ $group->nom }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="course-select">Choisissez le cours</label>
        <select class="form-control" name="course" id="course-select">
            @foreach ($courses as $course)
                <option value="{{ $course->title }}">{{ $course->title }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-info">Valider</button>
</form>


<div class="buttonBloc">
    <button type="button" id="accueilBtn" name="accueilBtn" onclick="window.location='{{ route('index') }}' "> > vers
        accueil </button>
    <button type="button" onclick="window.location='{{ route('attributions.index') }}' "> > Retour</button>
</div>

<script>
    $("#import-csv").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

</script>
@endsection
