<?php
require_once __DIR__ . '/../auth.php';
wajib_role('admin');
$user = mysqli_query($koneksi, "SELECT u.*, a.nama AS nama_anggota FROM user u LEFT JOIN anggota a ON a.id_anggota=u.anggota_id ORDER BY u.id_user ASC");
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>Data User</title><link rel="stylesheet" href="../data.css"></head>
<body><div class="container"><a class="back" href="../index1.php">← Dashboard</a><h1>Data User</h1><a class="button" href="tambah.php">+ Tambah User</a>
<div class="table-wrap"><table><thead><tr><th>No</th><th>Nama</th><th>Username</th><th>Password</th><th>Role</th><th>Anggota</th><th>Aksi</th></tr></thead><tbody>
<?php $no=1; while($row=mysqli_fetch_assoc($user)){ ?><tr>
<td><?= $no++ ?></td><td><?= htmlspecialchars($row['nama']) ?></td><td><?= htmlspecialchars($row['username']) ?></td><td><?= htmlspecialchars($row['password']) ?></td>
<td><?= htmlspecialchars($row['role']) ?></td><td><?= $row['nama_anggota'] ? htmlspecialchars($row['nama_anggota']) : '-' ?></td>
<td class="aksi"><a href="edit.php?id=<?= $row['id_user'] ?>">Edit</a><a class="danger" href="hapus.php?id=<?= $row['id_user'] ?>" onclick="return confirm('Hapus user ini?')">Hapus</a></td>
</tr><?php } if(mysqli_num_rows($user)===0){ ?><tr><td colspan="7" class="empty">Belum ada data user.</td></tr><?php } ?>
</tbody></table></div></div></body></html>