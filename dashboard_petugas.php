<?php
require_once __DIR__ . '/auth.php';
wajib_role('petugas');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas</title><link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="top">
        <div>
            <h1>Dashboard Petugas</h1><small>Login sebagai <?= htmlspecialchars($_SESSION['nama']) ?> — petugas</small>
        </div>
        <a class="logout" href="logout.php">Keluar</a>
    </div>
    <div class="wrap">
        <div class="welcome">
            <h2>Dashboard Petugas</h2><p>
                Pilih menu yang sesuai dengan hak akses akun.
            </p>
        </div>
        <div class="grid">
            <a class="card" href="CRUD anggota/"><h3>Data Anggota</h3><p>
                Lihat, edit, dan hapus data anggota.
            </p>
            </a><a class="card" href="CRUD buku/"><h3>Data Buku</h3><p>
                    Lihat, edit, dan hapus data buku.
                </p>
            </a><a class="card" href="CRUD transaksi/"><h3>Peminjaman</h3><p>
                    Lihat, edit, hapus, dan proses peminjaman.
                </p>
            </a><a class="card" href="CRUD detail/"><h3>Detail Peminjaman</h3><p>
                    Lihat, edit, dan hapus detail peminjaman.
                </p>
            </a><a class="card" href="CRUD pengembalian/"><h3>Pengembalian</h3><p>
                    Lihat, edit, dan hapus data pengembalian.
                </p>
            </a>
        </div>
    </div>
</body>
</html>