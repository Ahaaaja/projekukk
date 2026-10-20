<?php
require_once __DIR__ . '/../auth.php';
wajib_role(array('admin','petugas'));

include '../koneksi.php';
$id=isset($_POST['id'])?(int)$_POST['id']:0;
$kode_anggota=isset($_POST['kode_anggota'])?trim($_POST['kode_anggota']):'';
$nama=isset($_POST['nama'])?trim($_POST['nama']):'';
$jenis_kelamin=isset($_POST['jenis_kelamin'])?trim($_POST['jenis_kelamin']):'';
$telp=isset($_POST['telp'])?trim($_POST['telp']):'';
$alamat=isset($_POST['alamat'])?trim($_POST['alamat']):'';
if($id<=0) die('ID anggota tidak valid.');
if ($kode_anggota=='' || $nama=='' || $jenis_kelamin=='' || $telp=='' || $alamat=='') die('Data wajib belum lengkap.');
$stmt=mysqli_prepare($koneksi,"UPDATE anggota SET kode_anggota=?, nama=?, jenis_kelamin=?, telp=?, alamat=? WHERE id_anggota=?"); mysqli_stmt_bind_param($stmt,"sssssi",$kode_anggota, $nama, $jenis_kelamin, $telp, $alamat, $id);
if(mysqli_stmt_execute($stmt)) { header('Location: index.php'); exit; }
die('Gagal mengedit data anggota: '.mysqli_stmt_error($stmt));
?>