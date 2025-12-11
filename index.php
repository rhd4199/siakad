<?php
require_once __DIR__ . '/config.php';

$user = current_user();
if (!$user) {
    header('Location: /siakad/login.php');
    exit;
}

switch ($user['role']) {
    case 'superadmin':
        header('Location: /siakad/superadmin/index.php');
        break;
    case 'admin':
        header('Location: /siakad/admin/index.php');
        break;
    case 'tutor':
        header('Location: /siakad/tutor/index.php');
        break;
    case 'peserta':
        header('Location: /siakad/peserta/index.php');
        break;
    default:
        echo "Role tidak dikenali.";
}
exit;
