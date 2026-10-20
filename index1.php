<?php
require_once __DIR__ . '/auth.php';
wajib_login();

$target = dashboard_url();
header('Location: ' . $target);
exit;
?>
