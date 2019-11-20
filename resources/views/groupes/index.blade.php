@extends('layout')

@section('title', 'Liste de groupes')

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
<h1>Liste de groupes</h1>
<<<<<<< HEAD
@if(count($groupes) == 0)
<h2>La liste est un peu vide!</h2>
<p>Pas de groupes disponible 😀</p>
=======
@if (count($groupes) == 0)
<h2>La liste est vide</h2>
<p>Pas de groupe disponible. </p>
>>>>>>> 552366a16cc9501eebe212dd1f221fcd54554f5a
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
<<<<<<< HEAD
=======

<!-- Form -->
<form method='post' action='{{ route('upload_group') }}' enctype='multipart/form-data'>
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

>>>>>>> 552366a16cc9501eebe212dd1f221fcd54554f5a
<div class="buttonBloc">
    <button type="button" id="accueilBtn" name="accueilBtn" onclick="window.location='{{ route('index') }}' "> > vers
        accueil </button>
    {{-- <button type="button" onclick="window.location='{{ route('courses.create') }}' "> > créer</button> --}}
</div>
@endsection
