<?php
require_once __DIR__ . '/../auth.php';
wajib_login();
$buku = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id_buku ASC");
$isAdminOrPetugas = in_array($_SESSION['role'], array('admin', 'petugas'), true);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Data Buku</title>
    <link rel="stylesheet" href="../data.css">
</head>

<body>
    <div class="container"><a class="back" href="../index1.php">← Dashboard</a>
        <h1>Data Buku</h1>
        <?php if ($isAdminOrPetugas) { ?><a class="button" href="tambah.php">+ Tambah Buku</a><?php } ?>
        <?php if ($_SESSION['role'] === 'anggota') { ?><a class="button" href="../CRUD transaksi/tambah.php">+ Pinjam
                Buku</a><?php } ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Buku</th>
                        <th>Judul Buku</th>
                        <th>Kategori</th>
                        <th>Penerbit</th>
                        <th>Pengarang</th>
                        <th>Stok</th>
                        <th>Tahun Terbit</th>
                        <th>Sinopsis</th><?php if ($isAdminOrPetugas) { ?>
                            <th>Aksi</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    while ($row = mysqli_fetch_assoc($buku)) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['kode_buku']) ?></td>
                            <td><?= htmlspecialchars($row['judul_buku']) ?></td>
                            <td><?= htmlspecialchars($row['kategori']) ?></td>
                            <td><?= htmlspecialchars($row['penerbit']) ?></td>
                            <td><?= htmlspecialchars($row['pengarang'] ?: '-') ?></td>
                            <td><?= htmlspecialchars($row['stok'] ?: '0') ?></td>
                            <td><?= htmlspecialchars($row['tahun_terbit'] ?: '-') ?></td>
                            <td><?= htmlspecialchars($row['sinopsis'] ?: '-') ?></td>
                            <?php if ($isAdminOrPetugas) { ?>
                                <td class="aksi"><a href="edit.php?id=<?= $row['id_buku'] ?>">Edit</a><a class="danger"
                                        href="hapus.php?id=<?= $row['id_buku'] ?>"
                                        onclick="return confirm('Hapus buku ini?')">Hapus</a></td><?php } ?>
                        </tr><?php } ?>
                    <?php if (mysqli_num_rows($buku) === 0) { ?>
                        <tr>
                            <td colspan="<?= $isAdminOrPetugas ? 10 : 9 ?>" class="empty">Belum ada data buku.</td>
                        </tr><?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>