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

<!-- LIST PACKETS (Redesigned) -->
<div class="row g-4">
    <?php foreach ($pakets as $paket): ?>
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden card-hover-transform">
            <!-- Header Color Stripe -->
            <div class="h-100 position-absolute start-0 top-0" style="width: 6px; background-color: <?= $paket['status'] === 'ready' ? 'var(--bs-primary)' : 'var(--bs-warning)' ?>;"></div>
            
            <div class="card-body p-4 ps-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge rounded-pill border <?= $paket['status'] === 'ready' ? 'bg-primary-subtle text-primary border-primary-subtle' : 'bg-warning-subtle text-warning border-warning-subtle' ?> px-3 py-2 extra-small fw-bold">
                        <?= strtoupper($paket['status']) ?>
                    </span>
                    <div class="dropdown">
                        <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                            <li><a class="dropdown-item small" href="modul-soal-buat.php?id=<?= $paket['id'] ?>"><i class="bi bi-pencil me-2"></i>Edit Paket</a></li>
                            <li><a class="dropdown-item small" href="#"><i class="bi bi-files me-2"></i>Duplikasi</a></li>
                            <li><a class="dropdown-item small" href="#"><i class="bi bi-file-earmark-pdf me-2"></i>Download PDF</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item small text-danger" href="#"><i class="bi bi-trash me-2"></i>Hapus</a></li>
                        </ul>
                    </div>
                </div>

                <h5 class="fw-bold text-dark mb-2 text-truncate-2" style="min-height: 3rem;"><?= $paket['title'] ?></h5>
                
                <div class="d-flex align-items-center gap-2 mb-4">
                    <span class="badge bg-light text-muted border fw-normal"><?= $paket['subject'] ?></span>
                    <span class="text-muted small">•</span>
                    <span class="text-muted small"><?= $paket['id'] ?></span>
                </div>

                <div class="row g-2 mb-4">
                    <div class="col-4">
                        <div class="bg-light rounded-3 p-2 text-center border border-dashed">
                            <div class="h6 fw-bold mb-0 text-dark"><?= $paket['q_count'] ?></div>
                            <div class="extra-small text-muted text-uppercase">Soal</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="bg-light rounded-3 p-2 text-center border border-dashed">
                            <div class="h6 fw-bold mb-0 text-dark"><?= $paket['duration'] ?></div>
                            <div class="extra-small text-muted text-uppercase">Durasi</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="bg-light rounded-3 p-2 text-center border border-dashed">
                            <div class="h6 fw-bold mb-0 text-dark text-capitalize text-truncate"><?= $paket['type'] ?></div>
                            <div class="extra-small text-muted text-uppercase">Tipe</div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                     <a href="modul-soal-buat.php?id=<?= $paket['id'] ?>" class="btn btn-outline-primary rounded-pill btn-sm fw-medium">
                        <i class="bi bi-pencil-square me-1"></i> Edit Soal
                    </a>
                    <button class="btn btn-light rounded-pill btn-sm text-muted border hover-border-primary" onclick="alert('Fitur Download PDF akan segera tersedia!')">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Download PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Modal: New Question Package (Premium) -->
<div class="modal fade" id="modalPaketSoal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-body p-0">
                <div class="row g-0" style="min-height: 500px;">
                    <!-- Left Side: Visual/Info -->
                    <div class="col-lg-4 bg-primary text-white p-5 d-flex flex-column position-relative overflow-hidden">
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(0,0,0,0.05) 100%);"></div>
                        
                        <!-- Content -->
                        <div class="position-relative z-2 h-100 d-flex flex-column">
                            <div class="mb-5">
                                <div class="bg-white bg-opacity-20 rounded-3 d-inline-flex align-items-center justify-content-center p-3 mb-4 backdrop-blur-sm">
                                    <i class="bi bi-stack fs-3 text-white"></i>
                                </div>
                                <h3 class="fw-bold mb-2">Buat Paket Soal</h3>
                                <p class="opacity-75 mb-0 fs-6 fw-light">Kumpulkan soal-soal berkualitas untuk menguji pemahaman siswa.</p>
                            </div>

                            <div class="d-flex flex-column gap-4 mt-auto">
                                <div class="d-flex gap-3 align-items-start">
                                    <div class="rounded-circle bg-white bg-opacity-25 p-1 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                        <i class="bi bi-check-lg small"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1 fs-7">Fleksibel</h6>
                                        <p class="small opacity-50 mb-0">Dukung berbagai tipe soal: Pilihan Ganda, Esai, Skala, dll.</p>
                                    </div>
                                </div>
                                <div class="d-flex gap-3 align-items-start">
                                    <div class="rounded-circle bg-white bg-opacity-25 p-1 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                        <i class="bi bi-check-lg small"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1 fs-7">Bank Soal</h6>
                                        <p class="small opacity-50 mb-0">Simpan dan gunakan kembali soal untuk ujian mendatang.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Decorative Elements -->
                        <div class="position-absolute bottom-0 start-0 translate-middle-x translate-middle-y mb-n5 ms-n5 bg-white bg-opacity-10 rounded-circle" style="width: 300px; height: 300px; filter: blur(50px);"></div>
                        <div class="position-absolute top-0 end-0 translate-middle-x translate-middle-y mt-n5 me-n5 bg-info bg-opacity-20 rounded-circle" style="width: 200px; height: 200px; filter: blur(30px);"></div>
                    </div>
                    
                    <!-- Right Side: Form -->
                    <div class="col-lg-8 bg-white d-flex flex-column">
                        <div class="p-4 p-lg-5 h-100 overflow-y-auto">
                            <div class="d-flex justify-content-between align-items-center mb-5">
                                <div>
                                    <h5 class="fw-bold text-dark mb-1">Detail Paket</h5>
                                    <p class="text-muted small mb-0">Informasi dasar untuk paket soal ini.</p>
                                </div>
                                <button type="button" class="btn-close bg-light rounded-circle p-2" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                            <form action="modul-soal-buat.php" method="GET">
                                <input type="hidden" name="id" value="PK-NEW">
                                <div class="row g-4">
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-muted text-uppercase ls-1">Nama Paket Soal <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-lg bg-light border-0 fw-medium" placeholder="Contoh: Ujian Tengah Semester Genap">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted text-uppercase ls-1">Mata Pelajaran / Topik</label>
                                        <select class="form-select border-0 bg-light p-3">
                                            <option>Operator Komputer</option>
                                            <option>Digital Marketing</option>
                                            <option>Desain Grafis</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted text-uppercase ls-1">Estimasi Durasi (Menit)</label>
                                        <input type="number" class="form-control border-0 bg-light p-3" value="60">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-muted text-uppercase ls-1">Deskripsi / Instruksi</label>
                                        <textarea class="form-control border-0 bg-light p-3" rows="3" placeholder="Instruksi pengerjaan untuk siswa..."></textarea>
                                    </div>
                                </div>
                                
                                <div class="mt-5 d-flex justify-content-end gap-3">
                                    <button type="button" class="btn btn-light rounded-pill px-4 fw-medium text-muted" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm hover-scale transition-all">
                                        <i class="bi bi-arrow-right me-2"></i>Buat & Tambah Soal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card-hover-transform {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.card-hover-transform:hover {
    transform: translateY(-5px);
    box-shadow: 0 1rem 3rem rgba(0,0,0,.075) !important;
}
.text-truncate-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.border-dashed {
    border-style: dashed !important;
}
.hover-border-primary:hover {
    border-color: var(--bs-primary) !important;
    color: var(--bs-primary) !important;
    background-color: var(--bs-primary-bg-subtle) !important;
}
</style>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>