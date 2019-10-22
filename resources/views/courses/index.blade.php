@extends('layout')

@section('title', 'Liste de professeurs')

@section('content')
<h1>Liste de professeurs</h1>

<table id="table-professeurs-list" class="table">
    <thead>
        <tr>
            <th>Acronyme</th>
            <th>Nom</th>
            <th>Prenom</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($courses as $professeur)
        <tr>
            <td scope="row">{{$professeur["acronyme"]}} </td>
            <td>{{$professeur["nom"]}} </td>
            <td>{{$professeur["prenom"]}} </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="buttonBloc">
    <button type="button" onclick="window.location='{{ route('accueil') }}' "> > vers accueil </button>
    {{-- <button type="button" onclick="window.location='{{ route('courses.create') }}' "> > créer</button> --}}
</div>
@endsection