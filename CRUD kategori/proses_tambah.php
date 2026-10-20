<?php
require_once __DIR__ . '/../auth.php';
wajib_role('admin');

include '../koneksi.php';
$kode_kategori = isset($_POST['kode_kategori']) ? trim($_POST['kode_kategori']) : '';
$nama_kategori = isset($_POST['nama_kategori']) ? trim($_POST['nama_kategori']) : '';
if ($kode_kategori == '' || $nama_kategori == '')
    die('Data wajib belum lengkap.');
$stmt = mysqli_prepare($koneksi, "INSERT INTO kategori (kode_kategori, nama_kategori) VALUES (?, ?)");
mysqli_stmt_bind_param($stmt, "ss", $kode_kategori, $nama_kategori);
if (mysqli_stmt_execute($stmt)) {
    header('Location: index.php');
    exit;
}
die('Gagal menambah data kategori: ' . mysqli_stmt_error($stmt));
?>