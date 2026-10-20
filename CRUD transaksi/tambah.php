<?php
require_once __DIR__ . '/../auth.php';
wajib_login();
if (!in_array($_SESSION['role'], array('petugas', 'anggota'), true)) {
    http_response_code(403);
    die('Akses ditolak.');
}
$buku = mysqli_query($koneksi, "SELECT * FROM buku WHERE CAST(stok AS UNSIGNED)>0 ORDER BY judul_buku ASC");
$anggota = null;
$petugas = null;
if ($_SESSION['role'] !== 'anggota') {
    $anggota = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY nama ASC");
    $petugas = mysqli_query($koneksi, "SELECT * FROM user WHERE role IN ('admin','petugas') ORDER BY nama ASC");
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Pinjam Buku</title>
    <link rel="stylesheet" href="../data.css">
</head>

<body>
    <div class="container formbox"><a class="back" href="../index1.php">← Dashboard</a>
        <h1>Pinjam Buku</h1>
        <form method="post" action="proses_tambah.php">
            <?php if ($_SESSION['role'] === 'anggota') { ?>
                <p><b>Anggota:</b> <?= htmlspecialchars($_SESSION['nama']) ?></p>
                <input type="hidden" name="anggota_id" value="<?= (int) $_SESSION['anggota_id'] ?>">
            <?php } else { ?>
                <label>Anggota</label><select name="anggota_id" required>
                    <option value="">-- Pilih Anggota --</option><?php while ($a = mysqli_fetch_assoc($anggota)) { ?>
                        <option value="<?= $a['id_anggota'] ?>"><?= htmlspecialchars($a['kode_anggota'] . ' - ' . $a['nama']) ?>
                        </option><?php } ?>
                </select>
            <?php } ?>
            <label>Buku</label><select name="buku_id" required>
                <option value="">-- Pilih Buku --</option><?php while ($b = mysqli_fetch_assoc($buku)) { ?>
                    <option value="<?= $b['id_buku'] ?>">
                        <?= htmlspecialchars($b['kode_buku'] . ' - ' . $b['judul_buku'] . ' (Stok: ' . $b['stok'] . ')') ?></option>
                <?php } ?>
            </select>
            <label>Jumlah</label><input type="number" name="jumlah" min="1" value="1" required>
            <label>Tanggal Pinjam</label><input type="date" name="tanggal_pinjam" value="<?= date('Y-m-d') ?>" required>
            <label>Lama Pinjam (hari)</label><input type="number" name="lama_pinjam" min="1" value="7" required>
            <?php if ($_SESSION['role'] !== 'anggota') { ?><label>Petugas</label><select name="user_id" required>
                    <option value="">-- Pilih Petugas --</option><?php while ($u = mysqli_fetch_assoc($petugas)) { ?>
                        <option value="<?= $u['id_user'] ?>" <?= (int) $u['id_user'] === (int) $_SESSION['user_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($u['nama'] . ' (' . $u['role'] . ')') ?></option><?php } ?>
                </select><?php } ?>
            <label>Keterangan</label><textarea name="keterangan" placeholder="Keterangan peminjaman"></textarea>
            <button type="submit">Simpan Peminjaman</button>
        </form>
    </div>
</body>

</html>