<?php
require_once __DIR__ . '/../auth.php';
wajib_role(array('admin','petugas'));

$data = array();
$data['kode_anggota'] = '';
$data['nama'] = '';
$data['jenis_kelamin'] = '';
$data['telp'] = '';
$data['alamat'] = '';
$data['username'] = '';
$data['password'] = '';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Anggota</title>
    <link rel="stylesheet" href="../data.css">
</head>

<body>
    <div class="container formbox">
        <a class="back" href="index.php">← Kembali</a>
        <h1>Tambah Anggota</h1>
        <form method="post" action="proses_tambah.php">
            <label>Kode Anggota</label>
            <input type="text" name="kode_anggota" value="<?= $data['kode_anggota'] ?>" required>
            
            <label>Nama</label>
            <input type="text" name="nama" value="<?= $data['nama'] ?>" required>
            
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" required>
                <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                <option value="pria" <?= ($data['jenis_kelamin'] == 'pria') ? 'selected' : '' ?>>Pria</option>
                <option value="wanita" <?= ($data['jenis_kelamin'] == 'wanita') ? 'selected' : '' ?>>Wanita</option>
            </select>
            
            <label>Telp</label>
            <input type="text" name="telp" value="<?= $data['telp'] ?>" required>
            
            <label>Username untuk Login</label>
            <input type="text" name="username" required>

            <label>Password untuk Login</label>
            <input type="password" name="password" required>

            <label>Alamat</label>
            <input type="text" name="alamat" value="<?= $data['alamat'] ?>" required>
            
            <button type="submit">Tambah Anggota</button>
        </form>
    </div>
</body>

</html>