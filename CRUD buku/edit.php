<?php
require_once __DIR__ . '/../auth.php';
wajib_role(array('admin','petugas'));

include '../koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) die('ID buku tidak valid.');

$stmt = mysqli_prepare($koneksi, "SELECT * FROM buku WHERE id_buku=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) die('Data buku tidak ditemukan.');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title><link rel="stylesheet" href="../data.css">
</head>
<body>
    <div class="container formbox">
        <a class="back" href="index.php">← Kembali</a>
        <h1>Edit Buku</h1>
        <form method="post" action="proses_edit.php">
            <input type="hidden" name="id" value="<?= $data['id_buku'] ?>">
            <label>Kode Buku</label><input type="text" name="kode_buku" value="<?= $data['kode_buku'] ?>" required>
            <label>Judul Buku</label><input type="text" name="judul_buku" value="<?= $data['judul_buku'] ?>" required>
            <label>Kategori</label><input type="text" name="kategori" value="<?= $data['kategori'] ?>" required>
            <label>Penerbit</label><input type="text" name="penerbit" value="<?= $data['penerbit'] ?>" required>
            <label>Pengarang</label><input type="text" name="pengarang" value="<?= $data['pengarang'] ?>">
            <label>Stok</label><input type="number" name="stok" min="0" value="<?= $data['stok'] !== null ? $data['stok'] : '' ?>">
            <label>Tahun Terbit</label><input type="number" name="tahun_terbit" min="0" value="<?= $data['tahun_terbit'] !== null ? $data['tahun_terbit'] : '' ?>">
            <label>Sinopsis</label><textarea name="sinopsis"><?= $data['sinopsis'] ?></textarea>
            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
