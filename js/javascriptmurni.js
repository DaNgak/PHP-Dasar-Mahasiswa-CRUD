// Ambil element yang dibutuhkan
let caridata = document.getElementById("caridata");
let container = document.getElementById("container");
let tombolbutton = document.getElementById("tombolcari");
console.log("ok");
alert("ngapain kamu ");
caridata.addEventListener("keyup", function () {
    // Buat objex ajax
    let xhr = new XMLHttpRequest();

    // Cek kesiapan ajax
    // Gunakan objex ajax .onreadystatechange yang berisikan function
    // dan didalam functionnya gunakan readyState untuk melihat apakah ajaxnya jalan atau tidak
    // Valuenya mulai dari 0 sampai 4 jika 4 berarti ajax sudah siap pakai
    // Untuk status valuenya 200 kalau selain 200, misalnya 404 berarti ajax tidak siap pakai
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Didalam pengkondisian jika ajaxnya ready maka ubah apa yang ada didalam container dengan response ajaxnya
            container.innerHTML = xhr.responseText;
        }
    };

    // eksekusi ajax
    // Menggunakan ajax.open dengan 3 parameter, yaitu
    // 1. Method yang digunakan GET atau POST
    // 2. Lokasi sumber data yang diambil
    // 3. Pilih syncronus atau Asyncronus, jika syncronus isi false jika Asyncronus isi true
    xhr.open("GET", "ajax/datamahasiswa.php?keyword=" + caridata.value, true);
    xhr.send();
});
