<?php
require_once __DIR__ . '/../config.php';
require_login(['tutor']);

$user         = current_user();
$title        = 'PR & Penilaian';
$currentPage  = 'pr-saya';
$roleBasePath = '/tutor';
$baseUrl      = '/siakad';

ob_start();
?>
<div class="row mb-3">
    <div class="col-lg-8">
        <h4 class="fw-semibold mb-1">PR & Penilaian</h4>
        <p class="text-muted small mb-0">
            Lihat dan nilai tugas (PR) yang dikumpulkan peserta untuk kelas yang Anda ampu.
            Data di bawah ini masih dummy.
        </p>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white border-0 shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-primary-subtle text-primary">
                <i class="bi bi-journal-check"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">PR aktif</div>
                <div class="fs-4 fw-semibold">3</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white border-0 shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-warning-subtle text-warning">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Belum dinilai</div>
                <div class="fs-4 fw-semibold">14</div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <div class="row g-2 align-items-end mb-3 small">
            <div class="col-md-4">
                <label class="small text-muted mb-1">Kelas</label>
                <select class="form-select form-select-sm">
                    <option value="">Semua kelas</option>
                    <option>OM-01</option>
                    <option>DM-02</option>
                    <option>BRS-01</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="small text-muted mb-1">Status</label>
                <select class="form-select form-select-sm">
                    <option value="">Semua</option>
                    <option>Belum dinilai</option>
                    <option>Sudah dinilai</option>
                    <option>Lewat deadline</option>
                </select>
            </div>
            <div class="col-md-4 text-md-end">
                <button class="btn btn-outline-secondary btn-sm w-100">
                    <i class="bi bi-arrow-clockwise me-1"></i> Refresh
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-sm align-middle mb-0">
                <thead class="table-light extra-small text-muted">
                    <tr>
                        <th>PR / Tugas</th>
                        <th>Kelas</th>
                        <th>Deadline</th>
                        <th class="text-center">Kumpul</th>
                        <th>Status</th>
                        <th style="width: 130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="small">
                    <tr>
                        <td>
                            <div class="fw-semibold">PR 01 – Format Surat</div>
                            <div class="extra-small text-muted">
                                OM-01 • Upload file Word dengan format surat resmi.
                            </div>
                        </td>
                        <td>OM-01</td>
                        <td>
                            <div class="extra-small">10 Des 2025, 23:59</div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-primary-subtle text-primary">14 / 20</span>
                        </td>
                        <td>
                            <span class="badge bg-warning-subtle text-warning extra-small">
                                <i class="bi bi-hourglass-split me-1"></i>Belum dinilai
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm w-100" disabled>
                                <i class="bi bi-pencil-square me-1"></i> Nilai (Demo)
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fw-semibold">Project Konten IG</div>
                            <div class="extra-small text-muted">
                                DM-02 • Buat 1 konten feed + caption promosi.
                            </div>
                        </td>
                        <td>DM-02</td>
                        <td>
                            <div class="extra-small">15 Des 2025, 23:59</div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-primary-subtle text-primary">8 / 18</span>
                        </td>
                        <td>
                            <span class="badge bg-success-subtle text-success extra-small">
                                <i class="bi bi-check-circle me-1"></i>Sebagian dinilai
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm w-100" disabled>
                                <i class="bi bi-pencil-square me-1"></i> Lanjut nilai
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fw-semibold">Tugas Latte Art</div>
                            <div class="extra-small text-muted">
                                BRS-01 • Upload foto latte art terbaik, min 3 variasi.
                            </div>
                        </td>
                        <td>BRS-01</td>
                        <td>
                            <div class="extra-small">07 Des 2025, 18:00</div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-primary-subtle text-primary">12 / 12</span>
                        </td>
                        <td>
                            <span class="badge bg-secondary-subtle text-secondary extra-small">
                                <i class="bi bi-clipboard-check me-1"></i>Selesai dinilai
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-outline-secondary btn-sm w-100" disabled>
                                <i class="bi bi-eye me-1"></i> Lihat hasil
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body small">
                <h6 class="fw-semibold mb-2">Catatan Untuk Tutor</h6>
                <p class="extra-small text-muted mb-1">
                    Di versi produksi, setiap tugas yang Anda nilai akan otomatis 
                    masuk ke komponen nilai raport (PR / tugas).
                </p>
                <p class="extra-small text-muted mb-0">
                    Biasanya tutor memberi skor (0–100) + catatan singkat. 
                    Peserta bisa melihat nilai dan feedback langsung dari dashboard peserta.
                </p>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
