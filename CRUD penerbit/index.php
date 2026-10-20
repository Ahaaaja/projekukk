<?php
require_once __DIR__ . '/../auth.php';
wajib_role('admin');

include '../koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM penerbit ORDER BY id_penerbit ASC");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penerbit</title>
    <link rel="stylesheet" href="../data.css">
</head>

<body>
    <div class="container"><a class="back" href="../index1.php">← Menu Utama</a>
        <h1>Data Penerbit</h1><a class="button" href="tambah.php">+ Tambah Penerbit</a>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Penerbit</th>
                        <th>Nama Penerbit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    while ($row = mysqli_fetch_assoc($data)) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['kode_penerbit'] !== null && $row['kode_penerbit'] !== '' ? $row['kode_penerbit'] : '-' ?>
                            </td>
                            <td><?= $row['nama_penerbit'] !== null && $row['nama_penerbit'] !== '' ? $row['nama_penerbit'] : '-' ?>
                            </td>
                            <td class="aksi"><a href="edit.php?id=<?= $row['id_penerbit'] ?>">Edit</a><a class="danger"
                                    href="hapus.php?id=<?= $row['id_penerbit'] ?>"
                                    onclick="return confirm('Hapus data ini?')">Hapus</a></td>
                        </tr>
                    <?php }
                    if (mysqli_num_rows($data) === 0) { ?>
                        <tr>
                            <td colspan="20" class="empty">Belum ada data penerbit.</td>
                        </tr><?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>