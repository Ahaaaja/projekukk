<?php
session_start();
require_once __DIR__ . '/koneksi.php';
if (!empty($_SESSION['user_id']) && !empty($_SESSION['role'])) { header('Location: index1.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 $nama=trim($_POST['nama']??''); $username=trim($_POST['username']??'');
 $password=trim($_POST['password']??''); $jk=$_POST['jenis_kelamin']??'';
 $telp=trim($_POST['telp']??''); $alamat=trim($_POST['alamat']??'');
 if($nama===''||$username===''||$password===''||$telp===''||$alamat===''||!in_array($jk,['pria','wanita'],true)) $error='Lengkapi data wajib dengan benar.';
 else {
  $cek=mysqli_prepare($koneksi,"SELECT id_user FROM user WHERE username=? LIMIT 1");
  mysqli_stmt_bind_param($cek,"s",$username); mysqli_stmt_execute($cek);
  if(mysqli_num_rows(mysqli_stmt_get_result($cek))>0) $error='Username sudah digunakan.';
  else {
   mysqli_begin_transaction($koneksi);
   try {
    $kode='AGT'.strtoupper(substr(bin2hex(random_bytes(4)),0,6));
    $s=mysqli_prepare($koneksi,"INSERT INTO anggota (kode_anggota,nama,jenis_kelamin,telp,alamat) VALUES (?,?,?,?,?)");
    mysqli_stmt_bind_param($s,"sssss",$kode,$nama,$jk,$telp,$alamat);
    if(!mysqli_stmt_execute($s)) throw new Exception();
    $aid=mysqli_insert_id($koneksi); $role='anggota';
    $s=mysqli_prepare($koneksi,"INSERT INTO user (nama,username,password,role,anggota_id) VALUES (?,?,?,?,?)");
    mysqli_stmt_bind_param($s,"ssssi",$nama,$username,$password,$role,$aid);
    if(!mysqli_stmt_execute($s)) throw new Exception();
    mysqli_commit($koneksi); header('Location: index.php?daftar=berhasil'); exit;
   } catch(Throwable $e) { mysqli_rollback($koneksi); $error='Pendaftaran gagal. Periksa database lalu coba lagi.'; }
  }
 }
}
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Register Anggota</title>
<style>
*{box-sizing:border-box}body{margin:0;font-family:Arial;background:#f4f6f8;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px;color:#172033}
.card{width:100%;max-width:440px;background:white;padding:30px;border-radius:18px;box-shadow:0 15px 45px #1e3a8a20}h2{text-align:center;margin-top:0}
label{display:block;font-weight:bold;margin:13px 0 6px}input,select,textarea{width:100%;padding:11px;border:1px solid #cbd5e1;border-radius:9px;font-size:15px}
button{width:100%;margin-top:20px;padding:12px;border:0;border-radius:9px;background:#222;color:white;font-weight:bold}.error{margin-top:14px;padding:11px;background:#fee2e2;color:#991b1b;border-radius:9px}.foot{text-align:center;margin-top:18px}a{color:#2563eb}
</style></head><body><div class="card"><h2>Daftar Anggota</h2><form method="post">
<label>Nama Lengkap</label><input name="nama" required>
<label>Username</label><input name="username" required autocomplete="username">
<label>Password</label><input type="password" name="password" required autocomplete="new-password">
<label>Jenis Kelamin</label><select name="jenis_kelamin" required><option value="">Pilih jenis kelamin</option><option value="pria">Pria</option><option value="wanita">Wanita</option></select>
<label>No. Telepon</label><input name="telp" required>
<label>Alamat</label><textarea name="alamat" rows="3" required></textarea>
<button type="submit">Daftar</button></form>
<?php if($error!==''): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<div class="foot">Sudah punya akun? <a href="index.php">Login</a></div></div></body></html>