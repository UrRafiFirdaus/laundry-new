let table;

$(function () {
    table = $(".table").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: window.laporanDataUrl,
        },
        columns: [
            { data: "DT_RowIndex", searchable: false, sortable: false },
            { data: "tanggal" },
            { data: "pendapatan" },
        ],
        dom: "Brt",
        bSort: false,
        bPaginate: false,
    });

    $(".datepicker").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
    });
});

function updatePeriode() {
    $("#modal-form").modal("show");
}
