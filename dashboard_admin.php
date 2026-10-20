<?php
require_once __DIR__ . '/auth.php';
wajib_role('admin');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="dashboard.css">
</head>

<body>
    <div class="top">
        <div>
            <h1>Dashboard Admin</h1><small>Login sebagai <?= htmlspecialchars($_SESSION['nama']) ?> — admin</small>
        </div><a class="logout" href="logout.php">Keluar</a>
    </div>
    <div class="wrap">
        <div class="welcome">
            <h2>Dashboard Admin</h2>
            <p>Pilih menu yang sesuai dengan hak akses akun.</p>
        </div>
        <div class="grid"><a class="card" href="CRUD anggota/">
                <h3>Anggota</h3>
                <p>Kelola seluruh data anggota.</p>
            </a><a class="card" href="CRUD buku/">
                <h3>Buku</h3>
                <p>Tambah, lihat, edit, dan hapus buku.</p>
            </a><a class="card" href="CRUD kategori/">
                <h3>Kategori</h3>
                <p>Kelola kategori buku.</p>
            </a><a class="card" href="CRUD penerbit/">
                <h3>Penerbit</h3>
                <p>Kelola data penerbit.</p>
            </a><a class="card" href="CRUD user/">
                <h3>User</h3>
                <p>Kelola akun dan role pengguna.</p>
            </a><a class="card" href="CRUD transaksi/">
                <h3>Peminjaman</h3>
                <p>Kelola seluruh transaksi peminjaman.</p>
            </a><a class="card" href="CRUD riwayat/">
                <h3>Riwayat Pinjam</h3>
                <p>Lihat riwayat peminjaman seluruh anggota beserta status pengembalian.</p>
            </a><a class="card" href="CRUD detail/">
                <h3>Detail Peminjaman</h3>
                <p>Kelola isi/detail buku pada transaksi.</p>
            </a><a class="card" href="CRUD pengembalian/">
                <h3>Pengembalian</h3>
                <p>Kelola seluruh data pengembalian.</p>
            </a></div>
    </div>
</body>

</html>