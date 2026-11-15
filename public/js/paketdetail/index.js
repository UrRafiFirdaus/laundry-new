/* ==========================================================================
   Transaksi Baru (paketdetail)
   ========================================================================== */

let modeCustomer = "lama"; // 'lama' = pilih dari daftar, 'baru' = input manual
let totalTampil = 0; // angka yang sedang tampil (untuk animasi hitung)
let animFrame = null;

/* ---------- Util ---------- */
function rupiah(n) {
    return "Rp " + (Math.round(n) || 0).toLocaleString("id-ID");
}

function notify(msg) {
    if (window.Swal) {
        Swal.fire({ icon: "warning", title: "Perhatian", text: msg });
    } else {
        alert(msg);
    }
}

function escapeHtml(t) {
    return $("<div>").text(t).html();
}

/* ---------- Total bayar ---------- */
function animasiTotal(target) {
    if (animFrame) cancelAnimationFrame(animFrame);

    const awal = totalTampil;
    const mulai = performance.now();
    const durasi = 350;

    function frame(now) {
        const p = Math.min((now - mulai) / durasi, 1);
        const nilai = awal + (target - awal) * (1 - Math.pow(1 - p, 3));
        $("#tampil-total").html(
            '<span class="cur">Rp</span>' +
                Math.round(nilai).toLocaleString("id-ID"),
        );
        if (p < 1) {
            animFrame = requestAnimationFrame(frame);
        } else {
            totalTampil = target;
            $("#mobile-total").text(rupiah(target));
        }
    }
    animFrame = requestAnimationFrame(frame);

    $("#tampil-total").addClass("bump");
    setTimeout(function () {
        $("#tampil-total").removeClass("bump");
    }, 200);
}

function hitungTotal() {
    const berat = parseFloat($("#berat_total").val()) || 0;
    const harga = parseFloat($("#harga").val()) || 0;
    const total = Math.round(berat * harga);

    // dikirim ke backend
    $("#total_harga_hidden").val(total);

    if (total !== totalTampil) animasiTotal(total);

    $("#tampil-rumus").text(
        berat > 0 && harga > 0
            ? berat.toLocaleString("id-ID") + " Kg × " + rupiah(harga)
            : "Pilih tipe laundry & isi berat",
    );
    $("#sum-harga").text(harga > 0 ? rupiah(harga) + " / Kg" : "-");
    $("#sum-berat").text(
        berat > 0 ? berat.toLocaleString("id-ID") + " Kg" : "-",
    );
}

/* ---------- Ringkasan ---------- */
function updateRingkasan() {
    const nama = $.trim($("#nama_customer").val());
    let teks = nama || "-";
    if (nama && modeCustomer === "baru") teks += " (baru)";
    $("#sum-customer").text(teks);

    $("#sum-kategori").text($("#nama_kategori").val() || "-");

    const ambil = $("input[name=tipe_pengambilan]:checked").val();
    $("#sum-ambil").text(
        ambil ? ambil.charAt(0).toUpperCase() + ambil.slice(1) : "-",
    );
}

// Tunai -> otomatis "sudah dibayar". Non tunai -> "belum dibayar"
// sampai Midtrans mendeteksi pembayarannya.
function aturStatusPembayaran() {
    const tunai = $("input[name=tipe_pembayaran]:checked").val() === "tunai";

    $("#status_pembayaran").val(tunai ? "sudah dibayar" : "belum dibayar");
    $("#status_pembayaran_tampil")
        .text(tunai ? "Sudah dibayar" : "Belum dibayar")
        .toggleClass("ok", tunai)
        .toggleClass("warn", !tunai);

    $("#info_tipe_pembayaran")
        .text(
            "Customer membayar lewat menu Cek Status Laundry (Midtrans). Status berubah otomatis setelah dibayar.",
        )
        .toggle(!tunai);
}

/* ---------- Mode pelanggan: lama / baru ---------- */
function resetCustomer() {
    $("#id_customer").val("");
    $("#nama_customer").val("");
    $("#telepon").val("");
    $("#alamat").val("");
    $("#picked-box").hide();
}

function setMode(mode, tanpaReset) {
    modeCustomer = mode;
    $("#mode-lama").toggleClass("active", mode === "lama");
    $("#mode-baru").toggleClass("active", mode === "baru");

    if (!tanpaReset) resetCustomer();

    if (mode === "lama") {
        $("#panel-lama").show();
        $("#hint-baru").hide();
        $("#nama_customer")
            .prop("readonly", true)
            .attr("placeholder", "Pilih customer dari daftar...");
    } else {
        $("#panel-lama").hide();
        $("#hint-baru").show();
        $("#id_customer").val("");
        $("#picked-box").hide();
        $("#nama_customer")
            .prop("readonly", false)
            .attr("placeholder", "Nama pelanggan");
    }
    updateRingkasan();
}

/* ---------- Modal customer + pencarian ---------- */
function tampilCustomer() {
    $("#cari-customer").val("");
    filterCustomer();
    $("#modal-customer").modal("show");
}

function hideCustomer() {
    $("#modal-customer").modal("hide");
}

function pilihCustomer(id, kode, nama, telepon, alamat) {
    setMode("lama", true);

    $("#id_customer").val(id);
    $("#nama_customer").val(nama);
    $("#telepon").val(telepon);
    $("#alamat").val(alamat);

    $("#picked-av").text((nama || "?").charAt(0).toUpperCase());
    $("#picked-nama").text(nama);
    $("#picked-kode").text(kode);
    $("#picked-box").css("display", "flex");

    updateRingkasan();
    hideCustomer();
}

function highlight($cell, terms) {
    if ($cell.data("orig") === undefined) $cell.data("orig", $cell.text());
    const asli = String($cell.data("orig"));
    const polos = terms.filter(Boolean);

    if (!polos.length) {
        $cell.text(asli);
        return;
    }
    const pola = new RegExp(
        "(" +
            polos
                .map(function (t) {
                    return t.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
                })
                .join("|") +
            ")",
        "ig",
    );
    const html = asli
        .split(pola)
        .map(function (bagian, i) {
            // indeks ganjil = bagian yang cocok
            return i % 2 === 1
                ? '<mark class="hl">' + escapeHtml(bagian) + "</mark>"
                : escapeHtml(bagian);
        })
        .join("");
    $cell.html(html);
}

function filterCustomer() {
    const q = $.trim($("#cari-customer").val()).toLowerCase();
    const terms = q ? q.split(/\s+/) : [];
    const $rows = $("#modal-customer .cust-row");
    let tampil = 0;

    $rows.each(function () {
        const $r = $(this);
        const s = ($r.attr("data-search") || "").toLowerCase();
        const sPolos = s.replace(/[\s\-+.()]/g, "");

        const cocok = terms.every(function (t) {
            const tPolos = t.replace(/[\s\-+.()]/g, "");
            return (
                s.indexOf(t) !== -1 || (tPolos && sPolos.indexOf(tPolos) !== -1)
            );
        });

        $r.toggle(cocok);
        if (cocok) {
            tampil++;
            $r.find(".cust-no").text(tampil);
        }
        highlight($r.find(".cust-nama strong"), cocok ? terms : []);
        highlight($r.find(".cust-telepon"), cocok ? terms : []);
        highlight($r.find(".cust-alamat"), cocok ? terms : []);
    });

    $("#cari-customer-clear").toggle(q.length > 0);
    $("#cust-count-text").text(
        q
            ? "Ditemukan " + tampil + " dari " + $rows.length + " customer"
            : $rows.length + " customer terdaftar",
    );

    const kosong = tampil === 0;
    $("#cust-empty").toggle(kosong);
    if (kosong) {
        $("#cust-empty-text").text(
            $rows.length === 0
                ? "Belum ada customer terdaftar."
                : 'Tidak ada customer yang cocok dengan "' + q + '".',
        );
        $("#btn-jadi-baru").toggle(q.length > 0);
    }
}

/* ---------- Init ---------- */
$(function () {
    $("body").addClass("sidebar-collapse");

    // --- Pelanggan
    $("#mode-lama").on("click", function () {
        if (modeCustomer !== "lama") setMode("lama");
    });
    $("#mode-baru").on("click", function () {
        if (modeCustomer !== "baru") setMode("baru");
    });

    // Klik kolom nama saat mode lama = buka daftar customer
    $("#nama_customer").on("click", function () {
        if (modeCustomer === "lama") tampilCustomer();
    });
    $("#nama_customer").on("input", updateRingkasan);

    // Pencarian di modal
    $("#cari-customer").on("input", filterCustomer);
    $("#cari-customer-clear").on("click", function () {
        $("#cari-customer").val("").focus();
        filterCustomer();
    });
    $("#cari-customer").on("keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            const $v = $("#modal-customer .cust-row:visible");
            if ($v.length === 1) $v.first().trigger("click"); // hanya 1 hasil -> langsung pilih
        }
    });
    $("#modal-customer").on("shown.bs.modal", function () {
        $("#cari-customer").trigger("focus");
    });
    $("#modal-customer .cust-row").on("click", function () {
        const $r = $(this);
        pilihCustomer(
            $r.attr("data-id"),
            $r.attr("data-kode"),
            $r.attr("data-nama"),
            $r.attr("data-telepon"),
            $r.attr("data-alamat"),
        );
    });

    // Tidak ketemu -> lanjutkan sebagai customer baru
    $("#btn-jadi-baru").on("click", function () {
        const q = $.trim($("#cari-customer").val());
        const angka = q.replace(/[\s\-+.()]/g, "");
        const nomor = /^\d{5,}$/.test(angka);

        setMode("baru");
        if (nomor) {
            $("#telepon").val(q);
        } else {
            $("#nama_customer").val(q);
        }
        updateRingkasan();
        hideCustomer();
        $("#nama_customer").trigger("focus");
    });

    // Jika halaman dimuat ulang karena error validasi dan nama sudah terisi,
    // anggap mode input manual (id_customer tidak ikut kembali).
    if ($.trim($("#nama_customer").val()) !== "") {
        setMode("baru", true);
    } else {
        setMode("lama", true);
    }

    // --- Berat
    $("#berat_total").on("input", hitungTotal);
    $(".btn-step").on("click", function () {
        const step = parseFloat($(this).data("step"));
        let nilai = (parseFloat($("#berat_total").val()) || 0) + step;
        nilai = Math.max(0, Math.round(nilai * 10) / 10);
        $("#berat_total").val(nilai).trigger("input");
    });
    $(".trx-quick button").on("click", function () {
        $("#berat_total").val($(this).data("set")).trigger("input");
    });

    // --- Pengambilan & pembayaran
    $("input[name=tipe_pembayaran]").on("change", aturStatusPembayaran);
    $("input[name=tipe_pengambilan]").on("change", updateRingkasan);
    aturStatusPembayaran();
    updateRingkasan();
    hitungTotal();

    // Halaman dimuat ulang karena error validasi: pulihkan kategori terpilih
    const kategoriLama = $("#id_kategori").val();
    if (kategoriLama) {
        $("#modal-kategori [onclick^=\"pilihKategori('" + kategoriLama + "'\"]")
            .first()
            .trigger("click");
    }

    // --- Validasi sebelum simpan
    $("#form-paket").on("submit", function (e) {
        hitungTotal();

        if (modeCustomer === "lama" && !$("#id_customer").val()) {
            e.preventDefault();
            notify(
                'Pilih customer dari daftar, atau pilih "Belum pernah" untuk input customer baru.',
            );
            return;
        }
        if (modeCustomer === "baru" && !$.trim($("#nama_customer").val())) {
            e.preventDefault();
            notify("Nama customer baru wajib diisi.");
            $("#nama_customer").trigger("focus");
            return;
        }
        if (!$("#id_kategori").val()) {
            e.preventDefault();
            notify("Pilih tipe laundry terlebih dahulu.");
            return;
        }
        const total = parseInt($("#total_harga_hidden").val(), 10) || 0;
        if (total <= 0) {
            e.preventDefault();
            notify("Total harga belum dihitung. Isi berat laundry.");
            $("#berat_total").trigger("focus");
            return;
        }

        // cegah klik ganda
        $(".btn-simpan")
            .prop("disabled", true)
            .html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');
    });
});

/* ---------- Tipe laundry ---------- */
function tampilKategori() {
    $("#modal-kategori").modal("show");
}

function pilihKategori(id, nama, berat, harga) {
    $("#id_kategori").val(id);
    $("#nama_kategori").val(nama);
    $("#harga").val(harga);

    $("#kategori-judul").text(nama);
    $("#kategori-sub").text(
        rupiah(parseFloat(harga)) +
            " / Kg" +
            (parseFloat(berat) > 0 ? " · minimal " + berat + " Kg" : ""),
    );
    $("#btn-kategori").addClass("terpilih");

    // Kategori TIDAK disimpan di sini. Nilai hanya ditaruh di input hidden
    // #id_kategori dan disimpan sekali saat form disubmit (hanya 1 kategori per transaksi).

    updateRingkasan();
    hitungTotal();
    hideKategori();
}

function hideKategori() {
    $("#modal-kategori").modal("hide");
}
