<?php
require_once __DIR__ . '/../config.php';
require_login(['tutor']);

$user = current_user();
$title        = 'Detail Kelas';
$currentPage  = 'kelas-aktif';
$roleBasePath = '/tutor';
$baseUrl      = '/siakad';

$classId = $_GET['id'] ?? 'CLS-001';

// Dummy Data: Class Info
$classData = [
    'id' => 'CLS-001',
    'name' => 'Operator Komputer - Batch 12',
    'code' => 'OM-12',
    // Flexible Schedule: Array of schedules
    'schedules' => [
        ['day' => 'Senin', 'time' => '08.00 - 10.00 WIB', 'room' => 'Lab Komputer 1'],
        ['day' => 'Kamis', 'time' => '13.00 - 15.00 WIB', 'room' => 'Lab Komputer 2'],
        ['day' => 'Jumat', 'time' => '09.00 - 11.00 WIB', 'room' => 'Lab Teori A'], // Extra schedule example
    ],
    'students_count' => 15,
    'meetings_total' => 12,
    'meetings_done' => 4,
    'progress' => 33,
    'status' => 'active',
    'avg_attendance' => 88
];

// Dummy Data: Students
$students = [
    ['id' => 'S001', 'name' => 'Ahmad Rizki', 'nis' => '2023001', 'attendance' => 90, 'last_seen' => '2 jam lalu'],
    ['id' => 'S002', 'name' => 'Budi Santoso', 'nis' => '2023002', 'attendance' => 85, 'last_seen' => '1 hari lalu'],
    ['id' => 'S003', 'name' => 'Citra Dewi', 'nis' => '2023003', 'attendance' => 100, 'last_seen' => 'Baru saja'],
    ['id' => 'S004', 'name' => 'Dedi Pratama', 'nis' => '2023004', 'attendance' => 75, 'last_seen' => '3 hari lalu'],
    ['id' => 'S005', 'name' => 'Eka Putri', 'nis' => '2023005', 'attendance' => 95, 'last_seen' => '5 jam lalu'],
];

ob_start();
?>

<div class="d-flex flex-column gap-4">
    <!-- Header: Class Info -->
    <div class="d-flex align-items-start justify-content-between">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <a href="kelas-aktif.php" class="text-muted"><i class="bi bi-arrow-left"></i></a>
                <h4 class="fw-bold mb-0"><?= $classData['name'] ?></h4>
                <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle">
                    <?= strtoupper($classData['status']) ?>
                </span>
            </div>
            <div class="d-flex align-items-center gap-3 text-muted small mt-2">
                <span><i class="bi bi-people me-1"></i> <?= $classData['students_count'] ?> Siswa</span>
                <span class="text-muted opacity-25">|</span>
                <span><i class="bi bi-calendar-check me-1"></i> Pertemuan <?= $classData['meetings_done'] ?>/<?= $classData['meetings_total'] ?></span>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom px-4 pt-4 pb-0">
            <ul class="nav nav-tabs card-header-tabs" id="classTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-medium" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">Overview</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-medium" id="materi-tab" data-bs-toggle="tab" data-bs-target="#materi" type="button" role="tab">Materi & Absensi</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-medium" id="siswa-tab" data-bs-toggle="tab" data-bs-target="#siswa" type="button" role="tab">Data Siswa</button>
                </li>
            </ul>
        </div>
        
        <div class="card-body p-4">
            <div class="tab-content" id="classTabsContent">
                
                <!-- TAB: OVERVIEW (REDESIGNED) -->
                <div class="tab-pane fade show active" id="overview" role="tabpanel">
                    
                    <!-- Top Stats -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="p-3 border rounded-3 bg-primary-subtle bg-opacity-10 h-100">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-primary text-white rounded-circle p-3">
                                        <i class="bi bi-journal-check fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="small text-muted text-uppercase fw-bold">Progres Materi</div>
                                        <div class="fs-4 fw-bold text-primary"><?= $classData['progress'] ?>%</div>
                                    </div>
                                </div>
                                <div class="progress mt-3" style="height: 6px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $classData['progress'] ?>%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border rounded-3 bg-success-subtle bg-opacity-10 h-100">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-success text-white rounded-circle p-3">
                                        <i class="bi bi-people fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="small text-muted text-uppercase fw-bold">Rata-rata Kehadiran</div>
                                        <div class="fs-4 fw-bold text-success"><?= $classData['avg_attendance'] ?>%</div>
                                    </div>
                                </div>
                                <div class="d-flex gap-1 mt-3">
                                    <?php for($i=0; $i<10; $i++): ?>
                                        <div class="flex-grow-1 rounded-pill bg-success<?= $i > 8 ? '-subtle' : '' ?>" style="height: 6px;"></div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border rounded-3 bg-warning-subtle bg-opacity-10 h-100">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-warning text-dark rounded-circle p-3">
                                        <i class="bi bi-trophy fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="small text-muted text-uppercase fw-bold">Siswa Terbaik</div>
                                        <div class="fs-4 fw-bold text-dark">Citra Dewi</div>
                                    </div>
                                </div>
                                <div class="mt-3 small text-muted">
                                    <i class="bi bi-star-fill text-warning me-1"></i> Nilai rata-rata 98.5
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <!-- Left: Jadwal Fleksibel -->
                        <div class="col-lg-6">
                            <div class="card h-100 border shadow-none">
                                <div class="card-header bg-white py-3">
                                    <h6 class="fw-bold mb-0"><i class="bi bi-calendar-week me-2 text-primary"></i>Jadwal Rutin Kelas</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex flex-column gap-3">
                                        <?php foreach($classData['schedules'] as $sch): ?>
                                        <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-light border-start border-4 border-primary">
                                            <div class="text-center" style="min-width: 60px;">
                                                <div class="small text-muted text-uppercase">Hari</div>
                                                <div class="fw-bold text-dark"><?= $sch['day'] ?></div>
                                            </div>
                                            <div class="vr"></div>
                                            <div>
                                                <div class="fw-bold text-dark"><?= $sch['time'] ?></div>
                                                <div class="small text-muted"><i class="bi bi-geo-alt me-1"></i> <?= $sch['room'] ?></div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Activity Timeline -->
                        <div class="col-lg-6">
                            <div class="card h-100 border shadow-none">
                                <div class="card-header bg-white py-3">
                                    <h6 class="fw-bold mb-0"><i class="bi bi-activity me-2 text-primary"></i>Aktivitas Terkini</h6>
                                </div>
                                <div class="card-body">
                                    <div class="timeline-activity ps-2">
                                        <div class="d-flex gap-3 mb-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px; z-index: 1;"><i class="bi bi-check-lg small"></i></div>
                                                <div class="h-100 border-start border-2 border-light my-1 position-absolute" style="transform: translateY(32px);"></div>
                                            </div>
                                            <div>
                                                <div class="small text-primary fw-bold mb-1">Hari ini, 09:30</div>
                                                <div class="fw-bold text-dark">Absensi Pertemuan 4 Selesai</div>
                                                <div class="small text-muted bg-light p-2 rounded mt-1">12 dari 15 Siswa hadir dalam sesi ini.</div>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-3 mb-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px; z-index: 1;"><i class="bi bi-file-earmark-text small"></i></div>
                                                <div class="h-100 border-start border-2 border-light my-1 position-absolute" style="transform: translateY(32px);"></div>
                                            </div>
                                            <div>
                                                <div class="small text-muted mb-1">Kemarin</div>
                                                <div class="fw-bold text-dark">Tugas Baru: Latihan Formatting</div>
                                                <div class="small text-muted">Deadline: 20 Des 2025</div>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-3">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px; z-index: 1;"><i class="bi bi-person-plus small"></i></div>
                                            </div>
                                            <div>
                                                <div class="small text-muted mb-1">3 Hari lalu</div>
                                                <div class="fw-bold text-dark">Siswa Baru Bergabung</div>
                                                <div class="small text-muted">Eka Putri ditambahkan ke kelas.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB: MATERI & ABSENSI (ACCORDION) -->
                <div class="tab-pane fade" id="materi" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-bold mb-0">Daftar Pertemuan & Materi</h6>
                        <button class="btn btn-sm btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#modalTambahPertemuan">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Pertemuan
                        </button>
                    </div>
                    
                    <div class="accordion" id="accordionMateri">
                        <?php for($i=1; $i<=5; $i++): 
                            $isCurrent = ($i == 4);
                            $isDone = ($i < 4);
                        ?>
                        <div class="accordion-item border-0 mb-3 shadow-sm rounded-3 overflow-hidden">
                            <h2 class="accordion-header">
                                <button class="accordion-button <?= $isCurrent ? '' : 'collapsed' ?> bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $i ?>" aria-expanded="<?= $isCurrent ? 'true' : 'false' ?>">
                                    <div class="d-flex align-items-center gap-3 w-100 me-3">
                                        <div class="d-flex flex-column align-items-center justify-content-center bg-<?= $isDone ? 'success' : ($isCurrent ? 'primary' : 'light') ?>-subtle rounded p-2" style="width: 50px; height: 50px;">
                                            <div class="small fw-bold text-<?= $isDone ? 'success' : ($isCurrent ? 'primary' : 'muted') ?>">PER</div>
                                            <div class="fw-bold fs-5 text-<?= $isDone ? 'success' : ($isCurrent ? 'primary' : 'muted') ?>"><?= $i ?></div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-bold text-dark mb-1">
                                                Pengenalan Tools Microsoft Word Part <?= $i ?>
                                                <?php if($isCurrent): ?><span class="badge bg-primary ms-2">Sedang Berlangsung</span><?php endif; ?>
                                                <?php if($isDone): ?><span class="badge bg-success-subtle text-success ms-2"><i class="bi bi-check-lg"></i> Selesai</span><?php endif; ?>
                                            </div>
                                            <div class="small text-muted">10 Des 2025 • Lab Komputer 1</div>
                                        </div>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapse<?= $i ?>" class="accordion-collapse collapse <?= $isCurrent ? 'show' : '' ?>" data-bs-parent="#accordionMateri">
                                <div class="accordion-body bg-light border-top">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="card border-0 h-100">
                                                <div class="card-body p-3">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h6 class="fw-bold small text-uppercase text-muted mb-0"><i class="bi bi-file-text me-1"></i> Materi Pelajaran</h6>
                                                        <button class="btn btn-sm btn-link text-decoration-none p-0" data-bs-toggle="modal" data-bs-target="#modalKelolaMateri"><i class="bi bi-pencil-square"></i> Kelola</button>
                                                    </div>
                                                    <ul class="list-unstyled small mb-0 d-flex flex-column gap-2">
                                                        <li><a href="#" class="text-decoration-none d-flex align-items-center gap-2"><i class="bi bi-file-pdf text-danger"></i> Modul_Bab_<?= $i ?>.pdf</a></li>
                                                        <li><a href="#" class="text-decoration-none d-flex align-items-center gap-2"><i class="bi bi-play-circle text-primary"></i> Video Tutorial Part <?= $i ?></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card border-0 h-100">
                                                <div class="card-body p-3">
                                                    <h6 class="fw-bold small text-uppercase text-muted mb-3"><i class="bi bi-check-square me-1"></i> Absensi</h6>
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <span class="small text-muted">Hadir</span>
                                                        <span class="fw-bold text-success">12 Siswa</span>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                                        <span class="small text-muted">Tidak Hadir</span>
                                                        <span class="fw-bold text-danger">3 Siswa</span>
                                                    </div>
                                                    <button class="btn btn-sm btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#modalDetailAbsensi">Lihat Detail Absen</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card border-0 h-100">
                                                <div class="card-body p-3">
                                                    <h6 class="fw-bold small text-uppercase text-muted mb-3"><i class="bi bi-pencil-square me-1"></i> Tugas / Kuis</h6>
                                                    <?php if($i % 2 == 0): ?>
                                                        <div class="alert alert-light border mb-0 small">
                                                            <div class="fw-bold">Latihan Praktik <?= $i ?></div>
                                                            <div class="text-muted mb-2">Deadline: 15 Des 2025</div>
                                                            <div class="progress" style="height: 4px;">
                                                                <div class="progress-bar bg-warning" style="width: 45%"></div>
                                                            </div>
                                                            <div class="mt-1 extra-small text-end text-muted">8/15 Mengumpulkan</div>
                                                        </div>
                                                        <button class="btn btn-sm btn-link text-decoration-none px-0 mt-2">Edit Tugas</button>
                                                    <?php else: ?>
                                                        <div class="text-center py-3 border border-dashed rounded bg-light mb-0">
                                                             <div class="small text-muted mb-2">Belum ada tugas</div>
                                                             <button class="btn btn-sm btn-outline-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#modalTambahTugas">
                                                                <i class="bi bi-plus-lg me-1"></i> Buat Tugas
                                                             </button>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- TAB: DATA SISWA (MODERNIZED) -->
                <div class="tab-pane fade" id="siswa" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari siswa berdasarkan nama atau NIS...">
                            </div>
                        </div>
                        <div class="col-lg-6 text-end">
                            <button class="btn btn-outline-primary rounded-pill"><i class="bi bi-download me-1"></i> Export Data</button>
                        </div>
                    </div>
                    <div class="table-responsive border rounded-3">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 py-3 ps-3">Siswa</th>
                                    <th class="border-0 py-3">NIS</th>
                                    <th class="border-0 py-3 text-center">Kehadiran</th>
                                    <th class="border-0 py-3 text-center">Status</th>
                                    <th class="border-0 py-3 text-end pe-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($students as $student): ?>
                                <tr>
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-placeholder rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <?= substr($student['name'], 0, 1) ?>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark"><?= $student['name'] ?></div>
                                                <div class="extra-small text-muted"><i class="bi bi-clock me-1"></i> <?= $student['last_seen'] ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-muted"><?= $student['nis'] ?></td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center">
                                            <span class="fw-bold text-<?= $student['attendance'] >= 90 ? 'success' : 'warning' ?>">
                                                <?= $student['attendance'] ?>%
                                            </span>
                                            <div class="progress w-75 bg-light" style="height: 4px;">
                                                <div class="progress-bar bg-<?= $student['attendance'] >= 90 ? 'success' : 'warning' ?>" style="width: <?= $student['attendance'] ?>%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success-subtle text-success rounded-pill px-3">Aktif</span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <button class="btn btn-sm btn-light text-primary border rounded-pill px-3 btn-student-action" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalStudentAction"
                                                data-name="<?= $student['name'] ?>"
                                                data-nis="<?= $student['nis'] ?>">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal Student Action (Cool Modern Design) -->
<div class="modal fade" id="modalStudentAction" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-body p-0">
                <div class="row g-0">
                    <!-- Sidebar Profile -->
                    <div class="col-md-4 bg-light border-end">
                        <div class="p-4 text-center h-100 d-flex flex-column">
                            <div class="mb-4 mt-2">
                                <div class="avatar-placeholder bg-white border shadow-sm rounded-circle mx-auto d-flex align-items-center justify-content-center text-primary display-4 fw-bold" style="width: 100px; height: 100px;" id="modalStudentAvatar">
                                    A
                                </div>
                            </div>
                            <h5 class="fw-bold mb-1" id="modalStudentName">Nama Siswa</h5>
                            <p class="text-muted small mb-4" id="modalStudentNis">NIS: 12345</p>
                            
                            <div class="d-grid gap-2 mt-auto">
                                <button class="btn btn-primary rounded-pill"><i class="bi bi-chat-dots me-2"></i>Kirim Pesan</button>
                                <button class="btn btn-outline-danger rounded-pill"><i class="bi bi-exclamation-circle me-2"></i>Lapor Masalah</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Content Details -->
                    <div class="col-md-8">
                        <div class="p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h6 class="fw-bold mb-0 text-uppercase text-muted small">Detail Siswa</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <ul class="nav nav-pills nav-fill mb-4 p-1 bg-light rounded-pill" id="studentTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active rounded-pill py-1 small" id="st-stats-tab" data-bs-toggle="tab" data-bs-target="#st-stats" type="button">Statistik</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link rounded-pill py-1 small" id="st-assessment-tab" data-bs-toggle="tab" data-bs-target="#st-assessment" type="button">Penilaian</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link rounded-pill py-1 small" id="st-notes-tab" data-bs-toggle="tab" data-bs-target="#st-notes" type="button">Catatan</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="studentTabsContent">
                                <!-- Stats Tab -->
                                <div class="tab-pane fade show active" id="st-stats" role="tabpanel">
                                    <div class="row g-3 mb-4">
                                        <div class="col-6">
                                            <div class="p-3 border rounded-3 text-center">
                                                <div class="display-6 fw-bold text-success mb-0">92%</div>
                                                <div class="small text-muted">Kehadiran</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-3 border rounded-3 text-center">
                                                <div class="display-6 fw-bold text-primary mb-0">88</div>
                                                <div class="small text-muted">Rata-rata Nilai</div>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="fw-bold small mb-2">Grafik Performa</h6>
                                    <div class="bg-light rounded h-100 d-flex align-items-end justify-content-between px-3 pb-3 pt-5" style="height: 120px;">
                                        <!-- Fake Chart Bars -->
                                        <div class="w-100 bg-primary-subtle rounded-top mx-1" style="height: 40%"></div>
                                        <div class="w-100 bg-primary-subtle rounded-top mx-1" style="height: 60%"></div>
                                        <div class="w-100 bg-primary rounded-top mx-1" style="height: 80%"></div>
                                        <div class="w-100 bg-primary-subtle rounded-top mx-1" style="height: 70%"></div>
                                        <div class="w-100 bg-primary-subtle rounded-top mx-1" style="height: 50%"></div>
                                    </div>
                                </div>

                                <!-- Assessment Tab (NEW) -->
                                <div class="tab-pane fade" id="st-assessment" role="tabpanel">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label small fw-bold mb-0">Pemahaman Materi</label>
                                            <span class="small text-primary fw-bold">85/100</span>
                                        </div>
                                        <input type="range" class="form-range" min="0" max="100" value="85" id="rangePemahaman">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Sikap & Kedisiplinan</label>
                                        <select class="form-select form-select-sm">
                                            <option value="Sangat Baik" selected>Sangat Baik</option>
                                            <option value="Baik">Baik</option>
                                            <option value="Cukup">Cukup</option>
                                            <option value="Kurang">Kurang</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Keaktifan di Kelas</label>
                                        <div class="d-flex gap-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="activeRadio" id="active1" value="1">
                                                <label class="form-check-label small" for="active1">Pasif</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="activeRadio" id="active2" value="2">
                                                <label class="form-check-label small" for="active2">Cukup</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="activeRadio" id="active3" value="3" checked>
                                                <label class="form-check-label small" for="active3">Aktif</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-grid">
                                        <button class="btn btn-sm btn-primary">Simpan Penilaian</button>
                                    </div>
                                </div>

                                <!-- Notes Tab -->
                                <div class="tab-pane fade" id="st-notes" role="tabpanel">
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                                        <label for="floatingTextarea2">Catatan Pribadi untuk Siswa</label>
                                    </div>
                                    <button class="btn btn-sm btn-primary">Simpan Catatan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Absensi (NEW) -->
<div class="modal fade" id="modalDetailAbsensi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Detail Absensi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <p class="text-muted small mb-3">Pertemuan 4 - Pengenalan Tools Microsoft Word</p>
                
                <div class="d-flex gap-2 mb-3 overflow-auto pb-2">
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">Hadir: 12</span>
                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill">Izin: 2</span>
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">Alpha: 1</span>
                </div>

                <div class="list-group list-group-flush border rounded-3" style="max-height: 300px; overflow-y: auto;">
                    <?php foreach ($students as $index => $s): ?>
                    <div class="list-group-item d-flex align-items-center justify-content-between py-2">
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-placeholder rounded-circle bg-light border text-muted fw-bold d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 12px;">
                                <?= substr($s['name'], 0, 1) ?>
                            </div>
                            <div class="small fw-bold"><?= $s['name'] ?></div>
                        </div>
                        <select class="form-select form-select-sm w-auto border-0 bg-light fw-medium py-0" style="height: 28px; font-size: 12px;">
                            <option value="H" <?= $index < 12 ? 'selected' : '' ?>>Hadir</option>
                            <option value="I" <?= $index == 12 || $index == 13 ? 'selected' : '' ?>>Izin</option>
                            <option value="S">Sakit</option>
                            <option value="A" <?= $index == 14 ? 'selected' : '' ?>>Alpha</option>
                        </select>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-sm btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Pertemuan (NEW) -->
<div class="modal fade" id="modalTambahPertemuan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Pertemuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info border-0 bg-info-subtle text-info-emphasis extra-small mb-3">
                    <i class="bi bi-info-circle me-1"></i> Pertemuan tambahan bersifat fleksibel dan tidak harus sesuai modul.
                </div>
                <form>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Topik Pertemuan</label>
                        <input type="text" class="form-control" placeholder="Contoh: Pembahasan Kisi-kisi Ujian">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Materi (Deskripsi)</label>
                        <textarea class="form-control" rows="4" placeholder="Tuliskan materi atau ringkasan pertemuan..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Upload Video</label>
                        <div class="input-group">
                            <input type="file" class="form-control" accept="video/*">
                            <span class="input-group-text bg-light text-muted">atau</span>
                            <input type="text" class="form-control" placeholder="Link YouTube/Drive">
                        </div>
                        <div class="form-text extra-small">Upload file video atau tempel link video pembelajaran.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Upload Dokumen Materi</label>
                        <input type="file" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx">
                        <div class="form-text extra-small">Format: PDF, Word, atau PowerPoint.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Ajukan Pertemuan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Kelola Materi (NEW) -->
<div class="modal fade" id="modalKelolaMateri" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Kelola Materi Pertemuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Upload Video Baru</label>
                        <div class="input-group mb-2">
                            <input type="file" class="form-control" accept="video/*">
                            <span class="input-group-text bg-light text-muted">atau</span>
                            <input type="text" class="form-control" placeholder="Link YouTube/Drive">
                        </div>
                        <!-- List Video Existing -->
                        <div class="bg-light p-2 rounded border">
                            <div class="d-flex align-items-center justify-content-between small mb-1">
                                <span><i class="bi bi-play-circle text-primary me-2"></i>Video Tutorial Part 1</span>
                                <button type="button" class="btn btn-link text-danger p-0" style="font-size: 0.8rem;"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Upload Dokumen Materi Baru</label>
                        <input type="file" class="form-control mb-2" accept=".pdf,.doc,.docx,.ppt,.pptx">
                        <!-- List Dokumen Existing -->
                        <div class="bg-light p-2 rounded border">
                            <div class="d-flex align-items-center justify-content-between small mb-1">
                                <span><i class="bi bi-file-pdf text-danger me-2"></i>Modul_Bab_1.pdf</span>
                                <button type="button" class="btn btn-link text-danger p-0" style="font-size: 0.8rem;"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Selesai</button>
                <button type="button" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Tugas (NEW) -->
<div class="modal fade" id="modalTambahTugas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Buat Tugas Tambahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Judul Tugas</label>
                        <input type="text" class="form-control" placeholder="Contoh: Latihan Mandiri Bab 4">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Deskripsi / Soal</label>
                        <textarea class="form-control" rows="3" placeholder="Jelaskan detail tugas..."></textarea>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Deadline</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Waktu</label>
                            <input type="time" class="form-control" value="23:59">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Lampiran (Opsional)</label>
                        <input type="file" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Simpan Tugas</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalStudentAction = document.getElementById('modalStudentAction');
    if (modalStudentAction) {
        modalStudentAction.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const name = button.getAttribute('data-name');
            const nis = button.getAttribute('data-nis');
            
            const modalTitle = modalStudentAction.querySelector('#modalStudentName');
            const modalNis = modalStudentAction.querySelector('#modalStudentNis');
            const modalAvatar = modalStudentAction.querySelector('#modalStudentAvatar');
            
            modalTitle.textContent = name;
            modalNis.textContent = 'NIS: ' + nis;
            modalAvatar.textContent = name.charAt(0);
        });
    }
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
