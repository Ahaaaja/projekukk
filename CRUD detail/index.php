<?php
require_once __DIR__ . '/../auth.php';
wajib_role(array('admin','petugas'));
$sql="SELECT pd.*,p.tanggal_pinjam,p.status,a.kode_anggota,a.nama AS nama_anggota,b.kode_buku,b.judul_buku
FROM peminjaman_detail pd LEFT JOIN peminjaman p ON p.id_peminjaman=pd.peminjaman_id
LEFT JOIN anggota a ON a.id_anggota=p.anggota_id LEFT JOIN buku b ON b.id_buku=pd.buku_id
ORDER BY pd.id_pd ASC";
$data=mysqli_query($koneksi,$sql);
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>Detail Peminjaman</title><link rel="stylesheet" href="../data.css"></head>
<body><div class="container"><a class="back" href="../index1.php">← Dashboard</a><h1>Detail Peminjaman</h1><a class="button" href="../CRUD transaksi/">← Data Peminjaman</a>
<div class="table-wrap"><table><thead><tr><th>No</th><th>ID Peminjaman</th><th>Anggota</th><th>Buku</th><th>Jumlah</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
<?php $no=1;while($r=mysqli_fetch_assoc($data)){?><tr><td><?= $no++ ?></td><td><?= $r['peminjaman_id'] ?></td><td><?= htmlspecialchars(($r['kode_anggota']?:'-').' - '.($r['nama_anggota']?:'-')) ?></td><td><?= htmlspecialchars(($r['kode_buku']?:'-').' - '.($r['judul_buku']?:'Buku tidak ditemukan')) ?></td><td><?= $r['jumlah'] ?></td><td><?= $r['tanggal_pinjam']?:'-' ?></td><td><?= $r['status']?:'-' ?></td><td class="aksi"><a href="edit.php?id=<?= $r['id_pd'] ?>">Edit</a><a class="danger" href="hapus.php?id=<?= $r['id_pd'] ?>" onclick="return confirm('Hapus detail ini?')">Hapus</a></td></tr><?php } if(mysqli_num_rows($data)===0){?><tr><td colspan="8" class="empty">Belum ada detail peminjaman.</td></tr><?php }?></tbody></table></div></div></body></html>