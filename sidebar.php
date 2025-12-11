<?php
// sidebar.php
$user  = $user ?? current_user();
$role  = $user['role'] ?? 'guest';

function is_active(string $page, string $currentPage): string {
    return $page === $currentPage ? 'active app-nav-active' : '';
}

$roleBasePath = $roleBasePath ?? '';
$baseUrl      = $baseUrl      ?? '/siakad';
?>
<!-- Overlay untuk mobile -->
<div class="app-sidebar-overlay d-lg-none"></div>

<aside class="app-sidebar bg-white shadow-sm">
    <div class="app-sidebar-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <div class="app-logo-square">
                <span>DA</span>
            </div>
            <div>
                <div class="fw-semibold small text-uppercase">Depati Akademi</div>
                <div class="extra-small text-light opacity-75">SIAKAD • LPK Mode</div>
            </div>
        </div>
        <span class="badge rounded-pill bg-warning text-dark extra-small d-none d-lg-inline">
            <i class="bi bi-stars me-1"></i> Prototype
        </span>
    </div>

    <div class="app-sidebar-body">
        <nav class="nav flex-column">
            <!-- Dashboard -->
            <a href="<?= $baseUrl . $roleBasePath ?>/index.php"
               class="nav-link app-nav-link d-flex align-items-center <?= is_active('dashboard', $currentPage) ?>">
                <span class="app-nav-icon">
                    <i class="bi bi-speedometer2"></i>
                </span>
                <span>Dashboard</span>
            </a>

            <?php if ($role === 'superadmin'): ?>
                <div class="app-nav-section mt-3">
                    <span class="fw-bold text-primary small letter-spacing-1">MASTER CONTROL</span>
                </div>
                <a href="<?= $baseUrl . $roleBasePath ?>/companies.php"
                   class="nav-link app-nav-link d-flex align-items-center <?= is_active('companies', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-buildings text-primary"></i>
                    </span>
                    <span>Manajemen LPK</span>
                </a>
                <a href="<?= $baseUrl . $roleBasePath ?>/users.php"
                   class="nav-link app-nav-link d-flex align-items-center <?= is_active('users', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-shield-lock text-info"></i>
                    </span>
                    <span>Akun Admin LPK</span>
                </a>

                <div class="app-nav-section mt-3">
                    <span class="fw-bold text-primary small letter-spacing-1">MONITORING</span>
                </div>
                <a href="<?= $baseUrl . $roleBasePath ?>/logs.php"
                   class="nav-link app-nav-link d-flex align-items-center <?= is_active('logs', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-activity text-warning"></i>
                    </span>
                    <span>System Logs</span>
                </a>
                <a href="javascript:void(0)" onclick="alert('Fitur Billing akan hadir di versi 2.0')"
                   class="nav-link app-nav-link d-flex align-items-center">
                    <span class="app-nav-icon">
                        <i class="bi bi-credit-card-2-front text-success"></i>
                    </span>
                    <span>Billing & License</span>
                    <span class="badge bg-primary-subtle text-primary ms-auto extra-small">Pro</span>
                </a>

                <div class="app-nav-section mt-3">
                    <span class="fw-bold text-primary small letter-spacing-1">PLATFORM</span>
                </div>
                <a href="javascript:void(0)" onclick="alert('Pengaturan Global')"
                   class="nav-link app-nav-link d-flex align-items-center">
                    <span class="app-nav-icon">
                        <i class="bi bi-hdd-rack text-secondary"></i>
                    </span>
                    <span>Server Status</span>
                </a>
                <a href="javascript:void(0)" onclick="alert('Maintenance Mode')"
                   class="nav-link app-nav-link d-flex align-items-center">
                    <span class="app-nav-icon">
                        <i class="bi bi-toggle-on text-danger"></i>
                    </span>
                    <span>Maintenance</span>
                </a>
            <?php endif; ?>

            <?php if ($role === 'admin'): ?>
                <div class="app-nav-section mt-3">Master Data</div>
                <a href="<?= $baseUrl . $roleBasePath ?>/program.php"
                   class="nav-link app-nav-link d-flex align-items-center <?= is_active('program', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-journal-text"></i>
                    </span>
                    <span>Program & Modul</span>
                </a>
                <a href="<?= $baseUrl . $roleBasePath ?>/kelas.php"
                   class="nav-link app-nav-link d-flex align-items-center <?= is_active('kelas', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-easel"></i>
                    </span>
                    <span>Manajemen Kelas</span>
                </a>
                <a href="<?= $baseUrl . $roleBasePath ?>/peserta.php"
                   class="nav-link app-nav-link d-flex align-items-center <?= is_active('peserta', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-people-fill"></i>
                    </span>
                    <span>Manajemen Peserta</span>
                </a>
                <a href="<?= $baseUrl . $roleBasePath ?>/instruktur.php"
                   class="nav-link app-nav-link d-flex align-items-center <?= is_active('instruktur', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-person-badge"></i>
                    </span>
                    <span>Tutor / Instruktur</span>
                </a>
                <a href="<?= $baseUrl . $roleBasePath ?>/ruangan.php"
                   class="nav-link app-nav-link d-flex align-items-center <?= is_active('ruangan', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-building"></i>
                    </span>
                    <span>Manajemen Ruangan</span>
                </a>

                <div class="app-nav-section mt-3">Akademik</div>
                <a href="<?= $baseUrl . $roleBasePath ?>/jadwal.php"
                   class="nav-link app-nav-link d-flex align-items-center <?= is_active('jadwal', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-calendar-week"></i>
                    </span>
                    <span>Jadwal</span>
                </a>
                <a href="<?= $baseUrl . $roleBasePath ?>/elearning.php"
                   class="nav-link app-nav-link d-flex align-items-center <?= is_active('elearning', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-laptop"></i>
                    </span>
                    <span>E-Learning & PR</span>
                </a>
                <a href="<?= $baseUrl . $roleBasePath ?>/ujian.php"
                   class="nav-link app-nav-link d-flex align-items-center <?= is_active('ujian', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-patch-question"></i>
                    </span>
                    <span>Ujian</span>
                </a>
                <a href="<?= $baseUrl . $roleBasePath ?>/raport.php"
                   class="nav-link app-nav-link d-flex align-items-center <?= is_active('raport', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </span>
                    <span>Raport & Sertifikat</span>
                </a>

                <div class="app-nav-section mt-3">WA Blast</div>
                <a href="<?= $baseUrl . $roleBasePath ?>/wa-reminder.php"
                   class="nav-link app-nav-link d-flex align-items-center <?= is_active('wa-reminder', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-whatsapp"></i>
                    </span>
                    <span>Reminder Kelas</span>
                </a>

                <div class="app-nav-section mt-3">Laporan</div>
                <a href="<?= $baseUrl . $roleBasePath ?>/laporan-tutor.php"
                   class="nav-link app-nav-link d-flex align-items-center <?= is_active('laporan-tutor', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-clipboard-data"></i>
                    </span>
                    <span>Laporan Tutor Mengajar</span>
                </a>

                <div class="app-nav-section mt-3">Arsip</div>
                <a href="<?= $baseUrl . $roleBasePath ?>/arsip.php"
                   class="nav-link app-nav-link d-flex align-items-center <?= is_active('arsip', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-archive"></i>
                    </span>
                    <span>Data Arsip</span>
                </a>

                <div class="app-nav-section mt-3">Manajemen Dokumen</div>
                <a href="<?= $baseUrl . $roleBasePath ?>/template_raport.php"
                   class="nav-link app-nav-link d-flex align-items-center <?= is_active('template-raport', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-file-earmark-pdf"></i>
                    </span>
                    <span>Template Dokumen</span>
                </a>
            <?php endif; ?>

            <?php if ($role === 'tutor'): ?>
                <div class="app-nav-section mt-3">Daftar Modul</div>

                <!-- GRUP: MODUL -->
                <a href="<?= $baseUrl . $roleBasePath ?>/modul-kelas.php"
                class="nav-link app-nav-link d-flex align-items-center <?= is_active('modul-kelas', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-easel2"></i>
                    </span>
                    <span>Modul Kelas</span>
                </a>

                <a href="<?= $baseUrl . $roleBasePath ?>/modul-soal.php"
                class="nav-link app-nav-link d-flex align-items-center <?= is_active('modul-soal', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-patch-question"></i>
                    </span>
                    <span>Modul Soal</span>
                </a>

                <a href="<?= $baseUrl . $roleBasePath ?>/modul-ujian.php"
                class="nav-link app-nav-link d-flex align-items-center <?= is_active('modul-ujian', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-ui-checks-grid"></i>
                    </span>
                    <span>Modul Ujian</span>
                </a>

                <div class="app-nav-section mt-3">Active</div>
                <!-- GRUP: AKTIF -->
                <a href="<?= $baseUrl . $roleBasePath ?>/kelas-aktif.php"
                class="nav-link app-nav-link d-flex align-items-center <?= is_active('kelas-aktif', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-collection"></i>
                    </span>
                    <span>Kelas Aktif</span>
                </a>

                <a href="<?= $baseUrl . $roleBasePath ?>/ujian-aktif.php"
                class="nav-link app-nav-link d-flex align-items-center <?= is_active('ujian-aktif', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-clipboard-check"></i>
                    </span>
                    <span>Ujian Aktif</span>
                </a>

                <div class="app-nav-section mt-3">Arsip</div>

                <a href="<?= $baseUrl . $roleBasePath ?>/arsip-kelas.php"
                class="nav-link app-nav-link d-flex align-items-center <?= is_active('arsip-kelas', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-archive"></i>
                    </span>
                    <span>Arsip Kelas</span>
                </a>

                <a href="<?= $baseUrl . $roleBasePath ?>/arsip-ujian.php"
                class="nav-link app-nav-link d-flex align-items-center <?= is_active('arsip-ujian', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-journal-check"></i>
                    </span>
                    <span>Arsip Ujian</span>
                </a>
            <?php endif; ?>


            <?php if ($role === 'peserta'): ?>
                <div class="app-nav-section mt-3">Peserta</div>
                <a href="<?= $baseUrl . $roleBasePath ?>/kelas.php"
                   class="nav-link app-nav-link d-flex align-items-center <?= is_active('kelas', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-easel"></i>
                    </span>
                    <span>Kelas</span>
                </a>
                <a href="<?= $baseUrl . $roleBasePath ?>/tugas.php"
                   class="nav-link app-nav-link d-flex align-items-center <?= is_active('tugas', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-journal-check"></i>
                    </span>
                    <span>Ujian</span>
                </a>
                <a href="<?= $baseUrl . $roleBasePath ?>/raport.php"
                   class="nav-link app-nav-link d-flex align-items-center <?= is_active('raport', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-award"></i>
                    </span>
                    <span>Raport & Sertifikat</span>
                </a>

                <div class="app-nav-section mt-3">Akun</div>
                <a href="<?= $baseUrl . $roleBasePath ?>/akun.php"
                   class="nav-link app-nav-link d-flex align-items-center <?= is_active('akun', $currentPage) ?>">
                    <span class="app-nav-icon">
                        <i class="bi bi-person-gear"></i>
                    </span>
                    <span>Pengaturan Akun</span>
                </a>
            <?php endif; ?>
        </nav>
    </div>
</aside>
