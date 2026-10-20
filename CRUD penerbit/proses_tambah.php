<?php
require_once __DIR__ . '/../auth.php';
wajib_role('admin');

include '../koneksi.php';
$kode_penerbit=isset($_POST['kode_penerbit'])?trim($_POST['kode_penerbit']):'';
$nama_penerbit=isset($_POST['nama_penerbit'])?trim($_POST['nama_penerbit']):'';
if ($kode_penerbit=='' || $nama_penerbit=='') die('Data wajib belum lengkap.');
$stmt=mysqli_prepare($koneksi,"INSERT INTO penerbit (kode_penerbit, nama_penerbit) VALUES (?, ?)"); mysqli_stmt_bind_param($stmt,"ss",$kode_penerbit, $nama_penerbit);
if(mysqli_stmt_execute($stmt)) { header('Location: index.php'); exit; }
die('Gagal menambah data penerbit: '.mysqli_stmt_error($stmt));
?>