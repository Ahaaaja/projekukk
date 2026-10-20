<?php
require_once __DIR__ . '/../auth.php';
wajib_login();
$role = $_SESSION['role'];
if (!in_array($role, array('petugas', 'anggota'), true))
    die('Akses ditolak.');
$buku_id = (int) ($_POST['buku_id'] ?? 0);
$jumlah = (int) ($_POST['jumlah'] ?? 0);
$tanggal_pinjam = $_POST['tanggal_pinjam'] ?? '';
$lama_pinjam = (int) ($_POST['lama_pinjam'] ?? 0);
$keterangan = trim($_POST['keterangan'] ?? '');
if ($role === 'anggota') {
    $anggota_id = (int) ($_SESSION['anggota_id'] ?? 0);
    $user_id = (int) $_SESSION['user_id'];
} else {
    $anggota_id = (int) ($_POST['anggota_id'] ?? 0);
    $user_id = (int) ($_POST['user_id'] ?? 0);
}
if ($anggota_id <= 0 || $buku_id <= 0 || $jumlah <= 0 || $lama_pinjam <= 0 || $user_id <= 0 || $tanggal_pinjam === '')
    die('Data peminjaman tidak lengkap. <a href="tambah.php">Kembali</a>');
$cek = mysqli_query($koneksi, "SELECT stok FROM buku WHERE id_buku=$buku_id LIMIT 1");
$buku = mysqli_fetch_assoc($cek);
$stok = (int) ($buku['stok'] ?? 0);
if (!$buku || $stok < $jumlah)
    die('Stok buku tidak mencukupi. <a href="tambah.php">Kembali</a>');
if ($role === 'anggota') {
    $cekAng = mysqli_query($koneksi, "SELECT id_anggota FROM anggota WHERE id_anggota=$anggota_id LIMIT 1");
    if (!mysqli_fetch_assoc($cekAng))
        die('Data anggota akun tidak ditemukan.');
}
mysqli_begin_transaction($koneksi);
try {
    $stmt = mysqli_prepare($koneksi, "INSERT INTO peminjaman(tanggal_pinjam,lama_pinjam,keterangan,status,anggota_id,user_id) VALUES(?,?,?,'dipinjam',?,?)");
    mysqli_stmt_bind_param($stmt, 'sisii', $tanggal_pinjam, $lama_pinjam, $keterangan, $anggota_id, $user_id);
    if (!mysqli_stmt_execute($stmt))
        throw new Exception(mysqli_error($koneksi));
    $peminjaman_id = mysqli_insert_id($koneksi);
    mysqli_stmt_close($stmt);
    $stmt = mysqli_prepare($koneksi, "INSERT INTO peminjaman_detail(peminjaman_id,buku_id,jumlah) VALUES(?,?,?)");
    mysqli_stmt_bind_param($stmt, 'iii', $peminjaman_id, $buku_id, $jumlah);
    if (!mysqli_stmt_execute($stmt))
        throw new Exception(mysqli_error($koneksi));
    mysqli_stmt_close($stmt);
    $stmt = mysqli_prepare($koneksi, "UPDATE buku SET stok=CAST(stok AS UNSIGNED)-? WHERE id_buku=?");
    mysqli_stmt_bind_param($stmt, 'ii', $jumlah, $buku_id);
    if (!mysqli_stmt_execute($stmt))
        throw new Exception(mysqli_error($koneksi));
    mysqli_stmt_close($stmt);
    mysqli_commit($koneksi);
    header('Location: ' . ($role === 'anggota' ? '../dashboard_anggota.php' : 'index.php'));
    exit;
} catch (Exception $e) {
    mysqli_rollback($koneksi);
    die('Peminjaman gagal: ' . htmlspecialchars($e->getMessage()) . ' <a href="tambah.php">Kembali</a>');
}
?>