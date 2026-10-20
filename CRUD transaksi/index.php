<?php
require_once __DIR__ . '/../auth.php';
wajib_role(array('admin','petugas'));
$sql="SELECT p.*,a.kode_anggota,a.nama AS nama_anggota,u.nama AS nama_user,
GROUP_CONCAT(CONCAT(COALESCE(b.judul_buku,'Buku tidak ditemukan'),' (',pd.jumlah,')') SEPARATOR ', ') AS buku_dipinjam
FROM peminjaman p
LEFT JOIN anggota a ON a.id_anggota=p.anggota_id
LEFT JOIN user u ON u.id_user=p.user_id
LEFT JOIN peminjaman_detail pd ON pd.peminjaman_id=p.id_peminjaman
LEFT JOIN buku b ON b.id_buku=pd.buku_id
GROUP BY p.id_peminjaman ORDER BY p.id_peminjaman ASC";
$data=mysqli_query($koneksi,$sql);
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>Peminjaman</title><link rel="stylesheet" href="../data.css"></head>
<body><div class="container"><a class="back" href="../index1.php">← Dashboard</a><h1>Data Transaksi Peminjaman</h1>
<a class="button" href="tambah.php">+ Pinjam Buku</a> <a class="button" href="../CRUD detail/">Detail Peminjaman</a> <a class="button" href="../CRUD pengembalian/">Data Pengembalian</a>
<div class="table-wrap"><table><thead><tr><th>No</th><th>Anggota</th><th>Buku</th><th>Tanggal Pinjam</th><th>Lama</th><th>Tenggat</th><th>Denda Berjalan</th><th>Petugas</th><th>Status</th><th>Keterangan</th><th>Aksi</th></tr></thead><tbody>
<?php $no=1; while($row=mysqli_fetch_assoc($data)){ ?><tr>
<td><?= $no++ ?></td><td><?= htmlspecialchars(($row['kode_anggota']?:'-').' - '.($row['nama_anggota']?:'-')) ?></td><td><?= htmlspecialchars($row['buku_dipinjam']?:'-') ?></td>
<td><?= htmlspecialchars($row['tanggal_pinjam']) ?></td><td><?= $row['lama_pinjam']!==null ? $row['lama_pinjam'].' hari':'-' ?></td><?php $tenggat = date('Y-m-d', strtotime($row['tanggal_pinjam'].' +'.(int)$row['lama_pinjam'].' days')); $telat = $row['status']==='dipinjam' ? max(0, (int)floor((strtotime(date('Y-m-d'))-strtotime($tenggat))/86400)) : 0; ?><td><?= htmlspecialchars($tenggat) ?></td><td>Rp<?= number_format($telat*2000,0,',','.') ?></td><td><?= htmlspecialchars($row['nama_user']?:'-') ?></td>
<td><?= htmlspecialchars($row['status']) ?></td><td><?= htmlspecialchars($row['keterangan']?:'-') ?></td>
<td class="aksi"><a href="edit.php?id=<?= $row['id_peminjaman'] ?>">Edit</a><a class="danger" href="hapus.php?id=<?= $row['id_peminjaman'] ?>" onclick="return confirm('Hapus transaksi ini? Stok akan disesuaikan.')">Hapus</a>
<?php if($row['status']==='dipinjam'){ ?><a href="pengembalian.php?id=<?= $row['id_peminjaman'] ?>">Kembalikan</a><?php } ?></td></tr><?php } ?>
<?php if(mysqli_num_rows($data)===0){ ?><tr><td colspan="11" class="empty">Belum ada transaksi.</td></tr><?php } ?>
</tbody></table></div></div></body></html>