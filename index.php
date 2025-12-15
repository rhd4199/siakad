<?php
require_once __DIR__ . '/config.php';

$user = current_user();
if (!$user) {
    header('Location: /siakad/login.php');
    exit;
}

// Jika Superadmin, langsung ke dashboard khususnya (Master Control)
if ($user['role'] === 'superadmin') {
    header('Location: /siakad/superadmin/index.php');
    exit;
}

// Untuk role lain (Admin, Tutor, Peserta), masuk ke Portal Modul LMS
header('Location: /siakad/portal.php');
exit;
