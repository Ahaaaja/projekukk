<?php
require_once __DIR__ . '/../auth.php';
wajib_role('admin');

include '../koneksi.php';
$id=isset($_POST['id'])?(int)$_POST['id']:0;
$kode_penerbit=isset($_POST['kode_penerbit'])?trim($_POST['kode_penerbit']):'';
$nama_penerbit=isset($_POST['nama_penerbit'])?trim($_POST['nama_penerbit']):'';
if($id<=0) die('ID penerbit tidak valid.');
if ($kode_penerbit=='' || $nama_penerbit=='') die('Data wajib belum lengkap.');
$stmt=mysqli_prepare($koneksi,"UPDATE penerbit SET kode_penerbit=?, nama_penerbit=? WHERE id_penerbit=?"); mysqli_stmt_bind_param($stmt,"sss",$kode_penerbit, $nama_penerbit, $id);
if(mysqli_stmt_execute($stmt)) { header('Location: index.php'); exit; }
die('Gagal mengedit data penerbit: '.mysqli_stmt_error($stmt));
?>