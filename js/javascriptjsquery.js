console.log("JQUERY/AJAX ok");
// Jika menggunakan JQuery menggunakan $(document) untuk mengambil objek yang di manipulasi
// Jika ingin mengambil suatu elemen di HTML maka gunakan $("#selector")
// $("#selector") ini menggunakan querySelector() yang berarti harus menyertakan "#" jika id dan "." jika class
$(document).ready(function () {
    $("#caridata").on("keyup", function () {
        //  Munculkan gambar loadingnya
        $("#loader").show();

        // ajax menggunakan method load (kurang recomended)
        // menggunakan load hanya bisa mengambil data satu kata tidak bisa spasi
        // $("#container").load("ajax/datamahasiswa.php?keyword=" + $("#caridata").val());

        // ajax menggunakan get
        $.get("ajax/datamahasiswa.php?keyword=" + $("#caridata").val(), function (data) {
            // InnerHTML di JQuery yaitu nama objeknya diberi method html(data)
            // dan parameternya adalah data yang di innerkan ke objeknya $("#selector").html(data);
            $("#container").html(data);
            // Menghilangkan objek atau tag di HTML dengan hide
            $("#loader").hide();
        });
    });
});
