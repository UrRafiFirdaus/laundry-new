let table;

$(function () {
    table = $(".table").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: window.kategoriDataUrl,
        },
        columns: [
            { data: "DT_RowIndex", searchable: false, sortable: false },
            { data: "nama_kategori" },
            { data: "berat_minimal" },
            { data: "harga" },
            { data: "aksi", searchable: false, sortable: false },
        ],
    });

    $("#modal-form")
        .validator()
        .on("submit", function (e) {
            if (!e.preventDefault()) {
                $.post(
                    $("#modal-form form").attr("action"),
                    $("#modal-form form").serialize(),
                )
                    .done((response) => {
                        $("#modal-form").modal("hide");
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert("Tidak dapat menyimpan data");
                        return;
                    });
            }
        });
});

function addForm(url) {
    $("#modal-form").modal("show");
    $("#modal-form .modal-title").text("Tambah Kategori Laudry");

    $("#modal-form form")[0].reset();
    $("#modal-form form").attr("action", url);
    $("#modal-form [name=_method]").val("post");
    $("#modal-form [name=nama_kategori]").focus();
    $("#modal-form [name=berat_minimal]").focus();
    $("#modal-form [name=harga]").focus();
}

function editForm(url) {
    $("#modal-form").modal("show");
    $("#modal-form .modal-title").text("Edit Kategori");

    $("#modal-form form")[0].reset();
    $("#modal-form form").attr("action", url);
    $("#modal-form [name=_method]").val("put");
    $("#modal-form [name=nama_kategori]").focus();
    $("#modal-form [name=berat_minimal]").focus();
    $("#modal-form [name=harga]").focus();

    $.get(url)
        .done((response) => {
            $("#modal-form [name=nama_kategori]").val(response.nama_kategori);
            $("#modal-form [name=berat_minimal]").val(response.berat_minimal);
            $("#modal-form [name=harga]").val(response.harga);
        })
        .fail((errors) => {
            alert("Tidak dapat menampilkan data");
            return;
        });
}

function deleteData(url) {
    Swal.fire({
        title: "Yakin ingin menghapus kategori ini?",
        text: "Data yang telah dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(url, {
                _token: $("[name=csrf-token]").attr("content"),
                _method: "delete",
            })
                .done((response) => {
                    Swal.fire("Terhapus!", "Data berhasil dihapus.", "success");
                    table.ajax.reload();
                })
                .fail((errors) => {
                    Swal.fire("Gagal!", "Tidak dapat menghapus data.", "error");
                });
        }
    });
}
