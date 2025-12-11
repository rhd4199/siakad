<?php
require_once __DIR__ . '/../config.php';
require_login(['peserta']);

$user         = current_user();
$title        = 'Raport & Sertifikat';
$currentPage  = 'raport';
$roleBasePath = '/peserta';
$baseUrl      = '/siakad';

// Simulated Data
$stats = [
    ['label' => 'Program Diikuti', 'value' => 3, 'icon' => 'bi-journal-text', 'color' => 'primary'],
    ['label' => 'Program Lulus', 'value' => 2, 'icon' => 'bi-check2-circle', 'color' => 'success'],
    ['label' => 'e-Raport Siap', 'value' => 2, 'icon' => 'bi-filetype-pdf', 'color' => 'info'],
    ['label' => 'e-Sertifikat Siap', 'value' => 2, 'icon' => 'bi-award', 'color' => 'warning'],
];

$reports = [
    [
        'code' => 'OM-01',
        'program' => 'Operator Komputer',
        'status' => 'LULUS',
        'grade' => 'A',
        'score' => 88.5,
        'period' => 'Nov - Des 2024',
        'files' => [
            ['name' => 'e-Raport.pdf', 'type' => 'raport'],
            ['name' => 'Sertifikat Kompetensi.pdf', 'type' => 'cert']
        ]
    ],
    [
        'code' => 'DM-02',
        'program' => 'Digital Marketing',
        'status' => 'LULUS',
        'grade' => 'B+',
        'score' => 82.0,
        'period' => 'Okt - Nov 2024',
        'files' => [
            ['name' => 'e-Raport.pdf', 'type' => 'raport'],
            ['name' => 'Sertifikat Keahlian.pdf', 'type' => 'cert']
        ]
    ],
    [
        'code' => 'BRS-01',
        'program' => 'Barista Dasar',
        'status' => 'ONGOING',
        'grade' => '-',
        'score' => 0,
        'period' => 'Des 2024 - Jan 2025',
        'files' => []
    ]
];

ob_start();
?>
<style>
    .card-certificate {
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
        border: 1px solid #dee2e6;
        position: relative;
        overflow: hidden;
    }
    .card-certificate::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: #0d6efd; 
    }
    .card-certificate.lulus::before {
        background: #198754; /* Success Green */
    }
    .card-certificate.ongoing::before {
        background: #ffc107; /* Warning Yellow */
    }
    .watermark-icon {
        position: absolute;
        right: -20px;
        bottom: -20px;
        font-size: 8rem;
        opacity: 0.05;
        transform: rotate(-15deg);
    }
    .hover-lift {
        transition: transform 0.2s;
    }
    .hover-lift:hover {
        transform: translateY(-3px);
    }
</style>

<div class="row mb-4 align-items-center">
    <div class="col-lg-8">
        <h4 class="fw-bold mb-1">Raport & Sertifikat</h4>
        <p class="text-muted small mb-0">
            Arsip pencapaian akademik dan sertifikasi kompetensi Anda.
        </p>
    </div>
</div>

<!-- Stats -->
<div class="row g-3 mb-4">
    <?php foreach ($stats as $stat): ?>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="rounded-3 bg-<?= $stat['color'] ?>-subtle text-<?= $stat['color'] ?> p-3 d-flex align-items-center justify-content-center">
                    <i class="bi <?= $stat['icon'] ?> fs-4"></i>
                </div>
                <div>
                    <div class="extra-small text-muted text-uppercase fw-bold"><?= $stat['label'] ?></div>
                    <div class="fs-4 fw-bold"><?= $stat['value'] ?></div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <h5 class="fw-bold mb-3">Daftar Hasil Studi</h5>
        
        <?php foreach ($reports as $report): ?>
        <div class="card card-certificate border-0 shadow-sm mb-3 <?= strtolower($report['status']) == 'lulus' ? 'lulus' : 'ongoing' ?> hover-lift">
            <i class="bi bi-award-fill watermark-icon"></i>
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8 mb-3 mb-md-0">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <?php if ($report['status'] == 'LULUS'): ?>
                                <span class="badge bg-success-subtle text-success border border-success-subtle"><i class="bi bi-check-circle-fill me-1"></i> LULUS</span>
                            <?php else: ?>
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle"><i class="bi bi-hourglass-split me-1"></i> SEDANG BERJALAN</span>
                            <?php endif; ?>
                            <span class="text-muted small border-start ps-2"><?= $report['period'] ?></span>
                        </div>
                        <h5 class="fw-bold mb-1 text-dark"><?= $report['program'] ?></h5>
                        <div class="small text-muted mb-0">Kode Program: <span class="font-monospace"><?= $report['code'] ?></span></div>
                    </div>
                    
                    <div class="col-md-4 text-md-end">
                        <?php if ($report['status'] == 'LULUS'): ?>
                            <div class="d-flex justify-content-md-end align-items-center gap-3">
                                <div class="text-end">
                                    <div class="extra-small text-muted text-uppercase fw-bold">Nilai Akhir</div>
                                    <div class="fs-4 fw-bold text-dark"><?= $report['score'] ?></div>
                                </div>
                                <div class="text-center bg-light rounded p-2 border" style="min-width: 50px;">
                                    <div class="extra-small text-muted fw-bold">Grade</div>
                                    <div class="fs-4 fw-bold text-success"><?= $report['grade'] ?></div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="text-muted small fst-italic">
                                Nilai belum final
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (!empty($report['files'])): ?>
                <hr class="my-3 opacity-25">
                <div class="row g-2">
                    <?php foreach ($report['files'] as $file): ?>
                    <div class="col-sm-6">
                        <button class="btn btn-outline-<?= $file['type'] == 'cert' ? 'warning' : 'primary' ?> btn-sm w-100 text-start d-flex align-items-center">
                            <i class="bi bi-<?= $file['type'] == 'cert' ? 'patch-check-fill' : 'file-earmark-pdf-fill' ?> me-2 fs-5"></i>
                            <div class="overflow-hidden">
                                <div class="fw-medium text-truncate"><?= $file['name'] ?></div>
                                <div class="extra-small opacity-75">Klik untuk unduh</div>
                            </div>
                            <i class="bi bi-download ms-auto"></i>
                        </button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm bg-primary text-white mb-3">
            <div class="card-body p-4 text-center">
                <i class="bi bi-mortarboard-fill fs-1 mb-3 d-block text-white-50"></i>
                <h5 class="fw-bold">Selamat atas pencapaianmu!</h5>
                <p class="small text-white-50 mb-4">
                    Pertahankan prestasimu dan terus tingkatkan kompetensi untuk masa depan yang cerah.
                </p>
                <button class="btn btn-light text-primary fw-bold w-100 shadow-sm">
                    Bagikan ke LinkedIn <i class="bi bi-linkedin ms-1"></i>
                </button>
            </div>
        </div>
        
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">Verifikasi Sertifikat</h6>
            </div>
            <div class="card-body">
                <p class="small text-muted mb-3">
                    Pihak eksternal dapat memverifikasi keaslian sertifikat Anda dengan memindai QR Code pada sertifikat atau memasukkan ID Sertifikat di sini.
                </p>
                <div class="input-group mb-2">
                    <input type="text" class="form-control form-control-sm" placeholder="ID Sertifikat...">
                    <button class="btn btn-outline-secondary btn-sm" type="button">Cek</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
