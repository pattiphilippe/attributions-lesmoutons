@extends('layout')

@section('title', 'Liste de groupes')

@section('content')
<h1>Liste de groupes</h1>

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