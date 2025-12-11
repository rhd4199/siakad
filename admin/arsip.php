<?php
require_once __DIR__ . '/../config.php';
require_login(['admin']);

$user         = current_user();
$title        = 'Arsip Data';
$currentPage  = 'arsip';
$roleBasePath = '/admin';
$baseUrl      = '/siakad';

// Mock Data: Kelas Selesai
$archived_classes = [
    [
        'id' => 201, 'code' => 'WD-01', 'program' => 'Web Development', 
        'batch' => 'Batch Nov 2024', 'tutor' => 'Sandhika Galih', 
        'tutor_email' => 'sandhika@siakad.com', 'tutor_phone' => '+62 812-3456-7890',
        'description' => 'Kelas intensif pengembangan web modern menggunakan stack MERN (MongoDB, Express, React, Node.js).',
        'end_date' => '2024-12-20', 'graduates' => 18, 'total' => 20,
        'color' => 'primary',
        'students' => [
            ['name' => 'Aditya Pratama', 'status' => 'Lulus', 'score' => 88],
            ['name' => 'Budi Santoso', 'status' => 'Lulus', 'score' => 85],
            ['name' => 'Citra Lestari', 'status' => 'Lulus', 'score' => 90],
            ['name' => 'Dewi Ayu', 'status' => 'Lulus', 'score' => 82],
            ['name' => 'Erik Firmansyah', 'status' => 'Tidak Lulus', 'score' => 45],
        ]
    ],
    [
        'id' => 202, 'code' => 'DM-05', 'program' => 'Digital Marketing', 
        'batch' => 'Batch Okt 2024', 'tutor' => 'Eko Kurniawan', 
        'tutor_email' => 'eko@siakad.com', 'tutor_phone' => '+62 813-4567-8901',
        'description' => 'Strategi pemasaran digital komprehensif mulai dari SEO, SEM, hingga Social Media Marketing.',
        'end_date' => '2024-11-15', 'graduates' => 15, 'total' => 15,
        'color' => 'success',
        'students' => [
            ['name' => 'Fajar Nugraha', 'status' => 'Lulus', 'score' => 88],
            ['name' => 'Gita Pertiwi', 'status' => 'Lulus', 'score' => 92],
            ['name' => 'Hendra Gunawan', 'status' => 'Lulus', 'score' => 85],
        ]
    ],
    [
        'id' => 203, 'code' => 'GD-01', 'program' => 'Graphic Design', 
        'batch' => 'Batch Sept 2024', 'tutor' => 'Rio Purba', 
        'tutor_email' => 'rio@siakad.com', 'tutor_phone' => '+62 811-2345-6789',
        'description' => 'Mastering visual communication fundamentals, typography, and layout design using Adobe Creative Cloud.',
        'end_date' => '2024-10-30', 'graduates' => 19, 'total' => 20,
        'color' => 'danger',
        'students' => [
            ['name' => 'Indah Sari', 'status' => 'Lulus', 'score' => 95],
            ['name' => 'Joko Anwar', 'status' => 'Lulus', 'score' => 89],
        ]
    ]
];

// Mock Data: Ujian Selesai
$archived_exams = [
    [
        'id' => 501, 'name' => 'Ujian Akhir Web Dev', 'class' => 'Web Development - WD-01',
        'date' => '2024-12-18', 'participants' => 20, 'avg_score' => 85.5,
        'duration' => '90 Menit',
        'top_scorers' => [
            ['name' => 'Citra Lestari', 'score' => 98],
            ['name' => 'Aditya Pratama', 'score' => 95],
            ['name' => 'Budi Santoso', 'score' => 92]
        ]
    ],
    [
        'id' => 502, 'name' => 'Ujian Tengah Semester DM', 'class' => 'Digital Marketing - DM-05',
        'date' => '2024-11-01', 'participants' => 15, 'avg_score' => 78.2,
        'duration' => '60 Menit',
        'top_scorers' => [
            ['name' => 'Gita Pertiwi', 'score' => 94],
            ['name' => 'Fajar Nugraha', 'score' => 89],
            ['name' => 'Hendra Gunawan', 'score' => 85]
        ]
    ],
    [
        'id' => 503, 'name' => 'Quiz Fundamental Design', 'class' => 'Graphic Design - GD-01',
        'date' => '2024-10-15', 'participants' => 20, 'avg_score' => 92.0,
        'duration' => '45 Menit',
        'top_scorers' => [
            ['name' => 'Indah Sari', 'score' => 100],
            ['name' => 'Joko Anwar', 'score' => 98],
            ['name' => 'Kiki Amalia', 'score' => 96]
        ]
    ]
];

// Mock Data: Riwayat Cetak
$print_history = [
    [
        'id' => 1, 'type' => 'Sertifikat', 'student' => 'Aditya Pratama', 
        'class' => 'Web Development (WD-01)', 'date' => '2024-12-22', 'admin' => 'Admin Utama',
        'status' => 'success'
    ],
    [
        'id' => 2, 'type' => 'Raport', 'student' => 'Aditya Pratama', 
        'class' => 'Web Development (WD-01)', 'date' => '2024-12-22', 'admin' => 'Admin Utama',
        'status' => 'success'
    ],
    [
        'id' => 3, 'type' => 'Sertifikat', 'student' => 'Bunga Citra', 
        'class' => 'Digital Marketing (DM-05)', 'date' => '2024-11-20', 'admin' => 'Admin Utama',
        'status' => 'success'
    ],
    [
        'id' => 4, 'type' => 'Raport', 'student' => 'Chandra Wijaya', 
        'class' => 'Graphic Design (GD-01)', 'date' => '2024-10-31', 'admin' => 'Admin Utama',
        'status' => 'success'
    ],
    [
        'id' => 5, 'type' => 'Sertifikat', 'student' => 'Erik Santoso', 
        'class' => 'Web Development (WD-01)', 'date' => '2024-12-22', 'admin' => 'Admin Utama',
        'status' => 'success'
    ],
];

$activeTab = $_GET['tab'] ?? 'kelas';

ob_start();
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h4 class="fw-bold mb-1">Arsip Data Akademik</h4>
        <p class="text-muted small mb-0">
            Riwayat kelas selesai, ujian lampau, dan dokumen tercetak.
        </p>
    </div>
    <div class="col-md-6 mt-3 mt-md-0">
        <div class="input-group">
            <span class="input-group-text bg-white border-end-0">
                <i class="bi bi-search text-muted"></i>
            </span>
            <input type="text" class="form-control border-start-0" id="globalSearch" placeholder="Cari data arsip (nama kelas, siswa, atau ujian)..." onkeyup="filterArsip()">
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 bg-transparent">
    <div class="card-header bg-transparent border-bottom-0 p-0 mb-3">
        <ul class="nav nav-pills" id="arsipTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link <?= $activeTab === 'kelas' ? 'active' : '' ?> rounded-pill px-4" id="kelas-tab" data-bs-toggle="tab" data-bs-target="#kelas-pane" type="button" role="tab">
                    <i class="bi bi-folder2-open me-2"></i>Kelas Selesai
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?= $activeTab === 'ujian' ? 'active' : '' ?> rounded-pill px-4" id="ujian-tab" data-bs-toggle="tab" data-bs-target="#ujian-pane" type="button" role="tab">
                    <i class="bi bi-archive me-2"></i>Ujian Selesai
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?= $activeTab === 'dokumen' ? 'active' : '' ?> rounded-pill px-4" id="dokumen-tab" data-bs-toggle="tab" data-bs-target="#dokumen-pane" type="button" role="tab">
                    <i class="bi bi-files me-2"></i>Riwayat Cetak
                </button>
            </li>
        </ul>
    </div>
    
    <div class="card-body p-0">
        <div class="tab-content" id="arsipTabsContent">
            
            <!-- TAB: KELAS SELESAI -->
            <div class="tab-pane fade <?= $activeTab === 'kelas' ? 'show active' : '' ?>" id="kelas-pane" role="tabpanel">
                <div class="row g-3" id="list-kelas">
                    <?php foreach($archived_classes as $cls): ?>
                    <div class="col-md-6 col-xl-4 search-item" data-search="<?= strtolower($cls['program'] . ' ' . $cls['code'] . ' ' . $cls['tutor']) ?>">
                        <div class="card h-100 border-0 shadow-sm hover-shadow transition-all position-relative overflow-hidden">
                            <div class="position-absolute top-0 start-0 h-100 bg-<?= $cls['color'] ?>" style="width: 4px;"></div>
                            <div class="card-body ps-4">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-light text-dark border"><?= $cls['code'] ?></span>
                                    <small class="text-muted"><i class="bi bi-calendar-check me-1"></i><?= date('d M Y', strtotime($cls['end_date'])) ?></small>
                                </div>
                                <h5 class="fw-bold mb-1 text-truncate"><?= $cls['program'] ?></h5>
                                <p class="text-muted small mb-3"><?= $cls['batch'] ?></p>
                                
                                <div class="d-flex align-items-center mb-3 p-2 bg-light rounded">
                                    <div class="avatar-circle bg-white border text-dark me-2 small fw-bold">
                                        <?= substr($cls['tutor'], 0, 2) ?>
                                    </div>
                                    <div class="small">
                                        <div class="fw-semibold"><?= $cls['tutor'] ?></div>
                                        <div class="text-muted extra-small">Instruktur</div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between small mb-1">
                                        <span class="fw-medium text-muted">Tingkat Kelulusan</span>
                                        <span class="fw-bold text-success"><?= round(($cls['graduates']/$cls['total'])*100) ?>%</span>
                                    </div>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-success" style="width: <?= ($cls['graduates']/$cls['total'])*100 ?>%"></div>
                                    </div>
                                </div>

                                <button class="btn btn-outline-primary btn-sm w-100 stretched-link" onclick="openDetailModal(<?= $cls['id'] ?>)">
                                    <i class="bi bi-eye me-1"></i> Lihat Detail Kelas
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- TAB: UJIAN SELESAI -->
            <div class="tab-pane fade <?= $activeTab === 'ujian' ? 'show active' : '' ?>" id="ujian-pane" role="tabpanel">
                <div class="row g-3" id="list-ujian">
                    <?php foreach($archived_exams as $ex): ?>
                    <div class="col-md-6 col-lg-4 search-item" data-search="<?= strtolower($ex['name'] . ' ' . $ex['class']) ?>">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-start gap-3 mb-3">
                                    <div class="bg-light text-secondary p-3 rounded-3 border">
                                        <i class="bi bi-journal-text fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-1"><?= $ex['name'] ?></h6>
                                        <div class="small text-muted"><?= $ex['class'] ?></div>
                                    </div>
                                </div>
                                
                                <div class="bg-light rounded p-3 mb-3 small">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="text-muted mb-1">Tanggal</div>
                                            <div class="fw-semibold"><i class="bi bi-calendar me-1"></i><?= date('d M Y', strtotime($ex['date'])) ?></div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-muted mb-1">Durasi</div>
                                            <div class="fw-semibold"><i class="bi bi-clock me-1"></i><?= $ex['duration'] ?></div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-muted mb-1">Peserta</div>
                                            <div class="fw-semibold"><i class="bi bi-people me-1"></i><?= $ex['participants'] ?> Siswa</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-muted mb-1">Rata-rata</div>
                                            <div class="fw-semibold text-primary"><i class="bi bi-bar-chart me-1"></i><?= $ex['avg_score'] ?></div>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-sm btn-outline-secondary w-100" onclick="openInfoModal(<?= $ex['id'] ?>)">
                                    <i class="bi bi-info-circle me-1"></i> Lihat Informasi
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- TAB: RIWAYAT CETAK -->
            <div class="tab-pane fade <?= $activeTab === 'dokumen' ? 'show active' : '' ?>" id="dokumen-pane" role="tabpanel">
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-download me-1"></i> Export Log
                    </button>
                </div>
                
                <div class="row g-3" id="list-dokumen">
                    <?php foreach($print_history as $log): ?>
                    <div class="col-md-6 col-xl-3 search-item" data-search="<?= strtolower($log['type'] . ' ' . $log['student'] . ' ' . $log['class']) ?>">
                        <div class="card h-100 border-0 shadow-sm text-center p-2 hover-shadow transition-all">
                            <div class="card-body d-flex flex-col flex-column align-items-center">
                                <div class="mb-3 position-relative">
                                    <div class="p-3 rounded-circle <?= $log['type'] === 'Sertifikat' ? 'bg-warning-subtle text-warning-emphasis' : 'bg-primary-subtle text-primary-emphasis' ?>" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi <?= $log['type'] === 'Sertifikat' ? 'bi-award' : 'bi-file-earmark-text' ?> fs-3"></i>
                                    </div>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success border border-light">
                                        <i class="bi bi-check-lg"></i>
                                    </span>
                                </div>
                                
                                <h6 class="fw-bold mb-1 text-truncate w-100" title="<?= $log['student'] ?>"><?= $log['student'] ?></h6>
                                <div class="small text-muted mb-2"><?= $log['type'] ?></div>
                                
                                <div class="bg-light rounded p-2 w-100 mb-3 extra-small text-muted">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Kelas:</span>
                                        <span class="fw-medium text-truncate" style="max-width: 80px;" title="<?= $log['class'] ?>"><?= substr($log['class'], 0, 10) ?>...</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Tgl:</span>
                                        <span class="fw-medium"><?= date('d/m/y', strtotime($log['date'])) ?></span>
                                    </div>
                                </div>

                                <div class="mt-auto w-100 d-flex gap-2 justify-content-center">
                                    <button class="btn btn-light btn-sm flex-grow-1" onclick="openPreviewModal('<?= $log['type'] ?>', '<?= $log['student'] ?>')" data-bs-toggle="tooltip" title="Preview">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm flex-grow-1" data-bs-toggle="tooltip" title="Download">
                                        <i class="bi bi-download"></i>
                                    </button>
                                    <button class="btn btn-outline-primary btn-sm flex-grow-1" onclick="regenerateDoc('<?= $log['type'] ?>', '<?= $log['student'] ?>')" data-bs-toggle="tooltip" title="Generate Ulang">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- MODALS -->
<!-- Detail Kelas Modal -->
<div class="modal fade slide-up" id="detailKelasModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="detailKelasTitle"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <!-- Modal Tabs -->
                <ul class="nav nav-tabs nav-fill bg-light px-3 pt-3 border-bottom-0" id="detailKelasTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="detail-ringkasan-tab" data-bs-toggle="tab" data-bs-target="#detail-ringkasan" type="button" role="tab">
                            <i class="bi bi-info-circle me-2"></i>Ringkasan
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="detail-siswa-tab" data-bs-toggle="tab" data-bs-target="#detail-siswa" type="button" role="tab">
                            <i class="bi bi-people me-2"></i>Daftar Siswa
                        </button>
                    </li>
                </ul>
                
                <div class="tab-content p-4" id="detailKelasTabContent">
                    <!-- Tab Ringkasan -->
                    <div class="tab-pane fade show active" id="detail-ringkasan" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="bg-light rounded p-3 h-100">
                                    <h6 class="fw-bold mb-3 border-bottom pb-2">Informasi Kelas</h6>
                                    <p class="mb-2"><span class="text-muted d-block small">Kode Kelas</span> <span id="detailKelasCode" class="fw-medium"></span></p>
                                    <p class="mb-2"><span class="text-muted d-block small">Tanggal Selesai</span> <span id="detailKelasEndDate" class="fw-medium"></span></p>
                                    <p class="mb-0"><span class="text-muted d-block small">Deskripsi</span> <span id="detailKelasDesc" class="small text-secondary"></span></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-light rounded p-3 h-100">
                                    <h6 class="fw-bold mb-3 border-bottom pb-2">Statistik Kelulusan</h6>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted small">Tingkat Kelulusan</span>
                                        <span id="detailKelasGraduates" class="fw-bold text-success"></span>
                                    </div>
                                    <div class="progress mb-3" style="height: 10px;">
                                        <div class="progress-bar bg-success" id="detailKelasGraduatesProgress"></div>
                                    </div>
                                    
                                    <h6 class="fw-bold mt-4 mb-2 border-bottom pb-2">Profil Instruktur</h6>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="avatar-circle bg-primary text-white me-2">
                                            <i class="bi bi-person"></i>
                                        </div>
                                        <div>
                                            <div id="detailKelasTutor" class="fw-bold small"></div>
                                            <div id="detailKelasTutorEmail" class="text-muted extra-small"></div>
                                        </div>
                                    </div>
                                    <div class="small text-muted ps-5">
                                        <i class="bi bi-telephone me-1"></i> <span id="detailKelasTutorPhone"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tab Siswa -->
                    <div class="tab-pane fade" id="detail-siswa" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Siswa</th>
                                        <th class="text-center">Nilai Akhir</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="detailKelasStudentList">
                                    <!-- Populated by JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-top-0">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Info Ujian Modal -->
<div class="modal fade scale-in" id="infoUjianModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-light border-bottom-0">
                <h5 class="modal-title fw-bold">Informasi Ujian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-circle" style="width: 80px; height: 80px;">
                        <i class="bi bi-journal-text fs-1"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-1" id="infoUjianName"></h4>
                <p class="text-muted" id="infoUjianClass"></p>
                
                <div class="row g-3 mt-4 text-start">
                    <div class="col-6">
                        <div class="p-3 border rounded bg-white h-100 hover-shadow transition-all">
                            <div class="text-muted small mb-1"><i class="bi bi-calendar me-1"></i> Tanggal</div>
                            <div class="fw-bold" id="infoUjianDate"></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 border rounded bg-white h-100 hover-shadow transition-all">
                            <div class="text-muted small mb-1"><i class="bi bi-clock me-1"></i> Durasi</div>
                            <div class="fw-bold" id="infoUjianDuration"></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 border rounded bg-white h-100 hover-shadow transition-all">
                            <div class="text-muted small mb-1"><i class="bi bi-people me-1"></i> Peserta</div>
                            <div class="fw-bold" id="infoUjianParticipants"></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 border rounded bg-white h-100 hover-shadow transition-all">
                            <div class="text-muted small mb-1"><i class="bi bi-bar-chart me-1"></i> Rata-rata Nilai</div>
                            <div class="fw-bold text-primary fs-5" id="infoUjianAvg"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-start">
                    <h6 class="fw-bold mb-3 border-bottom pb-2"><i class="bi bi-trophy text-warning me-2"></i>Peraih Nilai Tertinggi</h6>
                    <div class="list-group list-group-flush" id="infoUjianTopScorers">
                        <!-- Populated by JS -->
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-top-0 justify-content-center">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg h-100">
            <div class="modal-header bg-dark text-white border-bottom-0">
                <h5 class="modal-title" id="previewTitle"><i class="bi bi-eye me-2"></i>Preview Dokumen</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 bg-secondary d-flex justify-content-center align-items-center position-relative" style="min-height: 500px; overflow: auto;">
                <!-- Placeholder for document preview -->
                <div class="bg-white shadow-lg p-5 text-center my-5" style="width: 210mm; min-height: 297mm; transform-origin: top center;">
                    <div class="mb-5 text-start border-bottom pb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="fw-bold text-primary m-0">SIAKAD</h1>
                            <div class="text-end text-muted small">
                                <p class="m-0">Jl. Pendidikan No. 123</p>
                                <p class="m-0">Jakarta, Indonesia</p>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <h2 class="fw-bold mb-4 ls-2" id="previewDocType">SERTIFIKAT</h2>
                    <p class="lead text-muted fst-italic">No: SK/2024/XII/001</p>
                    <br>
                    <p class="lead">Diberikan kepada:</p>
                    <h1 class="display-4 fw-bold text-dark my-4 font-monospace" id="previewStudentName">Nama Siswa</h1>
                    <p class="lead px-5">Atas keberhasilannya menyelesaikan program pendidikan dan memenuhi seluruh persyaratan akademik yang berlaku.</p>
                    <br><br><br><br>
                    <div class="row mt-5">
                        <div class="col-6 offset-6">
                            <p>Jakarta, <span id="previewDate"></span></p>
                            <br><br><br>
                            <p class="fw-bold border-top border-dark d-inline-block pt-2 px-5">Direktur Akademik</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Modal Animations */
    .slide-up .modal-dialog {
        transform: translate(0, 50px);
        transition: transform 0.3s ease-out;
    }
    .slide-up.show .modal-dialog {
        transform: none;
    }
    .scale-in .modal-dialog {
        transform: scale(0.8);
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .scale-in.show .modal-dialog {
        transform: none;
    }
    .ls-2 {
        letter-spacing: 5px;
    }
    
    .avatar-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .hover-shadow:hover {
        transform: translateY(-3px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.1)!important;
    }
    .transition-all {
        transition: all 0.2s ease;
    }
    hr.dashed {
        border-top: 1px dashed #dee2e6;
        opacity: 1;
    }
    .extra-small {
        font-size: 0.75rem;
    }
</style>

<script>
    // Inject PHP Data to JS
    const archivedClasses = <?= json_encode($archived_classes) ?>;
    const archivedExams = <?= json_encode($archived_exams) ?>;

    function openDetailModal(id) {
        const data = archivedClasses.find(c => c.id === id);
        if(!data) return;

        // Populate Ringkasan Tab
        document.getElementById('detailKelasTitle').textContent = 'Detail: ' + data.program;
        document.getElementById('detailKelasCode').textContent = data.code;
        document.getElementById('detailKelasDesc').textContent = data.description || 'Tidak ada deskripsi.';
        document.getElementById('detailKelasEndDate').textContent = new Date(data.end_date).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        document.getElementById('detailKelasGraduates').textContent = data.graduates + '/' + data.total + ' (' + Math.round((data.graduates/data.total)*100) + '%)';
        document.getElementById('detailKelasGraduatesProgress').style.width = (data.graduates/data.total)*100 + '%';

        // Populate Tutor Info
        document.getElementById('detailKelasTutor').textContent = data.tutor;
        document.getElementById('detailKelasTutorEmail').textContent = data.tutor_email || '-';
        document.getElementById('detailKelasTutorPhone').textContent = data.tutor_phone || '-';

        // Populate Student List Tab
        const studentList = document.getElementById('detailKelasStudentList');
        studentList.innerHTML = '';
        if(data.students && data.students.length > 0) {
            data.students.forEach(student => {
                const badgeClass = student.status === 'Lulus' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger';
                const row = `
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-light border text-secondary me-2 small">
                                    ${student.name.substring(0,2).toUpperCase()}
                                </div>
                                <span class="fw-medium">${student.name}</span>
                            </div>
                        </td>
                        <td class="text-center fw-bold">${student.score}</td>
                        <td class="text-center">
                            <span class="badge ${badgeClass} border border-opacity-10">${student.status}</span>
                        </td>
                    </tr>
                `;
                studentList.innerHTML += row;
            });
        } else {
            studentList.innerHTML = '<tr><td colspan="3" class="text-center text-muted py-4">Tidak ada data siswa.</td></tr>';
        }
        
        var myModal = new bootstrap.Modal(document.getElementById('detailKelasModal'));
        myModal.show();
    }

    function openInfoModal(id) {
        const data = archivedExams.find(e => e.id === id);
        if(!data) return;

        document.getElementById('infoUjianName').textContent = data.name;
        document.getElementById('infoUjianClass').textContent = data.class;
        document.getElementById('infoUjianDate').textContent = new Date(data.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        document.getElementById('infoUjianDuration').textContent = data.duration;
        document.getElementById('infoUjianParticipants').textContent = data.participants + ' Siswa';
        document.getElementById('infoUjianAvg').textContent = data.avg_score;
        
        // Populate Top Scorers
        const scorersList = document.getElementById('infoUjianTopScorers');
        scorersList.innerHTML = '';
        if(data.top_scorers && data.top_scorers.length > 0) {
            data.top_scorers.forEach((scorer, index) => {
                const iconColor = index === 0 ? 'text-warning' : (index === 1 ? 'text-secondary' : 'text-danger'); // Gold, Silver, Bronze(-ish)
                const item = `
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div class="d-flex align-items-center">
                            <div class="me-3 fw-bold ${iconColor}" style="width: 20px;">#${index + 1}</div>
                            <div>
                                <div class="fw-semibold">${scorer.name}</div>
                            </div>
                        </div>
                        <span class="badge bg-primary rounded-pill">${scorer.score}</span>
                    </div>
                `;
                scorersList.innerHTML += item;
            });
        } else {
            scorersList.innerHTML = '<div class="text-muted small text-center">Data nilai tidak tersedia.</div>';
        }

        var myModal = new bootstrap.Modal(document.getElementById('infoUjianModal'));
        myModal.show();
    }

    function openPreviewModal(type, studentName) {
        document.getElementById('previewDocType').textContent = type.toUpperCase();
        document.getElementById('previewStudentName').textContent = studentName;
        document.getElementById('previewDate').textContent = new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        
        var myModal = new bootstrap.Modal(document.getElementById('previewModal'));
        myModal.show();
    }

    function regenerateDoc(type, studentName) {
        // Simulasi proses generate ulang
        const btn = event.currentTarget;
        const originalContent = btn.innerHTML;
        
        // Find icon inside button
        const icon = btn.querySelector('i');
        if(icon) {
            icon.classList.remove('bi-arrow-repeat');
            icon.classList.add('spinner-border', 'spinner-border-sm');
        } else {
            btn.innerHTML = `<span class="spinner-border spinner-border-sm"></span>`;
        }
        btn.disabled = true;
        
        setTimeout(() => {
            if(icon) {
                icon.classList.remove('spinner-border', 'spinner-border-sm');
                icon.classList.add('bi-check-lg');
            } else {
                btn.innerHTML = `<i class="bi bi-check-lg"></i>`;
            }
            btn.classList.remove('btn-outline-primary');
            btn.classList.add('btn-success');
            
            // Show toast or alert
            // alert(`Dokumen ${type} untuk ${studentName} berhasil digenerate ulang!`);
            
            setTimeout(() => {
                btn.disabled = false;
                if(icon) {
                    icon.classList.remove('bi-check-lg');
                    icon.classList.add('bi-arrow-repeat');
                } else {
                    btn.innerHTML = originalContent;
                }
                btn.classList.add('btn-outline-primary');
                btn.classList.remove('btn-success');
            }, 2000);
        }, 1500);
    }

    function filterArsip() {
        const input = document.getElementById('globalSearch');
        const filter = input.value.toLowerCase();
        const items = document.querySelectorAll('.search-item');

        items.forEach(item => {
            const text = item.getAttribute('data-search');
            if (text.includes(filter)) {
                item.parentElement.style.display = '';
            } else {
                item.parentElement.style.display = 'none';
            }
        });
    }

    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
