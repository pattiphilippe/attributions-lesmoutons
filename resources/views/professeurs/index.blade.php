@extends('layout')

@section('title', 'Liste de professeurs')

@section('content')
<h1>Liste de professeurs</h1>

@if(Session::has('message'))
    <p>{{ Session::get('message') }}</p>
@endif

<table id="table-professeurs-list" class="table">
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

<!-- Form -->
<form method='post' action='/uploadFile' enctype='multipart/form-data' >
    {{ csrf_field() }}
    <input id="file-button" type='file' name='file' >
    <input type='submit' name='submit' value='Import'>
</form>

<div class="buttonBloc">
    <button type="button" onclick="window.location='{{ route('accueil') }}' "> > vers accueil </button>
    {{-- <button type="button" onclick="window.location='{{ route('courses.create') }}' "> > créer</button> --}}
</div>
@endsection