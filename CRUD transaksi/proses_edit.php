<?php
require_once __DIR__ . '/../auth.php';
wajib_role(array('admin','petugas'));
$id=(int)($_POST['id_peminjaman']??0);$anggota_id=(int)($_POST['anggota_id']??0);$tanggal=$_POST['tanggal_pinjam']??'';$lama=(int)($_POST['lama_pinjam']??0);$user_id=(int)($_POST['user_id']??0);$status=$_POST['status']??'';$keterangan=trim($_POST['keterangan']??'');
if($id<=0||$anggota_id<=0||$tanggal===''||$lama<=0||$user_id<=0||!in_array($status,array('dipinjam','sudah dikembalikan'),true))die('Data tidak lengkap.');
$stmt=mysqli_prepare($koneksi,"UPDATE peminjaman SET tanggal_pinjam=?,lama_pinjam=?,keterangan=?,status=?,anggota_id=?,user_id=? WHERE id_peminjaman=?");
mysqli_stmt_bind_param($stmt,'sissiii',$tanggal,$lama,$keterangan,$status,$anggota_id,$user_id,$id);
if(mysqli_stmt_execute($stmt)){header('Location: index.php');exit;}die('Gagal mengedit transaksi: '.mysqli_stmt_error($stmt));
?>