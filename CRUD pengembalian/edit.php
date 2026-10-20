<?php
require_once __DIR__ . '/../auth.php';
wajib_role(array('admin', 'petugas'));
$id = (int) ($_GET['id'] ?? 0);
$q = mysqli_query($koneksi, "SELECT * FROM pengembalian WHERE id_pengembalian=$id");
$d = mysqli_fetch_assoc($q);
if (!$d)
    die('Data pengembalian tidak ditemukan.');
$u = mysqli_query($koneksi, "SELECT * FROM user WHERE role IN ('admin','petugas') ORDER BY nama ASC");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Edit Pengembalian</title>
    <link rel="stylesheet" href="../data.css">
</head>

<body>
    <div class="container formbox"><a class="back" href="index.php">← Kembali</a>
        <h1>Edit Pengembalian</h1>
        <form method="post" action="proses_edit.php">
            <input type="hidden" name="id_pengembalian" value="<?= $id ?>"><label>Tanggal Kembali</label><input
                type="date" name="tanggal_kembali" value="<?= $d['tanggal_kembali'] ?>" required>
            <label>Petugas</label><select name="user_id" required><?php while ($x = mysqli_fetch_assoc($u)) { ?>
                    <option value="<?= $x['id_user'] ?>" <?= (int) $x['id_user'] === (int) $d['user_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($x['nama'] . ' (' . $x['role'] . ')') ?></option><?php } ?>
            </select>
            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</body>

</html>