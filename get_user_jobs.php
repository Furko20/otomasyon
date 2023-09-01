<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "enelsis";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Veritabanı bağlantısında hata oluştu: " . $conn->connect_error);
}

if (isset($_GET["user_id"])) {
    $user_id = $_GET["user_id"];

    // Kullanıcının işlerini çek
    $jobs_sql = "SELECT * FROM isler WHERE User_ID = ?";
    $stmt = $conn->prepare($jobs_sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p>" . $row["Tur"] . " - Süre: " . $row["Sure"] . " dakika - Açıklama: " . $row["Aciklama"] . "</p>";
        }
    } else {
        echo "<p>Bu kullanıcının işleri bulunmuyor.</p>";
    }
} else {
    echo "<p>Kullanıcı ID bulunamadı.</p>";
}

$stmt->close();
$conn->close();
?>
