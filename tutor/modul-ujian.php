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
        'kode'        => 'EX-OM-FINAL',
        'nama'        => 'Ujian Akhir – Operator Komputer Dasar',
        'program'     => 'Operator Komputer',
        'modul_kelas' => 'MOD-OM-01',
        'paket_soal'  => 'PK-OM-01',
        'jenis'       => 'Ujian Akhir',
        'mode'        => 'Online',
        'durasi'      => 60,
        'kkm'         => 70,
        'status'      => 'ready',
        'attempt'     => 1,
    ],
    [
        'kode'        => 'EX-OM-QUIZ1',
        'nama'        => 'Quiz Pertemuan 3 – Ms Word Dasar',
        'program'     => 'Operator Komputer',
        'modul_kelas' => 'MOD-OM-01',
        'paket_soal'  => 'PK-OM-QUIZ1',
        'jenis'       => 'Quiz',
        'mode'        => 'Online',
        'durasi'      => 20,
        'kkm'         => 60,
        'status'      => 'draft',
        'attempt'     => 2,
    ],
    [
        'kode'        => 'EX-DM-MID',
        'nama'        => 'Mid Test – Digital Marketing Pemula',
        'program'     => 'Digital Marketing',
        'modul_kelas' => 'MOD-DM-01',
        'paket_soal'  => 'PK-DM-01',
        'jenis'       => 'Mid Test',
        'mode'        => 'Online',
        'durasi'      => 45,
        'kkm'         => 75,
        'status'      => 'ready',
        'attempt'     => 1,
    ],
];

ob_start();
?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h4 class="fw-bold mb-1">Template Ujian</h4>
        <p class="text-muted small mb-0">
            Kelola blueprint ujian, aturan kelulusan, dan koneksi ke paket soal.
        </p>
    </div>
    <button class="btn btn-primary rounded-pill px-4 shadow-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalUjianBaru">
        <i class="bi bi-plus-lg me-2"></i>Buat Template
    </button>
</div>

<!-- Stats Summary (Optional but helpful) -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-4 bg-white shadow-sm border border-light h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="p-2 bg-primary-subtle text-primary rounded-3">
                    <i class="bi bi-clipboard-data fs-5"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold"><?= count($modulUjianList) ?></div>
                    <div class="text-muted extra-small text-uppercase fw-semibold">Total Template</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-4 bg-white shadow-sm border border-light h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="p-2 bg-success-subtle text-success rounded-3">
                    <i class="bi bi-check-circle fs-5"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold">2</div>
                    <div class="text-muted extra-small text-uppercase fw-semibold">Siap Pakai</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search & Filter -->
<div class="row g-3 mb-4">
    <div class="col-md-5 col-lg-4">
        <div class="input-group bg-white rounded-pill shadow-sm border p-1">
            <span class="input-group-text border-0 bg-transparent ps-3 text-muted">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" class="form-control border-0 bg-transparent" placeholder="Cari template ujian...">
        </div>
    </div>
    <div class="col-md-7 col-lg-8 text-md-end">
        <div class="d-inline-flex bg-white rounded-pill shadow-sm border p-1 overflow-auto" style="max-width: 100%;">
            <button class="btn btn-sm btn-light rounded-pill px-3 fw-medium text-nowrap">Semua</button>
            <button class="btn btn-sm btn-white text-muted rounded-pill px-3 text-nowrap">Ujian Akhir</button>
            <button class="btn btn-sm btn-white text-muted rounded-pill px-3 text-nowrap">Quiz</button>
            <button class="btn btn-sm btn-white text-muted rounded-pill px-3 text-nowrap">Draft</button>
        </div>
    </div>
</div>

<!-- List Layout -->
<div class="row g-3">
    <?php foreach ($modulUjianList as $item): ?>
    <div class="col-12">
        <div class="card border-0 shadow-sm card-hover-start">
            <div class="card-body p-4">
                <div class="row align-items-center gy-3">
                    <!-- Main Info -->
                    <div class="col-lg-5">
                        <div class="d-flex gap-3">
                            <div class="flex-shrink-0">
                                <div class="rounded-3 p-3 d-flex align-items-center justify-content-center 
                                    <?= $item['status'] === 'ready' ? 'bg-primary-subtle text-primary' : 'bg-secondary-subtle text-secondary' ?>" 
                                    style="width: 56px; height: 56px;">
                                    <i class="bi bi-file-earmark-text fs-4"></i>
                                </div>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1 text-dark"><?= $item['nama'] ?></h6>
                                <div class="d-flex flex-wrap align-items-center gap-2 small text-muted">
                                    <span class="badge bg-light text-muted border"><?= $item['kode'] ?></span>
                                    <span>•</span>
                                    <span><?= $item['program'] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Details (Grid inside row) -->
                    <div class="col-lg-4">
                        <div class="row g-2 text-center text-md-start">
                            <div class="col-4 col-lg-4">
                                <div class="extra-small text-muted text-uppercase fw-bold">Durasi</div>
                                <div class="fw-medium small"><i class="bi bi-clock me-1 text-info"></i><?= $item['durasi'] ?>m</div>
                            </div>
                            <div class="col-4 col-lg-4">
                                <div class="extra-small text-muted text-uppercase fw-bold">KKM</div>
                                <div class="fw-medium small"><i class="bi bi-check-all me-1 text-success"></i><?= $item['kkm'] ?></div>
                            </div>
                            <div class="col-4 col-lg-4">
                                <div class="extra-small text-muted text-uppercase fw-bold">Soal</div>
                                <div class="fw-medium small text-truncate" title="<?= $item['paket_soal'] ?>">
                                    <i class="bi bi-stack me-1 text-warning"></i>PKT
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status & Actions -->
                    <div class="col-lg-3 text-lg-end">
                        <div class="d-flex align-items-center justify-content-lg-end gap-3">
                            <?php if($item['status'] === 'ready'): ?>
                                <span class="badge bg-success-subtle text-success rounded-pill px-3">Siap Pakai</span>
                            <?php else: ?>
                                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">Draft</span>
                            <?php endif; ?>

                            <div class="dropdown">
                                <button class="btn btn-icon btn-light rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                                    <li><h6 class="dropdown-header">Aksi</h6></li>
                                    <li><a class="dropdown-item small" href="#"><i class="bi bi-pencil me-2"></i>Edit Aturan</a></li>
                                    <li><a class="dropdown-item small" href="#"><i class="bi bi-files me-2"></i>Duplikasi</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item small text-danger" href="#"><i class="bi bi-trash me-2"></i>Hapus</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light border-0 py-2">
                <div class="d-flex align-items-center gap-2 extra-small text-muted">
                    <i class="bi bi-link-45deg"></i>
                    <span>Terhubung dengan Modul Kelas: <strong><?= $item['modul_kelas'] ?></strong></span>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Modal: Modul Ujian Baru -->
<div class="modal fade" id="modalUjianBaru" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Buat Template Ujian Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <form>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-medium text-muted">Kode Ujian</label>
                            <input type="text" class="form-control" placeholder="EX-..." value="EX-NEW-01">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-medium text-muted">Nama Template Ujian</label>
                            <input type="text" class="form-control" placeholder="Contoh: Ujian Akhir Semester...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium text-muted">Program / Kelas</label>
                            <select class="form-select">
                                <option selected disabled>Pilih Modul Kelas...</option>
                                <option>MOD-OM-01 - Operator Komputer</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium text-muted">Paket Soal Utama</label>
                            <select class="form-select">
                                <option selected disabled>Pilih Paket Soal...</option>
                                <option>PK-OM-01 - Paket Utama</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <hr class="text-muted opacity-25">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-medium text-muted">Durasi (Menit)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-clock"></i></span>
                                <input type="number" class="form-control" value="60">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-medium text-muted">KKM (0-100)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-check-circle"></i></span>
                                <input type="number" class="form-control" value="70">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-medium text-muted">Kesempatan (x)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-arrow-repeat"></i></span>
                                <input type="number" class="form-control" value="1">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary rounded-pill px-4">Simpan Template</button>
            </div>
        </div>
    </div>
</div>

<style>
.card-hover-start {
    transition: all 0.2s ease;
    border-left: 4px solid transparent !important;
}
.card-hover-start:hover {
    transform: translateY(-2px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    border-left-color: var(--bs-primary) !important;
}
.btn-icon {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
</style>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>
