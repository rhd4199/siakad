<?php
require_once __DIR__ . '/../config.php';
require_login(['tutor']);

$user         = current_user();
$title        = 'Modul Soal';
$currentPage  = 'modul-soal';
$roleBasePath = '/tutor';
$baseUrl      = '/siakad';

// Paket terpilih (demo)
$selectedPaket = $_GET['paket'] ?? 'PK-OM-01';

// Dummy data paket
$pakets = [
    'PK-OM-01' => [
        'kode'        => 'PK-OM-01',
        'nama'        => 'Ujian Akhir – Operator Komputer',
        'program'     => 'Operator Komputer',
        'status'      => 'Siap dipakai',
        'total_soal'  => 25,
        'total_skor'  => 100,
        'durasi'      => 60,
        'ringkasan'   => 'PG: 15 • Multi PG: 5 • B/S: 2 • Isian: 2 • Esai: 1',
    ],
    'PK-DM-01' => [
        'kode'        => 'PK-DM-01',
        'nama'        => 'Quiz Funnel & Konten – DM',
        'program'     => 'Digital Marketing',
        'status'      => 'Siap dipakai',
        'total_soal'  => 15,
        'total_skor'  => 50,
        'durasi'      => 45,
        'ringkasan'   => 'Skala: 5 • PG: 8 • Esai: 2',
    ],
    'PK-BRS-01' => [
        'kode'        => 'PK-BRS-01',
        'nama'        => 'Evaluasi Praktik – Barista Dasar',
        'program'     => 'Barista',
        'status'      => 'Draft',
        'total_soal'  => 8,
        'total_skor'  => 30,
        'durasi'      => 30,
        'ringkasan'   => 'Skala: 6 • Isian: 2',
    ],
];

// Pilih paket aktif (fallback ke PK-OM-01 kalau tidak ada)
$activePaket = $pakets[$selectedPaket] ?? $pakets['PK-OM-01'];

ob_start();
?>
<div class="row mb-3">
    <div class="col-lg-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <h4 class="fw-semibold mb-0">Modul Soal & Bank Paket</h4>
            <span class="badge bg-light text-muted extra-small">
                <i class="bi bi-patch-question me-1"></i> Pembuatan Soal
            </span>
        </div>
        <p class="text-muted small mb-0">
            Susun <strong>paket soal</strong> per program. Di sini tutor membuat soal,
            mengatur bobot, kunci jawaban, dan menyalin soal antar paket dengan mudah.
        </p>
    </div>
    <div class="col-lg-4 mt-3 mt-lg-0 text-lg-end">
        <button class="btn btn-primary btn-sm" type="button"
                data-bs-toggle="modal" data-bs-target="#modalPaketSoal">
            <i class="bi bi-plus-lg me-1"></i> Paket Baru
        </button>
    </div>
</div>

<!-- SUMMARY -->
<div class="row g-3 mb-3">
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-primary-subtle text-primary">
                <i class="bi bi-archive"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Total paket</div>
                <div class="fs-5 fw-semibold">6</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-success-subtle text-success">
                <i class="bi bi-patch-question"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Total soal</div>
                <div class="fs-5 fw-semibold">84</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-warning-subtle text-warning">
                <i class="bi bi-check-circle"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Paket siap dipakai</div>
                <div class="fs-5 fw-semibold">4</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-info-subtle text-info">
                <i class="bi bi-clock-history"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Rata2 soal/paket</div>
                <div class="fs-5 fw-semibold">14</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- KOLOM KIRI: DAFTAR PAKET -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body small">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-semibold mb-0">Paket Soal</h6>
                </div>
                <div class="mb-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control border-0"
                               placeholder="Cari paket (demo, belum aktif)">
                    </div>
                </div>

                <div class="small" style="max-height: 430px; overflow-y: auto;">
                    <?php foreach ($pakets as $kode => $paket): 
                        $isActive = ($activePaket['kode'] === $kode);
                    ?>
                        <div class="border rounded-3 p-2 mb-2 <?= $isActive ? 'border-primary bg-light' : 'bg-white' ?>">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="mb-1">
                                        <span class="badge bg-primary-subtle text-primary extra-small me-1">
                                            <?= htmlspecialchars($paket['kode']) ?>
                                        </span>
                                        <span class="badge bg-light text-muted extra-small me-1">
                                            <?= htmlspecialchars($paket['program']) ?>
                                        </span>
                                        <?php if ($paket['status'] === 'Siap dipakai'): ?>
                                            <span class="badge bg-success-subtle text-success extra-small">Siap</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary-subtle text-secondary extra-small">Draft</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="fw-semibold small mb-1">
                                        <?= htmlspecialchars($paket['nama']) ?>
                                    </div>
                                    <div class="extra-small text-muted">
                                        <?= htmlspecialchars($paket['ringkasan']) ?>
                                    </div>
                                </div>
                                <div class="text-end extra-small text-muted ms-2">
                                    <div><i class="bi bi-patch-question me-1"></i><?= $paket['total_soal'] ?> soal</div>
                                    <div><i class="bi bi-123 me-1"></i>Skor <?= $paket['total_skor'] ?></div>
                                    <div><i class="bi bi-stopwatch me-1"></i><?= $paket['durasi'] ?> mnt</div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2 extra-small">
                                <span class="text-muted">
                                    Klik <strong>Pilih</strong> untuk lihat daftar soal.
                                </span>
                                <div class="btn-group btn-group-sm">
                                    <a href="<?= $baseUrl . $roleBasePath ?>/modul-soal.php?paket=<?= urlencode($paket['kode']) ?>"
                                       class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-eye me-1"></i> Pilih
                                    </a>
                                    <button class="btn btn-outline-secondary btn-sm" type="button">
                                        <i class="bi bi-files me-1"></i> Copy
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: DETAIL PAKET & DAFTAR SOAL -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body small">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <div class="extra-small text-muted mb-1">Paket terpilih</div>
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                            <h6 class="fw-semibold mb-0">
                                <?= htmlspecialchars($activePaket['kode']) ?> – <?= htmlspecialchars($activePaket['nama']) ?>
                            </h6>
                            <?php if ($activePaket['status'] === 'Siap dipakai'): ?>
                                <span class="badge bg-success-subtle text-success extra-small">Siap dipakai</span>
                            <?php else: ?>
                                <span class="badge bg-secondary-subtle text-secondary extra-small">Draft</span>
                            <?php endif; ?>
                        </div>
                        <div class="extra-small text-muted">
                            Program: <?= htmlspecialchars($activePaket['program']) ?> •
                            Total soal: <?= $activePaket['total_soal'] ?> •
                            Total skor: <?= $activePaket['total_skor'] ?> •
                            Durasi saran: <?= $activePaket['durasi'] ?> menit
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="btn-group btn-group-sm mb-1">
                            <button class="btn btn-outline-secondary btn-sm" type="button">
                                <i class="bi bi-gear me-1"></i> Pengaturan paket
                            </button>
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-box-arrow-down me-1"></i> Export
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end extra-small">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-filetype-xls me-1"></i>Export ke Excel</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-filetype-doc me-1"></i>Export ke Word</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-filetype-pdf me-1"></i>Export ke PDF</a></li>
                            </ul>
                        </div>
                        <div class="extra-small text-muted">
                            Soal dapat dipakai ulang di banyak ujian.
                        </div>
                    </div>
                </div>

                <hr class="my-2">

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="d-flex flex-wrap align-items-center gap-2 extra-small">
                        <span class="text-muted">Tipe soal di paket ini:</span>
                        <?php if ($activePaket['kode'] === 'PK-OM-01'): ?>
                            <span class="badge bg-light text-muted">PG</span>
                            <span class="badge bg-light text-muted">Multi PG</span>
                            <span class="badge bg-light text-muted">Benar/Salah</span>
                            <span class="badge bg-light text-muted">Isian singkat</span>
                            <span class="badge bg-light text-muted">Esai</span>
                        <?php elseif ($activePaket['kode'] === 'PK-DM-01'): ?>
                            <span class="badge bg-light text-muted">PG</span>
                            <span class="badge bg-light text-muted">Skala</span>
                            <span class="badge bg-light text-muted">Esai</span>
                        <?php else: ?>
                            <span class="badge bg-light text-muted">Skala</span>
                            <span class="badge bg-light text-muted">Isian singkat</span>
                        <?php endif; ?>
                    </div>
                    <button class="btn btn-primary btn-sm" type="button"
                            data-bs-toggle="modal" data-bs-target="#modalSoalBaru">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Soal
                    </button>
                </div>

                <!-- LIST SOAL DALAM PAKET (BERBEDA PER PAKET) -->
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light extra-small text-muted">
                            <tr>
                                <th style="width: 32px;">#</th>
                                <th>Soal</th>
                                <th style="width: 110px;">Jenis</th>
                                <th style="width: 60px;" class="text-center">Skor</th>
                                <th style="width: 80px;" class="text-center">Kunci</th>
                                <th style="width: 120px;" class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="extra-small">
                        <?php if ($activePaket['kode'] === 'PK-OM-01'): ?>
                            <!-- Contoh soal Paket Operator -->
                            <tr>
                                <td>1</td>
                                <td>
                                    <div class="fw-semibold mb-1">
                                        Bagian berikut ini yang termasuk <strong>perangkat input</strong> adalah...
                                    </div>
                                    <div class="text-muted">
                                        PG • 4 opsi
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-muted">PG</span></td>
                                <td class="text-center">4</td>
                                <td class="text-center">
                                    <span class="badge bg-light text-muted">B</span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                                data-bs-toggle="modal" data-bs-target="#modalSoalEdit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                                data-bs-toggle="modal" data-bs-target="#modalCopySoal">
                                            <i class="bi bi-files"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                                data-bs-toggle="modal" data-bs-target="#modalHapusSoal">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>
                                    <div class="fw-semibold mb-1">
                                        Pilih <strong>SEMUA</strong> contoh perangkat output di bawah ini.
                                    </div>
                                    <div class="text-muted">
                                        Multi PG • 5 opsi
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-muted">Multi PG</span></td>
                                <td class="text-center">5</td>
                                <td class="text-center">
                                    <span class="badge bg-light text-muted">A, C, E</span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                                data-bs-toggle="modal" data-bs-target="#modalSoalEdit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                                data-bs-toggle="modal" data-bs-target="#modalCopySoal">
                                            <i class="bi bi-files"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                                data-bs-toggle="modal" data-bs-target="#modalHapusSoal">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>
                                    <div class="fw-semibold mb-1">
                                        Menyalakan komputer tanpa mematikan dengan prosedur yang benar
                                        bisa menyebabkan kerusakan pada sistem.
                                    </div>
                                    <div class="text-muted">
                                        Benar / Salah
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-muted">Benar/Salah</span></td>
                                <td class="text-center">2</td>
                                <td class="text-center">
                                    <span class="badge bg-light text-muted">Benar</span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                                data-bs-toggle="modal" data-bs-target="#modalSoalEdit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                                data-bs-toggle="modal" data-bs-target="#modalCopySoal">
                                            <i class="bi bi-files"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                                data-bs-toggle="modal" data-bs-target="#modalHapusSoal">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php elseif ($activePaket['kode'] === 'PK-DM-01'): ?>
                            <!-- Contoh soal Paket Digital Marketing -->
                            <tr>
                                <td>1</td>
                                <td>
                                    <div class="fw-semibold mb-1">
                                        Seberapa sering Anda mengunggah konten di Instagram bisnis dalam 1 minggu?
                                    </div>
                                    <div class="text-muted">
                                        Skala 1–5 • Frekuensi
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-muted">Skala</span></td>
                                <td class="text-center">2</td>
                                <td class="text-center">
                                    <span class="badge bg-light text-muted">Auto</span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                                data-bs-toggle="modal" data-bs-target="#modalSoalEdit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                                data-bs-toggle="modal" data-bs-target="#modalCopySoal">
                                            <i class="bi bi-files"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                                data-bs-toggle="modal" data-bs-target="#modalHapusSoal">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>
                                    <div class="fw-semibold mb-1">
                                        Platform berikut yang termasuk <strong>top of funnel</strong> adalah...
                                    </div>
                                    <div class="text-muted">
                                        PG • 4 opsi
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-muted">PG</span></td>
                                <td class="text-center">3</td>
                                <td class="text-center">
                                    <span class="badge bg-light text-muted">A</span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                                data-bs-toggle="modal" data-bs-target="#modalSoalEdit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                                data-bs-toggle="modal" data-bs-target="#modalCopySoal">
                                            <i class="bi bi-files"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                                data-bs-toggle="modal" data-bs-target="#modalHapusSoal">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <!-- Contoh soal Paket Barista -->
                            <tr>
                                <td>1</td>
                                <td>
                                    <div class="fw-semibold mb-1">
                                        Seberapa mantap Anda menguasai teknik basic latte art (heart)?
                                    </div>
                                    <div class="text-muted">
                                        Skala 1–5 • Self-assessment
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-muted">Skala</span></td>
                                <td class="text-center">3</td>
                                <td class="text-center">
                                    <span class="badge bg-light text-muted">Auto</span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                                data-bs-toggle="modal" data-bs-target="#modalSoalEdit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                                data-bs-toggle="modal" data-bs-target="#modalCopySoal">
                                            <i class="bi bi-files"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                                data-bs-toggle="modal" data-bs-target="#modalHapusSoal">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <p class="extra-small text-muted mt-2 mb-0">
                    Setiap soal bisa di-edit, dihapus, atau disalin ke paket lain. Di versi produksi,
                    penomoran dan bobot bisa diatur massal.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- ============ MODALS ============ -->

<!-- Modal: Buat Paket Soal -->
<div class="modal fade" id="modalPaketSoal" tabindex="-1" aria-labelledby="modalPaketSoalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header border-0 pb-0">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge bg-primary-subtle text-primary extra-small">
                            <i class="bi bi-archive me-1"></i> Paket Soal
                        </span>
                        <span class="badge bg-light text-muted extra-small">
                            Bank Soal Per Program
                        </span>
                    </div>
                    <h6 class="modal-title small fw-semibold mb-0" id="modalPaketSoalLabel">
                        Buat Paket Soal Baru
                    </h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body small pt-3">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label extra-small text-muted mb-1">Kode Paket</label>
                        <input type="text" class="form-control form-control-sm"
                               value="PK-OM-02" placeholder="Contoh: PK-OM-02">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label extra-small text-muted mb-1">Nama Paket</label>
                        <input type="text" class="form-control form-control-sm"
                               placeholder="Contoh: Quiz Tengah Program – Operator Komputer">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label extra-small text-muted mb-1">Program / Modul</label>
                        <select class="form-select form-select-sm">
                            <option>Operator Komputer Dasar</option>
                            <option>Digital Marketing Pemula</option>
                            <option>Barista Dasar</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label extra-small text-muted mb-1">Level</label>
                        <select class="form-select form-select-sm">
                            <option>Basic</option>
                            <option>Intermediate</option>
                            <option>Advanced</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label extra-small text-muted mb-1">Durasi saran (menit)</label>
                        <input type="number" class="form-control form-control-sm" value="45" min="10">
                    </div>
                    <div class="col-12">
                        <label class="form-label extra-small text-muted mb-1">Catatan / Tujuan Paket</label>
                        <textarea class="form-control form-control-sm" rows="2"
                                  placeholder="Contoh: Quiz untuk mengukur pemahaman sebelum ujian akhir."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-sm">
                    <i class="bi bi-check2-circle me-1"></i> Simpan Paket (Demo)
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Tambah Soal Baru -->
<div class="modal fade" id="modalSoalBaru" tabindex="-1" aria-labelledby="modalSoalBaruLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0">
            <div class="modal-header border-0 pb-0">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge bg-primary-subtle text-primary extra-small">
                            <i class="bi bi-patch-question me-1"></i> Soal Baru
                        </span>
                        <span class="badge bg-light text-muted extra-small">
                            <?= htmlspecialchars($activePaket['kode']) ?> – <?= htmlspecialchars($activePaket['nama']) ?>
                        </span>
                    </div>
                    <h6 class="modal-title small fw-semibold mb-0" id="modalSoalBaruLabel">
                        Tambah Soal ke Paket
                    </h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body small pt-3">
                <div class="row g-3">
                    <!-- KIRI: PERTANYAAN & BOBOT -->
                    <div class="col-lg-7">
                        <div class="mb-2">
                            <label class="form-label extra-small text-muted mb-1">Teks Soal</label>
                            <textarea class="form-control form-control-sm" rows="4"
                                      placeholder="Tulis pertanyaan di sini..."></textarea>
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-md-5">
                                <label class="form-label extra-small text-muted mb-1">Jenis Soal</label>
                                <select class="form-select form-select-sm">
                                    <option>Pilihan Ganda (1 jawaban benar)</option>
                                    <option>Pilihan Ganda (lebih dari 1 benar)</option>
                                    <option>Benar / Salah</option>
                                    <option>Isian singkat</option>
                                    <option>Esai</option>
                                    <option>Skala (1–5)</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label extra-small text-muted mb-1">Skor / Bobot</label>
                                <input type="number" class="form-control form-control-sm" value="4" min="1">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label extra-small text-muted mb-1">Tag / Kelompok</label>
                                <input type="text" class="form-control form-control-sm"
                                       placeholder="Perangkat, OS, dll.">
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label extra-small text-muted mb-1">Pembahasan / catatan (opsional)</label>
                            <textarea class="form-control form-control-sm" rows="2"
                                      placeholder="Catatan untuk pembahasan atau koreksi manual."></textarea>
                        </div>
                    </div>

                    <!-- KANAN: INPUT JAWABAN -->
                    <div class="col-lg-5">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body small d-flex flex-column">
                                <h6 class="fw-semibold mb-2">Jawaban & Kunci</h6>

                                <ul class="nav nav-pills extra-small mb-2" role="tablist">
                                    <li class="nav-item">
                                        <button class="nav-link active py-1 px-2" data-bs-toggle="pill"
                                                data-bs-target="#tab-pg-input" type="button">
                                            PG
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link py-1 px-2" data-bs-toggle="pill"
                                                data-bs-target="#tab-mpg-input" type="button">
                                            Multi PG
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link py-1 px-2" data-bs-toggle="pill"
                                                data-bs-target="#tab-bs-input" type="button">
                                            B/S
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link py-1 px-2" data-bs-toggle="pill"
                                                data-bs-target="#tab-isian-input" type="button">
                                            Isian
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link py-1 px-2" data-bs-toggle="pill"
                                                data-bs-target="#tab-esai-input" type="button">
                                            Esai
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link py-1 px-2" data-bs-toggle="pill"
                                                data-bs-target="#tab-skala-input" type="button">
                                            Skala
                                        </button>
                                    </li>
                                </ul>

                                <div class="tab-content flex-grow-1">
                                    <!-- PG Input -->
                                    <div class="tab-pane fade show active" id="tab-pg-input">
                                        <p class="extra-small text-muted mb-2">
                                            Pilihan ganda dengan <strong>1 jawaban benar</strong>.
                                            Pilih salah satu sebagai kunci.
                                        </p>
                                        <?php foreach (['A','B','C','D'] as $opt): ?>
                                            <div class="input-group input-group-sm mb-1">
                                                <span class="input-group-text"><?= $opt ?>.</span>
                                                <input type="text" class="form-control"
                                                       placeholder="Opsi jawaban <?= $opt ?>">
                                                <span class="input-group-text bg-white">
                                                    <div class="form-check m-0">
                                                        <input class="form-check-input" type="radio"
                                                               name="pg_kunci">
                                                    </div>
                                                </span>
                                            </div>
                                        <?php endforeach; ?>
                                        <button class="btn btn-outline-secondary btn-xs extra-small mt-1" type="button">
                                            <i class="bi bi-plus-lg me-1"></i> Tambah opsi (Demo)
                                        </button>
                                    </div>

                                    <!-- Multi PG Input -->
                                    <div class="tab-pane fade" id="tab-mpg-input">
                                        <p class="extra-small text-muted mb-2">
                                            Pilihan ganda dengan <strong>lebih dari 1 jawaban benar</strong>.
                                            Centang opsi yang menjadi kunci.
                                        </p>
                                        <?php foreach (['A','B','C','D','E'] as $opt): ?>
                                            <div class="input-group input-group-sm mb-1">
                                                <span class="input-group-text"><?= $opt ?>.</span>
                                                <input type="text" class="form-control"
                                                       placeholder="Opsi jawaban <?= $opt ?>">
                                                <span class="input-group-text bg-white">
                                                    <div class="form-check m-0">
                                                        <input class="form-check-input" type="checkbox">
                                                    </div>
                                                </span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <!-- Benar / Salah Input -->
                                    <div class="tab-pane fade" id="tab-bs-input">
                                        <p class="extra-small text-muted mb-2">
                                            Tentukan apakah pernyataan di teks soal adalah <strong>Benar</strong>
                                            atau <strong>Salah</strong>.
                                        </p>
                                        <div class="form-check extra-small mb-1">
                                            <input class="form-check-input" type="radio" name="bs_kunci" id="bsBenar2" checked>
                                            <label class="form-check-label" for="bsBenar2">Benar</label>
                                        </div>
                                        <div class="form-check extra-small">
                                            <input class="form-check-input" type="radio" name="bs_kunci" id="bsSalah2">
                                            <label class="form-check-label" for="bsSalah2">Salah</label>
                                        </div>
                                    </div>

                                    <!-- Isian singkat Input -->
                                    <div class="tab-pane fade" id="tab-isian-input">
                                        <p class="extra-small text-muted mb-2">
                                            Tambahkan beberapa kemungkinan jawaban benar (dipisah koma).
                                        </p>
                                        <input type="text" class="form-control form-control-sm mb-1"
                                               placeholder="Contoh: harddisk, HDD, hard disk">
                                        <div class="form-text extra-small">
                                            Backend bisa cek dengan normalisasi teks (lowercase, trim).
                                        </div>
                                    </div>

                                    <!-- Esai Input -->
                                    <div class="tab-pane fade" id="tab-esai-input">
                                        <p class="extra-small text-muted mb-2">
                                            Jawaban akan dinilai manual. Tambahkan poin penilaian untuk memudahkan koreksi.
                                        </p>
                                        <label class="form-label extra-small text-muted mb-1">
                                            Poin penilaian (rubrik singkat)
                                        </label>
                                        <textarea class="form-control form-control-sm" rows="3"
                                                  placeholder="Contoh: menyebut 3 perangkat input, contoh jelas, bahasa rapi."></textarea>
                                    </div>

                                    <!-- Skala Input -->
                                    <div class="tab-pane fade" id="tab-skala-input">
                                        <p class="extra-small text-muted mb-2">
                                            Skala 1–5. Misal 1 = sangat tidak setuju, 5 = sangat setuju.
                                        </p>
                                        <div class="border rounded-3 p-2 bg-light-subtle extra-small mb-2">
                                            <div class="d-flex justify-content-between mb-1">
                                                <span>1</span><span>2</span><span>3</span><span>4</span><span>5</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="text-muted">Sangat tidak setuju</span>
                                                <span class="text-muted">Sangat setuju</span>
                                            </div>
                                        </div>
                                        <label class="form-label extra-small text-muted mb-1">
                                            Konversi skor (opsional)
                                        </label>
                                        <input type="text" class="form-control form-control-sm"
                                               placeholder="Contoh: 1–2 = 0, 3 = 50, 4–5 = 100">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- /col kanan -->
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-sm">
                    <i class="bi bi-check2-circle me-1"></i> Simpan Soal (Demo)
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Edit Soal (reuse layout Tambah Soal, cuma title berbeda) -->
<div class="modal fade" id="modalSoalEdit" tabindex="-1" aria-labelledby="modalSoalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0">
            <div class="modal-header border-0 pb-0">
                <div>
                    <span class="badge bg-light text-muted extra-small mb-1">
                        Edit Soal • <?= htmlspecialchars($activePaket['kode']) ?>
                    </span>
                    <h6 class="modal-title small fw-semibold mb-0" id="modalSoalEditLabel">
                        Edit Soal (Demo)
                    </h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body small">
                <p class="extra-small text-muted mb-0">
                    Untuk demo, struktur form sama seperti <strong>Tambah Soal</strong>. Di versi produksi,
                    data soal akan terisi otomatis di sini.
                </p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Hapus Soal -->
<div class="modal fade" id="modalHapusSoal" tabindex="-1" aria-labelledby="modalHapusSoalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title small fw-semibold" id="modalHapusSoalLabel">
                    Hapus Soal dari Paket?
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body small">
                <p class="mb-1">
                    Soal ini akan dihapus dari paket <strong><?= htmlspecialchars($activePaket['kode']) ?></strong>.
                </p>
                <p class="extra-small text-muted mb-0">
                    Di versi produksi, jika soal dipakai di ujian yang sudah berjalan, sistem bisa minta konfirmasi tambahan.
                </p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger btn-sm">
                    <i class="bi bi-trash me-1"></i> Hapus (Demo)
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Copy Soal ke Paket Lain -->
<div class="modal fade" id="modalCopySoal" tabindex="-1" aria-labelledby="modalCopySoalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title small fw-semibold" id="modalCopySoalLabel">
                    Salin Soal ke Paket Lain
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body small">
                <p class="extra-small text-muted">
                    Pilih paket tujuan. Soal akan dicopy dengan teks, opsi, kunci, dan bobot yang sama.
                </p>
                <?php foreach ($pakets as $kode => $paket): if ($kode === $activePaket['kode']) continue; ?>
                    <div class="form-check extra-small mb-1">
                        <input class="form-check-input" type="radio" name="copy_target" id="copy<?= $kode ?>">
                        <label class="form-check-label" for="copy<?= $kode ?>">
                            <?= htmlspecialchars($paket['kode']) ?> – <?= htmlspecialchars($paket['nama']) ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-sm">
                    <i class="bi bi-files me-1"></i> Salin (Demo)
                </button>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
