<?php
require_once __DIR__ . '/../auth.php';
wajib_role('admin');

$data=array();
$data['kode_kategori']='';
$data['nama_kategori']='';
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Tambah Kategori</title><link rel="stylesheet" href="../data.css"></head><body><div class="container formbox"><a class="back" href="index.php">← Kembali</a><h1>Tambah Kategori</h1><form method="post" action="proses_tambah.php"><label>Kode Kategori</label><input type="text" name="kode_kategori" value="<?= $data['kode_kategori'] ?>" required>
<label>Nama Kategori</label><input type="text" name="nama_kategori" value="<?= $data['nama_kategori'] ?>" required><button type="submit">Tambah Kategori</button></form></div></body></html>