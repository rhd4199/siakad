<?php
require_once __DIR__ . '/../config.php';
require_login(['admin']);

$user         = current_user();
$title        = 'Ujian & Evaluasi';
$currentPage  = 'ujian';
$roleBasePath = '/admin';
$baseUrl      = '/siakad';

// --- Simulated Data ---
$exams = [
    [
        'id' => 1,
        'title' => 'Ujian Akhir Semester: Operator Komputer',
        'type' => 'Final Exam',
        'program' => 'Operator Komputer',
        'class' => 'Batch 1',
        'date' => '12 Des 2025',
        'time' => '08:00 - 10:00',
        'participants' => 20,
        'status' => 'scheduled',
        'status_label' => 'Akan Datang',
        'status_color' => 'primary',
        'icon' => 'bi-pc-display'
    ],
    [
        'id' => 2,
        'title' => 'Quiz Mingguan: Social Media Strategy',
        'type' => 'Quiz',
        'program' => 'Digital Marketing',
        'class' => 'Batch 2',
        'date' => 'Hari Ini',
        'time' => '13:00 - 14:00',
        'participants' => 15,
        'status' => 'ongoing',
        'status_label' => 'Sedang Berjalan',
        'status_color' => 'success',
        'icon' => 'bi-phone'
    ],
    [
        'id' => 3,
        'title' => 'Tryout 1: Web Development',
        'type' => 'Tryout',
        'program' => 'Web Development',
        'class' => 'Batch 1',
        'date' => '10 Des 2025',
        'time' => '09:00 - 11:00',
        'participants' => 12,
        'status' => 'completed',
        'status_label' => 'Selesai',
        'status_color' => 'secondary',
        'icon' => 'bi-code-slash'
    ]
];

ob_start();
?>

<!-- Header -->
<div class="row g-3 mb-4 align-items-center">
    <div class="col-md-6">
        <h4 class="fw-bold text-dark mb-1">Ujian & Evaluasi</h4>
        <p class="text-muted small mb-0">Jadwal ujian, bank soal, dan hasil evaluasi peserta.</p>
    </div>
    <div class="col-md-6 text-md-end">
        <div class="d-inline-flex gap-2">
            <button class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalScheduleExam">
                <i class="bi bi-plus-lg me-1"></i> Jadwalkan Ujian
            </button>
        </div>
    </div>
</div>

<!-- Active/Ongoing Exam Alert -->
<?php 
$ongoing = array_filter($exams, fn($e) => $e['status'] === 'ongoing');
if (!empty($ongoing)): 
    $active = reset($ongoing);
?>
<div class="card border-0 shadow-sm bg-success text-white mb-4 overflow-hidden position-relative">
    <div class="card-body position-relative z-1 p-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-white text-success me-2 animate__animated animate__pulse animate__infinite">LIVE NOW</span>
                    <span class="opacity-75"><?= $active['time'] ?></span>
                </div>
                <h3 class="fw-bold mb-1"><?= $active['title'] ?></h3>
                <p class="mb-0 opacity-75">Kelas: <?= $active['class'] ?> &bull; Peserta: <?= $active['participants'] ?> Siswa</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <button class="btn btn-light text-success fw-bold rounded-pill px-4 shadow-sm">
                    <i class="bi bi-eye me-1"></i> Monitor Ujian
                </button>
            </div>
        </div>
    </div>
    <!-- Decorative -->
    <i class="bi bi-stopwatch position-absolute opacity-10" style="font-size: 10rem; right: -2rem; bottom: -3rem;"></i>
</div>
<?php endif; ?>

<!-- Filters -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control bg-light border-start-0" placeholder="Cari ujian...">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select bg-light border-0">
                    <option value="">Semua Status</option>
                    <option>Akan Datang</option>
                    <option>Selesai</option>
                </select>
            </div>
            <div class="col-md-5 text-md-end">
                <div class="btn-group" role="group">
                    <button class="btn btn-outline-secondary active" id="btn-view-list" onclick="switchView('list')">Daftar</button>
                    <button class="btn btn-outline-secondary" id="btn-view-calendar" onclick="switchView('calendar')">Kalender</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Exams List (Grid View) -->
<div id="view-list" class="row g-4">
    <?php foreach ($exams as $exam): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm hover-shadow transition-all position-relative overflow-hidden">
                <!-- Status Stripe -->
                <div class="position-absolute top-0 start-0 h-100 bg-<?= $exam['status_color'] ?>" style="width: 4px;"></div>
                
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="rounded-circle bg-<?= $exam['status_color'] ?> bg-opacity-10 p-3 text-<?= $exam['status_color'] ?>">
                            <i class="bi <?= $exam['icon'] ?> fs-4"></i>
                        </div>
                        <span class="badge bg-<?= $exam['status_color'] ?>-subtle text-<?= $exam['status_color'] ?> rounded-pill px-3 py-2">
                            <?= $exam['status_label'] ?>
                        </span>
                    </div>

                    <h5 class="fw-bold text-dark mb-1"><?= $exam['title'] ?></h5>
                    <div class="text-muted small mb-3"><?= $exam['type'] ?> &bull; <?= $exam['program'] ?></div>

                    <div class="d-flex align-items-center mb-3 p-2 bg-light rounded">
                        <div class="me-3 border-end pe-3">
                            <small class="text-muted d-block" style="font-size: 0.7rem;">KELAS</small>
                            <span class="fw-semibold text-dark"><?= $exam['class'] ?></span>
                        </div>
                        <div class="me-3 border-end pe-3">
                            <small class="text-muted d-block" style="font-size: 0.7rem;">TANGGAL</small>
                            <span class="fw-semibold text-dark"><?= $exam['date'] ?></span>
                        </div>
                        <div>
                            <small class="text-muted d-block" style="font-size: 0.7rem;">PESERTA</small>
                            <span class="fw-semibold text-dark"><?= $exam['participants'] ?> Siswa</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center text-muted small mb-4">
                        <i class="bi bi-clock me-2"></i> <?= $exam['time'] ?>
                        <?php if(isset($exam['room'])): ?>
                            <span class="mx-2">&bull;</span>
                            <i class="bi bi-geo-alt me-2"></i> <?= $exam['room'] ?>
                        <?php endif; ?>
                    </div>

                    <div class="d-grid gap-2">
                        <?php if ($exam['status'] === 'ongoing'): ?>
                            <a href="ujian_monitor.php?id=<?= $exam['id'] ?>" class="btn btn-success text-white fw-semibold shadow-sm">
                                <i class="bi bi-eye me-1"></i> Monitor Sekarang
                            </a>
                        <?php elseif ($exam['status'] === 'completed'): ?>
                             <a href="ujian_monitor.php?id=<?= $exam['id'] ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-bar-chart me-1"></i> Lihat Hasil
                            </a>
                        <?php else: ?>
                             <a href="ujian_monitor.php?id=<?= $exam['id'] ?>" class="btn btn-outline-primary">
                                <i class="bi bi-pencil-square me-1"></i> Detail & Edit
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    
    <!-- Add New Placeholder -->
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-2 border-dashed border-secondary-subtle bg-light d-flex align-items-center justify-content-center text-center p-4 cursor-pointer" 
             style="min-height: 280px; transition: all 0.2s;" 
             onclick="new bootstrap.Modal(document.getElementById('modalScheduleExam')).show()">
            <div>
                <div class="mb-3 text-muted opacity-50"><i class="bi bi-plus-circle fs-1"></i></div>
                <h5 class="fw-bold text-muted">Buat Ujian Baru</h5>
                <p class="small text-muted mb-0">Klik untuk menjadwalkan ujian</p>
            </div>
        </div>
    </div>
</div>

<!-- Calendar View -->
<div id="view-calendar" class="d-none">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0"><?= date('F Y') ?></h5>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-secondary"><i class="bi bi-chevron-left"></i></button>
                    <button class="btn btn-outline-secondary"><i class="bi bi-chevron-right"></i></button>
                </div>
            </div>
            
            <?php
            // Simple Calendar Logic
            $currentMonth = date('n');
            $currentYear = date('Y');
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
            $firstDayOfMonth = date('N', strtotime("$currentYear-$currentMonth-01")); // 1 (Mon) - 7 (Sun)
            
            // Map exams to dates
            $examsByDate = [];
            foreach ($exams as $ex) {
                // Parse date: "12 Des 2025" or "Hari Ini"
                // For simulation, let's just map ID 1 to 12th, ID 3 to 10th
                if ($ex['id'] == 1) $d = 12;
                elseif ($ex['id'] == 3) $d = 10;
                elseif ($ex['id'] == 2) $d = (int)date('d'); // Hari Ini
                else $d = 0;
                
                if ($d > 0) $examsByDate[$d][] = $ex;
            }
            ?>
            
            <div class="calendar-grid">
                <!-- Days Header -->
                <div class="calendar-header">Sen</div>
                <div class="calendar-header">Sel</div>
                <div class="calendar-header">Rab</div>
                <div class="calendar-header">Kam</div>
                <div class="calendar-header">Jum</div>
                <div class="calendar-header text-danger">Sab</div>
                <div class="calendar-header text-danger">Min</div>
                
                <!-- Empty slots before first day -->
                <?php for($i = 1; $i < $firstDayOfMonth; $i++): ?>
                    <div class="calendar-day empty bg-light"></div>
                <?php endfor; ?>
                
                <!-- Days -->
                <?php for($day = 1; $day <= $daysInMonth; $day++): 
                    $isToday = ($day == date('j'));
                    $hasExam = isset($examsByDate[$day]);
                ?>
                    <div class="calendar-day <?= $isToday ? 'today' : '' ?>">
                        <div class="day-number"><?= $day ?></div>
                        <?php if($hasExam): ?>
                            <div class="exam-chips">
                                <?php foreach($examsByDate[$day] as $ex): ?>
                                    <div class="exam-chip bg-<?= $ex['status_color'] ?>-subtle text-<?= $ex['status_color'] ?> text-truncate" 
                                         title="<?= $ex['title'] ?> (<?= $ex['time'] ?>)">
                                        <i class="bi <?= $ex['icon'] ?> me-1" style="font-size: 0.7rem;"></i>
                                        <?= $ex['class'] ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 1px;
        background: #dee2e6; /* Border color */
        border: 1px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
    }
    .calendar-header {
        background: #f8f9fa;
        padding: 10px;
        text-align: center;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .calendar-day {
        background: #fff;
        min-height: 120px;
        padding: 8px;
        position: relative;
    }
    .calendar-day.today {
        background-color: #f0f8ff;
    }
    .day-number {
        font-weight: 600;
        color: #6c757d;
        margin-bottom: 5px;
        font-size: 0.9rem;
    }
    .calendar-day.today .day-number {
        color: #0d6efd;
        background: rgba(13, 110, 253, 0.1);
        display: inline-block;
        padding: 2px 8px;
        border-radius: 10px;
    }
    .exam-chips {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .exam-chip {
        font-size: 0.75rem;
        padding: 4px 6px;
        border-radius: 4px;
        cursor: pointer;
        transition: transform 0.1s;
    }
    .exam-chip:hover {
        transform: scale(1.02);
        opacity: 0.9;
    }
</style>

<script>
    function switchView(view) {
        const btnList = document.getElementById('btn-view-list');
        const btnCal = document.getElementById('btn-view-calendar');
        const viewList = document.getElementById('view-list');
        const viewCal = document.getElementById('view-calendar');
        
        if (view === 'list') {
            btnList.classList.add('active');
            btnCal.classList.remove('active');
            viewList.classList.remove('d-none');
            viewCal.classList.add('d-none');
        } else {
            btnList.classList.remove('active');
            btnCal.classList.add('active');
            viewList.classList.add('d-none');
            viewCal.classList.remove('d-none');
        }
    }
</script>

<!-- Modal Schedule Exam -->
<div class="modal fade" id="modalScheduleExam" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Jadwalkan Ujian Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-info border-0 bg-info-subtle text-info-emphasis small mb-4">
                    <i class="bi bi-info-circle me-1"></i> Ujian akan muncul di jadwal kelas jika menggunakan ruangan LPK.
                </div>

                <form>
                    <div class="row g-4">
                        <div class="col-md-8 border-end">
                            <h6 class="fw-bold mb-3 text-secondary text-uppercase small">Informasi Ujian</h6>
                            
                            <div class="mb-3">
                                <label class="form-label small text-muted">Judul Ujian</label>
                                <input type="text" class="form-control form-control-lg" placeholder="Contoh: Ujian Akhir Semester Genap">
                            </div>
                            
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Tipe Ujian</label>
                                    <select class="form-select">
                                        <option>Ujian Akhir (Final)</option>
                                        <option>Ujian Tengah (Mid)</option>
                                        <option>Quiz Mingguan</option>
                                        <option>Tryout / Latihan</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Metode</label>
                                    <select class="form-select">
                                        <option value="online">Online (Remote/Mandiri)</option>
                                        <option value="onsite" selected>On-Site (Di Ruangan LPK)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small text-muted">Deskripsi / Instruksi</label>
                                <textarea class="form-control" rows="3" placeholder="Instruksi pengerjaan ujian..."></textarea>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <h6 class="fw-bold mb-3 text-secondary text-uppercase small">Jadwal & Peserta</h6>
                            
                            <div class="mb-3">
                                <label class="form-label small text-muted">Target Kelas</label>
                                <select class="form-select">
                                    <option>Pilih Kelas...</option>
                                    <option>Operator Komputer - Batch 1</option>
                                    <option>Digital Marketing - Batch 2</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small text-muted">Tanggal</label>
                                <input type="date" class="form-control">
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label class="form-label small text-muted">Mulai</label>
                                    <input type="time" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label class="form-label small text-muted">Selesai</label>
                                    <input type="time" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small text-muted">Ruangan (Opsional)</label>
                                <select class="form-select">
                                    <option value="">Tanpa Ruangan (Online)</option>
                                    <option value="1">R-01 Ruang Teori A</option>
                                    <option value="2">R-02 Lab Komputer 1</option>
                                    <option value="3">R-03 Ruang Diskusi</option>
                                </select>
                                <div class="form-text extra-small">Jika dipilih, akan membooking slot di Jadwal.</div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary rounded-pill px-5 shadow-sm">
                    <i class="bi bi-calendar-check me-2"></i> Jadwalkan Ujian
                </button>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>
