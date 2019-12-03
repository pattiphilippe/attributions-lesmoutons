<h1>Liste des attributions</h1>
<table>
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