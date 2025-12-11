<?php
require_once __DIR__ . '/../config.php';
require_login(['peserta']);

$user         = current_user();
$title        = 'Tugas & Ujian';
$currentPage  = 'tugas';
$roleBasePath = '/peserta';
$baseUrl      = '/siakad';

// Simulated Data
$exams = [
    [
        'type' => 'ujian',
        'title' => 'Ujian Tengah Semester',
        'course' => 'Operator Komputer',
        'date' => 'Hari Ini',
        'time' => '10:00 - 12:00',
        'duration' => '90 Menit',
        'status' => 'active',
        'questions' => 50
    ],
    [
        'type' => 'quiz',
        'title' => 'Quiz Harian 3',
        'course' => 'Digital Marketing',
        'date' => 'Besok',
        'time' => '09:00 - 09:30',
        'duration' => '30 Menit',
        'status' => 'upcoming',
        'questions' => 15
    ]
];

$assignments = [
    [
        'title' => 'Analisis SEO Website',
        'course' => 'Digital Marketing',
        'deadline' => '15 Des 2024, 23:59',
        'status' => 'pending',
        'desc' => 'Buat analisa SEO on-page untuk website dummy yang telah disediakan.'
    ],
    [
        'title' => 'Laporan Praktik Excel',
        'course' => 'Operator Komputer',
        'deadline' => '12 Des 2024, 12:00',
        'status' => 'submitted',
        'desc' => 'Upload file Excel hasil latihan VLOOKUP dan Pivot Table.'
    ]
];

ob_start();
?>
<style>
    .nav-pills .nav-link {
        color: #6c757d;
        font-weight: 500;
        padding: 0.75rem 1.25rem;
    }
    .nav-pills .nav-link.active {
        background-color: #0d6efd;
        color: white;
        box-shadow: 0 0.125rem 0.25rem rgba(13, 110, 253, 0.25);
    }
    .border-dashed {
        border-style: dashed !important;
    }
</style>

<div class="row mb-4 align-items-center">
    <div class="col-lg-8">
        <h4 class="fw-bold mb-1">Tugas & Ujian</h4>
        <p class="text-muted small mb-0">
            Kelola semua tagihan tugas dan jadwal ujian Anda di sini.
        </p>
    </div>
</div>

<!-- Tabs -->
<ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active rounded-pill" id="pills-ujian-tab" data-bs-toggle="pill" data-bs-target="#pills-ujian" type="button" role="tab" aria-controls="pills-ujian" aria-selected="true">
            <i class="bi bi-stopwatch me-2"></i>Ujian & Quiz
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link rounded-pill" id="pills-tugas-tab" data-bs-toggle="pill" data-bs-target="#pills-tugas" type="button" role="tab" aria-controls="pills-tugas" aria-selected="false">
            <i class="bi bi-file-earmark-text me-2"></i>Tugas & PR
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link rounded-pill" id="pills-history-tab" data-bs-toggle="pill" data-bs-target="#pills-history" type="button" role="tab" aria-controls="pills-history" aria-selected="false">
            <i class="bi bi-clock-history me-2"></i>Riwayat
        </button>
    </li>
</ul>

<div class="tab-content" id="pills-tabContent">
    
    <!-- Tab Ujian -->
    <div class="tab-pane fade show active" id="pills-ujian" role="tabpanel" aria-labelledby="pills-ujian-tab">
        <div class="row g-4">
            <div class="col-lg-8">
                <?php foreach ($exams as $exam): ?>
                <div class="card border-0 shadow-sm mb-3 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-md-1 bg-<?= $exam['status'] == 'active' ? 'danger' : 'light' ?> d-flex align-items-center justify-content-center" style="min-height: 80px;">
                                <i class="bi bi-<?= $exam['type'] == 'ujian' ? 'laptop' : 'lightning' ?> fs-3 text-<?= $exam['status'] == 'active' ? 'white' : 'secondary' ?>"></i>
                            </div>
                            <div class="col-md-11 p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <span class="badge bg-<?= $exam['status'] == 'active' ? 'danger' : 'warning' ?>-subtle text-<?= $exam['status'] == 'active' ? 'danger' : 'warning' ?>">
                                                <?= $exam['status'] == 'active' ? 'Sedang Berlangsung' : 'Akan Datang' ?>
                                            </span>
                                            <span class="small text-muted fw-medium"><?= $exam['course'] ?></span>
                                        </div>
                                        <h5 class="fw-bold mb-1"><?= $exam['title'] ?></h5>
                                    </div>
                                    <div class="text-end d-none d-sm-block">
                                        <div class="fs-5 fw-bold text-dark"><?= $exam['date'] ?></div>
                                        <div class="small text-muted"><?= $exam['time'] ?> WIB</div>
                                    </div>
                                </div>
                                
                                <div class="d-flex flex-wrap gap-3 text-muted extra-small mb-3">
                                    <span><i class="bi bi-clock me-1"></i> Durasi: <strong><?= $exam['duration'] ?></strong></span>
                                    <span><i class="bi bi-list-check me-1"></i> Soal: <strong><?= $exam['questions'] ?> Butir</strong></span>
                                    <span><i class="bi bi-shield-check me-1"></i> Mode: <strong>Full Screen</strong></span>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <?php if ($exam['status'] == 'active'): ?>
                                        <button class="btn btn-danger btn-sm px-4">
                                            <i class="bi bi-play-circle me-1"></i> Mulai Ujian Sekarang
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm px-4" disabled>
                                            <i class="bi bi-lock me-1"></i> Belum Dibuka
                                        </button>
                                        <button class="btn btn-outline-primary btn-sm px-3">
                                            <i class="bi bi-bell me-1"></i> Ingatkan Saya
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <div class="alert alert-info border-0 d-flex align-items-center gap-3">
                    <i class="bi bi-info-circle-fill fs-4"></i>
                    <div>
                        <div class="fw-bold">Tips Mengerjakan Ujian</div>
                        <div class="small">Pastikan koneksi internet stabil. Jangan menutup browser selama ujian berlangsung.</div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm bg-primary text-white">
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <i class="bi bi-trophy-fill fs-1 text-white-50"></i>
                        </div>
                        <h5 class="fw-bold">Leaderboard Tryout</h5>
                        <p class="small text-white-50 mb-3">Lihat peringkatmu di antara peserta lain.</p>
                        <button class="btn btn-light text-primary w-100 fw-medium">
                            Lihat Peringkat
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Tugas -->
    <div class="tab-pane fade" id="pills-tugas" role="tabpanel" aria-labelledby="pills-tugas-tab">
        <div class="row g-4">
            <?php foreach ($assignments as $task): ?>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-primary" style="width: 48px; height: 48px;">
                                <i class="bi bi-file-earmark-text fs-4"></i>
                            </div>
                            <?php if ($task['status'] == 'submitted'): ?>
                                <span class="badge bg-success-subtle text-success h-auto align-self-start"><i class="bi bi-check-lg me-1"></i> Dikumpulkan</span>
                            <?php else: ?>
                                <span class="badge bg-warning-subtle text-warning h-auto align-self-start"><i class="bi bi-hourglass-split me-1"></i> Belum Dikumpulkan</span>
                            <?php endif; ?>
                        </div>
                        
                        <h6 class="text-muted extra-small text-uppercase fw-bold mb-1"><?= $task['course'] ?></h6>
                        <h5 class="fw-bold mb-2"><?= $task['title'] ?></h5>
                        <p class="text-muted small mb-4">
                            <?= $task['desc'] ?>
                        </p>
                        
                        <div class="mt-auto">
                            <div class="d-flex align-items-center gap-2 text-danger extra-small mb-3">
                                <i class="bi bi-calendar-x"></i> Deadline: <strong><?= $task['deadline'] ?></strong>
                            </div>
                            
                            <?php if ($task['status'] == 'submitted'): ?>
                                <button class="btn btn-outline-secondary btn-sm w-100" disabled>
                                    Lihat Submission
                                </button>
                            <?php else: ?>
                                <div class="border border-dashed border-2 rounded p-3 text-center bg-light cursor-pointer hover-bg-light">
                                    <i class="bi bi-cloud-upload fs-4 text-muted mb-2 d-block"></i>
                                    <span class="small fw-bold text-primary">Upload File Tugas</span>
                                    <div class="extra-small text-muted">Max 5MB (PDF, DOCX)</div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Tab History -->
    <div class="tab-pane fade" id="pills-history" role="tabpanel" aria-labelledby="pills-history-tab">
        <div class="text-center py-5 text-muted">
            <i class="bi bi-clock-history fs-1 mb-3 d-block opacity-25"></i>
            <h6>Belum ada riwayat pengerjaan.</h6>
            <p class="small">Ujian dan tugas yang sudah dinilai akan muncul di sini.</p>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
