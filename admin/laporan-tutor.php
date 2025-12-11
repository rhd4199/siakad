<?php
require_once __DIR__ . '/../config.php';
require_login(['admin']);

$user         = current_user();
$title        = 'Laporan Kinerja Tutor';
$currentPage  = 'laporan-tutor';
$roleBasePath = '/admin';
$baseUrl      = '/siakad';

// --- MOCK DATA ---

// 1. DATA HARIAN
$daily_date = date('d M Y');
$daily_reports = [
    [
        'id' => 1,
        'tutor' => 'Sandhika Galih',
        'avatar' => 'SG',
        'color' => 'primary',
        'subject' => 'Web Development (WD-01)',
        'time_start' => '08:00',
        'time_end' => '10:00',
        'duration' => '2 Jam',
        'status' => 'Hadir Tepat Waktu',
        'status_color' => 'success',
        'materi' => 'React JS Hooks Deep Dive',
        'rating_today' => 4.8,
        'students_present' => 18,
        'students_total' => 20,
        'notes' => 'Kelas berjalan lancar, siswa sangat antusias saat sesi live coding.'
    ],
    [
        'id' => 2,
        'tutor' => 'Eko Kurniawan',
        'avatar' => 'EK',
        'color' => 'success',
        'subject' => 'Digital Marketing (DM-05)',
        'time_start' => '10:00',
        'time_end' => '12:00',
        'duration' => '2 Jam',
        'status' => 'Hadir Tepat Waktu',
        'status_color' => 'success',
        'materi' => 'Facebook Ads Targeting',
        'rating_today' => 4.9,
        'students_present' => 15,
        'students_total' => 15,
        'notes' => 'Semua siswa hadir. Diskusi studi kasus budget iklan.'
    ],
    [
        'id' => 3,
        'tutor' => 'Sandhika Galih',
        'avatar' => 'SG',
        'color' => 'primary',
        'subject' => 'Web Dev Lanjut (WD-02)',
        'time_start' => '13:00',
        'time_end' => '15:00',
        'duration' => '2 Jam',
        'status' => 'Hadir Tepat Waktu',
        'status_color' => 'success',
        'materi' => 'Rest API Implementation',
        'rating_today' => 4.7,
        'students_present' => 16,
        'students_total' => 18,
        'notes' => 'Ada 2 siswa izin sakit.'
    ],
    [
        'id' => 4,
        'tutor' => 'Rio Purba',
        'avatar' => 'RP',
        'color' => 'info',
        'subject' => 'Graphic Design (GD-03)',
        'time_start' => '15:30',
        'time_end' => '17:30',
        'duration' => '2 Jam',
        'status' => 'Terlambat 15 Menit',
        'status_color' => 'warning',
        'materi' => 'Adobe Illustrator Vector',
        'rating_today' => 4.5,
        'students_present' => 10,
        'students_total' => 12,
        'notes' => 'Tutor terlambat karena kendala teknis (mati listrik).'
    ],
];

// 2. DATA BULANAN
$month_name = date('F Y');
$monthly_reports = [
    [
        'id' => 101, 'name' => 'Sandhika Galih', 'avatar_initial' => 'SG', 'color' => 'primary',
        'role' => 'Senior Tutor',
        'total_classes' => 24, 'total_hours' => 48, 'attendance_rate' => 98, 'avg_rating' => 4.85, 
        'top_skill' => 'React JS',
        'performance_trend' => 'up', // up, down, flat
        'feedback' => [
            ['user' => 'Aditya', 'text' => 'Penjelasan sangat jelas dan mudah dipahami.'],
            ['user' => 'Budi', 'text' => 'Materi Hooks sangat membantu project saya.']
        ]
    ],
    [
        'id' => 102, 'name' => 'Eko Kurniawan', 'avatar_initial' => 'EK', 'color' => 'success',
        'role' => 'Expert Tutor',
        'total_classes' => 20, 'total_hours' => 40, 'attendance_rate' => 95, 'avg_rating' => 4.90,
        'top_skill' => 'Dig. Marketing',
        'performance_trend' => 'up',
        'feedback' => [
            ['user' => 'Citra', 'text' => 'Strategi ads nya daging semua!']
        ]
    ],
    [
        'id' => 103, 'name' => 'Rio Purba', 'avatar_initial' => 'RP', 'color' => 'info',
        'role' => 'Creative Mentor',
        'total_classes' => 16, 'total_hours' => 32, 'attendance_rate' => 90, 'avg_rating' => 4.75,
        'top_skill' => 'UI/UX Design',
        'performance_trend' => 'flat',
        'feedback' => []
    ],
    [
        'id' => 104, 'name' => 'Rina Wati', 'avatar_initial' => 'RW', 'color' => 'warning',
        'role' => 'English Coach',
        'total_classes' => 12, 'total_hours' => 24, 'attendance_rate' => 100, 'avg_rating' => 5.00,
        'top_skill' => 'Speaking',
        'performance_trend' => 'up',
        'feedback' => []
    ],
];

// 3. DATA OVERALL
$overall_reports = [
    [
        'id' => 101, 'name' => 'Sandhika Galih', 'join_date' => '15 Jan 2023', 'avatar_initial' => 'SG', 'color' => 'primary',
        'total_classes_all' => 450, 'total_hours_all' => 900, 'overall_rating' => 4.8,
        'badges' => ['Top Rated', 'Most Active'], 'status' => 'Excellent',
        'level' => 5
    ],
    [
        'id' => 102, 'name' => 'Eko Kurniawan', 'join_date' => '10 Feb 2023', 'avatar_initial' => 'EK', 'color' => 'success',
        'total_classes_all' => 380, 'total_hours_all' => 760, 'overall_rating' => 4.9,
        'badges' => ['Student Favorite'], 'status' => 'Excellent',
        'level' => 4
    ],
    [
        'id' => 103, 'name' => 'Rio Purba', 'join_date' => '01 Mar 2023', 'avatar_initial' => 'RP', 'color' => 'info',
        'total_classes_all' => 300, 'total_hours_all' => 600, 'overall_rating' => 4.7,
        'badges' => [], 'status' => 'Good',
        'level' => 3
    ],
];

ob_start();
?>

<!-- Custom CSS for "Cool" Look -->
<style>
    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .card-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
    }
    .avatar-lg {
        width: 64px;
        height: 64px;
        font-size: 1.5rem;
    }
    .avatar-xl {
        width: 80px;
        height: 80px;
        font-size: 2rem;
    }
    .timeline-item {
        position: relative;
        padding-left: 2rem;
        border-left: 2px solid #e3e6f0;
        padding-bottom: 2rem;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -9px;
        top: 0;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #fff;
        border: 3px solid #4e73df;
    }
    .timeline-item:last-child {
        border-left: transparent;
    }
    .progress-thin {
        height: 6px;
        border-radius: 3px;
    }
    .glass-effect {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
    }
</style>

<!-- Header -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5">
    <div>
        <h3 class="fw-bold text-dark mb-1">📊 Laporan Kinerja Tutor</h3>
        <p class="text-muted mb-0">Monitor performa, kehadiran, dan kualitas pengajaran.</p>
    </div>
    <div class="mt-3 mt-md-0">
        <button class="btn btn-white shadow-sm me-2 rounded-pill px-3" onclick="window.print()">
            <i class="bi bi-printer me-2"></i>Cetak Laporan
        </button>
        <button class="btn btn-primary shadow-sm rounded-pill px-4">
            <i class="bi bi-download me-2"></i>Export Data
        </button>
    </div>
</div>

<!-- Navigation Pills -->
<div class="d-flex justify-content-center mb-5">
    <ul class="nav nav-pills nav-fill bg-white p-1 rounded-pill shadow-sm border" id="pills-tab" role="tablist" style="max-width: 600px; width: 100%;">
        <li class="nav-item" role="presentation">
            <button class="nav-link active rounded-pill py-2" id="pills-daily-tab" data-bs-toggle="pill" data-bs-target="#pills-daily" type="button" role="tab">
                Harian
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-pill py-2" id="pills-monthly-tab" data-bs-toggle="pill" data-bs-target="#pills-monthly" type="button" role="tab">
                Bulanan
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-pill py-2" id="pills-overall-tab" data-bs-toggle="pill" data-bs-target="#pills-overall" type="button" role="tab">
                Overall
            </button>
        </li>
    </ul>
</div>

<div class="tab-content" id="pills-tabContent">

    <!-- TAB 1: DAILY TIMELINE -->
    <div class="tab-pane fade show active" id="pills-daily" role="tabpanel">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Jadwal Hari Ini <span class="text-muted fw-normal ms-2"><?= $daily_date ?></span></h5>
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3">Total <?= count($daily_reports) ?> Sesi</span>
                </div>

                <div class="timeline-container">
                    <?php foreach ($daily_reports as $row): ?>
                    <div class="timeline-item">
                        <div class="card border-0 shadow-sm hover-lift mb-2">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-<?= $row['color'] ?> text-white me-3 shadow-sm" style="width: 48px; height: 48px; font-size: 1.1rem;">
                                            <?= $row['avatar'] ?>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-0 text-dark"><?= $row['tutor'] ?></h6>
                                            <div class="small text-muted"><?= $row['subject'] ?></div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="fw-bold text-dark fs-5"><?= $row['time_start'] ?></div>
                                        <div class="extra-small text-muted">s/d <?= $row['time_end'] ?></div>
                                    </div>
                                </div>
                                
                                <div class="bg-light rounded p-3 mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-book text-primary me-2"></i>
                                        <span class="fw-medium text-dark"><?= $row['materi'] ?></span>
                                    </div>
                                    <div class="d-flex align-items-center text-muted small">
                                        <i class="bi bi-people me-2"></i>
                                        <span><?= $row['students_present'] ?>/<?= $row['students_total'] ?> Siswa Hadir</span>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-<?= $row['status_color'] ?>-subtle text-<?= $row['status_color'] ?> rounded-pill px-3 py-2">
                                        <?= $row['status'] ?>
                                    </span>
                                    <button class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick='showDailyDetail(<?= json_encode($row) ?>)'>
                                        Lihat Detail <i class="bi bi-arrow-right ms-1"></i>
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

    <!-- TAB 2: MONTHLY CARDS -->
    <div class="tab-pane fade" id="pills-monthly" role="tabpanel">
        <div class="row g-4">
            <?php foreach ($monthly_reports as $row): ?>
            <div class="col-md-6 col-xl-4">
                <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
                    <div class="card-body p-0">
                        <div class="p-4 bg-light border-bottom">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-lg bg-white text-<?= $row['color'] ?> border border-2 border-white shadow-sm rounded-circle d-flex align-items-center justify-content-center fw-bold me-3">
                                        <?= $row['avatar_initial'] ?>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-0 text-dark"><?= $row['name'] ?></h5>
                                        <div class="small text-muted"><?= $row['role'] ?></div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column align-items-end">
                                    <div class="d-flex align-items-center text-warning mb-1">
                                        <span class="fw-bold fs-5 me-1"><?= $row['avg_rating'] ?></span>
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                    <div class="badge bg-white text-secondary border rounded-pill">
                                        <?= $row['total_hours'] ?> Jam
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="row text-center mb-4">
                                <div class="col-4 border-end">
                                    <div class="small text-muted mb-1">Kelas</div>
                                    <div class="fw-bold text-dark"><?= $row['total_classes'] ?></div>
                                </div>
                                <div class="col-4 border-end">
                                    <div class="small text-muted mb-1">Kehadiran</div>
                                    <div class="fw-bold text-<?= $row['attendance_rate'] >= 90 ? 'success' : 'warning' ?>"><?= $row['attendance_rate'] ?>%</div>
                                </div>
                                <div class="col-4">
                                    <div class="small text-muted mb-1">Skill</div>
                                    <div class="fw-bold text-primary small text-truncate"><?= $row['top_skill'] ?></div>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-outline-dark rounded-pill" onclick='showMonthlyDetail(<?= json_encode($row) ?>)'>
                                    <i class="bi bi-bar-chart-line me-2"></i>Analisis Kinerja
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- TAB 3: OVERALL LEADERBOARD -->
    <div class="tab-pane fade" id="pills-overall" role="tabpanel">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">🏆 Leaderboard Instruktur (All Time)</h6>
            </div>
            <div class="list-group list-group-flush">
                <?php foreach ($overall_reports as $index => $row): ?>
                <div class="list-group-item p-4 border-bottom">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="fw-bold text-muted fs-4" style="width: 30px;">#<?= $index + 1 ?></div>
                        </div>
                        <div class="col-auto">
                            <div class="avatar-lg bg-<?= $row['color'] ?> text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm">
                                <?= $row['avatar_initial'] ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h5 class="fw-bold text-dark mb-1"><?= $row['name'] ?></h5>
                            <div class="d-flex gap-2">
                                <?php foreach ($row['badges'] as $badge): ?>
                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill extra-small">
                                    <i class="bi bi-award me-1"></i><?= $badge ?>
                                </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="col-md-3 text-center my-3 my-md-0">
                            <div class="small text-muted text-uppercase fw-bold mb-1">Total Jam Mengajar</div>
                            <h4 class="fw-bold text-primary mb-0"><?= number_format($row['total_hours_all']) ?></h4>
                            <div class="small text-muted">Sejak <?= explode(' ', $row['join_date'])[2] ?></div>
                        </div>
                        <div class="col-md-2 text-center">
                            <div class="d-inline-flex align-items-center justify-content-center p-3 rounded bg-light">
                                <i class="bi bi-star-fill text-warning fs-5 me-2"></i>
                                <span class="fw-bold fs-4"><?= $row['overall_rating'] ?></span>
                            </div>
                        </div>
                        <div class="col text-end">
                            <button class="btn btn-light btn-sm rounded-circle shadow-sm" style="width: 40px; height: 40px;" onclick='showOverallDetail(<?= json_encode($row) ?>)'>
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</div>

<!-- MODAL DETAIL HARIAN -->
<div class="modal fade" id="modalDailyDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white border-0">
                <h6 class="modal-title fw-bold"><i class="bi bi-calendar-day me-2"></i>Detail Sesi Mengajar</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <div id="md_avatar" class="avatar-lg bg-primary text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fw-bold shadow-sm">SG</div>
                    <h5 class="fw-bold mb-0" id="md_tutor">Tutor Name</h5>
                    <p class="text-muted small" id="md_subject">Subject</p>
                </div>
                
                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <div class="p-3 bg-light rounded text-center">
                            <div class="small text-muted mb-1">Waktu</div>
                            <div class="fw-bold text-dark" id="md_time">00:00 - 00:00</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-light rounded text-center">
                            <div class="small text-muted mb-1">Rating Sesi</div>
                            <div class="fw-bold text-warning" id="md_rating">0.0 <i class="bi bi-star-fill"></i></div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="small fw-bold text-muted text-uppercase mb-2">Materi</label>
                    <div class="p-3 border rounded bg-white">
                        <i class="bi bi-journal-text text-primary me-2"></i>
                        <span id="md_materi">Materi Content</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="small fw-bold text-muted text-uppercase mb-2">Catatan Kelas</label>
                    <p class="text-muted small mb-0 fst-italic" id="md_notes">No notes.</p>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light justify-content-center">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETAIL BULANAN -->
<div class="modal fade" id="modalMonthlyDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-4 bg-light p-4 text-center border-end d-flex flex-column justify-content-center">
                        <div id="mm_avatar" class="avatar-xl bg-primary text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fw-bold shadow-sm">SG</div>
                        <h5 class="fw-bold mb-1" id="mm_name">Name</h5>
                        <div class="badge bg-dark text-white rounded-pill mb-3 mx-auto" id="mm_role">Role</div>
                        
                        <div class="mt-4 text-start px-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small text-muted">Kehadiran</span>
                                <span class="small fw-bold" id="mm_attendance">0%</span>
                            </div>
                            <div class="progress mb-3" style="height: 6px;">
                                <div class="progress-bar bg-success" id="mm_bar_att" role="progressbar" style="width: 0%"></div>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small text-muted">Kepuasan Siswa</span>
                                <span class="small fw-bold" id="mm_rating">0.0</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-warning" id="mm_bar_rate" role="progressbar" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0">Analisis Kinerja Bulan Ini</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-4">
                                <div class="border rounded p-3 text-center hover-lift">
                                    <h3 class="fw-bold text-primary mb-0" id="mm_hours">0</h3>
                                    <div class="extra-small text-muted">Jam Mengajar</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border rounded p-3 text-center hover-lift">
                                    <h3 class="fw-bold text-success mb-0" id="mm_classes">0</h3>
                                    <div class="extra-small text-muted">Total Kelas</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border rounded p-3 text-center hover-lift">
                                    <h3 class="fw-bold text-info mb-0">Active</h3>
                                    <div class="extra-small text-muted">Status</div>
                                </div>
                            </div>
                        </div>

                        <h6 class="fw-bold border-bottom pb-2 mb-3">Feedback Terbaru Siswa</h6>
                        <div id="mm_feedback_list" class="bg-light rounded p-3" style="max-height: 200px; overflow-y: auto;">
                            <!-- Feedback items injected by JS -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETAIL OVERALL -->
<div class="modal fade" id="modalOverallDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 bg-light">
                <h6 class="modal-title fw-bold"><i class="bi bi-trophy me-2"></i>Instruktur Profile</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div id="mo_avatar" class="avatar-xl bg-primary text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fw-bold shadow-sm">SG</div>
                <h4 class="fw-bold mb-1" id="mo_name">Name</h4>
                <p class="text-muted small mb-3">Member since <span id="mo_join">Date</span></p>
                
                <div class="d-flex justify-content-center gap-2 mb-4" id="mo_badges">
                    <!-- Badges injected -->
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-4">
                        <div class="p-3 bg-light rounded hover-lift">
                            <div class="fw-bold text-primary fs-5" id="mo_hours">0</div>
                            <div class="extra-small text-muted">Total Jam</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 bg-light rounded hover-lift">
                            <div class="fw-bold text-dark fs-5" id="mo_classes">0</div>
                            <div class="extra-small text-muted">Total Kelas</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 bg-light rounded hover-lift">
                            <div class="fw-bold text-warning fs-5" id="mo_rating">0.0</div>
                            <div class="extra-small text-muted">Rating</div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info border-0 d-flex align-items-center mb-0">
                    <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                    <div class="text-start">
                        <div class="fw-bold">Level <span id="mo_level">1</span> Instructor</div>
                        <div class="extra-small">Status performa saat ini: <span class="fw-bold" id="mo_status">Good</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showDailyDetail(data) {
        document.getElementById('md_tutor').textContent = data.tutor;
        document.getElementById('md_subject').textContent = data.subject;
        document.getElementById('md_time').textContent = `${data.time_start} - ${data.time_end}`;
        document.getElementById('md_rating').innerHTML = `${data.rating_today} <i class="bi bi-star-fill"></i>`;
        document.getElementById('md_materi').textContent = data.materi;
        document.getElementById('md_notes').textContent = data.notes;
        
        const av = document.getElementById('md_avatar');
        av.textContent = data.avatar;
        av.className = `avatar-lg bg-${data.color} text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fw-bold shadow-sm`;

        new bootstrap.Modal(document.getElementById('modalDailyDetail')).show();
    }

    function showMonthlyDetail(data) {
        document.getElementById('mm_name').textContent = data.name;
        document.getElementById('mm_role').textContent = data.role;
        document.getElementById('mm_attendance').textContent = data.attendance_rate + '%';
        document.getElementById('mm_rating').textContent = data.avg_rating;
        document.getElementById('mm_hours').textContent = data.total_hours;
        document.getElementById('mm_classes').textContent = data.total_classes;
        
        document.getElementById('mm_bar_att').style.width = data.attendance_rate + '%';
        document.getElementById('mm_bar_rate').style.width = (data.avg_rating / 5 * 100) + '%';

        const av = document.getElementById('mm_avatar');
        av.textContent = data.avatar_initial;
        av.className = `avatar-xl bg-${data.color} text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fw-bold shadow-sm`;

        const list = document.getElementById('mm_feedback_list');
        list.innerHTML = '';
        if (data.feedback && data.feedback.length > 0) {
            data.feedback.forEach(fb => {
                list.innerHTML += `
                    <div class="mb-3 last-mb-0">
                        <div class="d-flex align-items-center mb-1">
                            <i class="bi bi-chat-quote-fill text-muted me-2"></i>
                            <span class="fw-bold small text-dark">${fb.user}</span>
                        </div>
                        <p class="text-muted small mb-0 ps-4">"${fb.text}"</p>
                    </div>
                `;
            });
        } else {
            list.innerHTML = '<p class="text-muted small text-center my-3">Belum ada feedback bulan ini.</p>';
        }

        new bootstrap.Modal(document.getElementById('modalMonthlyDetail')).show();
    }

    function showOverallDetail(data) {
        document.getElementById('mo_name').textContent = data.name;
        document.getElementById('mo_join').textContent = data.join_date;
        document.getElementById('mo_hours').textContent = data.total_hours_all;
        document.getElementById('mo_classes').textContent = data.total_classes_all;
        document.getElementById('mo_rating').textContent = data.overall_rating;
        document.getElementById('mo_level').textContent = data.level;
        document.getElementById('mo_status').textContent = data.status;

        const av = document.getElementById('mo_avatar');
        av.textContent = data.avatar_initial;
        av.className = `avatar-xl bg-${data.color} text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fw-bold shadow-sm`;

        const badgesContainer = document.getElementById('mo_badges');
        badgesContainer.innerHTML = '';
        if (data.badges && data.badges.length > 0) {
            data.badges.forEach(badge => {
                badgesContainer.innerHTML += `
                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-3 py-2">
                        <i class="bi bi-award me-1"></i>${badge}
                    </span>
                `;
            });
        }

        new bootstrap.Modal(document.getElementById('modalOverallDetail')).show();
    }
</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>