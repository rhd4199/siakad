<?php
require_once __DIR__ . '/../config.php';
require_login(['admin']);

$user         = current_user();
$title        = 'Dashboard Admin';
$currentPage  = 'dashboard';
$roleBasePath = '/admin';
$baseUrl      = '/siakad';

// Simulated Data
$stats = [
    [
        'label' => 'Total Siswa',
        'value' => '1,240',
        'trend' => '+12% bulan ini',
        'trend_up' => true,
        'icon'  => 'bi-people-fill',
        'color' => 'primary',
        'bg'    => 'primary-subtle'
    ],
    [
        'label' => 'Pendapatan',
        'value' => 'Rp 45.2M',
        'trend' => '+8% dari target',
        'trend_up' => true,
        'icon'  => 'bi-wallet-fill',
        'color' => 'success',
        'bg'    => 'success-subtle'
    ],
    [
        'label' => 'Kelas Aktif',
        'value' => '24',
        'trend' => 'Stabil',
        'trend_up' => true,
        'icon'  => 'bi-easel-fill',
        'color' => 'info',
        'bg'    => 'info-subtle'
    ],
    [
        'label' => 'Pending Review',
        'value' => '15',
        'trend' => '-2 tugas',
        'trend_up' => false,
        'icon'  => 'bi-clipboard-data-fill',
        'color' => 'warning',
        'bg'    => 'warning-subtle'
    ]
];

$recent_registrations = [
    ['name' => 'Sarah Amalia', 'program' => 'Digital Marketing', 'date' => 'Baru saja', 'status' => 'paid', 'avatar' => 'SA'],
    ['name' => 'Budi Santoso', 'program' => 'Web Development', 'date' => '5 menit lalu', 'status' => 'pending', 'avatar' => 'BS'],
    ['name' => 'Citra Dewi', 'program' => 'Data Science', 'date' => '1 jam lalu', 'status' => 'paid', 'avatar' => 'CD'],
    ['name' => 'Dimas Anggara', 'program' => 'UI/UX Design', 'date' => '2 jam lalu', 'status' => 'paid', 'avatar' => 'DA'],
];

$ongoing_classes = [
    ['code' => 'DM-01', 'name' => 'Digital Marketing Batch 1', 'tutor' => 'Eko Kurniawan', 'room' => 'Lab A', 'attendance' => '18/20'],
    ['code' => 'WD-03', 'name' => 'Web Dev Fullstack', 'tutor' => 'Sandhika Galih', 'room' => 'Lab B', 'attendance' => '15/15'],
];

ob_start();
?>

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        --card-shadow: 0 5px 15px rgba(0,0,0,0.05);
        --hover-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    /* Animations */
    .fade-in-up {
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
        transform: translateY(20px);
    }
    @keyframes fadeInUp {
        to { opacity: 1; transform: translateY(0); }
    }
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }

    /* Components */
    .welcome-banner {
        background: var(--primary-gradient);
        color: white;
        position: relative;
        overflow: hidden;
        border: none;
    }
    .welcome-decor {
        position: absolute;
        right: -50px;
        top: -50px;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
    }

    .stat-card {
        border: none;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--hover-shadow) !important;
    }
    .stat-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .avatar-circle {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .chart-bar-container {
        height: 100%;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        position: relative;
    }
    .chart-bar {
        width: 100%;
        border-radius: 6px 6px 0 0;
        transition: all 0.3s ease;
        position: relative;
        animation: growBar 1s ease-out forwards;
        transform-origin: bottom;
    }
    .chart-bar:hover {
        opacity: 0.8;
    }
    @keyframes growBar {
        from { transform: scaleY(0); }
        to { transform: scaleY(1); }
    }
    
    .quick-action-btn {
        transition: all 0.2s;
        border: 1px solid #eef0f7;
    }
    .quick-action-btn:hover {
        transform: translateY(-3px);
        background-color: #fff;
        border-color: #4e73df;
        box-shadow: 0 5px 15px rgba(78, 115, 223, 0.1);
        z-index: 1;
    }

    .pulse-dot {
        width: 8px;
        height: 8px;
        background-color: #dc3545;
        border-radius: 50%;
        display: inline-block;
        position: relative;
    }
    .pulse-dot::after {
        content: '';
        position: absolute;
        top: -4px;
        left: -4px;
        right: -4px;
        bottom: -4px;
        border-radius: 50%;
        border: 2px solid #dc3545;
        animation: pulse 1.5s infinite;
        opacity: 0.5;
    }
    @keyframes pulse {
        0% { transform: scale(1); opacity: 0.8; }
        100% { transform: scale(2); opacity: 0; }
    }
</style>

<!-- Welcome Section -->
<div class="row mb-4 fade-in-up">
    <div class="col-12">
        <div class="card welcome-banner shadow-lg rounded-4 p-4 p-md-5">
            <div class="welcome-decor"></div>
            <div class="position-relative z-1 d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="mb-3 mb-md-0">
                    <h2 class="fw-bold mb-2">Selamat Datang, Admin! 👋</h2>
                    <p class="mb-0 opacity-75 fs-5">
                        Siap untuk memantau perkembangan LPK hari ini? <br>
                        <span class="fs-6"><i class="bi bi-calendar-event me-2"></i><?= date('l, d F Y') ?></span>
                    </p>
                </div>
                <div class="d-flex gap-3">
                    <button class="btn btn-light text-primary shadow-sm rounded-pill px-4 py-2 fw-bold">
                        <i class="bi bi-cloud-download me-2"></i>Unduh Laporan
                    </button>
                    <button class="btn btn-warning text-dark shadow-sm rounded-pill px-4 py-2 fw-bold">
                        <i class="bi bi-plus-lg me-2"></i>Entri Baru
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-4 mb-4">
    <?php foreach ($stats as $index => $stat): ?>
    <div class="col-6 col-lg-3 fade-in-up" style="animation-delay: <?= ($index + 1) * 100 ?>ms">
        <div class="card stat-card h-100 rounded-4 overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon-box bg-<?= $stat['bg'] ?> text-<?= $stat['color'] ?>">
                        <i class="bi <?= $stat['icon'] ?>"></i>
                    </div>
                    <?php if ($stat['trend_up']): ?>
                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                            <i class="bi bi-graph-up-arrow me-1"></i><?= $stat['trend'] ?>
                        </span>
                    <?php else: ?>
                        <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">
                            <i class="bi bi-graph-down-arrow me-1"></i><?= $stat['trend'] ?>
                        </span>
                    <?php endif; ?>
                </div>
                <h3 class="fw-bold text-dark mb-1"><?= $stat['value'] ?></h3>
                <div class="text-muted fw-medium small text-uppercase spacing-1"><?= $stat['label'] ?></div>
            </div>
            <!-- Decorative line at bottom -->
            <div class="bg-<?= $stat['color'] ?>" style="height: 4px; width: 100%;"></div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="row g-4">
    <!-- Left Column: Main Content -->
    <div class="col-lg-8 fade-in-up delay-300">
        
        <!-- Registration Chart -->
        <div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
            <div class="card-header bg-white py-4 px-4 d-flex justify-content-between align-items-center border-bottom-0">
                <div>
                    <h5 class="fw-bold mb-1">Statistik Pendaftaran</h5>
                    <p class="text-muted small mb-0">Tren pendaftaran siswa baru dalam 7 hari terakhir.</p>
                </div>
                <div class="btn-group btn-group-sm bg-light rounded-pill p-1">
                    <button class="btn btn-white rounded-pill shadow-sm px-3 fw-bold small">Mingguan</button>
                    <button class="btn btn-transparent rounded-pill px-3 text-muted small">Bulanan</button>
                </div>
            </div>
            <div class="card-body px-4 pb-4 pt-0">
                <div class="d-flex align-items-end justify-content-between gap-3" style="height: 250px;">
                    <?php 
                    $days = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
                    for($i=0; $i<7; $i++): 
                        $h = rand(30, 95); 
                        $h2 = rand(20, $h - 10);
                    ?>
                    <div class="w-100 d-flex flex-column align-items-center gap-2" style="height: 100%;">
                        <div class="chart-bar-container w-100 bg-light rounded-top-3 overflow-hidden position-relative">
                            <!-- Background Bar (Total Capacity/Target) -->
                            <!-- Actual Bar -->
                            <div class="bg-primary chart-bar" style="height: <?= $h ?>%; position: absolute; bottom: 0; width: 100%; opacity: 0.15;"></div>
                            <div class="bg-primary chart-bar shadow-sm" style="height: <?= $h2 ?>%;">
                                <!-- Tooltip on Hover could go here -->
                            </div>
                        </div>
                        <span class="extra-small fw-bold text-muted"><?= $days[$i] ?></span>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>

        <!-- Recent Registrations -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white py-4 px-4 d-flex justify-content-between align-items-center border-bottom-0">
                <h5 class="fw-bold mb-0">Pendaftaran Terbaru</h5>
                <a href="#" class="btn btn-light btn-sm rounded-pill px-3 text-primary fw-bold">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4 py-3 border-0 rounded-start">Siswa</th>
                            <th class="py-3 border-0">Program</th>
                            <th class="py-3 border-0">Status</th>
                            <th class="py-3 border-0">Waktu</th>
                            <th class="pe-4 py-3 text-end border-0 rounded-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_registrations as $reg): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle bg-light text-primary border">
                                        <?= $reg['avatar'] ?>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark"><?= $reg['name'] ?></div>
                                        <div class="extra-small text-muted">ID: #<?= rand(1000, 9999) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="fw-medium text-dark"><?= $reg['program'] ?></span></td>
                            <td>
                                <?php if ($reg['status'] == 'paid'): ?>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">
                                        <i class="bi bi-check-circle-fill me-1"></i>Lunas
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3">
                                        <i class="bi bi-clock-fill me-1"></i>Pending
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-muted small"><?= $reg['date'] ?></td>
                            <td class="text-end pe-4">
                                <button class="btn btn-icon btn-light btn-sm rounded-circle text-muted shadow-sm hover-lift">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Right Column: Sidebar -->
    <div class="col-lg-4 fade-in-up delay-300">
        
        <!-- Quick Actions -->
        <div class="card border-0 shadow-sm mb-4 rounded-4">
            <div class="card-header bg-white py-3 px-4 border-bottom-0">
                <h6 class="fw-bold mb-0">🚀 Aksi Cepat</h6>
            </div>
            <div class="card-body px-4 pb-4 pt-0">
                <div class="row g-3">
                    <div class="col-6">
                        <a href="<?= $baseUrl . $roleBasePath ?>/program.php" class="btn btn-light w-100 p-3 quick-action-btn text-start h-100 rounded-3 position-relative overflow-hidden">
                            <div class="position-absolute end-0 top-0 p-2 opacity-10">
                                <i class="bi bi-plus-circle fs-1 text-primary"></i>
                            </div>
                            <div class="mb-2 bg-primary-subtle text-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="bi bi-plus-lg"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0">Program</h6>
                            <small class="text-muted extra-small">Tambah Baru</small>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= $baseUrl . $roleBasePath ?>/kelas.php" class="btn btn-light w-100 p-3 quick-action-btn text-start h-100 rounded-3 position-relative overflow-hidden">
                            <div class="position-absolute end-0 top-0 p-2 opacity-10">
                                <i class="bi bi-calendar-plus fs-1 text-success"></i>
                            </div>
                            <div class="mb-2 bg-success-subtle text-success rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="bi bi-calendar4"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0">Kelas</h6>
                            <small class="text-muted extra-small">Buka Sesi</small>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= $baseUrl . $roleBasePath ?>/instruktur.php" class="btn btn-light w-100 p-3 quick-action-btn text-start h-100 rounded-3 position-relative overflow-hidden">
                            <div class="position-absolute end-0 top-0 p-2 opacity-10">
                                <i class="bi bi-person-plus fs-1 text-info"></i>
                            </div>
                            <div class="mb-2 bg-info-subtle text-info rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="bi bi-person-plus-fill"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0">Tutor</h6>
                            <small class="text-muted extra-small">Rekrutmen</small>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= $baseUrl . $roleBasePath ?>/jadwal.php" class="btn btn-light w-100 p-3 quick-action-btn text-start h-100 rounded-3 position-relative overflow-hidden">
                            <div class="position-absolute end-0 top-0 p-2 opacity-10">
                                <i class="bi bi-broadcast fs-1 text-danger"></i>
                            </div>
                            <div class="mb-2 bg-danger-subtle text-danger rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="bi bi-megaphone-fill"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0">Info</h6>
                            <small class="text-muted extra-small">Pengumuman</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Classes -->
        <div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center border-bottom-0">
                <h6 class="fw-bold mb-0">Kelas Sedang Berjalan</h6>
                <div class="d-flex align-items-center">
                    <span class="pulse-dot me-2"></span>
                    <span class="text-danger fw-bold small text-uppercase">Live</span>
                </div>
            </div>
            <div class="list-group list-group-flush">
                <?php foreach ($ongoing_classes as $cls): ?>
                <div class="list-group-item px-4 py-3 border-light-subtle">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill extra-small px-2"><?= $cls['code'] ?></span>
                        <small class="text-muted fw-medium"><i class="bi bi-geo-alt-fill me-1 text-secondary"></i><?= $cls['room'] ?></small>
                    </div>
                    <h6 class="fw-bold mb-2 text-dark"><?= $cls['name'] ?></h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-circle bg-light text-secondary border" style="width: 28px; height: 28px; font-size: 0.8rem;">
                                <?= substr($cls['tutor'], 0, 1) ?>
                            </div>
                            <small class="text-muted fw-medium"><?= $cls['tutor'] ?></small>
                        </div>
                        <div class="d-flex align-items-center text-success">
                            <i class="bi bi-people-fill me-1"></i>
                            <small class="fw-bold"><?= $cls['attendance'] ?></small>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="card-footer bg-white text-center border-0 py-3">
                <a href="#" class="text-decoration-none small fw-bold text-primary">Lihat Semua Kelas Live <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
        </div>

        <!-- System Health -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4 d-flex align-items-center">
                    <i class="bi bi-hdd-rack me-2 text-secondary"></i>System Status
                </h6>
                <div class="mb-4">
                    <div class="d-flex justify-content-between small fw-bold mb-2">
                        <span>Server Load</span>
                        <span class="text-success">12%</span>
                    </div>
                    <div class="progress bg-success-subtle" style="height: 6px; border-radius: 10px;">
                        <div class="progress-bar bg-success rounded-pill" style="width: 12%"></div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="d-flex justify-content-between small fw-bold mb-2">
                        <span>Storage Usage</span>
                        <span class="text-warning">65%</span>
                    </div>
                    <div class="progress bg-warning-subtle" style="height: 6px; border-radius: 10px;">
                        <div class="progress-bar bg-warning rounded-pill" style="width: 65%"></div>
                    </div>
                </div>
                <div>
                    <div class="d-flex justify-content-between small fw-bold mb-2">
                        <span>Database Health</span>
                        <span class="text-primary">100%</span>
                    </div>
                    <div class="progress bg-primary-subtle" style="height: 6px; border-radius: 10px;">
                        <div class="progress-bar bg-primary rounded-pill" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
