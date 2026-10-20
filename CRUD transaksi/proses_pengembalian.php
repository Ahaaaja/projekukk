<?php
require_once __DIR__ . '/../auth.php';
wajib_role(array('admin','petugas'));

include '../koneksi.php';
$id = (int) ($_POST['id_peminjaman'] ?? 0);
$tanggal_kembali = $_POST['tanggal_kembali'] ?? '';
$user_id = (int) ($_POST['user_id'] ?? 0);
if ($id <= 0 || $user_id <= 0 || $tanggal_kembali === '')
    die('Data pengembalian tidak lengkap. <a href="index.php">Kembali</a>');

$cek = mysqli_query($koneksi, "SELECT status, tanggal_pinjam, lama_pinjam FROM peminjaman WHERE id_peminjaman=$id LIMIT 1");
$p = mysqli_fetch_assoc($cek);
if (!$p)
    die('Peminjaman tidak ditemukan.');
if ($p['status'] === 'sudah dikembalikan')
    die('Buku sudah dikembalikan. <a href="index.php">Kembali</a>');

// Tenggat dihitung dari tanggal pinjam + lama pinjam. Denda Rp2.000 per hari keterlambatan.
$tenggat = date('Y-m-d', strtotime($p['tanggal_pinjam'] . ' +' . (int)$p['lama_pinjam'] . ' days'));
$hari_terlambat = max(0, (int) floor((strtotime($tanggal_kembali) - strtotime($tenggat)) / 86400));
$denda = $hari_terlambat * 2000;

mysqli_begin_transaction($koneksi);
try {
    $detail = mysqli_query($koneksi, "SELECT buku_id, jumlah FROM peminjaman_detail WHERE peminjaman_id=$id");
    while ($d = mysqli_fetch_assoc($detail)) {
        $buku_id = (int) $d['buku_id'];
        $jumlah = (int) $d['jumlah'];
        mysqli_query($koneksi, "UPDATE buku SET stok = CAST(stok AS UNSIGNED) + $jumlah WHERE id_buku=$buku_id");
    }
    mysqli_query($koneksi, "UPDATE peminjaman SET status='sudah dikembalikan' WHERE id_peminjaman=$id");
    $stmt = mysqli_prepare($koneksi, "INSERT INTO pengembalian (peminjaman_id, tanggal_kembali, user_id, denda) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'isii', $id, $tanggal_kembali, $user_id, $denda);
    if (!mysqli_stmt_execute($stmt))
        throw new Exception(mysqli_error($koneksi));
    mysqli_stmt_close($stmt);
    mysqli_commit($koneksi);
    header('Location: ../CRUD pengembalian/index.php');
    exit;
} catch (Exception $e) {
    mysqli_rollback($koneksi);
    die('Pengembalian gagal: ' . $e->getMessage() . ' <a href="index.php">Kembali</a>');
}
?>