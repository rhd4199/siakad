<?php
require_once __DIR__ . '/../config.php';
require_login(['peserta']);

$user         = current_user();
$tab = $_GET['tab'] ?? 'active';
$title = ($tab === 'completed') ? 'Riwayat Kelas' : 'Kelas & Materi';
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

$allClasses = [
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
    ],
    [
        'code' => 'CS-03',
        'name' => 'Customer Service Excellence',
        'desc' => 'Teknik pelayanan pelanggan prima dan penanganan keluhan.',
        'tutor' => 'Ratna Dewi',
        'schedule' => 'Selesai',
        'location' => 'Lab 2',
        'meetings' => 5,
        'mode' => 'Tatap Muka',
        'progress' => 100,
        'status' => 'completed'
    ]
];

// Filter classes based on tab
$classes = array_filter($allClasses, function($c) use ($tab) {
    if ($tab === 'completed') {
        return $c['status'] === 'completed';
    } else {
        return $c['status'] !== 'completed';
    }
});

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
        <h4 class="fw-bold mb-1"><?= ($tab === 'completed') ? 'Riwayat Kelas Selesai' : 'Kelas & Materi Saya' ?></h4>
        <p class="text-muted small mb-0">
            <?= ($tab === 'completed') ? 'Daftar kelas yang telah Anda selesaikan.' : 'Akses semua materi pembelajaran, video, dan tugas Anda di sini.' ?>
        </p>
    </div>
</div>

<!-- Stats Section -->
<?php if ($tab !== 'completed'): ?>
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
<?php endif; ?>

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
                        <?php if ($class['status'] === 'completed'): ?>
                            <button class="btn btn-secondary btn-sm fw-medium" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#classDetailModal"
                                    data-title="<?= htmlspecialchars($class['name']) ?>"
                                    data-desc="<?= htmlspecialchars($class['desc']) ?>"
                                    data-tutor="<?= htmlspecialchars($class['tutor']) ?>"
                                    data-schedule="<?= htmlspecialchars($class['schedule']) ?>"
                                    data-progress="<?= htmlspecialchars($class['progress']) ?>">
                                <i class="bi bi-eye me-1"></i> Detail Kelas
                            </button>
                        <?php else: ?>
                            <a href="<?= $baseUrl . $roleBasePath ?>/kelas-detail.php?kode=<?= $class['code'] ?>" class="btn btn-outline-primary btn-sm fw-medium">
                                Masuk Kelas <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Class Detail Modal -->
<div class="modal fade" id="classDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalClassTitle">Detail Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="small text-muted fw-bold text-uppercase">Deskripsi</label>
                    <p class="text-dark" id="modalClassDesc"></p>
                </div>
                
                <div class="row g-3">
                    <div class="col-6">
                        <label class="small text-muted fw-bold text-uppercase">Tutor</label>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-person-circle text-primary"></i>
                            <span id="modalClassTutor" class="fw-medium"></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="small text-muted fw-bold text-uppercase">Jadwal Terakhir</label>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-calendar-check text-primary"></i>
                            <span id="modalClassSchedule" class="fw-medium"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="small text-muted fw-bold text-uppercase">Pencapaian Akhir</label>
                        <div class="d-flex align-items-center gap-3">
                            <div class="progress flex-grow-1" style="height: 10px;">
                                <div id="modalClassProgressBar" class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
                            </div>
                            <span id="modalClassProgress" class="fw-bold text-success"></span>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-light border mt-4 mb-0 d-flex gap-2">
                    <i class="bi bi-info-circle text-muted"></i>
                    <small class="text-muted">Kelas ini telah diarsipkan. Anda tidak dapat lagi mengakses materi detail, namun sertifikat tetap tersedia di menu Akun.</small>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-light w-100" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var classDetailModal = document.getElementById('classDetailModal');
        classDetailModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            
            var title = button.getAttribute('data-title');
            var desc = button.getAttribute('data-desc');
            var tutor = button.getAttribute('data-tutor');
            var schedule = button.getAttribute('data-schedule');
            var progress = button.getAttribute('data-progress');
            
            classDetailModal.querySelector('#modalClassTitle').textContent = title;
            classDetailModal.querySelector('#modalClassDesc').textContent = desc;
            classDetailModal.querySelector('#modalClassTutor').textContent = tutor;
            classDetailModal.querySelector('#modalClassSchedule').textContent = schedule;
            classDetailModal.querySelector('#modalClassProgress').textContent = progress + '%';
            classDetailModal.querySelector('#modalClassProgressBar').style.width = progress + '%';
        });
    });
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
