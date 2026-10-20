<?php
require_once __DIR__ . '/../auth.php';
wajib_role(array('admin','petugas'));

$data = array('kode_buku' => '', 'judul_buku' => '', 'kategori' => '', 'penerbit' => '', 'pengarang' => '', 'stok' => '', 'tahun_terbit' => '', 'sinopsis' => '');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title><link rel="stylesheet" href="../data.css">
</head>
<body>
    <div class="container formbox">
        <a class="back" href="index.php">← Kembali</a>
        <h1>Tambah Buku</h1>
        <form method="post" action="proses_tambah.php">
            <label>Kode Buku</label><input type="text" name="kode_buku" value="<?= $data['kode_buku'] ?>" required>
            <label>Judul Buku</label><input type="text" name="judul_buku" value="<?= $data['judul_buku'] ?>" required>
            <label>Kategori</label><input type="text" name="kategori" value="<?= $data['kategori'] ?>" required>
            <label>Penerbit</label><input type="text" name="penerbit" value="<?= $data['penerbit'] ?>" required>
            <label>Pengarang</label><input type="text" name="pengarang" value="<?= $data['pengarang'] ?>">
            <label>Stok</label><input type="number" name="stok" min="0" value="<?= $data['stok'] !== null ? $data['stok'] : '' ?>">
            <label>Tahun Terbit</label><input type="number" name="tahun_terbit" min="0" max="<?= date('Y') ?>" value="<?= $data['tahun_terbit'] !== null ? $data['tahun_terbit'] : '' ?>">
            <label>Sinopsis</label><textarea name="sinopsis"><?= $data['sinopsis'] ?></textarea>
            <button type="submit">Tambah Buku</button>
        </form>
    </div>
</body>
</html>
