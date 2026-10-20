<?php
require_once __DIR__ . '/../auth.php';
wajib_role('admin');
$nama=trim($_POST['nama']??''); $username=trim($_POST['username']??''); $password=trim($_POST['password']??'');
$role=trim($_POST['role']??''); $anggota_id=(int)($_POST['anggota_id']??0);
if($nama===''||$username===''||$password===''||!in_array($role,array('admin','petugas','anggota'),true)) die('Data wajib belum lengkap.');
if($role==='anggota' && $anggota_id<=0) die('Role anggota wajib dihubungkan ke data anggota.');
if($role!=='anggota') $anggota_id=0;
$stmt=mysqli_prepare($koneksi,"INSERT INTO user (nama,username,password,role,anggota_id) VALUES (?,?,?,?,NULLIF(?,0))");
mysqli_stmt_bind_param($stmt,"ssssi",$nama,$username,$password,$role,$anggota_id);
if(mysqli_stmt_execute($stmt)){header('Location: index.php');exit;} die('Gagal menambah user: '.mysqli_stmt_error($stmt));
?>