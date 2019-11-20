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
  <select id="select-groupby">
      <option value="" selected disabled>Choose here</option>
      <option value="group">Groupe</option>
      <option value="course">Activité d'apprentissage</option>
  </select>
</div>
<table id="table-professors-list" class="table">
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
            <td scope="row">{{$attribution["professor_acronyme"]}} </td>
            <td>{{$attribution["course_id"]}} </td>
            <td>{{$attribution["group_id"]}} </td>
            <td>{{$attribution["quadrimester"]}} </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

<a id="create-attribution-button" class="btn btn-info" href="{{ route('attributions.create') }}" role="button">Ajouter
    attribution</a>

<div class="buttonBloc">
    <button type="button" id="accueilBtn" name="accueilBtn" onclick="window.location='{{ route('index') }}' "> > vers
        accueil </button>
    {{-- <button type="button" onclick="window.location='{{ route('attributions.index') }}' "> > créer</button> --}}
</div>

<script>
    $("#import-csv").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    $(() => {
        initSelectListener();
        // fetchAttributions();
    });

    function initSelectListener() {
        $("#select-groupby").on('change', function() {
            if(this.value == "group") {
                fetchAttributions();
            }
        });
    }

    function fillTable(data) {
        console.log(data);
        // groupBy(data, attribution => attribution.group_id);
        emptyTable();

        for (const [key, value] of data.entries()) {
            // console.log(key, value);

            value.forEach(attribution => {
                console.log(attribution);
                addRow(attribution);
            });
        }
    }

    function addRow(data) {
        $("#table-professors-list tbody").append(`
        <tr>
            <td>${data.professor_acronyme}</td>
            <td scope="row">${data.course_id}</td>
            <td>${data.group_id}</td>
            <td>${data.quadrimester}</td>
        </tr>`);
    }

    function emptyTable() {
        $("#table-professors-list tbody").empty();
    }

    function fetchAttributions() {
        $.get("/api/attributions", (data, status) => {
            // console.log(groupBy(data, attribution => attribution.group_id));
            fillTable(groupBy(data, attribution => attribution.group_id));
        });
    }

    function groupBy(list, keyGetter) {
        const map = new Map();
        list.forEach((item) => {
            const key = keyGetter(item);
            const collection = map.get(key);
            if (!collection) {
                map.set(key, [item]);
            } else {
                collection.push(item);
            }
        });
        return map;
    }
</script>
@endsection
