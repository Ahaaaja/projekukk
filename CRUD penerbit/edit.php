<?php
require_once __DIR__ . '/../auth.php';
wajib_role('admin');

include '../koneksi.php';
$id=isset($_GET['id'])?(int)$_GET['id']:0;
if($id<=0) die('ID penerbit tidak valid.');
$stmt=mysqli_prepare($koneksi,"SELECT * FROM penerbit WHERE id_penerbit=?"); mysqli_stmt_bind_param($stmt,"i",$id); mysqli_stmt_execute($stmt); $result=mysqli_stmt_get_result($stmt); $data=mysqli_fetch_assoc($result);
if(!$data) die('Data penerbit tidak ditemukan.');
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Edit Penerbit</title><link rel="stylesheet" href="../data.css"></head><body><div class="container formbox"><a class="back" href="index.php">← Kembali</a><h1>Edit Penerbit</h1><form method="post" action="proses_edit.php"><input type="hidden" name="id" value="<?= $data['id_penerbit'] ?>"><label>Kode Penerbit</label><input type="text" name="kode_penerbit" value="<?= $data['kode_penerbit'] ?>" required>
<label>Nama Penerbit</label><input type="text" name="nama_penerbit" value="<?= $data['nama_penerbit'] ?>" required><button type="submit">Simpan Perubahan</button></form></div></body></html>