<?php
require_once __DIR__ . '/../config.php';
require_login(['tutor']);

$user         = current_user();
$title        = 'Ujian Aktif';
$currentPage  = 'ujian-aktif';
$roleBasePath = '/tutor';
$baseUrl      = '/siakad';

ob_start();
?>
<div class="row mb-3">
    <div class="col-lg-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <h4 class="fw-semibold mb-0">Ujian Aktif</h4>
            <span class="badge rounded-pill bg-danger-subtle text-danger extra-small">
                <i class="bi bi-record-circle me-1"></i> Live Proctoring
            </span>
        </div>
        <p class="text-muted small mb-0">
            Pantau pelaksanaan ujian yang sedang berlangsung secara real-time.
        </p>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-12">
        <div class="alert alert-info border-0 shadow-sm d-flex align-items-center" role="alert">
            <i class="bi bi-info-circle-fill me-2 fs-4"></i>
            <div>
                <strong>Mode Pengawas Aktif</strong>
                <div class="small">Pastikan koneksi internet stabil untuk memantau aktivitas peserta ujian.</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Exam Control & Monitoring Section -->
    <div class="col-lg-8">
        
        <!-- Exam Tabs -->
        <ul class="nav nav-pills mb-3" id="examTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active d-flex align-items-center gap-2" id="exam1-tab" data-bs-toggle="pill" data-bs-target="#exam1" type="button" role="tab" onclick="updateExamInfo(1)">
                    <span class="spinner-grow spinner-grow-sm text-danger" role="status" aria-hidden="true"></span>
                    UTS Operator Komputer
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link d-flex align-items-center gap-2" id="exam2-tab" data-bs-toggle="pill" data-bs-target="#exam2" type="button" role="tab" onclick="updateExamInfo(2)">
                    <span class="spinner-grow spinner-grow-sm text-danger" role="status" aria-hidden="true"></span>
                    Quiz Digital Marketing
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link d-flex align-items-center gap-2" id="exam3-tab" data-bs-toggle="pill" data-bs-target="#exam3" type="button" role="tab" onclick="updateExamInfo(3)">
                    <i class="bi bi-pause-circle text-warning"></i>
                    Evaluasi Barista
                </button>
            </li>
        </ul>

        <div class="tab-content" id="examTabContent">
            <!-- EXAM 1: UTS Operator Komputer (LIVE) -->
            <div class="tab-pane fade show active" id="exam1" role="tabpanel">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-danger-subtle text-danger border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                <h6 class="mb-0 fw-bold">Ujian Tengah Semester - Operator Komputer</h6>
                            </div>
                            <div>
                                <span class="badge bg-danger">LIVE</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Exam 1 Content (Existing Logic) -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="small text-muted mb-1">Waktu Tersisa</div>
                                <div class="fs-4 fw-mono text-danger">00:45:12</div>
                            </div>
                            <div class="col-md-4">
                                <div class="small text-muted mb-1">Peserta Login</div>
                                <div class="fs-4 fw-semibold">18/20</div>
                            </div>
                            <div class="col-md-4">
                                <div class="small text-muted mb-1">Selesai Mengerjakan</div>
                                <div class="fs-4 fw-semibold">2</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-semibold mb-0">Progress Peserta Real-time</h6>
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari peserta...">
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-hover table-sm align-middle mb-0">
                                <thead class="table-light extra-small text-muted">
                                    <tr>
                                        <th>Nama Peserta</th>
                                        <th>Progress Pengerjaan</th>
                                        <th>Status Koneksi</th>
                                        <th class="text-end">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="cursor-pointer" onclick="showStudentDetail('Andi Darmawan', 85, 'Online')">
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="avatar-sm bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold" style="width: 24px; height: 24px; font-size: 10px;">AD</div>
                                                <div>
                                                    <span class="small fw-medium d-block">Andi Darmawan</span>
                                                    <span class="extra-small text-muted">NIS: 2023001</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 35%;">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress flex-grow-1" style="height: 6px;">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 85%"></div>
                                                </div>
                                                <span class="extra-small fw-medium">42/50</span>
                                            </div>
                                            <div class="extra-small text-muted mt-1">Terakhir: Soal No. 42 (10 detik lalu)</div>
                                        </td>
                                        <td><span class="badge bg-success-subtle text-success extra-small"><i class="bi bi-wifi me-1"></i>Online</span></td>
                                        <td class="text-end">
                                            <button class="btn btn-light btn-sm text-primary"><i class="bi bi-chevron-right"></i></button>
                                        </td>
                                    </tr>
                                    <tr class="cursor-pointer" onclick="showStudentDetail('Budi Santoso', 40, 'Idle')">
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="avatar-sm bg-warning-subtle rounded-circle d-flex align-items-center justify-content-center text-warning fw-bold" style="width: 24px; height: 24px; font-size: 10px;">BS</div>
                                                    <div>
                                                    <span class="small fw-medium d-block">Budi Santoso</span>
                                                    <span class="extra-small text-muted">NIS: 2023002</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress flex-grow-1" style="height: 6px;">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 40%"></div>
                                                </div>
                                                <span class="extra-small fw-medium">20/50</span>
                                            </div>
                                                <div class="extra-small text-muted mt-1">Terakhir: Soal No. 20 (2 menit lalu)</div>
                                        </td>
                                        <td><span class="badge bg-warning-subtle text-warning extra-small"><i class="bi bi-exclamation-circle me-1"></i>Idle 2m</span></td>
                                        <td class="text-end">
                                            <button class="btn btn-light btn-sm text-primary"><i class="bi bi-chevron-right"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top-0 pt-0 text-center">
                        <button class="btn btn-link btn-sm text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalSemuaPeserta">
                            Lihat Semua 20 Peserta
                        </button>
                    </div>
                </div>
            </div>

            <!-- EXAM 2: Quiz Digital Marketing (LIVE) -->
            <div class="tab-pane fade" id="exam2" role="tabpanel">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-danger-subtle text-danger border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                <h6 class="mb-0 fw-bold">Quiz Digital Marketing - Batch 2</h6>
                            </div>
                            <div>
                                <span class="badge bg-danger">LIVE</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="small text-muted mb-1">Waktu Tersisa</div>
                                <div class="fs-4 fw-mono text-danger">00:20:05</div>
                            </div>
                            <div class="col-md-4">
                                <div class="small text-muted mb-1">Peserta Login</div>
                                <div class="fs-4 fw-semibold">15/15</div>
                            </div>
                            <div class="col-md-4">
                                <div class="small text-muted mb-1">Selesai Mengerjakan</div>
                                <div class="fs-4 fw-semibold">0</div>
                            </div>
                        </div>
                        <div class="alert alert-warning border-0 d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div>
                                <strong>Koneksi Tidak Stabil</strong>
                                <div class="small">Terdeteksi 3 peserta mengalami masalah koneksi dalam 5 menit terakhir.</div>
                            </div>
                        </div>
                        <!-- Dummy table for Exam 2 -->
                        <div class="table-responsive mt-3">
                            <table class="table table-hover table-sm align-middle mb-0">
                                <thead class="table-light extra-small text-muted">
                                    <tr>
                                        <th>Nama Peserta</th>
                                        <th>Progress Pengerjaan</th>
                                        <th>Status Koneksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Doni Pratama</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress flex-grow-1" style="height: 6px;">
                                                    <div class="progress-bar bg-success" style="width: 20%"></div>
                                                </div>
                                                <span class="extra-small fw-medium">2/10</span>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-success-subtle text-success extra-small">Online</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- EXAM 3: Evaluasi Barista (PREPARATION) -->
            <div class="tab-pane fade" id="exam3" role="tabpanel">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1 fw-bold">Evaluasi Barista - Praktek Dasar</h6>
                                <p class="mb-0 text-muted extra-small">Menunggu instruksi mulai</p>
                            </div>
                            <span class="badge bg-warning-subtle text-warning">Menunggu Dimulai</span>
                        </div>
                    </div>
                    <div class="card-body">
                         <div class="alert alert-light border d-flex align-items-center mb-4" role="alert">
                            <i class="bi bi-exclamation-circle text-primary fs-4 me-3"></i>
                            <div>
                                <div class="fw-medium">Token Ujian: <span class="fw-bold font-monospace user-select-all">BRS-99X</span></div>
                                <div class="small text-muted">Bagikan token ini kepada peserta.</div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-6 col-md-4 text-center border-end">
                                <div class="display-6 fw-bold text-primary">12</div>
                                <div class="small text-muted">Total Peserta</div>
                            </div>
                            <div class="col-6 col-md-4 text-center border-end">
                                <div class="display-6 fw-bold text-success">10</div>
                                <div class="small text-muted">Peserta Siap</div>
                            </div>
                            <div class="col-12 col-md-4 text-center mt-3 mt-md-0">
                                <div class="display-6 fw-bold text-secondary">2</div>
                                <div class="small text-muted">Belum Masuk</div>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#modalMulaiUjian">
                                <i class="bi bi-play-circle-fill me-2"></i> Mulai Ujian Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hidden Original Cards for Reference (Removed to clean up) -->
        
    </div>

    <!-- Right Column: Info & Upcoming -->
    <div class="col-lg-4">
        
        <!-- Informasi Ujian (Dynamic based on Tab) -->
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0 fw-semibold">Informasi Ujian</h6>
            </div>
            <div class="card-body pt-0">
                <table class="table table-sm table-borderless small mb-0" id="examInfoTable">
                    <tr>
                        <td class="text-muted ps-0" style="width: 100px;">Mata Kuliah</td>
                        <td class="fw-medium" id="infoMapel">Operator Komputer</td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-0">Kelas</td>
                        <td class="fw-medium" id="infoKelas">OK-2024-A</td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-0">Durasi</td>
                        <td class="fw-medium" id="infoDurasi">60 Menit</td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-0">Jumlah Soal</td>
                        <td class="fw-medium" id="infoSoal">50 Soal (PG)</td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-0">Jadwal</td>
                        <td class="fw-medium" id="infoJadwal">11 Des 2025, 08:00</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0 fw-semibold">Segera Dimulai</h6>
            </div>
            <div class="list-group list-group-flush">
                <div class="list-group-item px-3 py-3">
                    <div class="d-flex w-100 justify-content-between mb-1">
                        <h6 class="mb-1 small fw-bold">Ujian Susulan</h6>
                        <small class="text-muted">Besok</small>
                    </div>
                    <p class="mb-1 extra-small text-muted">Kelas Khusus • 60 Menit</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Student Detail Modal -->
<div class="modal fade" id="modalDetailSiswa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-semibold">Detail Progress Peserta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-3 pb-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="avatar-md bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold fs-4" style="width: 48px; height: 48px;">AD</div>
                    <div>
                        <h5 class="mb-1 fw-bold" id="detailNama">Andi Darmawan</h5>
                        <div class="d-flex align-items-center gap-2 text-muted small">
                            <span>NIS: 2023001</span> • 
                            <span class="badge bg-success-subtle text-success extra-small" id="detailStatus">Online</span>
                        </div>
                    </div>
                    <div class="ms-auto text-end">
                        <div class="small text-muted">Sisa Waktu</div>
                        <div class="fw-bold font-monospace">00:45:12</div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded-3 text-center">
                            <div class="small text-muted mb-1">Progress</div>
                            <div class="h4 fw-bold mb-0 text-primary" id="detailProgressText">42/50</div>
                            <div class="progress mt-2" style="height: 4px;">
                                <div class="progress-bar bg-primary" id="detailProgressBar" style="width: 85%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded-3 text-center">
                            <div class="small text-muted mb-1">Jawaban Benar (Sementara)</div>
                            <div class="h4 fw-bold mb-0 text-success">38</div>
                            <div class="extra-small text-muted">Estimasi Nilai: 76</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded-3 text-center">
                            <div class="small text-muted mb-1">Aktivitas Terakhir</div>
                            <div class="h4 fw-bold mb-0 text-secondary">10s</div>
                            <div class="extra-small text-muted">Menjawab Soal No. 42</div>
                        </div>
                    </div>
                </div>

                <h6 class="fw-semibold mb-3">Peta Jawaban</h6>
                <div class="d-flex flex-wrap gap-2 mb-4" id="questionMap">
                    <!-- Generated by JS -->
                </div>

                <h6 class="fw-semibold mb-2">Log Aktivitas</h6>
                <div class="list-group list-group-flush border rounded-3 overflow-hidden" style="max-height: 200px; overflow-y: auto;">
                    <div class="list-group-item extra-small py-2 text-muted">
                        <span class="font-monospace me-2">10:45:12</span> Menjawab soal nomor 42 (A)
                    </div>
                    <div class="list-group-item extra-small py-2 text-muted">
                        <span class="font-monospace me-2">10:44:30</span> Beralih ke soal nomor 42
                    </div>
                    <div class="list-group-item extra-small py-2 text-muted">
                        <span class="font-monospace me-2">10:44:15</span> Menjawab soal nomor 41 (C)
                    </div>
                    <div class="list-group-item extra-small py-2 text-muted">
                        <span class="font-monospace me-2">10:40:00</span> <span class="text-danger fw-medium">Koneksi terputus (3 detik)</span>
                    </div>
                    <div class="list-group-item extra-small py-2 text-muted">
                        <span class="font-monospace me-2">10:00:00</span> Login berhasil
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-warning btn-sm">
                    <i class="bi bi-exclamation-triangle me-1"></i> Peringatan
                </button>
                <button type="button" class="btn btn-danger btn-sm">
                    <i class="bi bi-stop-circle me-1"></i> Hentikan Ujian
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Mulai Ujian -->
<div class="modal fade" id="modalMulaiUjian" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-body p-4 text-center">
                <div class="mb-3 text-primary">
                    <i class="bi bi-play-circle-fill display-1"></i>
                </div>
                <h5 class="fw-bold mb-3">Mulai Ujian Sekarang?</h5>
                <p class="text-muted mb-4">
                    Tindakan ini akan membuka akses soal ke seluruh peserta.<br>
                    Waktu ujian akan mulai berjalan.
                </p>
                <div class="alert alert-warning border-0 d-flex align-items-center justify-content-center gap-2 small text-start mx-auto" style="max-width: 350px;">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                    <div>Pastikan semua peserta sudah siap di ruang tunggu.</div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary px-4" onclick="startExam()">
                        Ya, Mulai Ujian
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Lihat Semua Peserta -->
<div class="modal fade" id="modalSemuaPeserta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-semibold">Daftar Semua Peserta (20)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th class="ps-4">Nama Peserta</th>
                            <th>Status</th>
                            <th>Progress</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dummy 20 Rows generated by Loop -->
                        <?php for($i=1; $i<=20; $i++): 
                            $name = "Peserta Ujian " . $i;
                            $progress = rand(0, 50);
                            $percent = ($progress / 50) * 100;
                            $status = ($progress > 0) ? 'Online' : 'Offline';
                            $statusClass = ($status == 'Online') ? 'success' : 'secondary';
                        ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center text-muted fw-bold small" style="width: 32px; height: 32px;">
                                        P<?= $i ?>
                                    </div>
                                    <span class="fw-medium"><?= $name ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-<?= $statusClass ?>-subtle text-<?= $statusClass ?> extra-small">
                                    <?= $status ?>
                                </span>
                            </td>
                            <td style="width: 40%;">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-grow-1" style="height: 4px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $percent ?>%"></div>
                                    </div>
                                    <span class="extra-small text-muted"><?= $progress ?>/50</span>
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <button class="btn btn-light btn-sm text-primary" onclick="showStudentDetail('<?= $name ?>', <?= $progress ?>, '<?= $status ?>')">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function updateExamInfo(examId) {
        const examData = {
            1: {
                mapel: "Operator Komputer",
                kelas: "OK-2024-A",
                durasi: "60 Menit",
                soal: "50 Soal (PG)",
                jadwal: "11 Des 2025, 08:00"
            },
            2: {
                mapel: "Digital Marketing",
                kelas: "DM-02",
                durasi: "30 Menit",
                soal: "10 Soal (PG)",
                jadwal: "11 Des 2025, 13:00"
            },
            3: {
                mapel: "Barista Dasar",
                kelas: "BRS-01",
                durasi: "45 Menit",
                soal: "Praktek",
                jadwal: "11 Des 2025, 14:00"
            }
        };

        const data = examData[examId];
        if (data) {
            document.getElementById("infoMapel").textContent = data.mapel;
            document.getElementById("infoKelas").textContent = data.kelas;
            document.getElementById("infoDurasi").textContent = data.durasi;
            document.getElementById("infoSoal").textContent = data.soal;
            document.getElementById("infoJadwal").textContent = data.jadwal;
        }
    }

    function startExam() {
        // Close modal confirm first
        const modalEl = document.getElementById('modalMulaiUjian');
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) {
            modal.hide();
        }

        document.getElementById('examPreparationCard').classList.add('d-none');
        document.getElementById('activeExamCard').classList.remove('d-none');
        // Simulate live update
        setInterval(updateRandomProgress, 2000);
    }

    function pauseExam() {
        alert('Ujian dijeda. Peserta tidak dapat mengakses soal sementara waktu.');
    }

    function showStudentDetail(name, progress, status) {
        document.getElementById('detailNama').innerText = name;
        document.getElementById('detailStatus').innerText = status;
        document.getElementById('detailProgressText').innerText = progress + '/50';
        document.getElementById('detailProgressBar').style.width = (progress / 50 * 100) + '%';
        
        // Generate Question Map
        const mapContainer = document.getElementById('questionMap');
        mapContainer.innerHTML = '';
        for(let i=1; i<=50; i++) {
            let colorClass = 'bg-light text-muted border'; // Default: not answered
            if(i <= progress) {
                // Randomly assign some statuses for demo
                const r = Math.random();
                if(r > 0.9) colorClass = 'bg-warning text-white border-warning'; // Flagged
                else if (r > 0.8) colorClass = 'bg-danger text-white border-danger'; // Wrong (if shown)
                else colorClass = 'bg-success text-white border-success'; // Answered
            }
            
            const box = document.createElement('div');
            box.className = `d-flex align-items-center justify-content-center rounded small fw-medium ${colorClass}`;
            box.style.width = '30px';
            box.style.height = '30px';
            box.style.fontSize = '11px';
            box.innerText = i;
            mapContainer.appendChild(box);
        }

        const modal = new bootstrap.Modal(document.getElementById('modalDetailSiswa'));
        modal.show();
    }

    function updateRandomProgress() {
        // Just a dummy function to simulate activity if needed
    }
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
