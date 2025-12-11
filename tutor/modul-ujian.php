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
    'EX-OM-FINAL' => [
        'kode'        => 'EX-OM-FINAL',
        'nama'        => 'Ujian Akhir – Operator Komputer Dasar',
        'program'     => 'Operator Komputer',
        'modul_kelas' => 'MOD-OM-01',
        'paket_soal'  => 'PK-OM-01',
        'jenis'       => 'Ujian Akhir',
        'mode'        => 'Online',
        'durasi'      => 60,
        'kkm'         => 70,
        'status'      => 'Siap dipakai',
        'attempt'     => 1,
    ],
    'EX-OM-QUIZ1' => [
        'kode'        => 'EX-OM-QUIZ1',
        'nama'        => 'Quiz Pertemuan 3 – Ms Word Dasar',
        'program'     => 'Operator Komputer',
        'modul_kelas' => 'MOD-OM-01',
        'paket_soal'  => 'PK-OM-QUIZ1',
        'jenis'       => 'Quiz',
        'mode'        => 'Online',
        'durasi'      => 20,
        'kkm'         => 60,
        'status'      => 'Draft',
        'attempt'     => 2,
    ],
    'EX-DM-MID' => [
        'kode'        => 'EX-DM-MID',
        'nama'        => 'Mid Test – Digital Marketing Pemula',
        'program'     => 'Digital Marketing',
        'modul_kelas' => 'MOD-DM-01',
        'paket_soal'  => 'PK-DM-01',
        'jenis'       => 'Mid Test',
        'mode'        => 'Online',
        'durasi'      => 45,
        'kkm'         => 75,
        'status'      => 'Siap dipakai',
        'attempt'     => 1,
    ],
];

$selectedKode = $_GET['kode'] ?? 'EX-OM-FINAL';
$activeUjian  = $modulUjianList[$selectedKode] ?? $modulUjianList['EX-OM-FINAL'];

ob_start();
?>
<div class="row mb-3">
    <div class="col-lg-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <h4 class="fw-semibold mb-0">Modul Ujian</h4>
            <span class="badge bg-light text-muted extra-small">
                <i class="bi bi-clipboard-data me-1"></i> Template Ujian & Aturan
            </span>
        </div>
        <p class="text-muted small mb-0">
            Di sini tutor menyusun <strong>template ujian</strong>: jenis ujian, durasi, KKM,
            aturan pengerjaan, serta paket soal yang dipakai. Nanti admin tinggal pilih modul ini
            saat menjadwalkan <strong>Ujian Aktif</strong>.
        </p>
    </div>
    <div class="col-lg-4 mt-3 mt-lg-0 text-lg-end">
        <button class="btn btn-primary btn-sm" type="button"
                data-bs-toggle="modal" data-bs-target="#modalUjianBaru">
            <i class="bi bi-plus-lg me-1"></i> Modul Ujian Baru
        </button>
    </div>
</div>

<!-- SUMMARY -->
<div class="row g-3 mb-3">
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-primary-subtle text-primary">
                <i class="bi bi-clipboard-data"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Total modul ujian</div>
                <div class="fs-5 fw-semibold">8</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-success-subtle text-success">
                <i class="bi bi-check-circle"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Siap dipakai</div>
                <div class="fs-5 fw-semibold">5</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-warning-subtle text-warning">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Rata2 durasi</div>
                <div class="fs-5 fw-semibold">40 mnt</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-info-subtle text-info">
                <i class="bi bi-graph-up"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Rata2 KKM</div>
                <div class="fs-5 fw-semibold">70</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- KOLOM KIRI: LIST MODUL UJIAN -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body small">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-semibold mb-0">Daftar Modul Ujian</h6>
                </div>
                <div class="mb-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control border-0"
                               placeholder="Cari ujian: UTS, UAS, Quiz (demo)">
                    </div>
                </div>

                <div class="small" style="max-height: 430px; overflow-y: auto;">
                    <?php foreach ($modulUjianList as $kode => $m): 
                        $isActive = ($kode === $activeUjian['kode']);
                    ?>
                        <div class="border rounded-3 p-2 mb-2 <?= $isActive ? 'border-primary bg-light' : 'bg-white' ?>">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="mb-1">
                                        <span class="badge bg-primary-subtle text-primary extra-small me-1">
                                            <?= htmlspecialchars($m['kode']) ?>
                                        </span>
                                        <span class="badge bg-light text-muted extra-small me-1">
                                            <?= htmlspecialchars($m['jenis']) ?>
                                        </span>
                                        <?php if ($m['status'] === 'Siap dipakai'): ?>
                                            <span class="badge bg-success-subtle text-success extra-small">Siap</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary-subtle text-secondary extra-small">Draft</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="fw-semibold small mb-1">
                                        <?= htmlspecialchars($m['nama']) ?>
                                    </div>
                                    <div class="extra-small text-muted">
                                        Program: <?= htmlspecialchars($m['program']) ?><br>
                                        Modul kelas: <?= htmlspecialchars($m['modul_kelas']) ?> • Paket soal: <?= htmlspecialchars($m['paket_soal']) ?>
                                    </div>
                                </div>
                                <div class="text-end extra-small text-muted ms-2">
                                    <div><i class="bi bi-stopwatch me-1"></i><?= $m['durasi'] ?> mnt</div>
                                    <div><i class="bi bi-clipboard-check me-1"></i>KKM <?= $m['kkm'] ?></div>
                                    <div><i class="bi bi-arrow-repeat me-1"></i>Attempt: <?= $m['attempt'] ?></div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2 extra-small">
                                <span class="text-muted">
                                    Klik <strong>Pilih</strong> untuk lihat aturan lengkap.
                                </span>
                                <div class="btn-group btn-group-sm">
                                    <a href="<?= $baseUrl . $roleBasePath ?>/modul-ujian.php?kode=<?= urlencode($kode) ?>"
                                       class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-eye me-1"></i> Pilih
                                    </a>
                                    <button class="btn btn-outline-secondary btn-sm" type="button">
                                        <i class="bi bi-files me-1"></i> Duplikasi
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: DETAIL MODUL UJIAN -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body small">
                <!-- Header modul ujian -->
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <div class="extra-small text-muted mb-1">Modul ujian terpilih</div>
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                            <h6 class="fw-semibold mb-0">
                                <?= htmlspecialchars($activeUjian['kode']) ?> – <?= htmlspecialchars($activeUjian['nama']) ?>
                            </h6>
                            <span class="badge bg-light text-muted extra-small">
                                <?= htmlspecialchars($activeUjian['jenis']) ?> • <?= htmlspecialchars($activeUjian['mode']) ?>
                            </span>
                            <?php if ($activeUjian['status'] === 'Siap dipakai'): ?>
                                <span class="badge bg-success-subtle text-success extra-small">Siap dipakai</span>
                            <?php else: ?>
                                <span class="badge bg-secondary-subtle text-secondary extra-small">Draft</span>
                            <?php endif; ?>
                        </div>
                        <div class="extra-small text-muted">
                            Program: <?= htmlspecialchars($activeUjian['program']) ?> •
                            Modul kelas: <?= htmlspecialchars($activeUjian['modul_kelas']) ?> •
                            Paket soal: <?= htmlspecialchars($activeUjian['paket_soal']) ?>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="btn-group btn-group-sm mb-1">
                            <button class="btn btn-outline-secondary btn-sm" type="button">
                                <i class="bi bi-gear me-1"></i> Ubah pengaturan
                            </button>
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-box-arrow-down me-1"></i> Export
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end extra-small">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-filetype-xls me-1"></i>Export soal + aturan</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-filetype-pdf me-1"></i>Export layout ujian</a></li>
                            </ul>
                        </div>
                        <div class="extra-small text-muted">
                            Modul ini akan muncul di menu <strong>Ujian Aktif</strong> saat dijadwalkan admin.
                        </div>
                    </div>
                </div>

                <hr class="my-2">

                <!-- Ringkasan aturan -->
                <div class="row g-3 mb-2 extra-small">
                    <div class="col-md-4">
                        <div class="border rounded-3 p-2 bg-light-subtle h-100">
                            <div class="text-muted mb-1">Durasi & kelulusan</div>
                            <div><i class="bi bi-stopwatch me-1"></i>Durasi: <strong><?= $activeUjian['durasi'] ?> menit</strong></div>
                            <div><i class="bi bi-clipboard-check me-1"></i>KKM: <strong><?= $activeUjian['kkm'] ?></strong></div>
                            <div><i class="bi bi-arrow-repeat me-1"></i>Attempt: <strong><?= $activeUjian['attempt'] ?>x</strong></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded-3 p-2 bg-light-subtle h-100">
                            <div class="text-muted mb-1">Tampilan soal</div>
                            <div><i class="bi bi-shuffle me-1"></i>Acak urutan soal: <strong>Aktif</strong></div>
                            <div><i class="bi bi-shuffle me-1"></i>Acak opsi jawaban: <strong>Aktif</strong></div>
                            <div><i class="bi bi-arrow-left-right me-1"></i>Navigasi soal: <strong>Boleh mundur</strong></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded-3 p-2 bg-light-subtle h-100">
                            <div class="text-muted mb-1">Hasil & feedback</div>
                            <div><i class="bi bi-eye me-1"></i>Tampilkan skor langsung: <strong>Ya</strong></div>
                            <div><i class="bi bi-list-check me-1"></i>Tampilkan kunci: <strong>Setelah ujian ditutup</strong></div>
                            <div><i class="bi bi-arrow-counterclockwise me-1"></i>Remedial: <strong>Bisa diatur per kelas</strong></div>
                        </div>
                    </div>
                </div>

                <!-- Koneksi ke paket soal -->
                <div class="border rounded-3 p-2 mb-2 extra-small">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div>
                            <span class="text-muted">Paket soal utama</span><br>
                            <strong><?= htmlspecialchars($activeUjian['paket_soal']) ?></strong>
                            <span class="text-muted"> – terhubung ke Modul Soal.</span>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <a href="<?= $baseUrl . $roleBasePath ?>/modul-soal.php?paket=<?= urlencode($activeUjian['paket_soal']) ?>"
                               class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-box-arrow-up-right me-1"></i> Lihat paket soal
                            </a>
                            <button class="btn btn-outline-secondary btn-sm" type="button">
                                <i class="bi bi-plus-lg me-1"></i> Tambah paket pendukung
                            </button>
                        </div>
                    </div>
                    <div class="text-muted">
                        Ujian ini bisa memakai <strong>lebih dari 1 paket soal</strong>, misalnya teori + sikap.
                        Di versi produksi tinggal pilih beberapa paket sekaligus.
                    </div>
                </div>

                <!-- Flow peserta (ringkas) -->
                <div class="border rounded-3 p-2 extra-small">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-muted">Flow pengerjaan ujian oleh peserta (ringkas)</span>
                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                data-bs-toggle="modal" data-bs-target="#modalPreviewUjian">
                            <i class="bi bi-layout-sidebar-inset-reverse me-1"></i> Preview flow
                        </button>
                    </div>
                    <ol class="mb-0">
                        <li>Peserta login ke portal → masuk ke menu <strong>PR & Ujian</strong>.</li>
                        <li>Peserta klik ujian yang aktif → baca aturan singkat & durasi.</li>
                        <li>Begitu klik <strong>Mulai</strong>, timer berjalan dan soal muncul sesuai pengaturan modul ini.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============ MODALS ============ -->

<!-- Modal: Modul Ujian Baru -->
<div class="modal fade" id="modalUjianBaru" tabindex="-1" aria-labelledby="modalUjianBaruLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header border-0 pb-0">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge bg-primary-subtle text-primary extra-small">
                            <i class="bi bi-clipboard-data me-1"></i> Modul Ujian
                        </span>
                        <span class="badge bg-light text-muted extra-small">
                            Blueprint Ujian
                        </span>
                    </div>
                    <h6 class="modal-title small fw-semibold mb-0" id="modalUjianBaruLabel">
                        Buat Modul Ujian Baru
                    </h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body small pt-3">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label extra-small text-muted mb-1">Kode Ujian</label>
                        <input type="text" class="form-control form-control-sm"
                               value="EX-OM-UTS" placeholder="Contoh: EX-OM-UTS">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label extra-small text-muted mb-1">Nama Ujian</label>
                        <input type="text" class="form-control form-control-sm"
                               placeholder="Contoh: UTS – Operator Komputer Dasar">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label extra-small text-muted mb-1">Program / Modul Kelas</label>
                        <select class="form-select form-select-sm">
                            <option>MOD-OM-01 – Operator Komputer Dasar</option>
                            <option>MOD-DM-01 – Digital Marketing Pemula</option>
                            <option>MOD-BRS-01 – Barista Dasar</option>
                        </select>
                        <div class="form-text extra-small">
                            ModuI kelas yang akan menggunakan ujian ini.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label extra-small text-muted mb-1">Paket Soal Utama</label>
                        <select class="form-select form-select-sm">
                            <option>PK-OM-01 – Ujian Akhir Operator</option>
                            <option>PK-OM-QUIZ1 – Quiz Ms Word</option>
                            <option>PK-DM-01 – Quiz Funnel & Konten</option>
                        </select>
                        <div class="form-text extra-small">
                            Paket soal diambil dari menu <strong>Modul Soal</strong>.
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label extra-small text-muted mb-1">Jenis Ujian</label>
                        <select class="form-select form-select-sm">
                            <option>Quiz</option>
                            <option>Mid Test</option>
                            <option>Ujian Akhir</option>
                            <option>Remedial</option>
                            <option>Praktik (input nilai saja)</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label extra-small text-muted mb-1">Mode</label>
                        <select class="form-select form-select-sm">
                            <option>Online (dikerjakan di sistem)</option>
                            <option>Offline (hanya input nilai)</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label extra-small text-muted mb-1">Durasi (menit)</label>
                        <input type="number" class="form-control form-control-sm" value="45" min="5">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label extra-small text-muted mb-1">KKM</label>
                        <input type="number" class="form-control form-control-sm" value="70" min="0" max="100">
                    </div>

                    <div class="col-12">
                        <label class="form-label extra-small text-muted mb-1">Aturan pengerjaan</label>
                        <div class="row g-2 extra-small">
                            <div class="col-md-4">
                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" id="ruleShuffleQ" checked>
                                    <label class="form-check-label" for="ruleShuffleQ">
                                        Acak urutan soal
                                    </label>
                                </div>
                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" id="ruleShuffleOpt" checked>
                                    <label class="form-check-label" for="ruleShuffleOpt">
                                        Acak opsi jawaban
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" id="ruleBackNav" checked>
                                    <label class="form-check-label" for="ruleBackNav">
                                        Boleh kembali ke soal sebelumnya
                                    </label>
                                </div>
                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" id="ruleLockAfterTime">
                                    <label class="form-check-label" for="ruleLockAfterTime">
                                        Kunci otomatis saat waktu habis
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" id="ruleShowScore" checked>
                                    <label class="form-check-label" for="ruleShowScore">
                                        Tampilkan skor langsung
                                    </label>
                                </div>
                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" id="ruleShowKey">
                                    <label class="form-check-label" for="ruleShowKey">
                                        Tampilkan kunci setelah ujian tutup
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label extra-small text-muted mb-1">Batas attempt / percobaan</label>
                        <input type="number" class="form-control form-control-sm" value="1" min="1">
                        <div class="form-text extra-small">
                            Remedial bisa diatur di jadwal ujian aktif.
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label extra-small text-muted mb-1">Catatan untuk admin / tutor</label>
                        <textarea class="form-control form-control-sm" rows="2"
                                  placeholder="Contoh: Ujian ini digunakan di akhir program batch Januari."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-sm">
                    <i class="bi bi-check2-circle me-1"></i> Simpan Modul Ujian (Demo)
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Preview Flow Ujian -->
<div class="modal fade" id="modalPreviewUjian" tabindex="-1" aria-labelledby="modalPreviewUjianLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title small fw-semibold mb-0" id="modalPreviewUjianLabel">
                    Preview Flow Ujian di Sisi Peserta (Demo)
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body small">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="border rounded-3 p-3 bg-light-subtle h-100">
                            <div class="fw-semibold extra-small mb-1">Halaman Aturan Ujian</div>
                            <ul class="extra-small mb-0">
                                <li>Nama ujian, durasi, dan KKM tampil jelas.</li>
                                <li>Peserta diminta memastikan koneksi stabil.</li>
                                <li>Begitu klik <strong>Mulai Ujian</strong>, timer langsung berjalan.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded-3 p-3 h-100">
                            <div class="fw-semibold extra-small mb-1">Tampilan Soal (contoh)</div>
                            <p class="extra-small text-muted mb-1">
                                Di versi final, layout soal di sini mengikuti pengaturan modul
                                (acak soal, boleh mundur, dll).
                            </p>
                            <div class="border rounded-3 p-2 mb-2 extra-small">
                                <div class="text-muted mb-1">Soal 1 dari 25</div>
                                <div class="mb-2">
                                    Bagian berikut ini yang termasuk perangkat input adalah...
                                </div>
                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="radio" disabled>
                                    <label class="form-check-label">A. Monitor</label>
                                </div>
                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="radio" disabled>
                                    <label class="form-check-label">B. Keyboard</label>
                                </div>
                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="radio" disabled>
                                    <label class="form-check-label">C. Speaker</label>
                                </div>
                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="radio" disabled>
                                    <label class="form-check-label">D. Proyektor</label>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between extra-small">
                                <span class="text-muted"><i class="bi bi-stopwatch me-1"></i>Sisa waktu: 00:58:23</span>
                                <span class="text-muted">Nomor: 1 2 3 4 5 ...</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
