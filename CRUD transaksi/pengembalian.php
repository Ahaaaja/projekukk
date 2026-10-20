<?php
require_once __DIR__ . '/../auth.php';
wajib_role(array('admin','petugas'));
$id=(int)($_GET['id']??0);
$q=mysqli_query($koneksi,"SELECT p.*,a.nama AS nama_anggota,GROUP_CONCAT(CONCAT(COALESCE(b.judul_buku,'-'),' (',pd.jumlah,')') SEPARATOR ', ') AS buku_dipinjam FROM peminjaman p LEFT JOIN anggota a ON a.id_anggota=p.anggota_id LEFT JOIN peminjaman_detail pd ON pd.peminjaman_id=p.id_peminjaman LEFT JOIN buku b ON b.id_buku=pd.buku_id WHERE p.id_peminjaman=$id GROUP BY p.id_peminjaman");
$row=mysqli_fetch_assoc($q); if(!$row)die('Data peminjaman tidak ditemukan.'); if($row['status']==='sudah dikembalikan')die('Buku sudah dikembalikan.');
$tenggat = date('Y-m-d', strtotime($row['tanggal_pinjam'] . ' +' . (int)$row['lama_pinjam'] . ' days'));
$hari_terlambat = max(0, (int) floor((strtotime(date('Y-m-d')) - strtotime($tenggat)) / 86400));
$estimasi_denda = $hari_terlambat * 2000;
$petugas=mysqli_query($koneksi,"SELECT * FROM user WHERE role IN ('admin','petugas') ORDER BY nama ASC");
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>Pengembalian Buku</title><link rel="stylesheet" href="../data.css"></head>
<body><div class="container formbox"><a class="back" href="index.php">← Kembali</a><h1>Pengembalian Buku</h1>
<p><b>Anggota:</b> <?= htmlspecialchars($row['nama_anggota']) ?></p><p><b>Buku:</b> <?= htmlspecialchars($row['buku_dipinjam']) ?></p><p><b>Tanggal Pinjam:</b> <?= $row['tanggal_pinjam'] ?></p><p><b>Tenggat Pengembalian:</b> <?= $tenggat ?></p><p><b>Estimasi denda jika dikembalikan hari ini:</b> Rp<?= number_format($estimasi_denda, 0, ',', '.') ?> (Rp2.000 per hari keterlambatan)</p>
<form method="post" action="proses_pengembalian.php"><input type="hidden" name="id_peminjaman" value="<?= $id ?>">
<label>Tanggal Kembali</label><input type="date" name="tanggal_kembali" value="<?= date('Y-m-d') ?>" required>
<label>Petugas</label><select name="user_id" required><option value="">-- Pilih Petugas --</option><?php while($u=mysqli_fetch_assoc($petugas)){ ?><option value="<?= $u['id_user'] ?>" <?= (int)$u['id_user']===(int)$_SESSION['user_id']?'selected':'' ?>><?= htmlspecialchars($u['nama'].' ('.$u['role'].')') ?></option><?php } ?></select>
<button type="submit">Simpan Pengembalian</button></form></div></body></html>