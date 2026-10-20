<?php
require_once __DIR__ . '/../auth.php';
wajib_role('admin');

$data=array();
$data['kode_penerbit']='';
$data['nama_penerbit']='';
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Tambah Penerbit</title><link rel="stylesheet" href="../data.css"></head><body><div class="container formbox"><a class="back" href="index.php">← Kembali</a><h1>Tambah Penerbit</h1><form method="post" action="proses_tambah.php"><label>Kode Penerbit</label><input type="text" name="kode_penerbit" value="<?= $data['kode_penerbit'] ?>" required>
<label>Nama Penerbit</label><input type="text" name="nama_penerbit" value="<?= $data['nama_penerbit'] ?>" required><button type="submit">Tambah Penerbit</button></form></div></body></html>