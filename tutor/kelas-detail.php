<?php
require_once __DIR__ . '/../config.php';
require_login(['tutor']);

$user         = current_user();
$kodeKelas    = $_GET['kode'] ?? 'OM-01';
$title        = 'Kelola Kelas ' . $kodeKelas;
$currentPage  = 'kelas-saya';
$roleBasePath = '/tutor';
$baseUrl      = '/siakad';

ob_start();
?>
<div class="row mb-3">
    <div class="col-lg-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <h4 class="fw-semibold mb-0">Kelola Kelas: <?= htmlspecialchars($kodeKelas) ?></h4>
            <span class="badge bg-light text-muted extra-small">
                <i class="bi bi-sliders me-1"></i> Pengaturan Kelas
            </span>
        </div>
        <p class="text-muted small mb-0">
            Atur informasi kelas, materi & video per pertemuan, dan lihat rekap absen dari satu halaman.
            Semua contoh masih dummy.
        </p>
    </div>
    <div class="col-lg-4 mt-3 mt-lg-0 text-lg-end">
        <a href="<?= $baseUrl . $roleBasePath ?>/kelas-saya.php" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Kelas & Absen
        </a>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-primary-subtle text-primary">
                <i class="bi bi-people"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Peserta</div>
                <div class="fs-5 fw-semibold">20</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-success-subtle text-success">
                <i class="bi bi-journal-check"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Pertemuan</div>
                <div class="fs-5 fw-semibold">7 / 10</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-info-subtle text-info">
                <i class="bi bi-play-circle"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Materi upload</div>
                <div class="fs-5 fw-semibold">12</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-warning-subtle text-warning">
                <i class="bi bi-check2-square"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Rata2 hadir</div>
                <div class="fs-5 fw-semibold">82%</div>
            </div>
        </div>
    </div>
</div>

<!-- TAB NAV -->
<ul class="nav nav-pills mb-3 small" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="tab-info-kelas" data-bs-toggle="pill"
                data-bs-target="#panel-info-kelas" type="button" role="tab">
            <i class="bi bi-info-circle me-1"></i> Info Kelas
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab-materi" data-bs-toggle="pill"
                data-bs-target="#panel-materi" type="button" role="tab">
            <i class="bi bi-easel3 me-1"></i> Materi & Video
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab-absen" data-bs-toggle="pill"
                data-bs-target="#panel-absen" type="button" role="tab">
            <i class="bi bi-clipboard-check me-1"></i> Absen & Rekap
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab-pr" data-bs-toggle="pill"
                data-bs-target="#panel-pr" type="button" role="tab">
            <i class="bi bi-journal-text me-1"></i> PR & Penilaian
        </button>
    </li>
</ul>

<div class="tab-content">
    <!-- PANEL INFO KELAS -->
    <div class="tab-pane fade show active" id="panel-info-kelas" role="tabpanel">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body small">
                <h6 class="fw-semibold mb-2">Informasi Kelas</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label extra-small text-muted mb-1">Kode & Nama Kelas</label>
                            <input type="text" class="form-control form-control-sm"
                                   value="<?= htmlspecialchars($kodeKelas) ?> – Operator Komputer (Dummy)" disabled>
                        </div>
                        <div class="mb-2">
                            <label class="form-label extra-small text-muted mb-1">Jadwal</label>
                            <input type="text" class="form-control form-control-sm"
                                   value="Senin & Rabu, 08.00–10.00" disabled>
                        </div>
                        <div class="mb-2">
                            <label class="form-label extra-small text-muted mb-1">Ruang</label>
                            <input type="text" class="form-control form-control-sm"
                                   value="Lab 1" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label extra-small text-muted mb-1">Deskripsi singkat</label>
                            <textarea class="form-control form-control-sm" rows="3" disabled>
Pengenalan komputer dan Ms Office untuk pemula yang mau masuk kerja kantoran.
                            </textarea>
                        </div>
                        <div class="mb-2">
                            <label class="form-label extra-small text-muted mb-1">Catatan untuk peserta</label>
                            <textarea class="form-control form-control-sm" rows="2" disabled>
Bawa flashdisk sendiri dan pastikan datang tepat waktu setiap pertemuan.
                            </textarea>
                        </div>
                    </div>
                </div>
                <div class="alert alert-light border extra-small mb-0 mt-2">
                    <i class="bi bi-info-circle me-1"></i>
                    Di versi final, info ini bisa diedit oleh admin / tutor sesuai hak akses.
                </div>
            </div>
        </div>
    </div>

    <!-- PANEL MATERI & VIDEO -->
    <div class="tab-pane fade" id="panel-materi" role="tabpanel">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body small">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-semibold mb-0">Materi & Video per Pertemuan</h6>
                    <button class="btn btn-primary btn-sm" type="button" disabled>
                        <i class="bi bi-plus-lg me-1"></i> Tambah materi (Demo)
                    </button>
                </div>
                <p class="extra-small text-muted mb-2">
                    Materi di bawah ini akan tampil di halaman e-learning peserta, terurut per pertemuan.
                </p>

                <!-- pertemuan 1 -->
                <div class="border rounded-3 p-3 mb-2">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div>
                            <span class="badge bg-light text-muted extra-small me-1">Pertemuan 1</span>
                            <span class="fw-semibold small">Pengenalan Komputer & Sistem Operasi</span>
                        </div>
                        <span class="extra-small text-muted">Status: <strong>Terbit</strong></span>
                    </div>
                    <div class="extra-small text-muted mb-2">
                        Tujuan: peserta mengenal bagian komputer, OS, dan cara shutdown yang benar.
                    </div>
                    <ul class="extra-small mb-2 ps-3">
                        <li>Slide: Pengenalan Komputer (PDF)</li>
                        <li>Video: Tour Desktop & File Explorer (10 menit)</li>
                        <li>Latihan: Menyalakan & mematikan komputer dengan benar</li>
                    </ul>
                    <div class="d-flex justify-content-end gap-2 extra-small">
                        <button class="btn btn-outline-secondary btn-sm" type="button" disabled>
                            <i class="bi bi-eye me-1"></i> Preview sebagai peserta
                        </button>
                    </div>
                </div>

                <!-- pertemuan 2 -->
                <div class="border rounded-3 p-3 mb-2">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div>
                            <span class="badge bg-light text-muted extra-small me-1">Pertemuan 2</span>
                            <span class="fw-semibold small">Ms Word Dasar</span>
                        </div>
                        <span class="extra-small text-muted">Status: <strong>Terbit</strong></span>
                    </div>
                    <div class="extra-small text-muted mb-2">
                        Fokus: mengetik surat sederhana, format paragraf, dan penyimpanan file.
                    </div>
                    <ul class="extra-small mb-2 ps-3">
                        <li>Slide: Dasar Ms Word</li>
                        <li>Video: Mengetik & format paragraf (8 menit)</li>
                        <li>Latihan: Mengetik surat resmi 1 halaman</li>
                    </ul>
                    <div class="d-flex justify-content-end gap-2 extra-small">
                        <button class="btn btn-outline-secondary btn-sm" type="button" disabled>
                            <i class="bi bi-eye me-1"></i> Preview sebagai peserta
                        </button>
                    </div>
                </div>

                <!-- pertemuan 3 (draft) -->
                <div class="border rounded-3 p-3 mb-2 bg-light-subtle">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div>
                            <span class="badge bg-secondary-subtle text-secondary extra-small me-1">Pertemuan 3</span>
                            <span class="fw-semibold small">Ms Excel Dasar</span>
                        </div>
                        <span class="extra-small text-muted">Status: <strong>Draft</strong></span>
                    </div>
                    <div class="extra-small text-muted mb-2">
                        Materi ini belum terbit untuk peserta. Tutor bisa melengkapi video & file dulu.
                    </div>
                    <ul class="extra-small mb-2 ps-3">
                        <li>Belum ada file yang diupload</li>
                    </ul>
                    <div class="d-flex justify-content-end gap-2 extra-small">
                        <button class="btn btn-outline-secondary btn-sm" type="button" disabled>
                            <i class="bi bi-upload me-1"></i> Upload materi (Demo)
                        </button>
                    </div>
                </div>

                <div class="alert alert-light border extra-small mb-0">
                    <i class="bi bi-info-circle me-1"></i>
                    Di sisi peserta, tampilan akan mirip e-learning: pertemuan berurutan dengan tombol
                    <strong>Lanjutkan</strong> dan status selesai/belum.
                </div>
            </div>
        </div>
    </div>

    <!-- PANEL ABSEN & REKAP -->
    <div class="tab-pane fade" id="panel-absen" role="tabpanel">
        
        <!-- View 1: Rekap Absensi (Default) -->
        <div id="view-rekap-absen">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body small">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="fw-semibold mb-1">Rekap Absen Kelas</h6>
                            <p class="text-muted extra-small mb-0">Ringkasan kehadiran peserta per pertemuan.</p>
                        </div>
                        <button class="btn btn-outline-success btn-sm" onclick="alert('Fitur Export Excel akan mendownload file .xlsx (Demo)')">
                            <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light extra-small text-muted text-uppercase">
                                <tr>
                                    <th>Pertemuan</th>
                                    <th>Tanggal & Waktu</th>
                                    <th>Materi</th>
                                    <th class="text-center">Kehadiran</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-end" style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="extra-small">
                                <!-- Row 1 -->
                                <tr>
                                    <td>
                                        <div class="fw-bold text-primary">Pertemuan 1</div>
                                        <div class="text-muted">Minggu ke-1</div>
                                    </td>
                                    <td>
                                        <div>01 Nov 2025</div>
                                        <div class="text-muted">08.00 - 10.00</div>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;">Pengenalan Komputer & Sistem Operasi</div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <div class="progress w-100" style="height: 6px; width: 60px !important;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 90%"></div>
                                            </div>
                                            <span>18/20</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">Selesai</span>
                                    </td>
                                    <td class="text-end">
                                        <button class="btn btn-light btn-sm text-primary btn-detail-absen" data-meeting="1">
                                            <i class="bi bi-pencil-square me-1"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                                <!-- Row 2 -->
                                <tr>
                                    <td>
                                        <div class="fw-bold text-primary">Pertemuan 2</div>
                                        <div class="text-muted">Minggu ke-1</div>
                                    </td>
                                    <td>
                                        <div>03 Nov 2025</div>
                                        <div class="text-muted">08.00 - 10.00</div>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;">Ms Word Dasar</div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <div class="progress w-100" style="height: 6px; width: 60px !important;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 95%"></div>
                                            </div>
                                            <span>19/20</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">Selesai</span>
                                    </td>
                                    <td class="text-end">
                                        <button class="btn btn-light btn-sm text-primary btn-detail-absen" data-meeting="2">
                                            <i class="bi bi-pencil-square me-1"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                                <!-- Row 3 (Draft/Upcoming) -->
                                <tr class="bg-light-subtle">
                                    <td>
                                        <div class="fw-bold text-muted">Pertemuan 3</div>
                                        <div class="text-muted">Minggu ke-2</div>
                                    </td>
                                    <td>
                                        <div>05 Nov 2025</div>
                                        <div class="text-muted">08.00 - 10.00</div>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;">Ms Excel Dasar</div>
                                    </td>
                                    <td class="text-center">
                                        <div class="text-muted">-</div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Belum Mulai</span>
                                    </td>
                                    <td class="text-end">
                                        <button class="btn btn-light btn-sm text-muted" disabled>
                                            <i class="bi bi-lock me-1"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- View 2: Detail Absensi (Hidden by default) -->
        <div id="view-detail-absen" class="d-none">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <button class="btn btn-light btn-sm rounded-circle" id="btn-back-rekap">
                            <i class="bi bi-arrow-left"></i>
                        </button>
                        <div>
                            <h6 class="fw-semibold mb-0" id="detail-title">Detail Absensi - Pertemuan 1</h6>
                            <div class="extra-small text-muted">01 Nov 2025 • Pengenalan Komputer</div>
                        </div>
                    </div>
                    <div>
                        <span class="badge bg-success-subtle text-success me-2">
                            <i class="bi bi-check-circle-fill me-1"></i> 18 Hadir
                        </span>
                        <span class="badge bg-warning-subtle text-warning me-2">
                            <i class="bi bi-exclamation-circle-fill me-1"></i> 1 Izin
                        </span>
                        <span class="badge bg-danger-subtle text-danger">
                            <i class="bi bi-x-circle-fill me-1"></i> 1 Alfa
                        </span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light extra-small text-muted">
                                <tr>
                                    <th class="ps-4">Nama Peserta</th>
                                    <th>NIP</th>
                                    <th>Waktu Absen</th>
                                    <th>Status Kehadiran</th>
                                    <th>Keterangan</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="extra-small">
                                <!-- Sample Students -->
                                <?php 
                                $students = [
                                    ['name' => 'Aditya Pratama', 'nip' => '2025001', 'time' => '07:55', 'status' => 'Hadir', 'ket' => '-'],
                                    ['name' => 'Budi Santoso', 'nip' => '2025002', 'time' => '08:05', 'status' => 'Hadir', 'ket' => 'Telat 5 menit'],
                                    ['name' => 'Citra Kirana', 'nip' => '2025003', 'time' => '-', 'status' => 'Sakit', 'ket' => 'Surat Dokter via WA'],
                                    ['name' => 'Doni Irawan', 'nip' => '2025004', 'time' => '-', 'status' => 'Alfa', 'ket' => '-'],
                                    ['name' => 'Eka Putri', 'nip' => '2025005', 'time' => '07:58', 'status' => 'Hadir', 'ket' => '-'],
                                ];
                                foreach($students as $s): 
                                    $statusBadge = match($s['status']) {
                                        'Hadir' => 'bg-success-subtle text-success',
                                        'Sakit', 'Izin' => 'bg-warning-subtle text-warning',
                                        'Alfa' => 'bg-danger-subtle text-danger',
                                        default => 'bg-light text-muted'
                                    };
                                ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-sm rounded-circle bg-light d-flex align-items-center justify-content-center fw-bold text-muted" style="width: 24px; height: 24px; font-size: 10px;">
                                                <?= substr($s['name'], 0, 2) ?>
                                            </div>
                                            <span class="fw-medium"><?= $s['name'] ?></span>
                                        </div>
                                    </td>
                                    <td><?= $s['nip'] ?></td>
                                    <td><?= $s['time'] ?></td>
                                    <td>
                                        <span class="badge <?= $statusBadge ?>"><?= $s['status'] ?></span>
                                    </td>
                                    <td><?= $s['ket'] ?></td>
                                    <td class="text-end pe-4">
                                        <div class="dropdown">
                                            <button class="btn btn-light btn-sm py-0 px-2" type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end extra-small shadow border-0">
                                                <li><h6 class="dropdown-header">Ubah Status</h6></li>
                                                <li><a class="dropdown-item text-success" href="#"><i class="bi bi-check me-2"></i>Hadir</a></li>
                                                <li><a class="dropdown-item text-warning" href="#"><i class="bi bi-envelope me-2"></i>Izin/Sakit</a></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-x me-2"></i>Alfa</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white py-3 border-0 d-flex justify-content-end gap-2">
                    <button class="btn btn-light btn-sm text-muted">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Absen
                    </button>
                    <button class="btn btn-primary btn-sm">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const viewRekap = document.getElementById('view-rekap-absen');
            const viewDetail = document.getElementById('view-detail-absen');
            const btnBack = document.getElementById('btn-back-rekap');
            const detailButtons = document.querySelectorAll('.btn-detail-absen');
            const detailTitle = document.getElementById('detail-title');

            // Show Detail
            detailButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const meetingId = this.getAttribute('data-meeting');
                    detailTitle.textContent = 'Detail Absensi - Pertemuan ' + meetingId;
                    
                    viewRekap.classList.add('d-none');
                    viewDetail.classList.remove('d-none');
                });
            });

            // Back to Rekap
            btnBack.addEventListener('click', function() {
                viewDetail.classList.add('d-none');
                viewRekap.classList.remove('d-none');
            });
        });
        </script>

    </div>

    <!-- PANEL PR & PENILAIAN -->
    <div class="tab-pane fade" id="panel-pr" role="tabpanel">
        <div id="view-pr-list">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body small">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-semibold mb-0">PR & Penilaian Kelas</h6>
                        <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalBuatTugas">
                            <i class="bi bi-journal-plus me-1"></i> Buat PR (Demo)
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light extra-small text-muted">
                                <tr>
                                    <th>PR / Tugas</th>
                                    <th>Deadline</th>
                                    <th class="text-center">Submit</th>
                                    <th class="text-center">Status</th>
                                    <th style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="extra-small">
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-primary">PR 01 – Format Surat</div>
                                        <div class="text-muted">Upload surat resmi 1 halaman (Word/PDF)</div>
                                    </td>
                                    <td>10 Des 2025, 23:59</td>
                                    <td class="text-center">15 / 20</td>
                                    <td class="text-center">
                                        <span class="badge bg-warning-subtle text-warning">
                                            <i class="bi bi-hourglass-split me-1"></i>Menunggu nilai
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm w-100 btn-nilai-pr" data-id="1">
                                            <i class="bi bi-clipboard-check me-1"></i> Nilai PR
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-primary">Project Konten IG</div>
                                        <div class="text-muted">Feed + caption promosi (DM-02 style)</div>
                                    </td>
                                    <td>15 Des 2025, 23:59</td>
                                    <td class="text-center">18 / 18</td>
                                    <td class="text-center">
                                        <span class="badge bg-success-subtle text-success">
                                            <i class="bi bi-check-circle me-1"></i>Selesai
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-secondary btn-sm w-100 btn-nilai-pr" data-id="2">
                                            <i class="bi bi-eye me-1"></i> Lihat nilai
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p class="extra-small text-muted mt-2 mb-0">
                        Penilaian PR di sini akan ikut dihitung ke nilai akhir dan rapor.
                    </p>
                </div>
            </div>
        </div>

        <!-- View Detail Nilai PR (Hidden by default) -->
        <div id="view-pr-detail" class="d-none">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <button class="btn btn-light btn-sm rounded-circle" id="btn-back-pr">
                            <i class="bi bi-arrow-left"></i>
                        </button>
                        <div>
                            <h6 class="fw-semibold mb-0" id="pr-detail-title">Penilaian - PR 01</h6>
                            <div class="extra-small text-muted">Deadline: 10 Des 2025 • Upload File</div>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <span class="badge bg-primary-subtle text-primary">
                            <i class="bi bi-cloud-arrow-up-fill me-1"></i> 15 Submit
                        </span>
                        <span class="badge bg-warning-subtle text-warning">
                            <i class="bi bi-hourglass-split me-1"></i> 5 Belum
                        </span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light extra-small text-muted">
                                <tr>
                                    <th class="ps-4">Nama Peserta</th>
                                    <th>Waktu Upload</th>
                                    <th>File</th>
                                    <th style="width: 150px;">Nilai (0-100)</th>
                                    <th>Komentar</th>
                                    <th class="text-end pe-4">Status</th>
                                </tr>
                            </thead>
                            <tbody class="extra-small">
                                <!-- Sample Submission -->
                                <?php 
                                $submissions = [
                                    ['name' => 'Aditya Pratama', 'time' => '10 Des, 14:30', 'file' => 'surat_aditya.docx', 'score' => 85, 'status' => 'Dinilai'],
                                    ['name' => 'Budi Santoso', 'time' => '10 Des, 20:15', 'file' => 'tugas_budi_fix.pdf', 'score' => '', 'status' => 'Menunggu'],
                                    ['name' => 'Citra Kirana', 'time' => '-', 'file' => '-', 'score' => 0, 'status' => 'Belum'],
                                ];
                                foreach($submissions as $sub): 
                                ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-medium"><?= $sub['name'] ?></div>
                                    </td>
                                    <td><?= $sub['time'] ?></td>
                                    <td>
                                        <?php if($sub['file'] !== '-'): ?>
                                            <a href="#" class="text-decoration-none text-primary">
                                                <i class="bi bi-file-earmark-text me-1"></i> <?= $sub['file'] ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" value="<?= $sub['score'] ?>" placeholder="0" min="0" max="100">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" placeholder="Tulis komentar...">
                                    </td>
                                    <td class="text-end pe-4">
                                        <?php if($sub['status'] == 'Dinilai'): ?>
                                            <span class="badge bg-success-subtle text-success">Dinilai</span>
                                        <?php elseif($sub['status'] == 'Menunggu'): ?>
                                            <span class="badge bg-warning-subtle text-warning">Perlu Dinilai</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger-subtle text-danger">Belum Submit</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white py-3 border-0 d-flex justify-content-end gap-2">
                    <button class="btn btn-primary btn-sm">
                        <i class="bi bi-save me-1"></i> Simpan Penilaian
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Buat Tugas -->
        <div class="modal fade" id="modalBuatTugas" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="modal-title fw-semibold">Buat Tugas Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-3 pb-4">
                        <form>
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label small fw-medium">Judul Tugas</label>
                                        <input type="text" class="form-control" placeholder="Contoh: Latihan Excel Rumus VLOOKUP">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-medium">Deskripsi / Instruksi</label>
                                        <textarea class="form-control" rows="4" placeholder="Jelaskan detail tugas yang harus dikerjakan siswa..."></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-medium">Lampiran File (Opsional)</label>
                                        <input type="file" class="form-control form-control-sm">
                                        <div class="form-text extra-small">File pendukung seperti soal atau template.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 bg-light rounded-3">
                                        <div class="mb-3">
                                            <label class="form-label small fw-medium">Tenggat Waktu (Deadline)</label>
                                            <input type="datetime-local" class="form-control form-control-sm">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-medium">Tipe Pengumpulan</label>
                                            <select class="form-select form-select-sm">
                                                <option value="file">Upload File</option>
                                                <option value="text">Teks Online</option>
                                                <option value="link">Link Eksternal</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-medium">Nilai Maksimal</label>
                                            <input type="number" class="form-control form-control-sm" value="100">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary btn-sm">
                            <i class="bi bi-send me-1"></i> Terbitkan Tugas
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const viewPrList = document.getElementById('view-pr-list');
            const viewPrDetail = document.getElementById('view-pr-detail');
            const btnBackPr = document.getElementById('btn-back-pr');
            const btnNilaiPr = document.querySelectorAll('.btn-nilai-pr');
            const prDetailTitle = document.getElementById('pr-detail-title');

            // Show Detail
            btnNilaiPr.forEach(btn => {
                btn.addEventListener('click', function() {
                    // In real app, fetch data based on ID
                    const id = this.getAttribute('data-id');
                    prDetailTitle.textContent = id === '1' ? 'Penilaian - PR 01' : 'Penilaian - Project Konten IG';
                    
                    viewPrList.classList.add('d-none');
                    viewPrDetail.classList.remove('d-none');
                });
            });

            // Back to List
            btnBackPr.addEventListener('click', function() {
                viewPrDetail.classList.add('d-none');
                viewPrList.classList.remove('d-none');
            });
        });
        </script>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
