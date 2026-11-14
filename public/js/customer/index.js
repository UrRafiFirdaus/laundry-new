let table;
let isSubmitting = false;

$(function () {
    table = $(".table").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: window.customerDataUrl,
        },
        columns: [
            { data: "DT_RowIndex", searchable: false, sortable: false },
            { data: "kode_customer" },
            { data: "nama_customer" },
            { data: "telepon" },
            { data: "alamat" },
            { data: "aksi", searchable: false, sortable: false },
        ],
    });

    $("#modal-form form")
        .validator()
        .on("submit", function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                if (isSubmitting) {
                    return false;
                }

                isSubmitting = true;
                const $form = $(this);
                const $submitBtn = $form.find('button[type="submit"]');
                const originalBtnHtml = $submitBtn.html();

                $submitBtn
                    .prop("disabled", true)
                    .html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

                $.post($form.attr("action"), $form.serialize())
                    .done((response) => {
                        $("#modal-form").modal("hide");
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert("Tidak dapat meyimpan data");
                    })
                    .always(() => {
                        isSubmitting = false;
                        $submitBtn
                            .prop("disabled", false)
                            .html(originalBtnHtml);
                    });
                // $.post(
                //     $("#modal-form form").attr("action"),
                //     $("#modal-form form").serialize(),
                // )
                //     .done((response) => {
                //         $("#modal-form").modal("hide");
                //         table.ajax.reload();
                //     })
                //     .fail((errors) => {
                //         alert("Tidak dapat menyimpan data");
                //         return;
                //     });
            }
        });
});

function addForm(url) {
    $("#modal-form").modal("show");
    $("#modal-form .modal-title").text("Tambah Customer");

    $("#modal-form form")[0].reset();
    $("#modal-form form").attr("action", url);
    $("#modal-form [name=_method]").val("post");
    // $("#modal-form [name=kode_customer]").focus();
    // $("#modal-form [name=nama_customer]").focus();
    // $("#modal-form [name=telepon]").focus();
    // $("#modal-form [name=alamat]").focus();
    // $("#modal-form [name=alamat]").focus();
    $("#modal-form form").find('button[type="submit"]').prop("disabled", false);

    setTimeout(() => {
        $("#modal-form [name=nama_customer").focus();
    }, 300);
}

function editForm(url) {
    $("#modal-form").modal("show");
    $("#modal-form .modal-title").text("Edit Customer");

    $("#modal-form form")[0].reset();
    $("#modal-form form").attr("action", url);
    $("#modal-form [name=_method]").val("put");
    // $("#modal-form [name=kode_customer]").focus();
    // $("#modal-form [name=nama_customer]").focus();
    // $("#modal-form [name=telepon]").focus();
    // $("#modal-form [name=alamat]").focus();
    $("#modal-form form").find('button[type="submit"]').prop("disabled", false);

    $.get(url)
        .done((response) => {
            $("#modal-form [name=kode_customer]").val(response.kode_customer);
            $("#modal-form [name=nama_customer]").val(response.nama_customer);
            $("#modal-form [name=telepon]").val(response.telepon);
            $("#modal-form [name=alamat]").val(response.alamat);
        })
        .fail((errors) => {
            alert("Tidak dapat menampilkan data");
            return;
        });
}

function deleteData(url) {
    Swal.fire({
        title: "Yakin ingin menghapus customer ini?",
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
