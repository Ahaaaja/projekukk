<?php
require_once __DIR__ . '/../auth.php';
wajib_role('admin');

include '../koneksi.php';
$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
$kode_kategori = isset($_POST['kode_kategori']) ? trim($_POST['kode_kategori']) : '';
$nama_kategori = isset($_POST['nama_kategori']) ? trim($_POST['nama_kategori']) : '';
if ($id <= 0)
    die('ID kategori tidak valid.');
if ($kode_kategori == '' || $nama_kategori == '')
    die('Data wajib belum lengkap.');
$stmt = mysqli_prepare($koneksi, "UPDATE kategori SET kode_kategori=?, nama_kategori=? WHERE id_kategori=?");
mysqli_stmt_bind_param($stmt, "sss", $kode_kategori, $nama_kategori, $id);
if (mysqli_stmt_execute($stmt)) {
    header('Location: index.php');
    exit;
}
die('Gagal mengedit data kategori: ' . mysqli_stmt_error($stmt));
?>