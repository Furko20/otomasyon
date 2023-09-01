<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Yukarıdaki stil kodlarını buraya ekleyebilirsiniz */
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
    <title>Kalıp Yönetimi</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Kalıp Yönetimi</h1>
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
            $kalip_adi = $_POST["kalip_adi"];
            $makine_id = $_POST["makine_id"];
            $parca_sayisi = $_POST["parca_sayisi"];
            $kalip_not = $_POST["kalip_not"];

            $ekle_sql = "INSERT INTO kalip (KalipAdi, MakineID, ParcaSayisi, KalipNot) 
                         VALUES ('$kalip_adi', '$makine_id', '$parca_sayisi', '$kalip_not')";
            if ($conn->query($ekle_sql) === TRUE) {
                echo "<p class='success'>Kalıp başarıyla eklendi.</p>";
            } else {
                echo "<p class='error'>Hata: " . $ekle_sql . "<br>" . $conn->error . "</p>";
            }
        }

        $kalip_result = null;

        $kalip_sql = "SELECT * FROM kalip";
        $kalip_result = $conn->query($kalip_sql);

        ?>

        <h2>Kalıp Ekle</h2>
        <form method="POST">
            <input type="text" name="kalip_adi" placeholder="Kalıp Adı" required>
            <input type="text" name="makine_id" placeholder="Makine ID" required>
            <input type="text" name="parca_sayisi" placeholder="Parça Sayısı" required>
            <input type="text" name="kalip_not" placeholder="Kalıp Notu">
            <input type="submit" value="Ekle">
        </form>

        <?php
        if ($kalip_result && $kalip_result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>Kalıp Adı</th>
                        <th>Makine ID</th>
                        <th>Parça Sayısı</th>
                        <th>İşlem</th>
                    </tr>";
            while ($row = $kalip_result->fetch_assoc()) {
                $kalip_id = $row["KalipID"];
                $kalip_adi = $row["KalipAdi"];
                $makine_id = $row["MakineID"];
                $parca_sayisi = $row["ParcaSayisi"];
                $kalip_not = $row["KalipNot"];

                echo "<tr>
                        <td class='has-tooltip' data-note='$kalip_not'>$kalip_adi</td>
                        <td>$makine_id</td>
                        <td>$parca_sayisi</td>
                        <td>
                            <a href='?delete_id=$kalip_id' class='delete-button'>Sil</a>
                        </td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Kalıp verisi bulunamadı.</p>";
        }

        $conn->close();
        ?>

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

        document.addEventListener("mouseover", function(e) {
            if (e.target.classList.contains("has-tooltip")) {
                var note = e.target.getAttribute("data-note");
                showNote(e.target, note);
            }
        });

        document.addEventListener("mouseout", function(e) {
            hideNote();
        });
    </script>
</body>
</html>
