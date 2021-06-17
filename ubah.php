<?php
    session_start();
    if ( !isset($_SESSION["login"]) ){
        header("Location: login.php");
        exit;
    }

    // Koneksi dengan file functions.php untuk mengambil fungsinya 
    require 'functions.php';

    if ( !isset($_GET["id"]) ){ 
        header("Location: index.php");
        exit;
    }
    // Ambil data ID yang dikirim dari index.php melalui method get(lewat URL)
    $id = $_GET["id"];

    // Query data mahasiswa berdasarkan id
    $mhsedit = querysql("SELECT * FROM mahasiswa WHERE id = $id");
    // Melakukan pengecekan apakah tombol submit sudah ditekan
    if ( isset($_POST["submit"])) {
        // Melakukan pengecekan apakah datanya berhasil diubah atau tidak di database
        if( ubahdatamhs($_POST) > 0){
            echo "<script>
                alert('Data Berhasil Diubah');
                document.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Data Gagal Diubah');
            </script>";
            echo mysqli_error($conn);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Mahasiswa Page</title>
</head>
<body>
    <h1>Ubah Data Mahasiswa</h1>
    <br>
    <a href="admin.php"><h1>Kembali ke Home Page</h1></a>
    <br>
    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <input type="hidden" value="<?= $mhsedit[0]["id"] ?>" name="id">
            <input type="hidden" value="<?= $mhsedit[0]["gambar"] ?>" name="gambarlama">
            <li>
                <label for="nim">NIM Mahasiswa : </label>
                <input type="text" value="<?= $mhsedit[0]["nim"] ?>" placeholder="nim" id="nim" name="nim" minlength="10" maxlength="10" required>
            </li>
            <li>
                <label for="nama">Nama Mahasiswa : </label>
                <input type="text" value="<?= $mhsedit[0]["nama"] ?>" placeholder="nama" id="nama" name="nama" required>
            </li>
            <li>
                <label for="email">Email Mahasiswa : </label>
                <input type="email" value="<?= $mhsedit[0]["email"] ?>" placeholder="email" name="email" id="email" required>
            </li>
            <li>
                <label for="gambar">Gambar Mahasiswa : </label><br>
                <img src="img/<?= $mhsedit[0]["gambar"] ?>" alt="" width="200" height="200"> <br>
                <input type="file" value="<?= $mhsedit[0]["gambar"] ?>" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Kirim</button>
            </li>
        </ul>
    </form>
</body>
</html>