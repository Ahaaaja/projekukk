<?php
require_once __DIR__ . '/../auth.php';
wajib_role('admin');

include '../koneksi.php';
$id=isset($_GET['id'])?(int)$_GET['id']:0;
if($id<=0) die('ID penerbit tidak valid.');
$stmt=mysqli_prepare($koneksi,"DELETE FROM penerbit WHERE id_penerbit=?"); mysqli_stmt_bind_param($stmt,"i",$id);
if(mysqli_stmt_execute($stmt)) { header('Location: index.php'); exit; }
die('Gagal menghapus data penerbit: '.mysqli_stmt_error($stmt));
?>