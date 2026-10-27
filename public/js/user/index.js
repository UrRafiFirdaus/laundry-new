let table;

$(function () {
    table = $(".table").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: window.userDataUrl,
        },
        columns: [
            { data: "DT_RowIndex", searchable: false, sortable: false },
            { data: "name" },
            { data: "username", defaultContent: "-" },
            { data: "email" },
            { data: "level_text" },
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
                        let pesan = "Tidak dapat menyimpan data.";
                        if (errors.responseJSON && errors.responseJSON.errors) {
                            pesan = Object.values(
                                errors.responseJSON.errors,
                            )[0][0];
                        }
                        alert(pesan);
                        return;
                    });
            }
        });
});

function addForm(url) {
    $("#modal-form").modal("show");
    $("#modal-form .modal-title").text("Tambah User");

    $("#modal-form form")[0].reset();
    $("#modal-form form").attr("action", url);
    $("#modal-form [name=_method]").val("post");
    $("#modal-form [name=name]").focus();

    $("#password, #password_confirmation").attr("required", true);
}

function editForm(url) {
    $("#modal-form").modal("show");
    $("#modal-form .modal-title").text("Edit User");

    $("#modal-form form")[0].reset();
    $("#modal-form form").attr("action", url);
    $("#modal-form [name=_method]").val("put");
    $("#modal-form [name=name]").focus();

    $("#password, #password_confirmation").attr("required", false);

    $.get(url)
        .done((response) => {
            $("#modal-form [name=name]").val(response.name);
            $("#modal-form [name=username".val(response.username));
            $("#modal-form [name=email]").val(response.email);
            $("#modal-form [name=level]").val(response.level);
        })
        .fail((errors) => {
            alert("Tidak dapat menampilkan data");
            return;
        });
}

function deleteData(url) {
    if (confirm("Yakin ingin menghapus data terpilih?")) {
        $.post(url, {
            _token: $("[name=csrf-token]").attr("content"),
            _method: "delete",
        })
            .done((response) => {
                table.ajax.reload();
            })
            .fail((errors) => {
                alert("Tidak dapat menghapus data");
                return;
            });
    }
}
