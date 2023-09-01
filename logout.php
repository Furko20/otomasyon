<?php
session_start();

// Oturumu sonlandır ve oturum verilerini temizle
session_unset();
session_destroy();

// Giriş sayfasına yönlendir
header('Location: login.html');
exit();
?>
