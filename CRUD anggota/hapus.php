<?php
require_once __DIR__ . '/../auth.php';
wajib_role(array('admin','petugas'));

include '../koneksi.php';
$id=isset($_GET['id'])?(int)$_GET['id']:0;
if($id<=0) die('ID anggota tidak valid.');
$stmt=mysqli_prepare($koneksi,"DELETE FROM anggota WHERE id_anggota=?"); mysqli_stmt_bind_param($stmt,"i",$id);
if(mysqli_stmt_execute($stmt)) { header('Location: index.php'); exit; }
die('Gagal menghapus data anggota: '.mysqli_stmt_error($stmt));
?>