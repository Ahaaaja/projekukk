<?php
session_start();
require_once __DIR__ . '/koneksi.php';

if (!empty($_SESSION['user_id']) && !empty($_SESSION['role'])) {
    header('Location: index1.php');
    exit;
}

$error = '';
$success = (isset($_GET['daftar']) && $_GET['daftar'] === 'berhasil')
    ? 'Akun berhasil dibuat. Silakan login menggunakan username dan password yang sudah didaftarkan.'
    : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $stmt = mysqli_prepare($koneksi, "SELECT id_user, nama, username, password, role, anggota_id FROM user WHERE username=? LIMIT 1");
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && $password === $user['password']) {
        $_SESSION['user_id'] = (int)$user['id_user'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['anggota_id'] = $user['anggota_id'];

        header('Location: index1.php');
        exit;
    }

    $error = 'Username atau password salah.';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * {
            box-sizing: border-box
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #172033
        }
        .login {
            width: 100%;
            max-width: 400px;
            background: #fff;
            padding: 32px;
            border-radius: 20px;
            box-shadow: 0 20px 60px #1e3a8a20
        }
        h2 {
            text-align: center
        }

        .sub {
            color: #64748b;
            margin-bottom: 25px
        }
        label {
            display: block;
            margin: 14px 0 7px;
            font-weight: bold
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 15px
        }
        button {
            width: 100%;
            margin-top: 22px;
            padding: 12px;
            border: 0;
            border-radius: 10px;
            background: #222;
            color: white;
            font-weight: bold;
            cursor: pointer
        }
        .success {
            margin-top: 15px;
            padding: 12px;
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            border-radius: 10px
        }
        .error {
            margin-top: 15px;
            padding: 12px;
            background: #fee2e2;
            color: #991b1b;
            border-radius: 10px
        }
        .info {
            margin-top: 18px;
            padding: 12px;
            background: #f8fafc;
            border-radius: 10px;
            font-size: 13px;
            color: #475569
        }
    </style>
</head>
<body>
    <div class="login">
        <h2>Login</h2>
        <form method="post">
            <label>Username</label>
            <input type="text" name="username" required autocomplete="username">
            <label>Password</label>
            <input type="password" name="password" required autocomplete="current-password">
            <button type="submit">Masuk</button>
        </form>
        <p style="text-align:center;margin-top:18px">Belum punya akun? <a href="register.php">Daftar sebagai anggota</a></p>
        <?php if ($success !== ''): ?>
        <div class="success" role="status" aria-live="polite">
            <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
        </div>
        <?php endif; ?>
        <?php if ($error !== ''): ?>
        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>