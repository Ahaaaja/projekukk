<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/koneksi.php';

function wajib_login()
{
    if (empty($_SESSION['user_id']) || empty($_SESSION['role'])) {
        header('Location: ' . base_url('index.php'));
        exit;
    }
}

function punya_role($roles)
{
    wajib_login();
    if (!is_array($roles)) {
        $roles = array($roles);
    }

    return in_array($_SESSION['role'], $roles, true);
}

function wajib_role($roles)
{
    if (!punya_role($roles)) {
        http_response_code(403);
        die(
            '<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><title>Akses Ditolak</title>' .
            '<style>body{font-family:Arial;background:#f5f7fb;padding:40px;text-align:center}.box{max-width:500px;margin:auto;background:#fff;padding:30px;border-radius:16px;box-shadow:0 8px 30px #0001}a{display:inline-block;margin-top:15px;padding:10px 16px;background:#2563eb;color:#fff;text-decoration:none;border-radius:8px}</style>' .
            '</head><body><div class="box"><h2>Akses Ditolak</h2><p>Role Anda tidak memiliki izin untuk membuka halaman ini.</p><a href="' . htmlspecialchars(base_url('index1.php')) . '">Kembali ke Dashboard</a></div></body></html>'
        );
    }
}

function base_url($path = '')
{
    $script = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    $root = preg_replace('#/CRUD.*$#', '', $script);
    $root = rtrim($root, '/');
    return $root . '/' . ltrim($path, '/');
}

function dashboard_url()
{
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
    if ($role === 'admin') return base_url('dashboard_admin.php');
    if ($role === 'petugas') return base_url('dashboard_petugas.php');
    if ($role === 'anggota') return base_url('dashboard_anggota.php');
    return base_url('index.php');
}
?>
