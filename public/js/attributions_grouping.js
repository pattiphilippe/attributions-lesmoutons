$(() => {
    csvImportListener();
    initSelectListener();
});

function csvImportListener() {
    $("#import-csv").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
}

function initSelectListener() {
    $("#select-groupby").on('change', function () {
        if (this.value == "group") {
            setAttributionsGroupedBy("group");
        }
        if (this.value == "course") {
            setAttributionsGroupedBy("course");
        }
    });
}

function setAttributionsGroupedBy(criteria) {
    let matcher;
    if (criteria == "course") matcher = attribution => attribution.course_id;
    if (criteria == "group") matcher = attribution => attribution.group_id;
    $.get("/api/attributions", (data, status) => {
        createTable(groupBy(data, matcher));
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

function createTable(data) {
    removeTable();
    for (const [title, attributions] of data.entries()) {
        addTitle(title);
        createEmptyTable(title, attributions);
        fillTable(title, attributions);
    }
}

function addTitle(title) {
    $('#attributions_list').append(`<h3>${title}</h3>`);
}

function createEmptyTable(title) {
    $('#attributions_list').append(`
        <table class="table" id="table-${title}">
            <thead>
                <tr>
                    <th>Professeur</th>
                    <th>Cours</th>
                    <th>Groupe</th>
                    <th>Action<th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    `);
}

function fillTable(title, attributions) {
    var csrfVar = $('meta[name="csrf-token"]').attr('content');
    attributions.forEach(attribution => {
        $(`#table-${title} tbody`).append(`
            <tr>
                <td>${attribution.professor_acronyme}</td>
                <td scope="row">${attribution.course_id}</td>
                <td>${attribution.group_id}</td>
                <td>
                <form class="form-btnAction" action="/attributions/${attribution.id}" method="POST">
                    <a class="btn btn-primary" href="/attributions/${attribution.id}/edit">Editer</a>
                    <input name="_token" value="` + csrfVar + `" type="hidden">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="submit" class="btn btn-danger" value="Supprimer" />
                </form>
            </td>
            </tr>
        `);
    });
}

function removeTable() {
    $("#attributions_list").empty();
}
