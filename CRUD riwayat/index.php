<?php
require_once __DIR__ . '/../auth.php';
wajib_role(array('admin','anggota'));

$role = $_SESSION['role'];

$sql = "SELECT p.id_peminjaman, p.tanggal_pinjam, p.lama_pinjam, p.keterangan, p.status,
               a.kode_anggota, a.nama AS nama_anggota,
               u.nama AS nama_user,
               GROUP_CONCAT(CONCAT(COALESCE(b.judul_buku,'Buku tidak ditemukan'), ' (', pd.jumlah, ')') SEPARATOR ', ') AS buku_dipinjam,
               MAX(pg.tanggal_kembali) AS tanggal_kembali
        FROM peminjaman p
        LEFT JOIN anggota a ON a.id_anggota = p.anggota_id
        LEFT JOIN user u ON u.id_user = p.user_id
        LEFT JOIN peminjaman_detail pd ON pd.peminjaman_id = p.id_peminjaman
        LEFT JOIN buku b ON b.id_buku = pd.buku_id
        LEFT JOIN pengembalian pg ON pg.peminjaman_id = p.id_peminjaman";

if ($role === 'anggota') {
    $anggota_id = (int)($_SESSION['anggota_id'] ?? 0);
    $sql .= " WHERE p.anggota_id = $anggota_id";
}

$sql .= " GROUP BY p.id_peminjaman ORDER BY p.tanggal_pinjam DESC, p.id_peminjaman DESC";
$data = mysqli_query($koneksi, $sql);

if (!$data) {
    die('Gagal mengambil riwayat peminjaman: ' . htmlspecialchars(mysqli_error($koneksi)));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Riwayat Peminjaman</title>
<link rel="stylesheet" href="../data.css">
<style>
.status{display:inline-block;padding:5px 9px;border-radius:999px;font-size:13px;font-weight:bold;background:#e5e7eb}
.status.dipinjam{background:#fef3c7;color:#92400e}
.status.kembali{background:#dcfce7;color:#166534}
.info{margin:12px 0;padding:12px 15px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;color:#475569}
</style>
</head>
<body>
<div class="container">
    <a class="back" href="../index1.php">← Dashboard</a>
    <h1>Riwayat Peminjaman Buku</h1>
    <?php if ($role === 'anggota'): ?>
        <div class="info">Menampilkan seluruh riwayat peminjaman buku untuk akun <b><?= htmlspecialchars($_SESSION['nama']) ?></b>.</div>
    <?php else: ?>
        <div class="info">Menampilkan seluruh riwayat peminjaman buku semua anggota.</div>
    <?php endif; ?>

    <div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Anggota</th>
                <th>Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Lama Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Petugas</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
        <?php $no = 1; while ($row = mysqli_fetch_assoc($data)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars(($row['kode_anggota'] ?: '-') . ' - ' . ($row['nama_anggota'] ?: '-')) ?></td>
                <td><?= htmlspecialchars($row['buku_dipinjam'] ?: '-') ?></td>
                <td><?= htmlspecialchars($row['tanggal_pinjam']) ?></td>
                <td><?= $row['lama_pinjam'] !== null ? (int)$row['lama_pinjam'] . ' hari' : '-' ?></td>
                <td><?= $row['tanggal_kembali'] ? htmlspecialchars($row['tanggal_kembali']) : '-' ?></td>
                <td><?= htmlspecialchars($row['nama_user'] ?: '-') ?></td>
                <td>
                    <?php if ($row['status'] === 'dipinjam'): ?>
                        <span class="status dipinjam">Dipinjam</span>
                    <?php else: ?>
                        <span class="status kembali">Sudah dikembalikan</span>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($row['keterangan'] ?: '-') ?></td>
            </tr>
        <?php endwhile; ?>
        <?php if (mysqli_num_rows($data) === 0): ?>
            <tr><td colspan="9" class="empty">Belum ada riwayat peminjaman.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>
</body>
</html>
