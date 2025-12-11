<?php
require_once __DIR__ . '/../config.php';
require_login(['tutor']);

$user = current_user();
$title        = 'Penilaian Ujian';
$currentPage  = 'penilaian-ujian';
$roleBasePath = '/tutor';
$baseUrl      = '/siakad';

// Dummy Data: Exams
$exams = [
    [
        'id' => 'EX-003',
        'title' => 'Ujian Tengah Semester - Desain Grafis',
        'module' => 'Paket Soal C: Teori Warna & Layout',
        'class_name' => 'Desain Grafis - Batch 08',
        'date' => date('d M Y', strtotime('-2 days')),
        'time' => '10:00 - 11:30 WIB',
        'duration' => '90 Menit',
        'total_students' => 12,
        'graded' => 10,
        'status' => 'pending',
        'avg_score' => 85
    ],
    [
        'id' => 'EX-005',
        'title' => 'Kuis Logika Pemrograman',
        'module' => 'Paket Soal F: Python Dasar',
        'class_name' => 'Python Master - Batch 01',
        'date' => date('d M Y', strtotime('-5 days')),
        'time' => '13:00 - 14:00 WIB',
        'duration' => '60 Menit',
        'total_students' => 15,
        'graded' => 15,
        'status' => 'completed',
        'avg_score' => 92
    ]
];

// View Mode
$view = $_GET['view'] ?? 'list';
$examId = $_GET['id'] ?? null;
$studentId = $_GET['student_id'] ?? null;

// Get Active Exam
$activeExam = null;
if ($examId) {
    foreach ($exams as $e) {
        if ($e['id'] === $examId) {
            $activeExam = $e;
            break;
        }
    }
    if (!$activeExam) $activeExam = $exams[0]; // Fallback
}

// Dummy Students
$students = [
    ['id' => 1, 'name' => 'Andi Saputra', 'submitted_at' => '10:30', 'status' => 'graded', 'score' => 85, 'essay_needs_grading' => false, 'avatar' => 'AS'],
    ['id' => 2, 'name' => 'Budi Gunawan', 'submitted_at' => '10:35', 'status' => 'graded', 'score' => 90, 'essay_needs_grading' => false, 'avatar' => 'BG'],
    ['id' => 3, 'name' => 'Cindy Claudia', 'submitted_at' => '10:40', 'status' => 'pending', 'score' => 0, 'essay_needs_grading' => true, 'avatar' => 'CC'],
    ['id' => 4, 'name' => 'Dedi Mulyadi', 'submitted_at' => '10:42', 'status' => 'pending', 'score' => 0, 'essay_needs_grading' => true, 'avatar' => 'DM'],
    ['id' => 5, 'name' => 'Eka Pertiwi', 'submitted_at' => '10:45', 'status' => 'graded', 'score' => 88, 'essay_needs_grading' => false, 'avatar' => 'EP'],
    ['id' => 6, 'name' => 'Fajar Shodiq', 'submitted_at' => '10:48', 'status' => 'pending', 'score' => 0, 'essay_needs_grading' => true, 'avatar' => 'FS'],
];

// Dummy Questions & Answers for Grading
$gradingData = [
    [
        'no' => 1,
        'type' => 'essay',
        'question' => 'Jelaskan perbedaan antara warna primer, sekunder, dan tersier dalam roda warna!',
        'student_answer' => 'Warna primer adalah warna dasar (Merah, Kuning, Biru). Warna sekunder adalah campuran dua warna primer (Hijau, Ungu, Oranye). Warna tersier adalah campuran primer dan sekunder.',
        'max_score' => 20,
        'auto_score' => 0 // Essay needs manual grading
    ],
    [
        'no' => 2,
        'type' => 'choice',
        'question' => 'Manakah yang bukan merupakan prinsip dasar desain grafis?',
        'student_answer' => 'B. Kecepatan Render',
        'correct_answer' => 'B. Kecepatan Render',
        'max_score' => 10,
        'auto_score' => 10
    ],
    [
        'no' => 3,
        'type' => 'essay',
        'question' => 'Bagaimana penggunaan White Space dapat mempengaruhi keterbacaan desain?',
        'student_answer' => 'White space memberikan ruang istirahat bagi mata, membuat desain terlihat lebih bersih dan fokus. Jika terlalu padat, pembaca akan cepat lelah.',
        'max_score' => 20,
        'auto_score' => 0
    ],
    [
        'no' => 4,
        'type' => 'choice',
        'question' => 'Format file gambar yang mendukung transparansi adalah?',
        'student_answer' => 'A. PNG',
        'correct_answer' => 'A. PNG',
        'max_score' => 10,
        'auto_score' => 10
    ]
];

// Active Student for Grading
$activeStudent = null;
if ($view == 'grading' && $studentId) {
    foreach ($students as $s) {
        if ($s['id'] == $studentId) {
            $activeStudent = $s;
            break;
        }
    }
}

ob_start();
?>

<?php if ($view == 'list'): ?>
    <!-- LIST VIEW (UNCHANGED) -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1">Penilaian Ujian</h4>
            <p class="text-muted small mb-0">Periksa dan beri nilai hasil ujian siswa.</p>
        </div>
        <div class="input-group" style="width: 250px;">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
            <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari ujian...">
        </div>
    </div>

    <div class="row g-4">
        <?php foreach ($exams as $exam): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="bg-light rounded-circle p-3 text-primary">
                                <i class="bi bi-clipboard-check fs-4"></i>
                            </div>
                            <?php if ($exam['graded'] < $exam['total_students']): ?>
                                <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill">Perlu Penilaian</span>
                            <?php else: ?>
                                <span class="badge bg-success-subtle text-success rounded-pill">Selesai</span>
                            <?php endif; ?>
                        </div>
                        
                        <h5 class="fw-bold mb-1 text-truncate"><?= $exam['title'] ?></h5>
                        <p class="text-muted small mb-3"><?= $exam['class_name'] ?> • <?= $exam['date'] ?></p>
                        
                        <div class="d-flex justify-content-between text-center bg-light rounded-3 p-2 mb-3">
                            <div class="px-2">
                                <div class="fw-bold"><?= $exam['total_students'] ?></div>
                                <div class="extra-small text-muted">Peserta</div>
                            </div>
                            <div class="border-end"></div>
                            <div class="px-2">
                                <div class="fw-bold <?= $exam['graded'] < $exam['total_students'] ? 'text-danger' : 'text-success' ?>">
                                    <?= $exam['graded'] ?>
                                </div>
                                <div class="extra-small text-muted">Dinilai</div>
                            </div>
                            <div class="border-end"></div>
                            <div class="px-2">
                                <div class="fw-bold text-primary"><?= $exam['avg_score'] ?></div>
                                <div class="extra-small text-muted">Rata-rata</div>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <a href="?view=detail&id=<?= $exam['id'] ?>" class="btn btn-outline-primary rounded-pill">
                                <i class="bi bi-pencil-square me-2"></i>Buka Penilaian
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php elseif ($view == 'detail'): ?>
    <!-- DETAIL VIEW: LIST OF STUDENTS (REFACTORED) -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center gap-3">
            <a href="penilaian-ujian.php" class="btn btn-light rounded-circle shadow-sm"><i class="bi bi-arrow-left"></i></a>
            <div>
                <h4 class="fw-bold mb-0">Daftar Peserta Ujian</h4>
                <p class="text-muted small mb-0">Pilih siswa untuk mulai menilai.</p>
            </div>
        </div>
        <div class="dropdown">
            <button class="btn btn-success rounded-pill fw-bold dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="bi bi-download me-2"></i>Download Laporan
            </button>
            <ul class="dropdown-menu shadow-sm border-0 rounded-3">
                <li>
                    <a class="dropdown-item py-2" href="export-ujian.php?id=<?= $activeExam['id'] ?>&type=excel" target="_blank">
                        <i class="bi bi-file-earmark-spreadsheet text-success me-2"></i>Export Excel (.xls)
                    </a>
                </li>
                <li>
                    <a class="dropdown-item py-2" href="export-ujian.php?id=<?= $activeExam['id'] ?>&type=print" target="_blank">
                        <i class="bi bi-file-earmark-pdf text-danger me-2"></i>Cetak / Simpan PDF
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Exam Information Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <span class="badge bg-primary-subtle text-primary mb-2 rounded-pill"><?= $activeExam['class_name'] ?></span>
                    <h3 class="fw-bold mb-2"><?= $activeExam['title'] ?></h3>
                    <p class="text-muted mb-3"><i class="bi bi-journal-text me-2"></i><?= $activeExam['module'] ?></p>
                    
                    <div class="d-flex gap-4 text-secondary small">
                        <div><i class="bi bi-calendar3 me-1"></i> <?= $activeExam['date'] ?></div>
                        <div><i class="bi bi-clock me-1"></i> <?= $activeExam['time'] ?></div>
                        <div><i class="bi bi-hourglass-split me-1"></i> <?= $activeExam['duration'] ?></div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0 border-start-md ps-md-4">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="fw-bold fs-4"><?= $activeExam['total_students'] ?></div>
                            <div class="small text-muted">Total Peserta</div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="fw-bold fs-4 text-success"><?= $activeExam['graded'] ?></div>
                            <div class="small text-muted">Sudah Dinilai</div>
                        </div>
                        <div class="col-12">
                             <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: <?= ($activeExam['graded'] / $activeExam['total_students']) * 100 ?>%"></div>
                            </div>
                            <div class="small text-muted mt-1">Progress Penilaian</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Student List (Cards) -->
    <div class="row g-3">
        <?php foreach ($students as $student): ?>
            <div class="col-md-6 col-xl-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 hover-card transition-all">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="avatar-circle bg-light text-primary fw-bold rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <?= $student['avatar'] ?>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-0"><?= $student['name'] ?></h6>
                                <small class="text-muted">Submit: <?= $student['submitted_at'] ?></small>
                            </div>
                            <?php if ($student['essay_needs_grading']): ?>
                                <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill">Perlu Review</span>
                            <?php else: ?>
                                <span class="badge bg-success-subtle text-success rounded-pill">Selesai</span>
                            <?php endif; ?>
                        </div>

                        <div class="bg-light rounded-3 p-2 d-flex justify-content-between align-items-center mb-3">
                            <span class="small text-muted ms-2">Nilai Sementara</span>
                            <span class="fw-bold fs-5 me-2"><?= $student['score'] > 0 ? $student['score'] : '-' ?></span>
                        </div>

                        <div class="d-grid">
                            <a href="?view=grading&id=<?= $activeExam['id'] ?>&student_id=<?= $student['id'] ?>" class="btn <?= $student['essay_needs_grading'] ? 'btn-primary' : 'btn-outline-primary' ?> rounded-pill">
                                <i class="bi bi-pencil-square me-2"></i>
                                <?= $student['essay_needs_grading'] ? 'Mulai Menilai' : 'Edit Nilai' ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php elseif ($view == 'grading'): ?>
    <!-- GRADING VIEW -->
    <?php if (!$activeStudent): ?>
        <div class="alert alert-danger">Siswa tidak ditemukan.</div>
    <?php else: ?>
        <form method="post" action="?view=detail&id=<?= $activeExam['id'] ?>"> <!-- Action dummy redirect back -->
            
            <!-- Sticky Header -->
            <div class="sticky-top bg-white border-bottom shadow-sm py-3 mb-4" style="top: 0; z-index: 100;">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <a href="?view=detail&id=<?= $activeExam['id'] ?>" class="btn btn-light rounded-circle shadow-sm"><i class="bi bi-arrow-left"></i></a>
                            <div>
                                <h5 class="fw-bold mb-0">Penilaian: <?= $activeStudent['name'] ?></h5>
                                <div class="text-muted small"><?= $activeExam['title'] ?></div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="text-end d-none d-md-block">
                                <div class="small text-muted">Total Nilai</div>
                                <div class="fw-bold fs-5 text-primary">85<span class="text-muted fs-6">/100</span></div>
                            </div>
                            <button type="button" class="btn btn-primary rounded-pill fw-bold px-4" onclick="alert('Nilai berhasil disimpan!')">
                                <i class="bi bi-save me-2"></i>Simpan Penilaian
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <!-- Questions & Answers -->
                     <h6 class="fw-bold text-muted mb-3 text-uppercase small ls-1">Jawaban Siswa</h6>
                    <?php foreach ($gradingData as $index => $item): ?>
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="badge bg-light text-dark border">Soal No. <?= $item['no'] ?></span>
                                    <span class="badge bg-info-subtle text-info-emphasis">Bobot: <?= $item['max_score'] ?></span>
                                </div>
                                
                                <h5 class="fw-bold mb-3"><?= $item['question'] ?></h5>
                                
                                <div class="bg-light p-3 rounded-3 mb-3 border-start border-4 border-primary">
                                    <div class="small text-muted mb-1">Jawaban Siswa:</div>
                                    <div class="fw-medium"><?= $item['student_answer'] ?></div>
                                </div>

                                <?php if (isset($item['correct_answer'])): ?>
                                    <div class="bg-success-subtle p-3 rounded-3 mb-4 border-start border-4 border-success">
                                        <div class="small text-success-emphasis mb-1">Kunci Jawaban:</div>
                                        <div class="fw-medium text-success-emphasis"><?= $item['correct_answer'] ?></div>
                                    </div>
                                <?php endif; ?>

                                <hr class="my-4">

                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <label class="form-label text-muted small">Catatan Koreksi (Opsional)</label>
                                        <input type="text" class="form-control rounded-pill bg-light border-0" placeholder="Tulis catatan untuk siswa...">
                                    </div>
                                    <div class="col-md-4 mt-3 mt-md-0">
                                        <label class="form-label fw-bold text-primary small">Berikan Nilai</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control fw-bold text-center border-primary" 
                                                   value="<?= $item['auto_score'] > 0 ? $item['auto_score'] : '' ?>" 
                                                   max="<?= $item['max_score'] ?>" min="0">
                                            <span class="input-group-text bg-primary text-white">/ <?= $item['max_score'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="col-lg-4">
                    <!-- Summary Sidebar -->
                    <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px; z-index: 90;">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3">Ringkasan Penilaian</h6>
                            
                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="text-muted">Soal Pilihan Ganda (Otomatis)</span>
                                <span class="fw-bold">20/20</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="text-muted">Soal Essay (Manual)</span>
                                <span class="fw-bold text-warning">Belum Dinilai</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="fw-bold fs-5">Total Akhir</span>
                                <span class="fw-bold fs-4 text-primary">--</span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small text-muted">Feedback Umum</label>
                                <textarea class="form-control bg-light border-0 rounded-3" rows="4" placeholder="Berikan evaluasi umum untuk siswa ini..."></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="button" class="btn btn-success rounded-pill py-2 fw-bold" onclick="alert('Penilaian selesai dan disimpan!')">
                                    Selesai & Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <?php endif; ?>

<?php endif; ?>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>