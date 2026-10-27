let table;

function hitungTotal() {
    let berat = parseFloat($("#berat_total").val()) || 0;
    let harga = parseFloat($("#harga").val()) || 0;

    let total = berat * harga;

    // tampilkan ke UI
    $(".tampil-bayar").val("Rp " + total.toLocaleString("id-ID"));

    // INI YANG PALING PENTING (kirim ke backend)
    $("#total_harga_hidden").val(total);
}

// Tunai -> otomatis "sudah dibayar". QRIS / Virtual Account -> "belum dibayar"
// sampai Midtrans mendeteksi pembayarannya.
function aturStatusPembayaran() {
    let tipe = $("#tipe_pembayaran").val();
    let tunai = tipe === "tunai";

    $("#status_pembayaran").val(tunai ? "sudah dibayar" : "belum dibayar");
    $("#status_pembayaran_tampil").val(
        tunai ? "Sudah dibayar" : "Belum dibayar",
    );
    $("#info_tipe_pembayaran").text(
        tunai
            ? ""
            : "Customer membayar lewat menu Cek Status Laundry (Midtrans). Status berubah otomatis setelah dibayar.",
    );
}

$(function () {
    $("body").addClass("sidebar-collapse");

    $("#tipe_pembayaran").on("change", aturStatusPembayaran);
    aturStatusPembayaran();

    // Trigger saat berat diubah
    $("#berat_total").on("input", function () {
        hitungTotal();
    });

    table = $(".table-paket").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: window.transaksiDataUrl,
        },
        columns: [
            { data: "DT_RowIndex", searchable: false, sortable: false },
            { data: "nama_kategori" },
            { data: "berat_minimal" },
            { data: "harga" },
            { data: "aksi", searchable: false, sortable: false },
        ],
        dom: "Brt",
        dSort: false,
        paginate: false,
    });

    $(".btn-simpan").on("click", function (e) {
        e.preventDefault();
        hitungTotal();
        let total = $("#total_harga_hidden").val();

        if (!total || total == 0) {
            alert("Total harga belum dihitung");
            return;
        }
        $(".form-paket").submit();
    });
});

function tampilKategori() {
    $("#modal-kategori").modal("show");
}

function pilihKategori(id, nama, berat, harga) {
    $("#id_kategori").val(id);
    $("#nama_kategori").val(nama);
    $("#harga").val(harga);

    // SIMPAN KE paket_detail
    $.post(window.transaksiStoreUrl, {
        _token: $('meta[name="csrf-token"]').attr("content"),
        id_paket: $("#id_paket").val(),
        id_kategori: id,
    })
        .done(function () {
            table.ajax.reload(); // reload tabel detail
        })
        .fail(function () {
            alert("Gagal simpan detail");
        });

    hitungTotal();
    hideKategori();
}

function hideKategori() {
    $("#modal-kategori").modal("hide");
}

function tampilCustomer() {
    $("#modal-customer").modal("show");
}

function pilihCustomer(id, kode, nama, telepon, alamat) {
    $("#id_customer").val(id);
    $("#kode_customer").val(kode);
    $("#nama_customer").val(nama);
    $("#telepon").val(telepon);
    $("#alamat").val(alamat);
    hideCustomer();
}

function hideCustomer() {
    $("#modal-customer").modal("hide");
}

function addForm(url) {
    $("#modal-form").modal("show");
    $("#modal-form .modal-title").text("Tambah Paket Baru");

    $("#modal-form form")[0].reset();
    $("#modal-form form").attr("action", url);
    $("#modal-form [name=_method]").val("post");
    $("#modal-form [name=kode_produk]").focus();
    $("#modal-form [name=id_customer]").focus();
    $("#modal-form [name=nama_customer]").focus();
    $("#modal-form [name=berat_total]").focus();
    $("#modal-form [name=total_harga]").focus();
    $("#modal-form [name=id_kategori]").focus();
    $("#modal-form [name=total_harga]").focus();
    $("#modal-form [name=status_pembayaran]").focus();
    $("#modal-form [name=status_paket]").focus();
    $("#modal-form [name=harga]").focus();
}
