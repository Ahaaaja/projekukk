<?php
require_once __DIR__ . '/../auth.php';
wajib_role(array('admin', 'petugas'));
$sql = "SELECT pg.*,p.tanggal_pinjam,p.lama_pinjam,a.kode_anggota,a.nama AS nama_anggota,u.nama AS nama_user,
GROUP_CONCAT(CONCAT(COALESCE(b.judul_buku,'-'),' (',pd.jumlah,')') SEPARATOR ', ') AS buku
FROM pengembalian pg JOIN peminjaman p ON p.id_peminjaman=pg.peminjaman_id
LEFT JOIN anggota a ON a.id_anggota=p.anggota_id LEFT JOIN user u ON u.id_user=pg.user_id
LEFT JOIN peminjaman_detail pd ON pd.peminjaman_id=p.id_peminjaman LEFT JOIN buku b ON b.id_buku=pd.buku_id
GROUP BY pg.id_pengembalian ORDER BY pg.id_pengembalian ASC";
$data = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Data Pengembalian</title>
    <link rel="stylesheet" href="../data.css">
</head>

<body>
    <div class="container"><a class="back" href="../index1.php">← Dashboard</a>
        <h1>Data Pengembalian</h1><a class="button" href="../CRUD transaksi/">← Peminjaman</a>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Anggota</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tenggat</th>
                        <th>Tanggal Kembali</th>
                        <th>Denda</th>
                        <th>Petugas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    while ($r = mysqli_fetch_assoc($data)) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars(($r['kode_anggota'] ?: '-') . ' - ' . ($r['nama_anggota'] ?: '-')) ?></td>
                            <td><?= htmlspecialchars($r['buku'] ?: '-') ?></td>
                            <td><?= $r['tanggal_pinjam'] ?></td>
                            <td><?= date('Y-m-d', strtotime($r['tanggal_pinjam'] . ' +' . (int)$r['lama_pinjam'] . ' days')) ?></td>
                            <td><?= $r['tanggal_kembali'] ?></td>
                            <td>Rp<?= number_format((int)($r['denda'] ?? 0), 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($r['nama_user'] ?: '-') ?></td>
                            <td class="aksi"><a href="edit.php?id=<?= $r['id_pengembalian'] ?>">Edit</a><a class="danger"
                                    href="hapus.php?id=<?= $r['id_pengembalian'] ?>"
                                    onclick="return confirm('Hapus data pengembalian ini? Stok akan disesuaikan.')">Hapus</a>
                            </td>
                        </tr><?php }
                    if (mysqli_num_rows($data) === 0) { ?>
                        <tr>
                            <td colspan="9" class="empty">Belum ada data pengembalian.</td>
                        </tr><?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>