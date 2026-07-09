<?php
session_start();
require 'fungsi.php';

$message = '';

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($username === '' || $password === '') {
        $message = '<p class="message error">Username dan password wajib diisi.</p>';
    } else {
        $username = mysqli_real_escape_string($koneksi, $username);
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($koneksi, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                $_SESSION['login'] = true;
                $_SESSION['username'] = $username;
                header('Location: index.php');
                exit;
            } else {
                $message = '<p class="message error">Password salah.</p>';
            }
        } else {
            $message = '<p class="message error">Username tidak ditemukan.</p>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="asset/img/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <h2>Login</h2>
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
                <button type="submit" name="login">Masuk</button>
            </form>
            <p style="text-align:center; margin-top:15px;">
                Belum punya akun? <a href="register.php">Daftar</a>
            </p>
        </div>
    </div>
</body>
</html>
