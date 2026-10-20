<?php
require_once __DIR__ . '/../auth.php';
wajib_role(array('admin','petugas'));

$kode=trim($_POST['kode_anggota']??'');
$nama=trim($_POST['nama']??'');
$jk=trim($_POST['jenis_kelamin']??'');
$telp=trim($_POST['telp']??'');
$alamat=trim($_POST['alamat']??'');
$username=trim($_POST['username']??'');
$password=trim($_POST['password']??'');
if($kode===''||$nama===''||!in_array($jk,array('pria','wanita'),true)||$telp===''||$alamat===''||$username===''||$password==='') die('Semua data wajib diisi.');
mysqli_begin_transaction($koneksi);
try {
 $cek=mysqli_prepare($koneksi,"SELECT id_user FROM user WHERE username=? LIMIT 1");
 mysqli_stmt_bind_param($cek,'s',$username); mysqli_stmt_execute($cek);
 if(mysqli_num_rows(mysqli_stmt_get_result($cek))>0) throw new Exception('Username sudah digunakan.');
 $stmt=mysqli_prepare($koneksi,"INSERT INTO anggota(kode_anggota,nama,jenis_kelamin,telp,alamat) VALUES(?,?,?,?,?)");
 mysqli_stmt_bind_param($stmt,'sssss',$kode,$nama,$jk,$telp,$alamat);
 if(!mysqli_stmt_execute($stmt)) throw new Exception(mysqli_error($koneksi));
 $aid=mysqli_insert_id($koneksi); $role='anggota';
 $stmt=mysqli_prepare($koneksi,"INSERT INTO user(nama,username,password,role,anggota_id) VALUES(?,?,?,?,?)");
 mysqli_stmt_bind_param($stmt,'ssssi',$nama,$username,$password,$role,$aid);
 if(!mysqli_stmt_execute($stmt)) throw new Exception(mysqli_error($koneksi));
 mysqli_commit($koneksi); header('Location: index.php'); exit;
} catch(Throwable $e) { mysqli_rollback($koneksi); die('Gagal menambah anggota/akun: '.htmlspecialchars($e->getMessage())); }
?>