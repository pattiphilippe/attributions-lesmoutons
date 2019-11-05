@extends('layout')

@section('title', 'Liste de groupes')

@section('content')
<h1>Liste de groupes</h1>
@if (count($groupes) == 0)
<h2>La liste est vide</h2>
<p>Pas de groupe disponible. </p>
@else
<table id="table-groups-list" class="table">
    <thead>
        <tr>
            <th>nom</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($groupes as $group)
        <tr>
            <td scope="row">{{$group['nom']}} </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
<div class="buttonBloc">
    <button type="button" id="accueilBtn" name="accueilBtn" onclick="window.location='{{ route('index') }}' "> > vers
        accueil </button>
    {{-- <button type="button" onclick="window.location='{{ route('courses.create') }}' "> > créer</button> --}}
</div>
@endsection