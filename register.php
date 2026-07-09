<?php
require 'fungsi.php';

mysqli_query($koneksi, "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$message = '';

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($username === '' || $password === '') {
        $message = '<p class="message error">Username dan password wajib diisi.</p>';
    } else {
        $username = mysqli_real_escape_string($koneksi, $username);

        $cek_user = mysqli_query($koneksi, "SELECT id FROM users WHERE username = '$username'");

        if (mysqli_num_rows($cek_user) > 0) {
            $message = '<p class="message error">Username sudah terdaftar.</p>';
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (username, password) VALUES ('$username', '$password_hash')";

            if (mysqli_query($koneksi, $query)) {
                $message = '<p class="message success">Registrasi berhasil. Silakan lanjut ke halaman login.</p>';
            } else {
                $message = '<p class="message error">Registrasi gagal. Silakan coba lagi.</p>';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link rel="stylesheet" href="asset/img/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <h2>Registrasi</h2>
            <?php echo $message; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <button type="submit" name="register">Daftar</button>
            </form>
        </div>
    </div>
</body>
</html>
