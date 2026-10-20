<?php
require_once __DIR__ . '/../auth.php';
wajib_role('admin');

include '../koneksi.php';
$id = isset($_REQUEST['id_user']) ? (int) $_REQUEST['id_user'] : (isset($_REQUEST['id']) ? (int) $_REQUEST['id'] : 0);

if ($id <= 0) {
    die('ID user tidak valid.');
}

$stmt = mysqli_prepare($koneksi, "DELETE FROM user WHERE id_user = ?"); 
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    header('Location: index.php'); 
    exit;
}

die('Gagal menghapus data user: ' . mysqli_stmt_error($stmt));
?>