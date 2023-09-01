<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Makine Yönetimi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            padding: 20px;
            background-color: #3498db;
            color: white;
            margin: 0;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .green {
            color: green;
        }

        .red {
            color: red;
        }

        .add-button {
            display: block;
            width: 150px;
            margin: 20px auto;
            padding: 10px;
            background-color:#3498db;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }

        .add-button:hover {
            background-color: #3498db;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        h2 {
            margin-top: 20px;
            text-align: center;
        }

        form {
            text-align: center;
        }

        form input[type="text"],
        form input[type="submit"] {
            padding: 10px;
            margin: 5px;
        }
        .logout-button {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .logout-button:hover {
            background-color: #3498db;
        }

        /* Admin Anasayfası'na Dön butonu stil */
        .admin-anasayfa-button {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .admin-anasayfa-button:hover {
            background-color: #3498db;
        }
    </style>
</head>
<body>
    <h1>Makine Yönetimi</h1>

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
        $makine_adi = $_POST["makine_adi"];

        // Veritabanına ekleme işlemi
        $sql = "INSERT INTO makine (MakineAdi, durum_id) VALUES ('$makine_adi', 2)";
        if ($conn->query($sql) === TRUE) {
            echo "<p class='success'>Makine başarıyla eklendi.</p>";
        } else {
            echo "<p class='error'>Hata: " . $sql . "<br>" . $conn->error . "</p>";
        }
    }

    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];
        $delete_sql = "DELETE FROM makine WHERE MakineID = $delete_id";
        if ($conn->query($delete_sql) === TRUE) {
            echo "<p class='success'>Makine başarıyla silindi.</p>";
        } else {
            echo "<p class='error'>Hata: " . $delete_sql . "<br>" . $conn->error . "</p>";
        }
    }

    // Makine verilerini çekme sorgusu
    $makine_sql = "SELECT m.MakineID, m.MakineAdi, d.durum_adi 
                   FROM makine m
                   LEFT JOIN durum d ON m.durum_id = d.durum_id";
    $makine_result = $conn->query($makine_sql);

    if ($makine_result->num_rows > 0) {
        // Verileri tablo olarak görüntüleme
        echo "<table>
                <tr>
                    <th>Makine Adı</th>
                    <th>Durum</th>
                    <th>İşlem</th>
                </tr>";
        while ($row = $makine_result->fetch_assoc()) {
            $makine_id = $row["MakineID"];
            $makine_adi = $row["MakineAdi"];
            $durum_adi = $row["durum_adi"];
            $durum_renk = ($durum_adi == "Çalışıyor") ? "green" : "red";

            echo "<tr>
                    <td>$makine_adi</td>
                    <td class='$durum_renk'>$durum_adi</td>
                    <td>
                        <a href='?delete_id=$makine_id' class='delete-button'>Sil</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Makine verisi bulunamadı.</p>";
    }

    $conn->close();
    ?>

    <h2>Makine Ekle</h2>
    <form method="POST">
        <input type="text" name="makine_adi" placeholder="Makine Adı" required>
        <input type="submit" value="Ekle">
        <div style="text-align: center; margin-top: 20px;">
        <a href="logout.php" class="logout-button">Logout</a>
        <a href="index.php" class="admin-anasayfa-button"> Ana Sayfaya Dön</a>
    </div>
    </form>
</body>
</html>
