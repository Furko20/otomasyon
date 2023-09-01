<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <style>
        .tooltip {
            position: absolute;
            background-color: #333;
            color: white;
            padding: 5px;
            border-radius: 3px;
            font-size: 12px;
            z-index: 1;
        }
    </style>
    <title>Parça Yönetimi</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Parça Yönetimi</h1>
        </div>

        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "enelsis";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $parca_adi = $_POST["parca_adi"];
            $boyutlar = $_POST["boyutlar"];
            $gelis_tarihi = $_POST["gelis_tarihi"];
            $malzeme_turu = $_POST["malzeme_turu"];
            $fiyat = $_POST["fiyat"];
            $boyutlar_not = $_POST["boyutlar_not"];

            $insert_sql = "INSERT INTO parca (ParcaAdi, Boyutlar, GelisTarihi, malzeme_turu, fiyat, boyutlar_not) 
                           VALUES ('$parca_adi', '$boyutlar', '$gelis_tarihi', '$malzeme_turu', '$fiyat', '$boyutlar_not')";

            if ($conn->query($insert_sql) === TRUE) {
                echo "<p class='success'>Parça başarıyla eklendi.</p>";
            } else {
                echo "<p class='error'>Hata: " . $insert_sql . "<br>" . $conn->error . "</p>";
            }
        }

        if (isset($_GET['delete_id'])) {
            $delete_id = $_GET['delete_id'];
            $delete_sql = "DELETE FROM parca WHERE ParcaID = $delete_id";
            if ($conn->query($delete_sql) === TRUE) {
                echo "<p class='success'>Parça başarıyla silindi.</p>";
            } else {
                echo "<p class='error'>Hata: " . $delete_sql . "<br>" . $conn->error . "</p>";
            }
        }

        // Parça verilerini çekme sorgusu
        $parca_sql = "SELECT * FROM parca";
        $parca_result = $conn->query($parca_sql);

        if ($parca_result->num_rows > 0) {
            // Verileri tablo olarak görüntüleme
            echo "<table>
                    <tr>
                        <th>Parça Adı</th>
                        <th>Boyutlar</th>
                        <th>Geliş Tarihi</th>
                        <th>Malzeme Türü</th>
                        <th>Fiyat</th>
                        <th>Boyut Notu</th>
                        <th>İşlem</th>
                    </tr>";
            while ($row = $parca_result->fetch_assoc()) {
                $parca_id = $row["ParcaID"];
                $parca_adi = $row["ParcaAdi"];
                $boyutlar = $row["Boyutlar"];
                $gelis_tarihi = $row["GelisTarihi"];
                $malzeme_turu = $row["malzeme_turu"];
                $fiyat = $row["fiyat"];
                $boyutlar_not = $row["boyutlar_not"];

                echo "<tr>
                        <td>$parca_adi</td>
                        <td onmouseover=\"showNote(this, '$boyutlar_not')\">$boyutlar</td>
                        <td>$gelis_tarihi</td>
                        <td>$malzeme_turu</td>
                        <td>$fiyat</td>
                        <td>$boyutlar_not</td>
                        <td>
                            <a href='?delete_id=$parca_id' class='delete-button'>Sil</a>
                        </td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Parça verisi bulunamadı.</p>";
        }

        $conn->close();
        ?>

        <h2>Parça Ekle</h2>
        <form method="POST">
            <input type="text" name="parca_adi" placeholder="Parça Adı" required>
            <input type="text" name="boyutlar" placeholder="Boyutlar" required>
            <input type="text" name="gelis_tarihi" placeholder="Geliş Tarihi" required>
            <input type="text" name="malzeme_turu" placeholder="Malzeme Türü" required>
            <input type="text" name="fiyat" placeholder="Fiyat" required>
            <input type="text" name="boyutlar_not" placeholder="Boyut Notu">
            <input type="submit" value="Ekle">
        </form>
        <div style="text-align: center; margin-top: 20px;">
            <a href="logout.php" class="logout-button">Log Out</a>
            <a href="index.php" class="admin-anasayfa-button">Ana Sayfaya Dön</a>
        </div>
    </div>
    <script>
         var tooltip = null;

function showNote(element, note) {
    if (note) {
        hideNote();
        tooltip = document.createElement("div");
        tooltip.className = "tooltip";
        tooltip.innerText = note;

        element.appendChild(tooltip);
    }
}
function hideNote() {
    if (tooltip) {
        tooltip.remove();
        tooltip = null;
    }
}
// Not kutusunun görünürlüğünü sadece fare üzerine gelindiğinde görünecek
document.addEventListener("mouseover", function(e) {
    if (e.target.classList.contains("has-tooltip")) {
        var note = e.target.getAttribute("data-note");
        showNote(e.target, note);
    }
});

// Fare başka bir yere gittiğinde not kutusunu gizle
document.addEventListener("mouseout", function(e) {
    hideNote();
});
    </script>
</body>
</html>
