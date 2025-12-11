<?php
require_once __DIR__ . '/../config.php';
require_login(['admin']);

$examId = $_GET['id'] ?? 1;

// Simulated Exam Data (Matching the ID from ujian.php if possible)
$examData = [
    'id' => $examId,
    'title' => 'Ujian Akhir Semester: Operator Komputer',
    'class' => 'Batch 1',
    'date' => date('d M Y'),
    'time_start' => '08:00',
    'time_end' => '10:00',
    'duration' => 120, // minutes
    'total_students' => 20,
    'submitted' => 15,
    'working' => 4,
    'not_started' => 1,
    'status' => 'ongoing' // scheduled, ongoing, completed
];

// Simulated Students Data
$students = [
    ['name' => 'Ahmad Rizki', 'status' => 'submitted', 'time_submitted' => '09:45', 'score' => 85, 'ip' => '192.168.1.10'],
    ['name' => 'Budi Santoso', 'status' => 'working', 'progress' => '80%', 'last_active' => 'Just now', 'ip' => '192.168.1.12'],
    ['name' => 'Citra Dewi', 'status' => 'submitted', 'time_submitted' => '09:30', 'score' => 92, 'ip' => '192.168.1.15'],
    ['name' => 'Dian Pratama', 'status' => 'working', 'progress' => '45%', 'last_active' => '5 mins ago', 'ip' => '192.168.1.20'],
    ['name' => 'Eko Wijaya', 'status' => 'not_started', 'reason' => 'Late', 'ip' => '-'],
    ['name' => 'Fani Rahmawati', 'status' => 'submitted', 'time_submitted' => '09:50', 'score' => 78, 'ip' => '192.168.1.22'],
];

// Fill the rest with dummy data to match total 20
for ($i = 7; $i <= 20; $i++) {
    $students[] = [
        'name' => 'Siswa ' . $i, 
        'status' => 'submitted', 
        'time_submitted' => '09:' . rand(10, 59), 
        'score' => rand(70, 95),
        'ip' => '192.168.1.' . (30 + $i)
    ];
}

$title        = 'Monitoring Ujian';
$currentPage  = 'ujian';
$roleBasePath = '/admin';
$baseUrl      = '/siakad';

ob_start();
?>

<!-- Header & Controls -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="ujian.php" class="text-decoration-none">Ujian</a></li>
                <li class="breadcrumb-item active" aria-current="page">Monitoring</li>
            </ol>
        </nav>
        <h4 class="fw-bold text-dark mb-0">
            <?= $examData['title'] ?>
            <span class="badge bg-success-subtle text-success fs-6 align-middle ms-2">LIVE</span>
        </h4>
        <p class="text-muted small mb-0 mt-1">
            <i class="bi bi-clock me-1"></i> <?= $examData['time_start'] ?> - <?= $examData['time_end'] ?> &bull; 
            <i class="bi bi-people me-1"></i> Kelas <?= $examData['class'] ?>
        </p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-danger btn-sm rounded-pill px-3">
            <i class="bi bi-stop-circle me-1"></i> Force Stop
        </button>
        <button class="btn btn-primary btn-sm rounded-pill px-3" onclick="location.reload()">
            <i class="bi bi-arrow-clockwise me-1"></i> Refresh Data
        </button>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 bg-primary bg-gradient text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="card-title mb-0 opacity-75">Total Peserta</h6>
                    <i class="bi bi-people fs-4 opacity-50"></i>
                </div>
                <h2 class="fw-bold mb-0"><?= $examData['total_students'] ?></h2>
                <small class="opacity-75">Terdaftar dalam ujian</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="card-title mb-0 text-success">Sudah Submit</h6>
                    <i class="bi bi-check-circle-fill fs-4 text-success opacity-25"></i>
                </div>
                <h2 class="fw-bold mb-0 text-success"><?= $examData['submitted'] ?></h2>
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar bg-success" style="width: <?= ($examData['submitted']/$examData['total_students'])*100 ?>%"></div>
                </div>
                <small class="text-muted mt-2 d-block"><?= number_format(($examData['submitted']/$examData['total_students'])*100, 0) ?>% Selesai</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="card-title mb-0 text-warning">Sedang Mengerjakan</h6>
                    <i class="bi bi-pencil-square fs-4 text-warning opacity-25"></i>
                </div>
                <h2 class="fw-bold mb-0 text-warning"><?= $examData['working'] ?></h2>
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar bg-warning" style="width: <?= ($examData['working']/$examData['total_students'])*100 ?>%"></div>
                </div>
                <small class="text-muted mt-2 d-block">Aktif di sistem</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="card-title mb-0 text-danger">Belum Hadir</h6>
                    <i class="bi bi-person-x fs-4 text-danger opacity-25"></i>
                </div>
                <h2 class="fw-bold mb-0 text-danger"><?= $examData['not_started'] ?></h2>
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar bg-danger" style="width: <?= ($examData['not_started']/$examData['total_students'])*100 ?>%"></div>
                </div>
                <small class="text-muted mt-2 d-block">Offline / Belum login</small>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Monitoring List -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Status Peserta Real-time</h6>
        <div class="input-group input-group-sm w-auto">
            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
            <input type="text" class="form-control bg-light border-start-0" placeholder="Cari peserta...">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4">Nama Peserta</th>
                    <th>Status</th>
                    <th>Progres / Waktu</th>
                    <th>IP Address</th>
                    <th>Nilai (Sementara)</th>
                    <th class="text-end pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar-circle bg-primary bg-opacity-10 text-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                <?= substr($student['name'], 0, 1) ?>
                            </div>
                            <span class="fw-semibold text-dark"><?= $student['name'] ?></span>
                        </div>
                    </td>
                    <td>
                        <?php if ($student['status'] == 'submitted'): ?>
                            <span class="badge bg-success-subtle text-success rounded-pill px-3">Selesai</span>
                        <?php elseif ($student['status'] == 'working'): ?>
                            <span class="badge bg-warning-subtle text-warning rounded-pill px-3">Mengerjakan</span>
                        <?php else: ?>
                            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">Belum Mulai</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($student['status'] == 'submitted'): ?>
                            <small class="text-muted"><i class="bi bi-check-all me-1"></i> Submit: <?= $student['time_submitted'] ?></small>
                        <?php elseif ($student['status'] == 'working'): ?>
                            <div class="d-flex align-items-center">
                                <div class="progress flex-grow-1 me-2" style="height: 6px; width: 80px;">
                                    <div class="progress-bar bg-warning" style="width: <?= intval($student['progress']) ?>%"></div>
                                </div>
                                <small class="text-muted"><?= $student['progress'] ?></small>
                            </div>
                        <?php else: ?>
                            <small class="text-danger fst-italic">Tidak aktif</small>
                        <?php endif; ?>
                    </td>
                    <td class="text-muted small font-monospace"><?= $student['ip'] ?></td>
                    <td>
                        <?php if (isset($student['score'])): ?>
                            <span class="fw-bold <?= $student['score'] >= 75 ? 'text-success' : 'text-danger' ?>"><?= $student['score'] ?></span>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-end pe-4">
                        <button class="btn btn-sm btn-link text-muted p-0" data-bs-toggle="tooltip" title="Log Aktivitas">
                            <i class="bi bi-clock-history"></i>
                        </button>
                        <button class="btn btn-sm btn-link text-muted p-0 ms-2" data-bs-toggle="tooltip" title="Reset Login">
                            <i class="bi bi-arrow-repeat"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white border-top py-3">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end mb-0 pagination-sm">
                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>
