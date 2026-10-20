<?php
require_once __DIR__ . '/../auth.php';
wajib_role(array('admin','petugas'));
$id=(int)($_GET['id']??0);
$stmt=mysqli_prepare($koneksi,"SELECT * FROM peminjaman WHERE id_peminjaman=?");mysqli_stmt_bind_param($stmt,'i',$id);mysqli_stmt_execute($stmt);$data=mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if(!$data)die('Transaksi tidak ditemukan.');
$anggota=mysqli_query($koneksi,"SELECT * FROM anggota ORDER BY nama ASC"); $petugas=mysqli_query($koneksi,"SELECT * FROM user WHERE role IN ('admin','petugas') ORDER BY nama ASC");
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>Edit Peminjaman</title><link rel="stylesheet" href="../data.css"></head>
<body><div class="container formbox"><a class="back" href="index.php">← Kembali</a><h1>Edit Peminjaman</h1><form method="post" action="proses_edit.php">
<input type="hidden" name="id_peminjaman" value="<?= $id ?>">
<label>Anggota</label><select name="anggota_id" required><?php while($a=mysqli_fetch_assoc($anggota)){ ?><option value="<?= $a['id_anggota'] ?>" <?= (int)$data['anggota_id']===(int)$a['id_anggota']?'selected':'' ?>><?= htmlspecialchars($a['kode_anggota'].' - '.$a['nama']) ?></option><?php } ?></select>
<label>Tanggal Pinjam</label><input type="date" name="tanggal_pinjam" value="<?= $data['tanggal_pinjam'] ?>" required>
<label>Lama Pinjam</label><input type="number" name="lama_pinjam" min="1" value="<?= $data['lama_pinjam'] ?>" required>
<label>Petugas</label><select name="user_id" required><?php while($u=mysqli_fetch_assoc($petugas)){ ?><option value="<?= $u['id_user'] ?>" <?= (int)$data['user_id']===(int)$u['id_user']?'selected':'' ?>><?= htmlspecialchars($u['nama']) ?></option><?php } ?></select>
<label>Status</label><select name="status" required><option value="dipinjam" <?= $data['status']==='dipinjam'?'selected':'' ?>>dipinjam</option><option value="sudah dikembalikan" <?= $data['status']==='sudah dikembalikan'?'selected':'' ?>>sudah dikembalikan</option></select>
<label>Keterangan</label><textarea name="keterangan"><?= htmlspecialchars($data['keterangan']) ?></textarea><button type="submit">Simpan Perubahan</button></form></div></body></html>