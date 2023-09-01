<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Girişi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 100px auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .input-field {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        .button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 10px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Girişi</h2>
        <form action="admin_giris_process.php" method="POST">
            <input type="text" name="username" placeholder="Kullanıcı Adı" required class="input-field"><br>
            <input type="password" name="password" placeholder="Şifre" required class="input-field"><br>
            <button type="submit" class="button">Giriş Yap</button>
        </form>
        
        <!-- Personel Girişi Sayfası için buton -->
        <form action="login.html" method="GET">
            <button type="submit" class="button">Personel Girişi</button>
        </form>
    </div>
</body>
</html>
