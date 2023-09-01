<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Admin Sayfası</title>
    <style>
        /* Temel stil */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #f0f0f0;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            background-color: #3498db; /* Mavi renk */
            padding: 10px 0;
        }

        .header h1 {
            color: #000; /* Siyah metin rengi */
        }

        .menu {
            border: 1px solid #ccc;
            padding: 10px;
        }

        .menu a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #000; /* Siyah metin rengi */
            transition: background-color 0.3s;
        }

        .menu a:hover {
            background-color: #3498db; 
            color: #fff; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Admin Paneli</h1>
        </div>
        <div class="menu">
            <a href="makine.php">Makineler</a>
            <a href="parca.php">Parçalar</a>
            <a href="personel.php">Çalışanlar</a>
            <a href="calisma.php">Çalışmalar</a>
            <a href="kalip.php">Kalıplar</a>
            <a href="bildirim.php">Bildirimler</a>
        </div>
        <div style="text-align: center; margin-top: 20px;">
            <a href="logout.php" class="logout-button">Çıkış Yap</a>
        </div>
    </div>
</body>
</html>
