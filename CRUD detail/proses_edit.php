<?php
require_once __DIR__ . '/../auth.php';
wajib_role(array('admin','petugas'));
$id=(int)($_POST['id_pd']??0);$pid=(int)($_POST['peminjaman_id']??0);$new_book=(int)($_POST['buku_id']??0);$new_qty=(int)($_POST['jumlah']??0);
if($id<=0||$pid<=0||$new_book<=0||$new_qty<=0)die('Data tidak lengkap.');
mysqli_begin_transaction($koneksi);
try{
$q=mysqli_query($koneksi,"SELECT pd.*,p.status FROM peminjaman_detail pd JOIN peminjaman p ON p.id_peminjaman=pd.peminjaman_id WHERE pd.id_pd=$id AND pd.peminjaman_id=$pid FOR UPDATE");$old=mysqli_fetch_assoc($q);if(!$old)throw new Exception('Detail tidak ditemukan.');
$old_book=(int)$old['buku_id'];$old_qty=(int)$old['jumlah'];$status=$old['status'];
if($status==='dipinjam'){
    mysqli_query($koneksi,"UPDATE buku SET stok=CAST(stok AS UNSIGNED)+$old_qty WHERE id_buku=$old_book");
    $q2=mysqli_query($koneksi,"SELECT stok FROM buku WHERE id_buku=$new_book FOR UPDATE");$nb=mysqli_fetch_assoc($q2);if(!$nb|| (int)$nb['stok']<$new_qty)throw new Exception('Stok buku baru tidak mencukupi.');
    mysqli_query($koneksi,"UPDATE buku SET stok=CAST(stok AS UNSIGNED)-$new_qty WHERE id_buku=$new_book");
}
$stmt=mysqli_prepare($koneksi,"UPDATE peminjaman_detail SET buku_id=?,jumlah=? WHERE id_pd=?");mysqli_stmt_bind_param($stmt,'iii',$new_book,$new_qty,$id);if(!mysqli_stmt_execute($stmt))throw new Exception(mysqli_error($koneksi));
mysqli_commit($koneksi);header('Location: index.php');exit;
}catch(Exception $e){mysqli_rollback($koneksi);die('Gagal mengedit detail: '.htmlspecialchars($e->getMessage()).' <a href="index.php">Kembali</a>');}
?>