<?php
require_once __DIR__ . '/../config.php';
require_login(['tutor']);

$user = current_user();
$title        = 'Manajemen Ujian';
$currentPage  = 'ujian-aktif';
$roleBasePath = '/tutor';
$baseUrl      = '/siakad';

// Dummy Data: List of Exams
$exams = [
    [
        'id' => 'EX-001',
        'title' => 'Ujian Akhir Semester - Operator Komputer',
        'module' => 'Paket Soal A: Ms Office Lengkap',
        'class_name' => 'Operator Komputer - Batch 12',
        'date' => date('d M Y'),
        'time' => date('H:i') . ' - ' . date('H:i', strtotime('+90 minutes')),
        'duration' => 90, // minutes
        'status' => 'ongoing',
        'participants' => 15,
        'submitted' => 3,
        'bg_color' => 'success',
        'is_started' => true
    ],
    [
        'id' => 'EX-002',
        'title' => 'Kuis Harian - Digital Marketing',
        'module' => 'Paket Soal B: Social Media Ads Strategy',
        'class_name' => 'Digital Marketing - Batch 05',
        'date' => date('d M Y'),
        'time' => '14:00 - 15:00',
        'duration' => 60,
        'status' => 'ready', // Status baru: siap dimulai
        'participants' => 20,
        'submitted' => 0,
        'bg_color' => 'primary',
        'is_started' => false
    ],
    [
        'id' => 'EX-004',
        'title' => 'Ujian Susulan - Web Design',
        'module' => 'Paket Soal D: CSS Grid & Flexbox',
        'class_name' => 'Web Design - Batch 03',
        'date' => date('d M Y', strtotime('+2 days')),
        'time' => '09:00 - 10:30',
        'duration' => 90,
        'status' => 'scheduled',
        'participants' => 8,
        'submitted' => 0,
        'bg_color' => 'info',
        'is_started' => false
    ],
    [
        'id' => 'EX-003',
        'title' => 'Ujian Tengah Semester - Desain Grafis',
        'module' => 'Paket Soal C: Teori Warna & Layout',
        'class_name' => 'Desain Grafis - Batch 08',
        'date' => date('d M Y', strtotime('-2 days')),
        'time' => '13:00 - 15:00',
        'duration' => 120,
        'status' => 'finished',
        'participants' => 12,
        'submitted' => 12,
        'bg_color' => 'secondary',
        'is_started' => true
    ]
];

// Determine View Mode
$view = $_GET['view'] ?? 'list';
$activeExamId = $_GET['id'] ?? 'EX-001';

// If Monitoring View, we need dummy student data
if ($view == 'monitor') {
    // Find active exam by ID or default to the first one
    $activeExam = null;
    foreach ($exams as $exam) {
        if ($exam['id'] == $activeExamId) {
            $activeExam = $exam;
            break;
        }
    }
    if (!$activeExam) $activeExam = $exams[0];

    $students = [
        ['name' => 'Ahmad Rizki', 'status' => 'online', 'progress' => 80, 'current_module' => 'Modul 2: Ms Excel', 'last_activity' => 'Baru saja'],
        ['name' => 'Budi Santoso', 'status' => 'online', 'progress' => 60, 'current_module' => 'Modul 2: Ms Excel', 'last_activity' => '1 menit lalu'],
        ['name' => 'Citra Dewi', 'status' => 'finished', 'progress' => 100, 'current_module' => 'Selesai', 'last_activity' => '5 menit lalu'],
        ['name' => 'Dedi Pratama', 'status' => 'offline', 'progress' => 30, 'current_module' => 'Modul 1: Ms Word', 'last_activity' => '10 menit lalu'],
        ['name' => 'Eka Putri', 'status' => 'online', 'progress' => 75, 'current_module' => 'Modul 2: Ms Excel', 'last_activity' => 'Baru saja'],
        ['name' => 'Fajar Shiddiq', 'status' => 'finished', 'progress' => 100, 'current_module' => 'Selesai', 'last_activity' => '2 menit lalu'],
        ['name' => 'Gita Gutawa', 'status' => 'online', 'progress' => 50, 'current_module' => 'Istirahat', 'last_activity' => 'Baru saja'],
        ['name' => 'Hadi Sucipto', 'status' => 'online', 'progress' => 45, 'current_module' => 'Modul 1: Ms Word', 'last_activity' => '3 menit lalu'],
    ];
}

ob_start();
?>

<style>
    .card-exam {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card-exam:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .exam-date-box {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        line-height: 1;
    }
</style>

<?php if ($view == 'list'): ?>
    <!-- VIEW: LIST DASHBOARD -->
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h4 class="fw-bold mb-1">Jadwal Ujian Aktif</h4>
            <p class="text-muted small mb-0">Pantau dan kelola pelaksanaan ujian yang dijadwalkan admin.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <!-- Tombol Buat Jadwal dihapus sesuai request -->
             <div class="badge bg-info-subtle text-info border border-info-subtle px-3 py-2 rounded-pill">
                <i class="bi bi-info-circle me-1"></i> Jadwal diatur oleh Admin
             </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-success-subtle">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-success text-white rounded-circle p-3">
                            <i class="bi bi-broadcast fs-5"></i>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold text-success">1</div>
                            <div class="extra-small text-muted text-uppercase fw-bold">Berlangsung</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
             <div class="card border-0 shadow-sm rounded-4 h-100 bg-primary-subtle">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary text-white rounded-circle p-3">
                            <i class="bi bi-calendar-event fs-5"></i>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold text-primary">2</div>
                            <div class="extra-small text-muted text-uppercase fw-bold">Terjadwal</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-secondary-subtle">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-secondary text-white rounded-circle p-3">
                            <i class="bi bi-check-all fs-5"></i>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold text-secondary">1</div>
                            <div class="extra-small text-muted text-uppercase fw-bold">Selesai</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <?php foreach ($exams as $exam): ?>
            <div class="col-lg-6">
                <div class="card card-exam border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <div class="d-flex gap-3">
                                <div class="exam-date-box bg-light text-dark fw-bold border">
                                    <span class="fs-4"><?= date('d', strtotime($exam['date'])) ?></span>
                                    <span class="extra-small text-uppercase"><?= date('M', strtotime($exam['date'])) ?></span>
                                </div>
                                <div>
                                    <?php if($exam['status'] == 'ongoing'): ?>
                                        <span class="badge bg-success-subtle text-success rounded-pill mb-2"><i class="bi bi-record-circle me-1"></i> Sedang Berlangsung</span>
                                    <?php elseif($exam['status'] == 'ready'): ?>
                                        <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill mb-2"><i class="bi bi-play-circle me-1"></i> Siap Dimulai</span>
                                    <?php elseif($exam['status'] == 'scheduled'): ?>
                                        <span class="badge bg-primary-subtle text-primary rounded-pill mb-2"><i class="bi bi-calendar me-1"></i> Terjadwal</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary-subtle text-secondary rounded-pill mb-2"><i class="bi bi-check-circle me-1"></i> Selesai</span>
                                    <?php endif; ?>
                                    
                                    <h5 class="fw-bold mb-1 text-truncate" style="max-width: 280px;" title="<?= $exam['title'] ?>"><?= $exam['title'] ?></h5>
                                    <div class="text-muted small"><i class="bi bi-people me-1"></i> <?= $exam['class_name'] ?></div>
                                </div>
                            </div>
                            
                            <!-- Dropdown Menu -->
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm rounded-circle shadow-sm" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $exam['id'] ?>"><i class="bi bi-info-circle me-2"></i>Detail Ujian</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-question-circle me-2"></i>Lihat Soal</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="bg-light rounded-3 p-3 mb-3">
                            <div class="d-flex justify-content-between text-center">
                                <div>
                                    <div class="text-muted extra-small text-uppercase">Waktu</div>
                                    <div class="fw-bold small"><?= $exam['time'] ?></div>
                                </div>
                                <div class="border-end mx-2"></div>
                                <div>
                                    <div class="text-muted extra-small text-uppercase">Durasi</div>
                                    <div class="fw-bold small"><?= $exam['duration'] ?> Menit</div>
                                </div>
                                <div class="border-end mx-2"></div>
                                <div>
                                    <div class="text-muted extra-small text-uppercase">Peserta</div>
                                    <div class="fw-bold small"><?= $exam['participants'] ?> Org</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <?php if($exam['status'] == 'ongoing'): ?>
                                <a href="?view=monitor&id=<?= $exam['id'] ?>" class="btn btn-success rounded-pill fw-bold">
                                    <i class="bi bi-eye me-2"></i>Monitor Ujian
                                </a>
                            <?php elseif($exam['status'] == 'ready'): ?>
                                <button class="btn btn-primary rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalStart<?= $exam['id'] ?>">
                                    <i class="bi bi-play-fill me-2"></i>Mulai Ujian
                                </button>
                            <?php elseif($exam['status'] == 'finished'): ?>
                                <a href="penilaian-ujian.php" class="btn btn-outline-secondary rounded-pill fw-bold">
                                    <i class="bi bi-clipboard-check me-2"></i>Lihat Penilaian
                                </a>
                            <?php else: ?>
                                <button class="btn btn-light text-muted rounded-pill fw-bold" disabled>
                                    <i class="bi bi-lock me-2"></i>Belum Waktunya
                                </button>
                            <?php endif; ?>
                            
                            <button class="btn btn-link text-decoration-none text-muted btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $exam['id'] ?>">
                                Lihat Detail Lengkap
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Start Confirmation -->
            <div class="modal fade" id="modalStart<?= $exam['id'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow rounded-4">
                        <div class="modal-body p-4 text-center">
                            <div class="bg-warning-subtle text-warning rounded-circle p-3 d-inline-flex mb-3">
                                <i class="bi bi-play-fill fs-1"></i>
                            </div>
                            <h4 class="fw-bold mb-2">Mulai Ujian?</h4>
                            <p class="text-muted mb-4">
                                Anda akan memulai ujian <strong><?= $exam['title'] ?></strong>.
                                <br>Pastikan semua persiapan sudah selesai.
                            </p>
                            
                            <div class="alert alert-light border text-start small mb-4">
                                <div class="fw-bold mb-2"><i class="bi bi-info-circle me-1"></i> Yang akan terjadi:</div>
                                <ul class="mb-0 ps-3">
                                    <li>Timer mundur akan dimulai</li>
                                    <li>Peserta dapat masuk dan mengerjakan soal</li>
                                    <li>Status ujian berubah menjadi <strong>Berlangsung</strong></li>
                                </ul>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-primary rounded-pill fw-bold" onclick="startExam('<?= $exam['id'] ?>')">
                                    Ya, Mulai Ujian Sekarang
                                </button>
                                <button type="button" class="btn btn-light rounded-pill fw-bold text-muted" data-bs-dismiss="modal">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Detail for Each Exam -->
            <div class="modal fade" id="modalDetail<?= $exam['id'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow rounded-4">
                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title fw-bold">Detail Ujian</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body pt-0">
                            <div class="text-center mb-4">
                                <div class="bg-<?= $exam['bg_color'] ?>-subtle text-<?= $exam['bg_color'] ?> rounded-circle p-3 d-inline-flex mb-3">
                                    <i class="bi bi-journal-text fs-1"></i>
                                </div>
                                <h5 class="fw-bold mb-1"><?= $exam['title'] ?></h5>
                                <p class="text-muted small"><?= $exam['class_name'] ?></p>
                            </div>
                            
                            <ul class="list-group list-group-flush rounded-3 border">
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <span class="text-muted small"><i class="bi bi-book me-2"></i>Modul Ujian</span>
                                    <span class="fw-semibold text-end small" style="max-width: 50%;"><?= $exam['module'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <span class="text-muted small"><i class="bi bi-calendar-event me-2"></i>Tanggal</span>
                                    <span class="fw-semibold small"><?= $exam['date'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <span class="text-muted small"><i class="bi bi-clock me-2"></i>Waktu Pelaksanaan</span>
                                    <span class="fw-semibold small"><?= $exam['time'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <span class="text-muted small"><i class="bi bi-people me-2"></i>Total Peserta</span>
                                    <span class="fw-semibold small"><?= $exam['participants'] ?> Siswa</span>
                                </li>
                            </ul>
                            
                            <div class="alert alert-info border-0 bg-info-subtle text-info-emphasis extra-small mt-3 mb-0">
                                <i class="bi bi-info-circle me-1"></i> Jadwal dan modul ujian diatur oleh Administrator. Hubungi admin jika ada kesalahan.
                            </div>
                        </div>
                        <div class="modal-footer border-top-0 pt-0">
                            <button type="button" class="btn btn-light w-100 rounded-pill" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
    function startExam(examId) {
        // Simulasi perubahan status tanpa alert
        window.location.reload(); 
    }
    </script>

<?php elseif ($view == 'monitor'): ?>
    <!-- VIEW: MONITORING DETAIL -->
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="ujian-aktif.php" class="btn btn-light rounded-circle shadow-sm"><i class="bi bi-arrow-left"></i></a>
        <div>
            <h4 class="fw-bold mb-0">Monitoring Ujian</h4>
            <p class="text-muted small mb-0"><?= $activeExam['title'] ?></p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left: Exam Control & Info -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-body p-4 text-center">
                    <div class="avatar-lg bg-primary-subtle text-primary rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                        <i class="bi bi-clock-history fs-2"></i>
                    </div>
                    <h6 class="fw-bold mb-1 text-uppercase text-muted small ls-1">Sisa Waktu</h6>
                    <div class="display-4 fw-bold text-dark mb-2" id="timer">45:00</div>
                    <div class="progress mb-3" style="height: 6px;">
                        <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 50%"></div>
                    </div>
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-outline-warning btn-sm rounded-pill px-3"><i class="bi bi-pause-fill me-1"></i>Jeda</button>
                        <button class="btn btn-outline-primary btn-sm rounded-pill px-3"><i class="bi bi-plus-lg me-1"></i>Tambah Waktu</button>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom p-4">
                    <h6 class="fw-bold mb-0">Informasi Ujian</h6>
                </div>
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-2"><?= $activeExam['title'] ?></h5>
                    <p class="text-muted small mb-4"><?= $activeExam['class_name'] ?></p>
                    <div class="alert alert-light border small mb-4">
                        <i class="bi bi-journal-text me-1"></i> <?= $activeExam['module'] ?>
                    </div>

                    <div class="row g-3 text-center mb-4">
                        <div class="col-4">
                            <div class="p-2 bg-light rounded-3">
                                <div class="fw-bold fs-5 text-dark"><?= $activeExam['participants'] ?></div>
                                <div class="extra-small text-muted text-uppercase">Total</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 bg-success-subtle text-success rounded-3">
                                <div class="fw-bold fs-5"><?= $activeExam['submitted'] ?></div>
                                <div class="extra-small text-uppercase">Selesai</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 bg-primary-subtle text-primary rounded-3">
                                <div class="fw-bold fs-5"><?= $activeExam['participants'] - $activeExam['submitted'] ?></div>
                                <div class="extra-small text-uppercase">Aktif</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button class="btn btn-danger rounded-pill shadow-sm" onclick="confirmStopExam()">
                            <i class="bi bi-stop-circle me-2"></i>Hentikan Ujian
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Student Monitoring -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold mb-0">Status Peserta</h6>
                        <div class="text-muted small">Real-time monitoring aktivitas siswa</div>
                    </div>
                    <div class="input-group input-group-sm" style="width: 200px;">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control bg-light border-0" placeholder="Cari siswa...">
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 border-0">Siswa</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0" style="width: 30%;">Progres</th>
                                    <th class="border-0">Aktivitas</th>
                                    <th class="text-end pe-4 border-0">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($students as $student): ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark"><?= $student['name'] ?></div>
                                    </td>
                                    <td>
                                        <?php if($student['status'] == 'online'): ?>
                                            <span class="badge bg-success-subtle text-success rounded-pill border border-success-subtle px-2"><i class="bi bi-circle-fill extra-small me-1"></i> Online</span>
                                        <?php elseif($student['status'] == 'offline'): ?>
                                            <span class="badge bg-secondary-subtle text-secondary rounded-pill border border-secondary-subtle px-2"><i class="bi bi-wifi-off extra-small me-1"></i> Offline</span>
                                        <?php else: ?>
                                            <span class="badge bg-primary-subtle text-primary rounded-pill border border-primary-subtle px-2"><i class="bi bi-check-circle-fill extra-small me-1"></i> Selesai</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-between small mb-1">
                                            <span class="text-muted"><?= $student['current_module'] ?></span>
                                            <span class="fw-bold"><?= $student['progress'] ?>%</span>
                                        </div>
                                        <div class="progress" style="height: 4px;">
                                            <div class="progress-bar <?= $student['progress'] == 100 ? 'bg-success' : 'bg-primary' ?>" role="progressbar" style="width: <?= $student['progress'] ?>%"></div>
                                        </div>
                                    </td>
                                    <td class="small text-muted">
                                        <i class="bi bi-clock me-1"></i> <?= $student['last_activity'] ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="dropdown">
                                            <button class="btn btn-light btn-sm rounded-circle shadow-sm" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                                <li><a class="dropdown-item small" href="#"><i class="bi bi-chat-text me-2"></i>Kirim Pesan</a></li>
                                                <li><a class="dropdown-item small text-danger" href="#"><i class="bi bi-exclamation-triangle me-2"></i>Force Submit</a></li>
                                            </ul>
                                        </div>
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

    <script>
    let timeLeft = 45 * 60; // seconds
    const timerEl = document.getElementById('timer');

    function updateTimer() {
        const m = Math.floor(timeLeft / 60).toString().padStart(2, '0');
        const s = (timeLeft % 60).toString().padStart(2, '0');
        timerEl.innerText = `${m}:${s}`;
        if (timeLeft > 0) timeLeft--;
    }

    setInterval(updateTimer, 1000);
    updateTimer();

    function confirmStopExam() {
        if(confirm('Apakah Anda yakin ingin menghentikan ujian ini untuk semua peserta?')) {
            alert('Ujian dihentikan.');
            window.location.href = 'ujian-aktif.php';
        }
    }
    </script>
<?php endif; ?>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>
