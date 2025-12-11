<?php
require_once __DIR__ . '/../config.php';
require_login(['peserta']);

$user          = current_user();
$title         = 'Dashboard Peserta';
$currentPage   = 'dashboard';
$roleBasePath  = '/peserta';
$baseUrl      = '/siakad';

// --- Simulated Data for Dashboard ---

// 1. Statistik Ringkas
$stats = [
    [
        'label' => 'Total SKS/Jam',
        'value' => '144 Jam',
        'icon'  => 'bi-clock-history',
        'color' => 'primary',
        'bg'    => 'primary-subtle'
    ],
    [
        'label' => 'Kehadiran',
        'value' => '95%',
        'icon'  => 'bi-calendar-check',
        'color' => 'success',
        'bg'    => 'success-subtle'
    ],
    [
        'label' => 'Tugas Pending',
        'value' => '2 Tugas',
        'icon'  => 'bi-clipboard-data',
        'color' => 'warning',
        'bg'    => 'warning-subtle'
    ],
    [
        'label' => 'Rata-rata Nilai',
        'value' => '88.5',
        'icon'  => 'bi-graph-up-arrow',
        'color' => 'info',
        'bg'    => 'info-subtle'
    ]
];

// 2. Course Terakhir Diakses (Resume Learning)
$lastCourse = [
    'title'    => 'Digital Marketing Strategy',
    'code'     => 'DM-02',
    'module'   => 'Modul 3: SEO Fundamentals',
    'progress' => 65,
    'image'    => 'https://placehold.co/600x400/2563eb/ffffff?text=SEO+101', // Placeholder
    'next_lesson' => 'Keyword Research Techniques'
];

// 3. Jadwal Hari Ini & Besok
$schedules = [
    [
        'day' => 'Hari Ini',
        'date' => date('d M Y'),
        'items' => [
            [
                'time' => '09:00 - 11:00',
                'course' => 'Digital Marketing',
                'topic' => 'SEO On-Page Optimization',
                'room' => 'Lab Komputer 1',
                'status' => 'live' // live, upcoming, finished
            ],
            [
                'time' => '13:00 - 15:00',
                'course' => 'English for Business',
                'topic' => 'Email Correspondence',
                'room' => 'Kelas B3',
                'status' => 'upcoming'
            ]
        ]
    ],
    [
        'day' => 'Besok',
        'date' => date('d M Y', strtotime('+1 day')),
        'items' => [
            [
                'time' => '10:00 - 12:00',
                'course' => 'Desain Grafis',
                'topic' => 'Adobe Illustrator Basics',
                'room' => 'Lab Multimedia',
                'status' => 'upcoming'
            ]
        ]
    ]
];

// 4. Tugas Tenggat Terdekat
$upcomingTasks = [
    [
        'title' => 'Analisa Kompetitor SEO',
        'course' => 'Digital Marketing',
        'deadline' => 'Hari ini, 23:59',
        'type' => 'Tugas', // Tugas, Quiz
        'urgency' => 'high' // high, medium, low
    ],
    [
        'title' => 'Quiz Vocabulary',
        'course' => 'English for Business',
        'deadline' => 'Besok, 12:00',
        'type' => 'Quiz',
        'urgency' => 'medium'
    ]
];

// 5. Pengumuman Terbaru
$announcements = [
    [
        'title' => 'Libur Nasional & Cuti Bersama',
        'date' => '10 Des 2024',
        'excerpt' => 'Diberitahukan bahwa kegiatan belajar mengajar diliburkan pada tanggal...'
    ],
    [
        'title' => 'Maintenance Server E-Learning',
        'date' => '08 Des 2024',
        'excerpt' => 'Server akan mengalami downtime sementara pada hari Minggu pukul...'
    ]
];

ob_start();
?>

<style>
    .welcome-card {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        color: white;
    }
    .stat-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .timeline-item {
        position: relative;
        padding-left: 2rem;
        border-left: 2px solid #e9ecef;
        padding-bottom: 1.5rem;
    }
    .timeline-item:last-child {
        padding-bottom: 0;
        border-left-color: transparent;
    }
    .timeline-item::after {
        content: '';
        position: absolute;
        left: -0.4rem;
        top: 0.2rem;
        width: 0.8rem;
        height: 0.8rem;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #0d6efd;
    }
    .timeline-item.live::after {
        background: #dc3545; /* Red for live */
        border-color: #dc3545;
        animation: pulse 1.5s infinite;
    }
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4); }
        70% { box-shadow: 0 0 0 6px rgba(220, 53, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }
    .course-card-img {
        height: 140px;
        object-fit: cover;
    }
</style>

<!-- Welcome Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card welcome-card border-0 shadow-sm overflow-hidden position-relative">
            <!-- Decorative circle overlay -->
            <div class="position-absolute top-0 end-0 p-5 opacity-10 rounded-circle bg-white" style="margin-right: -50px; margin-top: -50px; width: 200px; height: 200px;"></div>
            
            <div class="card-body p-4 position-relative z-1">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h3 class="fw-bold mb-2">Halo, <?= htmlspecialchars($user['name']) ?>! 👋</h3>
                        <p class="mb-3 opacity-75" style="max-width: 600px;">
                            "Pendidikan adalah senjata paling mematikan di dunia, karena dengan pendidikan Anda dapat mengubah dunia." - Nelson Mandela
                        </p>
                        <div class="d-flex gap-2">
                            <a href="<?= $baseUrl . $roleBasePath ?>/kelas.php" class="btn btn-light text-primary fw-semibold shadow-sm">
                                <i class="bi bi-play-circle-fill me-2"></i>Lanjutkan Belajar
                            </a>
                            <a href="<?= $baseUrl . $roleBasePath ?>/tugas.php" class="btn btn-outline-light">
                                <i class="bi bi-list-check me-2"></i>Lihat Tugas
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 d-none d-md-block text-end">
                        <!-- Illustration placeholder or nice icon -->
                        <i class="bi bi-mortarboard-fill" style="font-size: 5rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <?php foreach ($stats as $stat): ?>
    <div class="col-6 col-md-3">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body p-3">
                <div class="d-flex align-items-center mb-2">
                    <div class="rounded-circle p-2 bg-<?= $stat['bg'] ?> text-<?= $stat['color'] ?> me-3">
                        <i class="bi <?= $stat['icon'] ?> fs-5"></i>
                    </div>
                    <div class="small text-muted fw-medium"><?= $stat['label'] ?></div>
                </div>
                <h4 class="fw-bold mb-0 text-dark"><?= $stat['value'] ?></h4>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="row g-4">
    <!-- Main Column (Left) -->
    <div class="col-lg-8">
        
        <!-- Continue Learning -->
        <div class="section-header d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Lanjutkan Belajar</h5>
            <a href="<?= $baseUrl . $roleBasePath ?>/kelas.php" class="text-decoration-none small">Semua Kelas <i class="bi bi-arrow-right"></i></a>
        </div>
        
        <div class="card border-0 shadow-sm mb-4">
            <div class="row g-0">
                <div class="col-md-4">
                    <div class="h-100 bg-light d-flex align-items-center justify-content-center text-secondary">
                        <!-- Placeholder for image if needed, or use a solid color -->
                         <div class="text-center p-4">
                            <i class="bi bi-collection-play fs-1 text-primary mb-2"></i>
                            <div class="small fw-bold text-dark"><?= $lastCourse['title'] ?></div>
                         </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">Terakhir Diakses</span>
                            <small class="text-muted"><?= $lastCourse['code'] ?></small>
                        </div>
                        <h5 class="card-title fw-bold mb-1"><?= $lastCourse['module'] ?></h5>
                        <p class="card-text text-muted small mb-3">Next: <?= $lastCourse['next_lesson'] ?></p>
                        
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="flex-grow-1">
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar" role="progressbar" style="width: <?= $lastCourse['progress'] ?>%" aria-valuenow="<?= $lastCourse['progress'] ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <span class="small fw-bold text-primary"><?= $lastCourse['progress'] ?>%</span>
                        </div>
                        <a href="<?= $baseUrl . $roleBasePath ?>/kelas-detail.php" class="btn btn-sm btn-primary mt-1">
                            Lanjutkan <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schedule -->
        <div class="section-header d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Jadwal Kuliah</h5>
            <a href="#" class="text-decoration-none small">Lihat Kalender <i class="bi bi-calendar3"></i></a>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <?php foreach ($schedules as $dayIndex => $day): ?>
                    <h6 class="fw-bold text-uppercase text-muted extra-small mb-3 <?= $dayIndex > 0 ? 'mt-4' : '' ?>">
                        <?= $day['day'] ?> <span class="fw-normal text-secondary">• <?= $day['date'] ?></span>
                    </h6>
                    <div class="timeline ps-2">
                        <?php foreach ($day['items'] as $item): ?>
                        <div class="timeline-item <?= $item['status'] == 'live' ? 'live' : '' ?>">
                            <div class="row">
                                <div class="col-md-3 mb-1 mb-md-0">
                                    <div class="fw-bold text-dark small"><?= $item['time'] ?></div>
                                    <?php if ($item['status'] == 'live'): ?>
                                        <span class="badge bg-danger animate-pulse border border-danger-subtle extra-small">SEDANG BERLANGSUNG</span>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-9">
                                    <div class="card bg-light border-0">
                                        <div class="card-body p-3">
                                            <h6 class="fw-bold mb-1 text-primary"><?= $item['course'] ?></h6>
                                            <div class="text-dark small mb-2"><?= $item['topic'] ?></div>
                                            <div class="d-flex align-items-center text-muted extra-small gap-3">
                                                <span><i class="bi bi-geo-alt me-1"></i><?= $item['room'] ?></span>
                                                <?php if ($item['status'] == 'live'): ?>
                                                    <a href="#" class="text-decoration-none fw-bold text-danger">Masuk Kelas <i class="bi bi-box-arrow-in-right"></i></a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>

    <!-- Right Column (Sidebar) -->
    <div class="col-lg-4">
        
        <!-- Tasks -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom-0 py-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-list-task text-warning me-2"></i>Tenggat Terdekat</h6>
            </div>
            <div class="list-group list-group-flush">
                <?php foreach ($upcomingTasks as $task): ?>
                <div class="list-group-item px-3 py-3 border-light">
                    <div class="d-flex w-100 justify-content-between mb-1">
                        <span class="badge bg-<?= $task['type'] == 'Quiz' ? 'info' : 'warning' ?>-subtle text-<?= $task['type'] == 'Quiz' ? 'info' : 'warning' ?> border border-<?= $task['type'] == 'Quiz' ? 'info' : 'warning' ?>-subtle extra-small rounded-pill"><?= $task['type'] ?></span>
                        <small class="text-<?= $task['urgency'] == 'high' ? 'danger fw-bold' : 'muted' ?>">
                            <i class="bi bi-clock me-1"></i><?= $task['deadline'] ?>
                        </small>
                    </div>
                    <div class="mb-1 fw-semibold text-dark small"><?= $task['title'] ?></div>
                    <small class="text-muted d-block"><?= $task['course'] ?></small>
                    <a href="<?= $baseUrl . $roleBasePath ?>/tugas.php" class="btn btn-outline-primary btn-sm w-100 mt-2" style="font-size: 0.75rem;">Kerjakan</a>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="card-footer bg-white border-top-0 text-center py-2">
                <a href="<?= $baseUrl . $roleBasePath ?>/tugas.php" class="text-decoration-none extra-small fw-bold">Lihat Semua Tugas</a>
            </div>
        </div>

        <!-- Announcements -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 py-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-megaphone text-info me-2"></i>Pengumuman</h6>
            </div>
            <div class="list-group list-group-flush">
                <?php foreach ($announcements as $announcement): ?>
                <div class="list-group-item px-3 py-3 border-light">
                    <div class="d-flex w-100 justify-content-between mb-1">
                        <h6 class="mb-0 small fw-bold text-dark"><?= $announcement['title'] ?></h6>
                    </div>
                    <small class="text-muted d-block mb-2 extra-small"><?= $announcement['date'] ?></small>
                    <p class="mb-1 small text-secondary text-truncate"><?= $announcement['excerpt'] ?></p>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="card-footer bg-white border-top-0 text-center py-2">
                <a href="#" class="text-decoration-none extra-small fw-bold">Lihat Arsip</a>
            </div>
        </div>

    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
