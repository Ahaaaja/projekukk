<?php
require_once __DIR__ . '/../auth.php';
wajib_role(array('admin','petugas'));
$id=(int)($_GET['id']??0); if($id<=0)die('ID tidak valid.');
mysqli_begin_transaction($koneksi);
try{
$q=mysqli_query($koneksi,"SELECT status FROM peminjaman WHERE id_peminjaman=$id FOR UPDATE");$p=mysqli_fetch_assoc($q);if(!$p)throw new Exception('Transaksi tidak ditemukan.');
$detail=mysqli_query($koneksi,"SELECT buku_id,jumlah FROM peminjaman_detail WHERE peminjaman_id=$id");
while($d=mysqli_fetch_assoc($detail)){
    $b=(int)$d['buku_id'];$j=(int)$d['jumlah'];
    if($p['status']==='dipinjam') mysqli_query($koneksi,"UPDATE buku SET stok=CAST(stok AS UNSIGNED)+$j WHERE id_buku=$b");
    else mysqli_query($koneksi,"UPDATE buku SET stok=CAST(stok AS UNSIGNED)-$j WHERE id_buku=$b");
}
mysqli_query($koneksi,"DELETE FROM pengembalian WHERE peminjaman_id=$id");
mysqli_query($koneksi,"DELETE FROM peminjaman_detail WHERE peminjaman_id=$id");
if(!mysqli_query($koneksi,"DELETE FROM peminjaman WHERE id_peminjaman=$id"))throw new Exception(mysqli_error($koneksi));
mysqli_commit($koneksi);header('Location: index.php');exit;
}catch(Exception $e){mysqli_rollback($koneksi);die('Gagal menghapus transaksi: '.htmlspecialchars($e->getMessage()).' <a href="index.php">Kembali</a>');}
?>