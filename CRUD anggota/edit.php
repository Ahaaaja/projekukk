<?php
require_once __DIR__ . '/../auth.php';
wajib_role(array('admin','petugas'));

include '../koneksi.php';
$id=isset($_GET['id'])?(int)$_GET['id']:0;
if($id<=0) die('ID anggota tidak valid.');
$stmt=mysqli_prepare($koneksi,"SELECT * FROM anggota WHERE id_anggota=?"); mysqli_stmt_bind_param($stmt,"i",$id); mysqli_stmt_execute($stmt); $result=mysqli_stmt_get_result($stmt); $data=mysqli_fetch_assoc($result);
if(!$data) die('Data anggota tidak ditemukan.');
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Edit Anggota</title><link rel="stylesheet" href="../data.css"></head><body><div class="container formbox"><a class="back" href="index.php">← Kembali</a><h1>Edit Anggota</h1><form method="post" action="proses_edit.php"><input type="hidden" name="id" value="<?= $data['id_anggota'] ?>"><label>Kode Anggota</label><input type="text" name="kode_anggota" value="<?= $data['kode_anggota'] ?>" required>
<label>Nama</label><input type="text" name="nama" value="<?= $data['nama'] ?>" required>
<label>Jenis Kelamin</label><input type="text" name="jenis_kelamin" value="<?= $data['jenis_kelamin'] ?>" required>
<label>Telp</label><input type="text" name="telp" value="<?= $data['telp'] ?>" required>
<label>Alamat</label><input type="text" name="alamat" value="<?= $data['alamat'] ?>" required><button type="submit">Simpan Perubahan</button></form></div></body></html>