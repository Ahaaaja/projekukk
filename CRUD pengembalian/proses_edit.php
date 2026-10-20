<?php
require_once __DIR__ . '/../auth.php';
wajib_role(array('admin', 'petugas'));
$id = (int) ($_POST['id_pengembalian'] ?? 0);
$tanggal = $_POST['tanggal_kembali'] ?? '';
$user = (int) ($_POST['user_id'] ?? 0);
if ($id <= 0 || $tanggal === '' || $user <= 0)
    die('Data tidak lengkap.');
$cek = mysqli_query($koneksi, "SELECT p.tanggal_pinjam,p.lama_pinjam FROM pengembalian pg JOIN peminjaman p ON p.id_peminjaman=pg.peminjaman_id WHERE pg.id_pengembalian=$id LIMIT 1");
$pinjam = mysqli_fetch_assoc($cek);
if (!$pinjam) die('Data pengembalian tidak ditemukan.');
$tenggat = date('Y-m-d', strtotime($pinjam['tanggal_pinjam'] . ' +' . (int)$pinjam['lama_pinjam'] . ' days'));
$hari_terlambat = max(0, (int) floor((strtotime($tanggal) - strtotime($tenggat)) / 86400));
$denda = $hari_terlambat * 2000;
$stmt = mysqli_prepare($koneksi, "UPDATE pengembalian SET tanggal_kembali=?,user_id=?,denda=? WHERE id_pengembalian=?");
mysqli_stmt_bind_param($stmt, 'siii', $tanggal, $user, $denda, $id);
if (mysqli_stmt_execute($stmt)) {
    header('Location: index.php');
    exit;
}
die('Gagal mengedit pengembalian: ' . mysqli_stmt_error($stmt));
?>