let table;

$(function () {
    table = $(".table-riwayat").DataTable({
        responsive: true,
        scrollX: true,
        scrollY: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: window.riwayatDataUrl,
        },
        columns: [
            { data: "DT_RowIndex", searchable: false, sortable: false },
            { data: "tanggal" },
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
});

function deleteData(url) {
    Swal.fire({
        title: "Yakin ingin menghapus data ini?",
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
