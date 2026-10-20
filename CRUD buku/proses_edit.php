<?php
require_once __DIR__ . '/../auth.php';
wajib_role(array('admin','petugas'));

include '../koneksi.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$kode = isset($_POST['kode_buku']) ? trim($_POST['kode_buku']) : '';
$judul = isset($_POST['judul_buku']) ? trim($_POST['judul_buku']) : '';
$kategori = isset($_POST['kategori']) ? trim($_POST['kategori']) : '';
$penerbit = isset($_POST['penerbit']) ? trim($_POST['penerbit']) : '';
$pengarang = isset($_POST['pengarang']) ? trim($_POST['pengarang']) : '';
$stok = isset($_POST['stok']) && $_POST['stok'] !== '' ? (int)$_POST['stok'] : null;
$tahun = isset($_POST['tahun_terbit']) && $_POST['tahun_terbit'] !== '' ? (int)$_POST['tahun_terbit'] : null;
$sinopsis = isset($_POST['sinopsis']) ? trim($_POST['sinopsis']) : '';

if ($id <= 0) die('ID buku tidak valid.');
if ($kode === '' || $judul === '' || $kategori === '' || $penerbit === '') {
    die('Data wajib belum lengkap.');
}

$stmt = mysqli_prepare($koneksi, "UPDATE buku SET kode_buku=?, judul_buku=?, kategori=?, penerbit=?, pengarang=?, stok=?, tahun_terbit=?, sinopsis=? WHERE id_buku=?");
mysqli_stmt_bind_param($stmt, "sssssiisi", $kode, $judul, $kategori, $penerbit, $pengarang, $stok, $tahun, $sinopsis, $id);

if (mysqli_stmt_execute($stmt)) {
    header('Location: index.php');
    exit;
}

die('Gagal mengedit data buku: ' . mysqli_stmt_error($stmt));
?>
