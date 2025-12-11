<?php
require_once __DIR__ . '/../config.php';
require_login(['tutor']);

$user         = current_user();
$kodeModul    = $_GET['kode'] ?? 'MOD-OM-01';
$title        = 'Kelola Modul Kelas ' . $kodeModul;
$currentPage  = 'modul-kelas';
$roleBasePath = '/tutor';
$baseUrl      = '/siakad';

ob_start();
?>
<div class="row mb-3">
    <div class="col-lg-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <h4 class="fw-semibold mb-0">Kelola Modul: <?= htmlspecialchars($kodeModul) ?></h4>
            <span class="badge bg-light text-muted extra-small">
                <i class="bi bi-easel3 me-1"></i> Template Kelas
            </span>
        </div>
        <p class="text-muted small mb-0">
            Modul ini dipakai sebagai blueprint kelas: sesi, materi, dan video. Admin tinggal pilih modul ini
            saat membuka kelas aktif.
        </p>
    </div>
    <div class="col-lg-4 mt-3 mt-lg-0 text-lg-end">
        <a href="<?= $baseUrl . $roleBasePath ?>/modul-kelas.php" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke daftar modul
        </a>
    </div>
</div>

<!-- SUMMARY -->
<div class="row g-3 mb-3">
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-primary-subtle text-primary">
                <i class="bi bi-bar-chart-steps"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Jumlah sesi</div>
                <div class="fs-5 fw-semibold">10</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-info-subtle text-info">
                <i class="bi bi-clock-history"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Estimasi durasi</div>
                <div class="fs-5 fw-semibold">20 jam</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-success-subtle text-success">
                <i class="bi bi-play-circle"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Materi & video</div>
                <div class="fs-5 fw-semibold">15 item</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-warning-subtle text-warning">
                <i class="bi bi-collection"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Dipakai di kelas aktif</div>
                <div class="fs-5 fw-semibold">2</div>
            </div>
        </div>
    </div>
</div>

<!-- TAB NAV -->
<ul class="nav nav-pills mb-3 small" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="tab-info-modul" data-bs-toggle="pill"
                data-bs-target="#panel-info-modul" type="button" role="tab">
            <i class="bi bi-info-circle me-1"></i> Info Modul
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab-struktur" data-bs-toggle="pill"
                data-bs-target="#panel-struktur" type="button" role="tab">
            <i class="bi bi-bar-chart-steps me-1"></i> Struktur Sesi
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab-materi" data-bs-toggle="pill"
                data-bs-target="#panel-materi" type="button" role="tab">
            <i class="bi bi-play-circle me-1"></i> Materi & Video
        </button>
    </li>
</ul>

<div class="tab-content">
    <!-- PANEL INFO MODUL -->
    <div class="tab-pane fade show active" id="panel-info-modul" role="tabpanel">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body small">
                <div class="row g-3">
                    <div class="col-md-6">
                        <h6 class="fw-semibold mb-2">Identitas Modul</h6>
                        <div class="mb-2">
                            <label class="form-label extra-small text-muted mb-1">Kode & Nama Modul</label>
                            <input type="text" class="form-control form-control-sm"
                                   value="<?= htmlspecialchars($kodeModul) ?> – Operator Komputer Dasar (Dummy)" disabled>
                        </div>
                        <div class="mb-2">
                            <label class="form-label extra-small text-muted mb-1">Program / Kategori</label>
                            <input type="text" class="form-control form-control-sm"
                                   value="Office & Operator Komputer" disabled>
                        </div>
                        <div class="mb-2">
                            <label class="form-label extra-small text-muted mb-1">Level</label>
                            <input type="text" class="form-control form-control-sm"
                                   value="Basic" disabled>
                        </div>
                        <div class="mb-2">
                            <label class="form-label extra-small text-muted mb-1">Status Modul</label>
                            <input type="text" class="form-control form-control-sm"
                                   value="Siap dipakai" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-semibold mb-2">Gambaran Umum</h6>
                        <div class="mb-2">
                            <label class="form-label extra-small text-muted mb-1">Deskripsi singkat</label>
                            <textarea class="form-control form-control-sm" rows="3" disabled>
Modul dasar untuk peserta yang baru belajar komputer: kenalan perangkat, Ms Word, dan Ms Excel sederhana.
                            </textarea>
                        </div>
                        <div class="mb-2">
                            <label class="form-label extra-small text-muted mb-1">Tujuan akhir</label>
                            <textarea class="form-control form-control-sm" rows="3" disabled>
Peserta mampu mengoperasikan komputer dasar, membuat dokumen sederhana, dan memahami manajemen file untuk kerja kantoran.
                            </textarea>
                        </div>
                        <div class="mb-2">
                            <label class="form-label extra-small text-muted mb-1">Prasyarat</label>
                            <textarea class="form-control form-control-sm" rows="2" disabled>
Tidak ada. Cocok untuk pemula yang baru pertama kali belajar komputer.
                            </textarea>
                        </div>
                    </div>
                </div>
                <div class="alert alert-light border extra-small mb-0 mt-3">
                    <i class="bi bi-info-circle me-1"></i>
                    Di versi produksi, info modul bisa diedit oleh admin / tutor yang diberi hak akses.
                </div>
            </div>
        </div>
    </div>

    <!-- PANEL STRUKTUR SESI -->
    <div class="tab-pane fade" id="panel-struktur" role="tabpanel">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body small">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-semibold mb-0">Struktur Sesi Pembelajaran</h6>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                data-bs-toggle="modal" data-bs-target="#modalSessionSort">
                            <i class="bi bi-arrow-up-down me-1"></i> Atur urutan
                        </button>
                        <button class="btn btn-primary btn-sm" type="button"
                                data-bs-toggle="modal" data-bs-target="#modalSessionForm">
                            <i class="bi bi-plus-lg me-1"></i> Tambah sesi baru
                        </button>
                    </div>
                </div>
                <p class="extra-small text-muted mb-3">
                    Sesi di sini jadi <strong>rangka tulang</strong> modul. Di kelas aktif, admin bisa atur jadwal harinya,
                    dan tutor tetap boleh menambah sesi tambahan kalau diperlukan (remedial/pengayaan).
                </p>

                <div class="accordion accordion-flush" id="accordionSessions">
                    <!-- Sesi 1 -->
                    <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
                        <h2 class="accordion-header" id="heading1">
                            <button class="accordion-button collapsed py-2 small" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse1"
                                    aria-expanded="false" aria-controls="collapse1">
                                <div class="d-flex flex-column">
                                    <span class="extra-small text-muted">Sesi 1 • ± 2 jam • Teori + Demo</span>
                                    <span class="fw-semibold">Pengenalan Komputer & Perangkat</span>
                                </div>
                            </button>
                        </h2>
                        <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1"
                             data-bs-parent="#accordionSessions">
                            <div class="accordion-body small">
                                <div class="row extra-small mb-2">
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <i class="bi bi-bullseye me-1"></i>Fokus:
                                            mengenal bagian komputer, input/output, dan cara penggunaan dasar.
                                        </div>
                                        <div class="mb-1">
                                            <i class="bi bi-check2-square me-1"></i>Tugas:
                                            latihan langsung di kelas (tanpa PR).
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <i class="bi bi-diagram-3 me-1"></i>Tipe:
                                            <strong>Pembukaan & Fondasi</strong>
                                        </div>
                                        <div class="mb-1">
                                            <i class="bi bi-play-circle me-1"></i>Materi terhubung:
                                            <strong>3 item</strong>
                                        </div>
                                    </div>
                                </div>

                                <!-- Catatan Tutor -->
                                <div class="border rounded-3 p-2 bg-light-subtle extra-small mb-2">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-muted">
                                            <i class="bi bi-journal-text me-1"></i>Catatan Tutor
                                        </span>
                                    </div>
                                    <div class="text-muted">
                                        Awali dengan perkenalan dan cek kondisi peserta. Jangan terlalu cepat di bagian
                                        pengenalan perangkat, beri waktu mereka pegang dan mencoba.
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 extra-small">
                                    <button class="btn btn-outline-secondary btn-sm" type="button"
                                            data-bs-toggle="modal" data-bs-target="#modalSessionForm">
                                        <i class="bi bi-pencil-square me-1"></i> Edit sesi
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm" type="button"
                                            data-bs-toggle="modal" data-bs-target="#modalSessionNote">
                                        <i class="bi bi-journal-plus me-1"></i> Ubah catatan tutor
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sesi 2 -->
                    <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
                        <h2 class="accordion-header" id="heading2">
                            <button class="accordion-button collapsed py-2 small" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse2"
                                    aria-expanded="false" aria-controls="collapse2">
                                <div class="d-flex flex-column">
                                    <span class="extra-small text-muted">Sesi 2 • ± 2 jam • Praktik</span>
                                    <span class="fw-semibold">Ms Word Dasar – Mengetik Surat</span>
                                </div>
                            </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2"
                             data-bs-parent="#accordionSessions">
                            <div class="accordion-body small">
                                <div class="row extra-small mb-2">
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <i class="bi bi-bullseye me-1"></i>Fokus:
                                            format paragraf, align, spacing, penyimpanan dokumen.
                                        </div>
                                        <div class="mb-1">
                                            <i class="bi bi-check2-square me-1"></i>Tugas:
                                            PR 01 – surat resmi 1 halaman.
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <i class="bi bi-diagram-3 me-1"></i>Tipe:
                                            <strong>Praktik Terstruktur</strong>
                                        </div>
                                        <div class="mb-1">
                                            <i class="bi bi-play-circle me-1"></i>Materi terhubung:
                                            <strong>4 item</strong>
                                        </div>
                                    </div>
                                </div>

                                <!-- Catatan Tutor -->
                                <div class="border rounded-3 p-2 bg-light-subtle extra-small mb-2">
                                    <div class="text-muted">
                                        Minta peserta memberi nama file dengan format:
                                        <strong>NAMA_SURAT_ANGKATAN.docx</strong> supaya mudah dinilai.
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 extra-small">
                                    <button class="btn btn-outline-secondary btn-sm" type="button"
                                            data-bs-toggle="modal" data-bs-target="#modalSessionForm">
                                        <i class="bi bi-pencil-square me-1"></i> Edit sesi
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm" type="button"
                                            data-bs-toggle="modal" data-bs-target="#modalSessionNote">
                                        <i class="bi bi-journal-plus me-1"></i> Ubah catatan tutor
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sesi 3 (Draft) -->
                    <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
                        <h2 class="accordion-header" id="heading3">
                            <button class="accordion-button collapsed py-2 small bg-light-subtle" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse3"
                                    aria-expanded="false" aria-controls="collapse3">
                                <div class="d-flex flex-column">
                                    <span class="extra-small text-muted">
                                        Sesi 3 • ± 2 jam • Draft
                                    </span>
                                    <span class="fw-semibold">Ms Excel Dasar – Tabel & Rumus</span>
                                </div>
                                <span class="badge bg-secondary-subtle text-secondary extra-small ms-2">
                                    <i class="bi bi-pencil me-1"></i>Draft
                                </span>
                            </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3"
                             data-bs-parent="#accordionSessions">
                            <div class="accordion-body small">
                                <p class="extra-small text-muted mb-2">
                                    Fokus rencana: pengenalan sheet, sel, dan rumus sederhana (SUM, AVERAGE).
                                    Belum ada materi & video yang dihubungkan.
                                </p>
                                <div class="border rounded-3 p-2 bg-white extra-small mb-2">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Sesi ini bisa dijadikan sesi utama atau sesi tambahan (remedial) tergantung kebutuhan kelas.
                                </div>
                                <div class="d-flex justify-content-end gap-2 extra-small">
                                    <button class="btn btn-outline-secondary btn-sm" type="button"
                                            data-bs-toggle="modal" data-bs-target="#modalSessionForm">
                                        <i class="bi bi-pencil-square me-1"></i> Lengkapi sesi
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm" type="button"
                                            data-bs-toggle="modal" data-bs-target="#modalSessionNote">
                                        <i class="bi bi-journal-plus me-1"></i> Tambah catatan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-light border extra-small mb-0 mt-3">
                    <i class="bi bi-info-circle me-1"></i>
                    Tutor boleh menambah sesi tambahan kapan saja (misal sesi penguatan materi). Di backend,
                    sesi baru ini tetap tercatat sebagai bagian modul.
                </div>
            </div>
        </div>
    </div>

    <!-- PANEL MATERI & VIDEO -->
    <div class="tab-pane fade" id="panel-materi" role="tabpanel">
        <div class="row g-3 mb-3">
            <!-- Materi Umum -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body small d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-semibold mb-0">
                                <i class="bi bi-archive me-1"></i>Materi Umum Modul
                            </h6>
                            <button class="btn btn-outline-secondary btn-sm" type="button"
                                    data-bs-toggle="modal" data-bs-target="#modalMaterialGlobal">
                                <i class="bi bi-cloud-arrow-up me-1"></i> Upload
                            </button>
                        </div>
                        <p class="extra-small text-muted mb-2">
                            Materi yang berlaku untuk seluruh kelas dan semua sesi:
                            silabus, modul PDF, starter project, atau link folder bersama.
                        </p>

                        <div class="border rounded-3 p-3 bg-light-subtle extra-small mb-2">
                            <div class="mb-1 text-muted">
                                Tarik file ke sini atau gunakan tombol <strong>Upload</strong> di atas
                                (simulasi, belum tersimpan ke server).
                            </div>
                        </div>

                        <div class="flex-grow-1">
                            <ul class="extra-small mb-0 ps-3">
                                <li>
                                    <i class="bi bi-file-earmark-pdf me-1"></i>
                                    Silabus Program Operator Komputer.pdf
                                </li>
                                <li>
                                    <i class="bi bi-file-earmark-zip me-1"></i>
                                    Starter File Latihan Word & Excel.zip
                                </li>
                                <li>
                                    <i class="bi bi-link-45deg me-1"></i>
                                    Folder Google Drive – Materi Umum (read-only)
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Materi per Sesi -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body small">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-semibold mb-0">
                                <i class="bi bi-calendar3-week me-1"></i>Materi & Video per Sesi
                            </h6>
                            <button class="btn btn-primary btn-sm" type="button"
                                    data-bs-toggle="modal" data-bs-target="#modalMaterialSession">
                                <i class="bi bi-upload me-1"></i> Tambah materi per sesi
                            </button>
                        </div>
                        <p class="extra-small text-muted mb-3">
                            Materi di sini hanya muncul di sesi tertentu. Contoh: contoh dokumen khusus
                            di sesi ke-3, atau file tambahan saat remedial.
                        </p>

                        <!-- Sesi 1 -->
                        <div class="border rounded-3 p-3 mb-2">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div>
                                    <span class="badge bg-light text-muted extra-small me-1">Sesi 1</span>
                                    <span class="fw-semibold small">Pengenalan Komputer & Perangkat</span>
                                </div>
                                <span class="extra-small text-muted">3 materi • 2 video</span>
                            </div>

                            <div class="row g-2 extra-small mb-2">
                                <div class="col-md-6">
                                    <div class="fw-semibold mb-1">
                                        <i class="bi bi-file-earmark-text me-1"></i>Materi Download
                                    </div>
                                    <ul class="mb-0 ps-3">
                                        <li>Slide: Pengenalan Komputer (PDF)</li>
                                        <li>Worksheet: Nama Perangkat & Fungsi (DOCX)</li>
                                        <li>Latihan: Menyalakan & mematikan komputer (PDF)</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <div class="fw-semibold mb-1">
                                        <i class="bi bi-play-circle me-1"></i>Video Pembelajaran
                                    </div>
                                    <div class="border rounded-3 p-2 bg-light-subtle mb-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Tour Desktop & File Explorer</span>
                                            <button class="btn btn-outline-secondary btn-xs"
                                                    data-bs-toggle="modal" data-bs-target="#modalPreviewVideo" type="button">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <div class="extra-small text-muted">Durasi 10:24</div>
                                    </div>
                                    <div class="border rounded-3 p-2 bg-light-subtle">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Mengenal Perangkat Input/Output</span>
                                            <button class="btn btn-outline-secondary btn-xs"
                                                    data-bs-toggle="modal" data-bs-target="#modalPreviewVideo" type="button">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <div class="extra-small text-muted">Durasi 07:10</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Upload video sesi ini -->
                            <div class="border rounded-3 p-2 border-dashed bg-white extra-small mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="bi bi-camera-reels me-1"></i>Upload video tambahan untuk sesi ini
                                    </span>
                                    <button class="btn btn-outline-secondary btn-xs" type="button"
                                            data-bs-toggle="modal" data-bs-target="#modalVideoSession">
                                        <i class="bi bi-upload me-1"></i> Upload video
                                    </button>
                                </div>
                            </div>

                            <!-- Catatan Tutor -->
                            <div class="border rounded-3 p-2 bg-white extra-small">
                                <i class="bi bi-journal-text me-1"></i>
                                Catatan:
                                materi & video di sesi ini dipakai untuk membangun rasa nyaman peserta dengan komputer.
                            </div>
                        </div>

                        <!-- Sesi 2 -->
                        <div class="border rounded-3 p-3 mb-2">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div>
                                    <span class="badge bg-light text-muted extra-small me-1">Sesi 2</span>
                                    <span class="fw-semibold small">Ms Word Dasar – Mengetik Surat</span>
                                </div>
                                <span class="extra-small text-muted">4 materi • 1 video</span>
                            </div>

                            <div class="row g-2 extra-small mb-2">
                                <div class="col-md-6">
                                    <div class="fw-semibold mb-1">
                                        <i class="bi bi-file-earmark-text me-1"></i>Materi Download
                                    </div>
                                    <ul class="mb-0 ps-3">
                                        <li>Slide: Dasar Ms Word (PDF)</li>
                                        <li>Template: Surat Resmi (DOCX)</li>
                                        <li>Instruksi PR 01 (PDF)</li>
                                        <li>Checklist Penilaian (PDF, hanya tutor)</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <div class="fw-semibold mb-1">
                                        <i class="bi bi-play-circle me-1"></i>Video Pembelajaran
                                    </div>
                                    <div class="border rounded-3 p-2 bg-light-subtle">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Mengetik & Format Paragraf</span>
                                            <button class="btn btn-outline-secondary btn-xs"
                                                    data-bs-toggle="modal" data-bs-target="#modalPreviewVideo" type="button">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <div class="extra-small text-muted">Durasi 08:05</div>
                                    </div>
                                </div>
                            </div>

                            <div class="border rounded-3 p-2 bg-white extra-small">
                                <i class="bi bi-journal-text me-1"></i>
                                Catatan:
                                sarankan peserta mem-pause video dan ikut mengetik saat bagian praktik.
                            </div>
                        </div>

                        <!-- Sesi 3 (Belum ada materi) -->
                        <div class="border rounded-3 p-3 mb-0 bg-light-subtle">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div>
                                    <span class="badge bg-secondary-subtle text-secondary extra-small me-1">Sesi 3</span>
                                    <span class="fw-semibold small">Ms Excel Dasar – Tabel & Rumus</span>
                                </div>
                                <span class="extra-small text-warning">
                                    <i class="bi bi-exclamation-triangle me-1"></i>Belum ada materi
                                </span>
                            </div>
                            <p class="extra-small text-muted mb-2">
                                Tambahkan materi khusus untuk sesi ini, misalnya file latihan tabel penjualan
                                atau rekaman demo rumus dasar.
                            </p>
                            <button class="btn btn-outline-secondary btn-sm extra-small" type="button"
                                    data-bs-toggle="modal" data-bs-target="#modalMaterialSession">
                                <i class="bi bi-upload me-1"></i> Tambah materi untuk sesi 3
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- end tab materi -->
</div>

<!-- ================= MODALS ================= -->

<!-- Modal: Form Sesi (Tambah / Edit) -->
<div class="modal fade" id="modalSessionForm" tabindex="-1" aria-labelledby="modalSessionFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header border-0 pb-0">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge bg-primary-subtle text-primary extra-small">
                            <i class="bi bi-bar-chart-steps me-1"></i> Sesi Modul
                        </span>
                        <span class="badge bg-light text-muted extra-small">
                            Tambah / Edit struktur sesi
                        </span>
                    </div>
                    <h6 class="modal-title small fw-semibold mb-0" id="modalSessionFormLabel">
                        Pengaturan Sesi Pembelajaran
                    </h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body small pt-3">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label extra-small text-muted mb-1">Nomor Sesi</label>
                        <input type="number" class="form-control form-control-sm" value="1" min="1">
                        <div class="form-text extra-small">
                            Bisa disesuaikan, sistem akan mengurutkan otomatis.
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label extra-small text-muted mb-1">Judul Sesi</label>
                        <input type="text" class="form-control form-control-sm"
                               placeholder="Contoh: Ms Word Dasar – Mengetik Surat">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label extra-small text-muted mb-1">Tipe Sesi</label>
                        <select class="form-select form-select-sm">
                            <option>Pembukaan & Fondasi</option>
                            <option>Teori</option>
                            <option>Praktik Terstruktur</option>
                            <option>Proyek / Study Case</option>
                            <option>Remedial / Penguatan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label extra-small text-muted mb-1">Durasi Estimasi</label>
                        <div class="input-group input-group-sm">
                            <input type="number" class="form-control form-control-sm" value="2">
                            <span class="input-group-text">jam</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label extra-small text-muted mb-1">Fokus / Tujuan sesi</label>
                        <textarea class="form-control form-control-sm" rows="2"
                                  placeholder="Contoh: Peserta mampu mengetik surat resmi 1 halaman dengan format rapi."></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label extra-small text-muted mb-1">Tugas / Aktivitas utama</label>
                        <textarea class="form-control form-control-sm" rows="2"
                                  placeholder="Contoh: PR 01 – Mengetik surat resmi, dikumpulkan dalam format PDF."></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label extra-small text-muted mb-1">Catatan Tutor (opsional)</label>
                        <textarea class="form-control form-control-sm" rows="2"
                                  placeholder="Catatan pribadi tutor untuk sesi ini, tidak terlihat peserta."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-sm">
                    <i class="bi bi-check2-circle me-1"></i> Simpan (Demo)
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Atur Urutan Sesi -->
<div class="modal fade" id="modalSessionSort" tabindex="-1" aria-labelledby="modalSessionSortLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title small fw-semibold" id="modalSessionSortLabel">
                    Atur Urutan Sesi (Demo)
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body small">
                <p class="extra-small text-muted mb-2">
                    Di versi final, sesi bisa di-drag & drop untuk mengubah urutan. Saat ini hanya simulasi.
                </p>
                <ul class="list-group list-group-flush extra-small">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Sesi 1 – Pengenalan Komputer & Perangkat</span>
                        <i class="bi bi-grip-vertical text-muted"></i>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Sesi 2 – Ms Word Dasar – Mengetik Surat</span>
                        <i class="bi bi-grip-vertical text-muted"></i>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Sesi 3 – Ms Excel Dasar – Tabel & Rumus</span>
                        <i class="bi bi-grip-vertical text-muted"></i>
                    </li>
                </ul>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary btn-sm">
                    <i class="bi bi-check2-circle me-1"></i> Simpan (Demo)
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Catatan Tutor -->
<div class="modal fade" id="modalSessionNote" tabindex="-1" aria-labelledby="modalSessionNoteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title small fw-semibold" id="modalSessionNoteLabel">
                    Catatan Tutor untuk Sesi
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body small">
                <label class="form-label extra-small text-muted mb-1">Catatan (hanya tutor)</label>
                <textarea class="form-control form-control-sm" rows="4"
                          placeholder="Contoh: perhatikan peserta yang masih kaku mengetik, sisihkan waktu 10 menit untuk cek satu-satu."></textarea>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-sm">
                    <i class="bi bi-check2-circle me-1"></i> Simpan (Demo)
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Materi Umum -->
<div class="modal fade" id="modalMaterialGlobal" tabindex="-1" aria-labelledby="modalMaterialGlobalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title small fw-semibold" id="modalMaterialGlobalLabel">
                    Upload Materi Umum Modul
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body small">
                <p class="extra-small text-muted">
                    Materi umum akan terlihat di semua kelas yang memakai modul ini. Cocok untuk silabus,
                    modul PDF utama, atau folder project.
                </p>
                <div class="border rounded-3 p-4 text-center bg-light-subtle mb-3">
                    <div class="mb-2">
                        <i class="bi bi-cloud-arrow-up" style="font-size: 2rem;"></i>
                    </div>
                    <div class="extra-small text-muted mb-2">
                        Tarik & letakkan file di sini atau klik tombol di bawah
                    </div>
                    <button type="button" class="btn btn-outline-secondary btn-sm">
                        Pilih File (Demo)
                    </button>
                </div>
                <label class="form-label extra-small text-muted mb-1">Catatan (opsional)</label>
                <textarea class="form-control form-control-sm" rows="2"
                          placeholder="Contoh: Silabus ini dipakai untuk semua gelombang tahun 2025."></textarea>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-sm">
                    <i class="bi bi-check2-circle me-1"></i> Simpan (Demo)
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Materi per Sesi -->
<div class="modal fade" id="modalMaterialSession" tabindex="-1" aria-labelledby="modalMaterialSessionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title small fw-semibold" id="modalMaterialSessionLabel">
                    Tambah Materi untuk Sesi Tertentu
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body small">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label extra-small text-muted mb-1">Pilih Sesi</label>
                        <select class="form-select form-select-sm">
                            <option>Sesi 1 – Pengenalan Komputer</option>
                            <option>Sesi 2 – Ms Word Dasar</option>
                            <option>Sesi 3 – Ms Excel Dasar</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label extra-small text-muted mb-1">Judul Materi</label>
                        <input type="text" class="form-control form-control-sm"
                               placeholder="Contoh: Contoh Surat Pengantar Resmi (DOCX)">
                    </div>
                    <div class="col-12">
                        <label class="form-label extra-small text-muted mb-1">Jenis Materi</label>
                        <div class="d-flex flex-wrap gap-2 extra-small">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_materi" id="materiFile" checked>
                                <label class="form-check-label" for="materiFile">File Download</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_materi" id="materiLink">
                                <label class="form-check-label" for="materiLink">Link (YouTube, Drive, dll.)</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label extra-small text-muted mb-1">File / Link</label>
                        <input type="text" class="form-control form-control-sm"
                               placeholder="Untuk demo, cukup isi nama file atau URL saja">
                    </div>
                    <div class="col-12">
                        <label class="form-label extra-small text-muted mb-1">Catatan untuk peserta (opsional)</label>
                        <textarea class="form-control form-control-sm" rows="2"
                                  placeholder="Contoh: Baca materi ini sebelum pertemuan berikutnya."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-sm">
                    <i class="bi bi-check2-circle me-1"></i> Simpan (Demo)
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Upload Video Sesi -->
<div class="modal fade" id="modalVideoSession" tabindex="-1" aria-labelledby="modalVideoSessionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title small fw-semibold" id="modalVideoSessionLabel">
                    Upload Video Pembelajaran Sesi
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body small">
                <label class="form-label extra-small text-muted mb-1">Pilih Sesi</label>
                <select class="form-select form-select-sm mb-2">
                    <option>Sesi 1 – Pengenalan Komputer</option>
                    <option>Sesi 2 – Ms Word Dasar</option>
                    <option>Sesi 3 – Ms Excel Dasar</option>
                </select>
                <div class="border rounded-3 p-3 text-center bg-light-subtle mb-2">
                    <div class="mb-2">
                        <i class="bi bi-camera-reels" style="font-size: 1.6rem;"></i>
                    </div>
                    <div class="extra-small text-muted mb-2">
                        Pilih file video (simulasi, belum benar-benar upload)
                    </div>
                    <button type="button" class="btn btn-outline-secondary btn-sm">
                        Pilih Video (Demo)
                    </button>
                </div>
                <label class="form-label extra-small text-muted mb-1">Deskripsi singkat</label>
                <textarea class="form-control form-control-sm" rows="2"
                          placeholder="Contoh: Demo mengatur paragraf & layout surat."></textarea>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-sm">
                    <i class="bi bi-check2-circle me-1"></i> Simpan (Demo)
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Preview Video (Demo) -->
<div class="modal fade" id="modalPreviewVideo" tabindex="-1" aria-labelledby="modalPreviewVideoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title small fw-semibold" id="modalPreviewVideoLabel">
                    Preview Video Pembelajaran (Demo)
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body small">
                <div class="border rounded-3 p-4 text-center bg-light-subtle mb-2">
                    <div class="mb-2">
                        <i class="bi bi-play-circle" style="font-size: 2.5rem;"></i>
                    </div>
                    <div class="extra-small text-muted">
                        Di versi final, player video akan muncul di sini.
                        Untuk sekarang hanya tampilan simulasi.
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
