<?php 

    // Untuk memulai menggunakan session gunakan session_start, jika ingin 
    // menghapus session gunakan session_destroy
    session_start();
    require 'functions.php';

    // Cek terlebih dahulu apakah cookie sudah pernah dibuat atau belum
    if ( isset($_COOKIE["testlogin"]) && isset($_COOKIE["keylogin"]) ){
        $id = $_COOKIE["testlogin"];
        $key = $_COOKIE["keylogin"];

        $result = mysqli_query($conn, "SELECT username FROM user WHERE id='$id'");
        $row = mysqli_fetch_assoc($result);

        if ( $key == hash('sha256', $row["username"]) ) {
            $_SESSION["login"] = true;
        }
    }


    if ( isset($_SESSION["login"]) ){
        header("Location: index.php");
        exit;
    }
    

    if ( isset($_POST["login"]) ) {
        $username = strtolower($_POST["username"]);
        $password = strtolower($_POST["password"]);
        $cekusername = "SELECT * FROM user WHERE username='$username'";
        $result = mysqli_query($conn, $cekusername);
        $row = mysqli_fetch_assoc($result);
        if ($row){
            if ($row["username"] === $username && $row["password"] === $password){
                $_SESSION["login"] = true;
                echo "<script>
                        alert('Selamat Anda Berhasil Login');
                    </script>";

                // Cek Untuk remember me dan set cookie
                if ( isset($_POST["rememberme"]) ){
                    $id = $row["id"];
                    $usernameenkripsi = $row["username"];
                    setcookie('testlogin', $id, time()+300);
                    setcookie('keylogin', hash('sha256', $usernameenkripsi), time()+300);
                }

                header("Location: index.php");
                exit;
            }
        }
        echo "<script>
                alert('Login Gagal');
            </script>";
    }   
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Login Page</title>
    </head>
    <body>
        <h1>Halaman Login</h1>
        <p>Belum Punya Akun ???  <a href="registrasi.php">Registrasi Sekarang !!!</a></p>
        <form action="" method="post">
            <ul>
                <li>
                    <label for="username">Username : </label>
                    <input type="text" placeholder="Username" id="username" name="username" required />
                </li>
                <li>
                    <label for="password">Password : </label>
                    <input type="password" placeholder="Password" id="password" name="password" required />
                </li>
                <li>
                    <input type="checkbox" id="rememberme" name="rememberme"/>
                    <label for="rememberme">Remember Me </label>
                </li>
                <button type="submit" name="login">Login!!</button>
            </ul>
        </form>
    </body>
</html>
