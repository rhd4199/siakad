<?php
require_once __DIR__ . '/../config.php';
require_login(['tutor']);

$user         = current_user();
$title        = 'Modul Soal';
$currentPage  = 'modul-soal';
$roleBasePath = '/tutor';
$baseUrl      = '/siakad';

// Dummy Data
$pakets = [
    [
        'id' => 'PK-OM-01',
        'title' => 'Ujian Akhir – Operator Komputer',
        'subject' => 'Operator Komputer',
        'q_count' => 25,
        'duration' => '60 Menit',
        'status' => 'ready',
        'type' => 'mix' // PG + Essay
    ],
    [
        'id' => 'PK-DM-01',
        'title' => 'Quiz Funnel & Konten',
        'subject' => 'Digital Marketing',
        'q_count' => 15,
        'duration' => '45 Menit',
        'status' => 'ready',
        'type' => 'pg'
    ],
    [
        'id' => 'PK-BRS-01',
        'title' => 'Evaluasi Praktik Barista',
        'subject' => 'Barista & F&B',
        'q_count' => 8,
        'duration' => '30 Menit',
        'status' => 'draft',
        'type' => 'essay'
    ]
];

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Bank Soal</h4>
        <p class="text-muted small mb-0">Kelola paket soal ujian dan kuis.</p>
    </div>
    <button class="btn btn-primary rounded-pill px-4 shadow-sm"
            type="button"
            data-bs-toggle="modal"
            data-bs-target="#modalPaketSoal">
        <i class="bi bi-plus-lg me-2"></i>Paket Baru
    </button>
</div>

<!-- FILTER -->
<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-4">
        <div class="input-group bg-white rounded-pill shadow-sm border p-1">
            <span class="input-group-text border-0 bg-transparent ps-3 text-muted">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" class="form-control border-0 bg-transparent" placeholder="Cari paket soal...">
        </div>
    </div>
    <div class="col-md-6 col-lg-8 text-md-end">
        <div class="d-inline-flex bg-white rounded-pill shadow-sm border p-1">
            <button class="btn btn-sm btn-light rounded-pill px-3 fw-medium">Semua</button>
            <button class="btn btn-sm btn-white text-muted rounded-pill px-3">Siap Dipakai</button>
            <button class="btn btn-sm btn-white text-muted rounded-pill px-3">Draft</button>
        </div>
    </div>
</div>

<!-- LIST PACKETS -->
<div class="row g-3">
    <?php foreach ($pakets as $paket): ?>
    <div class="col-12">
        <div class="card border-0 shadow-sm card-hover-left-border">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <!-- Icon & Title -->
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 p-3 d-flex align-items-center justify-content-center 
                                <?= $paket['status'] === 'ready' ? 'bg-primary-subtle text-primary' : 'bg-secondary-subtle text-secondary' ?>" 
                                style="width: 56px; height: 56px;">
                                <i class="bi bi-stack fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1 text-dark"><?= $paket['title'] ?></h6>
                                <div class="d-flex align-items-center gap-2 small text-muted">
                                    <span class="badge bg-light text-muted border"><?= $paket['subject'] ?></span>
                                    <span>•</span>
                                    <span><?= $paket['id'] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="col-md-3 mb-3 mb-md-0">
                        <div class="d-flex gap-4">
                            <div>
                                <div class="extra-small text-muted text-uppercase fw-bold">Soal</div>
                                <div class="fw-semibold"><?= $paket['q_count'] ?></div>
                            </div>
                            <div>
                                <div class="extra-small text-muted text-uppercase fw-bold">Durasi</div>
                                <div class="fw-semibold"><?= $paket['duration'] ?></div>
                            </div>
                            <div>
                                <div class="extra-small text-muted text-uppercase fw-bold">Tipe</div>
                                <div class="fw-semibold text-capitalize"><?= $paket['type'] ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="col-md-3 text-md-end">
                        <div class="d-flex align-items-center justify-content-md-end gap-2">
                            <?php if($paket['status'] === 'draft'): ?>
                                <span class="badge bg-warning-subtle text-warning me-2">Draft</span>
                            <?php else: ?>
                                <span class="badge bg-success-subtle text-success me-2">Ready</span>
                            <?php endif; ?>
                            
                            <div class="btn-group">
                                <button class="btn btn-outline-secondary btn-sm rounded-start-pill px-3">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </button>
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle dropdown-toggle-split rounded-end-pill px-2" data-bs-toggle="dropdown">
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                                    <li><a class="dropdown-item small" href="#"><i class="bi bi-files me-2"></i>Duplikasi</a></li>
                                    <li><a class="dropdown-item small" href="#"><i class="bi bi-eye me-2"></i>Preview Soal</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item small text-danger" href="#"><i class="bi bi-trash me-2"></i>Hapus</a></li>
                                </ul>
                            </div>
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
    transition: transform 0.2s, box-shadow 0.2s;
    border-left: 4px solid transparent !important;
}
.card-hover-left-border:hover {
    transform: translateX(4px);
    border-left-color: var(--bs-primary) !important;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08) !important;
}
</style>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>