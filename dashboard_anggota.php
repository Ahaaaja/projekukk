<?php
require_once __DIR__ . '/auth.php';
wajib_role('anggota');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Anggota</title>
    <link rel="stylesheet" href="dashboard.css">
</head>

<body>
    <div class="top">
        <div>
            <h1>Dashboard Anggota</h1><small>Login sebagai <?= htmlspecialchars($_SESSION['nama']) ?> — anggota</small>
        </div><a class="logout" href="logout.php">Keluar</a>
    </div>
    <div class="wrap">
        <div class="welcome">
            <h2>Dashboard Anggota</h2>
            <p>Pilih menu yang sesuai dengan hak akses akun.</p>
        </div>
        <div class="grid"><a class="card" href="CRUD buku/">
                <h3>Lihat Buku</h3>
                <p>Melihat seluruh daftar buku dan stok.</p>
            </a><a class="card" href="CRUD transaksi/tambah.php">
                <h3>Pinjam Buku</h3>
                <p>Mengajukan peminjaman buku.</p>
            </a><a class="card" href="CRUD riwayat/">
                <h3>Riwayat Pinjam</h3>
                <p>Melihat riwayat buku yang pernah dipinjam dan status pengembaliannya.</p>
            </a></div>
    </div>
</body>

</html>