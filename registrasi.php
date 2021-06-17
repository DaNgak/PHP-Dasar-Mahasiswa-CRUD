<?php 

    session_start();
    if ( isset($_SESSION["login"]) ){
        header("Location: index.php");
    }

    require 'functions.php';
    if ( isset($_POST["register"]) ) {
        if (registrasi($_POST) > 0) {
            echo "<script>
                alert('User Baru Berhasil Ditambahkan!!!');
            </script>";
        } else {
            mysqli_error($conn);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Register Page</title>
    </head>
    <body>
        <h1>Halaman Registrasi</h1>
        <p>Back to  <a href="login.php">Login</a></p>
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
                    <label for="password2">Konfirmasi Password : </label>
                    <input type="password" placeholder="Re-Password" id="password2" name="password2" required />
                </li>
                <button type="submit" name="register">Register!!</button>
            </ul>
        </form>
    </body>
</html>
