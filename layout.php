<?php
// layout.php
require_once __DIR__ . '/config.php';

$user = current_user();
if (!$user) {
    header('Location: /siakad/login.php');
    exit;
}

$title        = $title        ?? 'SIAKAD LPK';
$content      = $content      ?? '';
$currentPage  = $currentPage  ?? '';
$roleBasePath = $roleBasePath ?? ''; // misal: '/admin', '/superadmin', dst
$baseUrl      = '/siakad';
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title) ?> - SIAKAD LPK</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/custom.css">
</head>
<body class="app-body">

<div class="app-shell d-flex">
    <?php include __DIR__ . '/sidebar.php'; ?>

    <main class="app-main flex-grow-1">
        <!-- TOPBAR -->
        <nav class="app-topbar navbar navbar-expand-lg bg-white shadow-sm">
            <div class="container-fluid">
                <div class="d-flex align-items-center gap-2">
                    <!-- Sidebar toggle (mobile) -->
                    <button class="btn btn-sm btn-outline-secondary d-lg-none" type="button" data-sidebar-toggle>
                        <i class="bi bi-list"></i>
                    </button>
                    <div>
                        <div class="fw-semibold d-flex align-items-center gap-2">
                            <span class="badge rounded-pill app-badge-brand">
                                <i class="bi bi-mortarboard me-1"></i> SIAKAD LPK
                            </span>
                            <span class="small text-muted d-none d-sm-inline">
                                / <?= htmlspecialchars(ucfirst($user['role'])) ?>
                            </span>
                        </div>
                        <div class="small text-muted d-none d-md-block">
                            Panel akademik Depati Akademi – versi prototype
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <a href="<?= $baseUrl ?>/portal.php" class="btn btn-primary btn-sm rounded-pill d-none d-md-inline-flex align-items-center gap-2 shadow-sm">
                        <i class="bi bi-grid-fill"></i> Ganti Modul
                    </a>

                    <div class="text-end d-none d-sm-block">
                        <div class="small text-muted">Login sebagai</div>
                        <div class="fw-semibold"><?= htmlspecialchars($user['name']) ?></div>
                        <div class="small text-muted"><?= htmlspecialchars($user['email']) ?></div>
                    </div>
                    <div class="app-avatar d-none d-sm-flex">
                        <span>
                            <?= strtoupper(substr($user['name'], 0, 1)) ?>
                        </span>
                    </div>
                    <a href="<?= $baseUrl ?>/logout.php" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </a>
                </div>
            </div>
        </nav>

        <!-- CONTENT -->
        <div class="app-content container-fluid py-4">
            <?= $content ?>
        </div>
    </main>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= $baseUrl ?>/assets/js/main.js"></script>

<script>
    // Toggle sidebar di mobile
    $(function () {
        $('[data-sidebar-toggle]').on('click', function () {
            $('body').toggleClass('sidebar-open');
        });
        // klik di overlay nutup sidebar
        $('.app-sidebar-overlay').on('click', function () {
            $('body').removeClass('sidebar-open');
        });
    });
</script>
</body>
</html>
