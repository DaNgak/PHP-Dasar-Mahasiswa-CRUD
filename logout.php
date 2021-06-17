<?php 
    // Hapus Session
    session_start();
    $_SESSION = [];
    session_unset();
    session_destroy();

    // Hapus Cookie
    setcookie('testlogin', '', time()-3600);
    setcookie('keylogin', '', time()-3600);

    header("Location: login.php");
    exit;
?>