<?php
require_once __DIR__ . '/../config.php';
require_login(['peserta']);

$user         = current_user();
$title        = 'Kelas & Materi';
$currentPage  = 'kelas';
$roleBasePath = '/peserta';
$baseUrl      = '/siakad';

// Simulated Data
$stats = [
    ['label' => 'Kelas Aktif', 'value' => 3, 'icon' => 'bi-easel', 'color' => 'primary'],
    ['label' => 'Materi Selesai', 'value' => 12, 'icon' => 'bi-book', 'color' => 'success'],
    ['label' => 'PR Aktif', 'value' => 4, 'icon' => 'bi-journal-check', 'color' => 'warning'],
    ['label' => 'Jadwal Hari Ini', 'value' => 2, 'icon' => 'bi-calendar-week', 'color' => 'info'],
];

$classes = [
    [
        'code' => 'OM-01',
        'name' => 'Operator Komputer',
        'desc' => 'Dasar komputer dan Ms Office untuk pekerjaan administrasi perkantoran.',
        'tutor' => 'Budi Santoso',
        'schedule' => 'Senin & Rabu, 08.00–10.00',
        'location' => 'Lab 1',
        'meetings' => 10,
        'mode' => 'Tatap Muka + E-learning',
        'progress' => 40,
        'status' => 'active'
    ],
    [
        'code' => 'DM-02',
        'name' => 'Digital Marketing',
        'desc' => 'Strategi pemasaran digital, SEO, dan manajemen media sosial.',
        'tutor' => 'Siti Aminah',
        'schedule' => 'Selasa & Kamis, 13.00–15.00',
        'location' => 'Lab Multimedia',
        'meetings' => 12,
        'mode' => 'Full E-learning',
        'progress' => 15,
        'status' => 'active'
    ],
    [
        'code' => 'BRS-01',
        'name' => 'Barista Dasar',
        'desc' => 'Teknik dasar menyeduh kopi, espresso, dan latte art.',
        'tutor' => 'Andi Wijaya',
        'schedule' => 'Jumat, 09.00–11.00',
        'location' => 'Workshop Kopi',
        'meetings' => 8,
        'mode' => 'Praktek Langsung',
        'progress' => 0,
        'status' => 'upcoming'
    ]
];

ob_start();
?>
<style>
    .hover-scale {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-scale:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .card-icon-bg {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }
    .progress-thin {
        height: 6px;
    }
</style>

<div class="row mb-4 align-items-center">
    <div class="col-lg-8">
        <h4 class="fw-bold mb-1">Kelas & Materi Saya</h4>
        <p class="text-muted small mb-0">
            Akses semua materi pembelajaran, video, dan tugas Anda di sini.
        </p>
    </div>
</div>

<!-- Stats Section -->
<div class="row g-3 mb-4">
    <?php foreach ($stats as $stat): ?>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100 hover-scale">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="card-icon-bg bg-<?= $stat['color'] ?>-subtle text-<?= $stat['color'] ?>">
                    <i class="bi <?= $stat['icon'] ?> fs-5"></i>
                </div>
                <div>
                    <div class="extra-small text-muted text-uppercase fw-bold"><?= $stat['label'] ?></div>
                    <div class="fs-4 fw-bold text-dark"><?= $stat['value'] ?></div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="row g-4">
    <?php foreach ($classes as $class): ?>
    <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-sm h-100 hover-scale d-flex flex-column">
            <!-- Header Image Placeholder (Optional, using color block for now) -->
            <div class="h-100 p-0 overflow-hidden rounded-top position-relative">
                <div class="bg-gradient p-4" style="background: linear-gradient(45deg, #f8f9fa, #e9ecef);">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="badge bg-white text-primary shadow-sm"><?= $class['code'] ?></span>
                        <?php if ($class['status'] == 'active'): ?>
                            <span class="badge bg-success-subtle text-success"><i class="bi bi-circle-fill small me-1" style="font-size: 6px; vertical-align: middle;"></i> Aktif</span>
                        <?php else: ?>
                            <span class="badge bg-secondary-subtle text-secondary"><i class="bi bi-clock me-1"></i> Akan Datang</span>
                        <?php endif; ?>
                    </div>
                    <div class="mt-4 text-center text-muted opacity-25">
                        <i class="bi bi-journal-bookmark-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
            
            <div class="card-body d-flex flex-column">
                <h5 class="fw-bold mb-2 text-dark"><?= $class['name'] ?></h5>
                <p class="text-muted extra-small mb-3 line-clamp-2">
                    <?= $class['desc'] ?>
                </p>

                <div class="mt-auto">
                    <!-- Progress Bar -->
                    <div class="d-flex justify-content-between extra-small mb-1">
                        <span class="text-muted">Progress Belajar</span>
                        <span class="fw-bold text-primary"><?= $class['progress'] ?>%</span>
                    </div>
                    <div class="progress progress-thin mb-3 bg-light">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $class['progress'] ?>%" aria-valuenow="<?= $class['progress'] ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <!-- Details -->
                    <div class="bg-light rounded p-2 mb-3">
                        <div class="d-flex align-items-center gap-2 mb-1 extra-small text-muted">
                            <i class="bi bi-person-circle"></i>
                            <span class="text-truncate"><?= $class['tutor'] ?></span>
                        </div>
                        <div class="d-flex align-items-center gap-2 extra-small text-muted">
                            <i class="bi bi-calendar-event"></i>
                            <span class="text-truncate"><?= $class['schedule'] ?></span>
                        </div>
                    </div>

                    <div class="d-grid">
                        <a href="<?= $baseUrl . $roleBasePath ?>/kelas-detail.php?kode=<?= $class['code'] ?>" class="btn btn-outline-primary btn-sm fw-medium">
                            Masuk Kelas <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
