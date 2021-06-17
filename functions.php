<?php
    // Pertama connect kan ke file yang ingin menggunakan database
    // Connectnya dengan menuliskan syntax penghubung di file yang akan digunakan
    // Connectnya ada 2 cara
    // 1. require 'filefunction.php';
    // 2. inclue 'filefunction.php';

    // Buat Koneksi secara Global
    // Ada 4 parameter (tidak boleh tertukar)
    // 1. Localhost
    // 2. Username (untuk xampp usernamenya "root")
    // 3. Password (untuk xampp passwordnya kosong "")
    // 4. Nama Data Base
    $conn = mysqli_connect("localhost", "root", "", "mahasiswa");

    // Membuat Query untuk Menampilkan Data
    function querysql($query) {
        // Mengambil variabel $conn karena terhalang variabel scope
        // Menggunakan sytax global variabel
        global $conn;
        // Mengambil Data dari tabel-tabel di Database dengan Query SQL
        // Parameter ada 2 (tidak boleh tertukar)
        // 1. Koneksi DataBasenya (yang disimpan di variabel $conn)
        // 2. Query SQLnya (disarankan Querynya disimpan divariabel terlebih dahulu)
        $result = mysqli_query($conn, $query);
        // Buat array kosong untuk menampung data dari $result
        $tampungdatabase = [];
        // Setelah itu fetch data dari variabel $result dan fetch kedalam suatu variabel untuk menampung data perbarisnya di database
        // Deklarasikan secara langsung di whilenya agar selama true (ada datanya) akan di looping terus dan dimasikkan ke array $tampungdatabase
        while ($row = mysqli_fetch_assoc($result)) {
            $tampungdatabase[] = $row;
        }
        return $tampungdatabase;
    }

    function tambahdatamhs($datamhs){
        // Mengambil variabel global yaiut $conn 
        global $conn;

        // Menampung data NIM, nama, email kedalam sebuah variabel
        $nim = htmlspecialchars($datamhs["nim"]);
        $nama = htmlspecialchars($datamhs["nama"]);
        $email = htmlspecialchars($datamhs["email"]);
        // Mengubah gambar menjadi hasil return value dari fungsi upload
        $gambar = upload();
        if ( !$gambar ) {
            return false;
        }

        // Membuat Query SQL Insert untuk menambahkan data ke database
        // Untuk id dibiarkan kosong agar databasenya mengisi sendiri (auto_increment)
        $query = "
            INSERT INTO mahasiswa VALUES
            ('', '$nama', '$nim', '$email', '$gambar')
        ";

        // Menjalankan Querynya dengan mysqli_query yang diikuti dua parameter
        // Parameter pertama = Koneksi Databasenya
        // Parameter kedua = Isi Querynya
        $result = mysqli_query($conn, $query);

        // Mengembalikan mysqli_affected_rows yang digunakan untuk mengecek apakah data query tersebut masuk ke database
        // Jika datanya masuk maka mysqli_affected_rows akan bernilai lebih dari 0 (minimal 1)
        // Jika datanya tidak masuk maka mysqli_affected_rows akan bernilai -1
        // Fungsi mysqli_affected_rows memiliki 1 parameter wajib yaitu koneksi databasenya
        return mysqli_affected_rows($conn);
    }

    function hapus($id){
        // Memanggil variabel conn secara global
        global $conn;
        // Membuat Query Hapus
        $query = "DELETE FROM mahasiswa WHERE id = $id";
        // MEngeksekusi Query dengan mysql_querry dengan dua parameter
        // Parameter pertama yaitu koneksi
        // Parameter kedua yaitu isi query nya
        mysqli_query($conn, $query);

        // Return mysqli_affected_rows untuk mengetahui apakah ada baris yang terpengaruhi dari query diatas
        return mysqli_affected_rows($conn);
    }

    function ubahdatamhs($datamhs){
        // Memanggil variabel global conn
        global $conn;

        // Menampung data ke variabel 
        $idmhs = $datamhs["id"];
        $namamhs = htmlspecialchars($datamhs["nama"]);
        $nimmhs = htmlspecialchars($datamhs["nim"]);
        $emailmhs = htmlspecialchars($datamhs["email"]);
        $gambarlama = htmlspecialchars($datamhs["gambarlama"]);

        // Cek apakah user mengganti gambar menjadi gambar baru
        if( $_FILES["gambar"]["error"] === 4 ){
            $gambarmhs = $gambarlama;
        } else {
            $gambarmhs = upload();
        }

        // Membuat Query update data
        $query = "UPDATE mahasiswa SET nama='$namamhs', nim='$nimmhs', email='$emailmhs', gambar='$gambarmhs' WHERE id = $idmhs";

        // Mengeksekusi Query
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }

    function cari($datacari){
        // $query = "SELECT * FROM mahasiswa WHERE nama LIKE '$datacari'";
        $query = "SELECT * FROM mahasiswa WHERE nama LIKE '%$datacari%' OR nim LIKE '%$datacari%' OR email LIKE '%$datacari%'";
        return querysql($query);
    }

    function upload(){
        $namafiles = $_FILES["gambar"]["name"];
        $ukuranfiles = $_FILES["gambar"]["size"];
        $error = $_FILES["gambar"]["error"];
        $tmpfiles = $_FILES["gambar"]["tmp_name"];

        // Cek apakah ada gambar yang di upload
        if ($error === 4) {
            echo "<script>
                alert('Masukkan Gambar Terlebih Dahulu');
            </script>";
        }

        // Cek apakah yang diupload adalah gambar
        $ekstensiGambarvalid = ['jpg', 'jpeg', 'png'];
        $esktensiGambar = explode('.', $namafiles);
        $ekstensiupload = strtolower(end($esktensiGambar));
        if ( !in_array($ekstensiupload, $ekstensiGambarvalid) ) {
            echo "<script>
                alert('Yang Anda Upload Bukan Gambar');
            </script>";
            return false;
        } 

        // Cek Ukuran gambar terlalu besar dalam byte
        if ( $ukuranfiles > 2000000 ){
            echo "<script>
                alert('Size Gambar Terlalu Besar MAX 2 MB');
            </script>";
            return false;
        }

        // Jika tidak ingin nama file gambar sama
        // Generate nama file agar beda
        // $namafilerandom = uniqid();
        // $namafilerandom .= '.';
        // $namafilerandom .= $ekstensiupload;
        // echo $namafilerandom;

        // Setelah Lolos Pengecekan, Gambar Siap Diupload
        // Tempat Uploadnya relatif terhadap direktori tempat file ini dicoding 
        // (contoh sekarang ada di file phpdasar/pertemuan11upload/)
        move_uploaded_file($tmpfiles, 'img/'. $namafiles);

        return $namafiles;
    }

    function registrasi($datauser){
        global $conn;

        // Mengubah Username Menjadi 
        // 1. Huruf Kecil Semua = strtolower()
        // 2. Menghindari User memasukkan tanda strip/minus = stripcslashes()
        // 3. Menghindari User memasukkan HTML ke username = htmlspecialchars()
        $username = strtolower(stripcslashes(htmlspecialchars($datauser["username"])));

        // Menghindari Error ketika Insert data ke data base jika di passwordnya 
        // user menginputkan tanda petik atau petik dua (' atau ") = mysqli_real_escape_string()
        $password = mysqli_real_escape_string($conn ,$datauser["password"]);
        $password2 = mysqli_real_escape_string($conn ,$datauser["password2"]);

        // Cek apakah Username sudah ada apa belum di database
        $result = mysqli_query($conn, "SELECT username FROM user WHERE username='$username'");
        if (mysqli_fetch_assoc($result)) {
            echo "<script>
                alert('Username Sudah Terdaftar!!!');
            </script>";
            return false;
        }

        // Cek apakah password dan konfirmasi password sama
        if ( $password != $password2){
            echo "<script>
                alert('Password Tidak Sesuai!!!');
            </script>";
            return false;
        }

        // Enkripsi Password
        // menggunakan Method password_hash() yang punya dua parameter wajib
        // 1. Variabel yang mau di hash atau di enkripsi
        // 2. Algoritma Pengacakannya
        // Jika ingin gunakan enkripsi nyalakan commentnya
        // $password = password_hash($password, PASSWORD_DEFAULT);

        // Insert data ke databasee
        $query = "INSERT INTO user VALUES ('', '$username', '$password')";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }

    
?>