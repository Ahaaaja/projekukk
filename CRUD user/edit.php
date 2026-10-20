<?php
require_once __DIR__ . '/../auth.php';
wajib_role('admin');
$id=(int)($_GET['id']??0);
$stmt=mysqli_prepare($koneksi,"SELECT * FROM user WHERE id_user=?"); mysqli_stmt_bind_param($stmt,"i",$id); mysqli_stmt_execute($stmt);
$data=mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if(!$data) die('Data user tidak ditemukan.');
$anggota=mysqli_query($koneksi,"SELECT id_anggota,kode_anggota,nama FROM anggota ORDER BY nama ASC");
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>Edit User</title><link rel="stylesheet" href="../data.css"></head>
<body><div class="container formbox"><a class="back" href="index.php">← Kembali</a><h1>Edit User</h1>
<form method="post" action="proses_edit.php">
<input type="hidden" name="id_user" value="<?= $data['id_user'] ?>">
<label>Nama</label><input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
<label>Username</label><input type="text" name="username" value="<?= htmlspecialchars($data['username']) ?>" required>
<label>Password</label><input type="text" name="password" value="<?= htmlspecialchars($data['password']) ?>" required>
<label>Role</label><select name="role" required>
<option value="admin" <?= $data['role']==='admin'?'selected':'' ?>>Admin</option><option value="petugas" <?= $data['role']==='petugas'?'selected':'' ?>>Petugas</option><option value="anggota" <?= $data['role']==='anggota'?'selected':'' ?>>Anggota</option>
</select>
<label>Anggota (wajib untuk role anggota)</label><select name="anggota_id"><option value="">-- Tidak terkait anggota --</option><?php while($a=mysqli_fetch_assoc($anggota)){ ?><option value="<?= $a['id_anggota'] ?>" <?= ((int)$data['anggota_id']===(int)$a['id_anggota'])?'selected':'' ?>><?= htmlspecialchars($a['kode_anggota'].' - '.$a['nama']) ?></option><?php } ?></select>
<button type="submit">Simpan Perubahan</button>
</form></div></body></html>