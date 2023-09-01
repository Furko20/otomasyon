<?php
// Veritabanı bağlantısı ve oturum işlemleri
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "enelsis";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Veritabanı bağlantısında hata oluştu: " . $conn->connect_error);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ? AND role = 'personel'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['rol'] = 'personel';
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] =  $row["id"];
            header('Location: is_ekle.php');
            exit();
        } else {
            echo "Giriş Başarısız. Lütfen Kullanıcı Adı ve Şifrenizi Kontrol Edin.";
        }
    } else {
        echo "Kullanıcı Bulunamadı.";
    }
}
?>
