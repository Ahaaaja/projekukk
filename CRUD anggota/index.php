<?php
require_once __DIR__ . '/../auth.php';
wajib_role(array('admin','petugas'));

include '../koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY id_anggota ASC");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anggota</title>
    <link rel="stylesheet" href="../data.css">
</head>

<body>
    <div class="container"><a class="back" href="../index1.php">← Menu Utama</a>
        <h1>Data Anggota</h1><a class="button" href="tambah.php">+ Tambah Anggota</a> <a class="button"
            href="../CRUD transaksi/tambah.php">+ Pinjam Buku</a>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Anggota</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Telp</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    while ($row = mysqli_fetch_assoc($data)) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['kode_anggota'] !== null && $row['kode_anggota'] !== '' ? $row['kode_anggota'] : '-' ?>
                            </td>
                            <td><?= $row['nama'] !== null && $row['nama'] !== '' ? $row['nama'] : '-' ?></td>
                            <td><?= $row['jenis_kelamin'] !== null && $row['jenis_kelamin'] !== '' ? $row['jenis_kelamin'] : '-' ?>
                            </td>
                            <td><?= $row['telp'] !== null && $row['telp'] !== '' ? $row['telp'] : '-' ?></td>
                            <td><?= $row['alamat'] !== null && $row['alamat'] !== '' ? $row['alamat'] : '-' ?></td>
                            <td class="aksi"><a href="edit.php?id=<?= $row['id_anggota'] ?>">Edit</a><a class="danger"
                                    href="hapus.php?id=<?= $row['id_anggota'] ?>"
                                    onclick="return confirm('Hapus data ini?')">Hapus</a></td>
                        </tr>
                    <?php }
                    if (mysqli_num_rows($data) === 0) { ?>
                        <tr>
                            <td colspan="20" class="empty">Belum ada data anggota.</td>
                        </tr><?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>