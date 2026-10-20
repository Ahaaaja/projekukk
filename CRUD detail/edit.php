<?php
require_once __DIR__ . '/../auth.php';
wajib_role(array('admin','petugas'));
$id=(int)($_GET['id']??0);
$q=mysqli_query($koneksi,"SELECT pd.*,p.status,b.judul_buku,b.kode_buku FROM peminjaman_detail pd LEFT JOIN peminjaman p ON p.id_peminjaman=pd.peminjaman_id LEFT JOIN buku b ON b.id_buku=pd.buku_id WHERE pd.id_pd=$id");
$data=mysqli_fetch_assoc($q);if(!$data)die('Detail tidak ditemukan.');
$buku=mysqli_query($koneksi,"SELECT * FROM buku ORDER BY judul_buku ASC");
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>Edit Detail</title><link rel="stylesheet" href="../data.css"></head>
<body><div class="container formbox"><a class="back" href="index.php">← Kembali</a><h1>Edit Detail Peminjaman</h1><form method="post" action="proses_edit.php">
<input type="hidden" name="id_pd" value="<?= $id ?>"><input type="hidden" name="peminjaman_id" value="<?= $data['peminjaman_id'] ?>"><input type="hidden" name="status_lama" value="<?= htmlspecialchars($data['status']) ?>">
<label>Buku</label><select name="buku_id" required><?php while($b=mysqli_fetch_assoc($buku)){?><option value="<?= $b['id_buku'] ?>" <?= (int)$data['buku_id']===(int)$b['id_buku']?'selected':'' ?>><?= htmlspecialchars($b['kode_buku'].' - '.$b['judul_buku'].' (Stok: '.$b['stok'].')') ?></option><?php }?></select>
<label>Jumlah</label><input type="number" name="jumlah" min="1" value="<?= $data['jumlah'] ?>" required><button type="submit">Simpan Perubahan</button></form></div></body></html>