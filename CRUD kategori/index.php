<?php
require_once __DIR__ . '/../auth.php';
wajib_role('admin');

include '../koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY id_kategori ASC");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kategori</title>
    <link rel="stylesheet" href="../data.css">
</head>

<body>
    <div class="container"><a class="back" href="../index1.php">← Menu Utama</a>
        <h1>Data Kategori</h1><a class="button" href="tambah.php">+ Tambah Kategori</a>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Kategori</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    while ($row = mysqli_fetch_assoc($data)) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['kode_kategori'] !== null && $row['kode_kategori'] !== '' ? $row['kode_kategori'] : '-' ?>
                            </td>
                            <td><?= $row['nama_kategori'] !== null && $row['nama_kategori'] !== '' ? $row['nama_kategori'] : '-' ?>
                            </td>
                            <td class="aksi"><a href="edit.php?id=<?= $row['id_kategori'] ?>">Edit</a><a class="danger"
                                    href="hapus.php?id=<?= $row['id_kategori'] ?>"
                                    onclick="return confirm('Hapus data ini?')">Hapus</a></td>
                        </tr>
                    <?php }
                    if (mysqli_num_rows($data) === 0) { ?>
                        <tr>
                            <td colspan="20" class="empty">Belum ada data kategori.</td>
                        </tr><?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>