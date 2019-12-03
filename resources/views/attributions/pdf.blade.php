@extends('layouts.pdfLayout')
@section('content')
<header>
        <img id="logo" src="./images/he2b-esi.jpg" alt="HE2B-ESI" />

        <h1>PRJG5 - HE2B ESI </h1>
    </header>
    <h2>Liste des attributions</h2>
<table width="100%">
    <thead>
        <tr>
            <th>Professeur Acronyme</th>
            <th>Cours</th>
            <th>Groupe</th>
            <th>Quadrimestre</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($attributions as $attribution)
        <tr>
            <td>{{$attribution["professor_acronyme"]}} </td>
            <td>{{$attribution["course_id"]}} </td>
            <td>{{$attribution["group_id"]}} </td>
            <td>{{$attribution["quadrimester"]}} </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection