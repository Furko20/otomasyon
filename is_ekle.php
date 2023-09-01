<?php
session_start();

// Veritabanı bağlantısı ve oturum işlemleri
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "enelsis";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Veritabanı bağlantısında hata oluştu: " . $conn->connect_error);
}

// Kullanıcının user_id değerini döndüren fonksiyon
function getUserID($link, $username)
{
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['id'];
    }

    return null;
}
$showTimer = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tur"]) && isset($_POST["sure"]) && isset($_POST["makine"])) {
    // Veritabanına bağlan
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $showTimer = true;
    $remainingTime = $_POST["sure"] * 60;

    // Verileri al
    $tur = $_POST["tur"];
    $sure = $_POST["sure"];
    $makine_id = $_POST["makine"];
    $aciklama = $_POST["aciklama"];
    $username = $_SESSION['username']; // Oturum açılan kullanıcının "username" değeri
    $user_id = getUserID($conn, $username); // Kullanıcının "id" değeri

    // SQL sorgusu
    $insert_sql = "INSERT INTO isler (User_ID, MakineID, Tur, Sure, Aciklama) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("iiiss", $user_id, $makine_id, $tur, $sure, $aciklama);

    if ($stmt->execute()) {
        echo "<p class='success'>İş başarıyla eklendi.</p>";
    } else {
        echo "<p class='error'>Hata: " . $stmt->error . "</p>";
    }

    // Bağlantıyı kapat
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Durum Bildirimi</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        select, input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 5px;
        }

        textarea {
            resize: vertical;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        .logout-button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Durum Bildirimi</h1>
        </div>

        <h2>Hoş geldiniz, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?></h2>

        <h2>Durum Bildirimi</h2>
        <form method="POST">
        <label for="makine">Makine:</label>
            <select name="makine" id="makine" required>
                <?php
                // Veritabanından makineleri çekip listeme
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "enelsis";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $makine_sql = "SELECT MakineID, MakineAdi FROM makine";
                $makine_result = $conn->query($makine_sql);

                if ($makine_result->num_rows > 0) {
                    while ($row = $makine_result->fetch_assoc()) {
                        echo "<option value='" . $row["MakineID"] . "'>" . $row["MakineAdi"] . "</option>";
                    }
                }
                ?>
            </select>
            <br>
            <label for="tur">Durum Seçiniz</label>
            <select name="tur" id="tur" required>
                <option value="ariza">Arıza</option>
                <option value="sigara">Sigara Molası</option>
                <option value="takim">Takım Değişimi</option>
                <option value="elmas">Elmas Değişimi</option>
                <option valur="namaz">Namaz</option>
                <option value="diğer">Diğer</option>
                <!-- Diğer seçenekleri buraya ekleyebilirsiniz -->
            </select>
            <br>
            <label for="sure">Süre (dakika):</label>
            <input type="number" name="sure" id="sure" required>
            <br>
            
            <label for="aciklama">Açıklama:</label>
            <textarea name="aciklama" id="aciklama" rows="4"></textarea>
            <br>
            <input type="submit" value="Ekle">
        </form>

        <div style="text-align: center; margin-top: 20px;">
            <a href="logout.php" class="logout-button">Çıkış Yap</a>
        </div>
    </div>
    <script>
        <?php if ($showTimer): ?>
        var remainingTime = <?php echo $remainingTime; ?>;
        var timerInterval = setInterval(function() {
            var minutes = Math.floor(remainingTime / 60);
            var seconds = remainingTime % 60;

            document.getElementById("timer").innerHTML = minutes + " dakika " + seconds + " saniye";

            if (remainingTime === 0) {
                clearInterval(timerInterval);
                document.getElementById("timer").style.display = "none";
            }
            remainingTime--;
        }, 1000);
        <?php endif; ?>
    </script>
    <body>
    <div class="container">
        <?php if ($showTimer): ?>
        <p id="timer" style="text-align: center; font-weight: bold; font-size: 18px;">Süre: <?php echo $remainingTime; ?> saniye</p>
        <?php endif; ?>
    </div>
</body>
</body>

</html>
