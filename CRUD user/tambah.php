<?php
require_once __DIR__ . '/../auth.php';
wajib_role('admin');
$anggota = mysqli_query($koneksi, "SELECT id_anggota, kode_anggota, nama FROM anggota ORDER BY nama ASC");
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>Tambah User</title><link rel="stylesheet" href="../data.css"></head>
<body><div class="container formbox"><a class="back" href="index.php">← Kembali</a><h1>Tambah User</h1>
<form action="proses_tambah.php" method="post">
<label>Nama</label><input type="text" name="nama" required>
<label>Username</label><input type="text" name="username" required>
<label>Password</label><input type="text" name="password" required>
<label>Role</label><select name="role" id="role" required><option value="admin">Admin</option><option value="petugas">Petugas</option><option value="anggota">Anggota</option></select>
<label>Anggota (wajib untuk role anggota)</label><select name="anggota_id"><option value="">-- Tidak terkait anggota --</option><?php while($a=mysqli_fetch_assoc($anggota)){ ?><option value="<?= $a['id_anggota'] ?>"><?= htmlspecialchars($a['kode_anggota'].' - '.$a['nama']) ?></option><?php } ?></select>
<button type="submit">Simpan</button>
</form></div></body></html>