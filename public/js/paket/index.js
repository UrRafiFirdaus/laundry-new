let table, table1;

$(function () {
    table = $(".table-paketbaru").DataTable({
        responsive: true,
        scrollX: true,
        scrollY: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: window.paketbaruDataUrl,
        },
        columns: [
            { data: "select_all", searchable: false, sortable: false },
            { data: "DT_RowIndex", searchable: false, sortable: false },
            { data: "kode_paket" },
            { data: "nama_customer" },
            { data: "nama_kategori" },
            { data: "berat_total" },
            { data: "total_harga" },
            { data: "status_pembayaran" },
            { data: "status_paket" },
            { data: "aksi", searchable: false, sortable: false },
        ],
    });

    table1 = $(".table-detail").DataTable({
        processing: true,
        bSort: false,
        scrollX: true,
        autoWidth: false,
        responsive: true,
        dom: "Brt",
        columns: [
            { data: "DT_RowIndex", searchable: false, sortable: false },
            { data: "nama_kategori" },
            { data: "berat_minimal" },
            { data: "harga" },
            { data: "tipe_pengambilan" },
            { data: "telepon" },
            { data: "alamat" },
            { data: "kasir" },
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

    $("[name=select_all]").click(function () {
        $('input[name="id_paket[]"]').prop("checked", this.checked);
    });

    // Muat ulang tabel tiap 15 detik agar status pembayaran dari Midtrans otomatis terlihat.
    // Dilewati saat ada checkbox terpilih atau modal terbuka supaya kerja kasir tidak terganggu.
    setInterval(function () {
        if (
            $('input[name="id_paket[]"]:checked').length === 0 &&
            $(".modal.in").length === 0
        ) {
            table.ajax.reload(null, false);
        }
    }, 15000);
});

function showDetail(url) {
    $("#modal-detail").modal("show");

    table1.ajax.url(url);
    table1.ajax.reload();
}

function updateStatus(url, nextLabel) {
    Swal.fire({
        title: "Konfirmasi",
        text: 'Yakin ingin mengupdate status menjadi "' + nextLabel + '" ?',
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, update!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(url, {
                _token: window.csrfToken,
            })

                .done((response) => {
                    table.ajax.reload();

                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: response,
                    });
                })

                .fail((errors) => {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Gagal update status",
                    });
                });
        }
    });
}

function editForm(url) {
    $("#modal-form").modal("show");
    $("#modal-form .modal-title").text("Edit Paket");

    $("#modal-form form")[0].reset();

    $.get(url)
        .done((response) => {
            $("#modal-form form").attr(
                "action",
                window.basePaketUrl + "/" + response.id_paket,
            );

            $("#modal-form [name=_method]").val("put");

            $("#modal-form [name=kode_paket]").val(response.kode_paket);
            $("#modal-form [name=id_customer]").val(response.id_customer);
            $("#modal-form [name=berat_total]").val(response.berat_total);
            $("#modal-form [name=total_harga]").val(response.total_harga);
            $("#modal-form [name=status_pembayaran]").val(
                response.status_pembayaran,
            );
            $("#modal-form [name=tipe_pengambilan]").val(
                response.tipe_pengambilan,
            );
            $("#modal-form [name=status_paket]").val(response.status_paket);
            $("#modal-form [name=telepon]").val(response.telepon);
            $("#modal-form [name=alamat]").val(response.alamat);
        })

        .fail((errors) => {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Tidak dapat menampilkan data",
            });
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

function cetakBarcode(url) {
    let checked = $('input[name="id_paket[]"]:checked');
    if (checked.length < 1) {
        Swal.fire({
            icon: "warning",
            title: "Pilih Paket",
            text: "Silakan pilih minimal satu paket",
        });

        return;
    }

    $(".form-paket .selected").remove();
    checked.each(function () {
        $(".form-paket").append(
            '<input class="selected" type="hidden" name="id_paket[]" value="' +
                $(this).val() +
                '">',
        );
    });

    Swal.fire({
        title: "Cetak Barcode?",
        icon: "question",
        showCancelButton: true,
    }).then((result) => {
        if (result.isConfirmed) {
            $(".form-paket")
                .attr("action", url)
                .attr("target", "_blank")
                .submit();
        }
    });
}
