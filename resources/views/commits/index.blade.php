@extends('layout')

@section('title', 'Liste des commits')

@section('content')
<h1>Liste des commits</h1>

<table id="table-professeurs-list" class="table">
    <thead>
        <tr>
            <th>Identifiant</th>
            <th>Message</th>
            <th>Auteur</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($commits as $commit)
        <tr>
            <td>{{$commit["id"]}} </td>
            <td>{{$commit["message"]}} </td>
            <td>{{$commit["author"]}} </td>
            <td>{{$commit["insertion"]}} </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="buttonBloc">
    <button type="button" onclick="window.location='{{ route('accueil') }}' "> > vers accueil </button>
    {{-- <button type="button" onclick="window.location='{{ route('courses.create') }}' "> > créer</button> --}}
</div>
@endsection