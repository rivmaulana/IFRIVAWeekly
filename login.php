<?php
session_start();
include "fungsi.php";

$notif = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user = htmlspecialchars(trim($_POST["username"]));
    $pass = $_POST["password"];

    if (!empty($user) && !empty($pass)) {

        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        $stmt = mysqli_prepare($koneksi, $sql);

        mysqli_stmt_bind_param($stmt, "s", $user);
        mysqli_stmt_execute($stmt);

        $hasil = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($hasil) == 1) {

            $data = mysqli_fetch_assoc($hasil);

            if (password_verify($pass, $data["password"])) {

                $_SESSION["login"] = true;
                $_SESSION["username"] = $data["username"];

                header("Location: index.php");
                exit();

            } else {
                $notif = "<div class='message error'>Password yang Anda masukkan tidak benar.</div>";
            }

        } else {
            $notif = "<div class='message error'>Akun tidak ditemukan.</div>";
        }

        mysqli_stmt_close($stmt);

    } else {
        $notif = "<div class='message error'>Semua kolom harus diisi.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link rel="stylesheet" href="asset/img/style.css">
</head>
<body>

<div class="auth-container">
    <div class="auth-card">

        <h2>Silakan Login</h2>

        <?= $notif; ?>

        <form action="" method="post">

            <div class="form-group">
                <label>Username</label>
                <input
                    type="text"
                    name="username"
                    placeholder="Masukkan Username"
                    autocomplete="off"
                    required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input
                    type="password"
                    name="password"
                    placeholder="Masukkan Password"
                    required>
            </div>

            <button type="submit">Login</button>

        </form>

        <div style="text-align:center; margin-top:18px;">
            Belum memiliki akun?
            <a href="register.php">Registrasi</a>
        </div>

    </div>
</div>

</body>
</html>
