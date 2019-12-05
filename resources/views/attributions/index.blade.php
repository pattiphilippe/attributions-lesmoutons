@extends('layout')

@section('title', 'Liste des attributions')

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

<h1>Liste des attributions</h1>
@if(count($attributions) == 0)
<h2>La liste est vide</h2>
<p>Pas d'attributions 😀</p>
@else
<div class="form-group">
    <label for="select-groupby">Grouper par</label>
    <select name="groupby" id="select-groupby">
        <option value="" selected disabled>Choose here</option>
        <option value="group">Groupe</option>
        <option value="course">Activité d'apprentissage</option>
    </select>
</div>
<div id="attributions_list">
    <table id="table-professors-list" class="table">
        <thead>
            <tr>
                <th>Professeur Acronyme</th>
                <th>Cours</th>
                <th>Groupe</th>
                <th>Quadrimestre</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attributions as $attribution)
            <tr>
                <td scope="row">{{$attribution["professor_acronyme"]}} </td>
                <td>{{$attribution["course_id"]}} </td>
                <td>{{$attribution["group_id"]}} </td>
                <td>{{$attribution["quadrimester"]}} </td>
                <td>
                    <form id="form-btnAction" action="{{ route('attributions.destroy',$attribution["id"]) }}"
                        method="POST">
                        <a class="btn btn-primary" id="edit-{{$attribution['id']}}"
                            href="{{ route('attributions.edit',$attribution["id"]) }}">
                            <i class="fas fa-edit"></i> Editer</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="delete-{{$attribution['id']}}" class="btn btn-danger"
                            onclick="return confirm('Etes-vous sûr de vouloir supprimer cette attribution ? 😢');"><i
                                class="fas fa-trash-alt"></i> Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<a id="create-attribution-button" class="btn btn-info" href="{{ route('attributions.create') }}" role="button">Ajouter
    attribution</a>


@if(count($attributions) != 0)
<a id="export-pdf-button" class="btn btn-info" href="{{ route('download_attribution') }}" role="button">Export PDF</a>
@endif

<div class="buttonBloc">
    <button type="button" id="accueilBtn" name="accueilBtn" onclick="window.location='{{ route('index') }}' "> > vers
        accueil </button>
    {{-- <button type="button" onclick="window.location='{{ route('attributions.index') }}' "> > créer</button> --}}
</div>

<script src="{{ asset('js/attributions_grouping.js') }}"></script>
@endsection