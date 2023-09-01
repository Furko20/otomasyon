<?php
// Veritabanı bağlantısı için gerekli bilgileri buraya girin
$servername = "localhost";
$username = "root"; // Kullanıcı adınız
$password = ""; // Şifreniz
$dbname = "enelsis"; // Veritabanı adı

// Veritabanına bağlan
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Veritabanı bağlantısında hata oluştu: " . $conn->connect_error);
}

// Formdan verileri al
$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

// Şifreyi hash'le
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Kullanıcıyı users tablosuna ekle
$sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashedPassword', '$role')";
if ($conn->query($sql) === TRUE) {
    echo "Kullanıcı başarıyla eklendi.";
} else {
    echo "Hata: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
