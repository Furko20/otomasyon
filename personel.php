<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Çalışan Yönetimi</title>
    <style>
        /* Stil burada */
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Çalışan Yönetimi</h1>
        </div>
        <?php
// Veritabanı bağlantısı
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "enelsis";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri al
    $ad = $_POST["ad"];
    $soyad = $_POST["soyad"];
    $sifre = $_POST["sifre"];

    // Şifreyi hashleyerek kaydet
    $hashedSifre = password_hash($sifre, PASSWORD_DEFAULT);

    // Veritabanına ekleme işlemi
    $sql = "INSERT INTO personel (Ad, Soyad, password_hash) VALUES ('$ad', '$soyad', '$hashedSifre')";
    if ($conn->query($sql) === TRUE) {
        echo "<p class='success'>Çalışan başarıyla eklendi.</p>";
    } else {
        echo "<p class='error'>Hata: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM personel WHERE PersonelID = $delete_id";
    if ($conn->query($delete_sql) === TRUE) {
        echo "<p class='success'>Çalışan başarıyla silindi.</p>";
    } else {
        echo "<p class='error'>Hata: " . $delete_sql . "<br>" . $conn->error . "</p>";
    }
}

// Personel verilerini çekme sorgusu
$personel_sql = "SELECT * FROM personel";
$personel_result = $conn->query($personel_sql);

if ($personel_result->num_rows > 0) {
    // Verileri tablo olarak görüntüleme
    echo "<table>
            <tr>
                <th>Ad</th>
                <th>Soyad</th>
                <th>İşlem</th>
            </tr>";
    while ($row = $personel_result->fetch_assoc()) {
        $personel_id = $row["PersonelID"];
        $ad = $row["Ad"];
        $soyad = $row["Soyad"];

        echo "<tr>
                <td>$ad</td>
                <td>$soyad</td>
                <td>
                    <a href='?delete_id=$personel_id' class='delete-button'>Sil</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Çalışan verisi bulunamadı.</p>";
}

$conn->close();
?>

<h2>Çalışan Ekle</h2>
<form method="POST">
    <div style="text-align: center;">
        <div style="display: inline-block; text-align: center;">
            <input type="text" name="ad" placeholder="Ad" required>
            <input type="text" name="soyad" placeholder="Soyad" required>
            <input type="password" name="sifre" placeholder="Şifre" required>
            <input type="submit" value="Ekle">
        </div>
    </div>
</form>

<div style="text-align: center; margin-top: 20px;">
    <a href="logout.php" class="logout-button">Log Out</a>
    <a href="index.php" class="admin-anasayfa-button">Ana Sayfaya Dön</a>
</div>
</div>
</body>
</html>

        
    </div>
</body>
</html>