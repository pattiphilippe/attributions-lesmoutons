@extends('layouts.pdfLayout')
@section('content')
<h2>Liste des attributions</h2>
<!-- if we have a filter we apply the groupBY on it -->
@if(isset($filter) && $filter != 'none')
@foreach($attributions as $attributions['filter'] => $attribution)
<h3>{{$attributions['filter']}}</h3>
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
        @foreach ($attribution as $att)
        <tr>
            <td>{{$att["professor_acronyme"]}} </td>
            <td>{{$att["course_id"]}} </td>
            <td>{{$att["group_id"]}} </td>
            <td>{{$att["quadrimester"]}} </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endforeach
<!-- If we dont have a filter we return a table with all attribution not grouped -->
@else
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
@endif
@endsection



