<?php
    session_start();
    if ( !isset($_SESSION["login"]) ){
        header("Location: login.php");
        exit;
    }

    // Koneksi dengan file functions.php untuk mengambil fungsinya 
    require 'functions.php';
    // Melakukan pengecekan apakah tombol submit sudah ditekan



    if ( isset($_POST["submit"])) {

        // // Melihat isi dari variabel $POST 
        // var_dump($_POST);
        // echo 'Isi $_FILES Pisah';
        // var_dump($_FILES);
        
        // // Menghentikan program (di bawah die tidak dijalankan)
        // die;

        // Melakukan pengecekan apakah datanya berhasil dimasukkan ke database
        if( tambahdatamhs($_POST) > 0){
            echo "<script>
                alert('Data Berhasil DItambahkan');
                document.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Data Gagal Ditambahkan');
            </script>";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa Page</title>
</head>
<body>
    <h1>Tambah Data Mahasiswa</h1>
    <br>
    <a href="index.php"><h1>Kembali ke Home Page</h1></a>
    <br>
    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="nim">NIM Mahasiswa : </label>
                <input type="text" placeholder="nim" id="nim" name="nim" minlength="10" maxlength="10" required>
            </li>
            <li>
                <label for="nama">Nama Mahasiswa : </label>
                <input type="text" placeholder="nama" id="nama" name="nama" required>
            </li>
            <li>
                <label for="email">Email Mahasiswa : </label>
                <input type="email" placeholder="email" name="email" id="email" required>
            </li>
            <li>
                <label for="gambar">Gambar Mahasiswa : </label>
                <input type="file" name="gambar" id="gambar" required>
            </li>
            <li>
                <button type="submit" name="submit">Kirim</button>
            </li>
        </ul>
    </form>
</body>
</html>