<?php

    // Gunakan session agar saat user belum login dikembalikan ke halaman login secara paksa
    session_start();
    if ( !isset($_SESSION["login"]) ) {
        header("Location: login.php");
        exit;
    }



    // Koneksi ke database (Cara Baru dengan Function agar lebih Modular)
    // Jika ingin lihat Cara Lama bisa cek index2.php
    // Penjelasan Detail Syntaxnya ada di index2.php

    // Koneksikan file ini ke function.php dengan require ataupun include
    require 'functions.php';

    // Buat querynya untuk dimasukkan ke parameter fungsi querysql
    $query = "SELECT * FROM mahasiswa ORDER BY id DESC";
    
    // Panggil fungsi queryl di function php dan tampung ke variabel untuk menampung nilai return fungsi querysql, yaitu variabel $tampungdatabase
    $mhsiswa = querysql($query);

    if( isset($_POST["submit"])){
        // Tampung variabel $_POST dengan key cari
        $datacari = $_POST["cari"];

        // Cara 1 langsung menggunakan query di halaman ini dan dieksekusi langsung
        // $query = "SELECT * FROM mahasiswa WHERE nama LIKE '%$datacari%' OR nim LIKE '%$datacari%' OR email LIKE '%$datacari%'";
        // $mhsiswa = querysql($query);

        // Cara 2 membuat fungsi cari pada functions.php dan nanti dikembalikan querynya yang sudah di eksekusi dengan fungsi querysql();
        $mhsiswa = cari($datacari);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <style>
        img#loader{
            position: absolute;
            z-index: -1;
            left: 220px;
            top : 190px;
            display: none;
        }
    </style>
</head>
<body>
    <h1>Ini index.php</h1>
    <h1>Selamat Datang Admin</h1>
    <br>
    <h3>Daftar Mahasiswa</h3>
    <form action="" method="post">
        <label for="caridata">Cari Berdasarkan Nama atau NIM atau Email</label><br>
        <input type="text" size="40" autofocus autocomplete="off" name="cari" id="caridata" placeholder="Cari Data Mahasiswa : ">
        <!-- Matikan Tombol cari karena menggnakan AJAX / Live Search -->
        <!-- <button name="submit" id="tombolcari">Cari!!!</button> -->
        <img src="img/loader.png" alt="Loader" id="loader" width="200" heigth="200">
    </form>
    <br>
    <a href="tambah.php">Tambah Data Mahasiswa</a>
    <br><br><br>
    <div id="container">
        <table style="text-align:center;" border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>Nomer</th>
                <th>Nama</th>
                <th>NIM</th>
                <th>Email</th>
                <th>Gambar</th>
                <th colspan="2">Aksi</th>
                
            </tr>
            <?php $i = 1; ?>   
            <?php foreach ($mhsiswa as $mhs) : ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $mhs["nama"] ?></td>
                    <td><?= $mhs["nim"] ?></td>
                    <td><?= $mhs["email"] ?></td>
                    <td><img src="img/<?= $mhs["gambar"] ?>" alt=" <?= $mhs["gambar"] ?>" width="200" height="200"></td>
                    <td><a href="ubah.php?id=<?= $mhs["id"] ?>">edit</a></td>
                    <td><a href="hapus.php?id=<?= $mhs["id"] ?>" onclick="return confirm('Konfirmasi Hapus')">delete</a></td>
                    <?php $i++; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <br><br>
    <a href="logout.php">Logout</a>
    <br><br>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/javascriptjsquery.js"></script>
</body>
</html>