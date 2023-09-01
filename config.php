<?php
$servername = "localhost"; // Sunucu adı 
$username = "root"; // Veritabanı kullanıcı adı
$password = ""; // Veritabanı parolası
$dbname = "enelsis"; // Veritabanı adı

// Veritabanı bağlantısı 
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol etme
if ($conn->connect_error) {
    die("Veritabanına bağlantı hatası: " . $conn->connect_error);
}
?>
