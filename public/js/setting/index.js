$(function () {
    showData();

    $(".form-setting")
        .validator()
        .on("submit", function (e) {
            if (!e.preventDefault()) {
                $.ajax({
                    url: $(".form-setting").attr("action"),
                    type: $(".form-setting").attr("method"),
                    data: new FormData($(".form-setting")[0]),
                    async: false,
                    processData: false,
                    contentType: false,
                })
                    .done((response) => {
                        showData();
                        $(".alert").fadeIn();

                        setTimeout(() => {
                            $(".alert").fadeOut();
                        }, 3000);
                    })
                    .fail((errors) => {
                        alert("Tidak dapat menyimpan data");
                        return;
                    });
            }
        });
});

function showData() {
    $.get(window.settingShowUrl)
        .done((response) => {
            $("[name=nama_perusahaan]").val(response.nama_perusahaan);
            $("[name=telepon]").val(response.telepon);
            $("[name=email]").val(response.email);
            $("[name=alamat]").val(response.alamat);
            $("[name=tipe_nota]").val(response.tipe_nota);
            $("title").text(response.nama_perusahaan + " | Pengaturan");

            let words = response.nama_perusahaan.split(" ");
            let word = "";
            words.forEach((w) => {
                word += w.charAt(0);
            });
            $(".logo-mini").text(word);
            $(".logo-lg").text(response.nama_perusahaan);

            $(".tampil-logo").html(
                `<img src="${window.baseUrl}${response.path_logo}" width="200">`,
            );
            $("[rel=icon]").attr(
                "href",
                `${window.baseUrl}${response.path_logo}`,
            );
        })
        .fail((errors) => {
            alert("Tidak dapat menampilkan data");
            return;
        });
}
