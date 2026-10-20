<?php
$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "12aha";

$koneksi = mysqli_connect($servername, $username, $password, $dbname);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
mysqli_set_charset($koneksi, "utf8mb4");
?>
