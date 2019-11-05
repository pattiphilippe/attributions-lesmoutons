@extends('layout')

@section('title', 'Liste des Cours')

@section('content')
<h1>Liste des Cours</h1>
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
            <td scope="row">{{$course["id"]}} </td>
            <td>{{$course["title"]}} </td>
            <td>{{$course["credits"]}} </td>
            <td>{{$course["BM1_hours"]}} </td>
            <td>{{$course["BM2_hours"]}} </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
<div class="buttonBloc">
    <button type="button" onclick="window.location='{{ route('index') }}' "> > vers accueil </button>
</div>
@endsection