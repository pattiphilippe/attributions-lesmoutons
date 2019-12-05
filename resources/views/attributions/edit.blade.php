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

<h1>Edition de l'Attribution</h1>

<form method='POST' action='{{ route('attributions.update',$attribution->id) }}' enctype='multipart/form-data'>
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="professor-select">Choisissez le professeur</label>
        <select class="form-control" name="professor" id="professor-select">
            @foreach ($professors as $professor)
            @if($professor->acronyme == $attribution->professor_acronyme)
            <option value="{{ $professor->acronyme }}" selected>{{ $professor->acronyme }}</option>
            @else
            <option value="{{ $professor->acronyme }}">{{ $professor->acronyme }}</option>
            @endif
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="group-select">Choisissez le groupe</label>
        <select class="form-control" name="group" id="group-select">
            @foreach ($groupes as $group)
            @if($group->nom == $attribution->group_id)
            <option value="{{ $group->nom }}" selected>{{ $group->nom }}</option>
            @else
            <option value="{{ $group->nom }}">{{ $group->nom }}</option>
            @endif
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="course-select">Choisissez le cours</label>
        <select class="form-control" name="course" id="course-select">
            @foreach ($courses as $course)
            @if($course->id == $attribution->course_id)
            <option value="{{ $course->id }}" selected>{{ $course->title }}</option>
            @else
            <option value="{{ $course->id }}">{{ $course->title }}</option>
            @endif
            @endforeach
        </select>
    </div>

    <button id="submit-update-attribution" type="submit" class="btn btn-info">Valider</button>
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