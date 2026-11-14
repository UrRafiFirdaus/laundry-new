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

    const $modal = $("#modal-form");
    const $form = $("#modal-form form");
    const $submitBtn = $form.find('button[type="submit"]');
    const originalBtnHtml = $submitBtn.html();

    $modal.on("hidden.bs.modal", function () {
        isSubmitting = false;
        $submitBtn.prop("disabled", false).html(originalBtnHtml);
        $form.find("input").prop("readonly", false);
    });

    $form.on("keydown", "input", function (e) {
        if (e.key === "Enter" || e.keyCode === 13) {
            if (isSubmitting) {
                e.preventDefault();
                e.stopImmediatePropagation();
                return false;
            }
        }
    });

    $form.validator().on("submit", function (e) {
        if (e.isDefaultPrevented()) {
            return false;
        }

        e.preventDefault();
        e.stopImmediatePropagation();

        if (isSubmitting) {
            return false;
        }

        isSubmitting = true;
        $submitBtn
            .prop("disabled", true)
            .html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

        $form.find("input").prop("readonly", true);

        $.post($form.attr("action"), $form.serialize())
            .done((response) => {
                $modal.modal("hide");
                table.ajax.reload(null, false);
            })
            .fail((errors) => {
                isSubmitting = false;
                $submitBtn.prop("disabled", false).html(originalBtnHtml);
                $form.find("input").prop("readonly", false);
                alert("Tidak dapat menyimpan data customer.");
            });
    });
});

function addForm(url) {
    isSubmitting = false;
    $("#modal-form").modal("show");
    $("#modal-form .modal-title").text("Tambah Customer");

    $("#modal-form form")[0].reset();
    $("#modal-form form").attr("action", url);
    $("#modal-form [name=_method]").val("post");
    $("#modal-form form").find("input").prop("readonly", false);
    $("#modal-form form").find('button[type="submit"]').prop("disabled", false);

    setTimeout(() => {
        $("#modal-form [name=nama_customer]").focus();
    }, 300);
}

function editForm(url) {
    isSubmitting = false;
    $("#modal-form").modal("show");
    $("#modal-form .modal-title").text("Edit Customer");

    $("#modal-form form")[0].reset();
    $("#modal-form form").attr("action", url);
    $("#modal-form [name=_method]").val("put");
    $("#modal-form form").find("input").prop("readonly", false);
    $("#modal-form form").find('button[type="submit"]').prop("disabled", false);

    $.get(url)
        .done((response) => {
            $("#modal-form [name=nama_customer]").val(response.nama_customer);
            $("#modal-form [name=telepon]").val(response.telepon);
            $("#modal-form [name=alamat]").val(response.alamat);
            $("#modal-form [name=nama_customer]").focus();
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
