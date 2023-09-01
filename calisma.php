<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Çalışma Yönetimi</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Çalışma Yönetimi</h1>
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
            $makine_id = $_POST["makine_id"];
            $parca_id = $_POST["parca_id"];
            $personel_id = $_POST["personel_id"];
            $baslama_tarihi = $_POST["baslama_tarihi"];
            $bitis_tarihi = $_POST["bitis_tarihi"];
            $tahmini_sure = $_POST["tahmini_sure"];
            $gercek_sure = $_POST["gercek_sure"];
            $kalip_id = $_POST["kalip_id"];

            // Veritabanına ekleme işlemi
            $sql = "INSERT INTO calisma (MakineID, ParcaID, PersonelID, BaslamaTarihi, BitisTarihi, TahminiSure, GercekSure, KalipID)
                    VALUES ('$makine_id', '$parca_id', '$personel_id', '$baslama_tarihi', '$bitis_tarihi', '$tahmini_sure', '$gercek_sure', '$kalip_id')";
            if ($conn->query($sql) === TRUE) {
                echo "<p class='success'>Çalışma başarıyla eklendi.</p>";
            } else {
                echo "<p class='error'>Hata: " . $sql . "<br>" . $conn->error . "</p>";
            }
        }

        if (isset($_GET['delete_id'])) {
            $delete_id = $_GET['delete_id'];
            $delete_sql = "DELETE FROM calisma WHERE CalismaID = $delete_id";
            if ($conn->query($delete_sql) === TRUE) {
                echo "<p class='success'>Çalışma başarıyla silindi.</p>";
            } else {
                echo "<p class='error'>Hata: " . $delete_sql . "<br>" . $conn->error . "</p>";
            }
        }

        // Çalışma verilerini çekme sorgusu
        $calisma_sql = "SELECT * FROM calisma";
        $calisma_result = $conn->query($calisma_sql);

        if ($calisma_result->num_rows > 0) {
            // Verileri tablo olarak görüntüleme
            echo "<table>
                    <tr>
                        <th>Çalışma ID</th>
                        <th>Makine ID</th>
                        <th>Parça ID</th>
                        <th>Personel ID</th>
                        <th>Başlama Tarihi</th>
                        <th>Bitiş Tarihi</th>
                        <th>Tahmini Süre</th>
                        <th>Gerçek Süre</th>
                        <th>Kalıp ID</th>
                        <th>İşlem</th>
                    </tr>";
            while ($row = $calisma_result->fetch_assoc()) {
                $calisma_id = $row["CalismaID"];
                $makine_id = $row["MakineID"];
                $parca_id = $row["ParcaID"];
                $personel_id = $row["PersonelID"];
                $baslama_tarihi = $row["BaslamaTarihi"];
                $bitis_tarihi = $row["BitisTarihi"];
                $tahmini_sure = $row["TahminiSure"];
                $gercek_sure = $row["GercekSure"];
                $kalip_id = $row["KalipID"];

                echo "<tr>
                        <td>$calisma_id</td>
                        <td>$makine_id</td>
                        <td>$parca_id</td>
                        <td>$personel_id</td>
                        <td>$baslama_tarihi</td>
                        <td>$bitis_tarihi</td>
                        <td>$tahmini_sure</td>
                        <td>$gercek_sure</td>
                        <td>$kalip_id</td>
                        <td><a href='?delete_id=$calisma_id' class='delete-button'>Sil</a></td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Çalışma verisi bulunamadı.</p>";
        }

        $conn->close();
        ?>

        <h2>Çalışma Ekle</h2>
        <form method="POST">
            <input type="text" name="makine_id" placeholder="Makine ID" required>
            <input type="text" name="parca_id" placeholder="Parça ID" required>
            <input type="text" name="personel_id" placeholder="Personel ID" required>
            <input type="text" name="baslama_tarihi" placeholder="Başlama Tarihi" required>
            <input type="text" name="bitis_tarihi" placeholder="Bitiş Tarihi" required>
            <input type="text" name="tahmini_sure" placeholder="Tahmini Süre" required>
            <input type="text" name="gercek_sure" placeholder="Gerçek Süre" required>
            <input type="text" name="kalip_id" placeholder="Kalıp ID" required>
            <input type="submit" value="Ekle">
        </form>

        <div style="text-align: center; margin-top: 20px;">
            <a href="logout.php" class="logout-button">Log Out</a>
            <a href="index.php" class="admin-anasayfa-button">Ana Sayfaya Dön</a>
        </div>
    </div>
</body>
</html>
