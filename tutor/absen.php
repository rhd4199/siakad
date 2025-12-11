<?php
require_once __DIR__ . '/../config.php';
require_login(['tutor']);

$user         = current_user();
$title        = 'Buka Absen';
$currentPage  = 'absen';
$roleBasePath = '/tutor';
$baseUrl      = '/siakad';

ob_start();
?>
<div class="row mb-3">
    <div class="col-lg-8">
        <h4 class="fw-semibold mb-1">Buka Absen</h4>
        <p class="text-muted small mb-0">
            Dari halaman ini, Anda bisa membuka absen untuk kelas yang sedang berjalan.
            Prototype: tombol belum benar-benar menyimpan data.
        </p>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-12 col-md-4">
        <div class="p-3 rounded-3 bg-white border-0 shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-success-subtle text-success">
                <i class="bi bi-dot"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Sesi hari ini</div>
                <div class="fs-4 fw-semibold">3</div>
                <div class="extra-small text-muted">1 sedang berjalan</div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <div class="row g-2 align-items-end mb-3 small">
            <div class="col-md-4">
                <label class="small text-muted mb-1">Tanggal</label>
                <input type="date" class="form-control form-control-sm">
            </div>
            <div class="col-md-4">
                <label class="small text-muted mb-1">Kelas</label>
                <select class="form-select form-select-sm">
                    <option value="">Semua</option>
                    <option>OM-01</option>
                    <option>DM-02</option>
                    <option>BRS-01</option>
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
                        <th>Jam</th>
                        <th>Kelas</th>
                        <th>Program</th>
                        <th class="text-center">Peserta</th>
                        <th>Status Absen</th>
                        <th style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="small">
                    <tr>
                        <td>08.00 – 10.00</td>
                        <td>OM-01</td>
                        <td>Operator Komputer</td>
                        <td class="text-center">
                            <span class="badge bg-primary-subtle text-primary">20</span>
                        </td>
                        <td>
                            <span class="badge bg-success-subtle text-success extra-small">
                                <i class="bi bi-check2-square me-1"></i>Absen sudah dibuka
                            </span>
                            <div class="extra-small text-muted">Hadir: 16 • Izin: 2</div>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-secondary btn-sm" disabled>
                                    <i class="bi bi-eye"></i> Detail
                                </button>
                                <button class="btn btn-outline-secondary btn-sm" disabled>
                                    <i class="bi bi-printer"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>10.15 – 12.00</td>
                        <td>DM-02</td>
                        <td>Digital Marketing</td>
                        <td class="text-center">
                            <span class="badge bg-primary-subtle text-primary">18</span>
                        </td>
                        <td>
                            <span class="badge bg-warning-subtle text-warning extra-small">
                                <i class="bi bi-clock-history me-1"></i>Belum dibuka
                            </span>
                            <div class="extra-small text-muted">Disarankan buka 5 menit sebelum mulai</div>
                        </td>
                        <td>
                            <button class="btn btn-success btn-sm w-100" disabled>
                                <i class="bi bi-unlock me-1"></i> Buka Absen (Demo)
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>13.00 – 15.00</td>
                        <td>BRS-01</td>
                        <td>Barista Dasar</td>
                        <td class="text-center">
                            <span class="badge bg-primary-subtle text-primary">12</span>
                        </td>
                        <td>
                            <span class="badge bg-secondary-subtle text-secondary extra-small">
                                <i class="bi bi-clipboard-check me-1"></i>Selesai
                            </span>
                            <div class="extra-small text-muted">Hadir: 11 • Alfa: 1</div>
                        </td>
                        <td>
                            <button class="btn btn-outline-secondary btn-sm w-100" disabled>
                                <i class="bi bi-eye me-1"></i> Lihat Rekap
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
                <h6 class="fw-semibold mb-2">Cara Kerja Absen (Prototype)</h6>
                <ol class="extra-small mb-2">
                    <li>Tutor klik <strong>Buka Absen</strong> untuk sesi yang berjalan.</li>
                    <li>Sistem menampilkan PIN / kode absen di layar tutor.</li>
                    <li>Peserta login dari dashboard peserta, pilih kelas, klik <strong>Hadir</strong> dan isi PIN.</li>
                    <li>Setelah jam selesai, tutor bisa menutup absen dan cek rekap.</li>
                </ol>
                <p class="extra-small text-muted mb-0">
                    Di versi produksi, semua proses ini akan tercatat dan terhubung ke raport.
                </p>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
