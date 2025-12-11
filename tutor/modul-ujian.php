<?php
require_once __DIR__ . '/../config.php';
require_login(['tutor']);

$user         = current_user();
$title        = 'Modul Ujian';
$currentPage  = 'modul-ujian';
$roleBasePath = '/tutor';
$baseUrl      = '/siakad';

// Dummy data modul ujian
$modulUjianList = [
    [
        'id'          => 'EX-OM-FINAL',
        'nama'        => 'Ujian Akhir – Operator Komputer Dasar',
        'program'     => 'Operator Komputer',
        'segments'    => 3, // 2 modules + 1 break
        'total_durasi'=> 75,
        'kkm'         => 70,
        'status'      => 'ready',
        'last_updated'=> '2023-10-15',
        'type'        => 'Ujian Akhir'
    ],
    [
        'id'          => 'EX-OM-QUIZ1',
        'nama'        => 'Quiz Pertemuan 3 – Ms Word Dasar',
        'program'     => 'Operator Komputer',
        'segments'    => 1,
        'total_durasi'=> 20,
        'kkm'         => 60,
        'status'      => 'draft',
        'last_updated'=> '2023-10-20',
        'type'        => 'Quiz'
    ],
    [
        'id'          => 'EX-DM-MID',
        'nama'        => 'Mid Test – Digital Marketing Pemula',
        'program'     => 'Digital Marketing',
        'segments'    => 2, // 1 module + 1 break?
        'total_durasi'=> 45,
        'kkm'         => 75,
        'status'      => 'ready',
        'last_updated'=> '2023-10-10',
        'type'        => 'Mid Test'
    ],
];

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Template Ujian</h4>
        <p class="text-muted small mb-0">Kelola blueprint ujian, aturan kelulusan, dan alur sesi.</p>
    </div>
    <a href="modul-ujian-buat.php" class="btn btn-primary rounded-pill px-4 shadow-sm">
        <i class="bi bi-plus-lg me-2"></i>Buat Template
    </a>
</div>

<!-- FILTER -->
<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-4">
        <div class="input-group bg-white rounded-pill shadow-sm border p-1">
            <span class="input-group-text border-0 bg-transparent ps-3 text-muted">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" class="form-control border-0 bg-transparent" placeholder="Cari template ujian...">
        </div>
    </div>
    <div class="col-md-6 col-lg-8 text-md-end">
        <div class="d-inline-flex bg-white rounded-pill shadow-sm border p-1">
            <button class="btn btn-sm btn-light rounded-pill px-3 fw-medium">Semua</button>
            <button class="btn btn-sm btn-white text-muted rounded-pill px-3">Siap Pakai</button>
            <button class="btn btn-sm btn-white text-muted rounded-pill px-3">Draft</button>
        </div>
    </div>
</div>

<!-- LIST PACKETS (Redesigned - Horizontal Ticket Style) -->
<div class="d-flex flex-column gap-3">
    <?php foreach ($modulUjianList as $ujian): ?>
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden card-hover-left-border">
        <div class="card-body p-0">
            <div class="row g-0">
                <!-- Left: Status & Main Info -->
                <div class="col-lg-8 p-4 d-flex flex-column justify-content-center border-end-lg">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <span class="badge rounded-pill border <?= $ujian['status'] === 'ready' ? 'bg-success-subtle text-success border-success-subtle' : 'bg-warning-subtle text-warning border-warning-subtle' ?> px-3 py-1 extra-small fw-bold">
                            <?= strtoupper($ujian['status']) ?>
                        </span>
                        <span class="text-muted extra-small">•</span>
                        <span class="text-muted small fw-medium text-uppercase ls-1"><?= $ujian['program'] ?></span>
                    </div>
                    
                    <h5 class="fw-bold text-dark mb-1"><?= $ujian['nama'] ?></h5>
                    <p class="text-muted small mb-3"><?= $ujian['type'] ?> • Terakhir diperbarui <?= $ujian['last_updated'] ?></p>

                    <!-- Visual Timeline Preview (Mini) -->
                    <div class="d-flex align-items-center gap-1 mt-auto">
                        <div class="d-flex align-items-center bg-light rounded-pill px-2 py-1 border small text-muted" title="Sesi 1: Modul Soal">
                            <i class="bi bi-file-earmark-text me-1 text-primary"></i> Modul
                        </div>
                        <?php if($ujian['segments'] > 1): ?>
                            <div class="d-flex align-items-center px-1 text-muted opacity-50"><i class="bi bi-arrow-right small"></i></div>
                            <div class="d-flex align-items-center bg-light rounded-pill px-2 py-1 border small text-muted" title="Sesi 2: Istirahat">
                                <i class="bi bi-cup-hot me-1 text-warning"></i> Break
                            </div>
                            <?php if($ujian['segments'] > 2): ?>
                                <div class="d-flex align-items-center px-1 text-muted opacity-50"><i class="bi bi-arrow-right small"></i></div>
                                <div class="badge bg-secondary rounded-pill text-white fw-normal">+<?= $ujian['segments'] - 2 ?></div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Right: Stats & Action -->
                <div class="col-lg-4 bg-light bg-opacity-25 d-flex flex-column p-4">
                    <div class="row g-2 mb-3">
                         <div class="col-6">
                            <div class="small text-muted text-uppercase fw-bold mb-1" style="font-size: 0.7rem;">Total Durasi</div>
                            <div class="fw-bold fs-5 text-dark"><?= $ujian['total_durasi'] ?> <span class="fs-7 text-muted fw-normal">Menit</span></div>
                        </div>
                        <div class="col-6">
                            <div class="small text-muted text-uppercase fw-bold mb-1" style="font-size: 0.7rem;">Min. Nilai</div>
                            <div class="fw-bold fs-5 text-dark"><?= $ujian['kkm'] ?> <span class="fs-7 text-muted fw-normal">Poin</span></div>
                        </div>
                    </div>
                    
                    <div class="mt-auto d-flex gap-2">
                        <a href="modul-ujian-buat.php?id=<?= $ujian['id'] ?>" class="btn btn-primary rounded-pill btn-sm flex-grow-1 fw-medium shadow-sm">
                            <i class="bi bi-pencil-square me-2"></i>Edit Template
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-white border rounded-circle shadow-sm" style="width: 32px; height: 32px; padding: 0;" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical text-muted small"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                                <li><a class="dropdown-item small" href="#"><i class="bi bi-files me-2"></i>Duplikasi Template</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item small text-danger" href="#"><i class="bi bi-trash me-2"></i>Hapus</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<style>
.card-hover-left-border {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border-left: 4px solid transparent !important;
}
.card-hover-left-border:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,.08) !important;
    border-left-color: var(--bs-primary) !important;
}
.ls-1 { letter-spacing: 1px; }
.fs-7 { font-size: 0.85rem; }
@media (min-width: 992px) {
    .border-end-lg {
        border-right: 1px solid var(--bs-border-color) !important;
    }
}
</style>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>
