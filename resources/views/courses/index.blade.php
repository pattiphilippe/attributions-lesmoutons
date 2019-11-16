<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

@extends('layout')

@section('title', 'Liste des Cours')

@section('content')
<h1>Liste des Cours</h1>
@if(count($courses) == 0)
<h2>La liste est un peu vide!</h2>
<p>Pas de cours disponible 😀</p>
@else
<form id="form" action="/courses" method="GET">
    <select name="option" onchange="showCourses()">
        <option value="courses" <?php echo (isset($_GET['option']) && $_GET['option'] == 'courses') ? 'selected="selected"' : ''; ?> >Tout</option>
        <option value="coursesAttributed" <?php echo (isset($_GET['option']) && $_GET['option'] == 'coursesAttributed') ? 'selected="selected"' : ''; ?> >Attribué(s)</option>
        <option value="coursesNonAttributed" <?php echo (isset($_GET['option']) && $_GET['option'] == 'coursesNonAttributed') ? 'selected="selected"' : ''; ?> >Non-attribué(s)</option>
    </select>
</form>
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
<script>
    function showCourses() {
        $("#form").submit();
    }
</script>
@endif
<div class="buttonBloc">
    <button type="button" onclick="window.location='{{ route('index') }}' "> > vers accueil </button>
</div>
@endsection
