<?php
require_once __DIR__ . '/../auth.php';
wajib_role(array('admin', 'petugas'));
$id = (int) ($_GET['id'] ?? 0);
if ($id <= 0)
    die('ID tidak valid.');
mysqli_begin_transaction($koneksi);
try {
    $q = mysqli_query($koneksi, "SELECT pg.peminjaman_id FROM pengembalian pg WHERE pg.id_pengembalian=$id FOR UPDATE");
    $pg = mysqli_fetch_assoc($q);
    if (!$pg)
        throw new Exception('Data pengembalian tidak ditemukan.');
    $pid = (int) $pg['peminjaman_id'];
    $detail = mysqli_query($koneksi, "SELECT buku_id,jumlah FROM peminjaman_detail WHERE peminjaman_id=$pid");
    while ($d = mysqli_fetch_assoc($detail)) {
        $b = (int) $d['buku_id'];
        $j = (int) $d['jumlah'];
        mysqli_query($koneksi, "UPDATE buku SET stok=CAST(stok AS UNSIGNED)-$j WHERE id_buku=$b");
    }
    mysqli_query($koneksi, "DELETE FROM pengembalian WHERE id_pengembalian=$id");
    mysqli_query($koneksi, "UPDATE peminjaman SET status='dipinjam' WHERE id_peminjaman=$pid");
    mysqli_commit($koneksi);
    header('Location: index.php');
    exit;
} catch (Exception $e) {
    mysqli_rollback($koneksi);
    die('Gagal menghapus pengembalian: ' . htmlspecialchars($e->getMessage()) . ' <a href="index.php">Kembali</a>');
}
?>