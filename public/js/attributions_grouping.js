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
            document.getElementById("export-pdf-button").setAttribute('href', "/downloadFileAttribution/group");
        }
        if (this.value == "course") {
            setAttributionsGroupedBy("course");
            document.getElementById("export-pdf-button").setAttribute('href', "/downloadFileAttribution/course");
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
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    `);
}

function fillTable(title, attributions) {
    attributions.forEach(attribution => {
        $(`#table-${title} tbody`).append(`
            <tr>
                <td>${attribution.professor_acronyme}</td>
                <td scope="row">${attribution.course_id}</td>
                <td>${attribution.group_id}</td>
            </tr>
        `);
    });
}

function removeTable() {
    $("#attributions_list").empty();
}
