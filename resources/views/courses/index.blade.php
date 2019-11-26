@extends('layout')

@section('title', 'Liste des Cours')

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

<h1>Liste des Cours</h1>
<form id="formFilter" class="col-md-3 input-group" action="/courses" method="GET">
    <div class="form-group">
        <label for="filter">Filtre</label>
        <select class="selectpicker" name="filter" id="filter" onchange="showCourses()">
            <option value="courses"
                <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'courses') ? 'selected="selected"' : ''; ?>>
                Tout</option>
            <option value="coursesAttributed"
                <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'coursesAttributed') ? 'selected="selected"' : ''; ?>>
                Attribué(s)</option>
            <option value="coursesNonAttributed"
                <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'coursesNonAttributed') ? 'selected="selected"' : ''; ?>>
                Non-attribué(s)</option>
        </select>
    </div>
</form>
@if(count($courses) == 0)
<h2>La liste est un peu vide!</h2>
<p>Pas de cours disponible 😀</p>
@else
<table id="table-professeurs-list" class="table">
    <thead>
        <tr>
            <th>Acronyme</th>
            <th>Titre</th>
            <th>Ects</th>
            <th>Nombre d'heures pour le 1er bimestre</th>
            <th>Nombre d'heures pour le 2e bimestre</th>
        </tr>
    </thead>
    <tbody>
            @foreach ($courses as $course)
            <tr>
                <td scope="row">{{$course->id}} </td>
                <td>{{$course->title}} </td>
                <td>{{$course->credits}} </td>
                <td>{{$course->bm1_hours}} </td>
                <td>{{$course->bm2_hours}} </td>
            </tr>
            @endforeach
    </tbody>
</table>
@endif
<!-- Form -->
<form method='post' action='{{ route('upload_course') }}' enctype='multipart/form-data'>
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
    <button type="button" onclick="window.location='{{ route('index') }}' "> > vers accueil </button>
</div>
<script>
    function showCourses() {
       $("#formFilter").submit();
   }

   $("#import-csv").on("change", function () {
       var fileName = $(this).val().split("\\").pop();
       $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
   });
</script>
@endsection
