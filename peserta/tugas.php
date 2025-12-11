<?php
require_once __DIR__ . '/../config.php';
require_login(['peserta']);

$user         = current_user();
$tab = $_GET['tab'] ?? 'active';
$title = ($tab === 'completed') ? 'Riwayat Ujian' : 'Tugas & Ujian';
$currentPage  = 'tugas';
$roleBasePath = '/peserta';
$baseUrl      = '/siakad';

// Simulated Data
$allExams = [
    [
        'id' => 101,
        'type' => 'ujian',
        'title' => 'Ujian Tengah Semester',
        'course' => 'Operator Komputer',
        'date' => 'Hari Ini',
        'time' => '10:00 - 12:00',
        'duration' => 90, // minutes
        'status' => 'active',
        'questions' => 50,
        'score' => null,
        'description' => 'Ujian wajib untuk kelulusan modul dasar komputer.'
    ],
    [
        'id' => 102,
        'type' => 'quiz',
        'title' => 'Quiz Harian 3',
        'course' => 'Digital Marketing',
        'date' => 'Besok',
        'time' => '09:00 - 09:30',
        'duration' => 30,
        'status' => 'upcoming',
        'questions' => 15,
        'score' => null,
        'description' => 'Evaluasi materi minggu ke-3 tentang SEO Basic.'
    ],
    [
        'id' => 103,
        'type' => 'quiz',
        'title' => 'Quiz Harian 1',
        'course' => 'Operator Komputer',
        'date' => '01 Des 2025',
        'time' => '10:00 - 10:30',
        'duration' => 30,
        'status' => 'completed',
        'questions' => 15,
        'score' => 85,
        'description' => 'Evaluasi pengenalan hardware dan software.'
    ],
    [
        'id' => 104,
        'type' => 'ujian',
        'title' => 'Ujian Harian 2',
        'course' => 'Operator Komputer',
        'date' => '05 Des 2025',
        'time' => '10:00 - 11:30',
        'duration' => 90,
        'status' => 'completed',
        'questions' => 40,
        'score' => 92,
        'description' => 'Evaluasi penggunaan Microsoft Word dan Excel.'
    ]
];

// Filter exams based on tab
$exams = array_filter($allExams, function($e) use ($tab) {
    if ($tab === 'completed') {
        return $e['status'] === 'completed';
    } else {
        return $e['status'] !== 'completed';
    }
});

// Calculate stats for header
$activeCount = count(array_filter($allExams, fn($e) => $e['status'] === 'active'));
$upcomingCount = count(array_filter($allExams, fn($e) => $e['status'] === 'upcoming'));
$avgScore = 0;
$completedExams = array_filter($allExams, fn($e) => $e['status'] === 'completed');
if (count($completedExams) > 0) {
    $totalScore = array_sum(array_column($completedExams, 'score'));
    $avgScore = round($totalScore / count($completedExams));
}

ob_start();
?>
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        --success-gradient: linear-gradient(135deg, #198754 0%, #146c43 100%);
        --warning-gradient: linear-gradient(135deg, #ffc107 0%, #ffca2c 100%);
    }
    
    .bg-gradient-primary-soft {
        background: linear-gradient(180deg, rgba(13, 110, 253, 0.05) 0%, rgba(255, 255, 255, 0) 100%);
    }

    .exam-card {
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid rgba(0,0,0,0.08);
        background: #fff;
    }
    
    .exam-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border-color: rgba(13, 110, 253, 0.3);
    }

    .status-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }

    .status-active { background-color: #dc3545; box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.2); animation: pulse 2s infinite; }
    .status-upcoming { background-color: #ffc107; }
    .status-completed { background-color: #198754; }

    @keyframes pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(220, 53, 69, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }

    .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .score-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.25rem;
        border: 4px solid #e9ecef;
    }
    
    .score-high { border-color: #198754; color: #198754; background: #d1e7dd; }
    .score-med { border-color: #ffc107; color: #856404; background: #fff3cd; }
    .score-low { border-color: #dc3545; color: #dc3545; background: #f8d7da; }

    /* Custom Tabs */
    .nav-pills-custom .nav-link {
        color: #6c757d;
        background: #f8f9fa;
        border: 1px solid transparent;
        border-radius: 50rem;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        transition: all 0.2s;
        margin-right: 0.5rem;
    }
    .nav-pills-custom .nav-link.active {
        background: #0d6efd;
        color: #fff;
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
    }
    .nav-pills-custom .nav-link:hover:not(.active) {
        background: #e9ecef;
    }

    /* Stat Cards */
    .stat-card-mini {
        background: #fff;
        border-radius: 12px;
        padding: 1rem;
        border: 1px solid rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
</style>

<!-- Header Section -->
<div class="row mb-5 align-items-end">
    <div class="col-lg-6">
        <h6 class="text-primary fw-bold text-uppercase letter-spacing-1 mb-2">
            <i class="bi bi-mortarboard-fill me-2"></i>Area Ujian
        </h6>
        <h2 class="fw-bold display-6 mb-2">Halo, <?= htmlspecialchars($user['name'] ?? 'Peserta') ?>! 👋</h2>
        <p class="text-muted mb-0 lead fs-6">
            Siap untuk menguji kemampuanmu hari ini?
        </p>
    </div>
    <div class="col-lg-6 mt-4 mt-lg-0">
        <div class="row g-3">
            <div class="col-sm-4">
                <div class="stat-card-mini shadow-sm">
                    <div class="stat-icon bg-danger-subtle text-danger">
                        <i class="bi bi-play-circle-fill"></i>
                    </div>
                    <div>
                        <div class="h5 fw-bold mb-0"><?= $activeCount ?></div>
                        <div class="small text-muted">Aktif</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="stat-card-mini shadow-sm">
                    <div class="stat-icon bg-warning-subtle text-warning">
                        <i class="bi bi-calendar-event-fill"></i>
                    </div>
                    <div>
                        <div class="h5 fw-bold mb-0"><?= $upcomingCount ?></div>
                        <div class="small text-muted">Akan Datang</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="stat-card-mini shadow-sm">
                    <div class="stat-icon bg-success-subtle text-success">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div>
                        <div class="h5 fw-bold mb-0"><?= $avgScore ?></div>
                        <div class="small text-muted">Rata-rata</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Navigation -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <ul class="nav nav-pills nav-pills-custom" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link <?= ($tab !== 'completed') ? 'active' : '' ?>" href="?tab=active">
                <i class="bi bi-lightning-charge me-1"></i> Berlangsung
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link <?= ($tab === 'completed') ? 'active' : '' ?>" href="?tab=completed">
                <i class="bi bi-clock-history me-1"></i> Riwayat
            </a>
        </li>
    </ul>
    
    <!-- Filter/Search (Visual Only) -->
    <div class="d-none d-md-block">
        <div class="input-group input-group-sm">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
            <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari ujian...">
        </div>
    </div>
</div>

<!-- Content Grid -->
<?php if (empty($exams)): ?>
    <div class="text-center py-5">
        <div class="mb-4">
            <!-- Inline SVG for Empty State -->
            <svg width="200" height="200" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="100" cy="100" r="80" fill="#F8F9FA"/>
                <path d="M100 40V160" stroke="#E9ECEF" stroke-width="2" stroke-linecap="round"/>
                <path d="M40 100H160" stroke="#E9ECEF" stroke-width="2" stroke-linecap="round"/>
                <rect x="65" y="65" width="70" height="70" rx="8" fill="#DEE2E6"/>
                <path d="M85 90H115" stroke="white" stroke-width="4" stroke-linecap="round"/>
                <path d="M85 105H115" stroke="white" stroke-width="4" stroke-linecap="round"/>
                <path d="M85 120H105" stroke="white" stroke-width="4" stroke-linecap="round"/>
            </svg>
        </div>
        <h5 class="fw-bold text-muted">Belum ada data untuk ditampilkan</h5>
        <p class="text-muted mb-0">Sepertinya Anda belum memiliki ujian di kategori ini.</p>
    </div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach ($exams as $exam): ?>
            <?php 
                $isActive = $exam['status'] === 'active';
                $isCompleted = $exam['status'] === 'completed';
                $cardBorderClass = $isActive ? 'border-danger' : ($isCompleted ? 'border-success' : 'border-warning');
                $iconClass = $exam['type'] === 'ujian' ? 'bi-laptop' : 'bi-file-text';
                $iconBg = $isActive ? 'bg-danger text-white' : ($isCompleted ? 'bg-success text-white' : 'bg-warning text-dark');
            ?>
            <div class="col-md-6 col-xl-4">
                <div class="card h-100 exam-card shadow-sm border-0 rounded-4 overflow-hidden position-relative">
                    <?php if ($isActive): ?>
                        <div class="position-absolute top-0 end-0 mt-3 me-3">
                            <span class="badge bg-danger rounded-pill px-3 py-2 shadow-sm animate__animated animate__pulse animate__infinite">
                                <i class="bi bi-broadcast me-1"></i> LIVE
                            </span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start mb-3">
                            <div class="icon-box <?= $iconBg ?> shadow-sm me-3">
                                <i class="bi <?= $iconClass ?>"></i>
                            </div>
                            <div>
                                <h6 class="text-uppercase text-muted extra-small fw-bold mb-1 letter-spacing-1">
                                    <?= $exam['course'] ?>
                                </h6>
                                <h5 class="fw-bold mb-0 text-truncate" style="max-width: 200px;" title="<?= htmlspecialchars($exam['title']) ?>">
                                    <?= htmlspecialchars($exam['title']) ?>
                                </h5>
                            </div>
                        </div>
                        
                        <p class="text-muted small mb-4 line-clamp-2" style="min-height: 40px;">
                            <?= htmlspecialchars($exam['description'] ?? 'Tidak ada deskripsi.') ?>
                        </p>

                        <div class="d-flex justify-content-between align-items-center mb-4 bg-light p-3 rounded-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-calendar4-week text-primary me-2 fs-5"></i>
                                <div>
                                    <div class="small fw-bold text-dark"><?= $exam['date'] ?></div>
                                    <div class="extra-small text-muted"><?= $exam['time'] ?></div>
                                </div>
                            </div>
                            <div class="vr mx-2"></div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-stopwatch text-primary me-2 fs-5"></i>
                                <div>
                                    <div class="small fw-bold text-dark"><?= $exam['duration'] ?> mnt</div>
                                    <div class="extra-small text-muted">Durasi</div>
                                </div>
                            </div>
                        </div>

                        <?php if ($isCompleted): ?>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <?php 
                                        $scoreClass = ($exam['score'] >= 80) ? 'score-high' : (($exam['score'] >= 60) ? 'score-med' : 'score-low');
                                    ?>
                                    <div class="score-circle <?= $scoreClass ?> me-3" style="width: 50px; height: 50px; font-size: 1.1rem;">
                                        <?= $exam['score'] ?>
                                    </div>
                                    <div>
                                        <div class="small fw-bold">Nilai Akhir</div>
                                        <div class="extra-small text-muted">Lulus</div>
                                    </div>
                                </div>
                                <button class="btn btn-outline-primary rounded-pill px-4"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#examDetailModal"
                                        data-title="<?= htmlspecialchars($exam['title']) ?>"
                                        data-course="<?= htmlspecialchars($exam['course']) ?>"
                                        data-date="<?= htmlspecialchars($exam['date']) ?>"
                                        data-score="<?= htmlspecialchars($exam['score']) ?>"
                                        data-questions="<?= htmlspecialchars($exam['questions']) ?>">
                                    Detail
                                </button>
                            </div>
                        <?php else: ?>
                            <div class="d-grid">
                                <?php if ($isActive): ?>
                                    <a href="ujian.php?id=<?= $exam['id'] ?>" class="btn btn-primary btn-lg rounded-pill shadow-sm fw-bold">
                                        Mulai Kerjakan <i class="bi bi-arrow-right-short ms-1"></i>
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-light text-muted btn-lg rounded-pill fw-bold" disabled>
                                        <i class="bi bi-lock-fill me-2"></i> Belum Dibuka
                                    </button>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Exam Detail Modal (Preserved & Enhanced) -->
<div class="modal fade" id="examDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Detail Hasil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-2">
                <div class="text-center my-4">
                    <div class="position-relative d-inline-block">
                        <svg width="120" height="120" viewBox="0 0 120 120" class="circular-progress">
                            <circle class="bg" cx="60" cy="60" r="54" fill="none" stroke="#f0f0f0" stroke-width="12"/>
                            <circle class="fg" cx="60" cy="60" r="54" fill="none" stroke="#198754" stroke-width="12" 
                                    stroke-dasharray="339.292" stroke-dashoffset="60" transform="rotate(-90 60 60)"/>
                        </svg>
                        <div class="position-absolute top-50 start-50 translate-middle text-center">
                            <div class="h2 fw-bold mb-0" id="modalExamScore">0</div>
                            <div class="extra-small text-muted fw-bold">SKOR</div>
                        </div>
                    </div>
                    <h5 class="fw-bold mt-3 mb-1" id="modalExamTitle">Judul Ujian</h5>
                    <div class="badge bg-light text-dark border" id="modalExamCourse">Mata Kuliah</div>
                </div>

                <div class="row g-3">
                    <div class="col-6">
                        <div class="p-3 bg-light rounded-3 text-center">
                            <div class="text-muted extra-small fw-bold text-uppercase">Tanggal</div>
                            <div class="fw-bold text-dark" id="modalExamDate">-</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-light rounded-3 text-center">
                            <div class="text-muted extra-small fw-bold text-uppercase">Soal</div>
                            <div class="fw-bold text-dark" id="modalExamQuestions">-</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                <button type="button" class="btn btn-primary w-100 rounded-pill fw-bold" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var examDetailModal = document.getElementById('examDetailModal');
        examDetailModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            
            var title = button.getAttribute('data-title');
            var course = button.getAttribute('data-course');
            var date = button.getAttribute('data-date');
            var score = button.getAttribute('data-score');
            var questions = button.getAttribute('data-questions');
            
            examDetailModal.querySelector('#modalExamTitle').textContent = title;
            examDetailModal.querySelector('#modalExamCourse').textContent = course;
            examDetailModal.querySelector('#modalExamDate').textContent = date;
            examDetailModal.querySelector('#modalExamScore').textContent = score;
            examDetailModal.querySelector('#modalExamQuestions').textContent = questions + ' Butir';
            
            // Update circular progress (simple simulation)
            const circle = examDetailModal.querySelector('.circular-progress .fg');
            const radius = 54;
            const circumference = 2 * Math.PI * radius;
            const offset = circumference - (score / 100) * circumference;
            circle.style.strokeDashoffset = offset;
            
            // Color based on score
            if(score < 60) circle.style.stroke = '#dc3545';
            else if(score < 80) circle.style.stroke = '#ffc107';
            else circle.style.stroke = '#198754';
        });
    });
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
