<?php
// sidebar.php
$user  = $user ?? current_user();
$role  = $user['role'] ?? 'guest';

// Ambil Active Module dari Session
$activeModule = $_SESSION['active_module'] ?? null;

// Nama Modul untuk Display
$moduleNames = [
    'sim' => 'SIM Akademik',
    'elearning' => 'E-Learning',
    'cbt' => 'Ujian Online (CBT)',
    'raport' => 'Raport & Sertifikat'
];
$currentModuleName = $moduleNames[$activeModule] ?? 'Dashboard';

function is_active(string $page, string $currentPage): string {
    return $page === $currentPage ? 'active app-nav-active' : '';
}

$roleBasePath = $roleBasePath ?? '';
$baseUrl      = $baseUrl      ?? '/siakad';
?>
<!-- Overlay untuk mobile -->
<div class="app-sidebar-overlay d-lg-none"></div>

<aside class="app-sidebar bg-white shadow-sm d-flex flex-column">
    <div class="app-sidebar-header d-flex align-items-center justify-content-between flex-shrink-0">
        <div class="d-flex align-items-center gap-2">
            <div class="app-logo-square bg-primary text-white">
                <span>DA</span>
            </div>
            <div class="overflow-hidden">
                <div class="fw-bold small text-uppercase text-truncate">LMS DEPATI</div>
                <div class="extra-small text-muted text-truncate"><?= $currentModuleName ?></div>
            </div>
        </div>
    </div>

    <!-- Tombol Ganti Modul -->
    <div class="px-3 mb-2 mt-2">
        <a href="<?= $baseUrl ?>/portal.php" class="btn btn-outline-primary btn-sm w-100 d-flex align-items-center justify-content-center gap-2">
            <i class="bi bi-grid-fill"></i> Ganti Modul
        </a>
    </div>

    <div class="app-sidebar-body flex-grow-1 overflow-y-auto">
        <nav class="nav flex-column">
            
            <!-- Dashboard selalu ada -->
            <a href="<?= $baseUrl . $roleBasePath ?>/index.php"
               class="nav-link app-nav-link d-flex align-items-center <?= is_active('dashboard', $currentPage) ?>">
                <span class="app-nav-icon">
                    <i class="bi bi-speedometer2"></i>
                </span>
                <span>Dashboard</span>
            </a>

            <!-- SUPERADMIN (Tetap Full Access / Master Control) -->
            <?php if ($role === 'superadmin'): ?>
                <div class="app-nav-section mt-3">MASTER CONTROL</div>
                <a href="<?= $baseUrl . $roleBasePath ?>/companies.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('companies', $currentPage) ?>">
                    <span class="app-nav-icon"><i class="bi bi-buildings"></i></span> <span>Manajemen LPK</span>
                </a>
                <a href="<?= $baseUrl . $roleBasePath ?>/users.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('users', $currentPage) ?>">
                    <span class="app-nav-icon"><i class="bi bi-shield-lock"></i></span> <span>Akun Admin</span>
                </a>
                <a href="<?= $baseUrl . $roleBasePath ?>/logs.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('logs', $currentPage) ?>">
                    <span class="app-nav-icon"><i class="bi bi-activity"></i></span> <span>System Logs</span>
                </a>

                <div class="mt-auto"></div>
                <div class="app-nav-section mt-3">Pengaturan</div>
                <a href="<?= $baseUrl . $roleBasePath ?>/akun.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('akun', $currentPage) ?>">
                    <span class="app-nav-icon"><i class="bi bi-person-gear"></i></span> <span>Pengaturan Akun</span>
                </a>
            <?php endif; ?>

            <!-- ADMIN MENU PER MODUL -->
            <?php if ($role === 'admin'): ?>
                
                <?php if ($activeModule === 'sim'): ?>
                    <div class="app-nav-section mt-3">Manajemen Data</div>
                    <a href="<?= $baseUrl . $roleBasePath ?>/program.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('program', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-journal-text"></i></span> <span>Program & Modul</span>
                    </a>
                    <a href="<?= $baseUrl . $roleBasePath ?>/kelas.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('kelas', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-easel"></i></span> <span>Manajemen Kelas</span>
                    </a>
                    <a href="<?= $baseUrl . $roleBasePath ?>/peserta.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('peserta', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-people-fill"></i></span> <span>Manajemen Peserta</span>
                    </a>
                    <a href="<?= $baseUrl . $roleBasePath ?>/instruktur.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('instruktur', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-person-badge"></i></span> <span>Tutor / Instruktur</span>
                    </a>
                    <a href="<?= $baseUrl . $roleBasePath ?>/ruangan.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('ruangan', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-building"></i></span> <span>Manajemen Ruangan</span>
                    </a>
                    
                    <div class="app-nav-section mt-3">Operasional</div>
                    <a href="<?= $baseUrl . $roleBasePath ?>/jadwal.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('jadwal', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-calendar-week"></i></span> <span>Jadwal Pelajaran</span>
                    </a>
                    <a href="<?= $baseUrl . $roleBasePath ?>/ujian.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('ujian', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-calendar2-event"></i></span> <span>Jadwal Ujian</span>
                    </a>
                    <a href="<?= $baseUrl . $roleBasePath ?>/wa-reminder.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('wa-reminder', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-whatsapp"></i></span> <span>Reminder WA</span>
                    </a>

                    <!-- Admin E-Learning & CBT (Digabung ke SIM) -->
                    <div class="app-nav-section mt-3">E-Learning & CBT</div>
                    <a href="<?= $baseUrl . $roleBasePath ?>/elearning.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('elearning', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-laptop"></i></span> <span>Monitoring Kelas</span>
                    </a>
                    
                    <div class="app-nav-section mt-3">Laporan & Arsip</div>
                    <a href="<?= $baseUrl . $roleBasePath ?>/laporan-tutor.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('laporan-tutor', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-clipboard-data"></i></span> <span>Laporan Mengajar</span>
                    </a>
                    <a href="<?= $baseUrl . $roleBasePath ?>/arsip.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('arsip', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-archive"></i></span> <span>Arsip Kelas</span>
                    </a>
                    <a href="<?= $baseUrl . $roleBasePath ?>/arsip.php?type=ujian" class="nav-link app-nav-link d-flex align-items-center <?= is_active('arsip-ujian', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-journal-check"></i></span> <span>Arsip Ujian</span>
                    </a>
                    <a href="<?= $baseUrl . $roleBasePath ?>/arsip.php?type=raport" class="nav-link app-nav-link d-flex align-items-center <?= is_active('arsip-raport', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-file-earmark-check"></i></span> <span>Arsip Sertifikat/Rapor</span>
                    </a>
                <?php endif; ?>

                <?php if ($activeModule === 'raport'): ?>
                    <div class="app-nav-section mt-3">Hasil Studi</div>
                    <a href="<?= $baseUrl . $roleBasePath ?>/raport.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('raport', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-file-earmark-text"></i></span> <span>Generate Raport</span>
                    </a>
                    <a href="<?= $baseUrl . $roleBasePath ?>/arsip.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('arsip', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-archive"></i></span> <span>Arsip Nilai</span>
                    </a>
                    <a href="<?= $baseUrl . $roleBasePath ?>/template_raport.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('template-raport', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-file-earmark-pdf"></i></span> <span>Template Dokumen</span>
                    </a>
                <?php endif; ?>

                <div class="mt-auto"></div>
                <div class="app-nav-section mt-3">Pengaturan</div>
                <a href="<?= $baseUrl . $roleBasePath ?>/akun.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('akun', $currentPage) ?>">
                    <span class="app-nav-icon"><i class="bi bi-person-gear"></i></span> <span>Pengaturan Akun</span>
                </a>

            <?php endif; ?>

            <!-- TUTOR MENU PER MODUL -->
            <?php if ($role === 'tutor'): ?>
                
                <?php if ($activeModule === 'sim'): ?>
                    <div class="app-nav-section mt-3">Jadwal & Absensi</div>
                    <a href="<?= $baseUrl . $roleBasePath ?>/jadwal-mengajar.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('kelas-aktif', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-calendar-check"></i></span> <span>Jadwal Mengajar</span>
                    </a>
                    <div class="app-nav-section mt-3">Manajemen Modul</div>
                    <a href="<?= $baseUrl . $roleBasePath ?>/modul-kelas.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('modul-kelas', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-easel2"></i></span> <span>Modul Materi</span>
                    </a>
                    <a href="<?= $baseUrl . $roleBasePath ?>/modul-soal.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('modul-soal', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-collection"></i></span> <span>Bank Soal</span>
                    </a>
                    <a href="<?= $baseUrl . $roleBasePath ?>/modul-ujian.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('modul-ujian', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-ui-checks-grid"></i></span> <span>Paket Ujian</span>
                    </a>
                <?php endif; ?>

                <?php if ($activeModule === 'elearning'): ?>
                    <div class="app-nav-section mt-3">Manajemen Materi</div>
                    <a href="<?= $baseUrl . $roleBasePath ?>/kelas-aktif.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('kelas-aktif', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-collection"></i></span> <span>Kelas Berjalan</span>
                    </a>
                    <div class="app-nav-section mt-3">Arsip</div>
                    <a href="<?= $baseUrl . $roleBasePath ?>/arsip-kelas.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('arsip-kelas', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-archive"></i></span> <span>Arsip Kelas</span>
                    </a>
                <?php endif; ?>

                <?php if ($activeModule === 'cbt'): ?>                   
                    <div class="app-nav-section mt-3">Pelaksanaan</div>
                    <a href="<?= $baseUrl . $roleBasePath ?>/ujian-aktif.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('ujian-aktif', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-clipboard-check"></i></span> <span>Monitoring Ujian</span>
                    </a>
                    <a href="<?= $baseUrl . $roleBasePath ?>/penilaian-ujian.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('penilaian-ujian', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-check2-circle"></i></span> <span>Penilaian</span>
                    </a>
                    <a href="<?= $baseUrl . $roleBasePath ?>/arsip-ujian.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('arsip-ujian', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-archive"></i></span> <span>Arsip Ujian</span>
                    </a>
                <?php endif; ?>

                <div class="mt-auto"></div>
                <div class="app-nav-section mt-3">Pengaturan</div>
                <a href="<?= $baseUrl . $roleBasePath ?>/akun.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('akun', $currentPage) ?>">
                    <span class="app-nav-icon"><i class="bi bi-person-gear"></i></span> <span>Pengaturan Akun</span>
                </a>

            <?php endif; ?>

            <!-- PESERTA MENU PER MODUL -->
            <?php if ($role === 'peserta'): ?>
                <?php $currentTab = $_GET['tab'] ?? 'active'; ?>
                
                <?php if ($activeModule === 'elearning'): ?>
                    <div class="app-nav-section mt-3">Kelas Online</div>
                    <a href="<?= $baseUrl . $roleBasePath ?>/jadwal.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('jadwal', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-calendar-week"></i></span> <span>Jadwal Pelajaran</span>
                    </a>
                    <a href="<?= $baseUrl . $roleBasePath ?>/kelas.php?tab=active" class="nav-link app-nav-link d-flex align-items-center <?= ($currentPage === 'kelas' && $currentTab === 'active') ? 'active app-nav-active' : '' ?>">
                        <span class="app-nav-icon"><i class="bi bi-easel"></i></span> <span>Kelas Saya</span>
                    </a>
                    <a href="<?= $baseUrl . $roleBasePath ?>/kelas.php?tab=completed" class="nav-link app-nav-link d-flex align-items-center <?= ($currentPage === 'kelas' && $currentTab === 'completed') ? 'active app-nav-active' : '' ?>">
                        <span class="app-nav-icon"><i class="bi bi-archive"></i></span> <span>Arsip Materi</span>
                    </a>
                <?php endif; ?>

                <?php if ($activeModule === 'cbt'): ?>
                    <div class="app-nav-section mt-3">Ujian Computer Based</div>
                    <a href="<?= $baseUrl . $roleBasePath ?>/tugas.php?tab=active" class="nav-link app-nav-link d-flex align-items-center <?= ($currentPage === 'tugas' && $currentTab === 'active') ? 'active app-nav-active' : '' ?>">
                        <span class="app-nav-icon"><i class="bi bi-laptop"></i></span> <span>Ujian Aktif</span>
                    </a>
                    <a href="<?= $baseUrl . $roleBasePath ?>/tugas.php?tab=completed" class="nav-link app-nav-link d-flex align-items-center <?= ($currentPage === 'tugas' && $currentTab === 'completed') ? 'active app-nav-active' : '' ?>">
                        <span class="app-nav-icon"><i class="bi bi-clock-history"></i></span> <span>Riwayat Ujian</span>
                    </a>
                <?php endif; ?>

                <?php if ($activeModule === 'raport'): ?>
                    <div class="app-nav-section mt-3">Laporan Hasil</div>
                    <a href="<?= $baseUrl . $roleBasePath ?>/raport.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('raport', $currentPage) ?>">
                        <span class="app-nav-icon"><i class="bi bi-award"></i></span> <span>Raport & Sertifikat</span>
                    </a>
                <?php endif; ?>

                <!-- Menu Akun Selalu Ada di Bawah -->
                <div class="mt-auto"></div>
                <div class="app-nav-section mt-3">Pengaturan</div>
                <a href="<?= $baseUrl . $roleBasePath ?>/akun.php" class="nav-link app-nav-link d-flex align-items-center <?= is_active('akun', $currentPage) ?>">
                    <span class="app-nav-icon"><i class="bi bi-person-gear"></i></span> <span>Profil Saya</span>
                </a>

            <?php endif; ?>

            <?php if (!$activeModule && $role !== 'superadmin'): ?>
                <!-- Fallback jika user akses langsung url tanpa lewat portal -->
                <div class="p-3 text-center">
                    <p class="small text-muted">Silakan pilih modul layanan di portal.</p>
                    <a href="<?= $baseUrl ?>/portal.php" class="btn btn-primary btn-sm w-100">Ke Portal</a>
                </div>
            <?php endif; ?>

        </nav>
    </div>
    
    <!-- Footer Sidebar -->
    <div class="app-sidebar-footer p-3 border-top bg-light">
        <a href="<?= $baseUrl ?>/logout.php" class="d-flex align-items-center text-muted text-decoration-none hover-text-danger transition-all">
            <i class="bi bi-box-arrow-left fs-5 me-2"></i>
            <span class="fw-medium small">Keluar Aplikasi</span>
        </a>
    </div>
</aside>
