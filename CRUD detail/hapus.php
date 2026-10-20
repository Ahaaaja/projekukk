<?php
require_once __DIR__ . '/../auth.php';
wajib_role(array('admin','petugas'));
$id=(int)($_GET['id']??0);if($id<=0)die('ID tidak valid.');
mysqli_begin_transaction($koneksi);
try{
$q=mysqli_query($koneksi,"SELECT pd.*,p.status FROM peminjaman_detail pd JOIN peminjaman p ON p.id_peminjaman=pd.peminjaman_id WHERE pd.id_pd=$id FOR UPDATE");$d=mysqli_fetch_assoc($q);if(!$d)throw new Exception('Detail tidak ditemukan.');
if($d['status']==='dipinjam'){ $b=(int)$d['buku_id'];$j=(int)$d['jumlah'];mysqli_query($koneksi,"UPDATE buku SET stok=CAST(stok AS UNSIGNED)+$j WHERE id_buku=$b");}
if(!mysqli_query($koneksi,"DELETE FROM peminjaman_detail WHERE id_pd=$id"))throw new Exception(mysqli_error($koneksi));
mysqli_commit($koneksi);header('Location: index.php');exit;
}catch(Exception $e){mysqli_rollback($koneksi);die('Gagal menghapus detail: '.htmlspecialchars($e->getMessage()).' <a href="index.php">Kembali</a>');}
?>