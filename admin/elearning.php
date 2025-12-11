<?php
require_once __DIR__ . '/../config.php';
require_login(['admin']);

$user         = current_user();
$title        = 'E-Learning & Tugas';
$currentPage  = 'elearning';
$roleBasePath = '/admin';
$baseUrl      = '/siakad';

// --- Simulated Data ---
$materials = [
    [
        'id' => 1,
        'title' => 'Pengenalan Microsoft Office 2021',
        'type' => 'pdf',
        'size' => '2.5 MB',
        'class' => 'Operator Komputer',
        'uploaded' => '2 Hari yang lalu',
        'downloads' => 45,
        'icon' => 'bi-file-pdf text-danger'
    ],
    [
        'id' => 2,
        'title' => 'Tutorial Video: Rumus Excel VLOOKUP',
        'type' => 'video',
        'size' => '150 MB',
        'class' => 'Operator Komputer',
        'uploaded' => '3 Hari yang lalu',
        'downloads' => 32,
        'icon' => 'bi-file-play text-primary'
    ],
    [
        'id' => 3,
        'title' => 'Modul Digital Marketing Dasar',
        'type' => 'doc',
        'size' => '5.1 MB',
        'class' => 'Digital Marketing',
        'uploaded' => '1 Minggu yang lalu',
        'downloads' => 28,
        'icon' => 'bi-file-word text-primary'
    ]
];

$assignments = [
    [
        'id' => 101,
        'title' => 'Tugas 1: Membuat Surat Resmi',
        'class' => 'Operator Komputer - Batch 1',
        'deadline' => '15 Des 2025, 23:59',
        'submitted' => 18,
        'total' => 20,
        'status' => 'grading', // active, grading, closed
        'status_label' => 'Perlu Dinilai',
        'status_color' => 'warning'
    ],
    [
        'id' => 102,
        'title' => 'Tugas 2: Analisis Kompetitor',
        'class' => 'Digital Marketing - Batch 2',
        'deadline' => '20 Des 2025, 23:59',
        'submitted' => 5,
        'total' => 15,
        'status' => 'active',
        'status_label' => 'Sedang Berjalan',
        'status_color' => 'success'
    ],
    [
        'id' => 103,
        'title' => 'Quiz: Basic HTML & CSS',
        'class' => 'Web Development',
        'deadline' => '10 Des 2025, 12:00',
        'submitted' => 12,
        'total' => 12,
        'status' => 'closed',
        'status_label' => 'Selesai',
        'status_color' => 'secondary'
    ]
];

ob_start();
?>
<!-- Header -->
<div class="row g-3 mb-4 align-items-center">
    <div class="col-md-12">
        <h4 class="fw-bold text-dark mb-1">Monitoring E-Learning</h4>
        <p class="text-muted small mb-0">Pantau aktivitas pembelajaran, materi, dan pengumpulan tugas (Mode Pantauan).</p>
    </div>
</div>

<!-- Stats Overview -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 bg-info-subtle text-info-emphasis">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-circle bg-white p-3 me-3 text-info shadow-sm">
                    <i class="bi bi-folder2-open fs-4"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0">24</h3>
                    <div class="small opacity-75">Total Materi Modul</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 bg-warning-subtle text-warning-emphasis">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-circle bg-white p-3 me-3 text-warning shadow-sm">
                    <i class="bi bi-journal-text fs-4"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0">8</h3>
                    <div class="small opacity-75">Tugas Aktif</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 bg-success-subtle text-success-emphasis">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-circle bg-white p-3 me-3 text-success shadow-sm">
                    <i class="bi bi-check-all fs-4"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0">85%</h3>
                    <div class="small opacity-75">Rata-rata Pengumpulan</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabs for Materials vs Assignments -->
<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active rounded-pill px-4" id="pills-assignments-tab" data-bs-toggle="pill" data-bs-target="#pills-assignments" type="button" role="tab">Daftar Tugas (PR)</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link rounded-pill px-4" id="pills-materials-tab" data-bs-toggle="pill" data-bs-target="#pills-materials" type="button" role="tab">Materi Pelajaran</button>
    </li>
</ul>

<div class="tab-content" id="pills-tabContent">
    
    <!-- Assignments Tab -->
    <div class="tab-pane fade show active" id="pills-assignments" role="tabpanel">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Judul Tugas</th>
                                <th>Kelas Target</th>
                                <th>Deadline</th>
                                <th>Pengumpulan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($assignments as $task): ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded bg-<?= $task['status_color'] ?>-subtle text-<?= $task['status_color'] ?> p-2 me-3">
                                                <i class="bi bi-clipboard-data"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark"><?= $task['title'] ?></div>
                                                <div class="extra-small text-muted">ID: TUGAS-<?= $task['id'] ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-light text-dark border fw-normal"><?= $task['class'] ?></span></td>
                                    <td>
                                        <div class="small text-danger fw-semibold"><i class="bi bi-clock me-1"></i> <?= $task['deadline'] ?></div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2" style="height: 6px; width: 80px;">
                                                <div class="progress-bar bg-<?= $task['status_color'] ?>" role="progressbar" style="width: <?= ($task['submitted']/$task['total'])*100 ?>%"></div>
                                            </div>
                                            <span class="small text-muted"><?= $task['submitted'] ?>/<?= $task['total'] ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $task['status_color'] ?>-subtle text-<?= $task['status_color'] ?> rounded-pill">
                                            <?= $task['status_label'] ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-top-0 py-3">
                <div class="d-flex justify-content-center">
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Materials Tab -->
    <div class="tab-pane fade" id="pills-materials" role="tabpanel">
        <div class="row g-3">
            <?php foreach ($materials as $mat): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="fs-1 <?= $mat['icon'] ?>">
                                    <i class="bi <?= str_replace(' text-', ' bi-', $mat['icon']) ?>"></i> <!-- Hacky icon fix if needed, but standard works -->
                                </div>
                            </div>
                            <h6 class="fw-bold text-dark mb-1 line-clamp-2"><?= $mat['title'] ?></h6>
                            <div class="text-muted extra-small mb-3"><?= $mat['class'] ?> &bull; <?= $mat['size'] ?></div>
                            
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top border-light">
                                <div class="d-flex align-items-center text-muted extra-small">
                                    <i class="bi bi-cloud-arrow-down me-1"></i> <?= $mat['downloads'] ?> Unduhan
                                </div>
                                <div class="text-muted extra-small"><?= $mat['uploaded'] ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>
