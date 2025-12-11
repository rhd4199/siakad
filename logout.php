<?php
require_once __DIR__ . '/config.php';

logout();
header('Location: /siakad/login.php');
exit;
