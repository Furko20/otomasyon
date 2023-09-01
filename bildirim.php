<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "enelsis";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Veritabanı bağlantısında hata oluştu: " . $conn->connect_error);
}

// Kullanıcıları çek
$users_sql = "SELECT * FROM users WHERE role = 'personel'";
$users_result = $conn->query($users_sql);

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Bildirimler</title>
    <style>
        /* Stil buraya */
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bildirimler</h1>
        </div>

        <h2>Hoş geldiniz, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?></h2>

        <h2>Kullanıcılar</h2>
        <ul>
            <?php
            if ($users_result->num_rows > 0) {
                while ($user_row = $users_result->fetch_assoc()) {
                    echo "<li><a href='#' onclick='showUserJobs(" . $user_row["id"] . ")'>" . $user_row["username"] . "</a></li>";
                }
            }
            ?>
        </ul>

        <div id="userJobsModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeUserJobsModal()">&times;</span>
                <h2>Kullanıcının İşleri</h2>
                <div id="userJobsContent"></div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <a href="logout.php" class="logout-button">Çıkış Yap</a>
        </div>
    </div>

    <script>
    function showUserJobs(userId) {
        var modal = document.getElementById("userJobsModal");
        var contentDiv = document.getElementById("userJobsContent");

        // AJAX ile kullanıcının işlerini çek
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    contentDiv.innerHTML = xhr.responseText;
                    modal.style.display = "block";
                } else {
                    console.error("İşler getirilirken hata oluştu.");
                }
            }
        };

        xhr.open("GET", "get_user_jobs.php?user_id=" + userId, true);
        xhr.send();
    }

    function closeUserJobsModal() {
        var modal = document.getElementById("userJobsModal");
        modal.style.display = "none";
    }
</script>

</body>
</html>
