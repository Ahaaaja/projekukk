<?php
require_once __DIR__ . '/../auth.php';
wajib_role(array('admin','petugas'));

include '../koneksi.php';

$kode = isset($_POST['kode_buku']) ? trim($_POST['kode_buku']) : '';
$judul = isset($_POST['judul_buku']) ? trim($_POST['judul_buku']) : '';
$kategori = isset($_POST['kategori']) ? trim($_POST['kategori']) : '';
$penerbit = isset($_POST['penerbit']) ? trim($_POST['penerbit']) : '';
$pengarang = isset($_POST['pengarang']) ? trim($_POST['pengarang']) : '';
$stok = isset($_POST['stok']) && $_POST['stok'] !== '' ? (int)$_POST['stok'] : null;
$tahun = isset($_POST['tahun_terbit']) && $_POST['tahun_terbit'] !== '' ? (int)$_POST['tahun_terbit'] : null;
$sinopsis = isset($_POST['sinopsis']) ? trim($_POST['sinopsis']) : '';

if ($kode === '' || $judul === '' || $kategori === '' || $penerbit === '') {
    die('Data wajib belum lengkap.');
}

if ($tahun !== null && ($tahun < 0 || $tahun > (int)date('Y'))) die('Tahun terbit tidak boleh melebihi tahun sekarang.');

$stmt = mysqli_prepare($koneksi, "INSERT INTO buku (kode_buku, judul_buku, kategori, penerbit, pengarang, stok, tahun_terbit, sinopsis) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sssssiis", $kode, $judul, $kategori, $penerbit, $pengarang, $stok, $tahun, $sinopsis);

if (mysqli_stmt_execute($stmt)) {
    header('Location: index.php');
    exit;
}

die('Gagal menambah data buku: ' . mysqli_stmt_error($stmt));
?>
